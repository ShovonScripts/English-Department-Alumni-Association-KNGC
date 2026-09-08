<x-layouts.app title="Press Releases" description="Official announcements and press releases from the English Department Alumni Association KNGC.">
    <x-page-header
        eyebrow="Press Releases"
        title="Official Announcements"
        description="Stay informed with the latest official communications from EDAA-KNGC."
    />

    @if ($featuredRelease)
        <section class="bg-white py-12 sm:py-16">
            <div class="container-page">
                <a href="{{ route('press-releases.show', $featuredRelease) }}" class="group">
                    <article class="grid gap-8 rounded-xl border border-navy-100 bg-cream p-8 shadow-sm transition-colors hover:border-gold-500/40 sm:p-10 lg:grid-cols-2">
                        @if ($featuredRelease->cover_image)
                            <div class="overflow-hidden rounded-lg">
                                <img src="{{ $featuredRelease->cover_image_url }}" alt="{{ $featuredRelease->title }}" class="h-64 w-full object-cover transition-transform duration-500 group-hover:scale-105 sm:h-80">
                            </div>
                        @else
                            <div class="flex items-center justify-center rounded-lg bg-gradient-to-br from-navy-900 to-navy-800 p-8">
                                <span class="font-serif text-4xl font-bold text-gold-300/40">EDAA</span>
                            </div>
                        @endif

                        <div class="flex flex-col justify-center">
                            <div class="flex items-center gap-3">
                                <span class="inline-flex rounded-full bg-maroon-700 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-white">Featured</span>
                                @if ($featuredRelease->document_path)
                                    <span class="inline-flex rounded-full bg-navy-100 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-navy-700">PDF</span>
                                @endif
                            </div>
                            <h2 class="mt-4 font-serif text-2xl font-bold text-navy-950 transition-colors group-hover:text-maroon-700 sm:text-3xl">
                                {{ $featuredRelease->title }}
                            </h2>
                            @if ($featuredRelease->excerpt)
                                <p class="mt-3 text-ink-soft leading-relaxed line-clamp-3">{{ $featuredRelease->excerpt }}</p>
                            @endif
                            <p class="mt-4 text-sm text-ink-soft">
                                {{ $featuredRelease->formatted_date }}
                            </p>
                        </div>
                    </article>
                </a>
            </div>
        </section>
    @endif

    <section class="bg-cream py-8 sm:py-10">
        <div class="container-page">
            <form method="GET" action="{{ route('press-releases.index') }}" class="flex flex-col gap-4 sm:flex-row sm:items-end">
                <div class="flex-1">
                    <label for="search" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Search</label>
                    <input
                        type="search"
                        id="search"
                        name="search"
                        value="{{ $filters['search'] ?? '' }}"
                        placeholder="Search press releases…"
                        class="w-full rounded-md border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 placeholder-navy-400 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none"
                    >
                </div>
                <div class="flex gap-3">
                    <x-button type="submit" variant="navy">Search</x-button>
                    @if (! empty($filters['search']))
                        <a href="{{ route('press-releases.index') }}" class="focus-ring inline-flex items-center gap-2 rounded-md px-3.5 py-2 text-sm font-semibold text-navy-800 transition-colors hover:bg-navy-50">Clear</a>
                    @endif
                </div>
            </form>
        </div>
    </section>

    <section class="section-pad bg-white">
        <div class="container-page">
            @if ($pressReleases->isNotEmpty())
                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($pressReleases as $release)
                        <a href="{{ route('press-releases.show', $release) }}" class="card-lift shine glow-top group flex h-full flex-col overflow-hidden rounded-xl border border-white/20 bg-white/80 shadow-sm backdrop-blur-sm">
                            @if ($release->cover_image)
                                <div class="overflow-hidden">
                                    <img src="{{ $release->cover_image_url }}" alt="{{ $release->title }}" class="aspect-[16/9] w-full object-cover transition-transform duration-500 group-hover:scale-105">
                                </div>
                            @else
                                <div class="flex aspect-[16/9] items-center justify-center bg-gradient-to-br from-navy-900 to-navy-800">
                                    <span class="font-serif text-2xl font-bold text-gold-300/30">EDAA</span>
                                </div>
                            @endif

                            <div class="flex flex-1 flex-col p-6">
                                <div class="flex items-center gap-2">
                                    <time class="text-xs font-medium text-ink-soft" datetime="{{ $release->published_at?->toIso8601String() }}">
                                        {{ $release->formatted_date }}
                                    </time>
                                    @if ($release->document_path)
                                        <span class="inline-flex rounded-full bg-maroon-50 px-2 py-0.5 text-[10px] font-semibold uppercase text-maroon-700">PDF</span>
                                    @endif
                                </div>

                                <h3 class="mt-3 font-serif text-lg font-bold text-navy-950 transition-colors group-hover:text-maroon-700">
                                    {{ $release->title }}
                                </h3>

                                @if ($release->excerpt)
                                    <p class="mt-2 flex-1 text-sm leading-relaxed text-ink-soft line-clamp-3">{{ $release->excerpt }}</p>
                                @else
                                    <p class="mt-2 flex-1 text-sm leading-relaxed text-ink-soft line-clamp-3">{{ \Illuminate\Support\Str::limit(strip_tags($release->content ?? ''), 120) }}</p>
                                @endif

                                <div class="mt-4 flex items-center text-sm font-semibold text-maroon-700 transition-colors group-hover:text-maroon-800">
                                    Read more
                                    <svg class="ml-1 h-4 w-4 transition-transform group-hover:translate-x-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>

                <div class="mt-12">
                    {{ $pressReleases->links() }}
                </div>
            @else
                <x-empty-state
                    title="No press releases found"
                    description="No official announcements have been published yet. Check back soon for updates."
                />
            @endif
        </div>
    </section>
</x-layouts.app>
