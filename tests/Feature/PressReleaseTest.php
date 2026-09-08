<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\PressRelease;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PressReleaseTest extends TestCase
{
    use RefreshDatabase;

    private function createAdmin(): User
    {
        return User::factory()->create(['is_admin' => true, 'email_verified_at' => now()]);
    }

    private function createPublishedRelease(array $overrides = []): PressRelease
    {
        $title = $overrides['title'] ?? 'Test Press Release';

        return PressRelease::create(array_merge([
            'title' => $title,
            'slug' => PressRelease::uniqueSlug($title),
            'excerpt' => 'Test excerpt',
            'content' => 'Test content',
            'status' => 'published',
            'published_at' => now()->subDay(),
        ], $overrides));
    }

    private function createDraftRelease(array $overrides = []): PressRelease
    {
        $title = $overrides['title'] ?? 'Draft Release';

        return PressRelease::create(array_merge([
            'title' => $title,
            'slug' => PressRelease::uniqueSlug($title),
            'excerpt' => 'Draft excerpt',
            'content' => 'Draft content',
            'status' => 'draft',
        ], $overrides));
    }

    /*
    |--------------------------------------------------------------------------
    | PUBLIC TESTS
    |--------------------------------------------------------------------------
    */

    public function test_public_directory_loads(): void
    {
        $this->createPublishedRelease();
        $this->get(route('press-releases.index'))->assertOk();
    }

    public function test_public_detail_loads(): void
    {
        $release = $this->createPublishedRelease();
        $this->get(route('press-releases.show', $release))->assertOk();
    }

    public function test_public_search(): void
    {
        $this->createPublishedRelease(['title' => 'Scholarship Announcement']);
        $this->createPublishedRelease(['title' => 'Annual Meeting']);

        $this->get(route('press-releases.index', ['search' => 'Scholarship']))
            ->assertOk()
            ->assertSee('Scholarship Announcement')
            ->assertDontSee('Annual Meeting');
    }

    public function test_public_empty_search(): void
    {
        $this->createPublishedRelease();
        $this->get(route('press-releases.index', ['search' => 'nonexistent']))
            ->assertOk()
            ->assertSee('No press releases found');
    }

    public function test_public_pagination(): void
    {
        for ($i = 0; $i < 15; $i++) {
            $this->createPublishedRelease([
                'title' => "Release {$i}",
                'slug' => "release-{$i}",
            ]);
        }
        $this->get(route('press-releases.index'))->assertOk()->assertSee('Showing');
    }

    public function test_published_release_visible(): void
    {
        $release = $this->createPublishedRelease();
        $this->get(route('press-releases.show', $release))->assertOk()->assertSee($release->title);
    }

    public function test_draft_release_hidden(): void
    {
        $release = $this->createDraftRelease();
        $this->get(route('press-releases.show', $release))->assertStatus(404);
    }

    public function test_future_release_hidden(): void
    {
        $release = $this->createPublishedRelease([
            'published_at' => now()->addMonth(),
        ]);
        $this->get(route('press-releases.show', $release))->assertStatus(404);
    }

    public function test_invalid_slug_returns_404(): void
    {
        $this->get('/press-releases/nonexistent-slug-xyz')->assertStatus(404);
    }

    public function test_homepage_integration(): void
    {
        $this->createPublishedRelease();
        $this->get(route('home'))->assertOk()->assertSee('Press Releases');
    }

    public function test_related_releases(): void
    {
        $release = $this->createPublishedRelease();
        $related = $this->createPublishedRelease([
            'title' => 'Related Release',
            'slug' => 'related-release',
        ]);

        $this->get(route('press-releases.show', $release))
            ->assertOk()
            ->assertSee('Related Release');
    }

    public function test_seo_meta(): void
    {
        $release = $this->createPublishedRelease();
        $response = $this->get(route('press-releases.show', $release));
        $response->assertOk()->assertSee('og:title', false)->assertSee('meta name="description"', false);
    }

    public function test_json_ld(): void
    {
        $release = $this->createPublishedRelease();
        $this->get(route('press-releases.show', $release))
            ->assertOk()
            ->assertSee('application/ld+json')
            ->assertSee('NewsArticle');
    }

    public function test_image_presence(): void
    {
        Storage::fake('public');
        $image = UploadedFile::fake()->image('cover.jpg', 800, 600)->size(100);
        $path = $image->store('press-releases/covers', 'public');
        $release = $this->createPublishedRelease(['cover_image' => $path]);
        $this->get(route('press-releases.show', $release))->assertOk()->assertSee('storage/'.$path, false);
    }

    public function test_image_absence(): void
    {
        $release = $this->createPublishedRelease(['cover_image' => null]);
        $this->get(route('press-releases.show', $release))->assertOk();
    }

    public function test_pdf_presence(): void
    {
        $release = $this->createPublishedRelease([
            'document_path' => 'press-releases/documents/pr_test.pdf',
            'document_original_name' => 'test.pdf',
            'document_size' => 1024,
        ]);
        $this->get(route('press-releases.show', $release))->assertOk()->assertSee('Download');
    }

    public function test_pdf_absence(): void
    {
        $release = $this->createPublishedRelease(['document_path' => null]);
        $this->get(route('press-releases.show', $release))->assertOk()->assertDontSee('Download PDF');
    }

    public function test_external_link(): void
    {
        $release = $this->createPublishedRelease(['external_url' => 'https://example.com']);
        $this->get(route('press-releases.show', $release))->assertOk()->assertSee('External Source');
    }

    public function test_content_escaping(): void
    {
        $release = $this->createPublishedRelease([
            'content' => '<script>alert(1)</script>',
        ]);
        $response = $this->get(route('press-releases.show', $release));
        $response->assertOk();
        $response->assertDontSee('<script>alert(1)</script>', false);
        $response->assertSee('&lt;script&gt;', false);
    }

    public function test_img_xss_escaping(): void
    {
        $release = $this->createPublishedRelease([
            'content' => '<img src=x onerror=alert(1)>',
        ]);
        $response = $this->get(route('press-releases.show', $release));
        $response->assertOk();
        $response->assertDontSee('<img src=x', false);
    }

    /*
    |--------------------------------------------------------------------------
    | ADMIN TESTS
    |--------------------------------------------------------------------------
    */

    public function test_admin_guest_redirect(): void
    {
        $this->get(route('admin.press-releases.index'))->assertRedirect(route('admin.login'));
    }

    public function test_admin_non_admin_403(): void
    {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $this->actingAs($user)->get(route('admin.press-releases.index'))->assertStatus(403);
    }

    public function test_admin_index(): void
    {
        $this->actingAs($this->createAdmin())->get(route('admin.press-releases.index'))->assertOk();
    }

    public function test_admin_search(): void
    {
        $this->createPublishedRelease(['title' => 'Searchable Title']);
        $this->createPublishedRelease(['title' => 'Other Title', 'slug' => 'other-title']);

        $this->actingAs($this->createAdmin())
            ->get(route('admin.press-releases.index', ['search' => 'Searchable']))
            ->assertOk()
            ->assertSee('Searchable Title')
            ->assertDontSee('Other Title');
    }

    public function test_admin_filters(): void
    {
        $this->createPublishedRelease(['title' => 'Published One']);
        $this->createDraftRelease(['title' => 'Draft One']);

        $this->actingAs($this->createAdmin())
            ->get(route('admin.press-releases.index', ['status' => 'published']))
            ->assertOk()
            ->assertSee('Published One')
            ->assertDontSee('Draft One');
    }

    public function test_admin_create_form(): void
    {
        $this->actingAs($this->createAdmin())->get(route('admin.press-releases.create'))->assertOk();
    }

    public function test_admin_store(): void
    {
        Storage::fake('public');
        $this->actingAs($this->createAdmin())->post(route('admin.press-releases.store'), [
            'title' => 'New Press Release',
            'excerpt' => 'A new release',
            'content' => 'Content here',
            'status' => 'draft',
        ])->assertRedirect();

        $this->assertDatabaseHas('press_releases', ['slug' => 'new-press-release']);
    }

    public function test_admin_store_validation(): void
    {
        $this->actingAs($this->createAdmin())->post(route('admin.press-releases.store'), [
            'title' => '',
        ])->assertSessionHasErrors('title');
    }

    public function test_admin_edit_form(): void
    {
        $release = $this->createPublishedRelease();
        $this->actingAs($this->createAdmin())->get(route('admin.press-releases.edit', $release))->assertOk();
    }

    public function test_admin_update(): void
    {
        $release = $this->createPublishedRelease();
        $this->actingAs($this->createAdmin())->put(route('admin.press-releases.update', $release), [
            'title' => 'Updated Title',
            'excerpt' => $release->excerpt,
            'content' => $release->content,
            'status' => $release->status,
        ])->assertRedirect();

        $this->assertDatabaseHas('press_releases', ['id' => $release->id, 'slug' => 'updated-title']);
    }

    public function test_admin_delete(): void
    {
        $release = $this->createPublishedRelease();
        $this->actingAs($this->createAdmin())->delete(route('admin.press-releases.destroy', $release))
            ->assertRedirect();
        $this->assertDatabaseMissing('press_releases', ['id' => $release->id]);
    }

    public function test_admin_slug_generation(): void
    {
        $this->actingAs($this->createAdmin())->post(route('admin.press-releases.store'), [
            'title' => 'My Press Release',
            'status' => 'draft',
        ]);

        $this->assertDatabaseHas('press_releases', ['slug' => 'my-press-release']);
    }

    public function test_admin_duplicate_slug(): void
    {
        $this->createPublishedRelease(['title' => 'Duplicate', 'slug' => 'duplicate']);

        $this->actingAs($this->createAdmin())->post(route('admin.press-releases.store'), [
            'title' => 'Duplicate',
            'status' => 'draft',
        ]);

        $this->assertDatabaseHas('press_releases', ['slug' => 'duplicate-2']);
    }

    public function test_admin_publish(): void
    {
        $release = $this->createDraftRelease();
        $this->actingAs($this->createAdmin())->put(route('admin.press-releases.update', $release), [
            'title' => $release->title,
            'excerpt' => $release->excerpt,
            'content' => $release->content,
            'status' => 'published',
        ]);

        $this->assertDatabaseHas('press_releases', ['id' => $release->id, 'status' => 'published']);
    }

    public function test_admin_featured(): void
    {
        $release = $this->createPublishedRelease();
        $this->actingAs($this->createAdmin())->put(route('admin.press-releases.update', $release), [
            'title' => $release->title,
            'excerpt' => $release->excerpt,
            'content' => $release->content,
            'status' => $release->status,
            'is_featured' => true,
        ]);

        $this->assertDatabaseHas('press_releases', ['id' => $release->id, 'is_featured' => true]);
    }

    public function test_admin_image_upload(): void
    {
        Storage::fake('public');
        $release = $this->createPublishedRelease();
        $image = UploadedFile::fake()->image('cover.jpg', 800, 600)->size(100);

        $this->actingAs($this->createAdmin())->put(route('admin.press-releases.update', $release), [
            'title' => $release->title,
            'excerpt' => $release->excerpt,
            'content' => $release->content,
            'status' => $release->status,
            'cover_image' => $image,
        ]);

        $this->assertDatabaseHas('press_releases', [
            'id' => $release->id,
            'cover_image' => 'press-releases/covers/'.$image->hashName(),
        ]);
    }

    public function test_admin_image_replacement(): void
    {
        Storage::fake('public');
        $oldImage = UploadedFile::fake()->image('old.jpg', 800, 600)->size(100);
        $release = $this->createPublishedRelease([
            'cover_image' => $oldImage->store('press-releases/covers', 'public'),
        ]);
        $oldPath = $release->cover_image;

        $newImage = UploadedFile::fake()->image('new.jpg', 800, 600)->size(100);
        $this->actingAs($this->createAdmin())->put(route('admin.press-releases.update', $release), [
            'title' => $release->title,
            'excerpt' => $release->excerpt,
            'content' => $release->content,
            'status' => $release->status,
            'cover_image' => $newImage,
        ]);

        Storage::disk('public')->assertMissing($oldPath);
    }

    public function test_admin_image_deletion(): void
    {
        Storage::fake('public');
        $image = UploadedFile::fake()->image('cover.jpg', 800, 600)->size(100);
        $release = $this->createPublishedRelease([
            'cover_image' => $image->store('press-releases/covers', 'public'),
        ]);

        $this->actingAs($this->createAdmin())->put(route('admin.press-releases.update', $release), [
            'title' => $release->title,
            'excerpt' => $release->excerpt,
            'content' => $release->content,
            'status' => $release->status,
            'clear_image' => true,
        ]);

        $this->assertDatabaseHas('press_releases', ['id' => $release->id, 'cover_image' => null]);
    }

    public function test_admin_pdf_upload(): void
    {
        Storage::fake('public');
        $release = $this->createPublishedRelease();
        $pdf = UploadedFile::fake()->create('document.pdf', 100, 'application/pdf');

        $this->actingAs($this->createAdmin())->put(route('admin.press-releases.update', $release), [
            'title' => $release->title,
            'excerpt' => $release->excerpt,
            'content' => $release->content,
            'status' => $release->status,
            'document' => $pdf,
        ]);

        $release->refresh();
        $this->assertNotNull($release->document_path);
        $this->assertEquals('document.pdf', $release->document_original_name);
    }

    public function test_admin_pdf_replacement(): void
    {
        Storage::fake('public');
        $oldPdf = UploadedFile::fake()->create('old.pdf', 100, 'application/pdf');
        $release = $this->createPublishedRelease([
            'document_path' => $oldPdf->store('press-releases/documents', 'public'),
            'document_original_name' => 'old.pdf',
            'document_size' => 1024,
            'document_mime_type' => 'application/pdf',
        ]);
        $oldPath = $release->document_path;

        $newPdf = UploadedFile::fake()->create('new.pdf', 100, 'application/pdf');
        $this->actingAs($this->createAdmin())->put(route('admin.press-releases.update', $release), [
            'title' => $release->title,
            'excerpt' => $release->excerpt,
            'content' => $release->content,
            'status' => $release->status,
            'document' => $newPdf,
        ]);

        Storage::disk('public')->assertMissing($oldPath);
    }

    public function test_admin_pdf_deletion(): void
    {
        Storage::fake('public');
        $pdf = UploadedFile::fake()->create('document.pdf', 100, 'application/pdf');
        $release = $this->createPublishedRelease([
            'document_path' => $pdf->store('press-releases/documents', 'public'),
            'document_original_name' => 'document.pdf',
            'document_size' => 1024,
            'document_mime_type' => 'application/pdf',
        ]);

        $this->actingAs($this->createAdmin())->put(route('admin.press-releases.update', $release), [
            'title' => $release->title,
            'excerpt' => $release->excerpt,
            'content' => $release->content,
            'status' => $release->status,
            'clear_document' => true,
        ]);

        $this->assertDatabaseHas('press_releases', [
            'id' => $release->id,
            'document_path' => null,
            'document_original_name' => null,
        ]);
    }

    public function test_admin_physical_file_cleanup_on_delete(): void
    {
        Storage::fake('public');
        $image = UploadedFile::fake()->image('cover.jpg', 800, 600)->size(100);
        $pdf = UploadedFile::fake()->create('document.pdf', 100, 'application/pdf');

        $release = $this->createPublishedRelease([
            'cover_image' => $image->store('press-releases/covers', 'public'),
            'document_path' => $pdf->store('press-releases/documents', 'public'),
            'document_original_name' => 'document.pdf',
            'document_size' => 1024,
            'document_mime_type' => 'application/pdf',
        ]);

        $this->actingAs($this->createAdmin())->delete(route('admin.press-releases.destroy', $release));

        Storage::disk('public')->assertMissing($release->cover_image);
        Storage::disk('public')->assertMissing($release->document_path);
    }

    public function test_admin_dashboard_stats(): void
    {
        $this->createPublishedRelease();
        $this->createDraftRelease();

        $this->actingAs($this->createAdmin())->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('Press Releases')
            ->assertSee('1')
            ->assertSee('1 drafts');
    }

    /*
    |--------------------------------------------------------------------------
    | SECURITY TESTS
    |--------------------------------------------------------------------------
    */

    public function test_xss_payload_in_title(): void
    {
        $release = $this->createPublishedRelease(['title' => '<script>alert(1)</script>']);
        $response = $this->get(route('press-releases.show', $release));
        $response->assertOk();
        $response->assertDontSee('<script>alert(1)</script>', false);
    }

    public function test_invalid_mime_upload(): void
    {
        Storage::fake('public');
        $file = UploadedFile::fake()->create('malware.php', 100, 'application/php');

        $this->actingAs($this->createAdmin())->post(route('admin.press-releases.store'), [
            'title' => 'Test',
            'status' => 'draft',
            'document' => $file,
        ])->assertSessionHasErrors('document');
    }

    public function test_invalid_extension_upload(): void
    {
        Storage::fake('public');
        $file = UploadedFile::fake()->create('script.exe', 100, 'application/octet-stream');

        $this->actingAs($this->createAdmin())->post(route('admin.press-releases.store'), [
            'title' => 'Test',
            'status' => 'draft',
            'document' => $file,
        ])->assertSessionHasErrors('document');
    }

    public function test_oversized_file(): void
    {
        Storage::fake('public');
        $file = UploadedFile::fake()->create('large.pdf', 15000, 'application/pdf');

        $this->actingAs($this->createAdmin())->post(route('admin.press-releases.store'), [
            'title' => 'Test',
            'status' => 'draft',
            'document' => $file,
        ])->assertSessionHasErrors('document');
    }

    public function test_oversized_image_dimensions(): void
    {
        Storage::fake('public');
        $file = UploadedFile::fake()->image('large.jpg', 5500, 5500)->size(100);

        $this->actingAs($this->createAdmin())->post(route('admin.press-releases.store'), [
            'title' => 'Test',
            'status' => 'draft',
            'cover_image' => $file,
        ])->assertSessionHasErrors('cover_image');
    }

    public function test_unauthorized_mutation(): void
    {
        $release = $this->createPublishedRelease();
        $user = User::factory()->create(['email_verified_at' => now()]);

        $this->actingAs($user)->put(route('admin.press-releases.update', $release), [
            'title' => 'Hacked',
        ])->assertStatus(403);
    }

    public function test_draft_direct_access(): void
    {
        $release = $this->createDraftRelease();
        $this->get(route('press-releases.show', $release))->assertStatus(404);
    }

    public function test_future_release_direct_access(): void
    {
        $release = $this->createPublishedRelease([
            'published_at' => now()->addMonth(),
        ]);
        $this->get(route('press-releases.show', $release))->assertStatus(404);
    }

    /*
    |--------------------------------------------------------------------------
    | STORAGE REGRESSION TESTS
    |--------------------------------------------------------------------------
    */

    public function test_no_double_path(): void
    {
        $release = $this->createPublishedRelease([
            'cover_image' => 'press-releases/covers/image.jpg',
            'document_path' => 'press-releases/documents/doc.pdf',
        ]);

        $this->assertStringStartsNotWith('press-releases/press-releases', $release->cover_image);
        $this->assertStringStartsNotWith('press-releases/press-releases', $release->document_path);
    }

    public function test_accessor_url_no_double_path(): void
    {
        $release = $this->createPublishedRelease([
            'cover_image' => 'press-releases/covers/image.jpg',
        ]);

        $url = $release->cover_image_url;
        $this->assertStringContainsString('/storage/press-releases/covers/image.jpg', $url);
        $this->assertStringNotContainsString('press-releases/press-releases', $url);
    }

    /*
    |--------------------------------------------------------------------------
    | REGRESSION: Existing modules still work
    |--------------------------------------------------------------------------
    */

    public function test_news_module_unchanged(): void
    {
        $this->get(route('news.index'))->assertOk();
    }

    public function test_events_module_unchanged(): void
    {
        $this->get(route('events.index'))->assertOk();
    }

    public function test_stories_module_unchanged(): void
    {
        $this->get(route('stories.index'))->assertOk();
    }

    public function test_gallery_module_unchanged(): void
    {
        $this->get(route('gallery.index'))->assertOk();
    }

    public function test_publications_module_unchanged(): void
    {
        $this->get(route('publications.index'))->assertOk();
    }

    public function test_membership_module_unchanged(): void
    {
        $this->get(route('membership'))->assertOk();
    }

    public function test_leaderboard_module_unchanged(): void
    {
        $this->get(route('leaderboard.index'))->assertOk();
    }
}
