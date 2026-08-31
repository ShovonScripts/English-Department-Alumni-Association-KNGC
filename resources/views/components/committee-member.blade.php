@props([
    'name' => null,
    'role' => null,
    'bio' => null,
    'image' => null,
])

<article class="card-lift flex h-full flex-col rounded-lg border border-navy-100 bg-white p-8 shadow-sm">
    <div class="flex items-center gap-5">
        @if ($image)
            <img src="{{ $image }}" alt="{{ $name }}" class="h-16 w-16 rounded-full object-cover ring-2 ring-gold-500/40">
        @else
            <span class="flex h-16 w-16 shrink-0 items-center justify-center rounded-full bg-maroon-700 font-serif text-lg font-semibold text-white" aria-hidden="true">
                {{ \Illuminate\Support\Str::initials($name ?? '') }}
            </span>
        @endif
        <div>
            <h3 class="font-serif text-lg font-semibold text-navy-950">{{ $name }}</h3>
            <p class="text-sm font-medium uppercase tracking-wide text-maroon-600">{{ $role }}</p>
        </div>
    </div>

    @if ($bio)
        <p class="mt-4 flex-1 text-sm leading-relaxed text-ink-soft">
            {{ $bio }}
        </p>
    @endif
</article>