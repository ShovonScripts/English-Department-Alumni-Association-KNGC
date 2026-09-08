<x-layouts.admin title="Committees">
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="font-serif text-3xl font-semibold tracking-tight text-navy-950">Committees</h1>
            <p class="mt-1 text-sm text-ink-soft">Manage all committees across every type and year.</p>
        </div>
        <x-button href="{{ route('admin.committees.create') }}" variant="gold">Add Committee</x-button>
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

    {{-- Filters --}}
    <form method="GET" action="{{ route('admin.committees.index') }}" class="mb-6 rounded-lg border border-navy-100 bg-white p-6 shadow-sm">
        <div class="grid gap-4 sm:grid-cols-3">
            <div class="sm:col-span-2">
                <label for="search" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Search</label>
                <input type="search" id="search" name="search" value="{{ $filters['search'] }}" placeholder="Committee name..." class="w-full rounded-md border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 placeholder-navy-400 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none">
            </div>
            <div>
                <label for="committee_type_id" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Type</label>
                <select id="committee_type_id" name="committee_type_id" class="w-full rounded-md border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none">
                    <option value="">All</option>
                    @foreach ($types as $type)
                        <option value="{{ $type->id }}" @selected($filters['committee_type_id'] == $type->id)>{{ $type->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="mt-4 flex items-center gap-3">
            <button type="submit" class="focus-ring inline-flex items-center gap-2 rounded-md bg-navy-900 px-4 py-2 text-sm font-semibold text-white transition-colors hover:bg-navy-800">Filter</button>
            <a href="{{ route('admin.committees.index') }}" class="text-sm font-medium text-maroon-700 hover:text-maroon-900">Clear</a>
        </div>
    </form>

    {{-- Table --}}
    <div class="overflow-hidden rounded-lg border border-navy-100 bg-white shadow-sm">
        <table class="min-w-full divide-y divide-navy-100">
            <thead class="bg-navy-50/50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-ink-soft">Committee</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-ink-soft">Type</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-ink-soft">Years</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-ink-soft">Members</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-ink-soft">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-navy-100">
                @forelse ($committees as $committee)
                    <tr class="hover:bg-cream/50 transition-colors">
                        <td class="px-6 py-4">
                            <a href="{{ route('admin.committees.show', $committee) }}" class="font-semibold text-navy-950 hover:text-maroon-700 transition-colors">{{ $committee->name }}</a>
                        </td>
                        <td class="px-6 py-4 text-sm text-ink-soft">{{ $committee->type?->name ?? '---' }}</td>
                        <td class="px-6 py-4 text-sm text-ink-soft">{{ $committee->yearRange() }}</td>
                        <td class="px-6 py-4 text-sm text-ink-soft">{{ $committee->members()->count() }}</td>
                        <td class="px-6 py-4">
                            @if ($committee->is_current)
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-gold-500/15 px-2.5 py-1 text-[10px] font-semibold uppercase tracking-widest text-gold-700">Current</span>
                            @else
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-navy-100 px-2.5 py-1 text-[10px] font-semibold uppercase tracking-widest text-navy-500">Past</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-sm text-ink-soft">No committees found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="border-t border-navy-100 px-6 py-4">
            {{ $committees->links() }}
        </div>
    </div>
</x-layouts.admin>
