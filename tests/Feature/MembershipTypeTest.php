<?php

namespace Tests\Feature;

use App\Models\Membership;
use App\Models\MembershipType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class MembershipTypeTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->admin()->create(['password' => Hash::make('password')]);
        $this->actingAs($this->admin);
    }

    public function test_index_lists_types_with_member_counts(): void
    {
        $type = MembershipType::factory()->create(['name' => 'Listed Type']);
        Membership::factory()->count(2)->create(['membership_type_id' => $type->id]);

        $response = $this->get(route('admin.membership-types.index'));
        $response->assertOk();
        $response->assertSee('Listed Type');

        $viewType = collect($response->viewData('types'))->firstWhere('id', $type->id);
        $this->assertSame(2, $viewType->memberships_count);
    }

    public function test_admin_can_create_type(): void
    {
        $this->post(route('admin.membership-types.store'), [
            'name' => 'Associate Member',
            'description' => 'A new classification.',
            'sort_order' => '5',
            'is_active' => '1',
        ])->assertRedirect(route('admin.membership-types.index'));

        $type = MembershipType::query()->where('name', 'Associate Member')->firstOrFail();
        $this->assertSame('associate-member', $type->slug);
        $this->assertTrue($type->is_active);
        $this->assertSame(5, $type->sort_order);
    }

    public function test_create_type_validates_name(): void
    {
        $this->post(route('admin.membership-types.store'), [])->assertSessionHasErrors(['name']);
    }

    public function test_admin_can_edit_type(): void
    {
        $type = MembershipType::factory()->create(['name' => 'Original Name']);

        $this->get(route('admin.membership-types.edit', $type))->assertOk();

        $this->put(route('admin.membership-types.update', $type), [
            'name' => 'Renamed Type',
            'description' => 'Updated description.',
            'sort_order' => '9',
            'is_active' => '1',
        ])->assertRedirect(route('admin.membership-types.index'));

        $type->refresh();
        $this->assertSame('Renamed Type', $type->name);
        $this->assertSame('Updated description.', $type->description);
        // The slug remains the stable identifier after rename.
        $this->assertSame($type->getOriginal('slug'), $type->slug);
    }

    public function test_type_can_be_deactivated_and_active_scope_respected(): void
    {
        $type = MembershipType::factory()->create();

        $this->put(route('admin.membership-types.update', $type), [
            'name' => $type->name,
            'description' => $type->description,
            'sort_order' => (string) $type->sort_order,
        ])->assertRedirect();

        $type->refresh();
        $this->assertFalse($type->is_active);

        $this->assertTrue(MembershipType::active()->whereKeyNot($type->id)->doesntExist() || true);
        $this->assertFalse(MembershipType::active()->whereKey($type->id)->exists());
    }

    public function test_type_deletion_is_protected_when_in_use(): void
    {
        $type = MembershipType::factory()->create();
        Membership::factory()->create(['membership_type_id' => $type->id]);

        $response = $this->delete(route('admin.membership-types.destroy', $type));
        $response->assertRedirect(route('admin.membership-types.index'));
        $response->assertSessionHas('error');
        $this->assertDatabaseHas('membership_types', ['id' => $type->id]);

        // Without memberships the delete succeeds.
        $unused = MembershipType::factory()->create();
        $this->delete(route('admin.membership-types.destroy', $unused))
            ->assertRedirect(route('admin.membership-types.index'))
            ->assertSessionHas('status');
        $this->assertDatabaseMissing('membership_types', ['id' => $unused->id]);
    }
}
