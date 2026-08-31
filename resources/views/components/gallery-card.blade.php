@props([
    'title' => null,
    'category' => null,
    'image' => null,
    'count' => null,
    'href' => null,
])

<figure class="card-lift shine group relative overflow-hidden rounded-xl border border-white/20 shadow-sm backdrop-blur-sm">
    <div class="aspect-[4/3] bg-gradient-to-br from-navy-800 via-navy-900 to-maroon-900">
        @if ($image)
            <img src="{{ $image }}" alt="{{ $title }}" class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
        @else
            <div class="flex h-full w-full items-center justify-center" aria-hidden="true">
                <svg class="h-12 w-12 text-gold-400/70" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.2">
                    <rect x="3" y="5" width="18" height="14" rx="2" />
                    <circle cx="9" cy="10" r="2" />
                    <path stroke-linecap="round" d="M21 16l-5-5L5 21" />
                </svg>
            </div>
        @endif
    </div>

    <figcaption class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-navy-950/95 via-navy-950/70 to-transparent p-5 pt-14 text-white">
        @if ($category)
            <p class="text-[11px] font-semibold uppercase tracking-widest text-gold-300">{{ $category }}</p>
        @endif
        @if ($title)
            <p class="mt-1 font-serif text-lg font-semibold leading-snug">
                @if ($href)
                    <a href="{{ $href }}" class="focus-ring rounded">{{ $title }}</a>
                @else
                    {{ $title }}
                @endif
            </p>
        @endif
        @if ($count)
            <p class="mt-1 text-sm text-navy-200">{{ $count }} photos</p>
        @endif
    </figcaption>
</figure>