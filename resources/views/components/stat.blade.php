@props([
    'value' => null,
    'label' => null,
    'accent' => false,
])

<div class="{{ $accent ? 'bg-maroon-700/90 backdrop-blur-sm' : 'bg-white/80 backdrop-blur-sm' }} shine rounded-xl border border-white/20 p-6 text-center shadow-sm sm:p-8">
    <p class="font-serif text-4xl font-semibold tracking-tight {{ $accent ? 'text-gold-300' : 'text-navy-900' }} sm:text-5xl">
        {{ $value }}
    </p>
    <p class="mt-2 text-sm font-medium uppercase tracking-wider {{ $accent ? 'text-maroon-100' : 'text-ink-soft' }}">
        {{ $label }}
    </p>
</div>