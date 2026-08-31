@props([
    'type' => null,
    'tier' => null,
])

@php
    $label = $tier?->badge_label
        ? trim($tier->badge_label.' Member')
        : ($type?->name ?? null);
@endphp

@if ($label)
    <span {{ $attributes->merge(['class' => 'inline-flex items-center gap-1.5 rounded-full border border-gold-500/50 bg-gold-500/15 px-3 py-1 text-[11px] font-semibold uppercase tracking-widest text-gold-700']) }}>
        <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
            <path d="M10 2l1.9 4.05 4.45.55-3.28 3.1.85 4.4L10 11.95 6.08 14.1l.85-4.4L3.65 6.6l4.45-.55L10 2z" />
        </svg>
        {{ $label }}
    </span>
@endif
