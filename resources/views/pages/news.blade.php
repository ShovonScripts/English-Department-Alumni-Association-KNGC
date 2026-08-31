<x-layouts.app
    title="News & Announcements"
    description="Stay up to date with the latest news, announcements, and updates from the English Department Alumni Association KNGC."
>
    <x-page-header
        eyebrow="News & Announcements"
        title="Latest from the Association"
        description="Updates, stories, and announcements from the English Department Alumni Association KNGC community."
    />

    @if ($featuredNews)
        <section class="bg-white py-12 sm:py-16">
            <div class="container-page">
                <a href="{{ route('news.show', $featuredNews) }}" class="group">
                    <article class="grid gap-8 rounded-xl border border-navy-100 bg-cream p-8 shadow-sm transition-colors hover:border-gold-500/40 sm:p-10 lg:grid-cols-2">
                        @if ($featuredNews->featured_image_url)
                            <div class="relative overflow-hidden rounded-lg">
                                <img src="{{ $featuredNews->featured_image_url }}" alt="{{ $featuredNews->title }}" class="h-64 w-full object-cover transition duration-500 group-hover:scale-105 lg:h-full">
                            </div>
                        @else
                            <div class="flex h-64 items-center justify-center rounded-lg bg-gradient-to-br from-navy-800 via-navy-900 to-maroon-900 lg:h-full">
                                <svg class="h-16 w-16 text-gold-400/70" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.4" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 6a2 2 0 012-2h8l2 2h6a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V6z" />
                                </svg>
                            </div>
                        @endif

                        <div class="flex flex-col justify-center">
                            <div class="flex items-center gap-3">
                                @if ($featuredNews->category)
                                    <span class="rounded-full bg-navy-900 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-gold-300">{{ $featuredNews->category->name }}</span>
                                @endif
                                <span class="text-xs font-medium uppercase tracking-wider text-maroon-600">Featured</span>
                            </div>
                            <h2 class="mt-4 font-serif text-2xl font-semibold leading-snug text-navy-950 group-hover:text-maroon-700 sm:text-3xl">{{ $featuredNews->title }}</h2>
                            <p class="mt-4 text-ink-soft leading-relaxed">{{ $featuredNews->excerpt }}</p>
                            <div class="mt-6 flex items-center gap-4 text-sm text-ink-soft">
                                @if ($featuredNews->author_name)
                                    <span>By {{ $featuredNews->author_name }}</span>
                                @endif
                                <span>{{ $featuredNews->published_at?->format('F j, Y') }}</span>
                            </div>
                        </div>
                    </article>
                </a>
            </div>
        </section>
    @endif

    <section class="bg-cream py-8 sm:py-10">
        <div class="container-page">
            <form method="GET" action="{{ route('news.index') }}" class="flex flex-col gap-4 sm:flex-row sm:items-end">
                <div class="flex-1">
                    <label for="search" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Search</label>
                    <input type="search" id="search" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Search news..."
                        class="w-full rounded-md border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 placeholder-navy-400 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none">
                </div>
                <div class="sm:w-48">
                    <label for="category" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Category</label>
                    <select id="category" name="category" class="w-full rounded-md border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none">
                        <option value="">All Categories</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->slug }}" @selected(($filters['category'] ?? '') === $cat->slug)>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex gap-3">
                    <button type="submit" class="focus-ring inline-flex items-center gap-2 rounded-md bg-navy-900 px-5 py-2.5 text-sm font-semibold text-white transition-colors hover:bg-navy-800">Search</button>
                    @if (!empty($filters['search']) || !empty($filters['category']))
                        <a href="{{ route('news.index') }}" class="focus-ring inline-flex items-center gap-2 rounded-md px-3.5 py-2 text-sm font-semibold text-navy-800 transition-colors hover:bg-navy-50">Clear</a>
                    @endif
                </div>
            </form>
        </div>
    </section>

    <section class="section-pad bg-white">
        <div class="container-page">
            @if ($allNews->isNotEmpty())
                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($allNews as $article)
                        <x-news-card
                            :title="$article->title"
                            :excerpt="$article->excerpt"
                            :date="$article->published_at"
                            :category="$article->category?->name"
                            :author="$article->author_name"
                            :href="route('news.show', $article)"
                            :image="$article->featured_image_url"
                        />
                    @endforeach
                </div>

                <div class="mt-12">
                    {{ $allNews->links() }}
                </div>
            @else
                <x-empty-state
                    title="No news articles found"
                    description="No articles match your current search. Try different keywords or browse all news."
                    action_label="View All News"
                    action_href="{{ route('news.index') }}"
                />
            @endif
        </div>
    </section>
</x-layouts.app>
