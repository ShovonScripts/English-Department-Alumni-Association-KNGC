<x-layouts.app title="Gallery" description="Photo albums from English Department Alumni Association KNGC events and gatherings.">

    <x-page-header
        title="Gallery"
        description="Reunions, lectures, and celebrations — captured in pictures and preserved for the community."
        eyebrow="Moments"
        :breadcrumbs="[['label' => 'Gallery']]"
    />

    <section class="section-pad bg-white">
        <div class="container-page">
            <x-section-heading
                eyebrow="Albums"
                title="Browse the collection"
                description="A selection of our photo albums from Association events."
            />

            {{-- Search --}}
            <form method="GET" action="{{ route('gallery.index') }}" class="mt-8 rounded-lg border border-navy-100 bg-white p-4 shadow-sm">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-end">
                    <div class="flex-1">
                        <label for="search" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Search</label>
                        <input
                            type="search"
                            id="search"
                            name="search"
                            value="{{ $filters['search'] ?? '' }}"
                            placeholder="Search albums…"
                            class="w-full rounded-md border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 placeholder-navy-400 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none"
                        >
                    </div>
                    <div class="flex gap-3">
                        <x-button type="submit" variant="navy">Search</x-button>
                        @if (!empty($filters['search']))
                            <a href="{{ route('gallery.index') }}" class="focus-ring inline-flex items-center gap-2 rounded-md px-3.5 py-2 text-sm font-semibold text-navy-800 transition-colors hover:bg-navy-50">Clear</a>
                        @endif
                    </div>
                </div>
            </form>

            @if ($albums->isNotEmpty())
                <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($albums as $album)
                        <x-gallery-card
                            :title="$album->title"
                            :category="$album->event?->title"
                            :image="$album->cover_image_url"
                            :count="$album->photos_count"
                            :href="route('gallery.show', $album)"
                        />
                    @endforeach
                </div>

                <div class="mt-10">
                    {{ $albums->links() }}
                </div>
            @else
                <div class="mt-10">
                    <x-empty-state
                        title="No albums found"
                        description="No albums match your current search. Try adjusting your search terms."
                    />
                </div>
            @endif
        </div>
    </section>

</x-layouts.app>
