@props([
    'label' => null,
    'value' => null,
    'hint' => null,
    'icon' => null,
    'accent' => false,
])

<div class="{{ $accent ? 'bg-maroon-700 text-white' : 'bg-white text-navy-950' }} card-lift rounded-lg border p-6 shadow-sm">
    <div class="flex items-center justify-between">
        <p class="text-sm font-medium uppercase tracking-wider {{ $accent ? 'text-maroon-100' : 'text-ink-soft' }}">
            {{ $label }}
        </p>
        @if ($icon)
            <span class="flex h-10 w-10 items-center justify-center rounded-md {{ $accent ? 'bg-white/10 text-gold-300' : 'bg-navy-900 text-gold-300' }}">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="{{ $icon }}" />
                </svg>
            </span>
        @endif
    </div>

    <p class="mt-4 font-serif text-4xl font-semibold tracking-tight">{{ $value }}</p>

    @if ($hint)
        <p class="mt-1 text-sm {{ $accent ? 'text-maroon-100' : 'text-ink-soft' }}">{{ $hint }}</p>
    @endif
</div>