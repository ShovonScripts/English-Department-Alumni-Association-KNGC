<?php

namespace Tests\Feature;

use App\Models\Alumni;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\FeePlan;
use App\Models\Membership;
use App\Models\MembershipType;
use App\Models\Payment;
use App\Models\SiteSetting;
use App\Models\User;
use App\Services\FinanceService;
use App\Services\LeaderboardService;
use Database\Seeders\ExpenseCategorySeeder;
use Database\Seeders\ExpenseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FinanceTest extends TestCase
{
    use RefreshDatabase;

    protected FinanceService $finance;

    protected function setUp(): void
    {
        parent::setUp();

        $this->finance = new FinanceService;
    }

    protected function makeExpense(float $amount, array $attributes = []): Expense
    {
        return Expense::factory()->create(array_merge([
            'amount' => $amount,
        ], $attributes));
    }

    protected function makeMembershipWithPayments(array $amounts): Membership
    {
        $type = MembershipType::factory()->create();
        $plan = FeePlan::factory()->create(['membership_type_id' => $type->id, 'amount' => array_sum($amounts)]);
        $membership = Membership::factory()->active()->create([
            'membership_type_id' => $type->id,
            'is_public' => true,
            'show_on_leaderboard' => true,
        ]);

        foreach ($amounts as $amount) {
            Payment::factory()->create([
                'membership_id' => $membership->id,
                'fee_plan_id' => $plan->id,
                'amount' => $amount,
                'status' => 'paid',
                'paid_at' => now()->toDateString(),
            ]);
        }

        return $membership;
    }

    // ──────────────────────────────────────────
    // FINANCIAL CALCULATIONS
    // ──────────────────────────────────────────

    public function test_total_expenses_sums_recorded_expenses_only(): void
    {
        $this->makeExpense(1000);
        $this->makeExpense(500);
        Expense::factory()->voided()->create(['amount' => 999]);

        $this->assertSame(1500.0, $this->finance->totalExpenses());
        $this->assertSame(2, $this->finance->expenseCount());
    }

    public function test_total_collections_uses_payment_valid_logic(): void
    {
        $this->makeMembershipWithPayments([300, 200]);
        Payment::factory()->partial()->create(['amount' => 100]);
        Payment::factory()->void()->create(['amount' => 999]);
        Payment::factory()->waived()->create(['amount' => 999]);

        $this->makeExpense(100);

        // paid 500 + partial 100 — identical to Feature 13's own calculation.
        $this->assertSame(600.0, $this->finance->totalCollections());
        $this->assertSame(Payment::collectionTotals()['total'], $this->finance->totalCollections());
        $this->assertSame(100.0, $this->finance->totalExpenses());
    }

    public function test_current_balance_is_collections_minus_expenses(): void
    {
        $this->makeMembershipWithPayments([5000]);
        $this->makeExpense(15000);
        $this->makeExpense(3000);

        $this->assertSame(5000.0, $this->finance->totalCollections());
        $this->assertSame(18000.0, $this->finance->totalExpenses());
        $this->assertSame(-13000.0, $this->finance->currentBalance());
    }

    public function test_balance_is_not_floored_at_zero(): void
    {
        $this->makeExpense(500);

        $this->assertSame(-500.0, $this->finance->currentBalance());
        $this->assertSame('-৳500', FinanceService::formatBalance(-500.0));
        $this->assertSame('৳500', FinanceService::formatBalance(500.0));
    }

    public function test_monthly_figures_use_paid_at_and_expense_date(): void
    {
        $this->makeMembershipWithPayments([400]); // paid this month
        $this->makeExpense(150, ['expense_date' => now()->toDateString()]);
        $this->makeExpense(250, ['expense_date' => now()->subMonths(2)->toDateString()]);

        $this->assertSame(400.0, $this->finance->monthlyCollections());
        $this->assertSame(150.0, $this->finance->monthlyExpenses());
        $this->assertSame(250.0, $this->finance->monthlyBalance());

        $previousMonth = now()->subMonths(2);
        $this->assertSame(0.0, $this->finance->monthlyCollections((int) $previousMonth->format('Y'), (int) $previousMonth->format('n')));
        $this->assertSame(250.0, $this->finance->monthlyExpenses((int) $previousMonth->format('Y'), (int) $previousMonth->format('n')));
    }

    public function test_yearly_summary_groups_by_month(): void
    {
        $year = (int) now()->format('Y');

        $this->makeMembershipWithPayments([1000]);
        Payment::query()->update(['paid_at' => $year.'-01-15']);
        $this->makeExpense(400, ['expense_date' => $year.'-01-20']);
        $this->makeExpense(100, ['expense_date' => $year.'-02-10']);
        Expense::factory()->voided()->create(['amount' => 999, 'expense_date' => $year.'-03-05']);

        $summary = $this->finance->yearlySummary($year);

        $this->assertCount(12, $summary);
        $this->assertSame('January', $summary[0]['label']);
        $this->assertSame(1000.0, $summary[0]['collections']);
        $this->assertSame(400.0, $summary[0]['expenses']);
        $this->assertSame(600.0, $summary[0]['balance']);
        $this->assertSame(100.0, $summary[1]['expenses']);
        $this->assertSame(-100.0, $summary[1]['balance']);
        $this->assertSame(0.0, $summary[2]['expenses']); // void never appears
    }

    public function test_expense_category_breakdown_excludes_void_and_computes_totals(): void
    {
        $events = ExpenseCategory::factory()->create(['name' => 'Events & Programs']);
        $welfare = ExpenseCategory::factory()->create(['name' => 'Welfare Activities']);

        $this->makeExpense(10000, ['expense_category_id' => $events->id]);
        $this->makeExpense(7500, ['expense_category_id' => $welfare->id]);
        $this->makeExpense(2500, ['expense_category_id' => $events->id]);
        Expense::factory()->voided()->create(['amount' => 5000, 'expense_category_id' => $events->id]);

        $breakdown = $this->finance->expenseCategoryBreakdown();

        $this->assertCount(2, $breakdown);
        $this->assertSame('Events & Programs', $breakdown[0]->name);
        $this->assertSame(12500.0, $breakdown[0]->total);
        $this->assertSame(7500.0, $breakdown[1]->total);
        $this->assertSame(2, $breakdown[0]->count);
    }

    public function test_expense_category_breakdown_respects_period_filters(): void
    {
        $year = (int) now()->format('Y');
        ExpenseCategory::factory()->create();

        $this->makeExpense(100, ['expense_date' => $year.'-01-15']);
        $this->makeExpense(200, ['expense_date' => $year.'-03-01']);

        $this->assertSame(100.0, $this->finance->expenseCategoryBreakdown($year, 1)->sum('total'));
        $this->assertSame(200.0, $this->finance->expenseCategoryBreakdown($year, 3)->sum('total'));
        $this->assertSame(0.0, (float) $this->finance->expenseCategoryBreakdown($year - 1)->sum('total'));
    }

    public function test_recent_transactions_return_only_valid_records(): void
    {
        $this->makeMembershipWithPayments([500]);
        Payment::factory()->void()->create(['amount' => 999]);
        $this->makeExpense(100);
        Expense::factory()->voided()->create(['amount' => 999]);

        $this->assertSame(1, $this->finance->recentCollections()->count());
        $this->assertSame(1, $this->finance->recentExpenses()->count());
    }

    // ──────────────────────────────────────────
    // INTEGRATION — EXISTING FEATURES UNCHANGED
    // ──────────────────────────────────────────

    public function test_feature_13_collection_totals_are_unchanged_by_expenses(): void
    {
        $before = Payment::collectionTotals();

        $this->makeMembershipWithPayments([1000]);
        $afterPayments = Payment::collectionTotals();

        $this->makeExpense(999);
        Expense::factory()->voided()->create(['amount' => 999]);
        $afterExpenses = Payment::collectionTotals();

        $this->assertSame($before['total'] + 1000.0, $afterPayments['total']);
        $this->assertSame($afterPayments['total'], $afterExpenses['total']);
        $this->assertSame($afterPayments['count'], $afterExpenses['count']);
    }

    public function test_feature_14_leaderboard_totals_ignore_expenses(): void
    {
        $leaderboard = new LeaderboardService;
        $membership = $this->makeMembershipWithPayments([10000]);

        $before = $leaderboard->topContributors(5);
        $this->assertSame(10000.0, $before->first()->verified_total_float);

        // Expenses must never subtract from individual contributions.
        $this->makeExpense(5000);
        $this->makeExpense(2000);

        $after = $leaderboard->topContributors(5);
        $this->assertSame($before->count(), $after->count());
        $this->assertSame(10000.0, $after->first()->verified_total_float);
        $this->assertTrue($after->first()->membership_id == $membership->id);
    }

    public function test_membership_contribution_summaries_ignore_expenses(): void
    {
        $membership = $this->makeMembershipWithPayments([10000]);
        $beforeTotal = $membership->verifiedContributionTotal();
        $beforeCount = $membership->verifiedPaymentCount();

        $this->makeExpense(4000);

        $membership->refresh();
        $this->assertSame($beforeTotal, $membership->verifiedContributionTotal());
        $this->assertSame($beforeCount, $membership->verifiedPaymentCount());
    }

    // ──────────────────────────────────────────
    // PRIVACY — NOTHING FINANCIAL LEAKS PUBLICLY
    // ──────────────────────────────────────────

    public function test_public_pages_never_expose_financial_data(): void
    {
        $this->makeMembershipWithPayments([8000]);
        $this->makeExpense(3000);
        $alumni = Alumni::query()->firstOrFail();
        SiteSetting::set('leaderboard_public_enabled', true);

        $secretTokens = [
            'EDAA-EXP-',
            'Current Balance',
            'Total Expenses',
            'Total Collections',
            'Expense Category Breakdown',
        ];

        foreach ([
            route('home'),
            route('alumni.show', $alumni),
            route('leaderboard.index'),
        ] as $url) {
            $response = $this->get($url);
            $response->assertOk();

            foreach ($secretTokens as $token) {
                $response->assertDontSee($token, false);
            }
        }
    }

    public function test_public_routes_cannot_access_finance_dashboard(): void
    {
        // Unauthenticated users are bounced to the admin login...
        $this->get('/admin/finance')->assertRedirect(route('admin.login'));

        // ...and authenticated non-admins are forbidden. There is no public
        // finance controller at all — the route lives under the admin group.
        $this->actingAs(User::factory()->create());
        $this->get('/admin/finance')->assertForbidden();
    }

    // ──────────────────────────────────────────
    // SEEDING
    // ──────────────────────────────────────────

    public function test_expense_category_seeder_is_idempotent(): void
    {
        $this->seed(ExpenseCategorySeeder::class);
        $firstRun = ExpenseCategory::count();

        $this->seed(ExpenseCategorySeeder::class);
        $secondRun = ExpenseCategory::count();

        $this->assertSame(10, $firstRun);
        $this->assertSame($firstRun, $secondRun);
        $this->assertSame(10, ExpenseCategory::query()->distinct('slug')->count('slug'));
    }

    public function test_expense_seeder_creates_realistic_data_and_is_idempotent(): void
    {
        $this->seed(ExpenseCategorySeeder::class);
        User::factory()->admin()->create();

        $this->seed(ExpenseSeeder::class);
        $firstRun = Expense::count();

        $this->assertSame(5, $firstRun); // 4 valid + 1 void
        $this->assertSame(4, Expense::query()->valid()->count());
        $this->assertSame(1, Expense::query()->void()->count());
        $this->assertSame(5, Expense::query()->distinct('expense_number')->count('expense_number'));
        // 5000 + 3000 + 2500 + 1500 recorded, minus nothing (void excluded).
        $this->assertSame(12000.0, $this->finance->totalExpenses());

        // Idempotent: a second run must not duplicate anything.
        $this->seed(ExpenseSeeder::class);
        $this->assertSame($firstRun, Expense::count());

        // No orphan expenses — every expense references a real category.
        $this->assertSame(0, Expense::query()
            ->whereNotIn('expense_category_id', ExpenseCategory::query()->select('id'))
            ->count());
    }
}
