<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\EventCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class EventCategoryTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->admin()->create(['password' => Hash::make('password')]);
        $this->actingAs($this->admin);
    }

    public function test_guests_are_redirected_from_event_category_admin(): void
    {
        auth()->logout();

        $this->get(route('admin.events.categories.index'))
            ->assertRedirect(route('admin.login'));

        $this->post(route('admin.events.categories.store'), ['name' => 'X'])
            ->assertRedirect(route('admin.login'));
    }

    public function test_index_lists_event_categories(): void
    {
        EventCategory::create(['name' => 'Lecture', 'slug' => 'lecture']);
        EventCategory::create(['name' => 'Social', 'slug' => 'social']);

        $response = $this->get(route('admin.events.categories.index'));

        $response->assertOk();
        $response->assertSee('Lecture');
        $response->assertSee('Social');
    }

    public function test_create_page_loads(): void
    {
        $this->get(route('admin.events.categories.create'))->assertOk();
    }

    public function test_store_creates_category_with_generated_slug(): void
    {
        $response = $this->post(route('admin.events.categories.store'), [
            'name' => 'Manual QA Events',
            'description' => 'Temporary category for QA.',
        ]);

        $response->assertRedirect(route('admin.events.categories.index'));
        $this->assertDatabaseHas('event_categories', [
            'name' => 'Manual QA Events',
            'slug' => 'manual-qa-events',
        ]);
    }

    public function test_store_requires_name(): void
    {
        $this->from(route('admin.events.categories.create'))
            ->post(route('admin.events.categories.store'), ['name' => ''])
            ->assertSessionHasErrors('name');
    }

    public function test_edit_page_loads(): void
    {
        $category = EventCategory::create(['name' => 'Lecture', 'slug' => 'lecture']);

        $this->get(route('admin.events.categories.edit', $category))
            ->assertOk()
            ->assertSee('Lecture');
    }

    public function test_update_changes_name_and_regenerates_slug(): void
    {
        $category = EventCategory::create(['name' => 'Old Name', 'slug' => 'old-name']);

        $response = $this->put(route('admin.events.categories.update', $category), [
            'name' => 'New Name',
            'description' => 'Updated.',
        ]);

        $response->assertRedirect(route('admin.events.categories.index'));
        $this->assertDatabaseHas('event_categories', [
            'id' => $category->id,
            'name' => 'New Name',
            'slug' => 'new-name',
        ]);
    }

    public function test_update_generates_unique_slug_on_conflict(): void
    {
        EventCategory::create(['name' => 'Taken', 'slug' => 'taken']);
        $category = EventCategory::create(['name' => 'Free', 'slug' => 'free']);

        $this->put(route('admin.events.categories.update', $category), ['name' => 'Taken']);

        $this->assertSame('taken-2', $category->fresh()->slug);
    }

    public function test_destroy_deletes_unused_category(): void
    {
        $category = EventCategory::create(['name' => 'Unused', 'slug' => 'unused']);

        $response = $this->delete(route('admin.events.categories.destroy', $category));

        $response->assertRedirect(route('admin.events.categories.index'));
        $this->assertDatabaseMissing('event_categories', ['id' => $category->id]);
    }

    public function test_destroy_is_blocked_when_events_are_assigned(): void
    {
        $category = EventCategory::create(['name' => 'Busy', 'slug' => 'busy']);
        $event = Event::factory()->create(['category_id' => $category->id]);

        $response = $this->delete(route('admin.events.categories.destroy', $category));

        $response->assertRedirect(route('admin.events.categories.index'));
        $response->assertSessionHas('error');

        // Category and its events must remain intact.
        $this->assertDatabaseHas('event_categories', ['id' => $category->id]);
        $this->assertDatabaseHas('events', ['id' => $event->id, 'category_id' => $category->id]);
    }
}
