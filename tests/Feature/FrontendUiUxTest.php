<?php

namespace Tests\Feature;

use App\Models\Alumni;
use App\Models\Membership;
use App\Models\MembershipTier;
use App\Models\MembershipType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FrontendUiUxTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_loads_successfully_with_hero_and_quick_search(): void
    {
        $response = $this->get(route('home'));

        $response->assertStatus(200);
        $response->assertSee('Connected by English');
        $response->assertSee('Quick explore');
        $response->assertSee('Search alumni by name, batch, designation');
        $response->assertSee('Become a Member');
        $response->assertSee('Member Portal');
    }

    public function test_alumni_directory_loads_with_enhanced_filters_and_counter(): void
    {
        Alumni::factory()->create([
            'full_name' => 'Nazrul Graduate',
            'batch' => '18',
            'status' => Alumni::STATUS_ACTIVE,
        ]);

        $response = $this->get(route('alumni.index', ['search' => 'Nazrul']));

        $response->assertStatus(200);
        $response->assertSee('Alumni Directory');
        $response->assertSee('Search Alumni');
        $response->assertSee('Nazrul Graduate');
        $response->assertSee('Batch 18');
        $response->assertSee('Showing');
    }

    public function test_membership_page_loads_with_roadmap_and_tiers(): void
    {
        $type = MembershipType::factory()->create([
            'name' => 'General Alumni',
            'description' => 'For all graduates of the English Department.',
        ]);

        $tier = MembershipTier::factory()->create([
            'name' => 'Patron Member',
            'badge_label' => 'Patron',
        ]);

        $response = $this->get(route('membership'));

        $response->assertStatus(200);
        $response->assertSee('What is EDAA-KNGC?');
        $response->assertSee('General Alumni');
        $response->assertSee('Patron Member');
        $response->assertSee('How to');
        $response->assertSee('Become a Member');
        $response->assertSee('01');
        $response->assertSee('04');
    }

    public function test_navbar_displays_member_badge_when_authenticated(): void
    {
        $alumni = Alumni::factory()->create([
            'full_name' => 'Tariq Rahman',
        ]);

        $type = MembershipType::factory()->create(['name' => 'Life Member']);
        $tier = MembershipTier::factory()->create(['name' => 'Gold Fellow']);

        Membership::factory()->create([
            'alumni_id' => $alumni->id,
            'membership_type_id' => $type->id,
            'membership_tier_id' => $tier->id,
            'status' => Membership::STATUS_ACTIVE,
        ]);

        $user = User::factory()->create([
            'name' => 'Tariq Rahman',
            'email' => 'tariq@example.com',
            'is_admin' => false,
            'alumni_id' => $alumni->id,
        ]);

        $response = $this->actingAs($user)->get(route('home'));

        $response->assertStatus(200);
        $response->assertSee('Tariq Rahman');
        $response->assertSee('Member Dashboard');
        $response->assertSee('Digital ID Card');
    }

    public function test_credits_page_loads_successfully_with_standard_layout(): void
    {
        $response = $this->get(route('credits'));

        $response->assertStatus(200);
        $response->assertSee('Credits & Acknowledgements');
        $response->assertSee('Johirul Islam (Shovon)');
        $response->assertSee('Batch 2018–19');
        $response->assertSee('Lead Developer');
        $response->assertSee('Built with Modern Web Standards');
        $response->assertSee('Laravel Framework');
    }
}
