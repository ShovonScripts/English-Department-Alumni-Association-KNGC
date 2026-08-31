@php
    $jsonLd = [
        '@context' => 'https://schema.org',
        '@type' => 'Event',
        'name' => $event->title,
        'description' => $event->short_description,
        'startDate' => $event->event_date->toIso8601String(),
        'organizer' => [
            '@type' => 'Organization',
            'name' => $event->organizer ?? 'English Department Alumni Association KNGC',
        ],
    ];

    if ($event->start_time) {
        $startDateTime = $event->event_date->copy()->setTimeFromTimeString($event->start_time);
        $jsonLd['startDate'] = $startDateTime->toIso8601String();
        if ($event->end_time) {
            $endDateTime = $event->event_date->copy()->setTimeFromTimeString($event->end_time);
            $jsonLd['endDate'] = $endDateTime->toIso8601String();
        }
    }

    if ($event->venue) {
        $jsonLd['location'] = [
            '@type' => 'Place',
            'name' => $event->venue,
        ];
        if ($event->address || $event->city || $event->country) {
            $jsonLd['location']['address'] = [
                '@type' => 'PostalAddress',
                'streetAddress' => $event->address,
                'addressLocality' => $event->city,
                'addressCountry' => $event->country,
            ];
        }
    }

    if ($event->cover_image_url) {
        $jsonLd['image'] = [url($event->cover_image_url)];
    }
    if ($event->capacity) {
        $jsonLd['maximumAttendeeCapacity'] = $event->capacity;
    }
    if ($event->registration_deadline) {
        $jsonLd['registrationDeadline'] = $event->registration_deadline->toIso8601String();
    }
    $jsonLd['url'] = route('events.show', $event);
@endphp

<x-layouts.app :title="$event->title . ' — Events'" :description="$event->short_description">

    @push('head')
        <script type="application/ld+json">{!! json_encode($jsonLd, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!}</script>
    @endpush

    <x-page-header
        :title="$event->title"
        :description="$event->short_description"
        :eyebrow="$event->category?->name ?? 'Event'"
        :breadcrumbs="[
            ['label' => 'Events', 'href' => route('events.index')],
            ['label' => $event->title],
        ]"
    />

    @if ($event->cover_image)
        <section class="bg-white">
            <div class="container-page pb-12">
                <div class="overflow-hidden rounded-xl">
                    <img src="{{ $event->cover_image_url }}" alt="{{ $event->title }}" class="h-72 w-full object-cover sm:h-96">
                </div>
            </div>
        </section>
    @endif

    <section class="section-pad bg-white">
        <div class="container-page">
            <div class="grid gap-12 lg:grid-cols-3">
                <div class="lg:col-span-2">
                    <div class="max-w-none text-base leading-relaxed text-navy-950">
                        {!! nl2br(e($event->description)) !!}
                    </div>
                </div>

                <aside class="space-y-8">
                    <div class="rounded-xl border border-navy-100 bg-cream p-6 shadow-sm">
                        <h2 class="font-serif text-lg font-semibold text-navy-950">Event Details</h2>
                        <dl class="mt-4 space-y-4 text-sm">
                            <div class="flex items-start gap-3">
                                <dt class="flex h-9 w-9 shrink-0 items-center justify-center rounded-md bg-navy-900 text-white">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3M4 11h16M5 5h14a1 1 0 011 1v13a1 1 0 01-1 1H5a1 1 0 01-1-1V6a1 1 0 011-1z" /></svg>
                                </dt>
                                <dd>
                                    <span class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Date</span>
                                    <p class="mt-1 font-medium text-navy-950">{{ $event->formatted_date }}</p>
                                </dd>
                            </div>

                            @if ($event->formatted_time)
                                <div class="flex items-start gap-3">
                                    <dt class="flex h-9 w-9 shrink-0 items-center justify-center rounded-md bg-navy-900 text-white">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    </dt>
                                    <dd>
                                        <span class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Time</span>
                                        <p class="mt-1 font-medium text-navy-950">{{ $event->formatted_time }}</p>
                                    </dd>
                                </div>
                            @endif

                            @if ($event->venue)
                                <div class="flex items-start gap-3">
                                    <dt class="flex h-9 w-9 shrink-0 items-center justify-center rounded-md bg-navy-900 text-white">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M17.7 11.9l-6.8 6.9a2 2 0 01-2.8 0l-3-3a2 2 0 010-2.8l6.9-6.8M14.8 3.2L20.8 9.2m-2-2l-4.5 4.5a4 4 0 00-1 2.1l-.2 1.5a.5.5 0 00.6.6l1.5-.2a4 4 0 002.1-1l4.5-4.5a2 2 0 000-2.8l-2.5-2.5a2 2 0 00-2.8 0z" /></svg>
                                    </dt>
                                    <dd>
                                        <span class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Venue</span>
                                        <p class="mt-1 font-medium text-navy-950">{{ $event->venue }}</p>
                                        @if ($event->address || $event->location)
                                            <p class="mt-0.5 text-sm text-ink-soft">{{ collect([$event->address, $event->location])->filter()->implode(', ') }}</p>
                                        @endif
                                    </dd>
                                </div>
                            @endif

                            @if ($event->organizer)
                                <div class="flex items-start gap-3">
                                    <dt class="flex h-9 w-9 shrink-0 items-center justify-center rounded-md bg-navy-900 text-white">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                    </dt>
                                    <dd>
                                        <span class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Organizer</span>
                                        <p class="mt-1 font-medium text-navy-950">{{ $event->organizer }}</p>
                                    </dd>
                                </div>
                            @endif

                            @if ($event->capacity)
                                <div class="flex items-start gap-3">
                                    <dt class="flex h-9 w-9 shrink-0 items-center justify-center rounded-md bg-navy-900 text-white">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                                    </dt>
                                    <dd>
                                        <span class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Capacity</span>
                                        <p class="mt-1 font-medium text-navy-950">{{ number_format($event->capacity) }} attendees</p>
                                    </dd>
                                </div>
                            @endif

                            @if ($event->registration_deadline)
                                <div class="flex items-start gap-3">
                                    <dt class="flex h-9 w-9 shrink-0 items-center justify-center rounded-md bg-navy-900 text-white">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    </dt>
                                    <dd>
                                        <span class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Registration Deadline</span>
                                        <p class="mt-1 font-medium text-navy-950">{{ $event->registration_deadline->format('l, F j, Y') }}</p>
                                    </dd>
                                </div>
                            @endif

                            @if ($event->category)
                                <div class="flex items-start gap-3">
                                    <dt class="flex h-9 w-9 shrink-0 items-center justify-center rounded-md bg-navy-900 text-white">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z" /></svg>
                                    </dt>
                                    <dd>
                                        <span class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Category</span>
                                        <p class="mt-1 font-medium text-navy-950">{{ $event->category->name }}</p>
                                    </dd>
                                </div>
                            @endif
                        </dl>
                    </div>

                    <a href="{{ route('events.index') }}" class="focus-ring flex w-full items-center justify-center gap-2 rounded-lg border border-navy-200 bg-white px-4 py-3 text-sm font-semibold text-navy-800 transition-colors hover:bg-navy-50">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M7 17L3 12m0 0l4-5m-4 5h18" /></svg>
                        Back to Events
                    </a>
                </aside>
            </div>
        </div>
    </section>

</x-layouts.app>
