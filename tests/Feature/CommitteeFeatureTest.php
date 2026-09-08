<?php

namespace Tests\Feature;

use App\Models\Committee;
use App\Models\CommitteeRole;
use App\Models\CommitteeType;
use App\Models\Membership;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class CommitteeFeatureTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create(['is_admin' => true]);
    }

    // ─── CommitteeType CRUD ──────────────────────────────────────

    public function test_admin_can_list_committee_types(): void
    {
        CommitteeType::factory()->count(3)->create();

        $response = $this->actingAs($this->admin)->get('/admin/committee-types');
        $response->assertStatus(200);
        $response->assertSee('Committee Types');
    }

    public function test_admin_can_create_committee_type(): void
    {
        $data = ['name' => 'Executive Committee', 'description' => 'The executive body.'];

        $response = $this->actingAs($this->admin)->post('/admin/committee-types', $data);
        $response->assertRedirect();
        $this->assertDatabaseHas('committee_types', ['name' => 'Executive Committee', 'slug' => 'executive-committee']);
    }

    public function test_admin_cannot_create_committee_type_without_name(): void
    {
        $response = $this->actingAs($this->admin)->post('/admin/committee-types', ['name' => '']);
        $response->assertSessionHasErrors('name');
    }

    public function test_admin_can_update_committee_type(): void
    {
        $type = CommitteeType::factory()->create();

        $response = $this->actingAs($this->admin)->put("/admin/committee-types/{$type->slug}", ['name' => 'Updated Name']);
        $response->assertRedirect();
        $this->assertDatabaseHas('committee_types', ['id' => $type->id, 'name' => 'Updated Name']);
    }

    public function test_admin_can_delete_unused_committee_type(): void
    {
        $type = CommitteeType::factory()->create();

        $response = $this->actingAs($this->admin)->delete("/admin/committee-types/{$type->slug}");
        $response->assertRedirect();
        $this->assertDatabaseMissing('committee_types', ['id' => $type->id]);
    }

    public function test_admin_cannot_delete_committee_type_with_committees(): void
    {
        $type = CommitteeType::factory()->create();
        Committee::factory()->create(['committee_type_id' => $type->id]);

        $response = $this->actingAs($this->admin)->delete("/admin/committee-types/{$type->slug}");
        $response->assertSessionHas('error');
        $this->assertDatabaseHas('committee_types', ['id' => $type->id]);
    }

    // ─── Committee CRUD ──────────────────────────────────────────

    public function test_admin_can_list_committees(): void
    {
        Committee::factory()->count(3)->create();

        $response = $this->actingAs($this->admin)->get('/admin/committees');
        $response->assertStatus(200);
        $response->assertSee('Committees');
    }

    public function test_admin_can_search_committees(): void
    {
        Committee::factory()->create(['name' => 'Executive Board']);
        Committee::factory()->create(['name' => 'Advisory Council']);

        $response = $this->actingAs($this->admin)->get('/admin/committees?search=Executive');
        $response->assertStatus(200);
    }

    public function test_admin_can_filter_committees_by_type(): void
    {
        $type = CommitteeType::factory()->create();
        Committee::factory()->create(['committee_type_id' => $type->id]);
        Committee::factory()->create();

        $response = $this->actingAs($this->admin)->get("/admin/committees?committee_type_id={$type->id}");
        $response->assertStatus(200);
    }

    public function test_admin_can_create_committee(): void
    {
        $type = CommitteeType::factory()->create();
        $data = [
            'committee_type_id' => $type->id,
            'name' => '2024 Executive Committee',
            'start_year' => 2024,
            'end_year' => 2025,
        ];

        $response = $this->actingAs($this->admin)->post('/admin/committees', $data);
        $response->assertRedirect();
        $this->assertDatabaseHas('committees', ['name' => '2024 Executive Committee', 'slug' => '2024-executive-committee']);
    }

    public function test_admin_cannot_create_committee_with_invalid_years(): void
    {
        $type = CommitteeType::factory()->create();
        $data = [
            'committee_type_id' => $type->id,
            'name' => 'Bad Dates',
            'start_year' => 2025,
            'end_year' => 2024,
        ];

        $response = $this->actingAs($this->admin)->post('/admin/committees', $data);
        $response->assertSessionHasErrors('end_year');
    }

    public function test_admin_can_update_committee(): void
    {
        $committee = Committee::factory()->create();
        $data = [
            'committee_type_id' => $committee->committee_type_id,
            'name' => 'Updated Committee',
            'start_year' => $committee->start_year,
            'end_year' => $committee->end_year,
        ];

        $response = $this->actingAs($this->admin)->put("/admin/committees/{$committee->slug}", $data);
        $response->assertRedirect();
        $this->assertDatabaseHas('committees', ['id' => $committee->id, 'name' => 'Updated Committee']);
    }

    public function test_admin_can_delete_committee(): void
    {
        $committee = Committee::factory()->create();

        $response = $this->actingAs($this->admin)->delete("/admin/committees/{$committee->slug}");
        $response->assertRedirect();
        $this->assertDatabaseMissing('committees', ['id' => $committee->id]);
    }

    public function test_admin_can_make_committee_current(): void
    {
        $type = CommitteeType::factory()->create();
        $old = Committee::factory()->current()->create(['committee_type_id' => $type->id]);
        $new = Committee::factory()->create(['committee_type_id' => $type->id]);

        $response = $this->actingAs($this->admin)->post("/admin/committees/{$new->slug}/make-current");
        $response->assertRedirect();

        $this->assertDatabaseHas('committees', ['id' => $new->id, 'is_current' => true]);
        $this->assertDatabaseHas('committees', ['id' => $old->id, 'is_current' => false]);
    }

    // ─── Committee Role CRUD ─────────────────────────────────────

    public function test_admin_can_list_committee_roles(): void
    {
        CommitteeRole::factory()->count(3)->create();

        $response = $this->actingAs($this->admin)->get('/admin/committee-roles');
        $response->assertStatus(200);
    }

    public function test_admin_can_create_committee_role(): void
    {
        $response = $this->actingAs($this->admin)->post('/admin/committee-roles', ['name' => 'Vice President']);
        $response->assertRedirect();
        $this->assertDatabaseHas('committee_roles', ['name' => 'Vice President', 'slug' => 'vice-president']);
    }

    public function test_admin_cannot_create_duplicate_role_slug(): void
    {
        CommitteeRole::factory()->create(['name' => 'President', 'slug' => 'president']);

        $response = $this->actingAs($this->admin)->post('/admin/committee-roles', ['name' => 'President']);
        $response->assertRedirect();
        $this->assertDatabaseHas('committee_roles', ['slug' => 'president-2']);
    }

    public function test_admin_can_delete_unused_role(): void
    {
        $role = CommitteeRole::factory()->create();

        $response = $this->actingAs($this->admin)->delete("/admin/committee-roles/{$role->slug}");
        $response->assertRedirect();
        $this->assertDatabaseMissing('committee_roles', ['id' => $role->id]);
    }

    public function test_admin_cannot_delete_role_in_use(): void
    {
        $role = CommitteeRole::factory()->create();
        $committee = Committee::factory()->create();
        $membership = Membership::factory()->create();

        DB::table('committee_pivot')->insert([
            'committee_id' => $committee->id,
            'membership_id' => $membership->id,
            'committee_role_id' => $role->id,
            'sort_order' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $response = $this->actingAs($this->admin)->delete("/admin/committee-roles/{$role->slug}");
        $response->assertSessionHas('error');
        $this->assertDatabaseHas('committee_roles', ['id' => $role->id]);
    }

    // ─── Committee Member Management ─────────────────────────────

    public function test_admin_can_add_member_to_committee(): void
    {
        $committee = Committee::factory()->create();
        $role = CommitteeRole::factory()->create();
        $membership = Membership::factory()->create();

        $response = $this->actingAs($this->admin)->post("/admin/committees/{$committee->slug}/add-member", [
            'membership_id' => $membership->id,
            'committee_role_id' => $role->id,
        ]);
        $response->assertRedirect();

        $this->assertDatabaseHas('committee_pivot', [
            'committee_id' => $committee->id,
            'membership_id' => $membership->id,
            'committee_role_id' => $role->id,
        ]);
    }

    public function test_admin_can_update_member_role(): void
    {
        $committee = Committee::factory()->create();
        $oldRole = CommitteeRole::factory()->create();
        $newRole = CommitteeRole::factory()->create();
        $membership = Membership::factory()->create();

        $committee->members()->attach($membership->id, ['committee_role_id' => $oldRole->id, 'sort_order' => 1]);

        $response = $this->actingAs($this->admin)->put("/admin/committees/{$committee->slug}/members/{$membership->id}/role", [
            'committee_role_id' => $newRole->id,
        ]);
        $response->assertRedirect();

        $this->assertDatabaseHas('committee_pivot', [
            'committee_id' => $committee->id,
            'membership_id' => $membership->id,
            'committee_role_id' => $newRole->id,
        ]);
    }

    public function test_admin_can_remove_member_from_committee(): void
    {
        $committee = Committee::factory()->create();
        $role = CommitteeRole::factory()->create();
        $membership = Membership::factory()->create();

        $committee->members()->attach($membership->id, ['committee_role_id' => $role->id, 'sort_order' => 1]);

        $response = $this->actingAs($this->admin)->delete("/admin/committees/{$committee->slug}/members/{$membership->id}");
        $response->assertRedirect();

        $this->assertDatabaseMissing('committee_pivot', [
            'committee_id' => $committee->id,
            'membership_id' => $membership->id,
        ]);
    }

    // ─── Committee Model ─────────────────────────────────────────

    public function test_committee_mark_as_current(): void
    {
        $type = CommitteeType::factory()->create();
        $old = Committee::factory()->current()->create(['committee_type_id' => $type->id]);
        $new = Committee::factory()->create(['committee_type_id' => $type->id]);

        $new->markAsCurrent();

        $this->assertTrue($new->fresh()->is_current);
        $this->assertFalse($old->fresh()->is_current);
    }

    public function test_committee_year_range(): void
    {
        $committee = Committee::factory()->create(['start_year' => 2024, 'end_year' => 2025]);

        $this->assertEquals('2024 – 2025', $committee->yearRange());
    }

    public function test_unique_slug_generation(): void
    {
        Committee::factory()->create(['slug' => 'executive-committee']);
        $slug = Committee::uniqueSlug('Executive Committee');

        $this->assertEquals('executive-committee-2', $slug);
    }

    // ─── Public Pages ────────────────────────────────────────────

    public function test_public_committees_index_shows_active_types(): void
    {
        CommitteeType::factory()->create(['is_active' => true]);
        CommitteeType::factory()->create(['is_active' => false]);

        $response = $this->get('/committees');
        $response->assertStatus(200);
    }

    public function test_public_committee_show_displays_members(): void
    {
        $type = CommitteeType::factory()->create(['is_active' => true]);
        $committee = Committee::factory()->create(['committee_type_id' => $type->id]);
        $role = CommitteeRole::factory()->create();
        $membership = Membership::factory()->create();

        $committee->members()->attach($membership->id, ['committee_role_id' => $role->id, 'sort_order' => 1]);

        $response = $this->get("/committees/{$type->slug}/{$committee->slug}");
        $response->assertStatus(200);
    }

    public function test_public_committee_history_shows_all_committees(): void
    {
        $type = CommitteeType::factory()->create(['is_active' => true]);
        Committee::factory()->count(3)->create(['committee_type_id' => $type->id]);

        $response = $this->get("/committees/history/{$type->slug}");
        $response->assertStatus(200);
    }

    public function test_public_committee_show_404s_for_wrong_type(): void
    {
        $type1 = CommitteeType::factory()->create();
        $type2 = CommitteeType::factory()->create();
        $committee = Committee::factory()->create(['committee_type_id' => $type1->id]);

        $response = $this->get("/committees/{$type2->slug}/{$committee->slug}");
        $response->assertStatus(404);
    }

    // ─── Auth Guards ─────────────────────────────────────────────

    public function test_guest_redirected_from_admin_committee_pages(): void
    {
        $this->get('/admin/committee-types')->assertRedirect('/admin/login');
        $this->get('/admin/committees')->assertRedirect('/admin/login');
        $this->get('/admin/committee-roles')->assertRedirect('/admin/login');
    }
}
