<?php

namespace App\Services;

use App\Enums\PaymentStatus;
use App\Models\Membership;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

/**
 * Centralized leaderboard aggregation and ranking (Feature 14).
 *
 * Verified contributions are derived exclusively from payment records. Only
 * payments matching Payment::valid() (paid + partial) count — void and waived
 * payments are excluded. Aggregation happens in a single SQL query (a joined
 * aggregate subquery), never by loading memberships and looping in PHP.
 *
 * Competition ranking is used: members with equal totals share the same rank
 * and the next rank skips ahead (1, 2, 2, 4). Ranks are computed with a
 * RANK() window function inside a derived table so pagination stays valid on
 * both MySQL (production) and SQLite (the test database).
 */
class LeaderboardService
{
    /**
     * Public leaderboard — active, publicly listed members who opted into
     * leaderboard display and hold a positive verified contribution.
     *
     * @param  array<string, mixed>  $filters
     */
    public function publicPaginate(array $filters = [], int $perPage = 10): LengthAwarePaginator
    {
        return $this->finalizePaginator($this->publicQuery($filters), $perPage);
    }

    /**
     * Administrative leaderboard — every membership, including hidden,
     * private, and zero-contribution records.
     *
     * @param  array<string, mixed>  $filters
     */
    public function adminPaginate(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        return $this->finalizePaginator($this->adminQuery($filters), $perPage);
    }

    /**
     * Top contributors for the homepage / podium, respecting the public
     * eligibility rules.
     *
     * @param  array<string, mixed>  $filters
     * @return Collection<int, object>
     */
    public function topContributors(int $limit = 3, array $filters = []): Collection
    {
        return $this->publicQuery($filters)
            ->limit($limit)
            ->get()
            ->each(fn ($row) => $this->hydrateRow($row));
    }

    /**
     * Competition rank (1-based) of a membership within the public eligible
     * leaderboard, or null when it cannot be ranked (zero contribution).
     */
    public function rankFor(int $membershipId, float $total): ?int
    {
        if ($total <= 0) {
            return null;
        }

        // Competition ranking: one more than the number of eligible members
        // holding a strictly greater verified contribution total.
        $statuses = PaymentStatus::collectibleValues();
        $placeholders = implode(',', array_fill(0, count($statuses), '?'));

        $higher = DB::table('memberships as m')
            ->where('m.status', Membership::STATUS_ACTIVE)
            ->where('m.is_public', true)
            ->where('m.show_on_leaderboard', true)
            ->whereRaw(
                "(SELECT COALESCE(SUM(p.amount), 0) FROM payments p WHERE p.membership_id = m.id AND p.status IN ({$placeholders})) > ?",
                [...$statuses, $total]
            )
            ->count();

        return $higher + 1;
    }

    /**
     * Distinct alumni attribute values (batch, graduation year) among
     * publicly leaderboard-eligible members — used to build filter dropdowns
     * without exposing ineligible members.
     *
     * @return Collection<int, string|int>
     */
    public function eligibleAlumniValues(string $column): Collection
    {
        return DB::table('memberships as m')
            ->where('m.status', Membership::STATUS_ACTIVE)
            ->where('m.is_public', true)
            ->where('m.show_on_leaderboard', true)
            ->join('alumni as a', 'a.id', '=', 'm.alumni_id')
            ->whereNotNull("a.{$column}")
            ->where("a.{$column}", '!=', '')
            ->distinct()
            ->orderBy($column)
            ->pluck("a.{$column}");
    }

    /**
     * Publicly visible leaderboard rows: active memberships that are both
     * publicly listed and opted into leaderboard display. User-supplied
     * filters and the positive-total constraint are applied OUTSIDE the
     * derived table so filtering never changes a member's global rank.
     */
    private function publicQuery(array $filters = []): QueryBuilder
    {
        return $this->applyFilters(
            DB::query()->fromSub($this->rankedBase(publicOnly: true), 'lb'),
            $filters
        )
            ->where('lb.verified_total', '>', 0)
            ->orderByDesc('lb.verified_total')
            ->orderBy('lb.alumni_name');
    }

    /**
     * Administrative rows: every membership with its aggregated verified
     * contribution and competition rank, including hidden/private members.
     */
    private function adminQuery(array $filters = []): QueryBuilder
    {
        return $this->applyFilters(
            DB::query()->fromSub($this->rankedBase(), 'lb'),
            $filters,
            admin: true
        )
            ->orderByDesc('lb.verified_total')
            ->orderBy('lb.alumni_name');
    }

