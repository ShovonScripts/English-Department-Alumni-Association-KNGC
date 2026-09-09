<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use App\Models\AlumniStory;
use App\Models\SiteSetting;
use App\Services\LeaderboardService;
use Illuminate\Http\Request;

class AlumniController extends Controller
{
    public function __construct(private LeaderboardService $leaderboard) {}

    public function index(Request $request)
    {
        $search = trim((string) $request->query('search'));
        $batch = $request->query('batch');
        $graduationYear = $request->query('graduation_year');
        $country = $request->query('country');

        $alumni = Alumni::query()
            ->where('status', Alumni::STATUS_ACTIVE)
            ->with(['publicMembership.type', 'publicMembership.tier'])
            ->when($search !== '', fn ($query) => $query->where(function ($query) use ($search) {
                $query->where('full_name', 'like', "%" . $this->escapeLike($search) . "%")
                    ->orWhere('profession', 'like', "%" . $this->escapeLike($search) . "%")
                    ->orWhere('organization', 'like', "%" . $this->escapeLike($search) . "%");
            }))
            ->when($batch, fn ($query, $batch) => $query->where('batch', $batch))
            ->when($graduationYear, fn ($query, $year) => $query->where('graduation_year', $year))
            ->when($country, fn ($query, $country) => $query->where('country', $country))
            ->orderBy('sort_order')
            ->orderBy('full_name')
            ->paginate(12)
            ->withQueryString();

        return view('pages.alumni', [
            'alumni' => $alumni,
            'filters' => [
                'search' => $search,
                'batch' => $batch,
                'graduation_year' => $graduationYear,
                'country' => $country,
            ],
            'batches' => Alumni::query()
                ->where('status', Alumni::STATUS_ACTIVE)
                ->whereNotNull('batch')
                ->distinct()
                ->orderBy('batch')
                ->pluck('batch'),
            'years' => Alumni::query()
                ->where('status', Alumni::STATUS_ACTIVE)
                ->whereNotNull('graduation_year')
                ->distinct()
                ->orderByDesc('graduation_year')
                ->pluck('graduation_year'),
            'countries' => Alumni::query()
                ->where('status', Alumni::STATUS_ACTIVE)
                ->whereNotNull('country')
                ->distinct()
                ->orderBy('country')
                ->pluck('country'),
            'totalAlumni' => Alumni::query()->where('status', Alumni::STATUS_ACTIVE)->count(),
            'totalCountries' => Alumni::query()
                ->where('status', Alumni::STATUS_ACTIVE)
                ->whereNotNull('country')
                ->distinct('country')
                ->count('country'),
            'totalBatches' => Alumni::query()
                ->where('status', Alumni::STATUS_ACTIVE)
                ->whereNotNull('batch')
                ->distinct('batch')
                ->count('batch'),
            'featuredAlumni' => Alumni::query()
                ->where('status', Alumni::STATUS_ACTIVE)
                ->where('is_featured', true)
                ->with(['publicMembership.type', 'publicMembership.tier'])
                ->orderBy('sort_order')
                ->orderBy('full_name')
                ->limit(8)
                ->get(),
        ]);
    }

    public function show(Alumni $alumni)
    {
        abort_unless($alumni->status === Alumni::STATUS_ACTIVE, 404);

        $stories = AlumniStory::published()
            ->where('alumni_id', $alumni->id)
            ->latest('published_at')
            ->limit(4)
            ->get();

        $alumni->load(['publicMembership.type', 'publicMembership.tier']);

        // Feature 14 — a subtle leaderboard acknowledgment shown ONLY when the
        // member is publicly eligible (active + public profile + leaderboard
        // opt-in) AND holds a positive verified contribution. The aggregate is
        // derived data; individual payments are never exposed here.
        $leaderboard = null;

        if (SiteSetting::leaderboardEnabled()) {
            $membership = $alumni->publicMembership;

            if ($membership !== null && $membership->show_on_leaderboard) {
                $total = $membership->verifiedContributionTotal();
                $rank = $this->leaderboard->rankFor($membership->id, $total);

                if ($rank !== null) {
                    $leaderboard = [
                        'rank' => $rank,
                        'contribution' => $total,
                    ];
                }
            }
        }

        return view('pages.alumni-show', [
            'alumni' => $alumni,
            'stories' => $stories,
            'leaderboard' => $leaderboard,
        ]);
    }
}
