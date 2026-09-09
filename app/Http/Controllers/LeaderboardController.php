<?php

namespace App\Http\Controllers;

use App\Models\MembershipTier;
use App\Models\MembershipType;
use App\Models\SiteSetting;
use App\Services\LeaderboardService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class LeaderboardController extends Controller
{
    public function __construct(private LeaderboardService $leaderboard) {}

    /**
     * Public contribution leaderboard (Feature 14).
     *
     * Privacy is enforced at the database query level — only active, publicly
     * listed members who opted into leaderboard display are ever queried.
     */
    public function index(Request $request): View
    {
        // Site-level switch: when hidden, never query or leak contributor data.
        abort_unless(SiteSetting::leaderboardEnabled(), 404);

        $filters = [
            'q' => trim((string) $request->query('q', '')),
            'type' => trim((string) $request->query('type', '')),
            'tier' => trim((string) $request->query('tier', '')),
            'batch' => trim((string) $request->query('batch', '')),
            'graduation_year' => trim((string) $request->query('graduation_year', '')),
        ];

        return view('pages.leaderboard', [
            'entries' => $this->leaderboard->publicPaginate($filters),
            'filters' => $filters,
            'types' => MembershipType::query()->active()->ordered()->get(['slug', 'name']),
            'tiers' => MembershipTier::query()->active()->ordered()->get(['slug', 'name']),
            'batches' => $this->leaderboard->eligibleAlumniValues('batch'),
            'graduationYears' => $this->leaderboard->eligibleAlumniValues('graduation_year'),
        ]);
    }
}
