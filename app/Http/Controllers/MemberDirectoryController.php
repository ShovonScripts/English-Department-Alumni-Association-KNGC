<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use App\Models\Membership;
use App\Models\MembershipTier;
use App\Models\MembershipType;
use Illuminate\Http\Request;

class MemberDirectoryController extends Controller
{
    /**
     * Public member directory with search, filters, and statistics.
     */
    public function index(Request $request)
    {
        $search = trim((string) $request->query('search'));
        $batch = $request->query('batch');
        $graduationYear = $request->query('graduation_year');
        $country = $request->query('country');
        $profession = $request->query('profession');
        $typeId = $request->query('membership_type_id');
        $tierId = $request->query('membership_tier_id');

        $members = Membership::query()
            ->where('status', Membership::STATUS_ACTIVE)
            ->where('is_public', true)
            ->with(['alumni', 'type', 'tier'])
            ->when($search !== '', fn ($query) => $query->whereHas('alumni', function ($q) use ($search) {
                $q->where(function ($q) use ($search) {
                    $q->where('full_name', 'like', "%{$search}%")
                        ->orWhere('student_id', 'like', "%{$search}%")
                        ->orWhere('profession', 'like', "%{$search}%")
                        ->orWhere('organization', 'like', "%{$search}%")
                        ->orWhere('batch', 'like', "%{$search}%");
                });
            }))
            ->when($batch, fn ($query, $value) => $query->whereHas('alumni', fn ($q) => $q->where('batch', $value)))
            ->when($graduationYear, fn ($query, $value) => $query->whereHas('alumni', fn ($q) => $q->where('graduation_year', $value)))
            ->when($country, fn ($query, $value) => $query->whereHas('alumni', fn ($q) => $q->where('country', $value)))
            ->when($profession, fn ($query, $value) => $query->whereHas('alumni', fn ($q) => $q->where('profession', $value)))
            ->when($typeId, fn ($query, $value) => $query->where('membership_type_id', $value))
            ->when($tierId !== null && $tierId !== '', fn ($query) => $query->when(
                $tierId === 'none',
                fn ($q) => $q->whereNull('membership_tier_id'),
                fn ($q) => $q->where('membership_tier_id', $tierId)
            ))
            ->orderBy('sort_order')
            ->orderBy('membership_number')
            ->paginate(12)
            ->withQueryString();

        return view('pages.members', [
            'members' => $members,
            'filters' => [
                'search' => $search,
                'batch' => $batch,
                'graduation_year' => $graduationYear,
                'country' => $country,
                'profession' => $profession,
                'membership_type_id' => $typeId,
                'membership_tier_id' => $tierId,
            ],
            'batches' => Alumni::query()
                ->whereHas('membership', fn ($q) => $q->where('status', Membership::STATUS_ACTIVE)->where('is_public', true))
                ->whereNotNull('batch')
                ->distinct()
                ->orderBy('batch')
                ->pluck('batch'),
            'years' => Alumni::query()
                ->whereHas('membership', fn ($q) => $q->where('status', Membership::STATUS_ACTIVE)->where('is_public', true))
                ->whereNotNull('graduation_year')
                ->distinct()
                ->orderByDesc('graduation_year')
                ->pluck('graduation_year'),
            'countries' => Alumni::query()
                ->whereHas('membership', fn ($q) => $q->where('status', Membership::STATUS_ACTIVE)->where('is_public', true))
                ->whereNotNull('country')
                ->distinct()
                ->orderBy('country')
                ->pluck('country'),
            'professions' => Alumni::query()
                ->whereHas('membership', fn ($q) => $q->where('status', Membership::STATUS_ACTIVE)->where('is_public', true))
                ->whereNotNull('profession')
                ->distinct()
                ->orderBy('profession')
                ->pluck('profession'),
            'types' => MembershipType::active()->ordered()->get(),
            'tiers' => MembershipTier::active()->ordered()->get(),
            'stats' => $this->directoryStats(),
        ]);
    }

    /**
     * Public member profile page.
     */
    public function show(string $slug)
    {
        $alumni = Alumni::query()
            ->where('slug', $slug)
            ->with(['publicMembership.type', 'publicMembership.tier', 'stories' => fn ($q) => $q->published()->latest('published_at')])
            ->first();

        abort_unless($alumni, 404);

        $membership = $alumni->publicMembership;

        abort_unless($membership, 404);

        return view('pages.member-show', [
            'alumni' => $alumni,
            'membership' => $membership,
        ]);
    }

    /**
     * Aggregate public-safe statistics for the directory.
     */
    private function directoryStats(): array
    {
        $base = Membership::query()
            ->where('status', Membership::STATUS_ACTIVE)
            ->where('is_public', true);

        return [
            'total_members' => (clone $base)->count(),
            'total_types' => (clone $base)->distinct('membership_type_id')->count('membership_type_id'),
            'total_tiers' => (clone $base)->whereNotNull('membership_tier_id')->distinct('membership_tier_id')->count('membership_tier_id'),
            'total_countries' => Alumni::query()
                ->whereHas('membership', fn ($q) => $q->where('status', Membership::STATUS_ACTIVE)->where('is_public', true))
                ->whereNotNull('country')
                ->distinct('country')
                ->count('country'),
            'total_batches' => Alumni::query()
                ->whereHas('membership', fn ($q) => $q->where('status', Membership::STATUS_ACTIVE)->where('is_public', true))
                ->whereNotNull('batch')
                ->distinct('batch')
                ->count('batch'),
        ];
    }
}
