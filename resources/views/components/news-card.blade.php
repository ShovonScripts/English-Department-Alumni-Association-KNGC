@props([
    'title' => null,
    'excerpt' => null,
    'date' => null,
    'category' => null,
    'author' => null,
    'href' => null,
    'image' => null,
])

<article class="card-lift shine glow-top group flex h-full flex-col overflow-hidden rounded-xl border border-white/20 bg-white/80 shadow-sm backdrop-blur-sm">
    @if ($image)
        <div class="relative aspect-[16/9] overflow-hidden bg-navy-100">
            <img src="{{ $image }}" alt="" class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
            @if ($category)
                <span class="absolute left-4 top-4 rounded-full bg-navy-900/90 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-gold-300">
                    {{ $category }}
                </span>
            @endif
        </div>
    @else
        <div class="relative flex aspect-[16/9] items-center justify-center bg-gradient-to-br from-navy-800 via-navy-900 to-maroon-900">
            <svg class="h-10 w-10 text-gold-400/70" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.4" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 6a2 2 0 012-2h8l2 2h6a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V6z" />
            </svg>
            @if ($category)
                <span class="absolute left-4 top-4 rounded-full bg-navy-900/90 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-gold-300">
                    {{ $category }}
                </span>
            @endif
        </div>
    @endif

    <div class="flex flex-1 flex-col p-6">
        @if ($date)
            <p class="text-xs font-medium uppercase tracking-wider text-ink-soft">
                {{ \Illuminate\Support\Carbon::parse($date)->format('F j, Y') }}
            </p>
        @endif

        @if ($title)
            <h3 class="mt-2 font-serif text-xl font-semibold leading-snug text-navy-950">
                @if ($href)
                    <a href="{{ $href }}" class="focus-ring rounded transition-colors group-hover:text-maroon-700">{{ $title }}</a>
                @else
                    {{ $title }}
                @endif
            </h3>
        @endif

        @if ($excerpt)
            <p class="mt-3 line-clamp-3 flex-1 text-sm leading-relaxed text-ink-soft">
                {{ $excerpt }}
            </p>
        @endif

        @if ($author || $href)
            <div class="mt-4 flex items-center justify-between">
                @if ($author)
                    <p class="text-sm font-medium text-navy-900">By {{ $author }}</p>
                @endif
                @if ($href)
                    <a href="{{ $href }}" class="focus-ring inline-flex items-center gap-1.5 text-sm font-semibold text-maroon-700 transition-colors group-hover:text-maroon-600">
                        Read more
                        <svg class="h-4 w-4 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </a>
                @endif
            </div>
        @endif
    </div>
</article>