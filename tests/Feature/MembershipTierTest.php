<?php

namespace Tests\Feature;

use App\Models\Membership;
use App\Models\MembershipTier;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class MembershipTierTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->admin()->create(['password' => Hash::make('password')]);
        $this->actingAs($this->admin);
    }

    public function test_index_lists_tiers_with_member_counts(): void
    {
        $tier = MembershipTier::factory()->create(['name' => 'Obsidian']);
        Membership::factory()->count(3)->create(['membership_tier_id' => $tier->id]);

        $response = $this->get(route('admin.membership-tiers.index'));
        $response->assertOk();
        $response->assertSee('Obsidian');

        $viewTier = collect($response->viewData('tiers'))->firstWhere('id', $tier->id);
        $this->assertSame(3, $viewTier->memberships_count);
    }

    public function test_admin_can_create_tier(): void
    {
        $this->post(route('admin.membership-tiers.store'), [
            'name' => 'Diamond',
            'badge_label' => 'Diamond',
            'description' => 'Highest recognition.',
            'sort_order' => '5',
            'is_active' => '1',
        ])->assertRedirect(route('admin.membership-tiers.index'));

        $tier = MembershipTier::query()->where('name', 'Diamond')->firstOrFail();
        $this->assertSame('Diamond', $tier->badge_label);
        $this->assertSame('diamond', $tier->slug);
        $this->assertTrue($tier->is_active);
    }

    public function test_create_tier_requires_name_and_badge_label(): void
    {
        $this->post(route('admin.membership-tiers.store'), [])->assertSessionHasErrors(['name', 'badge_label']);
    }

    public function test_admin_can_edit_tier(): void
    {
        $tier = MembershipTier::factory()->create(['name' => 'Old Tier']);

        $this->get(route('admin.membership-tiers.edit', $tier))->assertOk();

        $this->put(route('admin.membership-tiers.update', $tier), [
            'name' => 'New Tier Name',
            'badge_label' => 'Elite',
            'description' => null,
            'sort_order' => '7',
            'is_active' => '1',
        ])->assertRedirect(route('admin.membership-tiers.index'));

        $tier->refresh();
        $this->assertSame('New Tier Name', $tier->name);
        $this->assertSame('Elite', $tier->badge_label);
    }

    public function test_tier_can_be_deactivated(): void
    {
        $tier = MembershipTier::factory()->create();

        $this->put(route('admin.membership-tiers.update', $tier), [
            'name' => $tier->name,
            'badge_label' => $tier->badge_label,
            'description' => $tier->description,
            'sort_order' => (string) $tier->sort_order,
        ])->assertRedirect();

        $tier->refresh();
        $this->assertFalse($tier->is_active);
        $this->assertFalse(MembershipTier::active()->whereKey($tier->id)->exists());
    }

    public function test_tier_deletion_is_protected_when_held_by_memberships(): void
    {
        $tier = MembershipTier::factory()->create();
        Membership::factory()->count(2)->create(['membership_tier_id' => $tier->id]);

        $response = $this->delete(route('admin.membership-tiers.destroy', $tier));
        $response->assertRedirect(route('admin.membership-tiers.index'));
        $response->assertSessionHas('error');
        $this->assertDatabaseHas('membership_tiers', ['id' => $tier->id]);

        $unused = MembershipTier::factory()->create();
        $this->delete(route('admin.membership-tiers.destroy', $unused))
            ->assertRedirect(route('admin.membership-tiers.index'))
            ->assertSessionHas('status');
        $this->assertDatabaseMissing('membership_tiers', ['id' => $unused->id]);
    }
}
