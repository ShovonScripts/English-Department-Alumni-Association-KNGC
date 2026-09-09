<x-layouts.admin title="Robots.txt Editor">
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="font-serif text-3xl font-semibold tracking-tight text-navy-950">Robots.txt Editor</h1>
                <p class="mt-1 text-sm text-ink-soft">
                    Control how search engine crawlers access your site.
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

    <div class="grid gap-6 lg:grid-cols-3">
        {{-- Editor --}}
        <div class="lg:col-span-2">
            <form method="POST" action="{{ route('admin.seo.robots.update') }}" class="space-y-4">
                @csrf
                @method('PUT')

                <div class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm sm:p-8">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-navy-100">
                            <svg class="h-5 w-5 text-navy-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold text-navy-950">Edit robots.txt</h2>
                            <p class="text-sm text-ink-soft">Define rules for search engine crawlers.</p>
                        </div>
                    </div>

                    <div>
                        <label for="robots_content" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Content</label>
                        <textarea
                            id="robots_content"
                            name="robots_content"
                            rows="20"
                            class="w-full rounded-md border border-navy-300 bg-navy-950 px-4 py-3 text-sm font-mono text-emerald-400 placeholder-navy-500 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none resize-none"
                            spellcheck="false"
                        >{{ old('robots_content', $content) }}</textarea>
                        @error('robots_content')
                            <p class="mt-1.5 text-xs font-medium text-maroon-700">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mt-4 flex items-center justify-end gap-3">
                        <button type="button" onclick="document.getElementById('robots_content').value=defaultRobots" class="focus-ring inline-flex items-center justify-center rounded-md px-4 py-2.5 text-sm font-semibold text-navy-600 transition-colors hover:bg-navy-50">
                            Reset to Default
                        </button>
                        <x-button type="submit" variant="gold">
                            Save robots.txt
                        </x-button>
                    </div>
                </div>
            </form>
        </div>

        {{-- Help --}}
        <div class="space-y-4">
            <div class="rounded-lg border border-navy-100 bg-white p-5 shadow-sm">
                <h3 class="text-sm font-semibold text-navy-950">Quick Reference</h3>
                <div class="mt-3 space-y-3 text-xs text-navy-600">
                    <div>
                        <code class="rounded bg-navy-100 px-1.5 py-0.5 text-navy-700">User-agent: *</code>
                        <p class="mt-1">Applies to all crawlers.</p>
                    </div>
                    <div>
                        <code class="rounded bg-navy-100 px-1.5 py-0.5 text-navy-700">Allow: /</code>
                        <p class="mt-1">Allow crawling of all paths.</p>
                    </div>
                    <div>
                        <code class="rounded bg-navy-100 px-1.5 py-0.5 text-navy-700">Disallow: /admin/</code>
                        <p class="mt-1">Block crawling of admin paths.</p>
                    </div>
                    <div>
                        <code class="rounded bg-navy-100 px-1.5 py-0.5 text-navy-700">Sitemap: https://...</code>
                        <p class="mt-1">Point to your sitemap URL.</p>
                    </div>
                    <div>
                        <code class="rounded bg-navy-100 px-1.5 py-0.5 text-navy-700">Crawl-delay: 10</code>
                        <p class="mt-1">Rate limit for Yandex/Bing.</p>
                    </div>
                </div>
            </div>

            <div class="rounded-lg border border-navy-100 bg-white p-5 shadow-sm">
                <h3 class="text-sm font-semibold text-navy-950">Tips</h3>
                <ul class="mt-3 space-y-2 text-xs text-navy-600">
                    <li class="flex items-start gap-2">
                        <svg class="mt-0.5 h-3 w-3 shrink-0 text-gold-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>
                        <span>Always block <code class="rounded bg-navy-100 px-1 py-0.5">/admin/</code> and <code class="rounded bg-navy-100 px-1 py-0.5">/member/</code> paths.</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="mt-0.5 h-3 w-3 shrink-0 text-gold-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>
                        <span>Include your sitemap URL for better indexing.</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="mt-0.5 h-3 w-3 shrink-0 text-gold-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>
                        <span>The file is served from <code class="rounded bg-navy-100 px-1 py-0.5">public/robots.txt</code>.</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        const defaultRobots = `User-agent: *
Allow: /
Disallow: /admin/
Disallow: /member/
Disallow: /api/

Sitemap: {{ config('app.url') }}/sitemap.xml`;
    </script>
    @endpush
</x-layouts.admin>
