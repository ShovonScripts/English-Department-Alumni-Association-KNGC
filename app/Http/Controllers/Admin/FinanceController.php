<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use App\Services\FinanceService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FinanceController extends Controller
{
    public function __construct(private FinanceService $finance) {}

    /**
     * Central internal financial dashboard. All figures are admin-only —
     * nothing from this page is ever exposed publicly (Feature 16 may
     * selectively change that later).
     */
    public function index(Request $request): View
    {
        $year = $this->resolveYear($request->query('year'));
        $month = $request->filled('month') ? max(1, min(12, (int) $request->query('month'))) : null;

        $totalCollections = $this->finance->totalCollections();
        $totalExpenses = $this->finance->totalExpenses();

        $monthCollections = $this->finance->monthlyCollections();
        $monthExpenses = $this->finance->monthlyExpenses();

        $breakdown = $this->finance->expenseCategoryBreakdown($year, $month);
        $breakdownTotal = (float) $breakdown->sum('total');

        return view('admin.finance.index', [
            'totalCollections' => $totalCollections,
            'totalExpenses' => $totalExpenses,
            'currentBalance' => round($totalCollections - $totalExpenses, 2),
            'collectionCount' => $this->finance->collectionCount(),
            'expenseCount' => $this->finance->expenseCount(),
            'monthCollections' => $monthCollections,
            'monthExpenses' => $monthExpenses,
            'monthBalance' => round($monthCollections - $monthExpenses, 2),
            'year' => $year,
            'selectedMonth' => $month,
            'yearly' => $this->finance->yearlySummary($year),
            'breakdown' => $breakdown,
            'breakdownTotal' => $breakdownTotal,
            'recentCollections' => $this->finance->recentCollections(),
            'recentExpenses' => $this->finance->recentExpenses(),
            'availableYears' => $this->availableYears(),
            'publicEnabled' => SiteSetting::financePublicEnabled(),
        ]);
    }

    /**
     * Toggle the site-wide public finance transparency switch (Feature 16).
     */
    public function togglePublic(): RedirectResponse
    {
        SiteSetting::set('public_finance_enabled', ! SiteSetting::financePublicEnabled());

        $state = SiteSetting::financePublicEnabled() ? 'enabled' : 'disabled';

        return redirect()
            ->route('admin.finance.index')
            ->with('status', "Public finance transparency has been {$state}.");
    }

    /**
     * Years that actually contain financial activity, newest first.
     *
     * @return list<int>
     */
    private function availableYears(): array
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

    private function resolveYear(mixed $value): int
    {
        $year = (int) $value;

        if ($year < 2000 || $year > 2100) {
            $year = (int) now()->year;
        }

        return $year;
    }
}
