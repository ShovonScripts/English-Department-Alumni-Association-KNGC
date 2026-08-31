@props([
    'name' => null,
    'graduation_year' => null,
    'quote' => null,
    'role' => null,
    'image' => null,
    'href' => null,
])

<figure class="card-lift shine glow-top relative flex h-full flex-col rounded-xl border border-white/20 bg-white/80 p-8 shadow-sm backdrop-blur-sm">
    @if ($href)
        <a href="{{ $href }}" class="focus-ring absolute inset-0" aria-label="Read the story by {{ $name }}"></a>
    @endif

    <svg class="h-8 w-8 text-gold-500" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
        <path d="M9.6 4C5.4 5.4 3 8.6 3 13.2V20h6.8v-6.8H6.4c0-2.8 1.4-4.9 4.2-5.8L9.6 4zm11 0c-4.2 1.4-6.6 4.6-6.6 9.2V20h6.8v-6.8h-3.4c0-2.8 1.4-4.9 4.2-5.8L20.6 4z" />
    </svg>

    @if ($quote)
        <blockquote class="mt-4 flex-1 text-base italic leading-relaxed text-ink">
            "{{ $quote }}"
        </blockquote>
    @endif

    <figcaption class="mt-6 flex items-center gap-4 border-t border-navy-50 pt-6">
        @if ($image)
            <img src="{{ $image }}" alt="{{ $name }}" class="h-12 w-12 rounded-full object-cover ring-2 ring-gold-500/40">
        @else
            <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-navy-900 font-serif text-sm font-semibold text-gold-300" aria-hidden="true">
                {{ \Illuminate\Support\Str::initials($name ?? '') }}
            </span>
        @endif
        <div>
            <p class="font-serif font-semibold text-navy-950">{{ $name }}</p>
            @if ($role || $graduation_year)
                <p class="text-sm text-ink-soft">
                    {{ collect([$role, $graduation_year ? "Class of {$graduation_year}" : null])->filter()->implode(' · ') }}
                </p>
            @endif
        </div>
    </figcaption>
</figure>