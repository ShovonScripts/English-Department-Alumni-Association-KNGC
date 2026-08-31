@props([
    'title' => null,
    'description' => null,
    'eyebrow' => null,
    'breadcrumbs' => [],
])

<section class="relative overflow-hidden bg-navy-950 text-white">
    {{-- Decorative academic pattern --}}
    <div class="pointer-events-none absolute inset-0 opacity-[0.06]" aria-hidden="true">
        <div class="absolute -right-24 -top-24 h-96 w-96 rounded-full border-2 border-gold-400"></div>
        <div class="absolute -right-10 top-10 h-64 w-64 rounded-full border border-white/60"></div>
        <div class="absolute bottom-0 left-1/4 h-40 w-40 rounded-full border border-gold-500/70"></div>
    </div>

    <div class="container-page relative py-14 sm:py-20 lg:py-24">
        <x-breadcrumb :items="$breadcrumbs" class="mb-6 sm:mb-8" />

        <div class="max-w-3xl">
            @if ($eyebrow)
                <p class="mb-3 inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-[0.2em] text-gold-300">
                    <span class="inline-block h-px w-8 bg-gold-500" aria-hidden="true"></span>
                    {{ $eyebrow }}
                </p>
            @endif

            @if ($title)
                <h1 class="font-serif text-4xl font-semibold leading-tight tracking-tight sm:text-5xl">
                    {{ $title }}
                </h1>
            @endif

            @if ($description)
                <p class="mt-5 max-w-2xl text-base leading-relaxed text-navy-100 sm:text-lg">
                    {{ $description }}
                </p>
            @endif
        </div>
    </div>
</section>