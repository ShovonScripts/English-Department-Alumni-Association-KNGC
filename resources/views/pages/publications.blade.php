<x-layouts.app
    title="Publications"
    description="Browse our collection of reports, magazines, research papers, and other publications from the English Department Alumni Association KNGC."
>
    <x-page-header
        eyebrow="Resources"
        title="Publications"
        description="Browse our collection of reports, magazines, research papers, and other publications."
    />

    <section class="bg-cream py-8 sm:py-10">
        <div class="container-page">
            <form method="GET" action="{{ route('publications.index') }}" class="flex flex-col gap-4 sm:flex-row sm:items-end">
                <div class="flex-1">
                    <label for="search" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Search</label>
                    <input type="search" id="search" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Search publications..."
                        class="w-full rounded-md border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 placeholder-navy-400 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none">
                </div>
                <div class="sm:w-48">
                    <label for="author" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Author</label>
                    <input type="text" id="author" name="author" value="{{ $filters['author'] ?? '' }}" placeholder="Filter by author..."
                        class="w-full rounded-md border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 placeholder-navy-400 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none">
                </div>
                <div class="sm:w-48">
                    <label for="publisher" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Publisher</label>
                    <input type="text" id="publisher" name="publisher" value="{{ $filters['publisher'] ?? '' }}" placeholder="Filter by publisher..."
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
                <div class="sm:w-48">
                    <label for="year" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Year</label>
                    <select id="year" name="year" class="w-full rounded-md border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none">
                        <option value="">All Years</option>
                        @foreach ($years as $y)
                            <option value="{{ $y }}" @selected(($filters['year'] ?? '') == $y)>{{ $y }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex gap-3">
                    <button type="submit" class="focus-ring inline-flex items-center gap-2 rounded-md bg-navy-900 px-5 py-2.5 text-sm font-semibold text-white transition-colors hover:bg-navy-800">Search</button>
                    @if (!empty($filters['search']) || !empty($filters['category']) || !empty($filters['author']) || !empty($filters['publisher']) || !empty($filters['year']))
                        <a href="{{ route('publications.index') }}" class="focus-ring inline-flex items-center gap-2 rounded-md px-3.5 py-2 text-sm font-semibold text-navy-800 transition-colors hover:bg-navy-50">Clear</a>
                    @endif
                </div>
            </form>
        </div>
    </section>

    @if ($featuredPublications && $featuredPublications->isNotEmpty())
        <section class="bg-white py-12 sm:py-16">
            <div class="container-page">
                <x-section-heading
                    eyebrow="Featured"
                    title="Featured Publications"
                    description="Highlighted selections from our publication collection."
                />

                <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($featuredPublications as $pub)
                        <x-publication-card
                            :title="$pub->title"
                            :type="$pub->document_original_name ? pathinfo($pub->document_original_name, PATHINFO_EXTENSION) : null"
                            :author="$pub->author"
                            :year="$pub->publication_date?->format('Y')"
                            :description="$pub->description"
                            :href="route('publications.show', $pub)"
                        />
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <section class="section-pad bg-white">
        <div class="container-page">
            @if ($publications->isNotEmpty())
                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($publications as $pub)
                        <article class="card-lift group flex h-full flex-col overflow-hidden rounded-lg border border-navy-100 bg-white shadow-sm">
                            @if ($pub->cover_image_url)
                                <div class="relative aspect-[16/9] overflow-hidden bg-navy-100">
                                    <img src="{{ $pub->cover_image_url }}" alt="{{ $pub->title }}" class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                                    @if ($pub->category)
                                        <span class="absolute left-4 top-4 rounded-full bg-navy-900/90 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-gold-300">
                                            {{ $pub->category->name }}
                                        </span>
                                    @endif
                                </div>
                            @else
                                <div class="relative flex aspect-[16/9] items-center justify-center bg-gradient-to-br from-navy-800 via-navy-900 to-maroon-900">
                                    <svg class="h-10 w-10 text-gold-400/70" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.4" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.3v11.4m0-11.4A3.2 3.2 0 009.5 3.5H6.5v13h3a3.2 3.2 0 013 2.8m-.5-12.9a3.2 3.2 0 012.5-2.8h3v13h-3a3.2 3.2 0 00-3 2.8m0-12.9v11.4" />
                                    </svg>
                                    @if ($pub->category)
                                        <span class="absolute left-4 top-4 rounded-full bg-navy-900/90 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-gold-300">
                                            {{ $pub->category->name }}
                                        </span>
                                    @endif
                                </div>
                            @endif

                            <div class="flex flex-1 flex-col p-6">
                                @if ($pub->publication_date)
                                    <p class="text-xs font-medium uppercase tracking-wider text-ink-soft">
                                        {{ $pub->publication_date->format('F j, Y') }}
                                    </p>
                                @endif

                                <h3 class="mt-2 font-serif text-xl font-semibold leading-snug text-navy-950">
                                    <a href="{{ route('publications.show', $pub) }}" class="focus-ring rounded transition-colors group-hover:text-maroon-700">{{ $pub->title }}</a>
                                </h3>

                                @if ($pub->author || $pub->publisher)
                                    <p class="mt-2 text-sm text-ink-soft">
                                        {{ collect([$pub->author, $pub->publisher])->filter()->implode(' · ') }}
                                    </p>
                                @endif

                                @if ($pub->description)
                                    <p class="mt-3 line-clamp-3 flex-1 text-sm leading-relaxed text-ink-soft">
                                        {{ $pub->description }}
                                    </p>
                                @endif

                                <div class="mt-4 flex items-center justify-between">
                                    @if ($pub->document_original_name)
                                        <span class="inline-flex rounded-full bg-maroon-50 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-maroon-700">
                                            {{ strtoupper(pathinfo($pub->document_original_name, PATHINFO_EXTENSION)) }}
                                        </span>
                                    @endif
                                    <a href="{{ route('publications.show', $pub) }}" class="focus-ring inline-flex items-center gap-1.5 text-sm font-semibold text-maroon-700 transition-colors group-hover:text-maroon-600">
                                        View details
                                        <svg class="h-4 w-4 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                <div class="mt-12">
                    {{ $publications->links() }}
                </div>
            @else
                <x-empty-state
                    title="No publications found"
                    description="No publications match your current search. Try different keywords or browse all publications."
                    action_label="View All Publications"
                    action_href="{{ route('publications.index') }}"
                />
            @endif
        </div>
    </section>
</x-layouts.app>
