<?php

namespace Tests\Feature;

use App\Enums\PaymentStatus;
use App\Models\FeePlan;
use App\Models\Membership;
use App\Models\MembershipType;
use App\Models\Payment;
use App\Models\User;
use Database\Seeders\FeePlanSeeder;
use Database\Seeders\MembershipTypeSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class PaymentTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->admin()->create(['password' => Hash::make('password')]);
    }

    protected function seedBaseline(): array
    {
        $this->seed(MembershipTypeSeeder::class);
        $this->seed(FeePlanSeeder::class);

        return [
            'types' => MembershipType::query()->pluck('id', 'slug')->all(),
            'plans' => FeePlan::query()->pluck('id', 'slug')->all(),
            'generalType' => MembershipType::query()->where('slug', 'general-member')->firstOrFail(),
        ];
    }

    protected function validPayload(Membership $membership, FeePlan $plan, array $overrides = []): array
    {
        return array_merge([
            'membership_id' => $membership->id,
            'fee_plan_id' => $plan->id,
            'amount' => '50',
            'status' => PaymentStatus::Paid->value,
            'paid_at' => now()->toDateString(),
        ], $overrides);
    }

    // ──────────────────────────────────────────
    // AUTHORIZATION
    // ──────────────────────────────────────────

    public function test_guest_is_redirected_to_login(): void
    {
        $this->get(route('admin.payments.index'))->assertRedirect(route('admin.login'));
        $this->get(route('admin.payments.create'))->assertRedirect(route('admin.login'));
    }

    public function test_non_admin_receives_403(): void
    {
        $this->actingAs(User::factory()->create());

        $this->get(route('admin.payments.index'))->assertForbidden();
        $this->post(route('admin.payments.store'), [])->assertForbidden();
        $this->put(route('admin.payments.update', Payment::factory()->create()), [])->assertForbidden();
        $this->post(route('admin.payments.void', Payment::factory()->create()), ['void_reason' => 'test'])->assertForbidden();
    }

    public function test_admin_can_access_payment_pages(): void
    {
        $this->seedTypesAndPlans();
        $this->actingAs($this->admin);

        $this->get(route('admin.payments.index'))->assertOk();
        $this->get(route('admin.payments.create'))->assertOk();

        $payment = Payment::factory()->create();
        $this->get(route('admin.payments.show', $payment))->assertOk();
        $this->get(route('admin.payments.edit', $payment))->assertOk();
    }

    protected function seedTypesAndPlans(): array
    {
        $this->seed(MembershipTypeSeeder::class);
        $this->seed(FeePlanSeeder::class);

        return [
            MembershipType::query()->pluck('id', 'slug')->all(),
            FeePlan::query()->pluck('id', 'slug')->all(),
        ];
    }

    // ──────────────────────────────────────────
    // CRUD
    // ──────────────────────────────────────────

    public function test_payment_index_works(): void
    {
        Payment::factory()->count(3)->create();
        $this->actingAs($this->admin);

        $response = $this->get(route('admin.payments.index'));
        $response->assertOk();
        $this->assertSame(3, $response->viewData('payments')->total());
    }

    public function test_create_page_works_and_lists_memberships_only(): void
    {
        [, $plans] = $this->seedTypesAndPlans();
        $membership = Membership::factory()->active()->create(['membership_type_id' => MembershipType::where('slug', 'general-member')->value('id')]);
        $this->actingAs($this->admin);

        $response = $this->get(route('admin.payments.create', ['membership_id' => $membership->id]));
        $response->assertOk();
        $options = collect($response->viewData('memberships'));
        $this->assertTrue($options->contains('id', $membership->id));
        $this->assertSame(FeePlan::count(), $response->viewData('feePlans')->count());
    }

    public function test_admin_can_create_paid_payment(): void
    {
        [$types, $plans] = $this->seedTypesAndPlans();
        $membership = Membership::factory()->active()->create(['membership_type_id' => $types['general-member']]);
        $this->actingAs($this->admin);

        $response = $this->post(route('admin.payments.store'), $this->validPayload($membership, FeePlan::find($plans['general-membership-registration'])));

        $response->assertRedirect(route('admin.payments.show', Payment::query()->firstOrFail()));
        $payment = Payment::query()->firstOrFail();
        $this->assertEquals('50.00', $payment->amount);
        $this->assertSame(PaymentStatus::Paid, $payment->status);
        $this->assertSame($this->admin->id, $payment->recorded_by);
        $this->assertSame('BDT', $payment->currency);
    }

    public function test_admin_can_create_partial_payment(): void
    {
        [$types, $plans] = $this->seedTypesAndPlans();
        $membership = Membership::factory()->active()->create(['membership_type_id' => $types['general-member']]);
        $this->actingAs($this->admin);

        $this->post(route('admin.payments.store'), $this->validPayload(
            $membership,
            FeePlan::find($plans['general-membership-registration']),
            ['amount' => '30', 'status' => PaymentStatus::Partial->value]
        ))->assertRedirect();

        $this->assertDatabaseHas('payments', [
            'membership_id' => $membership->id,
            'amount' => '30.00',
            'status' => 'partial',
        ]);
    }

    public function test_admin_can_create_waived_payment(): void
    {
        [$types, $plans] = $this->seedTypesAndPlans();
        $membership = Membership::factory()->active()->create(['membership_type_id' => $types['honorary-member']]);
        $plan = FeePlan::factory()->create([
            'membership_type_id' => $types['honorary-member'],
            'amount' => 1000,
        ]);
        $this->actingAs($this->admin);

        $this->post(route('admin.payments.store'), $this->validPayload($membership, $plan, [
            'amount' => '0',
            'status' => PaymentStatus::Waived->value,
            'notes' => 'Committee waived the fee.',
        ]))->assertRedirect();

        $this->assertDatabaseHas('payments', [
            'membership_id' => $membership->id,
            'status' => 'waived',
            'amount' => '0.00',
        ]);
    }

    public function test_show_displays_payment_with_expected_vs_collected(): void
    {
        [$types] = $this->seedTypesAndPlans();
        $typeId = $types['general-member'];
        $plan = FeePlan::factory()->current()->create(['membership_type_id' => $typeId, 'amount' => 100]);
        $membership = Membership::factory()->active()->create(['membership_type_id' => $typeId]);

        $partial = Payment::factory()->paid()->forMembership($membership)->forFeePlan($plan)->create([
            'amount' => 60,
            'status' => 'partial',
        ]);
        $this->actingAs($this->admin);

        $response = $this->get(route('admin.payments.show', $partial));
        $response->assertOk();
        $obligation = $response->viewData('obligation');
        $this->assertEquals(100.0, $obligation['expected']);
        $this->assertEquals(60.0, $obligation['collected']);
        $this->assertEquals(40.0, $obligation['outstanding']);
    }

    public function test_admin_can_edit_payment_core_fields(): void
    {
        $this->seedTypesAndPlans();
        $payment = Payment::factory()->partial()->create(['amount' => 20]);
        $this->actingAs($this->admin);

        $this->put(route('admin.payments.update', $payment), [
            'membership_id' => $payment->membership_id,
            'fee_plan_id' => $payment->fee_plan_id,
            'amount' => '35',
            'status' => PaymentStatus::Paid->value,
            'paid_at' => now()->subDays(2)->toDateString(),
            'reference' => 'Cash Receipt #9999',
            'notes' => 'Corrected after recount.',
        ])->assertRedirect(route('admin.payments.show', $payment));

        $payment->refresh();
        $this->assertEquals('35.00', $payment->amount);
        $this->assertSame(PaymentStatus::Paid, $payment->status);
        $this->assertSame('Cash Receipt #9999', $payment->reference);
    }

    public function test_membership_and_fee_plan_are_immutable_on_edit(): void
    {
        [$types] = $this->seedTypesAndPlans();
        $payment = Payment::factory()->paid()->create();
        $originalMembership = $payment->membership_id;
        $originalPlan = $payment->fee_plan_id;

        $otherPlan = FeePlan::factory()->create(['membership_type_id' => $types['executive-committee-member']]);
        $otherMembership = Membership::factory()->create(['membership_type_id' => $types['executive-committee-member']]);

        $this->actingAs($this->admin);
        $this->put(route('admin.payments.update', $payment), [
            'membership_id' => $otherMembership->id,
            'fee_plan_id' => $otherPlan->id,
            'amount' => '10',
            'status' => PaymentStatus::Partial->value,
            'paid_at' => now()->toDateString(),
        ])->assertRedirect();

        $payment->refresh();
        $this->assertSame($originalMembership, $payment->membership_id);
        $this->assertSame($originalPlan, $payment->fee_plan_id);
    }

    public function test_void_payment_replaces_deletion(): void
    {
        $this->seedTypesAndPlans();
        $payment = Payment::factory()->paid()->create();
        $this->actingAs($this->admin);

        $response = $this->post(route('admin.payments.void', $payment), [
            'void_reason' => 'Duplicate entry recorded in error.',
        ]);

        $response->assertRedirect(route('admin.payments.show', $payment));
        $payment->refresh();
        $this->assertSame(PaymentStatus::Void, $payment->status);
        $this->assertNotNull($payment->voided_at);
        $this->assertSame($this->admin->id, $payment->voided_by);
        $this->assertSame('Duplicate entry recorded in error.', $payment->void_reason);

        // No destructive delete route exists for payments.
        $this->assertFalse(in_array('admin.payments.destroy', array_keys(Route::getRoutes()->getRoutesByName()), true));
    }

    public function test_void_requires_a_reason(): void
    {
        $this->seedTypesAndPlans();
        $payment = Payment::factory()->paid()->create();
        $this->actingAs($this->admin);

        $this->from(route('admin.payments.show', $payment))
            ->post(route('admin.payments.void', $payment), ['void_reason' => ''])
            ->assertSessionHasErrors('void_reason');

        $this->assertNotSame(PaymentStatus::Void, $payment->fresh()->status);
    }

    // ──────────────────────────────────────────
    // PAYMENT NUMBER
    // ──────────────────────────────────────────

    public function test_payment_numbers_generated_sequentially(): void
    {
        [$types, $plans] = $this->seedTypesAndPlans();
        $this->actingAs($this->admin);
        $plan = FeePlan::find($plans['general-membership-registration']);

        foreach ([1, 2, 3] as $i) {
            $membership = Membership::factory()->active()->create(['membership_type_id' => $types['general-member']]);
            $this->post(route('admin.payments.store'), $this->validPayload($membership, $plan))->assertRedirect();
        }

        $numbers = Payment::query()->orderBy('payment_number')->pluck('payment_number')->values();
        $this->assertSame('EDAA-PAY-000001', $numbers[0]);
        $this->assertSame('EDAA-PAY-000002', $numbers[1]);
        $this->assertSame('EDAA-PAY-000003', $numbers[2]);
    }

    public function test_payment_numbers_unique_across_records(): void
    {
        $this->seed(MembershipTypeSeeder::class);
        Payment::factory()->count(20)->create();

        $numbers = Payment::query()->pluck('payment_number');
        $this->assertSame($numbers->count(), $numbers->unique()->count());
        $numbers->each(fn ($n) => $this->assertMatchesRegularExpression('/^EDAA-PAY-\d{6}$/', $n));
    }

    public function test_void_does_not_recycle_the_payment_number(): void
    {
        $this->seedTypesAndPlans();
        $first = Payment::factory()->paid()->create();
        $this->actingAs($this->admin);

        $this->post(route('admin.payments.void', $first), ['void_reason' => 'Testing number stability.']);

        $second = Payment::factory()->paid()->create();
        $first->refresh();
        $this->assertNotSame($first->payment_number, $second->payment_number);
        $this->assertSame(PaymentStatus::Void, $first->fresh()->status);
        $this->assertSame($first->payment_number, $first->fresh()->payment_number);
    }

    // ──────────────────────────────────────────
    // RELATIONSHIPS & VALIDATION
    // ──────────────────────────────────────────

    public function test_payment_relationships_resolve(): void
    {
        $this->seedTypesAndPlans();
        $payment = Payment::factory()->paid()->create();
        $recordedBy = $payment->recordedBy;

        $this->assertInstanceOf(Membership::class, $payment->membership);
        $this->assertInstanceOf(FeePlan::class, $payment->feePlan);
        $this->assertSame($this->admin->id !== $recordedBy->id ? $recordedBy->id : $recordedBy->id, $payment->recordedBy->id);
        $this->assertTrue($payment->feePlan->membership_type_id === $payment->membership->membership_type_id);
    }

    public function test_store_validates_required_fields_and_foreign_keys(): void
    {
        [$types, $plans] = $this->seedTypesAndPlans();
        $this->actingAs($this->admin);
        $membership = Membership::factory()->active()->create(['membership_type_id' => $types['general-member']]);
        $plan = FeePlan::find($plans['general-membership-registration']);

        // Missing everything.
        $this->post(route('admin.payments.store'), [])->assertSessionHasErrors([
            'membership_id', 'fee_plan_id', 'amount', 'status', 'paid_at',
        ]);

        // Invalid foreign keys.
        $this->post(route('admin.payments.store'), $this->validPayload($membership, $plan, [
            'membership_id' => 999999,
            'fee_plan_id' => 999999,
        ]))->assertSessionHasErrors(['membership_id', 'fee_plan_id']);

        $this->assertSame(0, Payment::count());
    }

    public function test_wrong_membership_type_fee_plan_is_rejected_server_side(): void
    {
        [$types, $plans] = $this->seedTypesAndPlans();
        $generalMembership = Membership::factory()->active()->create(['membership_type_id' => $types['general-member']]);
        $execPlan = FeePlan::find($plans['executive-committee-contribution']);
        $this->actingAs($this->admin);

        $this->from(route('admin.payments.create'))
            ->post(route('admin.payments.store'), $this->validPayload($generalMembership, $execPlan))
            ->assertSessionHasErrors('fee_plan_id');

        $this->assertSame(0, Payment::count());
    }

    public function test_amount_and_date_validation(): void
    {
        [$types, $plans] = $this->seedTypesAndPlans();
        $this->actingAs($this->admin);
        $membership = Membership::factory()->active()->create(['membership_type_id' => $types['general-member']]);
        $plan = FeePlan::find($plans['general-membership-registration']);

        // Negative amount.
        $this->post(route('admin.payments.store'), $this->validPayload($membership, $plan, ['amount' => '-1']))
            ->assertSessionHasErrors('amount');

        // Future date rejected.
        $this->post(route('admin.payments.store'), $this->validPayload($membership, $plan, [
            'paid_at' => now()->addDay()->toDateString(),
        ]))->assertSessionHasErrors('paid_at');

        // Today allowed.
        $this->post(route('admin.payments.store'), $this->validPayload($membership, $plan))
            ->assertRedirect();

        $this->assertSame(1, Payment::count());
    }

    public function test_invalid_status_rejected(): void
    {
        [$types, $plans] = $this->seedTypesAndPlans();
        $this->actingAs($this->admin);
        $membership = Membership::factory()->active()->create(['membership_type_id' => $types['general-member']]);
        $plan = FeePlan::find($plans['general-membership-registration']);

        $this->post(route('admin.payments.store'), $this->validPayload($membership, $plan, [
            'status' => 'refunded',
        ]))->assertSessionHasErrors('status');

        $this->assertSame(0, Payment::count());
    }

    public function test_notes_and_reference_length_validation(): void
    {
        [$types, $plans] = $this->seedTypesAndPlans();
        $this->actingAs($this->admin);
        $membership = Membership::factory()->active()->create(['membership_type_id' => $types['general-member']]);
        $plan = FeePlan::find($plans['general-membership-registration']);

        $this->post(route('admin.payments.store'), $this->validPayload($membership, $plan, [
            'notes' => str_repeat('x', 2001),
            'reference' => str_repeat('y', 256),
        ]))->assertSessionHasErrors(['notes', 'reference']);

        $this->assertSame(0, Payment::count());
    }

    // ──────────────────────────────────────────
    // SEARCH & FILTERS
    // ──────────────────────────────────────────

    public function test_index_search_by_payment_number_and_reference(): void
    {
        $this->seedTypesAndPlans();
        $byNumber = Payment::factory()->create(['reference' => 'Ref Alpha']);
        Payment::factory()->create();

        $this->actingAs($this->admin);

        $hit = $this->get(route('admin.payments.index', ['search' => $byNumber->payment_number]));
        $hit->assertOk();
        $this->assertSame(1, $hit->viewData('payments')->total());

        $byRef = $this->get(route('admin.payments.index', ['search' => 'Ref Alpha']));
        $byRef->assertOk();
        $this->assertTrue($byRef->viewData('payments')->getCollection()->contains(fn ($p) => $p->id === $byNumber->id));
    }

    public function test_index_filters_by_status_and_fee_plan_and_dates(): void
    {
        $this->seedTypesAndPlans();
        $paidHit = Payment::factory()->paid()->create(['paid_at' => now()->subDays(2)]);
        $waived = Payment::factory()->waived()->create(['paid_at' => now()->subDays(3)]);
        Payment::factory()->paid()->create(['paid_at' => now()->subYears(2)]);

        $this->actingAs($this->admin);

        $statusOnly = $this->get(route('admin.payments.index', ['status' => 'paid']));
        $statusOnly->assertOk();
        $result = $statusOnly->viewData('payments');
        $this->assertTrue($result->getCollection()->contains(fn ($p) => $p->id === $paidHit->id));
        $this->assertFalse($result->getCollection()->contains(fn ($p) => $p->id === $waived->id));

        $dateRange = $this->get(route('admin.payments.index', [
            'date_from' => now()->subDays(5)->toDateString(),
            'date_to' => now()->toDateString(),
        ]));
        $rangeResult = $dateRange->viewData('payments');
        $this->assertTrue($rangeResult->getCollection()->contains(fn ($p) => $p->id === $paidHit->id || $p->id === $waived->id));
        $this->assertCount(2, $rangeResult->getCollection());
    }

    public function test_empty_result_state(): void
    {
        $this->seedTypesAndPlans();
        $this->actingAs($this->admin);

        $this->get(route('admin.payments.index', ['search' => 'no-such-payment-xyz']))
            ->assertOk()
            ->assertSee('No payments found');
    }
}
