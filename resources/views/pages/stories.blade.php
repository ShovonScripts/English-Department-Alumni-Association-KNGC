<x-layouts.app title="Alumni Stories" description="Personal stories and experiences shared by alumni of the English Department.">

    <x-page-header
        title="Alumni Stories"
        description="In their own words — reflections, memories, and journeys from the people who make this community what it is."
        eyebrow="Shared Experiences"
        :breadcrumbs="[['label' => 'Stories']]"
    />

    {{-- Featured Stories --}}
    @if ($featuredStories->isNotEmpty())
        <section class="section-pad bg-white">
            <div class="container-page">
                <x-section-heading
                    eyebrow="Featured"
                    title="Stories worth sharing"
                    description="Highlights from alumni who have shared their experiences."
                />

                <div class="mt-12 grid gap-6 lg:grid-cols-3">
                    @foreach ($featuredStories as $story)
                        <x-story-card
                            :name="$story->alumni?->full_name"
                            :graduation_year="$story->alumni?->graduation_year"
                            :quote="$story->excerpt"
                            :role="$story->alumni?->designation"
                            :image="$story->cover_image_url"
                            :href="route('stories.show', $story)"
                        />
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- All Stories --}}
    <section class="section-pad bg-cream">
        <div class="container-page">
            <x-section-heading
                eyebrow="All Stories"
                title="In their own words"
                description="A collection of stories our alumni have shared with the Association."
            />

            {{-- Search --}}
            <form method="GET" action="{{ route('stories.index') }}" class="mt-8 rounded-lg border border-navy-100 bg-white p-4 shadow-sm">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-end">
                    <div class="flex-1">
                        <label for="search" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Search</label>
                        <input
                            type="search"
                            id="search"
                            name="search"
                            value="{{ $filters['search'] ?? '' }}"
                            placeholder="Search stories…"
                            class="w-full rounded-md border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 placeholder-navy-400 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none"
                        >
                    </div>
                    <div class="flex gap-3">
                        <x-button type="submit" variant="navy">Search</x-button>
                        @if (!empty($filters['search']))
                            <a href="{{ route('stories.index') }}" class="focus-ring inline-flex items-center gap-2 rounded-md px-3.5 py-2 text-sm font-semibold text-navy-800 transition-colors hover:bg-navy-50">Clear</a>
                        @endif
                    </div>
                </div>
            </form>

            @if ($allStories->isNotEmpty())
                <div class="mt-10 grid gap-6 lg:grid-cols-3">
                    @foreach ($allStories as $story)
                        <x-story-card
                            :name="$story->alumni?->full_name"
                            :graduation_year="$story->alumni?->graduation_year"
                            :quote="$story->excerpt"
                            :role="$story->alumni?->designation"
                            :image="$story->cover_image_url"
                            :href="route('stories.show', $story)"
                        />
                    @endforeach
                </div>

                <div class="mt-10">
                    {{ $allStories->links() }}
                </div>
            @else
                <div class="mt-10">
                    <x-empty-state
                        title="No stories found"
                        description="No stories match your current search. Try adjusting your search terms."
                    />
                </div>
            @endif
        </div>
    </section>

    {{-- CTA --}}
    <section class="bg-white py-16 sm:py-20">
        <div class="container-page mx-auto max-w-2xl text-center">
            <x-section-heading
                eyebrow="Share Yours"
                title="Have a story to tell?"
                description="We love hearing from alumni. Send us your memory and we may feature it here."
                align="center"
            />
            <div class="mt-8 flex justify-center">
                <x-button href="{{ route('contact') }}" variant="maroon" size="lg" :icon="true">Share Your Story</x-button>
            </div>
        </div>
    </section>

</x-layouts.app>
