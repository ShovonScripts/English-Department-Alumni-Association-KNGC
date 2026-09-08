@props([
    'title' => null,
    'date' => null,
    'time' => null,
    'location' => null,
    'category' => null,
    'href' => null,
])

<article class="card-lift shine group relative flex h-full flex-col overflow-hidden rounded-2xl border border-navy-100 bg-white/95 shadow-sm backdrop-blur-md transition-all duration-300 hover:border-gold-400/60 hover:shadow-xl">
    @if ($href)
        <a href="{{ $href }}" class="focus-ring absolute inset-0 z-10 rounded-2xl" aria-label="View event: {{ $title }}"></a>
    @endif

    <div class="flex-1 p-6 sm:p-7">
        <div class="flex items-center justify-between gap-3">
            @if ($date)
                <div class="flex h-14 w-14 shrink-0 flex-col items-center justify-center rounded-xl bg-gradient-to-br from-navy-950 via-navy-900 to-navy-800 text-white shadow-md ring-1 ring-gold-500/30 transition-transform duration-300 group-hover:scale-105">
                    <span class="text-xl font-bold leading-none tracking-tight">{{ \Illuminate\Support\Carbon::parse($date)->format('d') }}</span>
                    <span class="mt-0.5 text-[10px] font-bold uppercase tracking-widest text-gold-300">{{ \Illuminate\Support\Carbon::parse($date)->format('M') }}</span>
                </div>
            @endif

            @if ($category)
                <span class="inline-flex items-center rounded-full border border-maroon-200 bg-maroon-50 px-3 py-1 text-xs font-bold uppercase tracking-wider text-maroon-700 shadow-xs">
                    {{ $category }}
                </span>
            @endif
        </div>

        @if ($title)
            <h3 class="mt-5 font-serif text-xl font-bold leading-snug text-navy-950 transition-colors group-hover:text-maroon-700">
                {{ $title }}
            </h3>
        @endif

        @if ($time || $location)
            <ul class="mt-4 space-y-2 text-xs text-ink-soft">
                @if ($time)
                    <li class="flex items-center gap-2">
                        <svg class="h-4 w-4 shrink-0 text-maroon-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>{{ $time }}</span>
                    </li>
                @endif
                @if ($location)
                    <li class="flex items-center gap-2">
                        <svg class="h-4 w-4 shrink-0 text-maroon-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span class="truncate">{{ $location }}</span>
                    </li>
                @endif
            </ul>
        @endif
    </div>

    @if ($href)
        <div class="mt-auto flex items-center justify-between border-t border-navy-50 bg-navy-50/40 px-6 py-3.5">
            <span class="inline-flex items-center gap-1.5 text-xs font-bold uppercase tracking-wider text-maroon-700 transition-colors group-hover:text-maroon-900">
                View Event Details
                <svg class="h-3.5 w-3.5 transition-transform duration-200 group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </span>
            <span class="text-[10px] font-semibold uppercase tracking-wider text-navy-400">
                EDAA Event
            </span>
        </div>
    @endif
</article>