    /**
     * The ranked base query. Verified contributions aggregate ONLY valid
     * payments (Payment::valid() semantics: paid + partial). Future verified
     * contribution sources can be unioned into this one subquery later.
     *
     * When $publicOnly is true the eligibility rules (active, public profile,
     * leaderboard opt-in) are applied INSIDE the derived table so RANK() is
     * computed among publicly visible members only. This keeps the public
     * leaderboard self-contained — a hidden member's larger total can never
     * shift (or leak through) a visible member's rank.
     */
    private function rankedBase(bool $publicOnly = false): QueryBuilder
    {
        $aggregate = DB::table('payments')
            ->whereIn('status', PaymentStatus::collectibleValues())
            ->selectRaw('membership_id, SUM(amount) as verified_total, COUNT(*) as valid_payment_count')
            ->groupBy('membership_id');

        $base = DB::table('memberships as m')
            ->join('alumni as a', 'a.id', '=', 'm.alumni_id')
            ->leftJoin('membership_types as t', 't.id', '=', 'm.membership_type_id')
            ->leftJoin('membership_tiers as tier', 'tier.id', '=', 'm.membership_tier_id')
            ->leftJoinSub($aggregate, 'agg', 'agg.membership_id', '=', 'm.id');

        if ($publicOnly) {
            $base->where('m.status', Membership::STATUS_ACTIVE)
                ->where('m.is_public', true)
                ->where('m.show_on_leaderboard', true);
        }

        return $base->selectRaw(implode(', ', [
            'm.id as membership_id',
            'm.membership_number',
            'm.status',
            'm.is_public',
            'm.show_on_leaderboard',
            'm.alumni_id',
            'a.full_name as alumni_name',
            'a.slug as alumni_slug',
            'a.student_id',
            'a.profile_photo',
            'a.batch',
            'a.graduation_year',
            't.slug as type_slug',
            't.name as type_name',
            'tier.slug as tier_slug',
            'tier.name as tier_name',
            'tier.badge_label as tier_badge_label',
        ]))
            ->selectRaw('COALESCE(agg.verified_total, 0) as verified_total, COALESCE(agg.valid_payment_count, 0) as valid_payment_count')
            ->selectRaw('RANK() OVER (ORDER BY COALESCE(agg.verified_total, 0) DESC) as leaderboard_rank');
    }

    /**
     * Apply user-facing filters on the outer query (never affect ranks).
     *
     * Membership-number search is admin-only — the public page intentionally
     * searches only by alumni name and student ID.
     *
     * @param  array<string, mixed>  $filters
     */
    private function applyFilters(QueryBuilder $query, array $filters, bool $admin = false): QueryBuilder
    {
        $search = trim((string) ($filters['q'] ?? ''));

        if ($search !== '') {
            // Escape LIKE wildcards to prevent unintended pattern matching.
            $safeSearch = str_replace(['%', '_'], ['\%', '\_'], $search);

            $query->where(function (QueryBuilder $q) use ($safeSearch, $admin) {
                $q->where('lb.alumni_name', 'like', "%{$safeSearch}%")
                    ->orWhere('lb.student_id', 'like', "%{$safeSearch}%");

                if ($admin) {
                    $q->orWhere('lb.membership_number', 'like', "%{$safeSearch}%");
                }
            });
        }

        foreach (['type' => 'type_slug', 'tier' => 'tier_slug'] as $key => $column) {
            $value = trim((string) ($filters[$key] ?? ''));

            if ($value !== '') {
                $query->where("lb.{$column}", $value);
            }
        }

        if (! empty($filters['batch'])) {
            $query->where('lb.batch', trim((string) $filters['batch']));
        }

        // Admin-only filters.
        $status = trim((string) ($filters['status'] ?? ''));

        if ($status !== '') {
            $query->where('lb.status', $status);
        }

        $visibility = trim((string) ($filters['visibility'] ?? ''));

        if ($visibility === 'public') {
            $query->where('lb.is_public', true)
                ->where('lb.show_on_leaderboard', true);
        } elseif ($visibility === 'hidden') {
            $query->where(function (QueryBuilder $q) {
                $q->where('lb.is_public', false)
                    ->orWhere('lb.show_on_leaderboard', false);
            });
        }

        if (isset($filters['min_contribution']) && $filters['min_contribution'] !== null && $filters['min_contribution'] !== '') {
            $query->whereRaw('CAST(lb.verified_total AS REAL) >= ?', [max(0, (float) $filters['min_contribution'])]);
        }

        return $query;
    }

    /**
     * Paginate a prepared leaderboard query and hydrate display helpers on
     * each row (contribution formatting is centralized here, never inline in
     * Blade templates).
     */
    private function finalizePaginator(QueryBuilder $query, int $perPage): LengthAwarePaginator
    {
        $paginator = $query->paginate($perPage);

        $paginator->getCollection()->each(fn ($row) => $this->hydrateRow($row));

        return $paginator;
    }

    /**
     * Attach the derived presentation helpers to a leaderboard row object.
     */
    private function hydrateRow(object $row): void
    {
        $total = (float) $row->verified_total;

        $row->verified_total_float = $total;
        $row->formatted_contribution = '৳'.number_format($total);
    }
}
