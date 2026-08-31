<x-layouts.admin :title="$alumniStory->title">
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="font-serif text-3xl font-semibold tracking-tight text-navy-950">{{ $alumniStory->title }}</h1>
            <p class="mt-1 text-sm text-ink-soft">Story details and preview.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.stories.edit', $alumniStory) }}" class="focus-ring inline-flex items-center gap-2 rounded-md px-3.5 py-2 text-sm font-semibold text-navy-800 transition-colors hover:bg-navy-50">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.4-9.4a2 2 0 112.8 2.8L11 15l-4 1 1-4 9.6-9.4z" />
                </svg>
                Edit
            </a>
            <a href="{{ route('admin.stories.index') }}" class="focus-ring inline-flex items-center gap-2 rounded-md px-3.5 py-2 text-sm font-semibold text-navy-800 transition-colors hover:bg-navy-50">
                &larr; Back to Stories
            </a>
        </div>
    </div>

    <div class="grid gap-8 lg:grid-cols-3">
        <div class="space-y-8 lg:col-span-2">
            <section class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm sm:p-8">
                <h2 class="font-serif text-xl font-semibold text-navy-950">Content</h2>
                <div class="mt-4 whitespace-pre-line text-sm leading-relaxed text-navy-950">{{ $alumniStory->content }}</div>
            </section>

            <section class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm sm:p-8">
                <h2 class="font-serif text-xl font-semibold text-navy-950">Details</h2>
                <div class="mt-4 grid gap-4 sm:grid-cols-2">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Alumni</p>
                        <p class="mt-1 text-sm text-navy-950">{{ $alumniStory->alumni?->full_name ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Author</p>
                        <p class="mt-1 text-sm text-navy-950">{{ $alumniStory->author_name ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Published</p>
                        <p class="mt-1 text-sm text-navy-950">{{ $alumniStory->published_at?->format('M j, Y g:i A') ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Slug</p>
                        <p class="mt-1 text-sm text-navy-950">{{ $alumniStory->slug }}</p>
                    </div>
                </div>
            </section>
        </div>

        <aside class="space-y-8">
            <section class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm">
                <h2 class="font-serif text-lg font-semibold text-navy-950">Cover Image</h2>
                <div class="mt-4">
                    @if ($alumniStory->cover_image)
                        <img src="{{ $alumniStory->cover_image_url }}" alt="{{ $alumniStory->title }}" class="w-full rounded-lg object-cover ring-4 ring-gold-500/30">
                    @else
                        <div class="flex h-40 items-center justify-center rounded-lg border-2 border-dashed border-navy-200 bg-cream">
                            <span class="text-sm text-ink-soft">No image</span>
                        </div>
                    @endif
                </div>
            </section>

            <section class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm">
                <h2 class="font-serif text-lg font-semibold text-navy-950">Status</h2>
                <div class="mt-4 space-y-3">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Status</p>
                        @if ($alumniStory->status === 'published')
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
                        <p class="mt-1 text-sm text-navy-950">{{ $alumniStory->is_featured ? 'Yes' : 'No' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Sort Order</p>
                        <p class="mt-1 text-sm text-navy-950">{{ $alumniStory->sort_order }}</p>
                    </div>
                </div>
            </section>

            <section class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm">
                <h2 class="font-serif text-lg font-semibold text-navy-950">Timestamps</h2>
                <div class="mt-4 space-y-3">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Created</p>
                        <p class="mt-1 text-sm text-navy-950">{{ $alumniStory->created_at->format('M j, Y g:i A') }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Updated</p>
                        <p class="mt-1 text-sm text-navy-950">{{ $alumniStory->updated_at->format('M j, Y g:i A') }}</p>
                    </div>
                </div>
            </section>
        </aside>
    </div>
</x-layouts.admin>
