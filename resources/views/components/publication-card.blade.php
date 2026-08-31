@props([
    'title' => null,
    'type' => null,
    'author' => null,
    'year' => null,
    'description' => null,
    'href' => null,
])

<article class="card-lift shine glow-top flex h-full flex-col rounded-xl border border-white/20 bg-white/80 p-6 shadow-sm backdrop-blur-sm">
    <div class="flex items-start justify-between gap-4">
        <span class="inline-flex h-11 w-11 shrink-0 items-center justify-center rounded-md bg-navy-900 text-gold-300">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.3v11.4m0-11.4A3.2 3.2 0 009.5 3.5H6.5v13h3a3.2 3.2 0 013 2.8m-.5-12.9a3.2 3.2 0 012.5-2.8h3v13h-3a3.2 3.2 0 00-3 2.8m0-12.9v11.4" />
            </svg>
        </span>
        @if ($type)
            <span class="rounded-full bg-maroon-50 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-maroon-700">
                {{ $type }}
            </span>
        @endif
    </div>

    @if ($title)
        <h3 class="mt-4 font-serif text-lg font-semibold leading-snug text-navy-950">
            @if ($href)
                <a href="{{ $href }}" class="focus-ring rounded transition-colors hover:text-maroon-700">{{ $title }}</a>
            @else
                {{ $title }}
            @endif
        </h3>
    @endif

    @if ($author || $year)
        <p class="mt-1 text-xs font-medium uppercase tracking-wider text-ink-soft">
            {{ collect([$author, $year])->filter()->implode(' · ') }}
        </p>
    @endif

    @if ($description)
        <p class="mt-3 flex-1 text-sm leading-relaxed text-ink-soft">
            {{ $description }}
        </p>
    @endif
</article>