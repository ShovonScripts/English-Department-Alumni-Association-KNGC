<?php

namespace Tests\Feature;

use App\Models\Committee;
use App\Models\CommitteeRole;
use App\Models\CommitteeType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommitteeHttpVerificationTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create(['is_admin' => true]);
    }

    public function test_admin_committee_types_index_returns_200(): void
    {
        $this->actingAs($this->admin)->get('/admin/committee-types')->assertStatus(200);
    }

    public function test_admin_committee_types_create_returns_200(): void
    {
        $this->actingAs($this->admin)->get('/admin/committee-types/create')->assertStatus(200);
    }

    public function test_admin_committee_types_show_returns_200(): void
    {
        $type = CommitteeType::factory()->create();
        $this->actingAs($this->admin)->get("/admin/committee-types/{$type->slug}")->assertStatus(200);
    }

    public function test_admin_committee_types_edit_returns_200(): void
    {
        $type = CommitteeType::factory()->create();
        $this->actingAs($this->admin)->get("/admin/committee-types/{$type->slug}/edit")->assertStatus(200);
    }

    public function test_admin_committees_index_returns_200(): void
    {
        $this->actingAs($this->admin)->get('/admin/committees')->assertStatus(200);
    }

    public function test_admin_committees_create_returns_200(): void
    {
        $this->actingAs($this->admin)->get('/admin/committees/create')->assertStatus(200);
    }

    public function test_admin_committees_show_returns_200(): void
    {
        $committee = Committee::factory()->create();
        $this->actingAs($this->admin)->get("/admin/committees/{$committee->slug}")->assertStatus(200);
    }

    public function test_admin_committees_edit_returns_200(): void
    {
        $committee = Committee::factory()->create();
        $this->actingAs($this->admin)->get("/admin/committees/{$committee->slug}/edit")->assertStatus(200);
    }

    public function test_admin_committee_roles_index_returns_200(): void
    {
        $this->actingAs($this->admin)->get('/admin/committee-roles')->assertStatus(200);
    }

    public function test_public_committees_index_returns_200(): void
    {
        CommitteeType::factory()->create(['is_active' => true]);
        $this->get('/committees')->assertStatus(200);
    }

    public function test_public_committee_show_returns_200(): void
    {
        $type = CommitteeType::factory()->create(['is_active' => true]);
        $committee = Committee::factory()->create(['committee_type_id' => $type->id]);
        $this->get("/committees/{$type->slug}/{$committee->slug}")->assertStatus(200);
    }

    public function test_public_committee_history_returns_200(): void
    {
        $type = CommitteeType::factory()->create(['is_active' => true]);
        $this->get("/committees/history/{$type->slug}")->assertStatus(200);
    }

    public function test_admin_unauthenticated_redirected(): void
    {
        $this->get('/admin/committee-types')->assertRedirect('/admin/login');
        $this->get('/admin/committees')->assertRedirect('/admin/login');
        $this->get('/admin/committee-roles')->assertRedirect('/admin/login');
    }
}
