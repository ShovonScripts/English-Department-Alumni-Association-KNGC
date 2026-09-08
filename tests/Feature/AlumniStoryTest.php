<?php

namespace Tests\Feature;

use App\Models\Alumni;
use App\Models\AlumniStory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AlumniStoryTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->admin()->create(['password' => Hash::make('password')]);
        $this->password = 'password';
        $this->actingAs($this->admin);
    }

    // ──────────────────────────────────────────
    // MODEL TESTS
    // ──────────────────────────────────────────

    public function test_alumni_story_model_route_key_name(): void
    {
        $story = new AlumniStory;
        $this->assertSame('slug', $story->getRouteKeyName());
    }

    public function test_alumni_story_belongs_to_alumni(): void
    {
        $alumni = Alumni::factory()->create();
        $story = AlumniStory::factory()->published()->create(['alumni_id' => $alumni->id]);
        $this->assertNotNull($story->alumni);
        $this->assertSame($alumni->id, $story->alumni->id);
    }

    public function test_alumni_has_many_stories(): void
    {
        $alumni = Alumni::factory()->create();
        AlumniStory::factory()->count(3)->create(['alumni_id' => $alumni->id]);
        $this->assertCount(3, $alumni->stories);
    }

    public function test_alumni_story_unique_slug_collision_avoidance(): void
    {
        AlumniStory::factory()->create(['title' => 'Collision Test', 'slug' => 'collision-test']);
        $slug = AlumniStory::uniqueSlug('Collision Test');
        $this->assertNotSame('collision-test', $slug);
    }

    public function test_alumni_story_scope_published(): void
    {
        AlumniStory::factory()->published()->count(3)->create();
        AlumniStory::factory()->draft()->count(2)->create();
        $this->assertCount(3, AlumniStory::published()->get());
    }

    public function test_alumni_story_scope_draft(): void
    {
        AlumniStory::factory()->published()->count(2)->create();
        AlumniStory::factory()->draft()->count(4)->create();
        $this->assertCount(4, AlumniStory::draft()->get());
    }

    public function test_alumni_story_scope_featured(): void
    {
        AlumniStory::factory()->published()->featured()->count(2)->create();
        AlumniStory::factory()->published()->count(5)->create(['is_featured' => false]);
        $this->assertCount(2, AlumniStory::featured()->get());
    }

    public function test_alumni_story_cover_image_url_accessor(): void
    {
        $story = AlumniStory::factory()->create(['cover_image' => 'test-cover.jpg']);
        $this->assertNotNull($story->cover_image_url);
        $this->assertStringContainsString('test-cover.jpg', $story->cover_image_url);
    }

    public function test_alumni_story_factory_states(): void
    {
        $published = AlumniStory::factory()->published()->create();
        $this->assertSame('published', $published->status);
        $this->assertNotNull($published->published_at);

        $draft = AlumniStory::factory()->draft()->create();
        $this->assertSame('draft', $draft->status);

        $featured = AlumniStory::factory()->featured()->create();
        $this->assertTrue($featured->is_featured);
    }

    // ──────────────────────────────────────────
    // PUBLIC: /stories
    // ──────────────────────────────────────────

    public function test_public_stories_page_returns_200(): void
    {
        AlumniStory::factory()->published()->create();
        $this->get(route('stories.index'))->assertOk();
    }

    public function test_public_stories_page_shows_only_published_stories(): void
    {
        AlumniStory::factory()->published()->create(['title' => 'Published Story', 'excerpt' => 'Published excerpt text']);
        AlumniStory::factory()->draft()->create(['title' => 'Draft Story', 'excerpt' => 'Draft excerpt text']);
        $response = $this->get(route('stories.index'));
        $response->assertOk();
        $response->assertSee('Published excerpt text');
        $response->assertDontSee('Draft excerpt text');
    }

    public function test_public_stories_page_hides_future_dated_stories(): void
    {
        AlumniStory::factory()->published()->create(['title' => 'Current Story', 'excerpt' => 'Current excerpt']);
        AlumniStory::factory()->future()->create(['title' => 'Future Story', 'excerpt' => 'Future excerpt']);
        $response = $this->get(route('stories.index'));
        $response->assertSee('Current excerpt');
        $response->assertDontSee('Future excerpt');
    }

    public function test_public_stories_page_shows_featured_stories(): void
    {
        AlumniStory::factory()->published()->featured()->create(['title' => 'Featured Story', 'excerpt' => 'Featured excerpt text']);
        $response = $this->get(route('stories.index'));
        $response->assertSee('Featured excerpt text');
        $response->assertSee('Featured');
    }

    public function test_public_stories_page_can_search_by_title(): void
    {
        AlumniStory::factory()->published()->create(['title' => 'Alumni Career Journey', 'excerpt' => 'Career excerpt']);
        AlumniStory::factory()->published()->create(['title' => 'Poetry Collection', 'excerpt' => 'Poetry excerpt']);
        $response = $this->get(route('stories.index', ['search' => 'Career']));
        $response->assertSee('Career excerpt');
        $response->assertDontSee('Poetry excerpt');
    }

    public function test_public_stories_page_can_search_by_alumni_name(): void
    {
        $alumni = Alumni::factory()->create(['full_name' => 'Adaeze Okafor']);
        AlumniStory::factory()->published()->create(['alumni_id' => $alumni->id, 'title' => 'Adaeze Story', 'excerpt' => 'Adaeze excerpt text']);
        $otherAlumni = Alumni::factory()->create(['full_name' => 'Kwame Mensah']);
        AlumniStory::factory()->published()->create(['alumni_id' => $otherAlumni->id, 'title' => 'Kwame Story', 'excerpt' => 'Kwame excerpt text']);
        $response = $this->get(route('stories.index', ['search' => 'Adaeze']));
        $response->assertSee('Adaeze excerpt text');
        $response->assertDontSee('Kwame excerpt text');
    }

    public function test_public_stories_page_empty_state(): void
    {
        $response = $this->get(route('stories.index'));
        $response->assertOk();
        $response->assertSee('No stories found');
    }

    public function test_public_stories_page_pagination(): void
    {
        AlumniStory::factory()->published()->count(15)->create();
        $response = $this->get(route('stories.index'));
        $response->assertOk();
        $response->assertSee('1');
    }

    // ──────────────────────────────────────────
    // PUBLIC: /stories/{slug}
    // ──────────────────────────────────────────

    public function test_public_story_detail_returns_200(): void
    {
        $story = AlumniStory::factory()->published()->create();
        $this->get(route('stories.show', $story))->assertOk();
    }

    public function test_public_story_detail_shows_story_data(): void
    {
        $story = AlumniStory::factory()->published()->create([
            'title' => 'Test Story Title',
            'excerpt' => 'Test excerpt content',
            'content' => 'Full story content here',
        ]);
        $response = $this->get(route('stories.show', $story));
        $response->assertOk();
        $response->assertSee('Test Story Title');
        $response->assertSee('Test excerpt content');
        $response->assertSee('Full story content here');
    }

    public function test_public_story_detail_shows_alumni_name(): void
    {
        $alumni = Alumni::factory()->create(['full_name' => 'Mercy Uche']);
        $story = AlumniStory::factory()->published()->create(['alumni_id' => $alumni->id]);
        $response = $this->get(route('stories.show', $story));
        $response->assertSee('Mercy Uche');
    }

    public function test_public_story_detail_shows_author(): void
    {
        $story = AlumniStory::factory()->published()->create(['author_name' => 'Professor Milki Amatul Mogni']);
        $response = $this->get(route('stories.show', $story));
        $response->assertSee('Professor Milki Amatul Mogni');
    }

    public function test_public_story_detail_shows_breadcrumbs(): void
    {
        $story = AlumniStory::factory()->published()->create();
        $response = $this->get(route('stories.show', $story));
        $response->assertSee('Home');
        $response->assertSee('Stories');
    }

    public function test_public_story_detail_draft_returns_404(): void
    {
        $story = AlumniStory::factory()->draft()->create();
        $this->get(route('stories.show', $story))->assertNotFound();
    }

    public function test_public_story_detail_future_returns_404(): void
    {
        $story = AlumniStory::factory()->future()->create();
        $this->get(route('stories.show', $story))->assertNotFound();
    }

    public function test_public_story_detail_invalid_slug_returns_404(): void
    {
        $this->get('/stories/non-existent-slug-xyz')->assertNotFound();
    }

    public function test_story_cards_link_to_story_detail(): void
    {
        $story = AlumniStory::factory()->published()->create(['title' => 'Clickable Story']);

        // Directory: the story card must render an anchor to the detail page.
        $indexContent = $this->get(route('stories.index'))->getContent();
        $this->assertStringContainsString(
            'href="'.route('stories.show', $story).'"',
            $indexContent,
            'Story cards on /stories must link to the story detail page.'
        );

        // Homepage: same card component, same requirement.
        $homeContent = $this->get(route('home'))->getContent();
        $this->assertStringContainsString(
            'href="'.route('stories.show', $story).'"',
            $homeContent,
            'Story cards on the homepage must link to the story detail page.'
        );
    }

    public function test_related_story_cards_link_to_story_detail(): void
    {
        $alumni = Alumni::factory()->create();
        $story = AlumniStory::factory()->published()->create(['alumni_id' => $alumni->id]);
        $related = AlumniStory::factory()->published()->create([
            'alumni_id' => $alumni->id,
            'title' => 'Linked Related Story',
        ]);

        $content = $this->get(route('stories.show', $story))->getContent();

        $this->assertStringContainsString(
            'href="'.route('stories.show', $related).'"',
            $content,
            'Related story cards must link to the related story detail page.'
        );
    }

    public function test_public_story_json_ld_contains_url_and_absolute_image(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('alumni-stories/cover.jpg', 'fake-image');

        $story = AlumniStory::factory()->published()->create([
            'cover_image' => 'alumni-stories/cover.jpg',
            'author_name' => 'QA Author',
        ]);

        $content = $this->get(route('stories.show', $story))->getContent();

        preg_match('/<script type="application\/ld\+json">\s*(.*?)\s*<\/script>/s', $content, $m);
        $this->assertNotEmpty($m, 'JSON-LD script tag should be present.');

        $json = json_decode($m[1], true);
        $this->assertIsArray($json, 'JSON-LD must be valid JSON.');
        $this->assertSame('Article', $json['@type']);
        $this->assertSame($story->title, $json['headline']);

        // The story url must be present and absolute.
        $this->assertSame(route('stories.show', $story), $json['url']);
        $this->assertTrue(str_starts_with($json['url'], 'http'));

        // The image must be an array containing one absolute URL that
        // resolves to the stored file path.
        $this->assertIsArray($json['image']);
        $this->assertCount(1, $json['image']);
        $this->assertStringEndsWith('/storage/alumni-stories/cover.jpg', $json['image'][0]);
        $this->assertTrue(str_starts_with($json['image'][0], 'http'));
    }

    public function test_public_story_detail_shows_related_stories(): void
    {
        $alumni = Alumni::factory()->create();
        $story = AlumniStory::factory()->published()->create(['alumni_id' => $alumni->id, 'title' => 'Main Story', 'excerpt' => 'Main excerpt']);
        AlumniStory::factory()->published()->create(['alumni_id' => $alumni->id, 'title' => 'Related Story 1', 'excerpt' => 'Related excerpt one']);
        AlumniStory::factory()->published()->create(['alumni_id' => $alumni->id, 'title' => 'Related Story 2', 'excerpt' => 'Related excerpt two']);
        $response = $this->get(route('stories.show', $story));
        $response->assertSee('Related excerpt one');
        $response->assertSee('Related excerpt two');
        $response->assertSee('Related stories');
    }

    public function test_public_story_detail_excludes_self_from_related(): void
    {
        $alumni = Alumni::factory()->create();
        $story = AlumniStory::factory()->published()->create(['alumni_id' => $alumni->id, 'title' => 'Self Story']);
        $response = $this->get(route('stories.show', $story));
        $related = $response->viewData('relatedStories');
        $this->assertTrue($related->every(fn ($item) => $item->id !== $story->id));
    }

    // ──────────────────────────────────────────
    // ALUMNI PROFILE INTEGRATION
    // ──────────────────────────────────────────

    public function test_alumni_profile_shows_published_stories(): void
    {
        $alumni = Alumni::factory()->create();
        AlumniStory::factory()->published()->create(['alumni_id' => $alumni->id, 'title' => 'Published Profile Story']);
        $response = $this->get(route('alumni.show', $alumni));
        $stories = $response->viewData('stories');
        $this->assertTrue($stories->contains('title', 'Published Profile Story'));
    }

    public function test_alumni_profile_hides_draft_stories(): void
    {
        $alumni = Alumni::factory()->create();
        AlumniStory::factory()->draft()->create(['alumni_id' => $alumni->id, 'title' => 'Draft Profile Story']);
        $response = $this->get(route('alumni.show', $alumni));
        $stories = $response->viewData('stories');
        $this->assertFalse($stories->contains('title', 'Draft Profile Story'));
    }

    public function test_alumni_profile_hides_future_stories(): void
    {
        $alumni = Alumni::factory()->create();
        AlumniStory::factory()->future()->create(['alumni_id' => $alumni->id, 'title' => 'Future Profile Story']);
        $response = $this->get(route('alumni.show', $alumni));
        $stories = $response->viewData('stories');
        $this->assertFalse($stories->contains('title', 'Future Profile Story'));
    }

    // ──────────────────────────────────────────
    // HOMEPAGE INTEGRATION
    // ──────────────────────────────────────────

    public function test_homepage_displays_latest_stories(): void
    {
        AlumniStory::factory()->published()->create(['title' => 'Homepage Story Article', 'excerpt' => 'Homepage excerpt text']);
        $response = $this->get(route('home'));
        $response->assertOk();
        $response->assertSee('Homepage excerpt text');
    }

    public function test_homepage_hides_draft_stories(): void
    {
        AlumniStory::factory()->draft()->create(['title' => 'Draft on Homepage', 'excerpt' => 'Draft excerpt on homepage']);
        $response = $this->get(route('home'));
        $response->assertDontSee('Draft excerpt on homepage');
    }

    public function test_homepage_stories_section_uses_database(): void
    {
        AlumniStory::factory()->published()->count(3)->create();
        $response = $this->get(route('home'));
        $response->assertOk();
    }

    // ──────────────────────────────────────────
    // ADMIN: STORIES CRUD
    // ──────────────────────────────────────────

    public function test_admin_stories_index_returns_200(): void
    {
        $this->get(route('admin.stories.index'))->assertOk();
    }

    public function test_admin_stories_index_lists_stories(): void
    {
        AlumniStory::factory()->published()->create(['title' => 'Admin Listed Story']);
        $response = $this->get(route('admin.stories.index'));
        $response->assertSee('Admin Listed Story');
    }

    public function test_admin_stories_index_can_search(): void
    {
        AlumniStory::factory()->published()->create(['title' => 'Alumni Gathering']);
        AlumniStory::factory()->published()->create(['title' => 'Poetry Reading']);
        $response = $this->get(route('admin.stories.index', ['search' => 'Alumni']));
        $response->assertSee('Alumni Gathering');
        $response->assertDontSee('Poetry Reading');
    }

    public function test_admin_stories_index_can_filter_by_status(): void
    {
        AlumniStory::factory()->published()->create(['title' => 'Published One']);
        AlumniStory::factory()->draft()->create(['title' => 'Draft One']);
        $response = $this->get(route('admin.stories.index', ['status' => 'published']));
        $response->assertSee('Published One');
        $response->assertDontSee('Draft One');
    }

    public function test_admin_stories_index_can_filter_by_featured(): void
    {
        AlumniStory::factory()->published()->featured()->create(['title' => 'Featured Story']);
        AlumniStory::factory()->published()->create(['title' => 'Regular Story', 'is_featured' => false]);
        $response = $this->get(route('admin.stories.index', ['is_featured' => '1']));
        $response->assertSee('Featured Story');
        $response->assertDontSee('Regular Story');
    }

    public function test_admin_stories_index_empty_state(): void
    {
        $response = $this->get(route('admin.stories.index'));
        $response->assertSee('No stories found');
    }

    public function test_admin_stories_create_returns_200(): void
    {
        Alumni::factory()->create();
        $this->get(route('admin.stories.create'))->assertOk();
    }

    public function test_admin_stories_store_creates_story(): void
    {
        $alumni = Alumni::factory()->create();
        $data = [
            'title' => 'New Test Story',
            'alumni_id' => $alumni->id,
            'excerpt' => 'Test excerpt for the story',
            'content' => 'Full content of the test story',
            'status' => 'draft',
        ];
        $this->post(route('admin.stories.store'), $data)->assertRedirect();
        $this->assertDatabaseHas('alumni_stories', ['title' => 'New Test Story', 'status' => 'draft']);
    }

    public function test_admin_stories_store_validates_required_fields(): void
    {
        $this->post(route('admin.stories.store'), [])->assertSessionHasErrors(['title', 'alumni_id', 'excerpt', 'content', 'status']);
    }

    public function test_admin_stories_store_generates_unique_slug(): void
    {
        $alumni = Alumni::factory()->create();
        $this->post(route('admin.stories.store'), [
            'title' => 'Unique Slug Story',
            'alumni_id' => $alumni->id,
            'excerpt' => 'Excerpt',
            'content' => 'Content',
            'status' => 'draft',
        ])->assertRedirect();
        $this->assertDatabaseHas('alumni_stories', ['slug' => 'unique-slug-story']);
    }

    public function test_admin_stories_store_sets_published_at_when_publishing(): void
    {
        $alumni = Alumni::factory()->create();
        $this->post(route('admin.stories.store'), [
            'title' => 'Auto Publish Date Story',
            'alumni_id' => $alumni->id,
            'excerpt' => 'Excerpt',
            'content' => 'Content',
            'status' => 'published',
        ])->assertRedirect();
        $this->assertDatabaseHas('alumni_stories', ['title' => 'Auto Publish Date Story', 'status' => 'published']);
        $story = AlumniStory::where('title', 'Auto Publish Date Story')->first();
        $this->assertNotNull($story->published_at);
    }

    public function test_admin_stories_store_with_cover_image(): void
    {
        Storage::fake('public');
        $alumni = Alumni::factory()->create();
        $image = UploadedFile::fake()->image('cover.jpg', 800, 600)->size(100);
        $this->post(route('admin.stories.store'), [
            'title' => 'Image Test Story',
            'alumni_id' => $alumni->id,
            'excerpt' => 'Excerpt',
            'content' => 'Content',
            'status' => 'draft',
            'cover_image' => $image,
        ])->assertRedirect();
        $story = AlumniStory::where('title', 'Image Test Story')->first();
        $this->assertNotNull($story->cover_image);
        Storage::disk('public')->assertExists($story->cover_image);
    }

    public function test_admin_stories_store_validates_alumni_exists(): void
    {
        $this->post(route('admin.stories.store'), [
            'title' => 'No Alumni Story',
            'excerpt' => 'Excerpt',
            'content' => 'Content',
            'status' => 'draft',
        ])->assertSessionHasErrors(['alumni_id']);
    }

    // ──────────────────────────────────────────
    // ADMIN: SHOW / EDIT / UPDATE / DELETE
    // ──────────────────────────────────────────

    public function test_admin_stories_show_returns_200(): void
    {
        $story = AlumniStory::factory()->create();
        $this->get(route('admin.stories.show', $story))->assertOk();
    }

    public function test_admin_stories_edit_returns_200(): void
    {
        Alumni::factory()->create();
        $story = AlumniStory::factory()->create();
        $this->get(route('admin.stories.edit', $story))->assertOk();
    }

    public function test_admin_stories_update_modifies_story(): void
    {
        $story = AlumniStory::factory()->create(['title' => 'Original Title']);
        $this->put(route('admin.stories.update', $story), [
            'title' => 'Updated Title',
            'alumni_id' => $story->alumni_id,
            'excerpt' => 'Updated excerpt',
            'content' => 'Updated content',
            'status' => 'draft',
        ])->assertRedirect();
        $this->assertDatabaseHas('alumni_stories', ['id' => $story->id, 'title' => 'Updated Title']);
    }

    public function test_admin_stories_update_replaces_image(): void
    {
        Storage::fake('public');
        $story = AlumniStory::factory()->create();
        $newImage = UploadedFile::fake()->image('new.jpg', 800, 600)->size(100);
        $this->put(route('admin.stories.update', $story), [
            'title' => $story->title,
            'alumni_id' => $story->alumni_id,
            'excerpt' => $story->excerpt,
            'content' => $story->content,
            'status' => 'draft',
            'cover_image' => $newImage,
        ])->assertRedirect();
        $story->refresh();
        $this->assertNotNull($story->cover_image);
    }

    public function test_admin_stories_update_clears_image(): void
    {
        $story = AlumniStory::factory()->create(['cover_image' => 'test-image.jpg']);
        $this->put(route('admin.stories.update', $story), [
            'title' => $story->title,
            'alumni_id' => $story->alumni_id,
            'excerpt' => $story->excerpt,
            'content' => $story->content,
            'status' => 'draft',
            'clear_image' => '1',
        ])->assertRedirect();
        $story->refresh();
        $this->assertNull($story->cover_image);
    }

    public function test_admin_stories_destroy_deletes_story(): void
    {
        $story = AlumniStory::factory()->create();
        $this->delete(route('admin.stories.destroy', $story))->assertRedirect();
        $this->assertDatabaseMissing('alumni_stories', ['id' => $story->id]);
    }

    public function test_admin_stories_destroy_deletes_image_file(): void
    {
        Storage::fake('public');
        // cover_image stores the path returned by ->store('alumni-stories', 'public'),
        // which already includes the "alumni-stories/" prefix.
        $story = AlumniStory::factory()->create(['cover_image' => 'alumni-stories/to-delete.jpg']);
        Storage::disk('public')->put('alumni-stories/to-delete.jpg', 'fake');
        $this->delete(route('admin.stories.destroy', $story))->assertRedirect();
        Storage::disk('public')->assertMissing('alumni-stories/to-delete.jpg');
    }

    public function test_admin_stories_update_replaces_image_and_deletes_old_file(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('alumni-stories/old.png', 'old-image');

        $alumni = Alumni::factory()->create();
        $story = AlumniStory::factory()->create([
            'alumni_id' => $alumni->id,
            'cover_image' => 'alumni-stories/old.png',
        ]);

        $replacement = UploadedFile::fake()->image('new.jpg', 800, 600)->size(100);
        $this->put(route('admin.stories.update', $story), [
            'title' => $story->title,
            'alumni_id' => $alumni->id,
            'excerpt' => $story->excerpt,
            'content' => $story->content,
            'status' => 'draft',
            'cover_image' => $replacement,
        ])->assertRedirect();

        $story->refresh();
        $this->assertNotNull($story->cover_image);
        $this->assertNotSame('alumni-stories/old.png', $story->cover_image);
        Storage::disk('public')->assertExists($story->cover_image);
        Storage::disk('public')->assertMissing('alumni-stories/old.png');
    }

    public function test_admin_stories_store_rejects_oversized_dimensions_image(): void
    {
        // Small file size, but pixel dimensions exceed the 5000px guard.
        $image = UploadedFile::fake()->image('huge.png', 5500, 5500)->size(100);
        $this->post(route('admin.stories.store'), [
            'title' => 'Oversized Dimensions Story',
            'excerpt' => 'Excerpt',
            'content' => 'Content',
            'status' => 'draft',
            'cover_image' => $image,
        ])->assertSessionHasErrors(['cover_image']);

        $this->assertDatabaseMissing('alumni_stories', ['title' => 'Oversized Dimensions Story']);
    }
}
