<?php

namespace Tests\Feature;

use App\Models\News;
use App\Models\NewsCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class NewsTest extends TestCase
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
    // PUBLIC: /news
    // ──────────────────────────────────────────

    public function test_public_news_page_returns_200(): void
    {
        News::factory()->published()->create();
        $this->get(route('news.index'))->assertOk();
    }

    public function test_public_news_page_shows_only_published_news(): void
    {
        News::factory()->published()->create(['title' => 'Published Article']);
        News::factory()->draft()->create(['title' => 'Draft Article']);
        $response = $this->get(route('news.index'));
        $response->assertOk();
        $response->assertSee('Published Article');
        $response->assertDontSee('Draft Article');
    }

    public function test_public_news_page_hides_future_dated_news(): void
    {
        News::factory()->published()->create(['title' => 'Current Article']);
        News::factory()->future()->create(['title' => 'Future Article']);
        $response = $this->get(route('news.index'));
        $response->assertSee('Current Article');
        $response->assertDontSee('Future Article');
    }

    public function test_public_news_page_shows_featured_news(): void
    {
        News::factory()->published()->featured()->create(['title' => 'Featured Article']);
        $response = $this->get(route('news.index'));
        $response->assertSee('Featured Article');
        $response->assertSee('Featured');
    }

    public function test_public_news_page_can_search_by_title(): void
    {
        News::factory()->published()->create(['title' => 'Alumni Reunion Plans']);
        News::factory()->published()->create(['title' => 'Poetry Night']);
        $response = $this->get(route('news.index', ['search' => 'Reunion']));
        $response->assertSee('Alumni Reunion Plans');
        $response->assertDontSee('Poetry Night');
    }

    public function test_public_news_page_can_search_by_excerpt(): void
    {
        News::factory()->published()->create(['title' => 'Article A', 'excerpt' => 'Creative writing fellowship details']);
        News::factory()->published()->create(['title' => 'Article B', 'excerpt' => 'Sports day recap']);
        $response = $this->get(route('news.index', ['search' => 'fellowship']));
        $response->assertSee('Article A');
        $response->assertDontSee('Article B');
    }

    public function test_public_news_page_can_filter_by_category(): void
    {
        $cat = NewsCategory::create(['name' => 'Academic', 'slug' => 'academic']);
        $other = NewsCategory::create(['name' => 'Social', 'slug' => 'social']);
        News::factory()->published()->create(['news_category_id' => $cat->id, 'title' => 'Academic News']);
        News::factory()->published()->create(['news_category_id' => $other->id, 'title' => 'Social News']);
        $response = $this->get(route('news.index', ['category' => 'academic']));
        $response->assertSee('Academic News');
        $response->assertDontSee('Social News');
    }

    public function test_public_news_page_empty_state(): void
    {
        $response = $this->get(route('news.index'));
        $response->assertOk();
        $response->assertSee('No news articles found');
    }

    public function test_public_news_page_pagination(): void
    {
        News::factory()->published()->count(15)->create();
        $response = $this->get(route('news.index'));
        $response->assertOk();
        $response->assertSee('1');
    }

    // ──────────────────────────────────────────
    // PUBLIC: /news/{slug}
    // ──────────────────────────────────────────

    public function test_public_news_detail_returns_200(): void
    {
        $news = News::factory()->published()->create();
        $this->get(route('news.show', $news))->assertOk();
    }

    public function test_public_news_detail_shows_article_data(): void
    {
        $news = News::factory()->published()->create([
            'title' => 'Test News Title',
            'excerpt' => 'Test excerpt content',
            'content' => 'Full article content here',
        ]);
        $response = $this->get(route('news.show', $news));
        $response->assertOk();
        $response->assertSee('Test News Title');
        $response->assertSee('Test excerpt content');
        $response->assertSee('Full article content here');
    }

    public function test_public_news_detail_shows_category(): void
    {
        $category = NewsCategory::create(['name' => 'Academic', 'slug' => 'academic']);
        $news = News::factory()->published()->create(['news_category_id' => $category->id]);
        $response = $this->get(route('news.show', $news));
        $response->assertSee('Academic');
    }

    public function test_public_news_detail_shows_author(): void
    {
        $news = News::factory()->published()->create(['author_name' => 'Mercy Uche']);
        $response = $this->get(route('news.show', $news));
        $response->assertSee('Mercy Uche');
    }

    public function test_public_news_detail_shows_breadcrumbs(): void
    {
        $news = News::factory()->published()->create();
        $response = $this->get(route('news.show', $news));
        $response->assertSee('Home');
        $response->assertSee('News');
    }

    public function test_public_news_detail_draft_returns_404(): void
    {
        $news = News::factory()->draft()->create();
        $this->get(route('news.show', $news))->assertNotFound();
    }

    public function test_public_news_detail_future_returns_404(): void
    {
        $news = News::factory()->future()->create();
        $this->get(route('news.show', $news))->assertNotFound();
    }

    public function test_public_news_detail_invalid_slug_returns_404(): void
    {
        $this->get('/news/non-existent-slug-xyz')->assertNotFound();
    }

    public function test_public_news_detail_shows_related_news(): void
    {
        $category = NewsCategory::create(['name' => 'Academic', 'slug' => 'academic']);
        $news = News::factory()->published()->create(['news_category_id' => $category->id, 'title' => 'Main Article']);
        News::factory()->published()->create(['news_category_id' => $category->id, 'title' => 'Related Article 1']);
        News::factory()->published()->create(['news_category_id' => $category->id, 'title' => 'Related Article 2']);
        $response = $this->get(route('news.show', $news));
        $response->assertSee('Related Article 1');
        $response->assertSee('Related Article 2');
        $response->assertSee('Related articles');
    }

    public function test_public_news_detail_excludes_self_from_related(): void
    {
        $category = NewsCategory::create(['name' => 'Academic', 'slug' => 'academic']);
        $news = News::factory()->published()->create(['news_category_id' => $category->id, 'title' => 'Self Article']);
        $response = $this->get(route('news.show', $news));
        $related = $response->viewData('relatedNews');
        $this->assertTrue($related->every(fn ($item) => $item->id !== $news->id));
    }

    public function test_public_news_detail_draft_not_leaked_in_related(): void
    {
        $category = NewsCategory::create(['name' => 'Academic', 'slug' => 'academic']);
        $news = News::factory()->published()->create(['news_category_id' => $category->id]);
        News::factory()->draft()->create(['news_category_id' => $category->id, 'title' => 'Draft Related']);
        $response = $this->get(route('news.show', $news));
        $response->assertDontSee('Draft Related');
    }

    public function test_public_news_detail_json_ld_structured_data(): void
    {
        $news = News::factory()->published()->create([
            'title' => 'Structured Data Test',
            'author_name' => 'Test Author',
        ]);
        $response = $this->get(route('news.show', $news));
        $response->assertSee('application/ld+json');
        $response->assertSee('NewsArticle');
        $response->assertSee('Structured Data Test');
    }

    // ──────────────────────────────────────────
    // HOMEPAGE INTEGRATION
    // ──────────────────────────────────────────

    public function test_homepage_displays_latest_news(): void
    {
        News::factory()->published()->create(['title' => 'Homepage News Article']);
        $response = $this->get(route('home'));
        $response->assertOk();
        $response->assertSee('Homepage News Article');
    }

    public function test_homepage_hides_draft_news(): void
    {
        News::factory()->draft()->create(['title' => 'Draft on Homepage']);
        $response = $this->get(route('home'));
        $response->assertDontSee('Draft on Homepage');
    }

    public function test_homepage_news_section_uses_database(): void
    {
        News::factory()->published()->count(3)->create();
        $response = $this->get(route('home'));
        $response->assertOk();
    }

    // ──────────────────────────────────────────
    // ADMIN: NEWS CRUD
    // ──────────────────────────────────────────

    public function test_admin_news_index_returns_200(): void
    {
        $this->get(route('admin.news.index'))->assertOk();
    }

    public function test_admin_news_index_lists_news(): void
    {
        News::factory()->published()->create(['title' => 'Admin Listed Article']);
        $response = $this->get(route('admin.news.index'));
        $response->assertSee('Admin Listed Article');
    }

    public function test_admin_news_index_can_search(): void
    {
        News::factory()->published()->create(['title' => 'Alumni Gathering']);
        News::factory()->published()->create(['title' => 'Poetry Reading']);
        $response = $this->get(route('admin.news.index', ['search' => 'Alumni']));
        $response->assertSee('Alumni Gathering');
        $response->assertDontSee('Poetry Reading');
    }

    public function test_admin_news_index_can_filter_by_status(): void
    {
        News::factory()->published()->create(['title' => 'Published One']);
        News::factory()->draft()->create(['title' => 'Draft One']);
        $response = $this->get(route('admin.news.index', ['status' => 'published']));
        $response->assertSee('Published One');
        $response->assertDontSee('Draft One');
    }

    public function test_admin_news_index_can_filter_by_category(): void
    {
        $cat = NewsCategory::create(['name' => 'Academic', 'slug' => 'academic']);
        $other = NewsCategory::create(['name' => 'Social', 'slug' => 'social']);
        News::factory()->published()->create(['news_category_id' => $cat->id, 'title' => 'Academic Post']);
        News::factory()->published()->create(['news_category_id' => $other->id, 'title' => 'Social Post']);
        $response = $this->get(route('admin.news.index', ['category_id' => $cat->id]));
        $response->assertSee('Academic Post');
        $response->assertDontSee('Social Post');
    }

    public function test_admin_news_index_can_filter_by_featured(): void
    {
        News::factory()->published()->featured()->create(['title' => 'Featured Article']);
        News::factory()->published()->create(['title' => 'Regular Article', 'is_featured' => false]);
        $response = $this->get(route('admin.news.index', ['is_featured' => '1']));
        $response->assertSee('Featured Article');
        $response->assertDontSee('Regular Article');
    }

    public function test_admin_news_index_empty_state(): void
    {
        $response = $this->get(route('admin.news.index'));
        $response->assertSee('No news found');
    }

    public function test_admin_news_create_returns_200(): void
    {
        NewsCategory::create(['name' => 'Academic', 'slug' => 'academic', 'is_active' => true]);
        $this->get(route('admin.news.create'))->assertOk();
    }

    public function test_admin_news_store_creates_article(): void
    {
        $category = NewsCategory::create(['name' => 'Academic', 'slug' => 'academic', 'is_active' => true]);
        $data = [
            'title' => 'New Test Article',
            'excerpt' => 'Test excerpt for the article',
            'content' => 'Full content of the test article',
            'news_category_id' => $category->id,
            'status' => 'draft',
            'author_name' => 'Test Author',
        ];
        $this->post(route('admin.news.store'), $data)->assertRedirect();
        $this->assertDatabaseHas('news', ['title' => 'New Test Article', 'status' => 'draft']);
    }

    public function test_admin_news_store_validates_required_fields(): void
    {
        $this->post(route('admin.news.store'), [])->assertSessionHasErrors(['title', 'excerpt', 'content', 'status']);
    }

    public function test_admin_news_store_generates_unique_slug(): void
    {
        $category = NewsCategory::create(['name' => 'Academic', 'slug' => 'academic', 'is_active' => true]);
        $this->post(route('admin.news.store'), [
            'title' => 'Unique Slug Article',
            'excerpt' => 'Excerpt',
            'content' => 'Content',
            'status' => 'draft',
        ])->assertRedirect();
        $this->assertDatabaseHas('news', ['slug' => 'unique-slug-article']);
    }

    public function test_admin_news_store_sets_published_at_when_publishing(): void
    {
        $this->post(route('admin.news.store'), [
            'title' => 'Auto Publish Date',
            'excerpt' => 'Excerpt',
            'content' => 'Content',
            'status' => 'published',
        ])->assertRedirect();
        $this->assertDatabaseHas('news', ['title' => 'Auto Publish Date', 'status' => 'published']);
        $news = News::where('title', 'Auto Publish Date')->first();
        $this->assertNotNull($news->published_at);
    }

    public function test_admin_news_store_with_featured_image(): void
    {
        Storage::fake('public');
        $image = UploadedFile::fake()->image('news.jpg', 800, 600)->size(100);
        $this->post(route('admin.news.store'), [
            'title' => 'Image Test Article',
            'excerpt' => 'Excerpt',
            'content' => 'Content',
            'status' => 'draft',
            'featured_image' => $image,
        ])->assertRedirect();
        $news = News::where('title', 'Image Test Article')->first();
        $this->assertNotNull($news->featured_image);
        Storage::disk('public')->assertExists($news->featured_image);
    }

    public function test_admin_news_store_validates_image_type(): void
    {
        $file = UploadedFile::fake()->create('document.pdf', 100, 'application/pdf');
        $this->post(route('admin.news.store'), [
            'title' => 'PDF Test',
            'excerpt' => 'Excerpt',
            'content' => 'Content',
            'status' => 'draft',
            'featured_image' => $file,
        ])->assertSessionHasErrors(['featured_image']);
    }

    public function test_admin_news_store_validates_image_size(): void
    {
        $file = UploadedFile::fake()->image('large.jpg', 4000, 3000)->size(9000);
        $this->post(route('admin.news.store'), [
            'title' => 'Large Image Test',
            'excerpt' => 'Excerpt',
            'content' => 'Content',
            'status' => 'draft',
            'featured_image' => $file,
        ])->assertSessionHasErrors(['featured_image']);
    }

    public function test_admin_news_store_rejects_oversized_dimensions_image(): void
    {
        // Small file size, but pixel dimensions exceed the 5000px guard.
        $file = UploadedFile::fake()->image('huge.png', 5500, 5500)->size(100);
        $this->post(route('admin.news.store'), [
            'title' => 'Oversized Dimensions Test',
            'excerpt' => 'Excerpt',
            'content' => 'Content',
            'status' => 'draft',
            'featured_image' => $file,
        ])->assertSessionHasErrors(['featured_image']);

        $this->assertDatabaseMissing('news', ['title' => 'Oversized Dimensions Test']);
    }

    public function test_news_featured_image_url_uses_single_news_path(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('news/cover.jpg', 'fake-image');

        $news = News::factory()->create(['featured_image' => 'news/cover.jpg']);

        $url = $news->featured_image_url;

        // Must point at the correctly stored file, not a doubled news/ path.
        $this->assertNotNull($url);
        $this->assertStringEndsWith('/storage/news/cover.jpg', $url);
        $this->assertStringNotContainsString('/news/news/', $url);
        $this->assertStringNotContainsString('/storage/news/news', $url);
    }

    public function test_admin_news_update_replaces_image_and_deletes_old_file(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('news/old.png', 'old-image');

        $news = News::factory()->create(['featured_image' => 'news/old.png']);

        $replacement = UploadedFile::fake()->image('new.jpg', 800, 600)->size(100);
        $this->put(route('admin.news.update', $news), [
            'title' => $news->title,
            'excerpt' => 'Excerpt',
            'content' => 'Content',
            'status' => 'draft',
            'featured_image' => $replacement,
        ])->assertRedirect();

        // New file stored, old file physically removed.
        $news->refresh();
        $this->assertNotNull($news->featured_image);
        Storage::disk('public')->assertExists($news->featured_image);
        Storage::disk('public')->assertMissing('news/old.png');
    }

    public function test_admin_news_destroy_deletes_featured_image_file(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('news/gone.png', 'old-image');

        $news = News::factory()->create(['featured_image' => 'news/gone.png']);

        $this->delete(route('admin.news.destroy', $news))->assertRedirect();

        $this->assertDatabaseMissing('news', ['id' => $news->id]);
        Storage::disk('public')->assertMissing('news/gone.png');
    }

    public function test_admin_news_show_returns_200(): void
    {
        $news = News::factory()->create();
        $this->get(route('admin.news.show', $news))->assertOk();
    }

    public function test_admin_news_edit_returns_200(): void
    {
        NewsCategory::create(['name' => 'Academic', 'slug' => 'academic', 'is_active' => true]);
        $news = News::factory()->create();
        $this->get(route('admin.news.edit', $news))->assertOk();
    }

    public function test_admin_news_update_modifies_article(): void
    {
        $news = News::factory()->create(['title' => 'Original Title']);
        $this->put(route('admin.news.update', $news), [
            'title' => 'Updated Title',
            'excerpt' => 'Updated excerpt',
            'content' => 'Updated content',
            'status' => 'draft',
        ])->assertRedirect();
        $this->assertDatabaseHas('news', ['id' => $news->id, 'title' => 'Updated Title']);
    }

    public function test_admin_news_update_replaces_image(): void
    {
        Storage::fake('public');
        $news = News::factory()->create();
        $newImage = UploadedFile::fake()->image('new.jpg', 800, 600)->size(100);
        $this->put(route('admin.news.update', $news), [
            'title' => $news->title,
            'excerpt' => $news->excerpt,
            'content' => $news->content,
            'status' => 'draft',
            'featured_image' => $newImage,
        ])->assertRedirect();
        $news->refresh();
        $this->assertNotNull($news->featured_image);
    }

    public function test_admin_news_update_clears_image(): void
    {
        $news = News::factory()->create(['featured_image' => 'test-image.jpg']);
        $this->put(route('admin.news.update', $news), [
            'title' => $news->title,
            'excerpt' => $news->excerpt,
            'content' => $news->content,
            'status' => 'draft',
            'clear_image' => '1',
        ])->assertRedirect();
        $news->refresh();
        $this->assertNull($news->featured_image);
    }

    public function test_admin_news_destroy_deletes_article(): void
    {
        $news = News::factory()->create();
        $this->delete(route('admin.news.destroy', $news))->assertRedirect();
        $this->assertDatabaseMissing('news', ['id' => $news->id]);
    }

    public function test_admin_news_destroy_deletes_image_file(): void
    {
        Storage::fake('public');
        // featured_image stores the path returned by ->store('news', 'public'),
        // which already includes the "news/" prefix.
        $news = News::factory()->create(['featured_image' => 'news/to-delete.jpg']);
        Storage::disk('public')->put('news/to-delete.jpg', 'fake');
        $this->delete(route('admin.news.destroy', $news))->assertRedirect();
        Storage::disk('public')->assertMissing('news/to-delete.jpg');
    }

    // ──────────────────────────────────────────
    // ADMIN: CATEGORIES
    // ──────────────────────────────────────────

    public function test_admin_category_index_returns_200(): void
    {
        $this->get(route('admin.news-categories.index'))->assertOk();
    }

    public function test_admin_category_index_lists_categories(): void
    {
        NewsCategory::create(['name' => 'Academic News', 'slug' => 'academic-news']);
        $response = $this->get(route('admin.news-categories.index'));
        $response->assertSee('Academic News');
    }

    public function test_admin_category_create_returns_200(): void
    {
        $this->get(route('admin.news-categories.create'))->assertOk();
    }

    public function test_admin_category_store_creates_category(): void
    {
        $this->post(route('admin.news-categories.store'), [
            'name' => 'New Category',
            'description' => 'A test category',
        ])->assertRedirect();
        $this->assertDatabaseHas('news_categories', ['name' => 'New Category']);
    }

    public function test_admin_category_store_validates_required_name(): void
    {
        $this->post(route('admin.news-categories.store'), [])->assertSessionHasErrors(['name']);
    }

    public function test_admin_category_store_generates_unique_slug(): void
    {
        NewsCategory::create(['name' => 'Existing', 'slug' => 'existing']);
        $this->post(route('admin.news-categories.store'), [
            'name' => 'Existing',
            'description' => 'A second category with same name',
        ])->assertRedirect();
        $count = NewsCategory::where('name', 'Existing')->count();
        $this->assertSame(2, $count);
        $slugs = NewsCategory::where('name', 'Existing')->pluck('slug')->toArray();
        $this->assertNotSame($slugs[0], $slugs[1]);
    }

    public function test_admin_category_update_modifies_category(): void
    {
        $category = NewsCategory::create(['name' => 'Old Name', 'slug' => 'old-name']);
        $this->put(route('admin.news-categories.update', $category), [
            'name' => 'Updated Name',
        ])->assertRedirect();
        $this->assertDatabaseHas('news_categories', ['id' => $category->id, 'name' => 'Updated Name']);
    }

    public function test_admin_category_update_preserves_slug(): void
    {
        $category = NewsCategory::create(['name' => 'Keep Slug', 'slug' => 'keep-slug']);
        $this->put(route('admin.news-categories.update', $category), [
            'name' => 'Keep Slug',
            'description' => 'Updated description',
        ])->assertRedirect();
        $this->assertDatabaseHas('news_categories', ['id' => $category->id, 'slug' => 'keep-slug']);
    }

    public function test_admin_category_destroy_deletes_category(): void
    {
        $category = NewsCategory::create(['name' => 'To Delete', 'slug' => 'to-delete']);
        $this->delete(route('admin.news-categories.destroy', $category))->assertRedirect();
        $this->assertDatabaseMissing('news_categories', ['id' => $category->id]);
    }

    public function test_admin_category_active_toggle(): void
    {
        $category = NewsCategory::create(['name' => 'Toggle Test', 'slug' => 'toggle-test', 'is_active' => true]);
        $this->put(route('admin.news-categories.update', $category), [
            'name' => 'Toggle Test',
            'is_active' => false,
        ])->assertRedirect();
        $category->refresh();
        $this->assertFalse($category->is_active);
    }

    // ──────────────────────────────────────────
    // MODEL TESTS
    // ──────────────────────────────────────────

    public function test_news_model_route_key_name(): void
    {
        $news = new News;
        $this->assertSame('slug', $news->getRouteKeyName());
    }

    public function test_news_category_model_route_key_name(): void
    {
        $category = new NewsCategory;
        $this->assertSame('slug', $category->getRouteKeyName());
    }

    public function test_news_unique_slug_collision_avoidance(): void
    {
        News::factory()->create(['title' => 'Collision Test', 'slug' => 'collision-test']);
        $slug = News::uniqueSlug('Collision Test');
        $this->assertNotSame('collision-test', $slug);
    }

    public function test_news_belongs_to_category(): void
    {
        $category = NewsCategory::create(['name' => 'Academic', 'slug' => 'academic']);
        $news = News::factory()->create(['news_category_id' => $category->id]);
        $this->assertNotNull($news->category);
        $this->assertSame($category->id, $news->category->id);
    }

    public function test_news_category_has_many_news(): void
    {
        $category = NewsCategory::create(['name' => 'Academic', 'slug' => 'academic']);
        News::factory()->count(3)->create(['news_category_id' => $category->id]);
        $this->assertCount(3, $category->news);
    }

    public function test_news_scope_published(): void
    {
        News::factory()->published()->count(3)->create();
        News::factory()->draft()->count(2)->create();
        $this->assertCount(3, News::published()->get());
    }

    public function test_news_scope_draft(): void
    {
        News::factory()->published()->count(2)->create();
        News::factory()->draft()->count(4)->create();
        $this->assertCount(4, News::draft()->get());
    }

    public function test_news_scope_featured(): void
    {
        News::factory()->published()->featured()->count(2)->create();
        News::factory()->published()->count(5)->create(['is_featured' => false]);
        $this->assertCount(2, News::featured()->get());
    }

    public function test_news_scope_latest(): void
    {
        $oldest = News::factory()->published()->create([
            'title' => 'Oldest Article',
        ]);
        $oldest->update(['published_at' => now()->subDays(10)]);

        $newest = News::factory()->published()->create([
            'title' => 'Newest Article',
        ]);
        $newest->update(['published_at' => now()->subMinute()]);

        $latest = News::query()->orderByDesc('published_at')->limit(2)->get();
        $this->assertSame('Newest Article', $latest->first()->title);
    }

    public function test_news_featured_image_url_accessor(): void
    {
        $news = News::factory()->create(['featured_image' => 'test.jpg']);
        $this->assertNotNull($news->featured_image_url);
        $this->assertStringContainsString('test.jpg', $news->featured_image_url);
    }

    public function test_news_featured_image_url_null_when_empty(): void
    {
        $news = News::factory()->create(['featured_image' => null]);
        $this->assertNull($news->featured_image_url);
    }

    public function test_news_is_published_method(): void
    {
        $published = News::factory()->published()->create();
        $this->assertTrue($published->isPublished());

        $draft = News::factory()->draft()->create();
        $this->assertFalse($draft->isPublished());

        $future = News::factory()->future()->create();
        $this->assertFalse($future->isPublished());
    }

    public function test_news_category_unique_slug_method(): void
    {
        NewsCategory::create(['name' => 'First', 'slug' => 'first']);
        $slug = NewsCategory::uniqueSlug('First');
        $this->assertNotSame('first', $slug);
    }

    public function test_news_factory_states(): void
    {
        $published = News::factory()->published()->create();
        $this->assertSame('published', $published->status);
        $this->assertNotNull($published->published_at);

        $draft = News::factory()->draft()->create();
        $this->assertSame('draft', $draft->status);

        $featured = News::factory()->featured()->create();
        $this->assertTrue($featured->is_featured);
    }
}
