<?php

namespace Tests\Feature;

use App\Models\Alumni;
use App\Models\Membership;
use App\Models\MembershipTier;
use App\Models\MembershipType;
use App\Models\User;
use Database\Seeders\MembershipSeeder;
use Database\Seeders\MembershipTierSeeder;
use Database\Seeders\MembershipTypeSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class MembershipFoundationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->admin()->create(['password' => Hash::make('password')]);
        $this->actingAs($this->admin);
    }

    public function test_dashboard_shows_membership_statistics(): void
    {
        $general = MembershipType::factory()->create(['name' => 'General Member', 'slug' => 'general-member']);
        $lifetime = MembershipType::factory()->create(['name' => 'Lifetime Member', 'slug' => 'lifetime-member']);

        Membership::factory()->active()->create(['membership_type_id' => $general->id]);
        Membership::factory()->active()->lifetime()->create();
        Membership::factory()->pending()->create(['membership_type_id' => $general->id]);
        Membership::factory()->suspended()->create(['membership_type_id' => $general->id]);

        $response = $this->get(route('admin.dashboard'));

        $response->assertOk();

        $this->assertSame(4, (int) preg_replace('/\D/', '', $response->viewData('membershipTotalCount')));
        $this->assertSame(2, $response->viewData('membershipActiveCount'));
        $this->assertSame(1, $response->viewData('membershipPendingCount'));
        // Suspended lifetime membership must not count towards the active lifetime figure.
        $this->assertSame(1, $response->viewData('membershipLifetimeCount'));
    }

    public function test_type_seeder_is_idempotent_and_seeds_constitution_types(): void
    {
        $this->seed(MembershipTypeSeeder::class);
        $this->seed(MembershipTierSeeder::class);

        $this->seed(MembershipTypeSeeder::class);

        $this->assertSame(4, MembershipType::count());
        foreach (['general-member', 'lifetime-member', 'honorary-member', 'executive-committee-member'] as $slug) {
            $this->assertDatabaseHas('membership_types', ['slug' => $slug]);
        }
    }

    public function test_tier_seeder_is_idempotent(): void
    {
        $this->seed(MembershipTierSeeder::class);
        $this->seed(MembershipTierSeeder::class);

        $this->assertSame(4, MembershipTier::count());
        foreach (['bronze', 'silver', 'gold', 'platinum'] as $slug) {
            $this->assertDatabaseHas('membership_tiers', ['slug' => $slug]);
        }
    }

    public function test_membership_seeder_uses_existing_alumni_without_duplicates(): void
    {
        Alumni::factory()->count(12)->create();

        $this->seed(MembershipSeeder::class);

        $firstRun = Membership::count();
        $this->assertGreaterThan(0, $firstRun);
        $this->assertLessThanOrEqual(Alumni::count(), $firstRun);

        // Re-running must not create duplicates.
        $this->seed(MembershipSeeder::class);
        $this->assertSame($firstRun, Membership::count());

        // Every seeded record references real alumni and unique numbers.
        $numbers = Membership::query()->pluck('membership_number');
        $this->assertSame($numbers->count(), $numbers->unique()->count());

        // Coverage: pending, suspended and private states exist in seed data.
        $this->assertTrue(Membership::where('status', 'pending')->exists());
        $this->assertTrue(Membership::where('status', 'suspended')->exists());
        $this->assertTrue(Membership::where('is_public', false)->exists());
        $this->assertTrue(Membership::whereNull('membership_tier_id')->exists());
    }
}
