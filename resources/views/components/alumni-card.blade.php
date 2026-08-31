@props([
    'name' => null,
    'graduation_year' => null,
    'role' => null,
    'field' => null,
    'image' => null,
    'href' => null,
    'batch' => null,
    'country' => null,
    'bio' => null,
    'membership_type' => null,
    'membership_tier' => null,
])

<article class="card-lift shine glow-top group flex h-full flex-col items-center rounded-xl border border-white/20 bg-white/80 p-8 text-center shadow-sm backdrop-blur-sm">
    @if ($image)
        <img src="{{ $image }}" alt="{{ $name }}" class="h-24 w-24 rounded-full object-cover ring-4 ring-gold-500/30">
    @else
        <span class="flex h-24 w-24 items-center justify-center rounded-full bg-navy-900 font-serif text-2xl font-semibold text-gold-300 ring-4 ring-gold-500/30" aria-hidden="true">
            {{ \Illuminate\Support\Str::initials($name ?? '') }}
        </span>
    @endif

    <h3 class="mt-5 font-serif text-lg font-semibold text-navy-950">
        @if ($href)
            <a href="{{ $href }}" class="focus-ring rounded transition-colors group-hover:text-maroon-700">{{ $name }}</a>
        @else
            {{ $name }}
        @endif
    </h3>

    @if ($membership_tier || $membership_type)
        <div class="mt-2.5">
            <x-membership-badge :type="$membership_type" :tier="$membership_tier" />
        </div>
    @endif

    @if ($graduation_year)
        <p class="mt-1 text-xs font-semibold uppercase tracking-widest text-maroon-600">
            Class of {{ $graduation_year }}
        </p>
    @endif

    @if ($batch || $country)
        <p class="mt-2 text-xs font-medium uppercase tracking-widest text-navy-400">
            {{ collect([$batch ? 'Batch '.$batch : null, $country])->filter()->implode(' · ') }}
        </p>
    @endif

    @if ($role || $field)
        <p class="mt-2 text-sm text-ink-soft">
            {{ collect([$role, $field])->filter()->implode(' · ') }}
        </p>
    @endif

    @if ($bio)
        <p class="mt-3 text-sm leading-relaxed text-ink-soft line-clamp-2">{{ $bio }}</p>
    @endif
</article>