@props([
    'title' => null,
    'excerpt' => null,
    'date' => null,
    'category' => null,
    'author' => null,
    'href' => null,
    'image' => null,
])

<article class="card-lift shine group relative flex h-full flex-col overflow-hidden rounded-2xl border border-navy-100 bg-white/95 shadow-sm backdrop-blur-md transition-all duration-300 hover:border-gold-400/60 hover:shadow-xl">
    @if ($href)
        <a href="{{ $href }}" class="focus-ring absolute inset-0 z-10 rounded-2xl" aria-label="Read article: {{ $title }}"></a>
    @endif

    @if ($image)
        <div class="relative aspect-[16/9] overflow-hidden bg-navy-950">
            <img src="{{ $image }}" alt="{{ $title }}" class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105">
            @if ($category)
                <span class="absolute left-4 top-4 rounded-full border border-gold-400/30 bg-navy-950/90 px-3 py-1 text-[11px] font-bold uppercase tracking-wider text-gold-300 shadow-md backdrop-blur-sm">
                    {{ $category }}
                </span>
            @endif
        </div>
    @else
        <div class="relative flex aspect-[16/9] items-center justify-center bg-gradient-to-br from-navy-950 via-navy-900 to-maroon-950">
            <svg class="h-12 w-12 text-gold-400/50" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.4" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
            </svg>
            @if ($category)
                <span class="absolute left-4 top-4 rounded-full border border-gold-400/30 bg-navy-950/90 px-3 py-1 text-[11px] font-bold uppercase tracking-wider text-gold-300 shadow-md backdrop-blur-sm">
                    {{ $category }}
                </span>
            @endif
        </div>
    @endif

    <div class="flex flex-1 flex-col p-6 sm:p-7">
        @if ($date)
            <time class="text-xs font-semibold uppercase tracking-wider text-ink-soft" datetime="{{ \Illuminate\Support\Carbon::parse($date)->toIso8601String() }}">
                {{ \Illuminate\Support\Carbon::parse($date)->format('F j, Y') }}
            </time>
        @endif

        @if ($title)
            <h3 class="mt-2.5 font-serif text-xl font-bold leading-snug text-navy-950 transition-colors group-hover:text-maroon-700">
                {{ $title }}
            </h3>
        @endif

        @if ($excerpt)
            <p class="mt-3 line-clamp-3 flex-1 text-sm leading-relaxed text-ink-soft">
                {{ $excerpt }}
            </p>
        @endif

        <div class="mt-5 flex items-center justify-between border-t border-navy-50 pt-4">
            @if ($author)
                <span class="text-xs font-semibold text-navy-800">By {{ $author }}</span>
            @else
                <span class="text-xs font-semibold text-navy-400">EDAA Editorial</span>
            @endif

            @if ($href)
                <span class="inline-flex items-center gap-1 text-xs font-bold uppercase tracking-wider text-maroon-700 transition-colors group-hover:text-maroon-900">
                    Read Article
                    <svg class="h-3.5 w-3.5 transition-transform duration-200 group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </span>
            @endif
        </div>
    </div>
</article>