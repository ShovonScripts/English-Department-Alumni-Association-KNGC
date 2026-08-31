<x-layouts.admin :title="$publication->title">
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="font-serif text-3xl font-semibold tracking-tight text-navy-950">{{ $publication->title }}</h1>
            <p class="mt-1 text-sm text-ink-soft">Publication details and preview.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.publications.edit', $publication) }}" class="focus-ring inline-flex items-center gap-2 rounded-md px-3.5 py-2 text-sm font-semibold text-navy-800 transition-colors hover:bg-navy-50">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.4-9.4a2 2 0 112.8 2.8L11 15l-4 1 1-4 9.6-9.4z" />
                </svg>
                Edit
            </a>
            <a href="{{ route('admin.publications.index') }}" class="focus-ring inline-flex items-center gap-2 rounded-md px-3.5 py-2 text-sm font-semibold text-navy-800 transition-colors hover:bg-navy-50">
                &larr; Back to Publications
            </a>
        </div>
    </div>

    <div class="grid gap-8 lg:grid-cols-3">
        <div class="space-y-8 lg:col-span-2">
            <section class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm sm:p-8">
                <h2 class="font-serif text-xl font-semibold text-navy-950">Description</h2>
                <div class="mt-4 whitespace-pre-line text-sm leading-relaxed text-navy-950">{!! nl2br(e($publication->description ?? '—')) !!}</div>
            </section>

            <section class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm sm:p-8">
                <h2 class="font-serif text-xl font-semibold text-navy-950">Details</h2>
                <div class="mt-4 grid gap-4 sm:grid-cols-2">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Category</p>
                        <p class="mt-1 text-sm text-navy-950">{{ $publication->category?->name ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Subtitle</p>
                        <p class="mt-1 text-sm text-navy-950">{{ $publication->subtitle ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Author</p>
                        <p class="mt-1 text-sm text-navy-950">{{ $publication->author ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Publisher</p>
                        <p class="mt-1 text-sm text-navy-950">{{ $publication->publisher ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Publication Date</p>
                        <p class="mt-1 text-sm text-navy-950">{{ $publication->publication_date?->format('M j, Y') ?? '—' }}</p>
                    </div>
                </div>
            </section>
        </div>

        <aside class="space-y-8">
            <section class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm">
                <h2 class="font-serif text-lg font-semibold text-navy-950">Cover Image</h2>
                <div class="mt-4">
                    @if ($publication->cover_image)
                        <img src="{{ $publication->cover_image_url }}" alt="{{ $publication->title }}" class="w-full rounded-lg object-cover ring-4 ring-gold-500/30">
                    @else
                        <div class="flex h-40 items-center justify-center rounded-lg border-2 border-dashed border-navy-200 bg-cream">
                            <span class="text-sm text-ink-soft">No image</span>
                        </div>
                    @endif
                </div>
            </section>

            <section class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm">
                <h2 class="font-serif text-lg font-semibold text-navy-950">Document</h2>
                <div class="mt-4 space-y-3">
                    @if ($publication->document_path)
                        <div class="flex items-center gap-3 rounded-md border border-navy-200 bg-cream px-4 py-3">
                            <svg class="h-5 w-5 shrink-0 text-maroon-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                            <div class="min-w-0 flex-1">
                                <p class="text-sm font-medium text-navy-950 truncate">{{ $publication->document_original_name }}</p>
                                <p class="text-xs text-ink-soft">{{ strtoupper($publication->document_type ?? 'PDF') }} · {{ \Illuminate\Support\Number::format($publication->document_size ?? 0) }}B</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <a href="{{ route('admin.publications.document.view', $publication) }}" class="focus-ring inline-flex items-center gap-2 rounded-md px-3.5 py-2 text-sm font-semibold text-navy-800 transition-colors hover:bg-navy-50">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.5 12S6 5.5 12 5.5 21.5 12 21.5 12 18 18.5 12 18.5 2.5 12 2.5 12z" />
                                </svg>
                                View Document
                            </a>
                            <a href="{{ route('admin.publications.document.download', $publication) }}" class="focus-ring inline-flex items-center gap-2 rounded-md px-3.5 py-2 text-sm font-semibold text-navy-800 transition-colors hover:bg-navy-50">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Download
                            </a>
                        </div>
                    @else
                        <p class="text-sm text-ink-soft">No document attached.</p>
                    @endif
                </div>
            </section>

            <section class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm">
                <h2 class="font-serif text-lg font-semibold text-navy-950">Status</h2>
                <div class="mt-4 space-y-3">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Status</p>
                        @if ($publication->status === 'published')
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
                        <p class="mt-1 text-sm text-navy-950">{{ $publication->is_featured ? 'Yes' : 'No' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Sort Order</p>
                        <p class="mt-1 text-sm text-navy-950">{{ $publication->sort_order }}</p>
                    </div>
                </div>
            </section>

            <section class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm">
                <h2 class="font-serif text-lg font-semibold text-navy-950">Actions</h2>
                <div class="mt-4 space-y-3">
                    <a href="{{ route('admin.publications.edit', $publication) }}" class="focus-ring inline-flex w-full items-center justify-center gap-2 rounded-md border border-navy-200 bg-white px-4 py-2.5 text-sm font-semibold text-navy-800 transition-colors hover:bg-navy-50">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.4-9.4a2 2 0 112.8 2.8L11 15l-4 1 1-4 9.6-9.4z" />
                        </svg>
                        Edit Publication
                    </a>
                    <form method="POST" action="{{ route('admin.publications.destroy', $publication) }}" onsubmit="return confirm('Delete {{ addslashes($publication->title) }}? This cannot be undone.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="focus-ring inline-flex w-full items-center justify-center gap-2 rounded-md border border-maroon-200 bg-white px-4 py-2.5 text-sm font-semibold text-maroon-700 transition-colors hover:bg-maroon-50">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.8 12a2 2 0 01-2 1.8H7.8a2 2 0 01-2-1.8L5 7m5 4v6m4-6v6m-9-10h14M9 7V5a2 2 0 012-2h2a2 2 0 012 2v2" />
                            </svg>
                            Delete Publication
                        </button>
                    </form>
                </div>
            </section>

            <section class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm">
                <h2 class="font-serif text-lg font-semibold text-navy-950">Timestamps</h2>
                <div class="mt-4 space-y-3">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Created</p>
                        <p class="mt-1 text-sm text-navy-950">{{ $publication->created_at->format('M j, Y g:i A') }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Updated</p>
                        <p class="mt-1 text-sm text-navy-950">{{ $publication->updated_at->format('M j, Y g:i A') }}</p>
                    </div>
                </div>
            </section>
        </aside>
    </div>
</x-layouts.admin>
