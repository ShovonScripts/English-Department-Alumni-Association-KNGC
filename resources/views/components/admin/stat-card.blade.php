@props([
    'label' => null,
    'value' => null,
    'hint' => null,
    'icon' => null,
    'accent' => false,
    'href' => null,
    'badge' => null,
    'trend' => null,
])

@php
    $tag = $href ? 'a' : 'div';
    $baseClass = $accent
        ? 'bg-gradient-to-br from-maroon-700 via-maroon-800 to-navy-950 text-white border border-maroon-600/50 shadow-md shadow-maroon-950/20'
        : 'bg-white text-navy-950 border border-navy-100 shadow-sm hover:border-gold-300/80 hover:shadow-md';
    $interactiveClass = $href
        ? 'group cursor-pointer transition-all duration-300 transform hover:-translate-y-1 block focus:outline-none focus:ring-2 focus:ring-gold-500 focus:ring-offset-2'
        : 'group transition-all duration-300';
@endphp

<{{ $tag }}
    @if ($href) href="{{ $href }}" @endif
    class="relative overflow-hidden rounded-2xl p-6 {{ $baseClass }} {{ $interactiveClass }}"
>
    {{-- Ambient light effect on hover --}}
    <div class="pointer-events-none absolute -right-6 -top-6 h-28 w-28 rounded-full {{ $accent ? 'bg-gold-400/10' : 'bg-navy-500/5 group-hover:bg-gold-400/10' }} blur-2xl transition-all duration-500 group-hover:scale-150"></div>

    <div class="relative flex items-center justify-between">
        <p class="text-xs font-bold uppercase tracking-wider {{ $accent ? 'text-gold-200/90' : 'text-navy-500' }}">
            {{ $label }}
        </p>
        <div class="flex items-center gap-2">
            @if ($badge)
                <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-semibold {{ $accent ? 'bg-white/20 text-white' : 'bg-gold-50 text-gold-700 border border-gold-200' }}">
                    {{ $badge }}
                </span>
            @endif
            @if ($icon)
                <span class="flex h-11 w-11 items-center justify-center rounded-xl {{ $accent ? 'bg-white/10 text-gold-300 ring-1 ring-white/20 shadow-inner' : 'bg-gradient-to-br from-navy-50 to-navy-100/80 text-navy-700 ring-1 ring-navy-200/60 shadow-sm group-hover:from-gold-50 group-hover:to-gold-100 group-hover:text-gold-600 group-hover:ring-gold-300/70 transition-all duration-300' }}">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $icon }}" />
                    </svg>
                </span>
            @endif
        </div>
    </div>

    <div class="relative mt-4 flex items-baseline justify-between">
        <p class="font-serif text-3xl sm:text-4xl font-semibold tracking-tight {{ $accent ? 'text-white' : 'text-navy-950' }}">
            {{ $value }}
        </p>
        @if ($href)
            <span class="opacity-0 translate-x-1 group-hover:opacity-100 group-hover:translate-x-0 transition-all duration-300 {{ $accent ? 'text-gold-300' : 'text-navy-400 group-hover:text-gold-600' }}">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                </svg>
            </span>
        @endif
    </div>

    @if ($hint || $trend)
        <div class="relative mt-2 flex items-center justify-between text-xs {{ $accent ? 'text-maroon-100/80' : 'text-navy-500' }}">
            @if ($hint)
                <span>{{ $hint }}</span>
            @endif
            @if ($trend)
                <span class="font-medium text-emerald-600">{{ $trend }}</span>
            @endif
        </div>
    @endif
</{{ $tag }}>