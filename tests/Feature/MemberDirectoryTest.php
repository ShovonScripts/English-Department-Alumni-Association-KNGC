<?php

namespace Tests\Feature;

use App\Models\Alumni;
use App\Models\AlumniStory;
use App\Models\Membership;
use App\Models\MembershipTier;
use App\Models\MembershipType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MemberDirectoryTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->admin()->create();
    }

    // ──────────────────────────────────────────────────────────────
    // HELPERS
    // ──────────────────────────────────────────────────────────────

    protected function createPublicMember(array $alumniOverrides = [], array $membershipOverrides = []): array
    {
        $type = MembershipType::factory()->create();
        $tier = MembershipTier::factory()->create();

        $alumni = Alumni::factory()->create(array_merge([
            'status' => Alumni::STATUS_ACTIVE,
            'is_featured' => false,
        ], $alumniOverrides));

        $membership = Membership::factory()->active()->create(array_merge([
            'alumni_id' => $alumni->id,
            'membership_type_id' => $type->id,
            'membership_tier_id' => $tier->id,
            'is_public' => true,
        ], $membershipOverrides));

        return ['alumni' => $alumni, 'membership' => $membership, 'type' => $type, 'tier' => $tier];
    }

    // ──────────────────────────────────────────────────────────────
    // PUBLIC DIRECTORY
    // ──────────────────────────────────────────────────────────────

    public function test_directory_page_returns_200(): void
    {
        $this->get(route('members.index'))->assertOk();
    }

    public function test_directory_shows_public_active_members(): void
    {
        $public = $this->createPublicMember(['full_name' => 'Public Member']);

        $this->get(route('members.index'))
            ->assertSee('Public Member');
    }

    public function test_directory_hides_private_members(): void
    {
        $hidden = $this->createPublicMember(
            ['full_name' => 'Private Person'],
            ['is_public' => false]
        );

        $this->get(route('members.index'))
            ->assertDontSee('Private Person');
    }

    public function test_directory_hides_pending_members(): void
    {
        $type = MembershipType::factory()->create();
        $alumni = Alumni::factory()->create(['status' => Alumni::STATUS_ACTIVE]);
        Membership::factory()->pending()->create([
            'alumni_id' => $alumni->id,
            'membership_type_id' => $type->id,
            'is_public' => false,
        ]);

        $this->get(route('members.index'))
            ->assertDontSee($alumni->full_name);
    }

    public function test_directory_hides_suspended_members(): void
    {
        $data = $this->createPublicMember(
            ['full_name' => 'Suspended User'],
            ['status' => Membership::STATUS_SUSPENDED]
        );

        $this->get(route('members.index'))
            ->assertDontSee('Suspended User');
    }

    public function test_directory_hides_cancelled_members(): void
    {
        $data = $this->createPublicMember(
            ['full_name' => 'Cancelled User'],
            ['status' => Membership::STATUS_CANCELLED]
        );

        $this->get(route('members.index'))
            ->assertDontSee('Cancelled User');
    }

    public function test_directory_hides_expired_members(): void
    {
        $data = $this->createPublicMember(
            ['full_name' => 'Expired User'],
            ['status' => Membership::STATUS_EXPIRED]
        );

        $this->get(route('members.index'))
            ->assertDontSee('Expired User');
    }

    public function test_directory_shows_membership_badge(): void
    {
        $data = $this->createPublicMember(['full_name' => 'Badge User']);

        $this->get(route('members.index'))
            ->assertSee('Member');
    }

    public function test_directory_shows_tier_badge(): void
    {
        $data = $this->createPublicMember(['full_name' => 'Tier User']);
        $tierLabel = $data['tier']->badge_label;

        $this->get(route('members.index'))
            ->assertSee($tierLabel);
    }

    public function test_directory_shows_type_badge_fallback(): void
    {
        $data = $this->createPublicMember(
            ['full_name' => 'Type User'],
            ['membership_tier_id' => null]
        );

        $this->get(route('members.index'))
            ->assertSee('Type User')
            ->assertSee($data['type']->name);
    }

    public function test_directory_works_without_tier(): void
    {
        $type = MembershipType::factory()->create();
        $alumni = Alumni::factory()->create(['status' => Alumni::STATUS_ACTIVE, 'full_name' => 'No Tier User']);
        Membership::factory()->active()->create([
            'alumni_id' => $alumni->id,
            'membership_type_id' => $type->id,
            'membership_tier_id' => null,
            'is_public' => true,
        ]);

        $this->get(route('members.index'))
            ->assertOk()
            ->assertSee('No Tier User');
    }

    // ──────────────────────────────────────────────────────────────
    // SEARCH
    // ──────────────────────────────────────────────────────────────

    public function test_search_by_name(): void
    {
        $this->createPublicMember(['full_name' => 'Alice Searchable']);
        $this->createPublicMember(['full_name' => 'Bob Hidden']);

        $this->get(route('members.index', ['search' => 'Alice']))
            ->assertSee('Alice Searchable')
            ->assertDontSee('Bob Hidden');
    }

    public function test_search_by_student_id(): void
    {
        $this->createPublicMember(['full_name' => 'SID Match', 'student_id' => '2018-XYZ']);
        $this->createPublicMember(['full_name' => 'SID Other']);

        $this->get(route('members.index', ['search' => '2018-XYZ']))
            ->assertSee('SID Match')
            ->assertDontSee('SID Other');
    }

    public function test_search_by_profession(): void
    {
        $this->createPublicMember(['full_name' => 'Teacher One', 'profession' => 'Professor of English']);
        $this->createPublicMember(['full_name' => 'Doctor Two', 'profession' => 'Medical Doctor']);

        $this->get(route('members.index', ['search' => 'Professor']))
            ->assertSee('Teacher One')
            ->assertDontSee('Doctor Two');
    }

    public function test_search_by_organization(): void
    {
        $this->createPublicMember(['full_name' => 'Org Match', 'organization' => 'Google Inc']);
        $this->createPublicMember(['full_name' => 'Org Other', 'organization' => 'Microsoft Corp']);

        $this->get(route('members.index', ['search' => 'Google']))
            ->assertSee('Org Match')
            ->assertDontSee('Org Other');
    }

    public function test_search_by_batch(): void
    {
        $this->createPublicMember(['full_name' => 'Batch Match', 'batch' => '2015']);
        $this->createPublicMember(['full_name' => 'Batch Other', 'batch' => '2020']);

        $this->get(route('members.index', ['search' => '2015']))
            ->assertSee('Batch Match')
            ->assertDontSee('Batch Other');
    }

    public function test_empty_search_returns_all(): void
    {
        $this->createPublicMember(['full_name' => 'Visible Member']);

        $this->get(route('members.index', ['search' => '']))
            ->assertSee('Visible Member');
    }

    public function test_no_result_search(): void
    {
        $this->createPublicMember(['full_name' => 'Present Member']);

        $this->get(route('members.index', ['search' => 'NonexistentXYZ']))
            ->assertDontSee('Present Member')
            ->assertSee('No members match your search');
    }

    // ──────────────────────────────────────────────────────────────
    // FILTERS
    // ──────────────────────────────────────────────────────────────

    public function test_filter_by_batch(): void
    {
        $this->createPublicMember(['full_name' => 'Batch A', 'batch' => '2010']);
        $this->createPublicMember(['full_name' => 'Batch B', 'batch' => '2015']);

        $this->get(route('members.index', ['batch' => '2010']))
            ->assertSee('Batch A')
            ->assertDontSee('Batch B');
    }

    public function test_filter_by_graduation_year(): void
    {
        $this->createPublicMember(['full_name' => 'Year A', 'graduation_year' => 2018]);
        $this->createPublicMember(['full_name' => 'Year B', 'graduation_year' => 2022]);

        $this->get(route('members.index', ['graduation_year' => 2018]))
            ->assertSee('Year A')
            ->assertDontSee('Year B');
    }

    public function test_filter_by_country(): void
    {
        $this->createPublicMember(['full_name' => 'Country A', 'country' => 'Bangladesh']);
        $this->createPublicMember(['full_name' => 'Country B', 'country' => 'India']);

        $this->get(route('members.index', ['country' => 'Bangladesh']))
            ->assertSee('Country A')
            ->assertDontSee('Country B');
    }

    public function test_filter_by_profession(): void
    {
        $this->createPublicMember(['full_name' => 'Prof A', 'profession' => 'Teacher']);
        $this->createPublicMember(['full_name' => 'Prof B', 'profession' => 'Engineer']);

        $this->get(route('members.index', ['profession' => 'Teacher']))
            ->assertSee('Prof A')
            ->assertDontSee('Prof B');
    }

    public function test_filter_by_membership_type(): void
    {
        $dataA = $this->createPublicMember(['full_name' => 'Type A Member']);
        $dataB = $this->createPublicMember(['full_name' => 'Type B Member']);

        $this->get(route('members.index', ['membership_type_id' => $dataA['type']->id]))
            ->assertSee('Type A Member')
            ->assertDontSee('Type B Member');
    }

    public function test_filter_by_membership_tier(): void
    {
        $dataA = $this->createPublicMember(['full_name' => 'Tier A Member']);
        $dataB = $this->createPublicMember(['full_name' => 'Tier B Member']);

        $this->get(route('members.index', ['membership_tier_id' => $dataA['tier']->id]))
            ->assertSee('Tier A Member')
            ->assertDontSee('Tier B Member');
    }

    public function test_combined_filters(): void
    {
        $this->createPublicMember(['full_name' => 'Combo Match', 'batch' => '2015', 'country' => 'Bangladesh']);
        $this->createPublicMember(['full_name' => 'Combo Wrong', 'batch' => '2010', 'country' => 'Bangladesh']);
        $this->createPublicMember(['full_name' => 'Combo Wrong2', 'batch' => '2015', 'country' => 'India']);

        $this->get(route('members.index', ['batch' => '2015', 'country' => 'Bangladesh']))
            ->assertSee('Combo Match')
            ->assertDontSee('Combo Wrong')
            ->assertDontSee('Combo Wrong2');
    }

    public function test_filters_preserved_through_pagination(): void
    {
        $this->createPublicMember(['full_name' => 'Test Search Member', 'batch' => '2015']);
        $this->createPublicMember(['full_name' => 'Other Member', 'batch' => '2020']);

        $response = $this->get(route('members.index', ['batch' => '2015', 'search' => 'Test']));
        $response->assertOk();
        $response->assertSee('Test Search Member');
        $response->assertDontSee('Other Member');
    }

    // ──────────────────────────────────────────────────────────────
    // MEMBER PROFILE
    // ──────────────────────────────────────────────────────────────

    public function test_valid_public_member_profile_returns_200(): void
    {
        $data = $this->createPublicMember(['full_name' => 'Profile User']);

        $this->get(route('member.show', $data['alumni']->slug))
            ->assertOk()
            ->assertSee('Profile User');
    }

    public function test_private_member_profile_returns_404(): void
    {
        $data = $this->createPublicMember(
            ['full_name' => 'Private Profile'],
            ['is_public' => false]
        );

        $this->get(route('member.show', $data['alumni']->slug))
            ->assertNotFound();
    }

    public function test_suspended_member_profile_returns_404(): void
    {
        $data = $this->createPublicMember(
            ['full_name' => 'Suspended Profile'],
            ['status' => Membership::STATUS_SUSPENDED]
        );

        $this->get(route('member.show', $data['alumni']->slug))
            ->assertNotFound();
    }

    public function test_invalid_slug_returns_404(): void
    {
        $this->get(route('member.show', 'nonexistent-slug'))
            ->assertNotFound();
    }

    public function test_profile_shows_public_information(): void
    {
        $data = $this->createPublicMember([
            'full_name' => 'Profile Info User',
            'profession' => 'Teacher',
            'organization' => 'KNGC',
            'bio' => 'A short biography.',
        ]);

        $this->get(route('member.show', $data['alumni']->slug))
            ->assertSee('Profile Info User')
            ->assertSee('Teacher')
            ->assertSee('KNGC')
            ->assertSee('A short biography.');
    }

    public function test_profile_hides_private_information(): void
    {
        $data = $this->createPublicMember([
            'full_name' => 'Private Info User',
            'email' => 'private@example.com',
            'phone' => '+8801712345678',
        ]);

        $response = $this->get(route('member.show', $data['alumni']->slug));
        $response->assertOk();
        $response->assertDontSee('private@example.com');
        $response->assertDontSee('+8801712345678');
    }

    public function test_profile_shows_stories(): void
    {
        $data = $this->createPublicMember(['full_name' => 'Story User']);
        $story = AlumniStory::factory()->published()->create([
            'alumni_id' => $data['alumni']->id,
            'title' => 'My Alumni Story',
        ]);

        $this->get(route('member.show', $data['alumni']->slug))
            ->assertSee('My Alumni Story');
    }

    public function test_profile_shows_external_links(): void
    {
        $data = $this->createPublicMember([
            'full_name' => 'Link User',
            'linkedin_url' => 'https://linkedin.com/in/linkuser',
            'website_url' => 'https://linkuser.com',
        ]);

        $this->get(route('member.show', $data['alumni']->slug))
            ->assertSee('https://linkedin.com/in/linkuser')
            ->assertSee('https://linkuser.com');
    }

    // ──────────────────────────────────────────────────────────────
    // STATISTICS
    // ──────────────────────────────────────────────────────────────

    public function test_statistics_match_database(): void
    {
        $this->createPublicMember(['country' => 'Bangladesh', 'batch' => '2015']);
        $this->createPublicMember(['country' => 'India', 'batch' => '2018']);

        $response = $this->get(route('members.index'));
        $response->assertOk();
        $response->assertSee('2'); // total members
        $response->assertSee('2'); // countries
    }

    public function test_statistics_count_distinct_countries(): void
    {
        $this->createPublicMember(['country' => 'Bangladesh']);
        $this->createPublicMember(['country' => 'Bangladesh']);
        $this->createPublicMember(['country' => 'India']);

        $response = $this->get(route('members.index'));
        $response->assertOk();
    }

    public function test_statistics_count_distinct_batches(): void
    {
        $this->createPublicMember(['batch' => '2015']);
        $this->createPublicMember(['batch' => '2015']);
        $this->createPublicMember(['batch' => '2020']);

        $response = $this->get(route('members.index'));
        $response->assertOk();
    }

    // ──────────────────────────────────────────────────────────────
    // HOMEPAGE
    // ──────────────────────────────────────────────────────────────

    public function test_homepage_shows_public_members_section(): void
    {
        $this->createPublicMember(['full_name' => 'Home Member']);

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('Our Members')
            ->assertSee('Home Member')
            ->assertSee('View All Members');
    }

    public function test_homepage_hides_private_members(): void
    {
        $this->createPublicMember(
            ['full_name' => 'ZPrivateX Home Only 777'],
            ['is_public' => false]
        );

        $this->get(route('home'))
            ->assertOk()
            ->assertDontSeeText('ZPrivateX Home Only 777');
    }

    public function test_homepage_member_links_work(): void
    {
        $data = $this->createPublicMember(['full_name' => 'Home Link Member']);

        $this->get(route('home'))
            ->assertSee(route('member.show', $data['alumni']->slug));
    }

    // ──────────────────────────────────────────────────────────────
    // MEMBERSHIP PAGE
    // ──────────────────────────────────────────────────────────────

    public function test_membership_page_has_directory_cta(): void
    {
        $this->get(route('membership'))
            ->assertOk()
            ->assertSee('Meet Our Members')
            ->assertSee(route('members.index'));
    }

    public function test_membership_page_has_types_and_tiers_sections(): void
    {
        MembershipType::factory()->create(['name' => 'General Member', 'is_active' => true]);
        MembershipTier::factory()->create(['name' => 'Gold', 'is_active' => true]);

        $response = $this->get(route('membership'));
        $response->assertOk();
        $response->assertSee('Membership Categories');
        $response->assertSee('Membership Recognition Tiers');
    }

    // ──────────────────────────────────────────────────────────────
    // PRIVACY AUDIT
    // ──────────────────────────────────────────────────────────────

    public function test_directory_no_private_data(): void
    {
        $this->createPublicMember([
            'full_name' => 'Privacy Audit User',
            'email' => 'secret@example.com',
            'phone' => '+8801799999999',
        ]);

        $response = $this->get(route('members.index'));
        $response->assertOk();
        $response->assertDontSee('secret@example.com');
        $response->assertDontSee('+8801799999999');
        $response->assertDontSee('payment');
        $response->assertDontSee('collection');
        $response->assertDontSee('expense');
        $response->assertDontSee('outstanding');
        $response->assertDontSee('admin notes');
    }

    public function test_profile_no_private_data(): void
    {
        $data = $this->createPublicMember([
            'full_name' => 'Privacy Profile User',
            'email' => 'private@example.com',
            'phone' => '+8801788888888',
        ]);

        $response = $this->get(route('member.show', $data['alumni']->slug));
        $response->assertOk();
        $response->assertDontSee('private@example.com');
        $response->assertDontSee('+8801788888888');
        $response->assertDontSee('payment');
        $response->assertDontSee('collection');
        $response->assertDontSee('expense');
        $response->assertDontSee('outstanding');
        $response->assertDontSee('admin notes');
        $response->assertDontSee('membership_number');
    }

    public function test_membership_page_no_private_data(): void
    {
        $response = $this->get(route('membership'));
        $response->assertOk();
        $response->assertDontSee('payment number');
        $response->assertDontSee('admin notes');
        $response->assertDontSee('reviewer');
    }

    public function test_homepage_no_private_data(): void
    {
        $response = $this->get(route('home'));
        $response->assertOk();
        $response->assertDontSeeText('outstanding');
        $response->assertDontSeeText('admin notes');
        $response->assertDontSeeText('fee balance');
        $response->assertDontSeeText('membership_number');
    }

    // ──────────────────────────────────────────────────────────────
    // SEO
    // ──────────────────────────────────────────────────────────────

    public function test_directory_page_seo(): void
    {
        $response = $this->get(route('members.index'));
        $response->assertOk();
        $response->assertSee('meta name="description"', escape: false);
        $response->assertSee('Members', escape: false);
    }

    public function test_profile_page_seo(): void
    {
        $data = $this->createPublicMember(['full_name' => 'SEO User']);

        $response = $this->get(route('member.show', $data['alumni']->slug));
        $response->assertOk();
        $response->assertSee('SEO User', escape: false);
        $response->assertSee('application/ld+json', escape: false);
    }

    // ──────────────────────────────────────────────────────────────
    // ADMIN
    // ──────────────────────────────────────────────────────────────

    public function test_admin_toggle_requires_login(): void
    {
        $data = $this->createPublicMember();

        $this->post(route('admin.members.public-toggle', $data['membership']))
            ->assertRedirect(route('admin.login'));
    }

    public function test_admin_toggle_requires_admin(): void
    {
        $data = $this->createPublicMember();
        $nonAdmin = User::factory()->create();

        $this->actingAs($nonAdmin)
            ->post(route('admin.members.public-toggle', $data['membership']))
            ->assertForbidden();
    }

    public function test_admin_can_toggle_public_visibility(): void
    {
        $data = $this->createPublicMember(['full_name' => 'Toggle User']);

        $this->actingAs($this->admin)
            ->post(route('admin.members.public-toggle', $data['membership']))
            ->assertRedirect();

        $data['membership']->refresh();
        $this->assertFalse($data['membership']->is_public);

        // Confirm hidden from public
        $this->get(route('members.index'))
            ->assertDontSee('Toggle User');
    }

    public function test_admin_toggle_does_not_change_status(): void
    {
        $data = $this->createPublicMember();

        $this->actingAs($this->admin)
            ->post(route('admin.members.public-toggle', $data['membership']))
            ->assertRedirect();

        $data['membership']->refresh();
        $this->assertSame(Membership::STATUS_ACTIVE, $data['membership']->status);
    }

    public function test_admin_toggle_does_not_change_tier(): void
    {
        $data = $this->createPublicMember();
        $originalTierId = $data['membership']->membership_tier_id;

        $this->actingAs($this->admin)
            ->post(route('admin.members.public-toggle', $data['membership']))
            ->assertRedirect();

        $data['membership']->refresh();
        $this->assertSame($originalTierId, $data['membership']->membership_tier_id);
    }

    public function test_admin_toggle_does_not_change_type(): void
    {
        $data = $this->createPublicMember();
        $originalTypeId = $data['membership']->membership_type_id;

        $this->actingAs($this->admin)
            ->post(route('admin.members.public-toggle', $data['membership']))
            ->assertRedirect();

        $data['membership']->refresh();
        $this->assertSame($originalTypeId, $data['membership']->membership_type_id);
    }

    public function test_admin_re_enables_public_visibility(): void
    {
        $data = $this->createPublicMember(['full_name' => 'Re-enable User']);

        // Hide
        $this->actingAs($this->admin)
            ->post(route('admin.members.public-toggle', $data['membership']));

        $this->get(route('members.index'))
            ->assertDontSee('Re-enable User');

        // Re-enable
        $this->actingAs($this->admin)
            ->post(route('admin.members.public-toggle', $data['membership']));

        $this->get(route('members.index'))
            ->assertSee('Re-enable User');
    }

    public function test_admin_dashboard_shows_public_member_count(): void
    {
        $this->createPublicMember();
        $this->createPublicMember(['full_name' => 'Second Public']);

        $this->actingAs($this->admin)
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('Public Members')
            ->assertSee('2');
    }

    // ──────────────────────────────────────────────────────────────
    // EMPTY STATES
    // ──────────────────────────────────────────────────────────────

    public function test_empty_directory_shows_update_message(): void
    {
        $this->get(route('members.index'))
            ->assertOk()
            ->assertSee('Member directory is currently being updated');
    }

    public function test_no_search_results_shows_message(): void
    {
        $this->get(route('members.index', ['search' => 'nonexistent']))
            ->assertOk()
            ->assertSee('No members match your search');
    }

    // ──────────────────────────────────────────────────────────────
    // REGRESSION
    // ──────────────────────────────────────────────────────────────

    public function test_alumni_index_still_works(): void
    {
        $this->get(route('alumni.index'))->assertOk();
    }

    public function test_alumni_show_still_works(): void
    {
        $alumni = Alumni::factory()->create(['status' => Alumni::STATUS_ACTIVE]);

        $this->get(route('alumni.show', $alumni))->assertOk();
    }

    public function test_homepage_still_works(): void
    {
        $this->get(route('home'))->assertOk();
    }

    public function test_membership_page_still_works(): void
    {
        $this->get(route('membership'))->assertOk();
    }
}
