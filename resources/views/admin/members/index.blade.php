<x-layouts.admin title="Members">
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="font-serif text-3xl font-semibold tracking-tight text-navy-950">Members</h1>
            <p class="mt-1 text-sm text-ink-soft">
                Manage formal EDAA memberships for registered alumni.
            </p>
        </div>
        <x-button href="{{ route('admin.members.create') }}" variant="gold">Add Member</x-button>
    </div>

    @if (session('status'))
        <div class="mb-6 flex items-center gap-3 rounded-md border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800" role="status">
            <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            {{ session('status') }}
        </div>
    @endif

    <form method="GET" action="{{ route('admin.members.index') }}" class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm">
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-5">
            <div class="lg:col-span-2">
                <label for="search" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Search</label>
                <input
                    type="search"
                    id="search"
                    name="search"
                    value="{{ $filters['search'] }}"
                    placeholder="Member name, student ID, membership number…"
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
                <label for="membership_tier_id" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Tier</label>
                <select id="membership_tier_id" name="membership_tier_id" class="w-full rounded-md border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none">
                    <option value="">All</option>
                    @foreach ($tiers as $tier)
                        <option value="{{ $tier->id }}" @selected($filters['membership_tier_id'] == $tier->id)>{{ $tier->name }}</option>
                    @endforeach
                    <option value="none" @selected($filters['membership_tier_id'] === 'none')>No tier</option>
                </select>
            </div>

            <div>
                <label for="status" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Status</label>
                <div class="flex items-center gap-2">
                    <select id="status" name="status" class="w-full rounded-md border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none">
                        <option value="">All</option>
                        @foreach (\App\Models\Membership::STATUSES as $value)
                            <option value="{{ $value }}" @selected($filters['status'] === $value)>{{ ucfirst($value) }}</option>
                        @endforeach
                    </select>
                    <x-button type="submit" variant="navy">Filter</x-button>
                </div>
            </div>
        </div>
    </form>

    @if ($memberships->isNotEmpty())
        <div class="mt-8 overflow-hidden rounded-lg border border-navy-100 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="border-b border-navy-100 bg-navy-50/60 text-xs uppercase tracking-wider text-ink-soft">
                            <th class="px-6 py-3.5 font-semibold">Member</th>
                            <th class="px-6 py-3.5 font-semibold">Number</th>
                            <th class="px-6 py-3.5 font-semibold">Batch</th>
                            <th class="px-6 py-3.5 font-semibold">Type</th>
                            <th class="px-6 py-3.5 font-semibold">Tier</th>
                            <th class="px-6 py-3.5 font-semibold">Status</th>
                            <th class="px-6 py-3.5 font-semibold">Joined</th>
                            <th class="px-6 py-3.5 font-semibold">Public</th>
                            <th class="px-6 py-3.5 text-right font-semibold">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-navy-100">
                        @foreach ($memberships as $membership)
                            <tr class="transition-colors hover:bg-cream/70">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        @if ($membership->alumni?->profile_photo_url)
                                            <img src="{{ $membership->alumni->profile_photo_url }}" alt="" class="h-10 w-10 shrink-0 rounded-full object-cover">
                                        @else
                                            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-navy-900 font-serif text-xs font-semibold text-gold-300" aria-hidden="true">
                                                {{ \Illuminate\Support\Str::initials($membership->alumni?->full_name ?? '') }}
                                            </span>
                                        @endif
                                        <div>
                                            <a href="{{ route('admin.members.show', $membership) }}" class="focus-ring rounded font-semibold text-navy-950 transition-colors hover:text-maroon-700">
                                                {{ $membership->alumni?->full_name ?? '—' }}
                                            </a>
                                            @if ($membership->alumni?->student_id)
                                                <p class="text-xs text-ink-soft">{{ $membership->alumni->student_id }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 font-mono text-xs font-semibold text-navy-900">{{ $membership->membership_number }}</td>
                                <td class="px-6 py-4 text-navy-950">{{ $membership->alumni?->batch ?? '—' }}</td>
                                <td class="px-6 py-4 text-navy-950">{{ $membership->type?->name ?? '—' }}</td>
                                <td class="px-6 py-4 text-navy-950">{{ $membership->tier?->badge_label ?? '—' }}</td>
                                <td class="px-6 py-4">
                                    @php
                                        $statusStyles = [
                                            'active' => ['bg-emerald-100', 'text-emerald-800', 'bg-emerald-500'],
                                            'pending' => ['bg-gold-500/20', 'text-gold-700', 'bg-gold-500'],
                                            'suspended' => ['bg-maroon-100', 'text-maroon-800', 'bg-maroon-600'],
                                            'cancelled' => ['bg-navy-100', 'text-navy-600', 'bg-navy-400'],
                                            'expired' => ['bg-navy-100', 'text-navy-600', 'bg-navy-400'],
                                        ];
                                        [$bg, $text, $dot] = $statusStyles[$membership->status] ?? ['bg-navy-100', 'text-navy-600', 'bg-navy-400'];
                                    @endphp
                                    <span class="inline-flex items-center gap-1.5 rounded-full {{ $bg }} px-2.5 py-1 text-xs font-semibold {{ $text }}">
                                        <span class="h-1.5 w-1.5 rounded-full {{ $dot }}" aria-hidden="true"></span>
                                        {{ ucfirst($membership->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-ink-soft">{{ $membership->joined_at?->format('M j, Y') ?? '—' }}</td>
                                <td class="px-6 py-4">
                                    @if ($membership->is_public)
                                        <span class="inline-flex rounded-full bg-emerald-100 px-2.5 py-1 text-xs font-semibold text-emerald-800">Public</span>
                                    @else
                                        <span class="inline-flex rounded-full bg-navy-100 px-2.5 py-1 text-xs font-semibold text-navy-600">Private</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-end gap-1">
                                        <a href="{{ route('admin.members.show', $membership) }}" class="focus-ring inline-flex h-8 w-8 items-center justify-center rounded-md text-navy-600 transition-colors hover:bg-navy-50 hover:text-navy-900" aria-label="View {{ $membership->membership_number }}">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.5 12S6 5.5 12 5.5 21.5 12 21.5 12 18 18.5 12 18.5 2.5 12 2.5 12z" />
                                            </svg>
                                        </a>
                                        <a href="{{ route('admin.members.edit', $membership) }}" class="focus-ring inline-flex h-8 w-8 items-center justify-center rounded-md text-navy-600 transition-colors hover:bg-navy-50 hover:text-navy-900" aria-label="Edit {{ $membership->membership_number }}">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.4-9.4a2 2 0 112.8 2.8L11 15l-4 1 1-4 9.6-9.4z" />
                                            </svg>
                                        </a>
                                        <form method="POST" action="{{ route('admin.members.destroy', $membership) }}" onsubmit="return confirm('Delete membership {{ $membership->membership_number }}? This cannot be undone.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="focus-ring inline-flex h-8 w-8 items-center justify-center rounded-md text-maroon-600 transition-colors hover:bg-maroon-50 hover:text-maroon-800" aria-label="Delete {{ $membership->membership_number }}">
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
                {{ $memberships->links() }}
            </div>
        </div>
    @else
        <div class="mt-8">
            <x-empty-state
                title="No members found"
                description="No memberships match your current filters. Adjust the filters or register a new member to get started."
                action_label="Add Member"
                action_href="{{ route('admin.members.create') }}"
            />
        </div>
    @endif
</x-layouts.admin>
