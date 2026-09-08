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

<article 
    x-data="{}" 
    x-init="if (window.VanillaTilt) VanillaTilt.init($el, { max: 8, speed: 300, glare: true, 'max-glare': 0.12, scale: 1.02 })"
    class="card-lift shine group relative flex h-full flex-col items-center rounded-2xl border border-navy-100 bg-white/95 p-6 sm:p-7 text-center shadow-sm backdrop-blur-md transition-all duration-300 hover:border-gold-400/60 hover:shadow-xl tilt-card">
    
    @if ($href)
        <a href="{{ $href }}" class="focus-ring absolute inset-0 z-10 rounded-2xl" aria-label="View {{ $name }}'s profile"></a>
    @endif

    {{-- Batch Pill Badge --}}
    @if ($batch)
        <div class="absolute top-4 right-4 z-20">
            <span class="inline-flex items-center rounded-full border border-gold-400/40 bg-gold-50 px-2.5 py-0.5 text-[11px] font-bold text-gold-700 shadow-xs">
                Batch {{ $batch }}
            </span>
        </div>
    @endif

    <div class="tilt-inner flex flex-col items-center w-full h-full">
        {{-- Profile Avatar --}}
        <div class="relative mt-2">
            @if ($image)
                <img src="{{ $image }}" alt="{{ $name }}" class="h-24 w-24 rounded-full object-cover ring-4 ring-gold-500/30 transition-transform duration-300 group-hover:scale-105">
            @else
                <span class="flex h-24 w-24 items-center justify-center rounded-full bg-gradient-to-br from-navy-900 to-navy-800 font-serif text-2xl font-bold text-gold-300 ring-4 ring-gold-500/30 shadow-md">
                    {{ \Illuminate\Support\Str::initials($name ?? '') }}
                </span>
            @endif
        </div>

        {{-- Name --}}
        <h3 class="mt-4 font-serif text-lg font-bold text-navy-950 transition-colors group-hover:text-maroon-700">
            {{ $name }}
        </h3>

        {{-- Membership Tier Badge --}}
        @if ($membership_tier || $membership_type)
            <div class="mt-2">
                <x-membership-badge :type="$membership_type" :tier="$membership_tier" />
            </div>
        @endif

        {{-- Graduation Year --}}
        @if ($graduation_year)
            <p class="mt-1.5 text-xs font-semibold uppercase tracking-wider text-maroon-600">
                Class of {{ $graduation_year }}
            </p>
        @endif

        {{-- Location / Country --}}
        @if ($country)
            <p class="mt-1 text-xs font-medium text-navy-400">
                {{ $country }}
            </p>
        @endif

        {{-- Role & Field --}}
        @if ($role || $field)
            <p class="mt-2 text-sm text-ink-soft line-clamp-1">
                {{ collect([$role, $field])->filter()->implode(' · ') }}
            </p>
        @endif

        {{-- Bio Snippet --}}
        @if ($bio)
            <p class="mt-3 text-xs leading-relaxed text-ink-soft line-clamp-2">{{ $bio }}</p>
        @endif

        <div class="mt-auto pt-4">
            <span class="inline-flex items-center gap-1 text-xs font-bold uppercase tracking-wider text-maroon-600 transition-colors group-hover:text-maroon-800">
                View Profile &rarr;
            </span>
        </div>
    </div>
</article>