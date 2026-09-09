<?php

namespace Tests\Feature;

use App\Enums\PaymentStatus;
use App\Models\Alumni;
use App\Models\FeePlan;
use App\Models\Membership;
use App\Models\MembershipTier;
use App\Models\MembershipType;
use App\Models\Payment;
use App\Models\User;
use Database\Seeders\AlumniSeeder;
use Database\Seeders\FeePlanSeeder;
use Database\Seeders\MembershipSeeder;
use Database\Seeders\MembershipTypeSeeder;
use Database\Seeders\PaymentSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class PaymentFinancialsTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->admin()->create(['password' => Hash::make('password')]);
        $this->actingAs($this->admin);
        $this->seed(MembershipTypeSeeder::class);
    }

    protected function makePlan(array $attributes = []): FeePlan
    {
        return FeePlan::factory()->current()->create($attributes);
    }

    protected function makeMembership(MembershipType|int $type): Membership
    {
        $typeId = $type instanceof MembershipType ? $type->id : $type;

        return Membership::factory()->active()->create(['membership_type_id' => $typeId]);
    }

    // ──────────────────────────────────────────
    // CALCULATIONS
    // ──────────────────────────────────────────

    public function test_full_payment_produces_zero_outstanding(): void
    {
        $plan = $this->makePlan(['amount' => 1000]);
        $membership = $this->makeMembership($plan->membership_type_id);

        Payment::factory()->paid()->forMembership($membership)->create([
            'fee_plan_id' => $plan->id,
            'amount' => 1000,
        ]);

        $obligation = Payment::obligationFor($membership->id, $plan);
        $this->assertEquals(1000.0, $obligation['collected']);
        $this->assertEquals(0.0, $obligation['outstanding']);
        $this->assertEquals(0.0, $obligation['overpaid']);
    }

    public function test_partial_payment_produces_correct_outstanding(): void
    {
        $plan = $this->makePlan(['amount' => 1000]);
        $membership = $this->makeMembership($plan->membership_type_id);

        Payment::factory()->partial()->create([
            'membership_id' => $membership->id,
            'fee_plan_id' => $plan->id,
            'amount' => 400,
        ]);

        $obligation = Payment::obligationFor($membership->id, $plan);
        $this->assertEquals(400.0, $obligation['collected']);
        $this->assertEquals(600.0, $obligation['outstanding']);
    }

    public function test_multiple_payments_aggregate_correctly(): void
    {
        $plan = $this->makePlan(['amount' => 1000]);
        $membership = $this->makeMembership($plan->membership_type_id);

        foreach ([[300, 'paid'], [300, 'paid'], [400, 'paid']] as [$amount, $status]) {
            Payment::factory()->create([
                'membership_id' => $membership->id,
                'fee_plan_id' => $plan->id,
                'amount' => $amount,
                'status' => $status,
            ]);
        }

        $obligation = Payment::obligationFor($membership->id, $plan);
        $this->assertEquals(1000.0, $obligation['collected']);
        $this->assertEquals(0.0, $obligation['outstanding']);
    }

    public function test_void_payment_excluded_from_collections_and_outstanding(): void
    {
        $plan = $this->makePlan(['amount' => 500]);
        $membership = $this->makeMembership($plan->membership_type_id);

        Payment::factory()->void()->create([
            'membership_id' => $membership->id,
            'fee_plan_id' => $plan->id,
            'amount' => 500,
        ]);

        $obligation = Payment::obligationFor($membership->id, $plan);
        $this->assertEquals(0.0, $obligation['collected']);
        $this->assertEquals(500.0, $obligation['outstanding']);
        $this->assertEquals(0.0, (float) Payment::valid()->sum('amount'));
    }

    public function test_waived_payment_clears_obligation_but_counts_no_cash(): void
    {
        $plan = $this->makePlan(['amount' => 500]);
        $membership = $this->makeMembership($plan->membership_type_id);

        Payment::factory()->waived()->create([
            'membership_id' => $membership->id,
            'fee_plan_id' => $plan->id,
            'amount' => 0,
        ]);

        $obligation = Payment::obligationFor($membership->id, $plan);
        $this->assertTrue($obligation['waived']);
        // Waived is not collected cash…
        $this->assertEquals(0.0, $obligation['collected']);
        // …but the obligation is intentionally cleared.
        $this->assertEquals(0.0, $obligation['outstanding']);
        $this->assertEquals(0.0, (float) Payment::collectionTotals()['total']);
    }

    public function test_partial_amount_counts_toward_collections_total(): void
    {
        $plan = $this->makePlan();
        Payment::factory()->partial()->create([
            'fee_plan_id' => $plan->id,
            'amount' => 250,
        ]);
        Payment::factory()->paid()->create([
            'fee_plan_id' => $plan->id,
            'amount' => 750,
        ]);
        Payment::factory()->waived()->create(['fee_plan_id' => $plan->id]);
        Payment::factory()->void()->create(['fee_plan_id' => $plan->id]);

        $totals = Payment::collectionTotals();
        $this->assertEquals(1000.0, $totals['total']);
        $this->assertSame(2, $totals['count']);
    }

    public function test_overpayment_detected_correctly(): void
    {
        $plan = $this->makePlan(['amount' => 500]);
        $membership = $this->makeMembership($plan->membership_type_id);

        Payment::factory()->paid()->create([
            'membership_id' => $membership->id,
            'fee_plan_id' => $plan->id,
            'amount' => 700,
        ]);

        $obligation = Payment::obligationFor($membership->id, $plan);
        $this->assertEquals(700.0, $obligation['collected']);
        $this->assertEquals(0.0, $obligation['outstanding']);
        $this->assertEquals(200.0, $obligation['overpaid']);
    }

    public function test_membership_without_applicable_fee_has_no_fake_outstanding(): void
    {
        // Honorary type with no active fee plan at all.
        $honorary = MembershipType::query()->where('slug', 'honorary-member')->firstOrFail();
        $membership = $this->makeMembership($honorary->id);

        $stats = Payment::outstandingAndPaidMembers();
        $this->assertEquals(0.0, $stats['total']);
        $this->assertSame(0, $stats['paid_members']);
    }

    // ──────────────────────────────────────────
    // HISTORICAL INTEGRITY
    // ──────────────────────────────────────────

    public function test_expired_historical_fee_plan_is_selectable_for_payment(): void
    {
        $plan = $this->makePlan([
            'amount' => 50,
            'effective_from' => now()->subYear()->toDateString(),
            'effective_until' => now()->subMonths(6)->toDateString(),
        ]);
        $membership = $this->makeMembership($plan->membership_type_id);

        $response = $this->post(route('admin.payments.store'), [
            'membership_id' => $membership->id,
            'fee_plan_id' => $plan->id,
            'amount' => '50',
            'status' => PaymentStatus::Paid->value,
            'paid_at' => now()->toDateString(),
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('payments', ['membership_id' => $membership->id, 'fee_plan_id' => $plan->id]);
    }

    public function test_changing_current_fee_does_not_modify_old_payments(): void
    {
        $oldPlan = $this->makePlan(['name' => 'Old Plan', 'amount' => 50]);
        $typeId = $oldPlan->membership_type_id;
        $membership = $this->makeMembership($typeId);

        $payment = Payment::factory()->paid()->create([
            'membership_id' => $membership->id,
            'fee_plan_id' => $oldPlan->id,
            'amount' => 50,
        ]);

        // Admin raises the current fee afterwards via a NEW plan.
        $newPlan = $this->makePlan(['name' => 'New Raised Plan', 'amount' => 100]);

        $payment->refresh();
        $this->assertSame($oldPlan->id, $payment->fee_plan_id);
        $this->assertEquals('50.00', $payment->amount);
        $this->assertNotSame($newPlan->id, $payment->fee_plan_id);

        // Old payment still references the historical plan and amount.
        $this->get(route('admin.payments.show', $payment))
            ->assertOk()
            ->assertSee($oldPlan->name)
            ->assertSee('৳50');
    }

    // ──────────────────────────────────────────
    // MEMBERSHIP INTEGRATION
    // ──────────────────────────────────────────

    public function test_membership_page_shows_fee_and_payment_summary(): void
    {
        $this->actingAs($this->admin);

        $plan = $this->makePlan(['amount' => 1000]);
        $membership = $this->makeMembership($plan->membership_type_id);

        Payment::factory()->partial()->create([
            'membership_id' => $membership->id,
            'fee_plan_id' => $plan->id,
            'amount' => 600,
            'reference' => 'SUMMARY-REF-1',
        ]);

        $response = $this->get(route('admin.members.show', $membership));
        $response->assertOk();
        $response->assertSee('Expected (Current Fee)');
        $response->assertSee('৳1,000');   // expected / outstanding context
        $response->assertSee('৳600');     // total collected
        $response->assertSee('৳400');     // outstanding
        $response->assertSee('SUMMARY-REF-1');
        $response->assertSee('Record Payment');
        $response->assertSee('View Payment History');
    }

    public function test_membership_page_shows_overpayment_warning(): void
    {
        $plan = $this->makePlan(['amount' => 500]);
        $membership = $this->makeMembership($plan->membership_type_id);

        Payment::factory()->paid()->create([
            'membership_id' => $membership->id,
            'fee_plan_id' => $plan->id,
            'amount' => 700,
        ]);

        $this->get(route('admin.members.show', $membership))
            ->assertOk()
            ->assertSee('Overpaid by ৳200');
    }

    public function test_membership_delete_blocked_when_payments_exist(): void
    {
        $plan = $this->makePlan();
        $membership = $this->makeMembership($plan->membership_type_id);
        $payment = Payment::factory()->paid()->forMembership($membership)->create();

        $this->delete(route('admin.members.destroy', $membership))
            ->assertRedirect()
            ->assertSessionHas('error');

        $this->assertDatabaseHas('memberships', ['id' => $membership->id]);
        $this->assertDatabaseHas('payments', ['id' => $payment->id]);
    }

    // ──────────────────────────────────────────
    // DASHBOARD
    // ──────────────────────────────────────────

    public function test_dashboard_financial_summary_calculations(): void
    {
        $generalPlan = $this->makePlan(['amount' => 100, 'membership_type_id' => MembershipType::where('slug', 'general-member')->value('id')]);
        $execType = MembershipType::where('slug', 'executive-committee-member')->firstOrFail();
        $execPlan = $this->makePlan(['amount' => 100, 'membership_type_id' => $execType->id]);

        // Paid member (fully settled).
        $settled = $this->makeMembership($generalPlan->membership_type_id);
        Payment::factory()->paid()->create([
            'membership_id' => $settled->id,
            'fee_plan_id' => $generalPlan->id,
            'amount' => 100,
            'paid_at' => now()->toDateString(),
        ]);

        // Partial member: 60 collected, 40 outstanding. 35 days ago always
        // lands in a previous calendar month, keeping the monthly assertion
        // deterministic.
        $partialMember = $this->makeMembership($generalPlan->membership_type_id);
        Payment::factory()->partial()->create([
            'membership_id' => $partialMember->id,
            'fee_plan_id' => $generalPlan->id,
            'amount' => 60,
            'paid_at' => now()->subDays(35),
        ]);

        // Waived exec member — no cash, no outstanding.
        $waivedMember = $this->makeMembership($execType->id);
        Payment::factory()->waived()->create([
            'membership_id' => $waivedMember->id,
            'fee_plan_id' => $execPlan->id,
        ]);

        // Void payment — excluded everywhere.
        Payment::factory()->void()->create([
            'membership_id' => $settled->id,
            'fee_plan_id' => $generalPlan->id,
            'amount' => 999,
        ]);

        // Honorary membership without any plan: must add nothing.
        $this->makeMembership(MembershipType::where('slug', 'honorary-member')->value('id'));

        $response = $this->get(route('admin.dashboard'));
        $response->assertOk();

        $this->assertEquals(160.0, $response->viewData('totalCollections')); // 100 + 60
        $this->assertEquals(100.0, $response->viewData('collectionsThisMonth')); // only today's ৳100; partial was 10 days ago this month? see below
        $this->assertEquals(40.0, $response->viewData('outstandingFees'));
        $this->assertSame(1, $response->viewData('paidMembers'));

        // Suspended/cancelled memberships never owe or count as paid.
        $suspended = Membership::factory()->suspended()->create(['membership_type_id' => $generalPlan->membership_type_id]);
        Payment::factory()->paid()->create([
            'membership_id' => $suspended->id,
            'fee_plan_id' => $generalPlan->id,
            'amount' => 100,
        ]);
        $stats = Payment::outstandingAndPaidMembers();
        $this->assertSame(1, $stats['paid_members']); // unchanged
        $this->assertEquals(40.0, $stats['total']);   // unchanged
    }

    // ──────────────────────────────────────────
    // PRIVACY
    // ──────────────────────────────────────────

    public function test_public_alumni_profile_never_exposes_payment_data(): void
    {
        $alumnus = Alumni::factory()->create(['status' => 'active']);
        $tier = MembershipTier::factory()->create(['name' => 'Gold', 'badge_label' => 'Gold']);
        $membership = Membership::factory()->active()->public()->create([
            'alumni_id' => $alumnus->id,
            'membership_type_id' => MembershipType::where('slug', 'general-member')->value('id'),
            'membership_tier_id' => $tier->id,
        ]);

        $plan = $this->makePlan(['amount' => 9999, 'membership_type_id' => $membership->membership_type_id]);
        $payment = Payment::factory()->paid()->create([
            'membership_id' => $membership->id,
            'fee_plan_id' => $plan->id,
            'notes' => 'SECRET-PAYMENT-NOTE-42',
        ]);

        $public = $this->get(route('alumni.show', $alumnus));
        $public->assertOk();

        $content = $public->getContent();
        $this->assertStringNotContainsString((string) $payment->payment_number, $content);
        $this->assertStringNotContainsString('SECRET-PAYMENT-NOTE-42', $content);
        $this->assertStringNotContainsString('Outstanding', $content);
        $this->assertStringNotContainsString('Total Collected', $content);

        // The Feature 11 badge remains intact.
        $public->assertSee('Gold Member');
    }

    // ──────────────────────────────────────────
    // SEEDING
    // ──────────────────────────────────────────

    public function test_payment_seeder_creates_realistic_records_and_is_idempotent(): void
    {
        // Build the prerequisites the seeder expects: membership types, fee
        // plans, alumni, and memberships for the named demo members.
        $this->seed(MembershipTypeSeeder::class);
        $this->seed(FeePlanSeeder::class);
        $this->seed(AlumniSeeder::class);
        $this->seed(MembershipSeeder::class);

        $this->seed(PaymentSeeder::class);

        // Full, two-partials-same-plan, monthly paid, waived, and void exist.
        $this->assertTrue(Payment::query()->paid()->exists());
        $this->assertTrue(Payment::query()->partial()->count() >= 2);
        $this->assertTrue(Payment::query()->waived()->exists());
        $this->assertTrue(Payment::query()->void()->exists());
        $this->assertTrue(Payment::query()->whereNotNull('voided_at')->whereNotNull('void_reason')->exists());

        $numbers = Payment::query()->pluck('payment_number');
        $this->assertSame($numbers->count(), $numbers->unique()->count());

        $countAfterFirstRun = Payment::count();

        // Re-running must not duplicate anything.
        $this->seed(PaymentSeeder::class);
        $this->assertSame($countAfterFirstRun, Payment::count());
    }
}
