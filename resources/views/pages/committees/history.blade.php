<x-layouts.app title="{{ $type->name }} — Committee History" description="Browse all past and present {{ strtolower($type->name) }} of the EDAA.">

    <x-page-header
        title="{{ $type->name }}"
        description="Committee history — past and present."
        eyebrow="History"
        :breadcrumbs="[
            ['label' => 'Home', 'href' => route('home')],
            ['label' => 'Committees', 'href' => route('committees.index')],
            ['label' => 'History'],
        ]"
    />

    <section class="section-pad bg-cream">
        <div class="container-page mx-auto max-w-4xl">

            @if ($committees->isEmpty())
                <div class="rounded-2xl border border-dashed border-navy-200 bg-white/60 p-12 text-center">
                    <p class="text-ink-soft">No committees of this type exist yet.</p>
                </div>
            @else
                <div class="space-y-8">
                    @foreach ($committees as $committee)
                        <a href="{{ route('committees.show', ['type' => $type, 'committee' => $committee]) }}" class="group block rounded-2xl border border-navy-100 bg-white p-6 shadow-sm transition-all hover:shadow-md hover:-translate-y-0.5 relative overflow-hidden">
                            @if ($committee->is_current)
                                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-gold-500 via-gold-400 to-maroon-500"></div>
                            @endif

                            <div class="flex flex-wrap items-center justify-between gap-4">
                                <div>
                                    <div class="flex items-center gap-3">
                                        <h3 class="font-serif text-lg font-semibold text-navy-950 group-hover:text-maroon-700 transition-colors">{{ $committee->name }}</h3>
                                        @if ($committee->is_current)
                                            <span class="inline-flex items-center gap-1 rounded-full bg-gold-500/15 px-2 py-0.5 text-[10px] font-semibold uppercase tracking-widest text-gold-700">Current</span>
                                        @endif
                                    </div>
                                    <p class="mt-1 text-sm text-ink-soft">{{ $committee->yearRange() }} &middot; {{ $committee->members()->count() }} {{ Str::plural('member', $committee->members()->count()) }}</p>
                                    @if ($committee->description)
                                        <p class="mt-2 text-sm text-ink-soft line-clamp-2">{{ $committee->description }}</p>
                                    @endif
                                </div>
                                <svg class="h-5 w-5 text-navy-300 group-hover:text-maroon-500 transition-colors shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif

        </div>
    </section>
</x-layouts.app>
