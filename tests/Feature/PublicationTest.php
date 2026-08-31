<?php

namespace Tests\Feature;

use App\Models\Publication;
use App\Models\PublicationCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PublicationTest extends TestCase
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

    public function test_publication_category_has_many_publications(): void
    {
        $category = PublicationCategory::create(['name' => 'Academic', 'slug' => 'academic']);
        Publication::factory()->count(3)->create(['publication_category_id' => $category->id]);
        $this->assertCount(3, $category->publications);
    }

    public function test_publication_belongs_to_category(): void
    {
        $category = PublicationCategory::create(['name' => 'Academic', 'slug' => 'academic']);
        $publication = Publication::factory()->create(['publication_category_id' => $category->id]);
        $this->assertNotNull($publication->category);
        $this->assertSame($category->id, $publication->category->id);
    }

    public function test_publication_unique_slug_collision_avoidance(): void
    {
        Publication::factory()->create(['title' => 'Collision Test', 'slug' => 'collision-test']);
        $slug = Publication::uniqueSlug('Collision Test');
        $this->assertNotSame('collision-test', $slug);
    }

    public function test_publication_scope_published(): void
    {
        Publication::factory()->published()->count(3)->create();
        Publication::factory()->draft()->count(2)->create();
        $this->assertCount(3, Publication::published()->get());
    }

    public function test_publication_scope_draft(): void
    {
        Publication::factory()->published()->count(2)->create();
        Publication::factory()->draft()->count(4)->create();
        $this->assertCount(4, Publication::draft()->get());
    }

    public function test_publication_scope_featured(): void
    {
        Publication::factory()->published()->featured()->count(2)->create();
        Publication::factory()->published()->count(5)->create(['is_featured' => false]);
        $this->assertCount(2, Publication::featured()->get());
    }

    public function test_publication_cover_image_url_accessor(): void
    {
        $publication = Publication::factory()->create(['cover_image' => 'test-cover.jpg']);
        $this->assertNotNull($publication->cover_image_url);
        $this->assertStringContainsString('test-cover.jpg', $publication->cover_image_url);
    }

    public function test_publication_document_url_accessor(): void
    {
        $publication = Publication::factory()->create(['document_path' => 'test-doc.pdf']);
        $this->assertNotNull($publication->document_url);
        $this->assertStringContainsString('test-doc.pdf', $publication->document_url);
    }

    // ──────────────────────────────────────────
    // ADMIN: PUBLICATION CATEGORIES
    // ──────────────────────────────────────────

    public function test_admin_category_index_returns_200(): void
    {
        $this->get(route('admin.publication-categories.index'))->assertOk();
    }

    public function test_admin_category_create_returns_200(): void
    {
        $this->get(route('admin.publication-categories.create'))->assertOk();
    }

    public function test_admin_category_store_creates_category(): void
    {
        $this->post(route('admin.publication-categories.store'), [
            'name' => 'New Category',
            'description' => 'A test category',
        ])->assertRedirect();
        $this->assertDatabaseHas('publication_categories', ['name' => 'New Category']);
    }

    public function test_admin_category_update_modifies_category(): void
    {
        $category = PublicationCategory::create(['name' => 'Old Name', 'slug' => 'old-name']);
        $this->put(route('admin.publication-categories.update', $category), [
            'name' => 'Updated Name',
        ])->assertRedirect();
        $this->assertDatabaseHas('publication_categories', ['id' => $category->id, 'name' => 'Updated Name']);
    }

    public function test_admin_cannot_delete_category_with_publications(): void
    {
        $category = PublicationCategory::create(['name' => 'Has Pubs', 'slug' => 'has-pubs']);
        Publication::factory()->create(['publication_category_id' => $category->id]);
        $this->delete(route('admin.publication-categories.destroy', $category))
            ->assertSessionHasErrors(['error']);
        $this->assertDatabaseHas('publication_categories', ['id' => $category->id]);
    }

    public function test_admin_can_delete_empty_category(): void
    {
        $category = PublicationCategory::create(['name' => 'Empty', 'slug' => 'empty']);
        $this->delete(route('admin.publication-categories.destroy', $category))->assertRedirect();
        $this->assertDatabaseMissing('publication_categories', ['id' => $category->id]);
    }

    public function test_admin_category_validation(): void
    {
        $this->post(route('admin.publication-categories.store'), [])->assertSessionHasErrors(['name']);
    }

    public function test_admin_category_active_toggle(): void
    {
        $category = PublicationCategory::create(['name' => 'Toggle Test', 'slug' => 'toggle-test', 'is_active' => true]);
        $this->put(route('admin.publication-categories.update', $category), [
            'name' => 'Toggle Test',
            'is_active' => false,
        ])->assertRedirect();
        $category->refresh();
        $this->assertFalse($category->is_active);
    }

    public function test_admin_category_generates_unique_slug(): void
    {
        PublicationCategory::create(['name' => 'Existing', 'slug' => 'existing']);
        $this->post(route('admin.publication-categories.store'), [
            'name' => 'Existing',
        ])->assertRedirect();
        $count = PublicationCategory::where('name', 'Existing')->count();
        $this->assertSame(2, $count);
        $slugs = PublicationCategory::where('name', 'Existing')->pluck('slug')->toArray();
        $this->assertNotSame($slugs[0], $slugs[1]);
    }

    // ──────────────────────────────────────────
    // ADMIN: PUBLICATION CRUD
    // ──────────────────────────────────────────

    public function test_admin_publication_index_returns_200(): void
    {
        $this->get(route('admin.publications.index'))->assertOk();
    }

    public function test_admin_publication_index_lists_publications(): void
    {
        Publication::factory()->published()->create(['title' => 'Admin Listed Publication']);
        $response = $this->get(route('admin.publications.index'));
        $response->assertSee('Admin Listed Publication');
    }

    public function test_admin_publication_create_returns_200(): void
    {
        $this->get(route('admin.publications.create'))->assertOk();
    }

    public function test_admin_publication_store_creates_publication(): void
    {
        $category = PublicationCategory::create(['name' => 'Academic', 'slug' => 'academic', 'is_active' => true]);
        $data = [
            'title' => 'New Test Publication',
            'description' => 'A test description',
            'publication_category_id' => $category->id,
            'status' => 'draft',
            'author' => 'Test Author',
        ];
        $this->post(route('admin.publications.store'), $data)->assertRedirect();
        $this->assertDatabaseHas('publications', ['title' => 'New Test Publication', 'status' => 'draft']);
    }

    public function test_admin_publication_store_with_cover_image(): void
    {
        Storage::fake('public');
        $image = UploadedFile::fake()->image('cover.jpg', 800, 600)->size(100);
        $this->post(route('admin.publications.store'), [
            'title' => 'Image Test Publication',
            'description' => 'Description here',
            'status' => 'draft',
            'cover_image' => $image,
        ])->assertRedirect();
        $publication = Publication::where('title', 'Image Test Publication')->first();
        $this->assertNotNull($publication->cover_image);
        Storage::disk('public')->assertExists($publication->cover_image);
    }

    public function test_admin_publication_store_with_pdf(): void
    {
        Storage::fake('public');
        $pdf = UploadedFile::fake()->create('document.pdf', 100, 'application/pdf');
        $this->post(route('admin.publications.store'), [
            'title' => 'PDF Test Publication',
            'description' => 'Description here',
            'status' => 'draft',
            'document' => $pdf,
        ])->assertRedirect();
        $publication = Publication::where('title', 'PDF Test Publication')->first();
        $this->assertNotNull($publication->document_path);
        $this->assertNotNull($publication->document_original_name);
        $this->assertNotNull($publication->document_size);
        $this->assertNotNull($publication->document_mime_type);
        Storage::disk('public')->assertExists($publication->document_path);
    }

    public function test_admin_publication_store_validates_required_fields(): void
    {
        $this->post(route('admin.publications.store'), [])->assertSessionHasErrors(['title', 'description', 'status']);
    }

    public function test_admin_publication_store_validates_pdf_mime_type(): void
    {
        $file = UploadedFile::fake()->create('document.txt', 100, 'text/plain');
        $this->post(route('admin.publications.store'), [
            'title' => 'Invalid PDF',
            'description' => 'Description',
            'status' => 'draft',
            'document' => $file,
        ])->assertSessionHasErrors(['document']);
    }

    public function test_admin_publication_store_generates_unique_slug(): void
    {
        $this->post(route('admin.publications.store'), [
            'title' => 'Unique Slug Publication',
            'description' => 'Description',
            'status' => 'draft',
        ])->assertRedirect();
        $this->assertDatabaseHas('publications', ['slug' => 'unique-slug-publication']);
    }

    public function test_admin_publication_show_returns_200(): void
    {
        $publication = Publication::factory()->create();
        $this->get(route('admin.publications.show', $publication))->assertOk();
    }

    public function test_admin_publication_edit_returns_200(): void
    {
        $publication = Publication::factory()->create();
        $this->get(route('admin.publications.edit', $publication))->assertOk();
    }

    public function test_admin_publication_update_modifies_publication(): void
    {
        $publication = Publication::factory()->create(['title' => 'Original Title']);
        $this->put(route('admin.publications.update', $publication), [
            'title' => 'Updated Title',
            'description' => 'Updated description',
            'status' => 'draft',
        ])->assertRedirect();
        $this->assertDatabaseHas('publications', ['id' => $publication->id, 'title' => 'Updated Title']);
    }

    public function test_admin_publication_update_replaces_cover_image(): void
    {
        Storage::fake('public');
        $publication = Publication::factory()->create();
        $newImage = UploadedFile::fake()->image('new-cover.jpg', 800, 600)->size(100);
        $this->put(route('admin.publications.update', $publication), [
            'title' => $publication->title,
            'description' => $publication->description,
            'status' => 'draft',
            'cover_image' => $newImage,
        ])->assertRedirect();
        $publication->refresh();
        $this->assertNotNull($publication->cover_image);
    }

    public function test_admin_publication_update_replaces_document(): void
    {
        Storage::fake('public');
        $publication = Publication::factory()->create();
        $newDoc = UploadedFile::fake()->create('new-doc.pdf', 100, 'application/pdf');
        $this->put(route('admin.publications.update', $publication), [
            'title' => $publication->title,
            'description' => $publication->description,
            'status' => 'draft',
            'document' => $newDoc,
        ])->assertRedirect();
        $publication->refresh();
        $this->assertNotNull($publication->document_path);
    }

    public function test_admin_publication_destroy_deletes_publication(): void
    {
        $publication = Publication::factory()->create();
        $this->delete(route('admin.publications.destroy', $publication))->assertRedirect();
        $this->assertDatabaseMissing('publications', ['id' => $publication->id]);
    }

    public function test_admin_publication_destroy_removes_files(): void
    {
        Storage::fake('public');
        $publication = Publication::factory()->create([
            'cover_image' => 'to-delete-cover.jpg',
            'document_path' => 'publications/documents/to-delete-doc.pdf',
        ]);
        Storage::disk('public')->put('to-delete-cover.jpg', 'fake');
        Storage::disk('public')->put('publications/documents/to-delete-doc.pdf', 'fake');
        $this->delete(route('admin.publications.destroy', $publication))->assertRedirect();
        $this->assertDatabaseMissing('publications', ['id' => $publication->id]);
    }

    public function test_admin_publication_index_search_works(): void
    {
        Publication::factory()->published()->create(['title' => 'Alumni Reunion Publication']);
        Publication::factory()->published()->create(['title' => 'Poetry Anthology']);
        $response = $this->get(route('admin.publications.index', ['search' => 'Alumni']));
        $response->assertSee('Alumni Reunion Publication');
        $response->assertDontSee('Poetry Anthology');
    }

    public function test_admin_publication_index_filter_works(): void
    {
        Publication::factory()->published()->create(['title' => 'Published Pub']);
        Publication::factory()->draft()->create(['title' => 'Draft Pub']);
        $response = $this->get(route('admin.publications.index', ['status' => 'published']));
        $response->assertSee('Published Pub');
        $response->assertDontSee('Draft Pub');
    }

    // ──────────────────────────────────────────
    // PUBLIC: /publications
    // ──────────────────────────────────────────

    public function test_public_publications_page_returns_200(): void
    {
        Publication::factory()->published()->create();
        $this->get(route('publications.index'))->assertOk();
    }

    public function test_public_page_shows_only_published_publications(): void
    {
        Publication::factory()->published()->create(['title' => 'Published Publication']);
        Publication::factory()->draft()->create(['title' => 'Draft Publication']);
        $response = $this->get(route('publications.index'));
        $response->assertOk();
        $response->assertSee('Published Publication');
        $response->assertDontSee('Draft Publication');
    }

    public function test_public_page_search_works(): void
    {
        Publication::factory()->published()->create(['title' => 'Alumni Reunion Plans']);
        Publication::factory()->published()->create(['title' => 'Poetry Night']);
        $response = $this->get(route('publications.index', ['search' => 'Reunion']));
        $response->assertSee('Alumni Reunion Plans');
        $response->assertDontSee('Poetry Night');
    }

    public function test_public_page_category_filter_works(): void
    {
        $cat = PublicationCategory::create(['name' => 'Academic', 'slug' => 'academic']);
        $other = PublicationCategory::create(['name' => 'Social', 'slug' => 'social']);
        Publication::factory()->published()->create(['publication_category_id' => $cat->id, 'title' => 'Academic Publication']);
        Publication::factory()->published()->create(['publication_category_id' => $other->id, 'title' => 'Social Publication']);
        $response = $this->get(route('publications.index', ['category' => 'academic']));
        $response->assertSee('Academic Publication');
        $response->assertDontSee('Social Publication');
    }

    public function test_public_page_year_filter_works(): void
    {
        Publication::factory()->published()->create([
            'title' => '2024 Publication',
            'publication_date' => '2024-06-15',
        ]);
        Publication::factory()->published()->create([
            'title' => '2022 Publication',
            'publication_date' => '2022-06-15',
        ]);
        $response = $this->get(route('publications.index', ['year' => '2024']));
        $response->assertSee('2024 Publication');
        $response->assertDontSee('2022 Publication');
    }

    public function test_public_page_pagination_works(): void
    {
        Publication::factory()->published()->count(15)->create();
        $response = $this->get(route('publications.index'));
        $response->assertOk();
        $response->assertSee('1');
    }

    public function test_public_page_empty_state(): void
    {
        $response = $this->get(route('publications.index'));
        $response->assertOk();
        $response->assertSee('No publications found');
    }

    // ──────────────────────────────────────────
    // PUBLIC: /publications/{slug}
    // ──────────────────────────────────────────

    public function test_public_publication_detail_returns_200(): void
    {
        $publication = Publication::factory()->published()->create();
        $this->get(route('publications.show', $publication))->assertOk();
    }

    public function test_public_publication_detail_shows_data(): void
    {
        $publication = Publication::factory()->published()->create([
            'title' => 'Test Publication Title',
            'subtitle' => 'A Test Subtitle',
            'description' => 'Full publication description here',
            'author' => 'Mercy Uche',
        ]);
        $response = $this->get(route('publications.show', $publication));
        $response->assertOk();
        $response->assertSee('Test Publication Title');
        $response->assertSee('A Test Subtitle');
        $response->assertSee('Full publication description here');
        $response->assertSee('Mercy Uche');
    }

    public function test_public_publication_detail_draft_returns_404(): void
    {
        $publication = Publication::factory()->draft()->create();
        $this->get(route('publications.show', $publication))->assertNotFound();
    }

    public function test_public_publication_detail_nonexistent_returns_404(): void
    {
        $this->get('/publications/non-existent-slug-xyz')->assertNotFound();
    }

    public function test_public_publication_detail_shows_category(): void
    {
        $category = PublicationCategory::create(['name' => 'Academic', 'slug' => 'academic']);
        $publication = Publication::factory()->published()->create(['publication_category_id' => $category->id]);
        $response = $this->get(route('publications.show', $publication));
        $response->assertSee('Academic');
    }

    public function test_public_document_download_works_for_published(): void
    {
        Storage::fake('public');
        $publication = Publication::factory()->published()->create([
            'document_path' => 'publications/documents/test-document.pdf',
            'document_original_name' => 'test-document.pdf',
        ]);
        Storage::disk('public')->put('publications/documents/test-document.pdf', 'fake content');
        $this->get(route('publications.download', $publication))->assertOk();
    }

    // ──────────────────────────────────────────
    // HOMEPAGE INTEGRATION
    // ──────────────────────────────────────────

    public function test_homepage_displays_publications_section(): void
    {
        Publication::factory()->published()->create(['title' => 'Homepage Publication']);
        $response = $this->get(route('home'));
        $response->assertOk();
        $response->assertSee('Homepage Publication');
    }

    public function test_homepage_hides_draft_publications(): void
    {
        Publication::factory()->draft()->create(['title' => 'Draft on Homepage']);
        $response = $this->get(route('home'));
        $response->assertDontSee('Draft on Homepage');
    }

    public function test_homepage_publications_section_is_database_driven(): void
    {
        Publication::factory()->published()->count(3)->create();
        $response = $this->get(route('home'));
        $response->assertOk();
    }

    // ──────────────────────────────────────────
    // SEO
    // ──────────────────────────────────────────

    public function test_publication_detail_has_title(): void
    {
        $publication = Publication::factory()->published()->create(['title' => 'SEO Title Test']);
        $response = $this->get(route('publications.show', $publication));
        $response->assertSee('SEO Title Test');
    }

    public function test_publication_detail_has_meta_description(): void
    {
        $publication = Publication::factory()->published()->create(['description' => 'SEO meta description content']);
        $response = $this->get(route('publications.show', $publication));
        $response->assertSee('SEO meta description content');
    }

    public function test_publication_detail_has_canonical(): void
    {
        $publication = Publication::factory()->published()->create();
        $response = $this->get(route('publications.show', $publication));
        $response->assertSee('canonical');
    }

    // ──────────────────────────────────────────
    // SECURITY
    // ──────────────────────────────────────────

    public function test_draft_publication_not_accessible_via_public_url(): void
    {
        $publication = Publication::factory()->draft()->create();
        $this->get(route('publications.show', $publication))->assertNotFound();
    }

    public function test_draft_publication_document_not_downloadable(): void
    {
        $publication = Publication::factory()->draft()->create([
            'document_path' => 'publications/documents/draft-doc.pdf',
            'document_original_name' => 'draft-doc.pdf',
        ]);
        $this->get(route('publications.download', $publication))->assertNotFound();
    }

    public function test_non_existent_publication_returns_404(): void
    {
        $this->get('/publications/this-does-not-exist-999')->assertNotFound();
    }

    // ──────────────────────────────────────────
    // C1 REGRESSION: DOUBLE-PATH BUG
    // ──────────────────────────────────────────

    public function test_cover_image_url_does_not_double_path(): void
    {
        $publication = Publication::factory()->create([
            'cover_image' => 'publications/covers/abc123.jpg',
        ]);

        $url = $publication->cover_image_url;

        $this->assertStringContainsString('publications/covers/abc123.jpg', $url);
        $this->assertStringNotContainsString('publications/covers/publications/covers', $url);
    }

    public function test_document_url_does_not_double_path(): void
    {
        $publication = Publication::factory()->create([
            'document_path' => 'publications/documents/doc_abc123.pdf',
        ]);

        $url = $publication->document_url;

        $this->assertStringContainsString('publications/documents/doc_abc123.pdf', $url);
        $this->assertStringNotContainsString('publications/documents/publications/documents', $url);
    }

    public function test_destroy_removes_files_from_correct_path(): void
    {
        Storage::fake('public');

        $publication = Publication::factory()->create([
            'cover_image' => 'publications/covers/to-delete-cover.jpg',
            'document_path' => 'publications/documents/to-delete-doc.pdf',
        ]);

        Storage::disk('public')->put('publications/covers/to-delete-cover.jpg', 'fake');
        Storage::disk('public')->put('publications/documents/to-delete-doc.pdf', 'fake');

        $this->delete(route('admin.publications.destroy', $publication))->assertRedirect();

        Storage::disk('public')->assertMissing('publications/covers/to-delete-cover.jpg');
        Storage::disk('public')->assertMissing('publications/documents/to-delete-doc.pdf');
        $this->assertDatabaseMissing('publications', ['id' => $publication->id]);
    }

    public function test_update_replaces_cover_and_deletes_old(): void
    {
        Storage::fake('public');

        $publication = Publication::factory()->create([
            'cover_image' => 'publications/covers/old-cover.jpg',
        ]);

        Storage::disk('public')->put('publications/covers/old-cover.jpg', 'fake');

        $newImage = UploadedFile::fake()->image('new-cover.jpg', 800, 600)->size(100);

        $this->put(route('admin.publications.update', $publication), [
            'title' => $publication->title,
            'description' => $publication->description,
            'status' => $publication->status,
            'cover_image' => $newImage,
        ])->assertRedirect();

        $publication->refresh();

        Storage::disk('public')->assertMissing('publications/covers/old-cover.jpg');
        Storage::disk('public')->assertExists($publication->cover_image);
        $this->assertStringNotContainsString('publications/covers/publications/covers', $publication->cover_image);
    }
}
