@props([
    'title' => 'Nothing here yet',
    'description' => null,
    'action_label' => null,
    'action_href' => null,
    'compact' => false,
])

<div class="flex flex-col items-center justify-center rounded-lg border border-dashed border-navy-200 bg-cream px-6 py-16 text-center {{ $compact ? 'py-10' : '' }}">
    <span class="flex h-14 w-14 items-center justify-center rounded-full bg-navy-100 text-navy-500">
        <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 7a2 2 0 012-2h4l2 2h8a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V7z" />
        </svg>
    </span>

    <h2 class="mt-4 font-serif text-xl font-semibold text-navy-950">{{ $title }}</h2>

    @if ($description)
        <p class="mt-2 max-w-md text-sm leading-relaxed text-ink-soft">{{ $description }}</p>
    @endif

    @if ($action_label && $action_href)
        <div class="mt-6">
            <x-button href="{{ $action_href }}" variant="navy">{{ $action_label }}</x-button>
        </div>
    @endif
</div>