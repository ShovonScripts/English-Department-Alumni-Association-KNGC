<x-layouts.admin title="Committee">
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="font-serif text-3xl font-semibold tracking-tight text-navy-950">Committee</h1>
            <p class="mt-1 text-sm text-ink-soft">
                Manage the association's executive committee members.
            </p>
        </div>
        <x-button href="{{ route('admin.committee.create') }}" variant="gold">Add Committee Member</x-button>
    </div>

    @if (session('status'))
        <div class="mb-6 flex items-center gap-3 rounded-md border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800" role="status">
            <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            {{ session('status') }}
        </div>
    @endif

    <form method="GET" action="{{ route('admin.committee.index') }}" class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm">
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <div class="lg:col-span-2">
                <label for="search" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Search</label>
                <input
                    type="search"
                    id="search"
                    name="search"
                    value="{{ $filters['search'] }}"
                    placeholder="Name or position…"
                    class="w-full rounded-md border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 placeholder-navy-400 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none"
                >
            </div>

            <div>
                <label for="position" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Position</label>
                <select id="position" name="position" class="w-full rounded-md border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none">
                    <option value="">All</option>
                    @foreach ($positions as $pos)
                        <option value="{{ $pos }}" @selected($filters['position'] == $pos)>{{ $pos }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="active" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Status</label>
                <select id="active" name="active" class="w-full rounded-md border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none">
                    <option value="">All</option>
                    <option value="1" @selected($filters['active'] === '1')>Active</option>
                    <option value="0" @selected($filters['active'] === '0')>Inactive</option>
                </select>
            </div>

            <div class="flex items-end gap-3 sm:col-span-2 lg:col-span-4">
                <x-button type="submit" variant="navy">Apply Filters</x-button>
                <a href="{{ route('admin.committee.index') }}" class="focus-ring inline-flex items-center gap-2 rounded-md px-3.5 py-2 text-sm font-semibold text-navy-800 transition-colors hover:bg-navy-50">
                    Reset
                </a>
            </div>
        </div>
    </form>

    @if ($members->isNotEmpty())
        <div class="mt-8 overflow-hidden rounded-lg border border-navy-100 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="border-b border-navy-100 bg-navy-50/60 text-xs uppercase tracking-wider text-ink-soft">
                            <th class="px-6 py-3.5 font-semibold">Photo</th>
                            <th class="px-6 py-3.5 font-semibold">Name</th>
                            <th class="px-6 py-3.5 font-semibold">Position</th>
                            <th class="px-6 py-3.5 font-semibold">Status</th>
                            <th class="px-6 py-3.5 font-semibold">Order</th>
                            <th class="px-6 py-3.5 text-right font-semibold">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-navy-100">
                        @foreach ($members as $member)
                            <tr class="transition-colors hover:bg-cream/70">
                                <td class="px-6 py-4">
                                    @if ($member->profile_photo_url)
                                        <img src="{{ $member->profile_photo_url }}" alt="" class="h-10 w-10 shrink-0 rounded-full object-cover">
                                    @else
                                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-navy-900 font-serif text-xs font-semibold text-gold-300" aria-hidden="true">
                                            {{ \Illuminate\Support\Str::initials($member->name) }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <a href="{{ route('admin.committee.show', $member) }}" class="focus-ring rounded font-semibold text-navy-950 transition-colors hover:text-maroon-700">
                                        {{ $member->name }}
                                    </a>
                                    @if ($member->short_bio)
                                        <p class="mt-0.5 max-w-xs truncate text-xs text-ink-soft">{{ $member->short_bio }}</p>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-navy-950">{{ $member->position }}</td>
                                <td class="px-6 py-4">
                                    @if ($member->is_active)
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-navy-100 px-2.5 py-1 text-xs font-semibold text-navy-800">
                                            <span class="h-1.5 w-1.5 rounded-full bg-navy-600" aria-hidden="true"></span>
                                            Active
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-maroon-100 px-2.5 py-1 text-xs font-semibold text-maroon-800">
                                            <span class="h-1.5 w-1.5 rounded-full bg-maroon-600" aria-hidden="true"></span>
                                            Inactive
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-navy-950">{{ $member->sort_order }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-end gap-1">
                                        <a href="{{ route('admin.committee.show', $member) }}" class="focus-ring inline-flex h-8 w-8 items-center justify-center rounded-md text-navy-600 transition-colors hover:bg-navy-50 hover:text-navy-900" aria-label="View {{ $member->name }}">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.5 12S6 5.5 12 5.5 21.5 12 21.5 12 18 18.5 12 18.5 2.5 12 2.5 12z" />
                                            </svg>
                                        </a>
                                        <a href="{{ route('admin.committee.edit', $member) }}" class="focus-ring inline-flex h-8 w-8 items-center justify-center rounded-md text-navy-600 transition-colors hover:bg-navy-50 hover:text-navy-900" aria-label="Edit {{ $member->name }}">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.4-9.4a2 2 0 112.8 2.8L11 15l-4 1 1-4 9.6-9.4z" />
                                            </svg>
                                        </a>
                                        <form method="POST" action="{{ route('admin.committee.destroy', $member) }}" onsubmit="return confirm('Delete {{ addslashes($member->name) }}? This cannot be undone.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="focus-ring inline-flex h-8 w-8 items-center justify-center rounded-md text-maroon-600 transition-colors hover:bg-maroon-50 hover:text-maroon-800" aria-label="Delete {{ $member->name }}">
                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.8 12a2 2 0 01-2 1.8H7.8a2 2 0 01-2-1.8L5 7m5 4v6m4-6v6m-9-10h14M9 7V5a2 2 0 012-2h2a2 2 0 012 2v2" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="border-t border-navy-100 px-6 py-4">
                {{ $members->links() }}
            </div>
        </div>
    @else
        <div class="mt-8">
            <x-empty-state
                title="No committee members found"
                description="No records match your current filters. Adjust the filters or add a new committee member to get started."
                action_label="Add Committee Member"
                action_href="{{ route('admin.committee.create') }}"
            />
        </div>
    @endif
</x-layouts.admin>
