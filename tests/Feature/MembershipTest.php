<?php

namespace Tests\Feature;

use App\Models\Alumni;
use App\Models\Membership;
use App\Models\MembershipTier;
use App\Models\MembershipType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class MembershipTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected string $password = 'password';

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->admin()->create(['password' => Hash::make($this->password)]);
    }

    protected function seedTaxonomy(): array
    {
        $types = collect([
            ['name' => 'General Member', 'slug' => 'general-member', 'sort_order' => 1],
            ['name' => 'Lifetime Member', 'slug' => 'lifetime-member', 'sort_order' => 2],
            ['name' => 'Honorary Member', 'slug' => 'honorary-member', 'sort_order' => 3],
            ['name' => 'Executive Committee Member', 'slug' => 'executive-committee-member', 'sort_order' => 4],
        ])->mapWithKeys(function (array $item) {
            $type = MembershipType::create([...$item, 'is_active' => true]);

            return [$item['slug'] => $type];
        });

        $tiers = collect([
            ['name' => 'Bronze', 'slug' => 'bronze', 'badge_label' => 'Bronze', 'sort_order' => 1],
            ['name' => 'Silver', 'slug' => 'silver', 'badge_label' => 'Silver', 'sort_order' => 2],
            ['name' => 'Gold', 'slug' => 'gold', 'badge_label' => 'Gold', 'sort_order' => 3],
            ['name' => 'Platinum', 'slug' => 'platinum', 'badge_label' => 'Platinum', 'sort_order' => 4],
        ])->mapWithKeys(function (array $item) {
            $tier = MembershipTier::create([...$item, 'is_active' => true]);

            return [$item['name'] => $tier];
        });

        return [$types, $tiers];
    }

    // ──────────────────────────────────────────
    // PUBLIC DISPLAY
    // ──────────────────────────────────────────

    public function test_existing_alumni_pages_still_work(): void
    {
        Alumni::factory()->count(3)->create();

        $this->get(route('alumni.index'))->assertOk();
        $this->get(route('alumni.show', Alumni::first()))->assertOk();
    }

    public function test_active_public_membership_badge_appears_on_profile(): void
    {
        [$types, $tiers] = $this->seedTaxonomy();

        $alumni = Alumni::factory()->create();
        Membership::factory()->active()->public()->create([
            'alumni_id' => $alumni->id,
            'membership_type_id' => $types['general-member']->id,
            'membership_tier_id' => $tiers['Silver']->id,
        ]);

        $response = $this->get(route('alumni.show', $alumni));
        $response->assertOk();
        $response->assertSee('Silver Member');
    }

    public function test_private_membership_badge_does_not_appear(): void
    {
        [$types, $tiers] = $this->seedTaxonomy();

        $alumni = Alumni::factory()->create();
        Membership::factory()->active()->private()->create([
            'alumni_id' => $alumni->id,
            'membership_type_id' => $types['general-member']->id,
            'membership_tier_id' => $tiers['Gold']->id,
        ]);

        $this->get(route('alumni.show', $alumni))
            ->assertOk()
            ->assertDontSee('Gold Member');
    }

    public function test_suspended_membership_does_not_appear_publicly(): void
    {
        [$types, $tiers] = $this->seedTaxonomy();

        $alumni = Alumni::factory()->create();
        Membership::factory()->suspended()->public()->create([
            'alumni_id' => $alumni->id,
            'membership_type_id' => $types['general-member']->id,
            'membership_tier_id' => $tiers['Gold']->id,
        ]);

        $this->get(route('alumni.show', $alumni))
            ->assertOk()
            ->assertDontSee('Gold Member');
    }

    public function test_pending_membership_is_not_shown_as_active(): void
    {
        [$types] = $this->seedTaxonomy();

        $alumni = Alumni::factory()->create();
        Membership::factory()->pending()->public()->create([
            'alumni_id' => $alumni->id,
            'membership_type_id' => $types['lifetime-member']->id,
        ]);

        $this->get(route('alumni.show', $alumni))
            ->assertOk()
            ->assertDontSee('Lifetime Member');
    }

    public function test_correct_membership_type_and_tier_appear(): void
    {
        [$types, $tiers] = $this->seedTaxonomy();

        $alumni = Alumni::factory()->create();
        Membership::factory()->active()->public()->create([
            'alumni_id' => $alumni->id,
            'membership_type_id' => $types['lifetime-member']->id,
            'membership_tier_id' => $tiers['Platinum']->id,
        ]);

        // Tier badge wins the display label; type name must not be shown as a fake badge.
        $this->get(route('alumni.show', $alumni))
            ->assertOk()
            ->assertSee('Platinum Member')
            ->assertDontSee('Lifetime Member');
    }

    public function test_directory_shows_badge_for_public_active_members_only(): void
    {
        [$types, $tiers] = $this->seedTaxonomy();

        $visible = Alumni::factory()->create(['full_name' => 'Visible Member']);
        $hidden = Alumni::factory()->create(['full_name' => 'Hidden Member']);

        Membership::factory()->active()->public()->create([
            'alumni_id' => $visible->id,
            'membership_type_id' => $types['general-member']->id,
            'membership_tier_id' => $tiers['Gold']->id,
        ]);
        Membership::factory()->active()->private()->create([
            'alumni_id' => $hidden->id,
            'membership_type_id' => $types['general-member']->id,
            'membership_tier_id' => $tiers['Bronze']->id,
        ]);

        $response = $this->get(route('alumni.index'));
        $response->assertOk();
        $response->assertSee('Visible Member');
        $response->assertSee('Gold Member');
        $response->assertSee('Hidden Member');
        $response->assertDontSee('Bronze Member');
    }

    public function test_admin_notes_are_never_public(): void
    {
        [$types, $tiers] = $this->seedTaxonomy();

        $alumni = Alumni::factory()->create();
        Membership::factory()->active()->public()->create([
            'alumni_id' => $alumni->id,
            'membership_type_id' => $types['general-member']->id,
            'membership_tier_id' => $tiers['Silver']->id,
            'notes' => 'SECRET-INTERNAL-NOTE-7788',
        ]);

        $this->get(route('alumni.show', $alumni))
            ->assertOk()
            ->assertDontSee('SECRET-INTERNAL-NOTE-7788');
    }

    // ──────────────────────────────────────────
    // ADMIN AUTHORIZATION
    // ──────────────────────────────────────────

    public function test_guest_is_redirected_to_login_for_member_pages(): void
    {
        $this->get(route('admin.members.index'))->assertRedirect(route('admin.login'));
        $this->get(route('admin.members.create'))->assertRedirect(route('admin.login'));
        $this->get(route('admin.membership-types.index'))->assertRedirect(route('admin.login'));
        $this->get(route('admin.membership-tiers.index'))->assertRedirect(route('admin.login'));
    }

    public function test_non_admin_receives_403_for_member_pages(): void
    {
        $nonAdmin = User::factory()->create(['password' => Hash::make($this->password)]);
        $this->actingAs($nonAdmin);

        $this->get(route('admin.members.index'))->assertForbidden();
        $this->get(route('admin.membership-types.index'))->assertForbidden();
        $this->get(route('admin.membership-tiers.index'))->assertForbidden();
    }

    public function test_admin_can_access_member_pages(): void
    {
        $this->actingAs($this->admin);

        $this->get(route('admin.members.index'))->assertOk();
        $this->get(route('admin.members.create'))->assertOk();
        $this->get(route('admin.membership-types.index'))->assertOk();
        $this->get(route('admin.membership-types.create'))->assertOk();
        $this->get(route('admin.membership-tiers.index'))->assertOk();
        $this->get(route('admin.membership-tiers.create'))->assertOk();
    }

    // ──────────────────────────────────────────
    // MEMBERSHIP CRUD
    // ──────────────────────────────────────────

    public function test_admin_can_create_membership(): void
    {
        [$types, $tiers] = $this->seedTaxonomy();
        $alumni = Alumni::factory()->create();
        $this->actingAs($this->admin);

        $response = $this->post(route('admin.members.store'), [
            'alumni_id' => $alumni->id,
            'membership_type_id' => $types['general-member']->id,
            'membership_tier_id' => $tiers['Silver']->id,
            'status' => Membership::STATUS_ACTIVE,
            'joined_at' => '2026-01-15',
            'notes' => 'Registered at the reunion desk.',
            'is_public' => '1',
        ]);

        $response->assertRedirect();
        $membership = Membership::query()->where('alumni_id', $alumni->id)->firstOrFail();

        $this->assertSame(Membership::STATUS_ACTIVE, $membership->status);
        $this->assertTrue($membership->is_public);
        $this->assertSame('2026-01-15', $membership->joined_at->toDateString());
        $this->assertSame('Registered at the reunion desk.', $membership->notes);
        $this->assertNotNull($membership->approved_at);
    }

    public function test_membership_number_is_generated_and_sequential(): void
    {
        [$types] = $this->seedTaxonomy();
        $this->actingAs($this->admin);

        foreach ([1, 2, 3] as $i) {
            $alumni = Alumni::factory()->create();
            $this->post(route('admin.members.store'), [
                'alumni_id' => $alumni->id,
                'membership_type_id' => $types['general-member']->id,
                'status' => Membership::STATUS_PENDING,
            ])->assertRedirect();
        }

        $numbers = Membership::query()->orderBy('membership_number')->pluck('membership_number')->values();
        $this->assertCount(3, $numbers);
        $this->assertMatchesRegularExpression('/^EDAA-\d{6}$/', $numbers[0]);
        $this->assertSame('EDAA-000001', $numbers[0]);
        $this->assertSame('EDAA-000002', $numbers[1]);
        $this->assertSame('EDAA-000003', $numbers[2]);
    }

    public function test_membership_numbers_are_unique_across_records(): void
    {
        Membership::factory()->count(25)->create();

        $numbers = Membership::query()->pluck('membership_number');
        $this->assertSame($numbers->count(), $numbers->unique()->count());
    }

    public function test_admin_can_view_membership_details(): void
    {
        [$types, $tiers] = $this->seedTaxonomy();
        $membership = Membership::factory()->active()->public()->create([
            'membership_type_id' => $types['honorary-member']->id,
            'membership_tier_id' => $tiers['Gold']->id,
            'notes' => 'VIEW-NOTE-9911',
        ]);
        $this->actingAs($this->admin);

        $response = $this->get(route('admin.members.show', $membership));
        $response->assertOk();
        $response->assertSee($membership->membership_number);
        $response->assertSee('Honorary Member');
        $response->assertSee('Gold');
        $response->assertSee('VIEW-NOTE-9911');
    }

    public function test_admin_can_edit_membership(): void
    {
        [$types] = $this->seedTaxonomy();
        $membership = Membership::factory()->pending()->create([
            'membership_type_id' => $types['general-member']->id,
        ]);
        $this->actingAs($this->admin);

        $this->get(route('admin.members.edit', $membership))->assertOk();

        $this->put(route('admin.members.update', $membership), [
            'alumni_id' => $membership->alumni_id,
            'membership_type_id' => $types['general-member']->id,
            'membership_tier_id' => null,
            'status' => Membership::STATUS_ACTIVE,
            'joined_at' => $membership->joined_at?->toDateString(),
            'notes' => 'Approved after fee collection.',
            'is_public' => '1',
        ])->assertRedirect(route('admin.members.show', $membership));

        $membership->refresh();
        $this->assertSame(Membership::STATUS_ACTIVE, $membership->status);
        $this->assertTrue($membership->is_public);
        $this->assertSame('Approved after fee collection.', $membership->notes);
        $this->assertNotNull($membership->approved_at);
    }

    public function test_admin_can_update_membership_status_and_type_and_tier(): void
    {
        [$types, $tiers] = $this->seedTaxonomy();
        $membership = Membership::factory()->active()->create([
            'membership_type_id' => $types['general-member']->id,
            'membership_tier_id' => $tiers['Bronze']->id,
        ]);
        $this->actingAs($this->admin);

        $this->put(route('admin.members.update', $membership), [
            'alumni_id' => $membership->alumni_id,
            'membership_type_id' => $types['executive-committee-member']->id,
            'membership_tier_id' => $tiers['Diamond']?->id ?? $tiers['Platinum']->id,
            'status' => Membership::STATUS_SUSPENDED,
            'joined_at' => $membership->joined_at?->toDateString(),
        ])->assertRedirect();

        $membership->refresh();
        $this->assertSame(Membership::STATUS_SUSPENDED, $membership->status);
        $this->assertSame($types['executive-committee-member']->id, $membership->membership_type_id);
        $this->assertSame($tiers[$tiers->has('Diamond') ? 'Diamond' : 'Platinum']->id, $membership->membership_tier_id);
    }

    public function test_admin_can_delete_membership(): void
    {
        $membership = Membership::factory()->create();
        $this->actingAs($this->admin);

        $this->delete(route('admin.members.destroy', $membership))
            ->assertRedirect(route('admin.members.index'));

        $this->assertDatabaseMissing('memberships', ['id' => $membership->id]);
    }

    public function test_duplicate_membership_for_same_alumni_is_blocked_by_validation(): void
    {
        [$types] = $this->seedTaxonomy();
        $existing = Membership::factory()->create(['membership_type_id' => $types['general-member']->id]);
        $otherAlumni = Alumni::factory()->create();
        $this->actingAs($this->admin);

        // Creating a second membership for the same alumnus fails validation.
        $this->from(route('admin.members.create'))
            ->post(route('admin.members.store'), [
                'alumni_id' => $existing->alumni_id,
                'membership_type_id' => $types['general-member']->id,
                'status' => Membership::STATUS_PENDING,
            ])
            ->assertSessionHasErrors('alumni_id');

        // Updating another member to steal an already-taken alumni also fails.
        $second = Membership::factory()->create(['alumni_id' => $otherAlumni->id]);
        $this->put(route('admin.members.update', $second), [
            'alumni_id' => $existing->alumni_id,
            'membership_type_id' => $types['general-member']->id,
            'status' => Membership::STATUS_PENDING,
        ])->assertSessionHasErrors('alumni_id');

        $this->assertSame(2, Membership::count());
    }

    public function test_create_form_lists_only_alumni_without_membership(): void
    {
        [$types] = $this->seedTaxonomy();
        $taken = Alumni::factory()->create(['full_name' => 'Already Registered']);
        $free = Alumni::factory()->create(['full_name' => 'Still Available']);

        Membership::factory()->create([
            'alumni_id' => $taken->id,
            'membership_type_id' => $types['general-member']->id,
        ]);
        $this->actingAs($this->admin);

        $response = $this->get(route('admin.members.create'));
        $response->assertOk();
        $response->assertSee('Still Available');
        $response->assertDontSee('Already Registered');
    }

    public function test_admin_can_suspend_and_activate_membership(): void
    {
        $membership = Membership::factory()->active()->create();
        $this->actingAs($this->admin);

        $this->post(route('admin.members.suspend', $membership))->assertRedirect();
        $membership->refresh();
        $this->assertSame(Membership::STATUS_SUSPENDED, $membership->status);

        $this->post(route('admin.members.activate', $membership))->assertRedirect();
        $membership->refresh();
        $this->assertSame(Membership::STATUS_ACTIVE, $membership->status);
    }

    // ──────────────────────────────────────────
    // SEARCH & FILTERS
    // ──────────────────────────────────────────

    public function test_member_index_search_by_alumni_name(): void
    {
        $match = Membership::factory()->create(['alumni_id' => Alumni::factory()->create(['full_name' => 'Zubair Uniqueworthy'])->id]);
        Membership::factory()->create(['alumni_id' => Alumni::factory()->create(['full_name' => 'Someone Else'])->id]);
        $this->actingAs($this->admin);

        $response = $this->get(route('admin.members.index', ['search' => 'Zubair']));
        $response->assertOk();
        $response->assertSee('Zubair Uniqueworthy');
        $response->assertDontSee('Someone Else');

        $this->assertTrue($response->viewData('memberships')->getCollection()->contains(fn ($m) => $m->id === $match->id));
    }

    public function test_member_index_search_by_student_id(): void
    {
        Membership::factory()->create(['alumni_id' => Alumni::factory()->create(['student_id' => 'KNGC-STU-7777'])->id]);
        Membership::factory()->create();
        $this->actingAs($this->admin);

        $response = $this->get(route('admin.members.index', ['search' => 'KNGC-STU-7777']));
        $response->assertOk();
        $this->assertSame(1, $response->viewData('memberships')->total());
    }

    public function test_member_index_search_by_membership_number(): void
    {
        $target = Membership::factory()->create();
        Membership::factory()->count(2)->create();
        $this->actingAs($this->admin);

        $response = $this->get(route('admin.members.index', ['search' => $target->membership_number]));
        $response->assertOk();
        $this->assertSame(1, $response->viewData('memberships')->total());
    }

    public function test_member_index_filters_by_type_tier_status_combined(): void
    {
        [$types, $tiers] = $this->seedTaxonomy();

        $hit = Membership::factory()->active()->create([
            'membership_type_id' => $types['lifetime-member']->id,
            'membership_tier_id' => $tiers['Gold']->id,
        ]);
        Membership::factory()->pending()->create([
            'membership_type_id' => $types['lifetime-member']->id,
            'membership_tier_id' => $tiers['Gold']->id,
        ]);
        Membership::factory()->active()->create([
            'membership_type_id' => $types['general-member']->id,
            'membership_tier_id' => $tiers['Gold']->id,
        ]);
        Membership::factory()->active()->create([
            'membership_type_id' => $types['lifetime-member']->id,
            'membership_tier_id' => $tiers['Bronze']->id,
        ]);
        $this->actingAs($this->admin);

        $response = $this->get(route('admin.members.index', [
            'membership_type_id' => $types['lifetime-member']->id,
            'membership_tier_id' => $tiers['Gold']->id,
            'status' => Membership::STATUS_ACTIVE,
        ]));

        $response->assertOk();
        $result = $response->viewData('memberships');
        $this->assertSame(1, $result->total());
        $this->assertSame($hit->id, $result->getCollection()->first()->id);
    }

    public function test_member_index_filter_no_tier_and_empty_result_state(): void
    {
        [$types] = $this->seedTaxonomy();

        $noTier = Membership::factory()->create([
            'membership_type_id' => $types['general-member']->id,
            'membership_tier_id' => null,
        ]);
        Membership::factory()->create([
            'membership_type_id' => $types['general-member']->id,
        ]);
        $this->actingAs($this->admin);

        $response = $this->get(route('admin.members.index', ['membership_tier_id' => 'none']));
        $response->assertOk();
        $result = $response->viewData('memberships');
        $this->assertSame(1, $result->total());
        $this->assertSame($noTier->id, $result->getCollection()->first()->id);

        $empty = $this->get(route('admin.members.index', ['search' => 'nothing-matches-this-string']));
        $empty->assertOk();
        $empty->assertSee('No members found');
    }

    // ──────────────────────────────────────────
    // VALIDATION
    // ──────────────────────────────────────────

    public function test_store_requires_alumni_and_type_with_valid_values(): void
    {
        [$types] = $this->seedTaxonomy();
        $this->actingAs($this->admin);

        $this->post(route('admin.members.store'), [])->assertSessionHasErrors(['alumni_id', 'membership_type_id', 'status']);
        $this->post(route('admin.members.store'), [
            'alumni_id' => 999999,
            'membership_type_id' => 999999,
            'status' => Membership::STATUS_PENDING,
        ])->assertSessionHasErrors(['alumni_id', 'membership_type_id']);
        $this->post(route('admin.members.store'), [
            'alumni_id' => Alumni::factory()->create()->id,
            'membership_type_id' => $types['general-member']->id,
            'status' => 'not-a-status',
        ])->assertSessionHasErrors('status');
        $this->post(route('admin.members.store'), [
            'alumni_id' => Alumni::factory()->create()->id,
            'membership_type_id' => $types['general-member']->id,
            'status' => Membership::STATUS_PENDING,
            'membership_tier_id' => 999999,
        ])->assertSessionHasErrors('membership_tier_id');
        $this->post(route('admin.members.store'), [
            'alumni_id' => Alumni::factory()->create()->id,
            'membership_type_id' => $types['general-member']->id,
            'status' => Membership::STATUS_PENDING,
            'joined_at' => 'not-a-date',
        ])->assertSessionHasErrors('joined_at');
        $this->post(route('admin.members.store'), [
            'alumni_id' => Alumni::factory()->create()->id,
            'membership_type_id' => $types['general-member']->id,
            'status' => Membership::STATUS_PENDING,
            'joined_at' => now()->addDay()->toDateString(),
        ])->assertSessionHasErrors('joined_at');

        $this->assertSame(0, Membership::count());
    }

    public function test_notes_length_is_validated(): void
    {
        [$types] = $this->seedTaxonomy();
        $this->actingAs($this->admin);

        $this->post(route('admin.members.store'), [
            'alumni_id' => Alumni::factory()->create()->id,
            'membership_type_id' => $types['general-member']->id,
            'status' => Membership::STATUS_PENDING,
            'notes' => str_repeat('x', 2001),
        ])->assertSessionHasErrors('notes');

        $this->assertSame(0, Membership::count());
    }

    // ──────────────────────────────────────────
    // SECURITY
    // ──────────────────────────────────────────

    public function test_member_forms_include_csrf_token_field(): void
    {
        $this->actingAs($this->admin);

        $create = $this->get(route('admin.members.create'));
        $create->assertOk();
        $this->assertMatchesRegularExpression('/name="_token"/', $create->getContent());
    }

    public function test_unauthorized_non_admin_cannot_mutate_members(): void
    {
        $nonAdmin = User::factory()->create();
        $this->actingAs($nonAdmin);

        $this->post(route('admin.members.store'), [])->assertForbidden();
        $this->delete(route('admin.members.destroy', Membership::factory()->create()))->assertForbidden();
    }
}
