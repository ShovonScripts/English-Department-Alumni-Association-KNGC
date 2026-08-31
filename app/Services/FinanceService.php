<?php

namespace App\Services;

use App\Enums\ExpenseStatus;
use App\Enums\PaymentStatus;
use App\Models\Expense;
use App\Models\Payment;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

/**
 * Centralized association finance calculations.
 *
 * This is an association fund summary — never a commercial revenue system.
 * Total collections always flow through Payment::valid() (Feature 13) so
 * the paid/partial vs void/waived logic lives in exactly one place.
 *
 * All totals use database SUM()/COUNT() aggregation; no float accumulation
 * in PHP. Monthly grouping uses substr(Y-m) which works identically on
 * MySQL and SQLite for DATE columns.
 */
class FinanceService
{
    /*
    |--------------------------------------------------------------------------
    | Totals
    |--------------------------------------------------------------------------
    */

    /**
     * Total valid collections (paid + partial dues). Never void or waived.
     */
    public function totalCollections(): float
    {
        return (float) Payment::query()->valid()->sum('amount');
    }

    /**
     * Total valid (recorded) expenses. Void expenses never count.
     */
    public function totalExpenses(): float
    {
        return (float) Expense::query()->valid()->sum('amount');
    }

    /**
     * Current Balance = Total Collections - Total Expenses.
     * Negative balances are legitimate and never floored at zero.
     */
    public function currentBalance(): float
    {
        return round($this->totalCollections() - $this->totalExpenses(), 2);
    }

    public function collectionCount(): int
    {
        return (int) Payment::query()->valid()->count();
    }

    public function expenseCount(): int
    {
        return (int) Expense::query()->valid()->count();
    }

    /*
    |--------------------------------------------------------------------------
    | Monthly figures
    |--------------------------------------------------------------------------
    */

    public function monthlyCollections(?int $year = null, ?int $month = null): float
    {
        [$year, $month] = $this->resolvePeriod($year, $month);

        return (float) Payment::query()->valid()
            ->whereYear('paid_at', $year)
            ->whereMonth('paid_at', $month)
            ->sum('amount');
    }

    public function monthlyExpenses(?int $year = null, ?int $month = null): float
    {
        [$year, $month] = $this->resolvePeriod($year, $month);

        return (float) Expense::query()->valid()
            ->whereYear('expense_date', $year)
            ->whereMonth('expense_date', $month)
            ->sum('amount');
    }

    public function monthlyBalance(?int $year = null, ?int $month = null): float
    {
        [$year, $month] = $this->resolvePeriod($year, $month);

        return round($this->monthlyCollections($year, $month) - $this->monthlyExpenses($year, $month), 2);
    }

    /*
    |--------------------------------------------------------------------------
    | Yearly summary
    |--------------------------------------------------------------------------
    */

    /**
     * Month-by-month collections, expenses, and balance for one year.
     *
     * Two grouped aggregate queries total (one per source) — never one
     * query pair per month.
     *
     * @return list<array{month: int, label: string, collections: float, expenses: float, balance: float, collection_count: int, expense_count: int}>
     */
    public function yearlySummary(int $year): array
    {
        $collections = $this->groupedMonthlySums(
            (new Payment)->getTable(),
            'paid_at',
            $year,
            PaymentStatus::collectibleValues()
        );

        $expenses = $this->groupedMonthlySums(
            (new Expense)->getTable(),
            'expense_date',
            $year,
            [ExpenseStatus::Recorded->value]
        );

        $summary = [];

        for ($month = 1; $month <= 12; $month++) {
            $key = $year.'-'.str_pad((string) $month, 2, '0', STR_PAD_LEFT);
            $collected = (float) ($collections[$key]['total'] ?? 0);
            $spent = (float) ($expenses[$key]['total'] ?? 0);

            $summary[] = [
                'month' => $month,
                'label' => Carbon::create($year, $month, 1)->format('F'),
                'collections' => $collected,
                'expenses' => $spent,
                'balance' => round($collected - $spent, 2),
                'collection_count' => (int) ($collections[$key]['count'] ?? 0),
                'expense_count' => (int) ($expenses[$key]['count'] ?? 0),
            ];
        }

        return $summary;
    }

