<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\GalleryAlbum;
use App\Models\GalleryPhoto;
use App\Models\User;
use Database\Seeders\GallerySeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class GalleryTest extends TestCase
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

    public function test_album_model_route_key_name(): void
    {
        $album = new GalleryAlbum;
        $this->assertSame('slug', $album->getRouteKeyName());
    }

    public function test_album_unique_slug_collision_avoidance(): void
    {
        GalleryAlbum::factory()->create(['title' => 'Collision Test', 'slug' => 'collision-test']);
        $slug = GalleryAlbum::uniqueSlug('Collision Test');
        $this->assertNotSame('collision-test', $slug);
    }

    public function test_album_scope_published(): void
    {
        GalleryAlbum::factory()->published()->count(3)->create();
        GalleryAlbum::factory()->hidden()->count(2)->create();
        $this->assertCount(3, GalleryAlbum::published()->get());
    }

    public function test_album_scope_hidden(): void
    {
        GalleryAlbum::factory()->published()->count(2)->create();
        GalleryAlbum::factory()->hidden()->count(4)->create();
        $this->assertCount(4, GalleryAlbum::hidden()->get());
    }

    public function test_album_scope_ordered(): void
    {
        GalleryAlbum::factory()->create(['title' => 'Zebra Album', 'sort_order' => 3]);
        GalleryAlbum::factory()->create(['title' => 'Alpha Album', 'sort_order' => 1]);
        GalleryAlbum::factory()->create(['title' => 'Mango Album', 'sort_order' => 2]);
        $ordered = GalleryAlbum::ordered()->pluck('title')->toArray();
        $this->assertSame(['Alpha Album', 'Mango Album', 'Zebra Album'], $ordered);
    }

    public function test_album_cover_image_url_accessor_with_image(): void
    {
        $album = GalleryAlbum::factory()->create(['cover_image' => 'gallery/cover.jpg']);
        $this->assertNotNull($album->cover_image_url);
        $this->assertStringContainsString('gallery/cover.jpg', $album->cover_image_url);
    }

    public function test_album_cover_image_url_accessor_null_when_empty(): void
    {
        $album = GalleryAlbum::factory()->create(['cover_image' => null]);
        $this->assertNull($album->cover_image_url);
    }

    public function test_album_has_many_photos(): void
    {
        $album = GalleryAlbum::factory()->create();
        GalleryPhoto::factory()->count(3)->create(['gallery_album_id' => $album->id]);
        $this->assertCount(3, $album->photos);
    }

    public function test_photo_belongs_to_album(): void
    {
        $album = GalleryAlbum::factory()->create();
        $photo = GalleryPhoto::factory()->create(['gallery_album_id' => $album->id]);
        $this->assertNotNull($photo->album);
        $this->assertSame($album->id, $photo->album->id);
    }

    public function test_album_optionally_belongs_to_event(): void
    {
        $event = Event::factory()->published()->create();
        $album = GalleryAlbum::factory()->create(['event_id' => $event->id]);
        $this->assertNotNull($album->event);
        $this->assertSame($event->id, $album->event->id);
    }

    public function test_album_without_event(): void
    {
        $album = GalleryAlbum::factory()->create(['event_id' => null]);
        $this->assertNull($album->event);
    }

    public function test_photo_image_url_accessor(): void
    {
        $photo = GalleryPhoto::factory()->create(['image' => 'gallery/test-photo.jpg']);
        $this->assertNotNull($photo->image_url);
        $this->assertStringContainsString('gallery/test-photo.jpg', $photo->image_url);
    }

    public function test_photo_scope_published(): void
    {
        $album = GalleryAlbum::factory()->create();
        GalleryPhoto::factory()->published()->count(3)->create(['gallery_album_id' => $album->id]);
        GalleryPhoto::factory()->hidden()->count(2)->create(['gallery_album_id' => $album->id]);
        $this->assertCount(3, GalleryPhoto::published()->get());
    }

    public function test_photo_scope_ordered(): void
    {
        $album = GalleryAlbum::factory()->create();
        GalleryPhoto::factory()->create(['gallery_album_id' => $album->id, 'sort_order' => 3, 'image' => 'gallery/c.jpg']);
        GalleryPhoto::factory()->create(['gallery_album_id' => $album->id, 'sort_order' => 1, 'image' => 'gallery/a.jpg']);
        GalleryPhoto::factory()->create(['gallery_album_id' => $album->id, 'sort_order' => 2, 'image' => 'gallery/b.jpg']);
        $ordered = GalleryPhoto::ordered()->pluck('image')->toArray();
        $this->assertSame(['gallery/a.jpg', 'gallery/b.jpg', 'gallery/c.jpg'], $ordered);
    }

    // ──────────────────────────────────────────
    // ADMIN: ALBUM CRUD
    // ──────────────────────────────────────────

    public function test_admin_album_index_returns_200(): void
    {
        $this->get(route('admin.gallery.index'))->assertOk();
    }

    public function test_admin_album_index_lists_albums(): void
    {
        GalleryAlbum::factory()->create(['title' => 'Admin Listed Album']);
        $response = $this->get(route('admin.gallery.index'));
        $response->assertSee('Admin Listed Album');
    }

    public function test_admin_album_index_can_search(): void
    {
        GalleryAlbum::factory()->create(['title' => 'Alumni Reunion Photos']);
        GalleryAlbum::factory()->create(['title' => 'Poetry Night Shots']);
        $response = $this->get(route('admin.gallery.index', ['search' => 'Alumni']));
        $response->assertSee('Alumni Reunion Photos');
        $response->assertDontSee('Poetry Night Shots');
    }

    public function test_admin_album_index_can_filter_by_status(): void
    {
        GalleryAlbum::factory()->published()->create(['title' => 'Published Album']);
        GalleryAlbum::factory()->hidden()->create(['title' => 'Hidden Album']);
        $response = $this->get(route('admin.gallery.index', ['status' => 'published']));
        $response->assertSee('Published Album');
        $response->assertDontSee('Hidden Album');
    }

    public function test_admin_album_index_empty_state(): void
    {
        $response = $this->get(route('admin.gallery.index'));
        $response->assertSee('No albums found');
    }

    public function test_admin_album_create_returns_200(): void
    {
        $this->get(route('admin.gallery.create'))->assertOk();
    }

    public function test_admin_album_store_creates_album(): void
    {
        $data = [
            'title' => 'New Test Album',
            'description' => 'A test album description',
            'status' => 'published',
            'sort_order' => 0,
        ];
        $this->post(route('admin.gallery.store'), $data)->assertRedirect();
        $this->assertDatabaseHas('gallery_albums', ['title' => 'New Test Album', 'status' => 'published']);
    }

    public function test_admin_album_store_validates_required_fields(): void
    {
        $this->post(route('admin.gallery.store'), [])->assertSessionHasErrors(['title', 'status']);
    }

    public function test_admin_album_store_generates_unique_slug(): void
    {
        $this->post(route('admin.gallery.store'), [
            'title' => 'Unique Slug Album',
            'status' => 'published',
        ])->assertRedirect();
        $this->assertDatabaseHas('gallery_albums', ['slug' => 'unique-slug-album']);
    }

    public function test_admin_album_store_with_cover_image(): void
    {
        Storage::fake('public');
        $image = UploadedFile::fake()->image('cover.jpg', 800, 600)->size(100);
        $this->post(route('admin.gallery.store'), [
            'title' => 'Image Test Album',
            'status' => 'published',
            'cover_image' => $image,
        ])->assertRedirect();
        $album = GalleryAlbum::where('title', 'Image Test Album')->first();
        $this->assertNotNull($album->cover_image);
        Storage::disk('public')->assertExists($album->cover_image);
    }

    public function test_admin_album_store_with_event(): void
    {
        $event = Event::factory()->published()->create();
        $this->post(route('admin.gallery.store'), [
            'title' => 'Event Album',
            'status' => 'published',
            'event_id' => $event->id,
        ])->assertRedirect();
        $this->assertDatabaseHas('gallery_albums', ['title' => 'Event Album', 'event_id' => $event->id]);
    }

    public function test_admin_album_store_with_invalid_event_id(): void
    {
        $this->post(route('admin.gallery.store'), [
            'title' => 'Invalid Event Album',
            'status' => 'published',
            'event_id' => 99999,
        ])->assertSessionHasErrors(['event_id']);
    }

    public function test_admin_album_show_returns_200(): void
    {
        $album = GalleryAlbum::factory()->create();
        $this->get(route('admin.gallery.show', $album))->assertOk();
    }

    public function test_admin_album_show_displays_photos(): void
    {
        $album = GalleryAlbum::factory()->create();
        GalleryPhoto::factory()->create(['gallery_album_id' => $album->id, 'image' => 'gallery/photo1.jpg']);
        $response = $this->get(route('admin.gallery.show', $album));
        $response->assertOk();
    }

    public function test_admin_album_edit_returns_200(): void
    {
        $album = GalleryAlbum::factory()->create();
        $this->get(route('admin.gallery.edit', $album))->assertOk();
    }

    public function test_admin_album_update_modifies_album(): void
    {
        $album = GalleryAlbum::factory()->create(['title' => 'Original Title']);
        $this->put(route('admin.gallery.update', $album), [
            'title' => 'Updated Title',
            'description' => 'Updated description',
            'status' => 'published',
            'sort_order' => 0,
        ])->assertRedirect();
        $this->assertDatabaseHas('gallery_albums', ['id' => $album->id, 'title' => 'Updated Title']);
    }

    public function test_admin_album_update_replaces_cover_image(): void
    {
        Storage::fake('public');
        $album = GalleryAlbum::factory()->create();
        $newImage = UploadedFile::fake()->image('new-cover.jpg', 800, 600)->size(100);
        $this->put(route('admin.gallery.update', $album), [
            'title' => $album->title,
            'description' => $album->description,
            'status' => 'published',
            'sort_order' => 0,
            'cover_image' => $newImage,
        ])->assertRedirect();
        $album->refresh();
        $this->assertNotNull($album->cover_image);
    }

    public function test_admin_album_update_clears_cover_image(): void
    {
        $album = GalleryAlbum::factory()->create(['cover_image' => 'gallery/to-clear.jpg']);
        $this->put(route('admin.gallery.update', $album), [
            'title' => $album->title,
            'description' => $album->description,
            'status' => 'published',
            'sort_order' => 0,
            'clear_image' => '1',
        ])->assertRedirect();
        $album->refresh();
        $this->assertNull($album->cover_image);
    }

    public function test_admin_album_update_status(): void
    {
        $album = GalleryAlbum::factory()->published()->create();
        $this->put(route('admin.gallery.update', $album), [
            'title' => $album->title,
            'description' => $album->description,
            'status' => 'hidden',
            'sort_order' => 0,
        ])->assertRedirect();
        $album->refresh();
        $this->assertSame('hidden', $album->status);
    }

    public function test_admin_album_destroy_deletes_album(): void
    {
        $album = GalleryAlbum::factory()->create();
        $this->delete(route('admin.gallery.destroy', $album))->assertRedirect();
        $this->assertDatabaseMissing('gallery_albums', ['id' => $album->id]);
    }

    public function test_admin_album_destroy_deletes_photos_cascade(): void
    {
        $album = GalleryAlbum::factory()->create();
        GalleryPhoto::factory()->create(['gallery_album_id' => $album->id]);
        GalleryPhoto::factory()->create(['gallery_album_id' => $album->id]);
        $this->delete(route('admin.gallery.destroy', $album))->assertRedirect();
        $this->assertDatabaseMissing('gallery_albums', ['id' => $album->id]);
        $this->assertDatabaseMissing('gallery_photos', ['gallery_album_id' => $album->id]);
    }

    // ──────────────────────────────────────────
    // ADMIN: PHOTO UPLOAD & MANAGEMENT
    // ──────────────────────────────────────────

    public function test_admin_can_upload_single_photo(): void
    {
        Storage::fake('public');
        $album = GalleryAlbum::factory()->create();
        $image = UploadedFile::fake()->image('photo1.jpg', 800, 600)->size(100);
        $this->post(route('admin.gallery.photos.store', $album), [
            'images' => [$image],
        ])->assertRedirect();
        $this->assertDatabaseHas('gallery_photos', ['gallery_album_id' => $album->id]);
    }

    public function test_admin_can_upload_multiple_photos(): void
    {
        Storage::fake('public');
        $album = GalleryAlbum::factory()->create();
        $images = [
            UploadedFile::fake()->image('photo1.jpg', 800, 600)->size(100),
            UploadedFile::fake()->image('photo2.jpg', 800, 600)->size(100),
            UploadedFile::fake()->image('photo3.jpg', 800, 600)->size(100),
        ];
        $this->post(route('admin.gallery.photos.store', $album), [
            'images' => $images,
        ])->assertRedirect();
        $this->assertCount(3, $album->photos);
    }

    public function test_admin_upload_validates_image_required(): void
    {
        $album = GalleryAlbum::factory()->create();
        $this->post(route('admin.gallery.photos.store', $album), [
            'images' => [],
        ])->assertSessionHasErrors(['images']);
    }

    public function test_admin_upload_with_titles_and_captions(): void
    {
        Storage::fake('public');
        $album = GalleryAlbum::factory()->create();
        $images = [
            UploadedFile::fake()->image('photo1.jpg', 800, 600)->size(100),
            UploadedFile::fake()->image('photo2.jpg', 800, 600)->size(100),
        ];
        $this->post(route('admin.gallery.photos.store', $album), [
            'images' => $images,
            'titles' => ['First Photo', 'Second Photo'],
            'captions' => ['Caption one', 'Caption two'],
            'alt_texts' => ['Alt one', 'Alt two'],
        ])->assertRedirect();
        $photo1 = GalleryPhoto::where('gallery_album_id', $album->id)->where('title', 'First Photo')->first();
        $this->assertNotNull($photo1);
        $this->assertSame('Caption one', $photo1->caption);
        $photo2 = GalleryPhoto::where('gallery_album_id', $album->id)->where('title', 'Second Photo')->first();
        $this->assertNotNull($photo2);
        $this->assertSame('Caption two', $photo2->caption);
    }

    public function test_admin_photo_sort_order_is_set_correctly(): void
    {
        Storage::fake('public');
        $album = GalleryAlbum::factory()->create();
        GalleryPhoto::factory()->create(['gallery_album_id' => $album->id, 'sort_order' => 5]);
        $images = [
            UploadedFile::fake()->image('photo1.jpg', 800, 600)->size(100),
            UploadedFile::fake()->image('photo2.jpg', 800, 600)->size(100),
        ];
        $this->post(route('admin.gallery.photos.store', $album), [
            'images' => $images,
        ])->assertRedirect();
        $photos = $album->photos()->orderBy('sort_order')->get();
        $this->assertSame(5, $photos[0]->sort_order);
        $this->assertSame(6, $photos[1]->sort_order);
        $this->assertSame(7, $photos[2]->sort_order);
    }

    public function test_admin_can_update_photo_title_and_caption(): void
    {
        $album = GalleryAlbum::factory()->create();
        $photo = GalleryPhoto::factory()->create([
            'gallery_album_id' => $album->id,
            'title' => 'Old Title',
            'caption' => 'Old caption',
            'status' => 'published',
        ]);
        $this->put(route('admin.gallery.photos.update', [$album, $photo]), [
            'title' => 'New Title',
            'caption' => 'New caption',
            'status' => 'published',
        ])->assertRedirect();
        $photo->refresh();
        $this->assertSame('New Title', $photo->title);
        $this->assertSame('New caption', $photo->caption);
    }

    public function test_admin_can_delete_photo(): void
    {
        $album = GalleryAlbum::factory()->create();
        $photo = GalleryPhoto::factory()->create(['gallery_album_id' => $album->id]);
        $this->delete(route('admin.gallery.photos.destroy', [$album, $photo]))->assertRedirect();
        $this->assertDatabaseMissing('gallery_photos', ['id' => $photo->id]);
    }

    public function test_admin_cannot_access_photo_from_different_album(): void
    {
        $album1 = GalleryAlbum::factory()->create();
        $album2 = GalleryAlbum::factory()->create();
        $photo = GalleryPhoto::factory()->create(['gallery_album_id' => $album2->id]);
        $this->put(route('admin.gallery.photos.update', [$album1, $photo]), [
            'title' => 'Hacked',
            'status' => 'published',
        ])->assertNotFound();
    }

    public function test_admin_cannot_delete_photo_from_different_album(): void
    {
        $album1 = GalleryAlbum::factory()->create();
        $album2 = GalleryAlbum::factory()->create();
        $photo = GalleryPhoto::factory()->create(['gallery_album_id' => $album2->id]);
        $this->delete(route('admin.gallery.photos.destroy', [$album1, $photo]))->assertNotFound();
    }

    // ──────────────────────────────────────────
    // PUBLIC: /gallery
    // ──────────────────────────────────────────

    public function test_public_gallery_page_returns_200(): void
    {
        GalleryAlbum::factory()->published()->create();
        $this->get(route('gallery.index'))->assertOk();
    }

    public function test_public_gallery_page_shows_only_published_albums(): void
    {
        GalleryAlbum::factory()->published()->create(['title' => 'Published Album']);
        GalleryAlbum::factory()->hidden()->create(['title' => 'Hidden Album']);
        $response = $this->get(route('gallery.index'));
        $response->assertOk();
        $response->assertSee('Published Album');
        $response->assertDontSee('Hidden Album');
    }

    public function test_public_gallery_page_pagination(): void
    {
        GalleryAlbum::factory()->published()->count(15)->create();
        $response = $this->get(route('gallery.index'));
        $response->assertOk();
        $response->assertSee('1');
    }

    public function test_public_gallery_page_can_search(): void
    {
        GalleryAlbum::factory()->published()->create(['title' => 'Alumni Reunion 2025']);
        GalleryAlbum::factory()->published()->create(['title' => 'Poetry Night Highlights']);
        $response = $this->get(route('gallery.index', ['search' => 'Reunion']));
        $response->assertSee('Alumni Reunion 2025');
        $response->assertDontSee('Poetry Night Highlights');
    }

    public function test_public_gallery_page_empty_state(): void
    {
        $response = $this->get(route('gallery.index'));
        $response->assertOk();
        $response->assertSee('No albums found');
    }

    // ──────────────────────────────────────────
    // PUBLIC: /gallery/{slug}
    // ──────────────────────────────────────────

    public function test_public_album_detail_returns_200(): void
    {
        $album = GalleryAlbum::factory()->published()->create();
        $this->get(route('gallery.show', $album))->assertOk();
    }

    public function test_public_album_detail_shows_only_published_photos(): void
    {
        $album = GalleryAlbum::factory()->published()->create();
        GalleryPhoto::factory()->published()->create([
            'gallery_album_id' => $album->id,
            'title' => 'Published Photo',
            'image' => 'gallery/published.jpg',
        ]);
        GalleryPhoto::factory()->hidden()->create([
            'gallery_album_id' => $album->id,
            'title' => 'Hidden Photo',
            'image' => 'gallery/hidden.jpg',
        ]);
        $response = $this->get(route('gallery.show', $album));
        $response->assertOk();
        $response->assertSee('Published Photo');
        $response->assertDontSee('Hidden Photo');
    }

    public function test_public_album_detail_hidden_returns_404(): void
    {
        $album = GalleryAlbum::factory()->hidden()->create();
        $this->get(route('gallery.show', $album))->assertNotFound();
    }

    public function test_public_album_detail_invalid_slug_returns_404(): void
    {
        $this->get('/gallery/non-existent-slug-xyz')->assertNotFound();
    }

    public function test_public_album_detail_shows_event_link_when_event_exists(): void
    {
        $event = Event::factory()->published()->create(['title' => 'Annual Reunion']);
        $album = GalleryAlbum::factory()->published()->create([
            'event_id' => $event->id,
            'title' => 'Reunion Album',
        ]);
        $response = $this->get(route('gallery.show', $album));
        $response->assertSee('Annual Reunion');
    }

    public function test_public_album_detail_without_event(): void
    {
        $album = GalleryAlbum::factory()->published()->create(['event_id' => null]);
        $response = $this->get(route('gallery.show', $album));
        $response->assertOk();
    }

    // ──────────────────────────────────────────
    // HOMEPAGE INTEGRATION
    // ──────────────────────────────────────────

    public function test_homepage_displays_gallery_section(): void
    {
        GalleryAlbum::factory()->published()->create(['title' => 'Homepage Gallery Album']);
        $response = $this->get(route('home'));
        $response->assertOk();
        $response->assertSee('Homepage Gallery Album');
    }

    public function test_homepage_hides_hidden_albums(): void
    {
        GalleryAlbum::factory()->hidden()->create(['title' => 'Hidden on Homepage']);
        $response = $this->get(route('home'));
        $response->assertDontSee('Hidden on Homepage');
    }

    // ──────────────────────────────────────────
    // DASHBOARD INTEGRATION
    // ──────────────────────────────────────────

    public function test_dashboard_shows_gallery_stats(): void
    {
        GalleryAlbum::factory()->published()->count(3)->create();
        GalleryAlbum::factory()->hidden()->count(2)->create();
        $response = $this->get(route('admin.dashboard'));
        $response->assertOk();
    }

    // ──────────────────────────────────────────
    // ADDITIONAL INTEGRATION TESTS
    // ──────────────────────────────────────────

    public function test_album_cascade_deletes_photos_on_destroy(): void
    {
        $album = GalleryAlbum::factory()->create();
        $photo1 = GalleryPhoto::factory()->create(['gallery_album_id' => $album->id]);
        $photo2 = GalleryPhoto::factory()->create(['gallery_album_id' => $album->id]);
        $this->delete(route('admin.gallery.destroy', $album))->assertRedirect();
        $this->assertDatabaseMissing('gallery_photos', ['id' => $photo1->id]);
        $this->assertDatabaseMissing('gallery_photos', ['id' => $photo2->id]);
    }

    public function test_album_sort_order_is_respected(): void
    {
        GalleryAlbum::factory()->create(['title' => 'Third', 'sort_order' => 30]);
        GalleryAlbum::factory()->create(['title' => 'First', 'sort_order' => 10]);
        GalleryAlbum::factory()->create(['title' => 'Second', 'sort_order' => 20]);
        $ordered = GalleryAlbum::ordered()->pluck('title')->toArray();
        $this->assertSame(['First', 'Second', 'Third'], $ordered);
    }

    // ──────────────────────────────────────────
    // PHASE 07 FIX REGRESSIONS
    // ──────────────────────────────────────────

    public function test_seeder_generates_working_demo_images_for_all_photos(): void
    {
        Storage::fake('public');

        // The gallery seeder guards with exists() so start from an empty table.
        GalleryAlbum::query()->delete();
        GalleryPhoto::query()->delete();

        $this->seed(GallerySeeder::class);

        $albums = GalleryAlbum::with('photos')->get();
        $this->assertCount(8, $albums, 'Seeded album count must remain 8.');
        $this->assertCount(48, GalleryPhoto::all(), 'Seeded photo count must remain 48.');

        foreach ($albums as $album) {
            foreach ($album->photos as $photo) {
                Storage::disk('public')->assertExists($photo->image);
            }
        }

        // No photo may still reference the legacy demo-photo.jpg.
        $this->assertDatabaseMissing('gallery_photos', ['image' => 'gallery/demo-photo.jpg']);
    }

    public function test_seeder_heals_missing_demo_images_without_touching_existing_albums(): void
    {
        Storage::fake('public');

        // Simulate the QA failure state: seeded albums exist, but the physical
        // demo files were removed from storage.
        $this->seed(GallerySeeder::class);

        $beforeAlbums = GalleryAlbum::count();
        $beforePhotos = GalleryPhoto::count();

        Storage::disk('public')->deleteDirectory('gallery');
        $this->assertFalse(Storage::disk('public')->exists('gallery/demo-1.jpg'));

        // Re-running the seeder must regenerate every referenced demo image
        // and leave all album/photo records untouched.
        $this->seed(GallerySeeder::class);

        $this->assertSame($beforeAlbums, GalleryAlbum::count());
        $this->assertSame($beforePhotos, GalleryPhoto::count());

        foreach (GalleryPhoto::pluck('image')->unique() as $path) {
            Storage::disk('public')->assertExists($path);
        }
    }

    public function test_photo_url_accessor_uses_single_gallery_path(): void
    {
        $photo = GalleryPhoto::factory()->create(['image' => 'gallery/test-photo.jpg']);

        $url = $photo->image_url;

        $this->assertNotNull($url);
        $this->assertStringEndsWith('/storage/gallery/test-photo.jpg', $url);
        $this->assertStringNotContainsString('/gallery/gallery/', $url);
        $this->assertStringNotContainsString('/storage/gallery/gallery', $url);
    }

    public function test_admin_photo_destroy_deletes_physical_file(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('gallery/doomed.png', 'fake-image');

        $album = GalleryAlbum::factory()->published()->create();
        $photo = GalleryPhoto::factory()->create([
            'gallery_album_id' => $album->id,
            'image' => 'gallery/doomed.png',
        ]);

        $this->delete(route('admin.gallery.photos.destroy', [$album, $photo]))->assertRedirect();

        $this->assertDatabaseMissing('gallery_photos', ['id' => $photo->id]);
        Storage::disk('public')->assertMissing('gallery/doomed.png');
    }

    public function test_admin_album_cover_replacement_deletes_old_file(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('gallery/old-cover.png', 'old-image');

        $album = GalleryAlbum::factory()->published()->create([
            'cover_image' => 'gallery/old-cover.png',
        ]);

        $replacement = UploadedFile::fake()->image('new-cover.jpg', 800, 600)->size(100);
        $this->put(route('admin.gallery.update', $album), [
            'title' => $album->title,
            'description' => $album->description,
            'status' => 'published',
            'cover_image' => $replacement,
        ])->assertRedirect();

        $album->refresh();
        $this->assertNotNull($album->cover_image);
        $this->assertNotSame('gallery/old-cover.png', $album->cover_image);
        Storage::disk('public')->assertExists($album->cover_image);
        Storage::disk('public')->assertMissing('gallery/old-cover.png');
    }

    public function test_admin_album_destroy_removes_cover_and_photo_files(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('gallery/album-cover.jpg', 'cover');
        Storage::disk('public')->put('gallery/photo-one.jpg', 'one');
        Storage::disk('public')->put('gallery/photo-two.jpg', 'two');

        $album = GalleryAlbum::factory()->published()->create([
            'cover_image' => 'gallery/album-cover.jpg',
        ]);
        $p1 = GalleryPhoto::factory()->create([
            'gallery_album_id' => $album->id,
            'image' => 'gallery/photo-one.jpg',
        ]);
        $p2 = GalleryPhoto::factory()->create([
            'gallery_album_id' => $album->id,
            'image' => 'gallery/photo-two.jpg',
        ]);

        $this->delete(route('admin.gallery.destroy', $album))->assertRedirect();

        $this->assertDatabaseMissing('gallery_albums', ['id' => $album->id]);
        $this->assertDatabaseMissing('gallery_photos', ['id' => $p1->id]);
        $this->assertDatabaseMissing('gallery_photos', ['id' => $p2->id]);
        Storage::disk('public')->assertMissing('gallery/album-cover.jpg');
        Storage::disk('public')->assertMissing('gallery/photo-one.jpg');
        Storage::disk('public')->assertMissing('gallery/photo-two.jpg');
    }

    public function test_public_album_detail_shows_correct_published_photo_count(): void
    {
        $album = GalleryAlbum::factory()->published()->create();
        GalleryPhoto::factory()->published()->count(3)->create([
            'gallery_album_id' => $album->id,
        ]);
        // A hidden photo must not inflate the public count.
        GalleryPhoto::factory()->hidden()->create([
            'gallery_album_id' => $album->id,
        ]);

        $response = $this->get(route('gallery.show', $album));
        $response->assertOk();

        $albumView = $response->viewData('album');
        $this->assertSame(3, (int) $albumView->photos_count);

        $response->assertSee('3 photos');
    }

    public function test_gallery_uploads_reject_oversized_dimensions_image(): void
    {
        Storage::fake('public');

        // Album cover: small file size but dimensions exceed the 4000px guard.
        $huge = UploadedFile::fake()->image('huge.png', 5000, 5000)->size(100);
        $this->post(route('admin.gallery.store'), [
            'title' => 'Oversized Cover Album',
            'description' => 'Should be rejected.',
            'status' => 'published',
            'cover_image' => $huge,
        ])->assertSessionHasErrors(['cover_image']);
        $this->assertDatabaseMissing('gallery_albums', ['title' => 'Oversized Cover Album']);

        // Photo upload: same guard applies per image.
        $album = GalleryAlbum::factory()->published()->create();
        $hugePhoto = UploadedFile::fake()->image('huge-photo.png', 5000, 5000)->size(100);
        $this->post(route('admin.gallery.photos.store', $album), [
            'images' => [$hugePhoto],
        ])->assertSessionHasErrors(['images.0']);

        $this->assertDatabaseMissing('gallery_photos', ['gallery_album_id' => $album->id]);
    }
}
