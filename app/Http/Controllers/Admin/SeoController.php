<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SeoPageMeta;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SeoController extends Controller
{
    /**
     * SEO Dashboard — overview of all configured pages.
     */
    public function index()
    {
        $pages = SeoPageMeta::orderBy('uri')->get();
        $publicPages = SeoPageMeta::publicPageUris();
        $metas = $pages->keyBy('uri');

        $configuredCount = $pages->count();
        $totalPages = count($publicPages);
        $noindexCount = $pages->where('noindex', true)->count();
        $withDescriptionCount = $pages->whereNotNull('description')->where('description', '!=', '')->count();
        $withOgImageCount = $pages->whereNotNull('og_image')->where('og_image', '!=', '')->count();

        return view('admin.seo.index', compact(
            'pages', 'publicPages', 'metas', 'configuredCount', 'totalPages',
            'noindexCount', 'withDescriptionCount', 'withOgImageCount'
        ));
    }

    /**
     * Global SEO settings form.
     */
    public function settings()
    {
        return view('admin.seo.settings');
    }

    /**
     * Update global SEO settings.
     */
    public function updateSettings(Request $request)
    {
        $validated = $request->validate([
            'seo_meta_title' => 'nullable|string|max:255',
            'seo_meta_description' => 'nullable|string|max:500',
            'seo_meta_keywords' => 'nullable|string|max:500',
            'seo_og_title' => 'nullable|string|max:255',
            'seo_og_description' => 'nullable|string|max:500',
            'seo_og_image' => 'nullable|image|mimes:jpeg,png,webp|max:8192',
            'seo_og_type' => 'nullable|string|max:50',
            'seo_twitter_title' => 'nullable|string|max:255',
            'seo_twitter_description' => 'nullable|string|max:500',
            'seo_twitter_image' => 'nullable|image|mimes:jpeg,png,webp|max:8192',
            'seo_twitter_card' => 'nullable|string|max:50',
            'seo_twitter_handle' => 'nullable|string|max:50',
            'seo_facebook_app_id' => 'nullable|string|max:50',
            'seo_google_analytics_id' => 'nullable|string|max:50',
            'seo_google_tag_manager' => 'nullable|string|max:50',
            'seo_verification_code' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('seo_og_image')) {
            $old = SiteSetting::get('seo_og_image');
            if ($old && Storage::disk('public')->exists($old)) {
                Storage::disk('public')->delete($old);
            }
            $validated['seo_og_image'] = $request->file('seo_og_image')->store('seo', 'public');
        } else {
            unset($validated['seo_og_image']);
        }

        if ($request->hasFile('seo_twitter_image')) {
            $old = SiteSetting::get('seo_twitter_image');
            if ($old && Storage::disk('public')->exists($old)) {
                Storage::disk('public')->delete($old);
            }
            $validated['seo_twitter_image'] = $request->file('seo_twitter_image')->store('seo', 'public');
        } else {
            unset($validated['seo_twitter_image']);
        }

        foreach ($validated as $key => $value) {
            SiteSetting::set($key, $value);
        }

        return redirect()->route('admin.seo.settings')
            ->with('status', 'Global SEO settings updated successfully.');
    }

    /**
     * Per-page metadata management — list all public pages.
     */
    public function pages()
    {
        $publicPages = SeoPageMeta::publicPageUris();
        $metas = SeoPageMeta::orderBy('uri')->get()->keyBy('uri');

        return view('admin.seo.pages', compact('publicPages', 'metas'));
    }

    /**
     * Edit SEO metadata for a specific page.
     */
    public function editPage(string $encodedUri)
    {
        $uri = urldecode($encodedUri);
        $meta = SeoPageMeta::findByUri($uri);
        $publicPages = SeoPageMeta::publicPageUris();
        $pageName = $publicPages[$uri] ?? $uri;

        return view('admin.seo.page-edit', compact('uri', 'meta', 'pageName'));
    }

    /**
     * Update SEO metadata for a specific page.
     */
    public function updatePage(Request $request, string $encodedUri)
    {
        $uri = urldecode($encodedUri);

        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:500',
            'keywords' => 'nullable|string|max:500',
            'og_title' => 'nullable|string|max:255',
            'og_description' => 'nullable|string|max:500',
            'og_image' => 'nullable|image|mimes:jpeg,png,webp|max:8192',
            'og_type' => 'nullable|string|max:50',
            'twitter_title' => 'nullable|string|max:255',
            'twitter_description' => 'nullable|string|max:500',
            'twitter_image' => 'nullable|image|mimes:jpeg,png,webp|max:8192',
            'twitter_card' => 'nullable|string|max:50',
            'noindex' => 'nullable',
            'nofollow' => 'nullable',
            'canonical' => 'nullable|url|max:500',
            'schema_markup' => 'nullable|string',
        ]);

        $validated['noindex'] = $request->boolean('noindex');
        $validated['nofollow'] = $request->boolean('nofollow');
        $validated['uri'] = $uri;

        if ($request->hasFile('og_image')) {
            $meta = SeoPageMeta::findByUri($uri);
            if ($meta && $meta->og_image && Storage::disk('public')->exists($meta->og_image)) {
                Storage::disk('public')->delete($meta->og_image);
            }
            $validated['og_image'] = $request->file('og_image')->store('seo/pages', 'public');
        } else {
            unset($validated['og_image']);
        }

        if ($request->hasFile('twitter_image')) {
            $meta = SeoPageMeta::findByUri($uri);
            if ($meta && $meta->twitter_image && Storage::disk('public')->exists($meta->twitter_image)) {
                Storage::disk('public')->delete($meta->twitter_image);
            }
            $validated['twitter_image'] = $request->file('twitter_image')->store('seo/pages', 'public');
        } else {
            unset($validated['twitter_image']);
        }

        SeoPageMeta::updateOrCreate(
            ['uri' => $uri],
            $validated
        );

        return redirect()->route('admin.seo.pages')
            ->with('status', "SEO metadata updated for {$uri}");
    }

    /**
     * Reset SEO metadata for a specific page to defaults.
     */
    public function resetPage(string $encodedUri)
    {
        $uri = urldecode($encodedUri);
        $meta = SeoPageMeta::findByUri($uri);

        if ($meta) {
            if ($meta->og_image && Storage::disk('public')->exists($meta->og_image)) {
                Storage::disk('public')->delete($meta->og_image);
            }
            if ($meta->twitter_image && Storage::disk('public')->exists($meta->twitter_image)) {
                Storage::disk('public')->delete($meta->twitter_image);
            }
            $meta->delete();
        }

        return redirect()->route('admin.seo.pages')
            ->with('status', "SEO metadata reset for {$uri}");
    }

    /**
     * Robots.txt editor.
     */
    public function robots()
    {
        $content = $this->getRobotsContent();

        return view('admin.seo.robots', compact('content'));
    }

    /**
     * Update robots.txt.
     */
    public function updateRobots(Request $request)
    {
        $request->validate([
            'robots_content' => 'required|string|max:10000',
        ]);

        $content = $request->input('robots_content');
        Storage::disk('public')->put('robots.txt', $content);

        return redirect()->route('admin.seo.robots')
            ->with('status', 'robots.txt updated successfully.');
    }

    /**
     * Reset robots.txt to default.
     */
    public function resetRobots()
    {
        $default = $this->defaultRobotsContent();
        Storage::disk('public')->put('robots.txt', $default);

        return redirect()->route('admin.seo.robots')
            ->with('status', 'robots.txt reset to default.');
    }

    /**
     * Get robots.txt content.
     */
    private function getRobotsContent(): string
    {
        if (Storage::disk('public')->exists('robots.txt')) {
            return Storage::disk('public')->get('robots.txt');
        }

        return $this->defaultRobotsContent();
    }

    /**
     * Default robots.txt content.
     */
    private function defaultRobotsContent(): string
    {
        return <<<ROBOTS
User-agent: *
Allow: /
Disallow: /admin/
Disallow: /member/
Disallow: /api/

Sitemap: {$this->sitemapUrl()}

ROBOTS;
    }

    /**
     * Sitemap configuration page.
     */
    public function sitemap()
    {
        $settings = [
            'sitemap_last_generated' => SiteSetting::get('sitemap_last_generated', 'Never'),
            'sitemap_url_count' => $this->countSitemapUrls(),
        ];

        return view('admin.seo.sitemap', $settings);
    }

    /**
     * Generate the sitemap.xml file.
     */
    public function generateSitemap()
    {
        $urls = $this->collectSitemapUrls();

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"' . "\n";
        $xml .= '        xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"' . "\n";
        $xml .= '        xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9' . "\n";
        $xml .= '        http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">' . "\n";

        foreach ($urls as $url) {
            $xml .= '    <url>' . "\n";
            $xml .= '        <loc>' . e($url['loc']) . '</loc>' . "\n";
            if (isset($url['lastmod'])) {
                $xml .= '        <lastmod>' . e($url['lastmod']) . '</lastmod>' . "\n";
            }
            if (isset($url['priority'])) {
                $xml .= '        <priority>' . e($url['priority']) . '</priority>' . "\n";
            }
            if (isset($url['changefreq'])) {
                $xml .= '        <changefreq>' . e($url['changefreq']) . '</changefreq>' . "\n";
            }
            $xml .= '    </url>' . "\n";
        }

        $xml .= '</urlset>' . "\n";

        Storage::disk('public')->put('sitemap.xml', $xml);
        SiteSetting::set('sitemap_last_generated', now()->toDateTimeString());
        SiteSetting::set('sitemap_url_count', count($urls));

        return redirect()->route('admin.seo.sitemap')
            ->with('status', "Sitemap generated with " . count($urls) . " URLs.");
    }

    /**
     * Collect all URLs for the sitemap.
     */
    private function collectSitemapUrls(): array
    {
        $baseUrl = config('app.url');
        $urls = [];

        // Static pages
        $staticPages = [
            '/' => ['priority' => '1.0', 'changefreq' => 'weekly'],
            '/about' => ['priority' => '0.8', 'changefreq' => 'monthly'],
            '/events' => ['priority' => '0.9', 'changefreq' => 'daily'],
            '/news' => ['priority' => '0.9', 'changefreq' => 'daily'],
            '/stories' => ['priority' => '0.7', 'changefreq' => 'weekly'],
            '/gallery' => ['priority' => '0.6', 'changefreq' => 'weekly'],
            '/leaderboard' => ['priority' => '0.5', 'changefreq' => 'monthly'],
            '/finance' => ['priority' => '0.5', 'changefreq' => 'monthly'],
            '/committees' => ['priority' => '0.6', 'changefreq' => 'monthly'],
            '/publications' => ['priority' => '0.7', 'changefreq' => 'weekly'],
            '/press-releases' => ['priority' => '0.7', 'changefreq' => 'weekly'],
            '/contact' => ['priority' => '0.8', 'changefreq' => 'monthly'],
            '/credits' => ['priority' => '0.3', 'changefreq' => 'yearly'],
            '/members' => ['priority' => '0.6', 'changefreq' => 'weekly'],
            '/membership' => ['priority' => '0.7', 'changefreq' => 'monthly'],
            '/membership/apply' => ['priority' => '0.6', 'changefreq' => 'monthly'],
        ];

        foreach ($staticPages as $path => $meta) {
            $metaEntry = SeoPageMeta::findByUri($path);
            $urls[] = [
                'loc' => $baseUrl . $path,
                'lastmod' => now()->toDateString(),
                'priority' => $meta['priority'],
                'changefreq' => $meta['changefreq'],
            ];
        }

        // Dynamic pages: News
        try {
            $news = \App\Models\News::where('status', \App\Models\News::STATUS_PUBLISHED)
                ->orderByDesc('published_at')
                ->get(['slug', 'updated_at']);

            foreach ($news as $article) {
                $urls[] = [
                    'loc' => $baseUrl . '/news/' . $article->slug,
                    'lastmod' => $article->updated_at->toDateString(),
                    'priority' => '0.7',
                    'changefreq' => 'monthly',
                ];
            }
        } catch (\Exception $e) {
            // Table might not exist yet
        }

        // Dynamic pages: Events
        try {
            $events = \App\Models\Event::where('status', \App\Models\Event::STATUS_PUBLISHED)
                ->orderByDesc('event_date')
                ->get(['slug', 'updated_at']);

            foreach ($events as $event) {
                $urls[] = [
                    'loc' => $baseUrl . '/events/' . $event->slug,
                    'lastmod' => $event->updated_at->toDateString(),
                    'priority' => '0.8',
                    'changefreq' => 'monthly',
                ];
            }
        } catch (\Exception $e) {}

        // Dynamic pages: Alumni Stories
        try {
            $stories = \App\Models\AlumniStory::where('status', \App\Models\AlumniStory::STATUS_PUBLISHED)
                ->orderByDesc('created_at')
                ->get(['slug', 'updated_at']);

            foreach ($stories as $story) {
                $urls[] = [
                    'loc' => $baseUrl . '/stories/' . $story->slug,
                    'lastmod' => $story->updated_at->toDateString(),
                    'priority' => '0.6',
                    'changefreq' => 'monthly',
                ];
            }
        } catch (\Exception $e) {}

        // Dynamic pages: Publications
        try {
            $publications = \App\Models\Publication::where('status', \App\Models\Publication::STATUS_PUBLISHED)
                ->orderByDesc('created_at')
                ->get(['slug', 'updated_at']);

            foreach ($publications as $pub) {
                $urls[] = [
                    'loc' => $baseUrl . '/publications/' . $pub->slug,
                    'lastmod' => $pub->updated_at->toDateString(),
                    'priority' => '0.6',
                    'changefreq' => 'monthly',
                ];
            }
        } catch (\Exception $e) {}

        // Dynamic pages: Press Releases
        try {
            $pressReleases = \App\Models\PressRelease::where('status', \App\Models\PressRelease::STATUS_PUBLISHED)
                ->orderByDesc('created_at')
                ->get(['slug', 'updated_at']);

            foreach ($pressReleases as $pr) {
                $urls[] = [
                    'loc' => $baseUrl . '/press-releases/' . $pr->slug,
                    'lastmod' => $pr->updated_at->toDateString(),
                    'priority' => '0.6',
                    'changefreq' => 'monthly',
                ];
            }
        } catch (\Exception $e) {}

        // Dynamic pages: Gallery Albums
        try {
            $albums = \App\Models\GalleryAlbum::orderByDesc('created_at')
                ->get(['slug', 'updated_at']);

            foreach ($albums as $album) {
                $urls[] = [
                    'loc' => $baseUrl . '/gallery/' . $album->slug,
                    'lastmod' => $album->updated_at->toDateString(),
                    'priority' => '0.5',
                    'changefreq' => 'monthly',
                ];
            }
        } catch (\Exception $e) {}

        return $urls;
    }

    /**
     * Count URLs that would be in the sitemap.
     */
    private function countSitemapUrls(): int
    {
        return count($this->collectSitemapUrls());
    }

    /**
     * Get sitemap URL for robots.txt.
     */
    private function sitemapUrl(): string
    {
        return config('app.url') . '/sitemap.xml';
    }
}