    /*
    |--------------------------------------------------------------------------
    | Category breakdown
    |--------------------------------------------------------------------------
    */

    /**
     * Recorded expenses grouped by category, largest first. Void expenses
     * are excluded. Percentages are derived by the caller against the total.
     *
     * @return Collection<int, object{id: int, name: string, slug: string, total: float, count: int}>
     */
    public function expenseCategoryBreakdown(?int $year = null, ?int $month = null): Collection
    {
        $rows = Expense::query()
            ->valid()
            ->when($year !== null && $year > 0, fn ($q) => $q->whereYear('expense_date', $year))
            ->when($month !== null && $month > 0, fn ($q) => $q->whereMonth('expense_date', $month))
            ->join('expense_categories', 'expense_categories.id', '=', 'expenses.expense_category_id')
            ->toBase()
            ->selectRaw('expense_categories.id, expense_categories.name, expense_categories.slug, COALESCE(SUM(expenses.amount), 0) as total, COUNT(*) as count')
            ->groupBy('expense_categories.id', 'expense_categories.name', 'expense_categories.slug')
            ->orderByDesc('total')
            ->get();

        return $rows->map(fn ($row) => (object) [
            'id' => (int) $row->id,
            'name' => $row->name,
            'slug' => $row->slug,
            'total' => (float) $row->total,
            'count' => (int) $row->count,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Recent activity
    |--------------------------------------------------------------------------
    */

    /**
     * Most recent valid collections (paid + partial only).
     */
    public function recentCollections(int $limit = 5): Collection
    {
        return Payment::query()
            ->valid()
            ->with(['membership.alumni', 'membership.type', 'recordedBy'])
            ->orderByDesc('paid_at')
            ->orderByDesc('id')
            ->limit($limit)
            ->get();
    }

    /**
     * Most recent valid (recorded) expenses.
     */
    public function recentExpenses(int $limit = 5): Collection
    {
        return Expense::query()
            ->valid()
            ->with(['category', 'recordedBy'])
            ->orderByDesc('expense_date')
            ->orderByDesc('id')
            ->limit($limit)
            ->get();
    }

    /*
    |--------------------------------------------------------------------------
    | Formatting helpers
    |--------------------------------------------------------------------------
    */

    /**
     * Format a balance, keeping negative values explicit (never floored,
     * never color-only).
     */
    public static function formatBalance(float $balance): string
    {
        return ($balance < 0 ? '-' : '').'৳'.number_format(abs($balance));
    }
    /*
    |--------------------------------------------------------------------------
    | Internals
    |--------------------------------------------------------------------------
    */

    /**
     * Grouped monthly sums for one financial source table.
     *
     * @param  list<string>  $statuses
     * @return array<string, array{total: float, count: int}>
     */
    private function groupedMonthlySums(string $table, string $dateColumn, int $year, array $statuses): array
    {
        $rows = DB::table($table)
            ->where('status', $statuses)
            ->whereYear($dateColumn, $year)
            ->selectRaw("substr({$dateColumn}, 1, 7) as ym, COALESCE(SUM(amount), 0) as total, COUNT(*) as count")
            ->groupBy('ym')
            ->get();

        return $rows->mapWithKeys(fn ($row) => [
            $row->ym => ['total' => (float) $row->total, 'count' => (int) $row->count],
        ])->all();
    }

    /**
     * Default to the current month/year when no explicit period is given.
     *
     * @return array{0: int, 1: int}
     */
    private function resolvePeriod(?int $year, ?int $month): array
    {
        $now = now();

        return [
            ($year !== null && $year > 0) ? $year : (int) $now->year,
            ($month !== null && $month >= 1 && $month <= 12) ? $month : (int) $now->month,
        ];
    }
}
