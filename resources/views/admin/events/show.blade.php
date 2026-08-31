<x-layouts.admin :title="$event->title">
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="font-serif text-3xl font-semibold tracking-tight text-navy-950">{{ $event->title }}</h1>
            <p class="mt-1 text-sm text-ink-soft">Event details and preview.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.events.edit', $event) }}" class="focus-ring inline-flex items-center gap-2 rounded-md px-3.5 py-2 text-sm font-semibold text-navy-800 transition-colors hover:bg-navy-50">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.4-9.4a2 2 0 112.8 2.8L11 15l-4 1 1-4 9.6-9.4z" />
                </svg>
                Edit
            </a>
            <a href="{{ route('admin.events.index') }}" class="focus-ring inline-flex items-center gap-2 rounded-md px-3.5 py-2 text-sm font-semibold text-navy-800 transition-colors hover:bg-navy-50">
                &larr; Back to Events
            </a>
        </div>
    </div>

    <div class="grid gap-8 lg:grid-cols-3">
        <div class="space-y-8 lg:col-span-2">
            {{-- Main --}}
            <section class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm sm:p-8">
                <h2 class="font-serif text-xl font-semibold text-navy-950">Description</h2>
                <p class="mt-4 whitespace-pre-line text-sm leading-relaxed text-navy-950">{{ $event->description }}</p>
            </section>

            {{-- Meta --}}
            <section class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm sm:p-8">
                <h2 class="font-serif text-xl font-semibold text-navy-950">Details</h2>
                <div class="mt-4 grid gap-4 sm:grid-cols-2">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Category</p>
                        <p class="mt-1 text-sm text-navy-950">{{ $event->category?->name ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Event Date</p>
                        <p class="mt-1 text-sm text-navy-950">{{ $event->formatted_date }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Time</p>
                        <p class="mt-1 text-sm text-navy-950">{{ $event->formatted_time ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Capacity</p>
                        <p class="mt-1 text-sm text-navy-950">{{ $event->capacity ? number_format($event->capacity) : '—' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Registration Deadline</p>
                        <p class="mt-1 text-sm text-navy-950">{{ $event->registration_deadline?->format('M j, Y') ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Organizer</p>
                        <p class="mt-1 text-sm text-navy-950">{{ $event->organizer ?? '—' }}</p>
                    </div>
                </div>
            </section>
        </div>

        {{-- Sidebar --}}
        <aside class="space-y-8">
            {{-- Cover Image --}}
            <section class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm">
                <h2 class="font-serif text-lg font-semibold text-navy-950">Cover Image</h2>
                <div class="mt-4">
                    @if ($event->cover_image)
                        <img src="{{ $event->cover_image_url }}" alt="{{ $event->title }}" class="w-full rounded-lg object-cover ring-4 ring-gold-500/30">
                    @else
                        <div class="flex h-40 items-center justify-center rounded-lg border-2 border-dashed border-navy-200 bg-cream">
                            <span class="text-sm text-ink-soft">No image</span>
                        </div>
                    @endif
                </div>
            </section>

            {{-- Status --}}
            <section class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm">
                <h2 class="font-serif text-lg font-semibold text-navy-950">Status</h2>
                <div class="mt-4 space-y-3">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Status</p>
                        @if ($event->status === 'published')
                            <span class="mt-1 inline-flex items-center gap-1.5 rounded-full bg-navy-100 px-2.5 py-1 text-xs font-semibold text-navy-800">
                                <span class="h-1.5 w-1.5 rounded-full bg-navy-600" aria-hidden="true"></span>
                                Published
                            </span>
                        @else
                            <span class="mt-1 inline-flex items-center gap-1.5 rounded-full bg-maroon-100 px-2.5 py-1 text-xs font-semibold text-maroon-800">
                                <span class="h-1.5 w-1.5 rounded-full bg-maroon-600" aria-hidden="true"></span>
                                Draft
                            </span>
                        @endif
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Featured</p>
                        <p class="mt-1 text-sm text-navy-950">{{ $event->is_featured ? 'Yes' : 'No' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Sort Order</p>
                        <p class="mt-1 text-sm text-navy-950">{{ $event->sort_order }}</p>
                    </div>
                </div>
            </section>

            {{-- Location --}}
            <section class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm">
                <h2 class="font-serif text-lg font-semibold text-navy-950">Location</h2>
                <div class="mt-4 space-y-3">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Venue</p>
                        <p class="mt-1 text-sm text-navy-950">{{ $event->venue ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Address</p>
                        <p class="mt-1 text-sm text-navy-950">{{ $event->address ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-ink-soft">City, Country</p>
                        <p class="mt-1 text-sm text-navy-950">{{ $event->location ?? '—' }}</p>
                    </div>
                </div>
            </section>

            {{-- Timestamps --}}
            <section class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm">
                <h2 class="font-serif text-lg font-semibold text-navy-950">Timestamps</h2>
                <div class="mt-4 space-y-3">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Created</p>
                        <p class="mt-1 text-sm text-navy-950">{{ $event->created_at->format('M j, Y g:i A') }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Updated</p>
                        <p class="mt-1 text-sm text-navy-950">{{ $event->updated_at->format('M j, Y g:i A') }}</p>
                    </div>
                </div>
            </section>
        </aside>
    </div>
</x-layouts.admin>
