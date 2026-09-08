<x-layouts.admin title="{{ $type->name }}">
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="font-serif text-3xl font-semibold tracking-tight text-navy-950">{{ $type->name }}</h1>
            <p class="mt-1 text-sm text-ink-soft">Committee type details and associated committees.</p>
        </div>
        <a href="{{ route('admin.committee-types.index') }}" class="focus-ring inline-flex items-center gap-2 rounded-md px-3.5 py-2 text-sm font-semibold text-navy-800 transition-colors hover:bg-navy-50">&larr; Back to Committee Types</a>
    </div>

    @if (session('status'))
        <div class="mb-6 flex items-center gap-3 rounded-md border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800" role="status">
            <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            {{ session('status') }}
        </div>
    @endif

    <div class="grid gap-8 lg:grid-cols-3">
        {{-- Summary Card --}}
        <div>
            <section class="rounded-lg border border-navy-100 bg-white p-8 text-center shadow-sm">
                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-navy-900 font-serif text-xl font-bold text-gold-300 shadow-md">
                    {{ strtoupper(substr($type->slug, 0, 2)) }}
                </div>
                <h2 class="mt-4 font-serif text-xl font-semibold text-navy-950">{{ $type->name }}</h2>
                <p class="mt-1 text-sm text-ink-soft">{{ $type->description ?: 'No description' }}</p>
                <div class="mt-4 flex flex-wrap items-center justify-center gap-1.5">
                    @if ($type->is_active)
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-100 px-2.5 py-1 text-xs font-semibold text-emerald-800"><span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span> Active</span>
                    @else
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-navy-100 px-2.5 py-1 text-xs font-semibold text-navy-600"><span class="h-1.5 w-1.5 rounded-full bg-navy-400"></span> Inactive</span>
                    @endif
                    <span class="inline-flex items-center gap-1.5 rounded-full bg-navy-100 px-2.5 py-1 text-xs font-semibold text-navy-600">{{ $type->committees()->count() }} {{ Str::plural('committee', $type->committees()->count()) }}</span>
                </div>
                <div class="mt-6 flex flex-col gap-2">
                    <a href="{{ route('admin.committee-types.edit', $type) }}" class="focus-ring inline-flex items-center justify-center gap-2 rounded-lg border border-navy-300 px-4 py-2.5 text-sm font-semibold text-navy-900 transition-colors hover:bg-navy-50">Edit Type</a>
                    <form method="POST" action="{{ route('admin.committee-types.destroy', $type) }}" onsubmit="return confirm('Delete this type? This cannot be undone.');">
                        @csrf @method('DELETE')
                        <button type="submit" class="focus-ring w-full inline-flex items-center justify-center gap-2 rounded-lg px-4 py-2.5 text-sm font-semibold text-maroon-600 transition-colors hover:bg-maroon-50">Delete Type</button>
                    </form>
                </div>
            </section>
        </div>

        {{-- Committees --}}
        <div class="lg:col-span-2">
            <section class="rounded-lg border border-navy-100 bg-white p-8 shadow-sm sm:p-10">
                <div class="flex flex-wrap items-start justify-between gap-4">
                    <div>
                        <h2 class="font-serif text-xl font-semibold text-navy-950">Committees</h2>
                        <p class="mt-1 text-sm text-ink-soft">All committees of this type, newest first.</p>
                    </div>
                    <a href="{{ route('admin.committees.create', ['committee_type_id' => $type->id]) }}" class="focus-ring inline-flex items-center justify-center gap-2 rounded-lg bg-gold-500 px-4 py-2 text-sm font-semibold text-navy-950 shadow-sm transition-colors hover:bg-gold-400">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" /></svg>
                        Add Committee
                    </a>
                </div>

                @if ($type->committees->isEmpty())
                    <p class="mt-6 rounded-md bg-navy-50 px-4 py-3 text-sm text-navy-700">No committees of this type yet.</p>
                @else
                    <div class="mt-6 divide-y divide-navy-100">
                        @foreach ($type->committees as $committee)
                            <div class="flex items-center justify-between gap-4 py-4 first:pt-0 last:pb-0">
                                <div>
                                    <a href="{{ route('admin.committees.show', $committee) }}" class="font-semibold text-navy-950 hover:text-maroon-700 transition-colors">{{ $committee->name }}</a>
                                    <p class="text-sm text-ink-soft">{{ $committee->yearRange() }}</p>
                                </div>
                                <div class="flex items-center gap-2">
                                    @if ($committee->is_current)
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-gold-500/15 px-2.5 py-1 text-[10px] font-semibold uppercase tracking-widest text-gold-700">Current</span>
                                    @endif
                                    <span class="text-xs text-ink-soft">{{ $committee->members()->count() }} members</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </section>
        </div>
    </div>
</x-layouts.admin>
