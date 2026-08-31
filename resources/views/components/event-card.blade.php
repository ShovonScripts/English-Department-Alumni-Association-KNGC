@props([
    'title' => null,
    'date' => null,
    'time' => null,
    'location' => null,
    'category' => null,
    'href' => null,
])

<article class="card-lift shine glow-top group flex h-full flex-col overflow-hidden rounded-xl border border-white/20 bg-white/80 shadow-sm backdrop-blur-sm">
    <div class="flex-1 p-6">
        <div class="flex items-center gap-3">
            @if ($date)
                <div class="flex h-14 w-14 shrink-0 flex-col items-center justify-center rounded-md bg-navy-900 text-white">
                    <span class="text-lg font-bold leading-none">{{ \Illuminate\Support\Str::upper(\Illuminate\Support\Carbon::parse($date)->format('d')) }}</span>
                    <span class="text-[10px] font-medium uppercase tracking-widest text-gold-300">{{ \Illuminate\Support\Carbon::parse($date)->format('M') }}</span>
                </div>
            @endif
            @if ($category)
                <span class="rounded-full bg-maroon-50 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-maroon-700">
                    {{ $category }}
                </span>
            @endif
        </div>

        @if ($title)
            <h3 class="mt-4 font-serif text-xl font-semibold leading-snug text-navy-950">
                @if ($href)
                    <a href="{{ $href }}" class="focus-ring rounded transition-colors group-hover:text-maroon-700">{{ $title }}</a>
                @else
                    {{ $title }}
                @endif
            </h3>
        @endif

        @if ($time || $location)
            <ul class="mt-4 space-y-2 text-sm text-ink-soft">
                @if ($time)
                    <li class="flex items-center gap-2">
                        <svg class="h-4 w-4 text-maroon-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ $time }}
                    </li>
                @endif
                @if ($location)
                    <li class="flex items-center gap-2">
                        <svg class="h-4 w-4 text-maroon-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.7 11.9l-6.8 6.9a2 2 0 01-2.8 0l-3-3a2 2 0 010-2.8l6.9-6.8M14.8 3.2L20.8 9.2m-2-2l-4.5 4.5a4 4 0 00-1 2.1l-.2 1.5a.5.5 0 00.6.6l1.5-.2a4 4 0 002.1-1l4.5-4.5a2 2 0 000-2.8l-2.5-2.5a2 2 0 00-2.8 0z" />
                        </svg>
                        {{ $location }}
                    </li>
                @endif
            </ul>
        @endif
    </div>

    @if ($href)
        <div class="border-t border-navy-50 px-6 py-4">
            <a href="{{ $href }}" class="focus-ring inline-flex items-center gap-1.5 text-sm font-semibold text-maroon-700 transition-colors group-hover:text-maroon-600">
                View details
                <svg class="h-4 w-4 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </a>
        </div>
    @endif
</article>