@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination" class="flex flex-col items-center gap-4 sm:flex-row sm:justify-between">
        <p class="text-sm text-ink-soft">
            Showing
            <span class="font-semibold text-navy-950">{{ $paginator->firstItem() ?? 0 }}</span>
            to
            <span class="font-semibold text-navy-950">{{ $paginator->lastItem() ?? 0 }}</span>
            of
            <span class="font-semibold text-navy-950">{{ $paginator->total() }}</span>
            results
        </p>

        <div class="flex items-center gap-1.5">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <span aria-disabled="true" aria-label="{{ __('pagination.previous') }}" class="inline-flex h-9 w-9 items-center justify-center rounded-md border border-navy-200 text-navy-300">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="{{ __('pagination.previous') }}" class="focus-ring inline-flex h-9 w-9 items-center justify-center rounded-md border border-navy-300 text-navy-800 transition-colors hover:border-navy-600 hover:bg-navy-50">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <span aria-disabled="true" class="inline-flex h-9 items-center px-3 font-medium text-navy-400">{{ $element }}</span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span aria-current="page" class="inline-flex h-9 w-9 items-center justify-center rounded-md bg-gold-500 font-semibold text-navy-950">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" aria-label="{{ __('Go to page :page', ['page' => $page]) }}" class="focus-ring inline-flex h-9 w-9 items-center justify-center rounded-md border border-navy-300 font-medium text-navy-800 transition-colors hover:border-navy-600 hover:bg-navy-50">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="{{ __('pagination.next') }}" class="focus-ring inline-flex h-9 w-9 items-center justify-center rounded-md border border-navy-300 text-navy-800 transition-colors hover:border-navy-600 hover:bg-navy-50">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            @else
                <span aria-disabled="true" aria-label="{{ __('pagination.next') }}" class="inline-flex h-9 w-9 items-center justify-center rounded-md border border-navy-200 text-navy-300">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </span>
            @endif
        </div>
    </nav>
@endif