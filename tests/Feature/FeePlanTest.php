<?php

namespace Tests\Feature;

use App\Enums\FeeFrequency;
use App\Models\FeePlan;
use App\Models\Membership;
use App\Models\MembershipType;
use App\Models\User;
use Database\Seeders\FeePlanSeeder;
use Database\Seeders\MembershipTypeSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class FeePlanTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->admin()->create(['password' => Hash::make('password')]);
    }

    protected function seedTypes(): array
    {
        $this->seed(MembershipTypeSeeder::class);

        return MembershipType::query()->pluck('id', 'slug')->all();
    }

    // ──────────────────────────────────────────
    // AUTHORIZATION
    // ──────────────────────────────────────────

    public function test_guest_is_redirected_to_login(): void
    {
        $this->get(route('admin.fee-plans.index'))->assertRedirect(route('admin.login'));
        $this->get(route('admin.fee-plans.create'))->assertRedirect(route('admin.login'));
    }

    public function test_non_admin_receives_403(): void
    {
        $this->actingAs(User::factory()->create());

        $this->get(route('admin.fee-plans.index'))->assertForbidden();
        $this->post(route('admin.fee-plans.store'), [])->assertForbidden();
    }

    public function test_admin_can_access_fee_plan_pages(): void
    {
        $this->actingAs($this->admin);

        $this->get(route('admin.fee-plans.index'))->assertOk();
        $this->get(route('admin.fee-plans.create'))->assertOk();

        $plan = FeePlan::factory()->create();
        $this->get(route('admin.fee-plans.show', $plan))->assertOk();
        $this->get(route('admin.fee-plans.edit', $plan))->assertOk();
    }

    // ──────────────────────────────────────────
    // CRUD
    // ──────────────────────────────────────────

    public function test_index_works_and_lists_plans(): void
    {
        $this->seedTypes();
        FeePlan::factory()->create(['name' => 'Indexed Plan']);
        $this->actingAs($this->admin);

        $response = $this->get(route('admin.fee-plans.index'));
        $response->assertOk();
        $response->assertSee('Indexed Plan');
    }

    public function test_create_page_works(): void
    {
        $this->seedTypes();
        $this->actingAs($this->admin);

        $this->get(route('admin.fee-plans.create'))->assertOk();
    }

    public function test_admin_can_create_fee_plan(): void
    {
        $types = $this->seedTypes();
        $this->actingAs($this->admin);

        $this->post(route('admin.fee-plans.store'), [
            'name' => 'General Registration 2027',
            'membership_type_id' => $types['general-member'],
            'amount' => '100',
            'currency' => 'BDT',
            'frequency' => FeeFrequency::OneTime->value,
            'description' => 'Future fee schedule.',
            'effective_from' => '2027-01-01',
            'effective_until' => null,
            'sort_order' => '5',
            'is_active' => '1',
        ])->assertRedirect();

        $plan = FeePlan::query()->where('name', 'General Registration 2027')->firstOrFail();
        $this->assertEquals('100.00', $plan->amount);
        $this->assertSame(FeeFrequency::OneTime, $plan->frequency);
        $this->assertSame('BDT', $plan->currency);
        $this->assertTrue($plan->is_active);
        $this->assertSame('2027-01-01', $plan->effective_from->toDateString());
        $this->assertSame(5, $plan->sort_order);
    }

    public function test_show_displays_plan_details(): void
    {
        $types = $this->seedTypes();
        $plan = FeePlan::factory()->create([
            'membership_type_id' => $types['general-member'],
            'name' => 'Detail View Plan',
            'amount' => 75,
        ]);
        $this->actingAs($this->admin);

        $response = $this->get(route('admin.fee-plans.show', $plan));
        $response->assertOk();
        $response->assertSee('Detail View Plan');
        $response->assertSee('৳75');
        $response->assertSee('General Member');
    }

    public function test_admin_can_edit_fee_plan(): void
    {
        $types = $this->seedTypes();
        $plan = FeePlan::factory()->create(['membership_type_id' => $types['general-member']]);
        $this->actingAs($this->admin);

        $this->put(route('admin.fee-plans.update', $plan), [
            'name' => $plan->name,
            'membership_type_id' => $types['general-member'],
            'amount' => '100',
            'currency' => 'BDT',
            'frequency' => FeeFrequency::Monthly->value,
            'description' => $plan->description,
            'effective_from' => $plan->effective_from?->toDateString(),
            'effective_until' => $plan->effective_until?->toDateString(),
            'sort_order' => (string) $plan->sort_order,
            'is_active' => '1',
        ])->assertRedirect(route('admin.fee-plans.show', $plan));

        $plan->refresh();
        $this->assertEquals('100.00', $plan->amount);
        $this->assertSame(FeeFrequency::Monthly, $plan->frequency);
    }

    public function test_unused_fee_plan_can_be_deleted(): void
    {
        $this->seedTypes();
        $plan = FeePlan::factory()->create();
        $this->actingAs($this->admin);

        $this->delete(route('admin.fee-plans.destroy', $plan))
            ->assertRedirect(route('admin.fee-plans.index'))
            ->assertSessionHas('status');

        $this->assertDatabaseMissing('fee_plans', ['id' => $plan->id]);
    }

    public function test_fee_plan_can_be_deactivated_and_reactivated(): void
    {
        $this->seedTypes();
        $plan = FeePlan::factory()->current()->create();
        $this->actingAs($this->admin);

        $this->post(route('admin.fee-plans.deactivate', $plan))->assertRedirect();
        $this->assertTrue($plan->fresh()->is_active === false);
        $this->assertFalse(FeePlan::active()->whereKey($plan->id)->exists());

        $this->post(route('admin.fee-plans.activate', $plan))->assertRedirect();
        $this->assertTrue($plan->fresh()->is_active);
    }

    // ──────────────────────────────────────────
    // VALIDATION
    // ──────────────────────────────────────────

    public function test_store_validates_required_fields(): void
    {
        $this->seedTypes();
        $this->actingAs($this->admin);

        $this->post(route('admin.fee-plans.store'), [])->assertSessionHasErrors([
            'name', 'membership_type_id', 'amount', 'frequency',
        ]);
    }

    public function test_invalid_membership_type_is_rejected(): void
    {
        $this->seedTypes();
        $this->actingAs($this->admin);

        $this->post(route('admin.fee-plans.store'), [
            'name' => 'Bad Type Plan',
            'membership_type_id' => 999999,
            'amount' => '50',
            'frequency' => FeeFrequency::OneTime->value,
        ])->assertSessionHasErrors('membership_type_id');

        $this->assertSame(0, FeePlan::count());
    }

    public function test_negative_amount_is_rejected(): void
    {
        $types = $this->seedTypes();
        $this->actingAs($this->admin);

        $this->post(route('admin.fee-plans.store'), [
            'name' => 'Negative Plan',
            'membership_type_id' => $types['general-member'],
            'amount' => '-10',
            'frequency' => FeeFrequency::OneTime->value,
        ])->assertSessionHasErrors('amount');

        $this->assertSame(0, FeePlan::count());
    }

    public function test_invalid_frequency_is_rejected(): void
    {
        $types = $this->seedTypes();
        $this->actingAs($this->admin);

        $this->post(route('admin.fee-plans.store'), [
            'name' => 'Weird Frequency',
            'membership_type_id' => $types['general-member'],
            'amount' => '50',
            'frequency' => 'weekly',
        ])->assertSessionHasErrors('frequency');

        $this->assertSame(0, FeePlan::count());
    }

    public function test_effective_date_validation(): void
    {
        $types = $this->seedTypes();
        $this->actingAs($this->admin);
        $base = [
            'membership_type_id' => $types['general-member'],
            'amount' => '50',
            'frequency' => FeeFrequency::OneTime->value,
        ];

        $this->post(route('admin.fee-plans.store'), $base + [
            'name' => 'Bad From', 'effective_from' => 'not-a-date',
        ])->assertSessionHasErrors('effective_from');

        $this->post(route('admin.fee-plans.store'), $base + [
            'name' => 'Bad Until', 'effective_until' => 'also-not-a-date',
        ])->assertSessionHasErrors('effective_until');

        $this->post(route('admin.fee-plans.store'), $base + [
            'name' => 'Inverted Window',
            'effective_from' => '2026-12-31',
            'effective_until' => '2026-01-01',
        ])->assertSessionHasErrors('effective_until');

        $this->assertSame(0, FeePlan::count());
    }

    public function test_sort_order_must_be_an_integer(): void
    {
        $types = $this->seedTypes();
        $this->actingAs($this->admin);

        $this->post(route('admin.fee-plans.store'), [
            'name' => 'Sort Order Plan',
            'membership_type_id' => $types['general-member'],
            'amount' => '50',
            'frequency' => FeeFrequency::OneTime->value,
            'sort_order' => 'not-an-int',
        ])->assertSessionHasErrors('sort_order');

        $this->assertSame(0, FeePlan::count());
    }

    // ──────────────────────────────────────────
    // SEARCH & FILTERS
    // ──────────────────────────────────────────

    public function test_search_by_plan_name_and_membership_type(): void
    {
        $types = $this->seedTypes();
        FeePlan::factory()->create([
            'name' => 'Zamindar Special Fee',
            'membership_type_id' => $types['lifetime-member'],
        ]);
        FeePlan::factory()->create([
            'name' => 'Other Plan',
            'membership_type_id' => $types['general-member'],
        ]);
        $this->actingAs($this->admin);

        $byName = $this->get(route('admin.fee-plans.index', ['search' => 'Zamindar']));
        $byName->assertOk();
        $byName->assertSee('Zamindar Special Fee');
        $byName->assertDontSee('Other Plan');

        $byType = $this->get(route('admin.fee-plans.index', ['search' => 'Lifetime']));
        $byType->assertOk();
        $byType->assertSee('Zamindar Special Fee');
        $byType->assertDontSee('Other Plan');
    }

    public function test_filters_by_type_frequency_status_timing_combined(): void
    {
        $types = $this->seedTypes();

        $hit = FeePlan::factory()->monthly()->create([
            'membership_type_id' => $types['executive-committee-member'],
            'name' => 'Hit Plan',
        ]);
        FeePlan::factory()->oneTime()->create([
            'membership_type_id' => $types['executive-committee-member'],
            'name' => 'Wrong Frequency',
        ]);
        FeePlan::factory()->monthly()->create([
            'membership_type_id' => $types['general-member'],
            'name' => 'Wrong Type',
        ]);
        FeePlan::factory()->inactive()->monthly()->create([
            'membership_type_id' => $types['executive-committee-member'],
            'name' => 'Wrong Status',
        ]);
        $this->actingAs($this->admin);

        $response = $this->get(route('admin.fee-plans.index', [
            'membership_type_id' => $types['executive-committee-member'],
            'frequency' => FeeFrequency::Monthly->value,
            'status' => 'active',
        ]));

        $result = $response->viewData('feePlans');
        $this->assertSame(1, $result->total());
        $this->assertSame($hit->id, $result->getCollection()->first()->id);
    }

    public function test_timing_filters_current_upcoming_expired(): void
    {
        $this->seedTypes();
        FeePlan::factory()->current()->create(['name' => 'Current Plan']);
        FeePlan::factory()->upcoming()->create(['name' => 'Upcoming Plan']);
        FeePlan::factory()->expired()->create(['name' => 'Expired Plan']);
        FeePlan::factory()->inactive()->create(['name' => 'Inactive Plan']);
        $this->actingAs($this->admin);

        $current = $this->get(route('admin.fee-plans.index', ['timing' => 'current']))->viewData('feePlans');
        $this->assertSame(1, $current->total());
        $this->assertSame('Current Plan', $current->getCollection()->first()->name);

        $upcoming = $this->get(route('admin.fee-plans.index', ['timing' => 'upcoming']))->viewData('feePlans');
        $this->assertSame(1, $upcoming->total());
        $this->assertSame('Upcoming Plan', $upcoming->getCollection()->first()->name);

        $expired = $this->get(route('admin.fee-plans.index', ['timing' => 'expired']))->viewData('feePlans');
        $names = $expired->getCollection()->pluck('name')->all();
        $this->assertEqualsCanonicalizing(['Expired Plan', 'Inactive Plan'], $names);
    }

    public function test_empty_result_state(): void
    {
        $this->seedTypes();
        $this->actingAs($this->admin);

        $this->get(route('admin.fee-plans.index', ['search' => 'no-match-anywhere']))
            ->assertOk()
            ->assertSee('No fee plans found');
    }

    // ──────────────────────────────────────────
    // MODEL BEHAVIOUR
    // ──────────────────────────────────────────

    public function test_current_scope_respects_active_status_and_window(): void
    {
        $types = $this->seedTypes();

        $openEnded = FeePlan::factory()->current()->create([
            'membership_type_id' => $types['general-member'],
            'name' => 'Open Ended',
        ]);
        FeePlan::factory()->create([
            'membership_type_id' => $types['general-member'],
            'is_active' => false,
            'name' => 'Inactive Not Current',
        ]);

        $current = FeePlan::query()->current()->get();
        $this->assertSame(1, $current->count());
        $this->assertSame($openEnded->id, $current->first()->id);

        // A window containing today is current.
        $bounded = FeePlan::factory()->create([
            'membership_type_id' => $types['executive-committee-member'],
            'effective_from' => now()->subDays(5)->toDateString(),
            'effective_until' => now()->addDays(5)->toDateString(),
        ]);
        $this->assertTrue(FeePlan::query()->current()->whereKey($bounded->id)->exists());

        // Expired and future windows are not current.
        $this->assertFalse(FeePlan::query()->current()->whereKey(
            FeePlan::factory()->expired()->create()->id
        )->exists());
        $this->assertFalse(FeePlan::query()->current()->whereKey(
            FeePlan::factory()->upcoming()->create()->id
        )->exists());
    }

    public function test_upcoming_and_expired_scopes(): void
    {
        $this->seedTypes();
        FeePlan::factory()->upcoming()->create();
        FeePlan::factory()->expired()->create();
        FeePlan::factory()->current()->create();

        $this->assertSame(1, FeePlan::upcoming()->count());
        $this->assertSame(1, FeePlan::expired()->count());
    }

    public function test_membership_type_relationship_and_delete_protection_via_fk(): void
    {
        $types = $this->seedTypes();
        $plan = FeePlan::factory()->create(['membership_type_id' => $types['general-member']]);

        $this->assertSame($types['general-member'], $plan->membershipType->id);

        $this->actingAs($this->admin);
        $type = MembershipType::query()->findOrFail($types['general-member']);

        // Controller-level guard blocks deletion when fee plans reference it.
        $this->delete(route('admin.membership-types.destroy', $type))
            ->assertRedirect()
            ->assertSessionHas('error');
        $this->assertDatabaseHas('membership_types', ['id' => $type->id]);
    }

    public function test_formatted_amount_and_frequency_label(): void
    {
        $this->seedTypes();
        $plan = FeePlan::factory()->make([
            'amount' => 5000,
            'frequency' => FeeFrequency::Monthly,
        ]);

        $this->assertSame('৳5,000', $plan->formattedAmount());
        $this->assertSame('Monthly', $plan->frequencyLabel());

        $plan2 = FeePlan::factory()->make(['amount' => 50]);
        $this->assertSame('৳50', $plan2->formattedAmount());
        $this->assertSame('One Time', $plan2->frequencyLabel());
    }

    public function test_timing_state_helper_classifications(): void
    {
        $this->seedTypes();
        $this->assertSame('current', FeePlan::factory()->current()->make()->timingState());
        $this->assertSame('upcoming', FeePlan::factory()->upcoming()->make()->timingState());
        $this->assertSame('expired', FeePlan::factory()->expired()->make()->timingState());
        $this->assertSame('expired', FeePlan::factory()->inactive()->make()->timingState());
    }

    // ──────────────────────────────────────────
    // MEMBERSHIP INTEGRATION
    // ──────────────────────────────────────────

    public function test_general_member_shows_current_applicable_fee(): void
    {
        $this->seed(FeePlanSeeder::class);
        $membership = Membership::factory()->active()->create([
            'membership_type_id' => MembershipType::where('slug', 'general-member')->value('id'),
        ]);
        $this->actingAs($this->admin);

        $this->get(route('admin.members.show', $membership))
            ->assertOk()
            ->assertSee('৳50 — One Time')
            ->assertSee('Current Applicable Fee');
    }

    public function test_executive_member_shows_monthly_fee(): void
    {
        $this->seed(FeePlanSeeder::class);
        $membership = Membership::factory()->active()->create([
            'membership_type_id' => MembershipType::where('slug', 'executive-committee-member')->value('id'),
        ]);
        $this->actingAs($this->admin);

        $this->get(route('admin.members.show', $membership))
            ->assertOk()
            ->assertSee('৳100 — Monthly');
    }

    public function test_no_active_plan_displays_no_fee_message(): void
    {
        $this->seed(FeePlanSeeder::class); // Lifetime/Honorary seeded inactive.
        $membership = Membership::factory()->active()->lifetime()->create();
        $this->actingAs($this->admin);

        $this->get(route('admin.members.show', $membership))
            ->assertOk()
            ->assertSee('No active fee plan');
    }

    public function test_expired_plan_is_not_treated_as_current_for_member(): void
    {
        $types = $this->seedTypes();
        FeePlan::factory()->expired()->create([
            'membership_type_id' => $types['general-member'],
        ]);
        $membership = Membership::factory()->active()->create([
            'membership_type_id' => $types['general-member'],
        ]);
        $this->actingAs($this->admin);

        $this->get(route('admin.members.show', $membership))
            ->assertOk()
            ->assertDontSee('৳')
            ->assertSee('No active fee plan');
    }

    public function test_future_plan_is_not_treated_as_current_for_member(): void
    {
        $types = $this->seedTypes();
        FeePlan::factory()->upcoming()->create([
            'membership_type_id' => $types['general-member'],
            'amount' => 999,
        ]);
        $membership = Membership::factory()->active()->create([
            'membership_type_id' => $types['general-member'],
        ]);
        $this->actingAs($this->admin);

        $this->get(route('admin.members.show', $membership))
            ->assertOk()
            ->assertDontSee('৳999')
            ->assertSee('No active fee plan');
    }

    // ──────────────────────────────────────────
    // SECURITY
    // ──────────────────────────────────────────

    public function test_member_forms_include_csrf_token_field(): void
    {
        $this->seedTypes();
        $this->actingAs($this->admin);

        $create = $this->get(route('admin.fee-plans.create'));
        $create->assertOk();
        $this->assertMatchesRegularExpression('/name="_token"/', $create->getContent());
    }

    public function test_unauthorized_non_admin_cannot_mutate_fee_plans(): void
    {
        $this->seedTypes();
        $this->actingAs(User::factory()->create());
        $plan = FeePlan::factory()->create();

        $this->post(route('admin.fee-plans.store'), [])->assertForbidden();
        $this->put(route('admin.fee-plans.update', $plan), [])->assertForbidden();
        $this->delete(route('admin.fee-plans.destroy', $plan))->assertForbidden();
        $this->assertDatabaseHas('fee_plans', ['id' => $plan->id]);
    }

    // ──────────────────────────────────────────
    // DASHBOARD
    // ──────────────────────────────────────────

    public function test_dashboard_shows_fee_plan_statistics(): void
    {
        $this->seedTypes();
        FeePlan::factory()->current()->count(2)->create();
        FeePlan::factory()->upcoming()->create();
        FeePlan::factory()->inactive()->create();
        $this->actingAs($this->admin);

        $response = $this->get(route('admin.dashboard'));
        $response->assertOk();
        $this->assertSame(3, $response->viewData('feePlanActiveCount'));
        $this->assertSame(2, $response->viewData('feePlanCurrentCount'));
    }

    // ──────────────────────────────────────────
    // SEEDING
    // ──────────────────────────────────────────

    public function test_seeder_creates_constitutional_baseline_plans(): void
    {
        $this->seed(MembershipTypeSeeder::class);
        $this->seed(FeePlanSeeder::class);

        $general = FeePlan::query()->where('slug', 'general-membership-registration')->firstOrFail();
        $this->assertEquals('50.00', $general->amount);
        $this->assertSame(FeeFrequency::OneTime, $general->frequency);
        $this->assertTrue($general->is_active);
        $this->assertSame('General Member', $general->membershipType->name);

        $exec = FeePlan::query()->where('slug', 'executive-committee-contribution')->firstOrFail();
        $this->assertEquals('100.00', $exec->amount);
        $this->assertSame(FeeFrequency::Monthly, $exec->frequency);

        foreach (['lifetime-membership', 'honorary-membership'] as $slug) {
            $plan = FeePlan::query()->where('slug', $slug)->firstOrFail();
            $this->assertFalse($plan->is_active, "Constitution-undefined plan {$slug} must seed inactive.");
            $this->assertStringContainsStringIgnoringCase('Executive Committee', $plan->description);
        }
    }

    public function test_seeder_is_idempotent(): void
    {
        $this->seed(MembershipTypeSeeder::class);

        $this->seed(FeePlanSeeder::class);
        $this->seed(FeePlanSeeder::class);

        $this->assertSame(4, FeePlan::count());
    }
}
