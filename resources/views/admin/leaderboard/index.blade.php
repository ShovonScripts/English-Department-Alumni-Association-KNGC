<x-layouts.admin title="Leaderboard Management">
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="font-serif text-3xl font-semibold tracking-tight text-navy-950">Leaderboard Management</h1>
            <p class="mt-1 text-sm text-ink-soft">
                Administrative view of member contribution rankings. All memberships are shown including hidden, private, and zero-contribution records.
                Verified contributions are derived from <code class="bg-navy-50 px-1.5 py-0.5 rounded text-xs font-mono">Payment::valid()</code> (paid + partial) — never manually editable.
            </p>
        </div>

        {{-- Public Leaderboard Toggle --}}
        <div class="flex items-center gap-4">
            <div class="inline-flex items-center gap-3 rounded-md border border-navy-200 bg-cream px-4 py-3">
                <span class="text-sm font-medium text-navy-950">Public Leaderboard</span>
                <form method="POST" action="{{ route('admin.leaderboard.togglePublic') }}">
                    @csrf
                    <x-button
                        type="submit"
                        :variant="$publicEnabled ? 'emerald' : 'navy'"
                        size="sm"
                    >
                        {{ $publicEnabled ? 'Enabled' : 'Disabled' }}
                    </x-button>
                </form>
                <span class="text-xs text-ink-soft">
                    {{ $publicEnabled ? 'Contributors are visible on /leaderboard' : 'Public leaderboard is hidden' }}
                </span>
            </div>
        </div>
    </div>

    @if (session('status'))
        <div class="mb-6 flex items-center gap-3 rounded-md border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800" role="status">
            <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            {{ session('status') }}
        </div>
    @endif

    {{-- Filters --}}
    <form method="GET" action="{{ route('admin.leaderboard.index') }}" class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm" aria-label="Leaderboard filters">
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-8">
            {{-- Search --}}
            <div class="lg:col-span-3">
                <label for="q" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Search</label>
                <input
                    type="search"
                    id="q"
                    name="q"
                    value="{{ $filters['q'] }}"
                    placeholder="Name, student ID, membership #…"
                    class="w-full rounded-md border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 placeholder-navy-400 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none"
                >
            </div>

            {{-- Membership Type --}}
            <div>
                <label for="type" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Type</label>
                <select id="type" name="type" class="w-full rounded-md border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none">
                    <option value="">All Types</option>
                    @foreach ($types as $type)
                        <option value="{{ $type->slug }}" @selected($filters['type'] === $type->slug)>{{ $type->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Membership Tier --}}
            <div>
                <label for="tier" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Tier</label>
                <select id="tier" name="tier" class="w-full rounded-md border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none">
                    <option value="">All Tiers</option>
                    @foreach ($tiers as $tier)
                        <option value="{{ $tier->slug }}" @selected($filters['tier'] === $tier->slug)>{{ $tier->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Status --}}
            <div>
                <label for="status" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Status</label>
                <select id="status" name="status" class="w-full rounded-md border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none">
                    <option value="">All Statuses</option>
                    @foreach ($statuses as $status)
                        <option value="{{ $status }}" @selected($filters['status'] === $status)>{{ ucfirst($status) }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Leaderboard Visibility --}}
            <div>
                <label for="visibility" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Leaderboard</label>
                <select id="visibility" name="visibility" class="w-full rounded-md border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none">
                    <option value="">All</option>
                    <option value="public" @selected($filters['visibility'] === 'public')>Public</option>
                    <option value="hidden" @selected($filters['visibility'] === 'hidden')>Hidden</option>
                </select>
            </div>

            {{-- Minimum Contribution --}}
            <div>
                <label for="min_contribution" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Min. Contribution (৳)</label>
                <input
                    type="number"
                    id="min_contribution"
                    name="min_contribution"
                    value="{{ $filters['min_contribution'] }}"
                    min="0"
                    step="1"
                    placeholder="0"
                    class="w-full rounded-md border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 placeholder-navy-400 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none"
                >
            </div>

            {{-- Submit --}}
            <div class="flex items-end gap-2">
                <x-button type="submit" variant="navy">Filter</x-button>
                <a href="{{ route('admin.leaderboard.index') }}" class="focus-ring inline-flex h-10 items-center justify-center rounded-md px-4 text-sm font-semibold text-navy-600 transition-colors hover:bg-navy-50 hover:text-navy-900">Clear</a>
            </div>
        </div>
    </form>

    {{-- Results --}}
    @if ($entries->isNotEmpty())
        <div class="mt-8 overflow-hidden rounded-lg border border-navy-100 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm" role="table">
                    <thead>
                        <tr class="border-b border-navy-100 bg-navy-50/60 text-xs uppercase tracking-wider text-ink-soft">
                            <th class="px-6 py-3.5 font-semibold w-16">Rank</th>
                            <th class="px-6 py-3.5 font-semibold">Member</th>
                            <th class="px-6 py-3.5 font-semibold hidden md:table-cell">Membership #</th>
                            <th class="px-6 py-3.5 font-semibold hidden lg:table-cell">Type</th>
                            <th class="px-6 py-3.5 font-semibold hidden xl:table-cell">Tier</th>
                            <th class="px-6 py-3.5 font-semibold text-right">Verified Contribution</th>
                            <th class="px-6 py-3.5 font-semibold text-center hidden md:table-cell">Payments</th>
                            <th class="px-6 py-3.5 font-semibold text-center hidden lg:table-cell">Leaderboard</th>
                            <th class="px-6 py-3.5 font-semibold text-center">Status</th>
                            <th class="px-6 py-3.5 font-semibold text-right w-24">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-navy-100">
                        @foreach ($entries as $entry)
                            <tr class="transition-colors {{ $entry->verified_total > 0 ? '' : 'bg-navy-50/30' }} {{ $entry->status !== 'active' || ! $entry->is_public || ! $entry->show_on_leaderboard ? 'opacity-70' : '' }}">
                                {{-- Rank --}}
                                <td class="px-6 py-4 font-mono text-sm font-semibold text-navy-900">
                                    @if ($entry->verified_total > 0)
                                        <span class="inline-flex h-8 w-8 items-center justify-center rounded-full font-serif text-xs font-bold {{ $entry->leaderboard_rank <= 3 ? 'bg-gold-500 text-navy-950' : 'bg-navy-100 text-navy-950' }}">
                                            {{ $entry->leaderboard_rank }}
                                        </span>
                                        <span class="sr-only">{{ \Illuminate\Support\Number::ordinal($entry->leaderboard_rank) }} place</span>
                                    @else
                                        <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-navy-100 text-navy-400 text-[10px] font-medium">—</span>
                                        <span class="sr-only">Not ranked</span>
                                    @endif
                                </td>

                                {{-- Member --}}
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        @if ($entry->profile_photo)
                                            <img src="{{ Storage::disk('public')->url($entry->profile_photo) }}" alt="" class="h-10 w-10 rounded-full object-cover ring-2 ring-gold-500/40">
                                        @else
                                            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-navy-900 font-serif text-xs font-semibold text-gold-300" aria-hidden="true">
                                                {{ \Illuminate\Support\Str::initials($entry->alumni_name) }}
                                            </span>
                                        @endif
                                        <div>
                                            <a href="{{ route('admin.members.show', $entry->membership_id) }}" class="focus-ring font-medium text-navy-950 transition-colors hover:text-maroon-700">{{ $entry->alumni_name }}</a>
                                            @if ($entry->student_id)
                                                <p class="text-xs text-ink-soft">{{ $entry->student_id }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </td>

                                {{-- Membership Number --}}
                                <td class="px-6 py-4 hidden md:table-cell font-mono text-xs text-ink-soft">{{ $entry->membership_number }}</td>

                                {{-- Type --}}
                                <td class="px-6 py-4 hidden lg:table-cell text-ink-soft">{{ $entry->type_name ?? '—' }}</td>

                                {{-- Tier --}}
                                <td class="px-6 py-4 hidden xl:table-cell">
                                    @if ($entry->tier_name)
                                        <span class="inline-flex items-center gap-1.5 rounded-full border border-gold-500/50 bg-gold-500/15 px-2.5 py-1 text-[10px] font-semibold uppercase tracking-widest text-gold-700">
                                            <svg class="h-2.5 w-2.5" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                                <path d="M10 2l1.9 4.05 4.45.55-3.28 3.1.85 4.4L10 11.95 6.08 14.1l.85-4.4L3.65 6.6l4.45-.55L10 2z" />
                                            </svg>
                                            {{ $entry->tier_name }}
                                        </span>
                                    @else
                                        <span class="text-ink-soft">—</span>
                                    @endif
                                </td>

                                {{-- Verified Contribution --}}
                                <td class="px-6 py-4 text-right font-bold tabular-nums text-navy-950">
                                    {{ $entry->formatted_contribution }}
                                    @if ($entry->verified_total === 0)
                                        <span class="ml-1 text-[10px] font-normal uppercase tracking-widest text-ink-soft">(none)</span>
                                    @endif
                                </td>

                                {{-- Payment Count --}}
                                <td class="px-6 py-4 text-center hidden md:table-cell font-mono text-sm text-navy-950">{{ $entry->valid_payment_count }}</td>

                                {{-- Leaderboard Visibility --}}
                                <td class="px-6 py-4 text-center hidden lg:table-cell">
                                    @if ($entry->is_public && $entry->show_on_leaderboard)
                                        <span class="inline-flex rounded-full bg-emerald-100 px-2.5 py-1 text-[10px] font-semibold uppercase tracking-wide text-emerald-800">Public</span>
                                    @else
                                        <span class="inline-flex rounded-full bg-maroon-100 px-2.5 py-1 text-[10px] font-semibold uppercase tracking-wide text-maroon-800">Hidden</span>
                                    @endif
                                </td>

                                {{-- Status --}}
                                <td class="px-6 py-4 text-center">
                                    @php
                                        $statusStyles = [
                                            'active' => ['bg-emerald-100', 'text-emerald-800'],
                                            'pending' => ['bg-gold-500/20', 'text-gold-700'],
                                            'suspended' => ['bg-maroon-100', 'text-maroon-800'],
                                            'cancelled' => ['bg-navy-100', 'text-navy-600'],
                                            'expired' => ['bg-navy-100', 'text-navy-500'],
                                        ];
                                        [$bg, $text] = $statusStyles[$entry->status] ?? ['bg-navy-100', 'text-navy-600'];
                                    @endphp
                                    <span class="inline-flex rounded-full {{ $bg }} px-2.5 py-1 text-[10px] font-semibold uppercase tracking-wide {{ $text }}">{{ ucfirst($entry->status) }}</span>
                                </td>

                                {{-- Actions --}}
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-end gap-1">
                                        <a href="{{ route('admin.members.show', $entry->membership_id) }}" class="focus-ring inline-flex h-8 w-8 items-center justify-center rounded-md text-navy-600 transition-colors hover:bg-navy-50 hover:text-navy-900" aria-label="View {{ $entry->membership_number }}">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.5 12S6 5.5 12 5.5 21.5 12 21.5 12 18 18.5 12 18.5 2.5 12 2.5 12z" />
                                            </svg>
                                        </a>

                                        {{-- Toggle Leaderboard Visibility --}}
                                        <form method="POST" action="{{ route('admin.leaderboard.visibility', $entry->membership_id) }}" class="inline">
                                            @csrf
                                            <x-button
                                                type="submit"
                                                :variant="$entry->show_on_leaderboard ? 'navy' : 'outline'"
                                                size="icon"
                                                aria-label="{{ $entry->show_on_leaderboard ? 'Hide from public leaderboard' : 'Show on public leaderboard' }}"
                                            >
                                                @if ($entry->show_on_leaderboard)
                                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                                    </svg>
                                                @else
                                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.5 12S6 5.5 12 5.5 21.5 12 21.5 12 18 18.5 12 18.5 2.5 12 2.5 12z" />
                                                    </svg>
                                                @endif
                                            </x-button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="border-t border-navy-100 px-6 py-4">
                {{ $entries->appends(request()->query())->links() }}
            </div>
        </div>
    @else
        <div class="mt-8">
            <x-empty-state
                title="No members found"
                description="No membership records match your current filters. Adjust the filters or create a new membership to get started."
                action_label="Create Membership"
                action_href="{{ route('admin.members.create') }}"
            />
        </div>
    @endif
</x-layouts.admin>