<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use App\Models\AlumniStory;
use App\Models\CommitteeMember;
use App\Models\Event;
use App\Models\FeePlan;
use App\Models\GalleryAlbum;
use App\Models\Membership;
use App\Models\MembershipTier;
use App\Models\MembershipType;
use App\Models\News;
use App\Models\Publication;
use App\Models\SiteSetting;
use App\Services\FinanceService;
use App\Services\LeaderboardService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PageController extends Controller
{
    public function __construct(private LeaderboardService $leaderboard) {}

    public function home()
    {
        $leaderboardEnabled = SiteSetting::leaderboardEnabled();

        return view('pages.home', [
            'featuredAlumni' => Alumni::query()
                ->where('status', Alumni::STATUS_ACTIVE)
                ->where('is_featured', true)
                ->with(['publicMembership.type', 'publicMembership.tier'])
                ->orderBy('sort_order')
                ->orderBy('full_name')
                ->limit(4)
                ->get(),
            'committeeMembers' => CommitteeMember::query()
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->orderBy('name')
                ->limit(6)
                ->get(),
            'upcomingEvents' => Event::query()
                ->published()
                ->upcoming()
                ->with('category')
                ->orderBy('event_date')
                ->limit(3)
                ->get(),
            'latestNews' => News::query()
                ->published()
                ->with('category')
                ->latest('published_at')
                ->limit(3)
                ->get(),
            'latestStories' => AlumniStory::query()
                ->published()
                ->with('alumni')
                ->latest('published_at')
                ->limit(3)
                ->get(),
            'latestAlbums' => GalleryAlbum::query()
                ->published()
                ->withCount('photos')
                ->with('event')
                ->ordered()
                ->limit(4)
                ->get(),
            'latestPublications' => Publication::query()
                ->published()
                ->with('category')
                ->latest('publication_date')
                ->limit(4)
                ->get(),
            // Feature 14 — compact top-contributor section, only when the
            // site-level public leaderboard switch is enabled. The service
            // applies every public eligibility rule at the query level.
            'leaderboardEnabled' => $leaderboardEnabled,
            'topContributors' => $leaderboardEnabled
                ? $this->leaderboard->topContributors(3)
                : collect(),
            'publicMembers' => Membership::query()
                ->where('status', Membership::STATUS_ACTIVE)
                ->where('is_public', true)
                ->with(['alumni', 'type', 'tier'])
                ->orderByDesc('approved_at')
                ->limit(6)
                ->get(),
        ]);
    }

    public function about()
    {
        return view('pages.about');
    }

    public function alumni()
    {
        return view('pages.alumni');
    }

    public function stories()
    {
        return view('pages.stories');
    }

    public function gallery()
    {
        return view('pages.gallery');
    }

    public function publications()
    {
        return view('pages.publications');
    }

    public function contact()
    {
        return view('pages.contact');
    }

    /**
     * Public finance transparency page (Feature 16).
     *
     * Shows aggregate-only financial information. Individual payments,
     * expenses, member names, and all private records are never exposed.
     */
    public function finance(FinanceService $finance)
    {
        abort_unless(SiteSetting::financePublicEnabled(), 404);

        $year = $this->resolveFinanceYear(request()->query('year'));

        $totalCollections = $finance->totalCollections();
        $totalExpenses = $finance->totalExpenses();

        $monthCollections = $finance->monthlyCollections();
        $monthExpenses = $finance->monthlyExpenses();

        return view('pages.finance', [
            'totalCollections' => $totalCollections,
            'totalExpenses' => $totalExpenses,
            'currentBalance' => round($totalCollections - $totalExpenses, 2),
            'monthCollections' => $monthCollections,
            'monthExpenses' => $monthExpenses,
            'monthBalance' => round($monthCollections - $monthExpenses, 2),
            'year' => $year,
            'yearly' => $finance->yearlySummary($year),
            'breakdown' => $breakdown = $finance->expenseCategoryBreakdown($year),
            'breakdownTotal' => (float) $breakdown->sum('total'),
            'availableYears' => $this->financeAvailableYears(),
            'lastUpdatedAt' => $this->financeLastUpdated(),
        ]);
    }

    /**
     * Years that contain financial activity, newest first, always
     * including the current year.
     *
     * @return list<int>
     */
    private function financeAvailableYears(): array
    {
        $paymentYears = DB::table('payments')
            ->selectRaw('DISTINCT substr(paid_at, 1, 4) as y')
            ->pluck('y');

        $expenseYears = DB::table('expenses')
            ->selectRaw('DISTINCT substr(expense_date, 1, 4) as y')
            ->pluck('y');

        return $paymentYears->merge($expenseYears)
            ->map(fn ($y) => (int) $y)
            ->push((int) now()->year)
            ->unique()
            ->sortDesc()
            ->values()
            ->all();
    }

    private function resolveFinanceYear(mixed $value): int
    {
        $year = (int) $value;

        if ($year < 2000 || $year > 2100) {
            $year = (int) now()->year;
        }

        return $year;
    }

    /**
     * Determine the latest financial record date for the "last updated"
     * indicator on the public transparency page.
     */
    private function financeLastUpdated(): ?Carbon
    {
        $latestPayment = DB::table('payments')
            ->where('status', ['paid', 'partial'])
            ->max('paid_at');

        $latestExpense = DB::table('expenses')
            ->where('status', 'recorded')
            ->max('expense_date');

        $dates = array_filter([$latestPayment, $latestExpense]);

        return $dates ? Carbon::parse(max($dates)) : null;
    }

    /**
     * Public membership information page.
     */
    public function membership()
    {
        $membershipTypes = MembershipType::active()->ordered()->get();
        $membershipTiers = MembershipTier::active()->ordered()->get();
        $feePlans = FeePlan::active()->current()->with('type')->get();

        return view('pages.membership', [
            'membershipTypes' => $membershipTypes,
            'membershipTiers' => $membershipTiers,
            'feePlans' => $feePlans,
        ]);
    }
}
