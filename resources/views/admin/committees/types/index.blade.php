<x-layouts.admin title="Committee Types">
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="font-serif text-3xl font-semibold tracking-tight text-navy-950">Committee Types</h1>
            <p class="mt-1 text-sm text-ink-soft">Define the types of committees your association uses.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.committee-roles.index') }}" class="focus-ring inline-flex items-center gap-2 rounded-md border border-navy-300 px-3.5 py-2 text-sm font-semibold text-navy-800 transition-colors hover:bg-navy-50">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" /></svg>
                Manage Roles
            </a>
            <x-button href="{{ route('admin.committee-types.create') }}" variant="gold">Add Committee Type</x-button>
        </div>
    </div>

    @if (session('status'))
        <div class="mb-6 flex items-center gap-3 rounded-md border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800" role="status">
            <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            {{ session('status') }}
        </div>
    @endif

    @if (session('error'))
        <div class="mb-6 flex items-center gap-3 rounded-md border border-maroon-200 bg-maroon-50 px-4 py-3 text-sm text-maroon-800" role="alert">
            <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v4m0 4h.01M10.3 3.9L1.8 18a2 2 0 001.7 3h17a2 2 0 001.7-3L13.7 3.9a2 2 0 00-3.4 0z" /></svg>
            {{ session('error') }}
        </div>
    @endif

    @if ($types->isEmpty())
        <div class="rounded-lg border border-dashed border-navy-200 bg-white p-12 text-center shadow-sm">
            <svg class="mx-auto h-12 w-12 text-navy-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
            <h3 class="mt-3 font-serif text-lg font-semibold text-navy-950">No committee types yet</h3>
            <p class="mt-1 text-sm text-ink-soft">Create your first committee type to get started.</p>
            <x-button href="{{ route('admin.committee-types.create') }}" variant="gold" class="mt-4">Add Committee Type</x-button>
        </div>
    @else
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($types as $type)
                <a href="{{ route('admin.committee-types.show', $type) }}" class="group block rounded-lg border border-navy-100 bg-white p-6 shadow-sm transition-all hover:shadow-md hover:border-gold-500/50 hover:-translate-y-0.5">
                    <div class="flex items-start justify-between">
                        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-navy-900 font-serif text-sm font-bold text-gold-300 shadow-sm">
                            {{ strtoupper(substr($type->slug, 0, 2)) }}
                        </div>
                        @if ($type->is_active)
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-100 px-2 py-0.5 text-[10px] font-semibold uppercase tracking-widest text-emerald-800">Active</span>
                        @else
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-navy-100 px-2 py-0.5 text-[10px] font-semibold uppercase tracking-widest text-navy-500">Inactive</span>
                        @endif
                    </div>
                    <h3 class="mt-4 font-serif text-lg font-semibold text-navy-950 group-hover:text-maroon-700 transition-colors">{{ $type->name }}</h3>
                    <p class="mt-1 text-sm text-ink-soft line-clamp-2">{{ $type->description ?: 'No description' }}</p>
                    <div class="mt-4 flex items-center gap-2 text-xs text-ink-soft">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                        {{ $type->committees()->count() }} {{ Str::plural('committee', $type->committees()->count()) }}
                    </div>
                </a>
            @endforeach
        </div>
    @endif
</x-layouts.admin>
