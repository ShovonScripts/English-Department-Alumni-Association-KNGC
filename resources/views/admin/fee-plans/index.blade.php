<x-layouts.admin title="Fee Plans">
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="font-serif text-3xl font-semibold tracking-tight text-navy-950">Fee Plans</h1>
            <p class="mt-1 text-sm text-ink-soft">
                Define what members are charged. Collection recording arrives in a later release.
            </p>
        </div>
        <x-button href="{{ route('admin.fee-plans.create') }}" variant="gold">Add Fee Plan</x-button>
    </div>

    @if (session('status'))
        <div class="mb-6 flex items-center gap-3 rounded-md border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800" role="status">
            <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            {{ session('status') }}
        </div>
    @endif

    @if (session('error'))
        <div class="mb-6 flex items-center gap-3 rounded-md border border-maroon-200 bg-maroon-50 px-4 py-3 text-sm text-maroon-800" role="alert">
            <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v4m0 4h.01M10.3 3.9L1.8 18a2 2 0 001.7 3h17a2 2 0 001.7-3L13.7 3.9a2 2 0 00-3.4 0z" />
            </svg>
            {{ session('error') }}
        </div>
    @endif

    <form method="GET" action="{{ route('admin.fee-plans.index') }}" class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm">
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-6">
            <div class="lg:col-span-2">
                <label for="search" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Search</label>
                <input
                    type="search"
                    id="search"
                    name="search"
                    value="{{ $filters['search'] }}"
                    placeholder="Plan name or membership type…"
                    class="w-full rounded-md border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 placeholder-navy-400 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none"
                >
            </div>

            <div>
                <label for="membership_type_id" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Type</label>
                <select id="membership_type_id" name="membership_type_id" class="w-full rounded-md border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none">
                    <option value="">All</option>
                    @foreach ($types as $type)
                        <option value="{{ $type->id }}" @selected($filters['membership_type_id'] == $type->id)>{{ $type->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="frequency" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Frequency</label>
                <select id="frequency" name="frequency" class="w-full rounded-md border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none">
                    <option value="">All</option>
                    @foreach ($frequencies as $frequency)
                        <option value="{{ $frequency->value }}" @selected($filters['frequency'] === $frequency->value)>{{ $frequency->label() }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="status" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Status</label>
                <select id="status" name="status" class="w-full rounded-md border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none">
                    <option value="">All</option>
                    <option value="active" @selected($filters['status'] === 'active')>Active</option>
                    <option value="inactive" @selected($filters['status'] === 'inactive')>Inactive</option>
                </select>
            </div>

            <div>
                <label for="timing" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Timing</label>
                <div class="flex items-center gap-2">
                    <select id="timing" name="timing" class="w-full rounded-md border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none">
                        <option value="">All</option>
                        <option value="current" @selected($filters['timing'] === 'current')>Current</option>
                        <option value="upcoming" @selected($filters['timing'] === 'upcoming')>Upcoming</option>
                        <option value="expired" @selected($filters['timing'] === 'expired')>Expired</option>
                    </select>
                    <x-button type="submit" variant="navy">Filter</x-button>
                </div>
            </div>
        </div>
    </form>

    @if ($feePlans->isNotEmpty())
        <div class="mt-8 overflow-hidden rounded-lg border border-navy-100 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="border-b border-navy-100 bg-navy-50/60 text-xs uppercase tracking-wider text-ink-soft">
                            <th class="px-6 py-3.5 font-semibold">Fee Plan</th>
                            <th class="px-6 py-3.5 font-semibold">Membership Type</th>
                            <th class="px-6 py-3.5 font-semibold">Amount</th>
                            <th class="px-6 py-3.5 font-semibold">Frequency</th>
                            <th class="px-6 py-3.5 font-semibold">Effective From</th>
                            <th class="px-6 py-3.5 font-semibold">Effective Until</th>
                            <th class="px-6 py-3.5 font-semibold">Status</th>
                            <th class="px-6 py-3.5 text-right font-semibold">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-navy-100">
                        @foreach ($feePlans as $plan)
                            <tr class="transition-colors hover:bg-cream/70">
                                <td class="px-6 py-4">
                                    <a href="{{ route('admin.fee-plans.show', $plan) }}" class="focus-ring rounded font-semibold text-navy-950 transition-colors hover:text-maroon-700">
                                        {{ $plan->name }}
                                    </a>
                                </td>
                                <td class="px-6 py-4 text-navy-950">{{ $plan->membershipType?->name ?? '—' }}</td>
                                <td class="px-6 py-4 font-semibold text-navy-950">{{ $plan->formattedAmount() }}</td>
                                <td class="px-6 py-4 text-navy-950">{{ $plan->frequencyLabel() }}</td>
                                <td class="px-6 py-4 text-ink-soft">{{ $plan->effective_from?->format('M j, Y') ?? '—' }}</td>
                                <td class="px-6 py-4 text-ink-soft">{{ $plan->effective_until?->format('M j, Y') ?? '—' }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-wrap items-center gap-1.5">
                                        @if ($plan->is_active)
                                            <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-100 px-2.5 py-1 text-xs font-semibold text-emerald-800">
                                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500" aria-hidden="true"></span>
                                                Active
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 rounded-full bg-navy-100 px-2.5 py-1 text-xs font-semibold text-navy-600">
                                                <span class="h-1.5 w-1.5 rounded-full bg-navy-400" aria-hidden="true"></span>
                                                Inactive
                                            </span>
                                        @endif
                                        @if ($plan->timingState() === 'upcoming')
                                            <span class="inline-flex rounded-full bg-gold-500/20 px-2 py-0.5 text-[11px] font-bold uppercase tracking-wide text-gold-700">Upcoming</span>
                                        @elseif($plan->is_active)
                                            <span class="inline-flex rounded-full bg-maroon-700/10 px-2 py-0.5 text-[11px] font-bold uppercase tracking-wide text-maroon-700">Current</span>
                                        @else
                                            <span class="inline-flex rounded-full bg-navy-100 px-2 py-0.5 text-[11px] font-bold uppercase tracking-wide text-navy-500">Expired</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-end gap-1">
                                        <a href="{{ route('admin.fee-plans.show', $plan) }}" class="focus-ring inline-flex h-8 w-8 items-center justify-center rounded-md text-navy-600 transition-colors hover:bg-navy-50 hover:text-navy-900" aria-label="View {{ $plan->name }}">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.5 12S6 5.5 12 5.5 21.5 12 21.5 12 18 18.5 12 18.5 2.5 12 2.5 12z" />
                                            </svg>
                                        </a>
                                        <a href="{{ route('admin.fee-plans.edit', $plan) }}" class="focus-ring inline-flex h-8 w-8 items-center justify-center rounded-md text-navy-600 transition-colors hover:bg-navy-50 hover:text-navy-900" aria-label="Edit {{ $plan->name }}">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.4-9.4a2 2 0 112.8 2.8L11 15l-4 1 1-4 9.6-9.4z" />
                                            </svg>
                                        </a>
                                        <form method="POST" action="{{ route('admin.fee-plans.destroy', $plan) }}" onsubmit="return confirm('Delete {{ addslashes($plan->name) }}? This cannot be undone.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="focus-ring inline-flex h-8 w-8 items-center justify-center rounded-md text-maroon-600 transition-colors hover:bg-maroon-50 hover:text-maroon-800" aria-label="Delete {{ $plan->name }}">
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
                {{ $feePlans->links() }}
            </div>
        </div>
    @else
        <div class="mt-8">
            <x-empty-state
                title="No fee plans found"
                description="No fee plans match your current filters. Adjust the filters or create a new fee plan to get started."
                action_label="Add Fee Plan"
                action_href="{{ route('admin.fee-plans.create') }}"
            />
        </div>
    @endif
</x-layouts.admin>
