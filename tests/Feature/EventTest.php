<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\EventCategory;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class EventTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->admin()->create(['password' => Hash::make('password')]);
        $this->password = 'password';
        $this->actingAs($this->admin);
    }

    public function test_public_events_page_returns_200(): void
    {
        Event::factory()->published()->upcoming()->create();
        $this->get(route('events.index'))->assertOk();
    }

    public function test_public_events_page_shows_only_published_events(): void
    {
        Event::factory()->published()->upcoming()->create(['title' => 'Published Event']);
        Event::factory()->create(['title' => 'Draft Event', 'status' => 'draft']);
        $response = $this->get(route('events.index'));
        $response->assertOk();
        $response->assertSee('Published Event');
        $response->assertDontSee('Draft Event');
    }

    public function test_public_events_page_separates_upcoming_and_past(): void
    {
        Event::factory()->published()->upcoming()->create(['title' => 'Upcoming Event']);
        Event::factory()->published()->past()->create(['title' => 'Past Event']);
        $response = $this->get(route('events.index'));
        $response->assertOk();
        $response->assertSee('Upcoming Event');
        $response->assertSee('Past Event');
    }

    public function test_public_events_page_can_filter_by_search(): void
    {
        Event::factory()->published()->upcoming()->create(['title' => 'Annual Alumni Lecture']);
        Event::factory()->published()->upcoming()->create(['title' => 'Poetry Evening']);
        $response = $this->get(route('events.index', ['search' => 'Lecture']));
        $response->assertOk();
        $response->assertSee('Annual Alumni Lecture');
        $response->assertDontSee('Poetry Evening');
    }

    public function test_public_events_page_can_filter_by_category(): void
    {
        $category = EventCategory::create(['name' => 'Lecture', 'slug' => 'lecture']);
        $otherCategory = EventCategory::create(['name' => 'Social', 'slug' => 'social']);
        Event::factory()->published()->upcoming()->create(['category_id' => $category->id, 'title' => 'Lecture Event']);
        Event::factory()->published()->upcoming()->create(['category_id' => $otherCategory->id, 'title' => 'Social Event']);
        $response = $this->get(route('events.index', ['category_id' => $category->id]));
        $response->assertOk();
        $response->assertSee('Lecture Event');
        $response->assertDontSee('Social Event');
    }

    public function test_public_events_page_can_filter_by_timing(): void
    {
        Event::factory()->published()->upcoming()->create(['title' => 'Future Event']);
        Event::factory()->published()->past()->create(['title' => 'Old Event']);
        $response = $this->get(route('events.index', ['timing' => 'upcoming']));
        $response->assertOk();
        $response->assertSee('Future Event');
        $response->assertDontSee('Old Event');
    }

    public function test_public_events_page_empty_state(): void
    {
        $response = $this->get(route('events.index'));
        $response->assertOk();
        $response->assertSee('No events yet');
    }

    public function test_public_event_detail_returns_200(): void
    {
        $event = Event::factory()->published()->create();
        $this->get(route('events.show', $event))->assertOk();
    }

    public function test_public_event_detail_shows_event_data(): void
    {
        $event = Event::factory()->published()->create([
            'title' => 'Lecture Test Event',
            'description' => '<p>Test event description.</p>',
        ]);
        $response = $this->get(route('events.show', $event));
        $response->assertOk();
        $response->assertSee('Lecture Test Event');
        $response->assertSee('Test event description.');
    }

    public function test_public_event_detail_shows_category(): void
    {
        $category = EventCategory::create(['name' => 'Lecture', 'slug' => 'lecture']);
        $event = Event::factory()->published()->create(['category_id' => $category->id]);
        $response = $this->get(route('events.show', $event));
        $response->assertOk();
        $response->assertSee('Lecture');
    }

    public function test_public_event_detail_shows_location(): void
    {
        $event = Event::factory()->published()->create([
            'venue' => 'Great Hall',
            'city' => 'Lagos',
            'country' => 'Nigeria',
        ]);
        $response = $this->get(route('events.show', $event));
        $response->assertOk();
        $response->assertSee('Great Hall');
    }

    public function test_public_event_detail_404_for_draft_events(): void
    {
        $event = Event::factory()->create(['status' => 'draft']);
        $this->get(route('events.show', $event))->assertNotFound();
    }

    public function test_public_event_detail_includes_json_ld(): void
    {
        $event = Event::factory()->published()->create([
            'title' => 'Test JSON-LD Event',
            'description' => 'Test.',
        ]);
        $response = $this->get(route('events.show', $event));
        $response->assertOk();
        $response->assertSee('application/ld+json');
        $response->assertSee('Test JSON-LD Event');
    }

    public function test_public_event_json_ld_contains_url_and_absolute_image(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('events/cover.jpg', 'image');
        $event = Event::factory()->published()->create([
            'title' => 'Schema Event',
            'cover_image' => 'events/cover.jpg',
        ]);

        $response = $this->get(route('events.show', $event));
        $response->assertOk();

        preg_match('/<script type="application\/ld\+json">(.*?)<\/script>/s', $response->getContent(), $m);
        $this->assertNotEmpty($m, 'JSON-LD script tag should be present.');

        $json = json_decode($m[1], true);
        $this->assertIsArray($json, 'JSON-LD must be valid JSON.');
        $this->assertSame('Event', $json['@type']);

        // The event url must be present and absolute.
        $this->assertSame(route('events.show', $event), $json['url']);
        $this->assertTrue(str_starts_with($json['url'], 'http'));

        // The image must be an absolute URL pointing at the stored file,
        // resolved against the current request root (never a relative path).
        $this->assertIsArray($json['image']);
        $this->assertCount(1, $json['image']);
        $this->assertStringEndsWith('/storage/events/cover.jpg', $json['image'][0]);
        $this->assertTrue(str_starts_with($json['image'][0], 'http'));
    }

    public function test_public_event_detail_title_uses_em_dash(): void
    {
        $event = Event::factory()->published()->create([
            'title' => 'Plain Title Event',
        ]);

        $content = $this->get(route('events.show', $event))->getContent();

        // Human-readable em dash in the browser title (layout appends site name).
        $this->assertStringContainsString('<title>Plain Title Event — Events |', $content);
        $this->assertStringNotContainsString('&mdash;', $content);
        $this->assertStringNotContainsString('&amp;mdash;', $content);
    }

    public function test_public_event_description_renders_plain_text_safely(): void
    {
        $event = Event::factory()->published()->create([
            'description' => "First paragraph of the brief.\n\nSecond paragraph with a <script>alert('xss')</script> attempt and <p>faked</p> markup.",
        ]);

        $content = $this->get(route('events.show', $event))->getContent();

        // Text content is visible.
        $this->assertStringContainsString('First paragraph of the brief.', $content);
        $this->assertStringContainsString('Second paragraph with a', $content);

        // Markup is never executed: no raw tags in output, entities escaped.
        $this->assertStringNotContainsString('<script>alert(', $content);
        $this->assertStringNotContainsString('<p>faked</p>', $content);
        $this->assertStringContainsString('&lt;script&gt;', $content);

        // Paragraph breaks are converted to line breaks for readability.
        $this->assertStringContainsString('brief.<br />', $content);
        $this->assertStringContainsString('<br />', $content);
    }

    public function test_admin_events_index_returns_200(): void
    {
        Event::factory()->create();
        $this->get(route('admin.events.index'))->assertOk();
    }

    public function test_admin_events_index_lists_all_events(): void
    {
        Event::factory()->create(['title' => 'Admin Listed Event']);
        $response = $this->get(route('admin.events.index'));
        $response->assertOk();
        $response->assertSee('Admin Listed Event');
    }

    public function test_admin_events_index_can_filter_by_status(): void
    {
        Event::factory()->published()->create(['title' => 'Published Event']);
        Event::factory()->create(['title' => 'Draft Event', 'status' => 'draft']);
        $response = $this->get(route('admin.events.index', ['status' => 'published']));
        $response->assertOk();
        $response->assertSee('Published Event');
        $response->assertDontSee('Draft Event');
    }

    public function test_admin_events_index_can_search(): void
    {
        Event::factory()->create(['title' => 'Annual Lecture']);
        Event::factory()->create(['title' => 'Poetry Evening']);
        $response = $this->get(route('admin.events.index', ['search' => 'Poetry']));
        $response->assertOk();
        $response->assertSee('Poetry Evening');
        $response->assertDontSee('Annual Lecture');
    }

    public function test_admin_events_index_can_filter_by_category(): void
    {
        $category = EventCategory::create(['name' => 'Lecture', 'slug' => 'lecture']);
        $otherCategory = EventCategory::create(['name' => 'Social', 'slug' => 'social']);
        Event::factory()->create(['category_id' => $category->id, 'title' => 'Lecture Event']);
        Event::factory()->create(['category_id' => $otherCategory->id, 'title' => 'Social Event']);
        $response = $this->get(route('admin.events.index', ['category_id' => $category->id]));
        $response->assertOk();
        $response->assertSee('Lecture Event');
        $response->assertDontSee('Social Event');
    }

    public function test_admin_events_create_returns_200(): void
    {
        $this->get(route('admin.events.create'))->assertOk();
    }

    public function test_admin_events_store_creates_event(): void
    {
        $data = [
            'title' => 'New Test Event',
            'short_description' => 'A short description for the test event.',
            'description' => '<p>Full description of the event.</p>',
            'event_date' => now()->addDays(30)->format('Y-m-d'),
            'start_time' => '14:00',
            'end_time' => '16:00',
            'venue' => 'Test Venue',
            'city' => 'Lagos',
            'country' => 'Nigeria',
            'status' => 'draft',
        ];
        $response = $this->post(route('admin.events.store'), $data);
        $response->assertRedirect();
        $this->assertDatabaseHas('events', ['title' => 'New Test Event']);
    }

    public function test_admin_events_store_validates_required_fields(): void
    {
        $response = $this->post(route('admin.events.store'), []);
        $response->assertSessionHasErrors(['title', 'short_description', 'description', 'event_date', 'status']);
    }

    public function test_admin_events_store_handles_cover_image(): void
    {
        Storage::fake('public');
        $data = [
            'title' => 'Event with Image',
            'short_description' => 'Description.',
            'description' => '<p>Description.</p>',
            'event_date' => now()->addDays(30)->format('Y-m-d'),
            'status' => 'draft',
            'cover_image' => UploadedFile::fake()->image('event.jpg', 800, 600),
        ];
        $response = $this->post(route('admin.events.store'), $data);
        $response->assertRedirect();
        $event = Event::where('title', 'Event with Image')->first();
        $this->assertNotNull($event->cover_image);
        Storage::disk('public')->assertExists($event->cover_image);
    }

    public function test_admin_events_store_creates_unique_slug(): void
    {
        Event::factory()->create(['title' => 'Existing Event', 'slug' => 'existing-event']);
        $this->post(route('admin.events.store'), [
            'title' => 'Existing Event',
            'short_description' => 'Description.',
            'description' => '<p>Description.</p>',
            'event_date' => now()->addDays(30)->format('Y-m-d'),
            'status' => 'draft',
        ]);
        $this->assertDatabaseHas('events', ['slug' => 'existing-event-2']);
    }

    public function test_admin_events_show_returns_200(): void
    {
        $event = Event::factory()->create();
        $this->get(route('admin.events.show', $event))->assertOk();
    }

    public function test_admin_events_edit_returns_200(): void
    {
        $event = Event::factory()->create();
        $this->get(route('admin.events.edit', $event))->assertOk();
    }

    public function test_admin_events_update_modifies_event(): void
    {
        $event = Event::factory()->create(['title' => 'Original Title']);
        $data = [
            'title' => 'Updated Title',
            'short_description' => 'Updated description.',
            'description' => '<p>Updated full description.</p>',
            'event_date' => $event->event_date->format('Y-m-d'),
            'status' => 'draft',
        ];
        $response = $this->put(route('admin.events.update', $event), $data);
        $response->assertRedirect();
        $this->assertDatabaseHas('events', ['id' => $event->id, 'title' => 'Updated Title']);
    }

    public function test_admin_events_update_validates_required_fields(): void
    {
        $event = Event::factory()->create();
        $response = $this->put(route('admin.events.update', $event), []);
        $response->assertSessionHasErrors(['title', 'short_description', 'description', 'event_date', 'status']);
    }

    public function test_admin_events_update_handles_cover_image_replacement(): void
    {
        Storage::fake('public');
        $event = Event::factory()->create(['cover_image' => null]);
        $data = [
            'title' => $event->title,
            'short_description' => $event->short_description,
            'description' => $event->description,
            'event_date' => $event->event_date->format('Y-m-d'),
            'status' => 'draft',
            'cover_image' => UploadedFile::fake()->image('new-event.jpg', 800, 600),
        ];
        $this->put(route('admin.events.update', $event), $data);
        $event->refresh();
        $this->assertNotNull($event->cover_image);
        Storage::disk('public')->assertExists($event->cover_image);
    }

    public function test_admin_events_update_clears_old_cover_image(): void
    {
        Storage::fake('public');
        $event = Event::factory()->create(['cover_image' => 'events/old-image.jpg']);
        Storage::disk('public')->put('events/old-image.jpg', 'old');
        $this->put(route('admin.events.update', $event), [
            'title' => $event->title,
            'short_description' => $event->short_description,
            'description' => $event->description,
            'event_date' => $event->event_date->format('Y-m-d'),
            'status' => 'draft',
            'cover_image' => UploadedFile::fake()->image('new-event.jpg', 800, 600),
        ]);
        $event->refresh();
        $this->assertNotNull($event->cover_image);
        Storage::disk('public')->assertExists($event->cover_image);
        Storage::disk('public')->assertMissing('events/old-image.jpg');
    }

    public function test_admin_events_destroy_deletes_event(): void
    {
        $event = Event::factory()->create();
        $response = $this->delete(route('admin.events.destroy', $event));
        $response->assertRedirect();
        $this->assertDatabaseMissing('events', ['id' => $event->id]);
    }

    public function test_admin_events_destroy_clears_cover_image_file(): void
    {
        Storage::fake('public');
        $event = Event::factory()->create(['cover_image' => 'events/image.jpg']);
        Storage::disk('public')->put('events/image.jpg', 'data');
        $this->delete(route('admin.events.destroy', $event));
        Storage::disk('public')->assertMissing('events/image.jpg');
        $this->assertDatabaseMissing('events', ['id' => $event->id]);
    }

    public function test_admin_events_empty_state(): void
    {
        $response = $this->get(route('admin.events.index'));
        $response->assertOk();
        $response->assertSee('No events found');
    }

    public function test_homepage_displays_upcoming_events(): void
    {
        Event::factory()->published()->upcoming()->create(['title' => 'Homepage Featured Event']);
        $response = $this->get(route('home'));
        $response->assertOk();
        $response->assertSee('Homepage Featured Event');
    }

    public function test_homepage_does_not_display_draft_events(): void
    {
        Event::factory()->create(['title' => 'Draft Event', 'status' => 'draft']);
        $response = $this->get(route('home'));
        $response->assertOk();
        $response->assertDontSee('Draft Event');
    }

    public function test_event_category_uses_route_key_name_slug(): void
    {
        $category = EventCategory::create(['name' => 'Test Category', 'slug' => 'test-category']);
        $this->assertEquals('slug', $category->getRouteKeyName());
    }

    public function test_event_category_unique_slug_avoids_collisions(): void
    {
        EventCategory::create(['name' => 'Workshop', 'slug' => 'workshop']);
        $slug = EventCategory::uniqueSlug('Workshop');
        $this->assertEquals('workshop-2', $slug);
    }

    public function test_event_category_has_many_events(): void
    {
        $category = EventCategory::create(['name' => 'Lecture', 'slug' => 'lecture']);
        $this->assertInstanceOf(HasMany::class, $category->events());
    }

    public function test_event_belongs_to_category(): void
    {
        $category = EventCategory::create(['name' => 'Lecture', 'slug' => 'lecture']);
        $event = Event::factory()->create(['category_id' => $category->id]);
        $this->assertInstanceOf(BelongsTo::class, $event->category());
        $this->assertEquals($category->id, $event->category->id);
    }

    public function test_event_location_accessor(): void
    {
        $event = Event::factory()->create(['city' => 'Lagos', 'country' => 'Nigeria']);
        $this->assertEquals('Lagos, Nigeria', $event->location);
    }

    public function test_event_location_accessor_with_null_values(): void
    {
        $event = Event::factory()->create(['city' => null, 'country' => null]);
        $this->assertNull($event->location);
    }

    public function test_event_formatted_date_accessor(): void
    {
        $event = Event::factory()->create(['event_date' => '2026-09-18']);
        $this->assertNotEmpty($event->formatted_date);
        $this->assertStringContainsString('2026', $event->formatted_date);
    }

    public function test_event_formatted_time_accessor(): void
    {
        $event = Event::factory()->create(['start_time' => '14:00', 'end_time' => '16:00']);
        $this->assertStringContainsString('PM', $event->formatted_time);
    }

    public function test_event_formatted_time_null_when_no_start_time(): void
    {
        $event = Event::factory()->create(['start_time' => null, 'end_time' => null]);
        $this->assertNull($event->formatted_time);
    }

    public function test_event_is_upcoming(): void
    {
        $event = Event::factory()->create(['event_date' => now()->addDays(10)->format('Y-m-d')]);
        $this->assertTrue($event->isUpcoming());
    }

    public function test_event_is_past(): void
    {
        $event = Event::factory()->create(['event_date' => now()->subDays(10)->format('Y-m-d')]);
        $this->assertTrue($event->isPast());
    }

    public function test_event_scope_published_filters_correctly(): void
    {
        Event::factory()->published()->create(['title' => 'Published']);
        Event::factory()->create(['title' => 'Draft', 'status' => 'draft']);
        $published = Event::published()->pluck('title');
        $this->assertContains('Published', $published);
        $this->assertNotContains('Draft', $published);
    }

    public function test_event_scope_upcoming_filters_correctly(): void
    {
        Event::factory()->create(['title' => 'Future', 'event_date' => now()->addDays(5)->format('Y-m-d')]);
        Event::factory()->create(['title' => 'Past', 'event_date' => now()->subDays(5)->format('Y-m-d')]);
        $upcoming = Event::upcoming()->pluck('title');
        $this->assertContains('Future', $upcoming);
        $this->assertNotContains('Past', $upcoming);
    }

    public function test_event_scope_featured_filters_correctly(): void
    {
        Event::factory()->featured()->create(['title' => 'Featured']);
        Event::factory()->create(['title' => 'Not Featured', 'is_featured' => false]);
        $featured = Event::featured()->pluck('title');
        $this->assertContains('Featured', $featured);
        $this->assertNotContains('Not Featured', $featured);
    }
}
