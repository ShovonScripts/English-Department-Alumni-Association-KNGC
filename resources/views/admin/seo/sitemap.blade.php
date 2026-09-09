<x-layouts.admin title="Sitemap Generator">
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="font-serif text-3xl font-semibold tracking-tight text-navy-950">Sitemap Generator</h1>
                <p class="mt-1 text-sm text-ink-soft">
                    Generate and manage your XML sitemap for search engines.
                </p>
            </div>
            <a href="{{ route('admin.seo.index') }}" class="focus-ring inline-flex items-center gap-2 rounded-lg border border-navy-200 bg-white px-4 py-2.5 text-sm font-semibold text-navy-950 transition-colors hover:bg-navy-50">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back
            </a>
        </div>
    </div>

    @if (session('status'))
        <div class="mb-6 flex items-center gap-3 rounded-md border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800" role="status">
            <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            {{ session('status') }}
        </div>
    @endif

    {{-- Stats --}}
    <div class="mb-8 grid gap-4 sm:grid-cols-3">
        <div class="rounded-lg border border-navy-100 bg-white p-5 shadow-sm">
            <p class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Status</p>
            <div class="mt-2 flex items-center gap-2">
                @if (\Illuminate\Support\Facades\Storage::disk('public')->exists('sitemap.xml'))
                    <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-100 px-2.5 py-0.5 text-xs font-medium text-emerald-700">
                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                        Generated
                    </span>
                @else
                    <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-100 px-2.5 py-0.5 text-xs font-medium text-amber-700">
                        <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>
                        Not Generated
                    </span>
                @endif
            </div>
        </div>

        <div class="rounded-lg border border-navy-100 bg-white p-5 shadow-sm">
            <p class="text-xs font-semibold uppercase tracking-wider text-ink-soft">URLs in Sitemap</p>
            <p class="mt-2 text-2xl font-bold text-navy-950">{{ number_format($sitemap_url_count) }}</p>
        </div>

        <div class="rounded-lg border border-navy-100 bg-white p-5 shadow-sm">
            <p class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Last Generated</p>
            <p class="mt-2 text-sm font-semibold text-navy-950">{{ $sitemap_last_generated }}</p>
        </div>
    </div>

    {{-- Generate --}}
    <div class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm sm:p-8">
        <div class="flex items-center gap-3 mb-6">
            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-navy-100">
                <svg class="h-5 w-5 text-navy-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2" />
                </svg>
            </div>
            <div>
                <h2 class="text-lg font-semibold text-navy-950">Generate Sitemap</h2>
                <p class="text-sm text-ink-soft">Create a fresh XML sitemap with all your public pages and content.</p>
            </div>
        </div>

        <div class="rounded-lg bg-navy-50 p-4 text-sm text-navy-700">
            <p class="font-semibold">What's included:</p>
            <ul class="mt-2 space-y-1 text-navy-600">
                <li class="flex items-center gap-2">
                    <svg class="h-4 w-4 shrink-0 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                    All static public pages (home, about, events, news, etc.)
                </li>
                <li class="flex items-center gap-2">
                    <svg class="h-4 w-4 shrink-0 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                    Published news articles with slugs
                </li>
                <li class="flex items-center gap-2">
                    <svg class="h-4 w-4 shrink-0 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                    Events with slugs
                </li>
                <li class="flex items-center gap-2">
                    <svg class="h-4 w-4 shrink-0 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                    Alumni stories, publications, press releases, gallery albums
                </li>
                <li class="flex items-center gap-2">
                    <svg class="h-4 w-4 shrink-0 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                    Priority and change frequency hints for crawlers
                </li>
            </ul>
        </div>

        <form method="POST" action="{{ route('admin.seo.sitemap.generate') }}" class="mt-6">
            @csrf
            <button type="submit" class="focus-ring inline-flex items-center gap-2 rounded-lg bg-navy-900 px-6 py-3 text-sm font-semibold text-white transition-colors hover:bg-navy-800">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                Generate Sitemap Now
            </button>
        </form>

        @if (\Illuminate\Support\Facades\Storage::disk('public')->exists('sitemap.xml'))
            <div class="mt-6">
                <a href="{{ asset('sitemap.xml') }}" target="_blank" rel="noopener noreferrer" class="focus-ring inline-flex items-center gap-2 text-sm font-semibold text-navy-950 hover:text-maroon-700 transition-colors">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                    </svg>
                    View current sitemap.xml
                </a>
            </div>
        @endif
    </div>
</x-layouts.admin>
