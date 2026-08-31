<x-layouts.admin title="Membership Applications">
    <div class="mb-8 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="font-serif text-3xl font-semibold tracking-tight text-navy-950">Membership Applications</h1>
            <p class="text-sm text-ink-soft">{{ $applications->total() }} application{{ $applications->total() !== 1 ? 's' : '' }} total</p>
        </div>
    </div>

    {{-- Filters --}}
    <form method="GET" class="mb-6 rounded-lg border border-navy-100 bg-white p-4 shadow-sm">
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <div>
                <label for="q" class="mb-1 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Search</label>
                <input
                    id="q"
                    type="text"
                    name="q"
                    value="{{ request('q') }}"
                    placeholder="Number, name, email, phone…"
                    class="input-field"
                >
            </div>
            <div>
                <label for="status" class="mb-1 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Status</label>
                <select id="status" name="status" class="input-field">
                    <option value="">All Statuses</option>
                    @foreach ($statuses as $status)
                        <option value="{{ $status->value }}" {{ request('status') === $status->value ? 'selected' : '' }}>
                            {{ $status->label() }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="membership_type_id" class="mb-1 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Membership Type</label>
                <select id="membership_type_id" name="membership_type_id" class="input-field">
                    <option value="">All Types</option>
                    @foreach ($membershipTypes as $type)
                        <option value="{{ $type->id }}" {{ request('membership_type_id') == $type->id ? 'selected' : '' }}>
                            {{ $type->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="requested_tier_id" class="mb-1 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Tier</label>
                <select id="requested_tier_id" name="requested_tier_id" class="input-field">
                    <option value="">All Tiers</option>
                    @foreach ($membershipTiers as $tier)
                        <option value="{{ $tier->id }}" {{ request('requested_tier_id') == $tier->id ? 'selected' : '' }}>
                            {{ $tier->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="mt-4 flex items-end gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <div>
                <label for="date_from" class="mb-1 block text-xs font-semibold uppercase tracking-wider text-ink-soft">From</label>
                <input id="date_from" type="date" name="date_from" value="{{ request('date_from') }}" class="input-field">
            </div>
            <div>
                <label for="date_to" class="mb-1 block text-xs font-semibold uppercase tracking-wider text-ink-soft">To</label>
                <input id="date_to" type="date" name="date_to" value="{{ request('date_to') }}" class="input-field">
            </div>
            <div class="flex gap-2">
                <button type="submit" class="focus-ring inline-flex items-center gap-2 rounded-md bg-navy-900 px-4 py-2.5 text-sm font-semibold text-white transition-colors hover:bg-navy-800">
                    Filter
                </button>
                @if (request()->hasAny(['q', 'status', 'membership_type_id', 'requested_tier_id', 'date_from', 'date_to']))
                    <a href="{{ route('admin.membership-applications.index') }}" class="focus-ring inline-flex items-center gap-2 rounded-md border border-navy-200 px-4 py-2.5 text-sm font-semibold text-navy-600 transition-colors hover:bg-navy-50">
                        Clear
                    </a>
                @endif
            </div>
        </div>
    </form>

    @if (session('success'))
        <div class="mb-6 flex items-start gap-3 rounded-lg border border-green-200 bg-green-50 p-5 text-green-800" role="status">
            <svg class="mt-0.5 h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <p class="text-sm">{{ session('success') }}</p>
        </div>
    @endif

    {{-- Table --}}
    @if ($applications->isNotEmpty())
        <div class="overflow-hidden rounded-lg border border-navy-100 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-navy-100 text-sm">
                    <thead class="bg-cream">
                        <tr>
                            <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-ink-soft">Application</th>
                            <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-ink-soft">Applicant</th>
                            <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-ink-soft">Type</th>
                            <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-ink-soft">Tier</th>
                            <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-ink-soft">Status</th>
                            <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-ink-soft">Submitted</th>
                            <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-ink-soft">Reviewed</th>
                            <th scope="col" class="px-6 py-3.5 text-right text-xs font-semibold uppercase tracking-wider text-ink-soft">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-navy-50">
                        @foreach ($applications as $application)
                            @php
                                $statusColor = match($application->status->value) {
                                    'pending' => 'bg-gold-100 text-gold-800',
                                    'under_review' => 'bg-navy-100 text-navy-800',
                                    'approved' => 'bg-emerald-100 text-emerald-800',
                                    'rejected' => 'bg-maroon-100 text-maroon-800',
                                    'changes_requested' => 'bg-amber-100 text-amber-800',
                                    'cancelled' => 'bg-navy-100 text-navy-800',
                                    default => 'bg-navy-100 text-navy-800',
                                };
                            @endphp
                            <tr class="transition-colors hover:bg-cream/60">
                                <td class="whitespace-nowrap px-6 py-3.5">
                                    <a href="{{ route('admin.membership-applications.show', $application) }}" class="font-medium text-maroon-700 hover:text-maroon-800">
                                        {{ $application->application_number }}
                                    </a>
                                </td>
                                <td class="px-6 py-3.5">
                                    <div class="font-medium text-navy-950">{{ $application->full_name }}</div>
                                    <div class="text-xs text-ink-soft">{{ $application->email }}</div>
                                </td>
                                <td class="px-6 py-3.5 text-ink-soft">{{ $application->membershipType->name ?? '—' }}</td>
                                <td class="px-6 py-3.5 text-ink-soft">{{ $application->requestedTier->name ?? '—' }}</td>
                                <td class="px-6 py-3.5">
                                    <span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-semibold {{ $statusColor }}">
                                        {{ $application->status->label() }}
                                    </span>
                                </td>
                                <td class="whitespace-nowrap px-6 py-3.5 text-ink-soft">{{ $application->submitted_at->format('d M Y') }}</td>
                                <td class="whitespace-nowrap px-6 py-3.5 text-ink-soft">{{ $application->reviewed_at?->format('d M Y') ?? '—' }}</td>
                                <td class="whitespace-nowrap px-6 py-3.5 text-right">
                                    <a href="{{ route('admin.membership-applications.show', $application) }}" class="focus-ring inline-flex items-center gap-1 rounded-md px-2.5 py-1.5 text-xs font-semibold text-navy-600 transition-colors hover:bg-navy-50">
                                        View
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-6">
            {{ $applications->links() }}
        </div>
    @else
        <x-empty-state
            title="No applications found"
            description="{{ request()->hasAny(['q', 'status', 'membership_type_id', 'requested_tier_id', 'date_from', 'date_to']) ? 'Try adjusting your filters.' : 'No membership applications have been submitted yet.' }}"
        />
    @endif
</x-layouts.admin>
