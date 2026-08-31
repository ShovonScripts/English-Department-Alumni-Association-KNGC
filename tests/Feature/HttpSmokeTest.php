<?php

namespace Tests\Feature;

use App\Models\Alumni;
use App\Models\NewsCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class HttpSmokeTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->admin()->create(['password' => Hash::make('password')]);
        $this->password = 'password';
        $this->actingAs($this->admin);
    }

    // ── Public routes return 200 ─────────────────────────────

    public function test_home_page_returns_200(): void
    {
        $this->get(route('home'))->assertOk();
    }

    public function test_about_page_returns_200(): void
    {
        $this->get(route('about'))->assertOk();
    }

    public function test_alumni_index_returns_200(): void
    {
        $this->get(route('alumni.index'))->assertOk();
    }

    public function test_committee_index_returns_200(): void
    {
        $this->get(route('committee.index'))->assertOk();
    }

    public function test_events_index_returns_200(): void
    {
        $this->get(route('events.index'))->assertOk();
    }

    public function test_news_index_returns_200(): void
    {
        $this->get(route('news.index'))->assertOk();
    }

    public function test_stories_index_returns_200(): void
    {
        $this->get(route('stories.index'))->assertOk();
    }

    public function test_gallery_index_returns_200(): void
    {
        $this->get(route('gallery.index'))->assertOk();
    }

    public function test_publications_index_returns_200(): void
    {
        $this->get(route('publications.index'))->assertOk();
    }

    public function test_contact_page_returns_200(): void
    {
        $this->get(route('contact'))->assertOk();
    }

    // ── Public show routes return 404 for nonexistent slugs ──

    public function test_alumni_nonexistent_slug_returns_404(): void
    {
        $this->get(route('alumni.show', 'nonexistent-slug-xyz'))->assertNotFound();
    }

    public function test_committee_nonexistent_slug_returns_404(): void
    {
        $this->get(route('committee.show', 'nonexistent-slug-xyz'))->assertNotFound();
    }

    public function test_events_nonexistent_slug_returns_404(): void
    {
        $this->get(route('events.show', 'nonexistent-slug-xyz'))->assertNotFound();
    }

    public function test_news_nonexistent_slug_returns_404(): void
    {
        $this->get(route('news.show', 'nonexistent-slug-xyz'))->assertNotFound();
    }

    public function test_stories_nonexistent_slug_returns_404(): void
    {
        $this->get(route('stories.show', 'nonexistent-slug-xyz'))->assertNotFound();
    }

    public function test_gallery_nonexistent_slug_returns_404(): void
    {
        $this->get(route('gallery.show', 'nonexistent-slug-xyz'))->assertNotFound();
    }

    // ── Admin index routes return 200 ───────────────────────

    public function test_admin_dashboard_returns_200(): void
    {
        $this->get(route('admin.dashboard'))->assertOk();
    }

    public function test_admin_alumni_index_returns_200(): void
    {
        $this->get(route('admin.alumni.index'))->assertOk();
    }

    public function test_admin_committee_index_returns_200(): void
    {
        $this->get(route('admin.committee.index'))->assertOk();
    }

    public function test_admin_events_index_returns_200(): void
    {
        $this->get(route('admin.events.index'))->assertOk();
    }

    public function test_admin_news_index_returns_200(): void
    {
        $this->get(route('admin.news.index'))->assertOk();
    }

    public function test_admin_stories_index_returns_200(): void
    {
        $this->get(route('admin.stories.index'))->assertOk();
    }

    public function test_admin_gallery_index_returns_200(): void
    {
        $this->get(route('admin.gallery.index'))->assertOk();
    }

    // ── Admin create pages return 200 ───────────────────────

    public function test_admin_alumni_create_returns_200(): void
    {
        $this->get(route('admin.alumni.create'))->assertOk();
    }

    public function test_admin_committee_create_returns_200(): void
    {
        $this->get(route('admin.committee.create'))->assertOk();
    }

    public function test_admin_events_create_returns_200(): void
    {
        $this->get(route('admin.events.create'))->assertOk();
    }

    public function test_admin_news_create_returns_200(): void
    {
        NewsCategory::create(['name' => 'Academic', 'slug' => 'academic', 'is_active' => true]);
        $this->get(route('admin.news.create'))->assertOk();
    }

    public function test_admin_stories_create_returns_200(): void
    {
        Alumni::factory()->create();
        $this->get(route('admin.stories.create'))->assertOk();
    }

    public function test_admin_gallery_create_returns_200(): void
    {
        $this->get(route('admin.gallery.create'))->assertOk();
    }
}
