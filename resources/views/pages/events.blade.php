<x-layouts.app title="Events" description="Lectures, reunions, and literary evenings hosted by the English Department Alumni Association KNGC.">

    <x-page-header
        title="Events"
        description="From scholarly lectures to joyful reunions, our events are the heartbeats of the community."
        eyebrow="Community Calendar"
        :breadcrumbs="[['label' => 'Events']]"
    />

    {{-- Search and filter --}}
    <section class="bg-white py-8">
        <div class="container-page">
            <form method="GET" action="{{ route('events.index') }}" class="flex flex-col gap-4 sm:flex-row sm:items-end">
                <div class="flex-1">
                    <label for="search" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Search</label>
                    <input
                        type="search"
                        id="search"
                        name="search"
                        value="{{ $filters['search'] }}"
                        placeholder="Search events…"
                        class="w-full rounded-md border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 placeholder-navy-400 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none"
                    >
                </div>
                <div>
                    <label for="category_id" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Category</label>
                    <select id="category_id" name="category_id" class="w-full rounded-md border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none">
                        <option value="">All categories</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}" @selected($filters['category_id'] == $cat->id)>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="timing" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Timing</label>
                    <select id="timing" name="timing" class="w-full rounded-md border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none">
                        <option value="">All</option>
                        <option value="upcoming" @selected($filters['timing'] === 'upcoming')>Upcoming</option>
                        <option value="past" @selected($filters['timing'] === 'past')>Past</option>
                    </select>
                </div>
                <div class="flex gap-3">
                    <x-button type="submit" variant="gold">Search</x-button>
                    <a href="{{ route('events.index') }}" class="focus-ring inline-flex items-center gap-2 rounded-md px-3.5 py-2 text-sm font-semibold text-navy-800 transition-colors hover:bg-navy-50">Reset</a>
                </div>
            </form>
        </div>
    </section>

    {{-- Featured event (first upcoming featured) --}}
    @php
        $featuredEvent = $upcomingEvents->firstWhere('is_featured', true) ?? $upcomingEvents->first();
    @endphp

    @if ($featuredEvent)
        <section class="section-pad bg-white">
            <div class="container-page">
                <div class="relative overflow-hidden rounded-xl bg-gradient-to-br from-navy-800 via-navy-900 to-maroon-900 text-white">
                    <div class="pointer-events-none absolute inset-0 opacity-[0.08]" aria-hidden="true">
                        <div class="absolute -right-16 -top-16 h-72 w-72 rounded-full border-2 border-gold-400"></div>
                    </div>
                    <div class="relative grid gap-8 p-8 sm:p-12 lg:grid-cols-3 lg:items-center">
                        <div class="lg:col-span-2">
                            <span class="inline-flex items-center gap-2 rounded-full bg-gold-500/20 px-4 py-1.5 text-xs font-semibold uppercase tracking-widest text-gold-300">
                                <span class="h-1.5 w-1.5 rounded-full bg-gold-400" aria-hidden="true"></span>
                                Next Event
                            </span>
                            <h2 class="mt-5 font-serif text-3xl font-semibold leading-tight sm:text-4xl">
                                <a href="{{ route('events.show', $featuredEvent) }}" class="focus-ring rounded transition-colors hover:text-gold-200">{{ $featuredEvent->title }}</a>
                            </h2>
                            <p class="mt-4 max-w-2xl text-navy-100">{{ $featuredEvent->short_description }}</p>
                            <div class="mt-6 flex flex-wrap items-center gap-x-6 gap-y-3 text-sm text-navy-100">
                                <span class="inline-flex items-center gap-2">
                                    <svg class="h-4 w-4 text-gold-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3M4 11h16M5 5h14a1 1 0 011 1v13a1 1 0 01-1 1H5a1 1 0 01-1-1V6a1 1 0 011-1z" /></svg>
                                    {{ $featuredEvent->formatted_date }}
                                </span>
                                @if ($featuredEvent->formatted_time)
                                    <span class="inline-flex items-center gap-2">
                                        <svg class="h-4 w-4 text-gold-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                        {{ $featuredEvent->formatted_time }}
                                    </span>
                                @endif
                                @if ($featuredEvent->venue)
                                    <span class="inline-flex items-center gap-2">
                                        <svg class="h-4 w-4 text-gold-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M17.7 11.9l-6.8 6.9a2 2 0 01-2.8 0l-3-3a2 2 0 010-2.8l6.9-6.8M14.8 3.2L20.8 9.2m-2-2l-4.5 4.5a4 4 0 00-1 2.1l-.2 1.5a.5.5 0 00.6.6l1.5-.2a4 4 0 002.1-1l4.5-4.5a2 2 0 000-2.8l-2.5-2.5a2 2 0 00-2.8 0z" /></svg>
                                        {{ $featuredEvent->venue }}
                                    </span>
                                @endif
                            </div>
                            <div class="mt-8">
                                <x-button href="{{ route('events.show', $featuredEvent) }}" variant="gold" :icon="true">View Details</x-button>
                            </div>
                        </div>
                        <div class="hidden lg:block">
                            <div class="mx-auto max-w-xs rounded-lg border border-white/10 bg-white/5 p-8 text-center backdrop-blur">
                                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-gold-300">Save the Date</p>
                                <p class="mt-4 font-serif text-6xl font-semibold text-white">{{ $featuredEvent->event_date->format('d') }}</p>
                                <p class="font-serif text-xl italic text-navy-100">{{ $featuredEvent->event_date->format('F') }}</p>
                                <p class="mt-2 text-sm text-navy-200">{{ $featuredEvent->event_date->format('Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    {{-- Upcoming events --}}
    @if ($upcomingEvents->count() > ($featuredEvent ? 1 : 0))
        <section class="section-pad bg-cream">
            <div class="container-page">
                <x-section-heading
                    eyebrow="Upcoming"
                    title="Mark your calendar"
                    description="Events are free for members and the wider university community unless otherwise noted."
                />

                <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($upcomingEvents as $event)
                        @if ($featuredEvent && $event->id === $featuredEvent->id)
                            @continue
                        @endif
                        <x-event-card
                            :title="$event->title"
                            :date="$event->event_date"
                            :time="$event->formatted_time"
                            :location="$event->venue"
                            :category="$event->category?->name"
                            :href="route('events.show', $event)"
                        />
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- Past events --}}
    @if ($pastEvents->isNotEmpty())
        <section class="section-pad bg-white">
            <div class="container-page">
                <x-section-heading
                    eyebrow="Archive"
                    title="Past events"
                    description="A look back at previous gatherings, lectures, and celebrations."
                />

                <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($pastEvents as $event)
                        <x-event-card
                            :title="$event->title"
                            :date="$event->event_date"
                            :time="$event->formatted_time"
                            :location="$event->venue"
                            :category="$event->category?->name"
                            :href="route('events.show', $event)"
                        />
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @if ($upcomingEvents->isEmpty() && $pastEvents->isEmpty())
        <section class="section-pad bg-white">
            <div class="container-page">
                <x-empty-state
                    title="No events yet"
                    description="Check back soon for upcoming lectures, reunions, and gatherings hosted by the association."
                    action_label="Contact Us"
                    action_href="{{ route('contact') }}"
                />
            </div>
        </section>
    @endif

</x-layouts.app>
