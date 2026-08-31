<?php

namespace App\Models;

use App\Enums\PaymentStatus;
use Database\Factories\PaymentFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    /** @use HasFactory<PaymentFactory> */
    use HasFactory;

    protected $fillable = [
        'membership_id',
        'fee_plan_id',
        'payment_number',
        'amount',
        'currency',
        'status',
        'paid_at',
        'reference',
        'notes',
        'recorded_by',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'status' => PaymentStatus::class,
            'paid_at' => 'date',
            'voided_at' => 'datetime',
        ];
    }

    public function membership(): BelongsTo
    {
        return $this->belongsTo(Membership::class);
    }

    public function feePlan(): BelongsTo
    {
        return $this->belongsTo(FeePlan::class);
    }

    public function recordedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }

    public function voidedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'voided_by');
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes — all financial aggregation must flow through these.
    |--------------------------------------------------------------------------
    */

    /**
     * Payments that represent money actually collected (paid + partial).
     */
    public function scopeValid(Builder $query): Builder
    {
        return $query->whereIn('status', PaymentStatus::collectibleValues());
    }

    public function scopePaid(Builder $query): Builder
    {
        return $query->where('status', PaymentStatus::Paid->value);
    }

    public function scopePartial(Builder $query): Builder
    {
        return $query->where('status', PaymentStatus::Partial->value);
    }

    public function scopeWaived(Builder $query): Builder
    {
        return $query->where('status', PaymentStatus::Waived->value);
    }

    public function scopeVoid(Builder $query): Builder
    {
        return $query->where('status', PaymentStatus::Void->value);
    }

    public function scopeForMembership(Builder $query, int $membershipId): Builder
    {
        return $query->where('membership_id', $membershipId);
    }

    public function scopeForFeePlan(Builder $query, int $feePlanId): Builder
    {
        return $query->where('fee_plan_id', $feePlanId);
    }

    /*
    |--------------------------------------------------------------------------
    | Number generation
    |--------------------------------------------------------------------------
    */

    /**
     * Generate the next sequential, unique payment number (EDAA-PAY-000001).
     *
     * Numbers are fixed-width so descending string order equals numeric
     * order. Voided records keep their numbers forever; the unique
     * constraint is the final race-condition guard.
     */
    public static function generatePaymentNumber(): string
    {
        $attempts = 0;

        do {
            $latest = static::query()->orderByDesc('payment_number')->value('payment_number');
            $sequence = $latest !== null ? (int) substr($latest, 9) : 0;
            $number = 'EDAA-PAY-'.str_pad((string) ($sequence + 1), 6, '0', STR_PAD_LEFT);

            if (! static::query()->where('payment_number', $number)->exists()) {
                return $number;
            }

            $attempts++;
        } while ($attempts < 25);

        throw new \RuntimeException('Unable to generate a unique payment number.');
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    public function formattedAmount(): string
    {
        return '৳'.number_format((float) $this->amount);
    }

    /**
     * Valid money collected for a membership + plan pair, excluding this
     * payment when one is provided (used when recalculating on edit).
     */
    public static function collectedFor(int $membershipId, int $feePlanId, ?int $ignorePaymentId = null): float
    {
        return (float) static::query()
            ->valid()
            ->forMembership($membershipId)
            ->forFeePlan($feePlanId)
            ->when($ignorePaymentId, fn (Builder $q, int $id) => $q->whereKeyNot($ignorePaymentId))
            ->sum('amount');
    }

    /**
     * Whether any waiver exists for the membership + plan pair. A waived
     * obligation is intentionally cleared and never appears as outstanding,
     * while contributing nothing to collected cash.
     */
    public static function waivedFor(int $membershipId, int $feePlanId): bool
    {
        return static::query()
            ->waived()
            ->forMembership($membershipId)
            ->forFeePlan($feePlanId)
            ->exists();
    }

    /**
     * Obligation summary for one membership against one fee plan.
     *
     * @return array{expected: float, collected: float, outstanding: float, overpaid: float, waived: bool}
     */
    public static function obligationFor(int $membershipId, FeePlan $plan, ?int $ignorePaymentId = null): array
    {
        $collected = static::collectedFor($membershipId, $plan->id, $ignorePaymentId);
        $expected = (float) $plan->amount;
        $waived = static::waivedFor($membershipId, $plan->id);

        return [
            'expected' => $expected,
            'collected' => $collected,
            // A waived obligation is intentionally cleared — never outstanding.
            'outstanding' => $waived ? 0.0 : max(0, $expected - $collected),
            'overpaid' => max(0, $collected - $expected),
            'waived' => $waived,
        ];
    }

    /**
     * Association-wide collection totals. These are organizational dues,
     * not website revenue.
     *
     * @return array{total: float, month: float, count: int}
     */
    public static function collectionTotals(): array
    {
        $valid = static::query()->valid();

        return [
            'total' => (float) (clone $valid)->sum('amount'),
            'month' => (float) (clone $valid)
                ->whereYear('paid_at', now()->year)
                ->whereMonth('paid_at', now()->month)
                ->sum('amount'),
            'count' => (int) (clone $valid)->count(),
        ];
    }

    /**
     * Outstanding dues across all active memberships that have an applicable
     * current fee plan. Memberships without an applicable plan (e.g. no
     * active plan exists, constitutionally undefined fees) are never
     * treated as owing money.
     *
     * @return array{total: float, paid_members: int}
     */
    public static function outstandingAndPaidMembers(): array
    {
        // One deterministic primary plan per type: the first by display
        // order among currently applicable plans.
        $plansByType = FeePlan::query()
            ->current()
            ->ordered()
            ->get()
            ->unique('membership_type_id')
            ->filter(fn (FeePlan $plan) => (float) $plan->amount > 0)
            ->keyBy('membership_type_id');

        $memberships = Membership::query()
            ->where('status', Membership::STATUS_ACTIVE)
            ->get(['id', 'membership_type_id']);

        $collectedByMembership = static::query()
            ->valid()
            ->whereIn('membership_id', $memberships->modelKeys())
            ->selectRaw('membership_id, SUM(amount) as total')
            ->groupBy('membership_id')
            ->pluck('total', 'membership_id');

        $waiverKeys = static::query()
            ->waived()
            ->whereIn('membership_id', $memberships->modelKeys())
            ->get(['membership_id', 'fee_plan_id'])
            ->map(fn ($p) => $p->membership_id.':'.$p->fee_plan_id)
            ->all();

        $outstandingTotal = 0.0;
        $paidMembers = 0;

        foreach ($memberships as $membership) {
            /** @var FeePlan|null $plan */
            $plan = $plansByType->get($membership->membership_type_id);

            if ($plan === null) {
                continue; // No applicable fee — never fabricate dues.
            }

            $collected = (float) ($collectedByMembership[$membership->id] ?? 0);
            $isWaived = in_array($membership->id.':'.$plan->id, $waiverKeys, true);

            if ($isWaived) {
                continue; // Intentionally cleared — no outstanding, not "paid".
            }

            $balance = (float) $plan->amount - $collected;

            if ($balance <= 0) {
                $paidMembers++;
            } else {
                $outstandingTotal += $balance;
            }
        }

        return [
            'total' => round($outstandingTotal, 2),
            'paid_members' => $paidMembers,
        ];
    }
}
