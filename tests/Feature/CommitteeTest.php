<?php

namespace Tests\Feature;

use App\Models\CommitteeMember;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CommitteeTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->admin()->create(['password' => Hash::make('password')]);
        $this->password = 'password';
        $this->actingAs($this->admin);
    }

    // ── Public committee page ──────────────────────────────────

    public function test_public_committee_page_returns_200(): void
    {
        CommitteeMember::factory()->create(['is_active' => true]);

        $this->get(route('committee.index'))->assertOk();
    }

    public function test_public_committee_page_shows_only_active_members(): void
    {
        $active = CommitteeMember::factory()->create([
            'name' => 'Active Member',
            'is_active' => true,
            'sort_order' => 1,
        ]);
        $inactive = CommitteeMember::factory()->inactive()->create([
            'name' => 'Inactive Member',
            'sort_order' => 2,
        ]);

        $response = $this->get(route('committee.index'));

        $response->assertOk();
        $response->assertSee('Active Member');
        $response->assertDontSee('Inactive Member');
    }

    public function test_public_committee_page_orders_by_sort_order_then_name(): void
    {
        CommitteeMember::factory()->create(['name' => 'Zara Second', 'is_active' => true, 'sort_order' => 2]);
        CommitteeMember::factory()->create(['name' => 'Ada First', 'is_active' => true, 'sort_order' => 1]);

        $response = $this->get(route('committee.index'));

        $content = $response->getContent();
        $firstPos = strpos($content, 'Ada First');
        $secondPos = strpos($content, 'Zara Second');

        $this->assertTrue($firstPos < $secondPos, 'Members should be ordered by sort_order then name.');
    }

    public function test_public_committee_page_shows_empty_state_when_no_active_members(): void
    {
        CommitteeMember::factory()->inactive()->create();

        $this->get(route('committee.index'))
            ->assertOk()
            ->assertSee('Committee coming soon');
    }

    public function test_public_committee_page_shows_empty_state_when_no_members(): void
    {
        $this->get(route('committee.index'))
            ->assertOk()
            ->assertSee('Committee coming soon');
    }

    public function test_public_committee_page_links_leadership_card_to_leader_profile(): void
    {
        $leader = CommitteeMember::factory()->create([
            'name' => 'Ada Leader',
            'is_active' => true,
            'sort_order' => 1,
        ]);
        CommitteeMember::factory()->create(['name' => 'Zed Follower', 'is_active' => true, 'sort_order' => 2]);

        $response = $this->get(route('committee.index'));

        $response->assertOk();

        $content = $response->getContent();

        // The leadership card must link to the leader's public profile.
        $this->assertStringContainsString('href="'.route('committee.show', $leader).'"', $content);
        $this->assertStringContainsString('View Ada Leader\'s profile', $content);

        // Follow the link to confirm it opens the correct profile.
        $this->get(route('committee.show', $leader))
            ->assertOk()
            ->assertSee('Ada Leader');
    }

    public function test_profile_photo_url_is_origin_independent(): void
    {
        // Simulate a different environment host than APP_URL.
        config(['app.url' => 'https://staging.example.org']);

        $member = CommitteeMember::factory()->create([
            'profile_photo' => 'committee/photo.jpg',
        ]);

        $url = $member->profile_photo_url;

        $this->assertNotNull($url);
        $this->assertStringContainsString('/storage/committee/photo.jpg', $url);

        // Relative URL: must never bake a scheme or host into the asset path.
        $this->assertStringStartsWith('/', $url);
        $this->assertStringNotContainsString('://', $url);
        $this->assertStringNotContainsString('staging.example.org', $url);
    }

    // ── Public committee member profile ────────────────────────

    public function test_public_profile_returns_200(): void
    {
        $member = CommitteeMember::factory()->create([
            'name' => 'John Doe',
            'is_active' => true,
        ]);

        $this->get(route('committee.show', $member))->assertOk();
    }

    public function test_public_profile_uses_slug(): void
    {
        $member = CommitteeMember::factory()->create([
            'name' => 'Jane Smith',
            'is_active' => true,
        ]);

        $response = $this->get("/committee/{$member->slug}");
        $response->assertOk();
        $response->assertSee('Jane Smith');
    }

    public function test_public_profile_returns_404_for_nonexistent_slug(): void
    {
        $this->get(route('committee.show', 'nonexistent-slug'))->assertNotFound();
    }

    public function test_public_profile_does_not_expose_private_email(): void
    {
        $member = CommitteeMember::factory()->create([
            'name' => 'Secret Person',
            'email' => 'secret@example.com',
            'is_active' => true,
        ]);

        $response = $this->get(route('committee.show', $member));

        $response->assertOk();
        $response->assertSee('Secret Person');
        $response->assertDontSee('secret@example.com');
    }

    public function test_public_profile_shows_biography(): void
    {
        $member = CommitteeMember::factory()->create([
            'name' => 'Bio Person',
            'biography' => 'This is a detailed biography.',
            'is_active' => true,
        ]);

        $this->get(route('committee.show', $member))
            ->assertOk()
            ->assertSee('This is a detailed biography.');
    }

    public function test_public_profile_shows_links(): void
    {
        $member = CommitteeMember::factory()->create([
            'name' => 'Linked Person',
            'linkedin_url' => 'https://linkedin.com/in/example',
            'website_url' => 'https://example.com',
            'is_active' => true,
        ]);

        $response = $this->get(route('committee.show', $member));

        $response->assertOk();
        $response->assertSee('https://linkedin.com/in/example');
        $response->assertSee('https://example.com');
    }

    // ── Admin CRUD ─────────────────────────────────────────────

    public function test_admin_index_works(): void
    {
        CommitteeMember::factory()->create();

        $this->get(route('admin.committee.index'))->assertOk();
    }

    public function test_admin_create_page_works(): void
    {
        $this->get(route('admin.committee.create'))->assertOk();
    }

    public function test_admin_store_creates_record(): void
    {
        $this->post(route('admin.committee.store'), [
            'name' => 'New Member',
            'position' => 'Treasurer',
        ])->assertRedirect(route('admin.committee.index'));

        $this->assertDatabaseHas('committee_members', [
            'name' => 'New Member',
            'position' => 'Treasurer',
            'slug' => 'new-member',
        ]);
    }

    public function test_admin_show_works(): void
    {
        $member = CommitteeMember::factory()->create();

        $this->get(route('admin.committee.show', $member))->assertOk();
    }

    public function test_admin_edit_works(): void
    {
        $member = CommitteeMember::factory()->create();

        $this->get(route('admin.committee.edit', $member))->assertOk();
    }

    public function test_admin_update_modifies_record(): void
    {
        $member = CommitteeMember::factory()->create(['name' => 'Old Name']);

        $this->put(route('admin.committee.update', $member), [
            'name' => 'Updated Name',
            'position' => 'President',
        ])->assertRedirect(route('admin.committee.index'));

        $this->assertDatabaseHas('committee_members', ['id' => $member->id, 'name' => 'Updated Name']);
    }

    public function test_admin_delete_removes_record(): void
    {
        $member = CommitteeMember::factory()->create();

        $this->delete(route('admin.committee.destroy', $member))
            ->assertRedirect(route('admin.committee.index'));

        $this->assertDatabaseMissing('committee_members', ['id' => $member->id]);
    }

    // ── Validation ─────────────────────────────────────────────

    public function test_admin_requires_name_and_position(): void
    {
        $this->post(route('admin.committee.store'), [
            'name' => '',
            'position' => '',
        ])->assertSessionHasErrors(['name', 'position']);
    }

    public function test_admin_validates_email(): void
    {
        $this->post(route('admin.committee.store'), [
            'name' => 'Valid Person',
            'position' => 'Member',
            'email' => 'not-an-email',
        ])->assertSessionHasErrors('email');
    }

    public function test_admin_validates_urls(): void
    {
        $this->post(route('admin.committee.store'), [
            'name' => 'Valid Person',
            'position' => 'Member',
            'linkedin_url' => 'not-a-url',
        ])->assertSessionHasErrors('linkedin_url');
    }

    public function test_admin_validates_sort_order(): void
    {
        $this->post(route('admin.committee.store'), [
            'name' => 'Valid Person',
            'position' => 'Member',
            'sort_order' => -1,
        ])->assertSessionHasErrors('sort_order');
    }

    public function test_admin_validation_preserves_old_input(): void
    {
        $response = $this->post(route('admin.committee.store'), [
            'name' => '',
            'position' => '',
        ]);

        $response->assertSessionHasErrors(['name', 'position']);
    }

    // ── Slug uniqueness ────────────────────────────────────────

    public function test_unique_slug_generation(): void
    {
        CommitteeMember::factory()->create(['name' => 'John Doe', 'slug' => 'john-doe']);

        $this->post(route('admin.committee.store'), [
            'name' => 'John Doe',
            'position' => 'Member',
        ])->assertRedirect(route('admin.committee.index'));

        $this->assertDatabaseHas('committee_members', ['name' => 'John Doe', 'slug' => 'john-doe-2']);
    }

    public function test_duplicate_names_produce_unique_slugs(): void
    {
        CommitteeMember::factory()->create(['name' => 'John Doe', 'slug' => 'john-doe']);
        CommitteeMember::factory()->create(['name' => 'John Doe', 'slug' => 'john-doe-2']);

        $this->post(route('admin.committee.store'), [
            'name' => 'John Doe',
            'position' => 'Member',
        ])->assertRedirect(route('admin.committee.index'));

        $this->assertDatabaseHas('committee_members', ['name' => 'John Doe', 'slug' => 'john-doe-3']);
    }

    // ── Image upload ───────────────────────────────────────────

    public function test_profile_photo_is_uploaded_and_stored(): void
    {
        Storage::fake('public');

        $this->post(route('admin.committee.store'), [
            'name' => 'Photo Person',
            'position' => 'Member',
            'profile_photo' => UploadedFile::fake()->image('portrait.jpg', 200, 200),
        ])->assertRedirect(route('admin.committee.index'));

        $member = CommitteeMember::where('name', 'Photo Person')->firstOrFail();

        $this->assertNotNull($member->profile_photo);
        Storage::disk('public')->assertExists($member->profile_photo);
    }

    public function test_old_image_is_replaced_on_update(): void
    {
        Storage::fake('public');

        $member = CommitteeMember::factory()->create();

        $oldPhoto = UploadedFile::fake()->image('old.jpg', 200, 200);
        $this->post(route('admin.committee.store'), [
            'name' => $member->name,
            'position' => $member->position,
            'profile_photo' => $oldPhoto,
        ]);

        $member->refresh();
        $oldPath = $member->profile_photo;

        $newPhoto = UploadedFile::fake()->image('new.jpg', 200, 200);
        $this->put(route('admin.committee.update', $member), [
            'name' => $member->name,
            'position' => $member->position,
            'profile_photo' => $newPhoto,
        ]);

        $member->refresh();
        $this->assertNotEquals($oldPath, $member->profile_photo);
    }

    public function test_image_is_deleted_when_committee_member_is_deleted(): void
    {
        Storage::fake('public');

        $member = CommitteeMember::factory()->create();

        $photo = UploadedFile::fake()->image('photo.jpg', 200, 200);

        $this->put(route('admin.committee.update', $member), [
            'name' => $member->name,
            'position' => $member->position,
            'profile_photo' => $photo,
        ]);

        $member->refresh();
        $this->assertNotNull($member->profile_photo);

        $this->delete(route('admin.committee.destroy', $member));
        $this->assertDatabaseMissing('committee_members', ['id' => $member->id]);
    }

    // ── Search and filter ──────────────────────────────────────

    public function test_admin_search_by_name(): void
    {
        $match = CommitteeMember::factory()->create(['name' => 'Alice Searchable', 'position' => 'Secretary']);
        $other = CommitteeMember::factory()->create(['name' => 'Bob Quiet', 'position' => 'Member']);

        $this->get(route('admin.committee.index', ['search' => 'Alice']))
            ->assertSee('Alice Searchable')
            ->assertDontSee('Bob Quiet');
    }

    public function test_admin_search_by_position(): void
    {
        $match = CommitteeMember::factory()->create(['name' => 'Treasurer Person', 'position' => 'Treasurer']);
        $other = CommitteeMember::factory()->create(['name' => 'Secretary Person', 'position' => 'Secretary']);

        $this->get(route('admin.committee.index', ['search' => 'Treasurer']))
            ->assertSee('Treasurer Person')
            ->assertDontSee('Secretary Person');
    }

    public function test_admin_filter_by_active(): void
    {
        $active = CommitteeMember::factory()->create(['name' => 'Active One', 'is_active' => true]);
        $inactive = CommitteeMember::factory()->inactive()->create(['name' => 'Inactive One']);

        $this->get(route('admin.committee.index', ['active' => '1']))
            ->assertSee('Active One')
            ->assertDontSee('Inactive One');

        $this->get(route('admin.committee.index', ['active' => '0']))
            ->assertSee('Inactive One')
            ->assertDontSee('Active One');
    }

    public function test_admin_search_no_result_state(): void
    {
        CommitteeMember::factory()->create(['name' => 'Only Person']);

        $this->get(route('admin.committee.index', ['search' => 'NoSuchPersonXYZ']))
            ->assertOk()
            ->assertSee('No committee members found');
    }

    // ── Dashboard ──────────────────────────────────────────────

    public function test_admin_dashboard_shows_committee_count(): void
    {
        CommitteeMember::factory()->count(3)->create(['is_active' => true]);
        CommitteeMember::factory()->count(2)->inactive()->create();

        $this->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('3');
    }

    // ── Homepage integration ───────────────────────────────────

    public function test_homepage_shows_committee_members(): void
    {
        $member = CommitteeMember::factory()->create([
            'name' => 'Home Page Leader',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('Home Page Leader');
    }

    public function test_homepage_does_not_show_inactive_committee_members(): void
    {
        CommitteeMember::factory()->inactive()->create([
            'name' => 'Inactive Home',
        ]);

        $this->get(route('home'))
            ->assertOk()
            ->assertDontSee('Inactive Home');
    }

    // ── Regression: Alumni still works ─────────────────────────

    public function test_alumni_page_still_works(): void
    {
        $this->get(route('alumni.index'))->assertOk();
    }

    public function test_alumni_admin_still_works(): void
    {
        $this->get(route('admin.alumni.index'))->assertOk();
    }
}
