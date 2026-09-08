@props([
    'title' => null,
    'category' => null,
    'image' => null,
    'count' => null,
    'href' => null,
])

<figure class="card-lift shine group relative overflow-hidden rounded-2xl border border-navy-100 bg-white shadow-sm backdrop-blur-md transition-all duration-300 hover:border-gold-400/60 hover:shadow-xl">
    @if ($href)
        <a href="{{ $href }}" class="focus-ring absolute inset-0 z-20 rounded-2xl" aria-label="View album: {{ $title }}"></a>
    @endif

    <div class="relative aspect-[4/3] overflow-hidden bg-gradient-to-br from-navy-950 via-navy-900 to-maroon-950">
        @if ($image)
            <img src="{{ $image }}" alt="{{ $title }}" class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
        @else
            <div class="flex h-full w-full items-center justify-center text-gold-400/50" aria-hidden="true">
                <svg class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.2">
                    <rect x="3" y="5" width="18" height="14" rx="2" />
                    <circle cx="9" cy="10" r="2" />
                    <path stroke-linecap="round" d="M21 16l-5-5L5 21" />
                </svg>
            </div>
        @endif

        @if ($count)
            <div class="absolute top-3 right-3 z-10 flex items-center gap-1 rounded-full border border-white/20 bg-navy-950/80 px-2.5 py-1 text-[11px] font-bold text-white shadow backdrop-blur-sm">
                <svg class="h-3 w-3 text-gold-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <span>{{ $count }}</span>
            </div>
        @endif
    </div>

    <figcaption class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-navy-950 via-navy-950/80 to-transparent p-5 pt-14 text-white pointer-events-none">
        @if ($category)
            <p class="text-[10px] font-bold uppercase tracking-widest text-gold-300">{{ $category }}</p>
        @endif
        @if ($title)
            <h3 class="mt-1 font-serif text-lg font-bold leading-snug text-white transition-colors group-hover:text-gold-200 line-clamp-1">
                {{ $title }}
            </h3>
        @endif
    </figcaption>
</figure>