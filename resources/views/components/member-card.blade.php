@props([
    'alumni' => null,
    'membership' => null,
    'name' => null,
    'profession' => null,
    'organization' => null,
    'location' => null,
    'batch' => null,
    'graduation_year' => null,
    'image' => null,
    'href' => null,
    'membership_type' => null,
    'membership_tier' => null,
])

@php
    $name = $name ?? $alumni?->full_name;
    $profession = $profession ?? $alumni?->profession;
    $organization = $organization ?? $alumni?->organization;
    $location = $location ?? $alumni?->location;
    $batch = $batch ?? $alumni?->batch;
    $graduation_year = $graduation_year ?? $alumni?->graduation_year;
    $image = $image ?? $alumni?->profile_photo_url;
    $href = $href ?? route('member.show', $alumni?->slug ?? '');
    $membership_type = $membership_type ?? $membership?->type;
    $membership_tier = $membership_tier ?? $membership?->tier;
@endphp

<article class="card-lift shine group relative flex h-full flex-col overflow-hidden rounded-2xl border border-navy-100 bg-white/95 shadow-sm backdrop-blur-md transition-all duration-300 hover:border-gold-400/60 hover:shadow-xl">
    <a href="{{ $href }}" class="focus-ring absolute inset-0 z-10 rounded-2xl" aria-label="View {{ $name }}'s profile" tabindex="0"></a>

    {{-- Top verified accent bar --}}
    <div class="h-1.5 w-full bg-gradient-to-r from-navy-800 via-gold-500 to-maroon-700"></div>

    <div class="flex items-center gap-4 p-6 pb-0">
        @if ($image)
            <img src="{{ $image }}" alt="{{ $name }}" class="h-16 w-16 shrink-0 rounded-full object-cover ring-2 ring-gold-500/40 transition-transform duration-300 group-hover:scale-105">
        @else
            <span class="flex h-16 w-16 shrink-0 items-center justify-center rounded-full bg-gradient-to-br from-maroon-700 to-maroon-900 font-serif text-lg font-bold text-white shadow ring-2 ring-gold-500/40" aria-hidden="true">
                {{ \Illuminate\Support\Str::initials($name ?? '') }}
            </span>
        @endif

        <div class="min-w-0 flex-1">
            <div class="flex items-center gap-1.5">
                <h3 class="truncate font-serif text-lg font-bold text-navy-950 transition-colors group-hover:text-maroon-700">{{ $name }}</h3>
                <svg class="h-4 w-4 shrink-0 text-gold-500" viewBox="0 0 20 20" fill="currentColor" title="Verified Member">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd"/>
                </svg>
            </div>
            @if ($profession)
                <p class="truncate text-xs font-medium text-ink-soft">{{ $profession }}</p>
            @endif
        </div>
    </div>

    <div class="flex-1 px-6 pt-4">
        @if ($membership_tier || $membership_type)
            <div class="mb-3">
                <x-membership-badge :type="$membership_type" :tier="$membership_tier" />
            </div>
        @endif

        <dl class="space-y-2 text-xs text-ink-soft">
            @if ($organization)
                <div class="flex items-center gap-2">
                    <svg class="h-4 w-4 shrink-0 text-navy-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    <span class="truncate font-medium text-navy-900" title="{{ $organization }}">{{ $organization }}</span>
                </div>
            @endif

            @if ($location)
                <div class="flex items-center gap-2">
                    <svg class="h-4 w-4 shrink-0 text-navy-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span class="truncate">{{ $location }}</span>
                </div>
            @endif

            @if ($batch || $graduation_year)
                <div class="flex items-center gap-2">
                    <svg class="h-4 w-4 shrink-0 text-navy-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                    </svg>
                    <span class="font-semibold text-navy-800">
                        @if ($batch)Batch {{ $batch }}@endif
                        @if ($batch && $graduation_year) · @endif
                        @if ($graduation_year)Class of {{ $graduation_year }}@endif
                    </span>
                </div>
            @endif
        </dl>
    </div>

    <div class="mt-4 flex items-center justify-between border-t border-navy-50 px-6 py-3 bg-navy-50/40">
        <span class="text-xs font-bold uppercase tracking-wider text-maroon-600 transition-colors group-hover:text-maroon-800">
            View Profile &rarr;
        </span>
        <span class="text-[10px] font-semibold uppercase tracking-wider text-navy-400">
            EDAA Member
        </span>
    </div>
</article>
