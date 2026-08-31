<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Membership;
use App\Models\MembershipTier;
use App\Models\MembershipType;
use App\Models\SiteSetting;
use App\Services\LeaderboardService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LeaderboardController extends Controller
{
    public function __construct(private LeaderboardService $leaderboard) {}

    /**
     * Administrative leaderboard / contribution analysis.
     *
     * Unlike the public page this includes hidden, private, and
     * zero-contribution memberships — it is a management view only. The
     * totals remain derived data and can never be edited here.
     */
    public function index(Request $request): View
    {
        $filters = [
            'q' => trim((string) $request->query('q', '')),
            'type' => trim((string) $request->query('type', '')),
            'tier' => trim((string) $request->query('tier', '')),
            'status' => trim((string) $request->query('status', '')),
            'visibility' => trim((string) $request->query('visibility', '')),
            'min_contribution' => $request->query('min_contribution', ''),
        ];

        return view('admin.leaderboard.index', [
            'entries' => $this->leaderboard->adminPaginate($filters),
            'filters' => $filters,
            'types' => MembershipType::query()->active()->ordered()->get(),
            'tiers' => MembershipTier::query()->active()->ordered()->get(),
            'statuses' => Membership::STATUSES,
            'publicEnabled' => SiteSetting::leaderboardEnabled(),
        ]);
    }

    /**
     * Toggle one member's public leaderboard visibility.
     *
     * This affects leaderboard display only — payments, contribution totals,
     * membership status, and the public alumni profile are untouched.
     */
    public function toggleVisibility(Membership $membership): RedirectResponse
    {
        $membership->update(['show_on_leaderboard' => ! $membership->show_on_leaderboard]);

        $state = $membership->show_on_leaderboard ? 'now visible on' : 'hidden from';

        return redirect()
            ->route('admin.leaderboard.index')
            ->with('status', "Membership {$membership->membership_number} is {$state} the public leaderboard.");
    }

    /**
     * Toggle the site-wide public leaderboard switch.
     */
    public function togglePublic(): RedirectResponse
    {
        SiteSetting::set('leaderboard_public_enabled', ! SiteSetting::leaderboardEnabled());

        $state = SiteSetting::leaderboardEnabled() ? 'enabled' : 'disabled';

        return redirect()
            ->route('admin.leaderboard.index')
            ->with('status', "The public leaderboard has been {$state}.");
    }
}
