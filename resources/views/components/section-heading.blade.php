@props([
    'eyebrow' => null,
    'title' => null,
    'description' => null,
    'align' => 'left',
    'dark' => false,
])

@php
    $alignment = $align === 'center' ? 'items-center text-center mx-auto' : 'items-start text-left';
    $width = $align === 'center' ? 'max-w-2xl' : 'max-w-3xl';
    $titleColor = $dark ? 'text-white' : 'text-navy-950';
    $descColor = $dark ? 'text-navy-100' : 'text-ink-soft';
    $eyebrowColor = $dark ? 'text-gold-300' : 'text-maroon-600';
@endphp

<div class="{{ $alignment }} flex flex-col {{ $width }}">
    @if ($eyebrow)
        <p class="mb-3 inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-[0.2em] {{ $eyebrowColor }}">
            <span class="inline-block h-px w-8 bg-gold-500" aria-hidden="true"></span>
            {{ $eyebrow }}
        </p>
    @endif

    @if ($title)
        <h2 class="font-serif text-3xl font-semibold leading-tight tracking-tight {{ $titleColor }} sm:text-4xl">
            {{ $title }}
        </h2>
    @endif

    @if ($description)
        <p class="mt-4 text-base leading-relaxed {{ $descColor }} sm:text-lg">
            {{ $description }}
        </p>
    @endif
</div>