<x-layouts.admin :title="$pressRelease->title">
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="font-serif text-3xl font-semibold tracking-tight text-navy-950">{{ $pressRelease->title }}</h1>
            <p class="mt-1 text-sm text-ink-soft">Press release details and preview.</p>
        </div>
        <div class="flex items-center gap-3">
            @if ($pressRelease->isPublished())
                <a href="{{ route('press-releases.show', $pressRelease) }}" target="_blank" class="focus-ring inline-flex items-center gap-2 rounded-md px-3.5 py-2 text-sm font-semibold text-navy-800 transition-colors hover:bg-navy-50">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" /></svg>
                    View Public
                </a>
            @endif
            <a href="{{ route('admin.press-releases.edit', $pressRelease) }}" class="focus-ring inline-flex items-center gap-2 rounded-md px-3.5 py-2 text-sm font-semibold text-navy-800 transition-colors hover:bg-navy-50">Edit</a>
        </div>
    </div>

    @if (session('status'))
        <div class="mb-6 flex items-center gap-3 rounded-md border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800" role="status">
            <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            {{ session('status') }}
        </div>
    @endif

    <div class="grid gap-8 lg:grid-cols-3">
        <div class="lg:col-span-2 space-y-6">
            @if ($pressRelease->excerpt)
                <div class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm">
                    <h2 class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Excerpt</h2>
                    <p class="mt-2 text-sm leading-relaxed text-navy-950">{{ $pressRelease->excerpt }}</p>
                </div>
            @endif

            @if ($pressRelease->content)
                <div class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm">
                    <h2 class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Content</h2>
                    <div class="mt-2 whitespace-pre-line text-sm leading-relaxed text-navy-950">{{ $pressRelease->content }}</div>
                </div>
            @endif

            @if (! $pressRelease->excerpt && ! $pressRelease->content)
                <div class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm">
                    <p class="text-sm text-ink-soft">No text content.</p>
                </div>
            @endif

            @if ($pressRelease->external_url)
                <div class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm">
                    <h2 class="text-xs font-semibold uppercase tracking-wider text-ink-soft">External URL</h2>
                    <a href="{{ $pressRelease->external_url }}" target="_blank" rel="noopener noreferrer" class="mt-2 inline-flex items-center gap-1 text-sm text-maroon-700 hover:text-maroon-800">
                        {{ $pressRelease->external_url }}
                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" /></svg>
                    </a>
                </div>
            @endif
        </div>

        <div class="space-y-6">
            <div class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm">
                <h2 class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Details</h2>
                <dl class="mt-4 space-y-3 text-sm">
                    <div class="flex justify-between">
                        <dt class="text-ink-soft">Status</dt>
                        <dd>
                            @if ($pressRelease->status === 'published')
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-navy-100 px-2.5 py-1 text-xs font-semibold text-navy-800">
                                    <span class="h-1.5 w-1.5 rounded-full bg-navy-600"></span>
                                    Published
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-maroon-100 px-2.5 py-1 text-xs font-semibold text-maroon-800">
                                    <span class="h-1.5 w-1.5 rounded-full bg-maroon-600"></span>
                                    Draft
                                </span>
                            @endif
                        </dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-ink-soft">Featured</dt>
                        <dd class="font-medium text-navy-950">{{ $pressRelease->is_featured ? 'Yes' : 'No' }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-ink-soft">Published</dt>
                        <dd class="font-medium text-navy-950">{{ $pressRelease->published_at?->format('M j, Y g:i A') ?? '—' }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-ink-soft">Sort Order</dt>
                        <dd class="font-medium text-navy-950">{{ $pressRelease->sort_order }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-ink-soft">Slug</dt>
                        <dd class="font-mono text-xs text-navy-950">{{ $pressRelease->slug }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-ink-soft">Created</dt>
                        <dd class="text-navy-950">{{ $pressRelease->created_at?->format('M j, Y g:i A') }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-ink-soft">Updated</dt>
                        <dd class="text-navy-950">{{ $pressRelease->updated_at?->format('M j, Y g:i A') }}</dd>
                    </div>
                </dl>
            </div>

            @if ($pressRelease->cover_image)
                <div class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm">
                    <h2 class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Cover Image</h2>
                    <img src="{{ $pressRelease->cover_image_url }}" alt="{{ $pressRelease->title }}" class="mt-3 w-full rounded-lg object-cover">
                </div>
            @endif

            @if ($pressRelease->document_path)
                <div class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm">
                    <h2 class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Document</h2>
                    <div class="mt-3 flex items-center gap-3 rounded-md border border-navy-200 bg-cream px-4 py-3">
                        <svg class="h-8 w-8 shrink-0 text-maroon-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                        </svg>
                        <div>
                            <p class="text-sm font-medium text-navy-950">{{ $pressRelease->document_original_name }}</p>
                            <p class="text-xs text-ink-soft">PDF · {{ \Illuminate\Support\Number::format($pressRelease->document_size ?? 0) }}B</p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="flex gap-3">
                <form method="POST" action="{{ route('admin.press-releases.destroy', $pressRelease) }}" onsubmit="return confirm('Delete this press release? This cannot be undone.');">
                    @csrf
                    @method('DELETE')
                    <x-button type="submit" variant="outline">Delete</x-button>
                </form>
            </div>
        </div>
    </div>
</x-layouts.admin>
