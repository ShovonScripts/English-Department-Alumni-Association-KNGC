<?php

namespace Tests\Feature;

use App\Models\Alumni;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\Membership;
use App\Models\MembershipType;
use App\Models\Payment;
use App\Models\SiteSetting;
use App\Models\User;
use App\Services\FinanceService;
use App\Services\LeaderboardService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicFinanceTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->admin()->create();

        // Default: finance is disabled.
        SiteSetting::set('public_finance_enabled', false);
    }

    protected function enableFinance(): void
    {
        SiteSetting::set('public_finance_enabled', true);
    }

    protected function makeMembershipWithPayments(array $amounts): Membership
    {
        $type = MembershipType::factory()->create();
        $membership = Membership::factory()->active()->create([
            'membership_type_id' => $type->id,
        ]);

        foreach ($amounts as $amount) {
            Payment::factory()->create([
                'membership_id' => $membership->id,
                'amount' => $amount,
                'status' => 'paid',
                'paid_at' => now()->toDateString(),
            ]);
        }

        return $membership;
    }

    protected function makeExpense(float $amount, array $attributes = []): Expense
    {
        return Expense::factory()->create(array_merge([
            'amount' => $amount,
        ], $attributes));
    }

    // ──────────────────────────────────────────
    // PUBLIC VISIBILITY
    // ──────────────────────────────────────────

    public function test_finance_disabled_returns_404(): void
    {
        SiteSetting::set('public_finance_enabled', false);

        $this->get(route('finance.public'))->assertNotFound();
    }

    public function test_finance_enabled_returns_200(): void
    {
        $this->enableFinance();

        $this->get(route('finance.public'))->assertOk();
    }

    public function test_disabled_finance_not_visible_in_navbar(): void
    {
        SiteSetting::set('public_finance_enabled', false);

        $response = $this->get(route('home'));
        $response->assertOk();
        $response->assertDontSee(route('finance.public'), escape: false);
        $response->assertDontSee('Financial Transparency');
    }

    public function test_enabled_finance_visible_in_navbar(): void
    {
        $this->enableFinance();

        $response = $this->get(route('home'));
        $response->assertOk();
        $response->assertSee(route('finance.public'), escape: false);
    }

    public function test_disabled_finance_not_visible_in_footer(): void
    {
        SiteSetting::set('public_finance_enabled', false);

        $response = $this->get(route('about'));
        $response->assertOk();
        $response->assertDontSee('Financial Transparency');
    }

    public function test_enabled_finance_visible_in_footer(): void
    {
        $this->enableFinance();

        $response = $this->get(route('about'));
        $response->assertOk();
        $response->assertSee('Financial Transparency');
    }

    // ──────────────────────────────────────────
    // PUBLIC CONTENT
    // ──────────────────────────────────────────

    public function test_total_collections_correct(): void
    {
        $this->enableFinance();
        $this->makeMembershipWithPayments([5000, 3000]);
        Payment::factory()->partial()->create(['amount' => 1000]);
        Payment::factory()->void()->create(['amount' => 999]);

        $response = $this->get(route('finance.public'));
        $response->assertOk();
        $response->assertSee('৳9,000');
    }

    public function test_total_expenses_correct(): void
    {
        $this->enableFinance();
        $this->makeExpense(5000);
        $this->makeExpense(2500);
        Expense::factory()->voided()->create(['amount' => 999]);

        $response = $this->get(route('finance.public'));
        $response->assertOk();
        $response->assertSee('৳7,500');
    }

    public function test_current_balance_correct(): void
    {
        $this->enableFinance();
        $this->makeMembershipWithPayments([10000]);
        $this->makeExpense(3000);

        $response = $this->get(route('finance.public'));
        $response->assertOk();
        $response->assertSee('৳7,000');
    }

    public function test_negative_balance_supported(): void
    {
        $this->enableFinance();
        $this->makeMembershipWithPayments([1000]);
        $this->makeExpense(5000);

        $response = $this->get(route('finance.public'));
        $response->assertOk();
        $response->assertSee('-৳4,000');
    }

    public function test_current_month_values_correct(): void
    {
        $this->enableFinance();
        $this->makeMembershipWithPayments([2000]);
        $this->makeExpense(500, ['expense_date' => now()->toDateString()]);

        $response = $this->get(route('finance.public'));
        $response->assertOk();
        $response->assertSee(now()->format('F Y'));
    }

    public function test_yearly_summary_correct(): void
    {
        $this->enableFinance();
        $year = (int) now()->format('Y');
        $this->makeMembershipWithPayments([1000]);
        Payment::query()->update(['paid_at' => $year.'-03-15']);
        $this->makeExpense(400, ['expense_date' => $year.'-03-20']);

        $response = $this->get(route('finance.public', ['year' => $year]));
        $response->assertOk();
        $response->assertSee('March');
        $response->assertSee('৳1,000');
        $response->assertSee('৳400');
    }

    public function test_all_12_months_displayed(): void
    {
        $this->enableFinance();
        $year = (int) now()->format('Y');

        $response = $this->get(route('finance.public', ['year' => $year]));
        $response->assertOk();

        foreach (['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'] as $month) {
            $response->assertSee($month);
        }
    }

    public function test_zero_months_displayed_correctly(): void
    {
        $this->enableFinance();
        $year = (int) now()->format('Y');

        $response = $this->get(route('finance.public', ['year' => $year]));
        $response->assertOk();
        // Months with no activity show a dash, not ৳0
        $response->assertSee('—');
    }

    public function test_category_breakdown_correct(): void
    {
        $this->enableFinance();
        $events = ExpenseCategory::factory()->create(['name' => 'Events & Programs']);
        $welfare = ExpenseCategory::factory()->create(['name' => 'Welfare Activities']);
        $year = (int) now()->format('Y');

        $this->makeExpense(10000, [
            'expense_category_id' => $events->id,
            'expense_date' => now()->startOfYear()->toDateString(),
        ]);
        $this->makeExpense(7500, [
            'expense_category_id' => $welfare->id,
            'expense_date' => now()->startOfYear()->addMonth()->toDateString(),
        ]);

        $response = $this->get(route('finance.public', ['year' => $year]));
        $response->assertOk();
        $response->assertSee('Events & Programs');
        $response->assertSee('৳10,000');
        $response->assertSee('Welfare Activities');
        $response->assertSee('৳7,500');
    }

    public function test_empty_state_when_no_records(): void
    {
        $this->enableFinance();

        $response = $this->get(route('finance.public'));
        $response->assertOk();
        $response->assertSee('Financial Transparency');
    }

    // ──────────────────────────────────────────
    // PRIVACY — INDIVIDUAL RECORDS NEVER EXPOSED
    // ──────────────────────────────────────────

    public function test_public_finance_never_exposes_payment_numbers(): void
    {
        $this->enableFinance();
        $this->makeMembershipWithPayments([5000]);

        $response = $this->get(route('finance.public'));
        $response->assertOk();
        $response->assertDontSee('EDAA-PAY-');
    }

    public function test_public_finance_never_exposes_expense_numbers(): void
    {
        $this->enableFinance();
        $this->makeExpense(1000);

        $response = $this->get(route('finance.public'));
        $response->assertOk();
        $response->assertDontSee('EDAA-EXP-');
    }

    public function test_public_finance_never_exposes_member_names(): void
    {
        $this->enableFinance();
        $membership = $this->makeMembershipWithPayments([5000]);

        $response = $this->get(route('finance.public'));
        $response->assertOk();
        $response->assertDontSee($membership->alumni->full_name);
    }

    public function test_public_finance_never_exposes_membership_numbers(): void
    {
        $this->enableFinance();
        $membership = $this->makeMembershipWithPayments([5000]);

        $response = $this->get(route('finance.public'));
        $response->assertOk();
        $response->assertDontSee($membership->membership_number);
    }

    public function test_public_finance_never_exposes_payment_references(): void
    {
        $this->enableFinance();
        Payment::factory()->create([
            'amount' => 5000,
            'status' => 'paid',
            'reference' => 'Cash receipt #12345',
            'paid_at' => now()->toDateString(),
        ]);

        $response = $this->get(route('finance.public'));
        $response->assertOk();
        $response->assertDontSee('Cash receipt #12345');
    }

    public function test_public_finance_never_exposes_expense_references(): void
    {
        $this->enableFinance();
        $this->makeExpense(1000, ['reference' => 'Voucher 2026-001']);

        $response = $this->get(route('finance.public'));
        $response->assertOk();
        $response->assertDontSee('Voucher 2026-001');
    }

    public function test_public_finance_never_exposes_recorded_by(): void
    {
        $this->enableFinance();
        $this->makeExpense(1000);

        $response = $this->get(route('finance.public'));
        $response->assertOk();
        $response->assertDontSee('Recorded By');
    }

    public function test_public_finance_never_exposes_void_reasons(): void
    {
        $this->enableFinance();
        Expense::factory()->voided()->create([
            'amount' => 1000,
            'void_reason' => 'Duplicate entry — internal detail.',
        ]);

        $response = $this->get(route('finance.public'));
        $response->assertOk();
        $response->assertDontSee('Duplicate entry');
    }

    public function test_public_finance_never_exposes_expense_descriptions(): void
    {
        $this->enableFinance();
        $this->makeExpense(1000, ['description' => 'Internal audit note — confidential detail.']);

        $response = $this->get(route('finance.public'));
        $response->assertOk();
        $response->assertDontSee('Internal audit note');
    }

    public function test_public_finance_never_exposes_individual_expense_dates(): void
    {
        $this->enableFinance();
        $this->makeExpense(1000, ['expense_date' => '2026-03-15']);

        $response = $this->get(route('finance.public'));
        $response->assertOk();
        // Individual expense dates should not appear; only month labels should
        $response->assertDontSee('2026-03-15');
    }

    public function test_homepage_never_exposes_finance_data_when_disabled(): void
    {
        SiteSetting::set('public_finance_enabled', false);
        $this->makeMembershipWithPayments([8000]);
        $this->makeExpense(3000);

        $response = $this->get(route('home'));
        $response->assertOk();
        $response->assertDontSee('Total Collections');
        $response->assertDontSee('Total Expenses');
        $response->assertDontSee('Current Balance');
    }

    public function test_alumni_profile_never_exposes_finance_data(): void
    {
        $this->enableFinance();
        $this->makeMembershipWithPayments([8000]);
        $this->makeExpense(3000);

        $alumni = Alumni::query()->firstOrFail();

        $response = $this->get(route('alumni.show', $alumni));
        $response->assertOk();
        $response->assertDontSee('Total Collections');
        $response->assertDontSee('Total Expenses');
        $response->assertDontSee('Current Balance');
    }

    public function test_leaderboard_never_exposes_finance_data(): void
    {
        $this->enableFinance();
        SiteSetting::set('leaderboard_public_enabled', true);
        $this->makeMembershipWithPayments([8000]);
        $this->makeExpense(3000);

        $response = $this->get(route('leaderboard.index'));
        $response->assertOk();
        $response->assertDontSee('Total Collections');
        $response->assertDontSee('Total Expenses');
        $response->assertDontSee('Current Balance');
    }

    // ──────────────────────────────────────────
    // ADMIN AUTH
    // ──────────────────────────────────────────

    public function test_guest_cannot_toggle_public_finance(): void
    {
        auth()->logout();

        $this->post(route('admin.finance.togglePublic'))->assertRedirect(route('admin.login'));
    }

    public function test_non_admin_cannot_toggle_public_finance(): void
    {
        $this->actingAs(User::factory()->create());

        $this->post(route('admin.finance.togglePublic'))->assertForbidden();
    }

    public function test_admin_can_access_finance_page(): void
    {
        $this->actingAs($this->admin);

        $this->get(route('admin.finance.index'))->assertOk();
    }

    // ──────────────────────────────────────────
    // ADMIN TOGGLE
    // ──────────────────────────────────────────

    public function test_admin_can_enable_public_finance(): void
    {
        $this->assertFalse(SiteSetting::financePublicEnabled());

        $this->actingAs($this->admin)
            ->post(route('admin.finance.togglePublic'))
            ->assertRedirect(route('admin.finance.index'))
            ->assertSessionHas('status');

        $this->assertTrue(SiteSetting::financePublicEnabled());
    }

    public function test_admin_can_disable_public_finance(): void
    {
        $this->enableFinance();
        $this->assertTrue(SiteSetting::financePublicEnabled());

        $this->actingAs($this->admin)
            ->post(route('admin.finance.togglePublic'))
            ->assertRedirect(route('admin.finance.index'));

        $this->assertFalse(SiteSetting::financePublicEnabled());
    }

    public function test_toggle_requires_admin_auth(): void
    {
        $this->post(route('admin.finance.togglePublic'))
            ->assertRedirect('/admin/login');
    }

    public function test_toggle_state_persists(): void
    {
        $this->actingAs($this->admin);

        // Enable
        $this->post(route('admin.finance.togglePublic'));
        $this->assertTrue(SiteSetting::financePublicEnabled());

        // Verify still enabled on fresh request
        $this->get(route('admin.finance.index'))
            ->assertOk()
            ->assertSee('Enabled');

        // Disable
        $this->post(route('admin.finance.togglePublic'));
        $this->assertFalse(SiteSetting::financePublicEnabled());

        // Verify still disabled on fresh request
        $this->get(route('admin.finance.index'))
            ->assertOk()
            ->assertSee('Disabled');
    }

    public function test_public_route_follows_toggle_state(): void
    {
        $this->actingAs($this->admin);

        // Disabled → 404
        $this->post(route('admin.finance.togglePublic')); // enable
        $this->post(route('admin.finance.togglePublic')); // disable
        $this->get(route('finance.public'))->assertNotFound();

        // Enabled → 200
        $this->post(route('admin.finance.togglePublic')); // enable
        $this->get(route('finance.public'))->assertOk();
    }

    public function test_navbar_follows_toggle_state(): void
    {
        // Disabled — no finance link
        $response = $this->get(route('home'));
        $response->assertDontSee(route('finance.public'), escape: false);

        // Enable
        $this->actingAs($this->admin)
            ->post(route('admin.finance.togglePublic'));

        // Enabled — finance link present
        $response = $this->get(route('home'));
        $response->assertSee(route('finance.public'), escape: false);

        // Disable again
        $this->actingAs($this->admin)
            ->post(route('admin.finance.togglePublic'));

        // Disabled — finance link gone
        $response = $this->get(route('home'));
        $response->assertDontSee(route('finance.public'), escape: false);
    }

    public function test_admin_finance_page_shows_preview_link_when_enabled(): void
    {
        $this->enableFinance();

        $this->actingAs($this->admin)
            ->get(route('admin.finance.index'))
            ->assertOk()
            ->assertSee('View Public Finance');
    }

    public function test_admin_finance_page_hides_preview_link_when_disabled(): void
    {
        SiteSetting::set('public_finance_enabled', false);

        $this->actingAs($this->admin)
            ->get(route('admin.finance.index'))
            ->assertOk()
            ->assertDontSee('View Public Finance');
    }

    // ──────────────────────────────────────────
    // FINANCIAL REGRESSION
    // ──────────────────────────────────────────

    public function test_feature_13_payment_totals_unchanged(): void
    {
        $before = Payment::collectionTotals();

        $this->makeMembershipWithPayments([1000]);
        $after = Payment::collectionTotals();

        $this->assertSame($before['total'] + 1000.0, $after['total']);
        $this->assertSame($before['count'] + 1, $after['count']);
    }

    public function test_feature_14_leaderboard_unchanged(): void
    {
        $leaderboard = new LeaderboardService;
        $membership = $this->makeMembershipWithPayments([10000]);

        $before = $leaderboard->topContributors(5);
        $this->assertSame(10000.0, $before->first()->verified_total_float);

        $this->makeExpense(5000);

        $after = $leaderboard->topContributors(5);
        $this->assertSame(10000.0, $after->first()->verified_total_float);
    }

    public function test_feature_15_finance_service_calculations_unchanged(): void
    {
        $finance = new FinanceService;

        $this->makeMembershipWithPayments([5000]);
        $this->makeExpense(1500);

        $this->assertSame(5000.0, $finance->totalCollections());
        $this->assertSame(1500.0, $finance->totalExpenses());
        $this->assertSame(3500.0, $finance->currentBalance());
    }

    // ──────────────────────────────────────────
    // SETTINGS
    // ──────────────────────────────────────────

    public function test_setting_default_is_false(): void
    {
        // The setting should default to false when not set
        $this->assertFalse(SiteSetting::financePublicEnabled());
    }

    public function test_setting_persists_value(): void
    {
        SiteSetting::set('public_finance_enabled', true);
        $this->assertTrue(SiteSetting::financePublicEnabled());

        SiteSetting::set('public_finance_enabled', false);
        $this->assertFalse(SiteSetting::financePublicEnabled());
    }

    public function test_setting_is_unique(): void
    {
        SiteSetting::set('public_finance_enabled', true);
        SiteSetting::set('public_finance_enabled', false);

        $count = SiteSetting::query()->where('key', 'public_finance_enabled')->count();
        $this->assertSame(1, $count);
    }

    // ──────────────────────────────────────────
    // SEO
    // ──────────────────────────────────────────

    public function test_public_finance_page_has_seo_metadata(): void
    {
        $this->enableFinance();

        $response = $this->get(route('finance.public'));
        $response->assertOk();
        $response->assertSee('Financial Transparency', escape: false);
        $response->assertSee('og:title', escape: false);
        $response->assertSee('og:description', escape: false);
        $response->assertSee('twitter:card', escape: false);
    }

    public function test_disabled_finance_does_not_expose_seo(): void
    {
        SiteSetting::set('public_finance_enabled', false);

        $this->get(route('finance.public'))->assertNotFound();
    }

    // ──────────────────────────────────────────
    // TRANSPARENCY STATEMENT
    // ──────────────────────────────────────────

    public function test_transparency_statement_present(): void
    {
        $this->enableFinance();

        $response = $this->get(route('finance.public'));
        $response->assertOk();
        $response->assertSee('About This Page');
        $response->assertSee('aggregate records');
        $response->assertSee('not publicly disclosed');
    }

    public function test_last_updated_indicator_present_when_records_exist(): void
    {
        $this->enableFinance();
        $this->makeMembershipWithPayments([1000]);

        $response = $this->get(route('finance.public'));
        $response->assertOk();
        $response->assertSee('Financial data updated through');
    }

    public function test_last_updated_absent_when_no_records(): void
    {
        $this->enableFinance();

        $response = $this->get(route('finance.public'));
        $response->assertOk();
        $response->assertDontSee('Financial data updated through');
    }
}
