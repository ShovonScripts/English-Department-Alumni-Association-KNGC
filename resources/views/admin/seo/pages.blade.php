<x-layouts.admin title="Page SEO Metadata">
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="font-serif text-3xl font-semibold tracking-tight text-navy-950">Page SEO Metadata</h1>
                <p class="mt-1 text-sm text-ink-soft">
                    Set custom meta tags, Open Graph images, and indexing rules for each page.
                </p>
            </div>
            <a href="{{ route('admin.seo.index') }}" class="focus-ring inline-flex items-center gap-2 rounded-lg border border-navy-200 bg-white px-4 py-2.5 text-sm font-semibold text-navy-950 transition-colors hover:bg-navy-50">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back
            </a>
        </div>
    </div>

    @if (session('status'))
        <div class="mb-6 flex items-center gap-3 rounded-md border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800" role="status">
            <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            {{ session('status') }}
        </div>
    @endif

    <div class="space-y-3">
        @forelse ($publicPages as $uri => $pageName)
            @php $meta = $metas->get($uri); @endphp
            <div class="flex items-center justify-between rounded-lg border border-navy-100 bg-white p-5 shadow-sm transition-colors hover:border-navy-200">
                <div class="flex items-center gap-4">
                    <div class="flex h-10 w-10 items-center justify-center rounded-lg {{ $meta ? 'bg-emerald-100' : 'bg-navy-100' }}">
                        @if ($meta)
                            <svg class="h-5 w-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        @else
                            <svg class="h-5 w-5 text-navy-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                        @endif
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-navy-950">{{ $pageName }}</h3>
                        <div class="mt-0.5 flex items-center gap-2">
                            <code class="rounded bg-navy-100 px-2 py-0.5 text-xs text-navy-700">{{ $uri }}</code>
                            @if ($meta && $meta->noindex)
                                <span class="rounded-full bg-red-100 px-2 py-0.5 text-[10px] font-bold text-red-700">NOINDEX</span>
                            @endif
                            @if ($meta && $meta->description)
                                <span class="text-xs text-ink-soft">{{ Str::limit($meta->description, 60) }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    @if ($meta)
                        <form method="POST" action="{{ route('admin.seo.pages.reset', urlencode($uri)) }}" onsubmit="return confirm('Reset SEO for this page to defaults?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="focus-ring inline-flex items-center gap-1.5 rounded-lg border border-navy-200 bg-white px-3 py-1.5 text-xs font-semibold text-navy-600 transition-colors hover:bg-navy-50">
                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                                Reset
                            </button>
                        </form>
                    @endif
                    <a href="{{ route('admin.seo.pages.edit', urlencode($uri)) }}" class="focus-ring inline-flex items-center gap-1.5 rounded-lg bg-navy-900 px-4 py-1.5 text-xs font-semibold text-white transition-colors hover:bg-navy-800">
                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        {{ $meta ? 'Edit' : 'Configure' }}
                    </a>
                </div>
            </div>
        @empty
            <div class="rounded-lg border border-navy-100 bg-white p-12 text-center shadow-sm">
                <svg class="mx-auto h-12 w-12 text-navy-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <p class="mt-3 text-sm text-ink-soft">No public pages found.</p>
            </div>
        @endforelse
    </div>
</x-layouts.admin>
