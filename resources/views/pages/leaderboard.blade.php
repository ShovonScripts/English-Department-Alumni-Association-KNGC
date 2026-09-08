<x-layouts.app
    :title="'Member Leaderboard | EDAA-KNGC'"
    :description="'Recognizing members who have made verified financial contributions to EDAA-KNGC.'"
>

    {{-- 1. Page Header --}}
    <section class="section-pad bg-white">
        <div class="container-page">
            <div class="flex flex-col items-start justify-between gap-6 sm:flex-row sm:items-end">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-wider text-maroon-700">Member Leaderboard</p>
                    <h1 class="mt-2 font-serif text-4xl font-semibold tracking-tight text-navy-950 sm:text-5xl">
                        Recognizing Our Contributors
                    </h1>
                </div>
            </div>

            <div class="mt-8 rounded-lg border border-navy-100 bg-cream p-6 md:p-8">
                <p class="text-base leading-relaxed text-ink-soft">
                    This leaderboard recognizes members who have made <strong>verified financial contributions</strong> to the English Department Alumni Association KNGC.
                    Contributions are derived solely from manually recorded membership payments (paid and partial) — void and waived records are excluded.
                </p>
                <p class="mt-3 text-sm text-ink-soft">
                    Rankings are calculated using competition ranking: members with equal verified totals share the same rank,
                    and the next rank skips accordingly. Tier and type are displayed for context but do not determine ranking.
                </p>
            </div>
        </div>
    </section>

    {{-- 2. Top 3 Podium --}}
    @if ($entries->isNotEmpty() && $entries->onFirstPage())
    <section class="bg-cream py-16 sm:py-20" aria-labelledby="podium-heading">
        <div class="container-page">
            <h2 id="podium-heading" class="sr-only">Top Contributors</h2>

            <div class="mx-auto grid max-w-4xl gap-5 sm:grid-cols-3">
                @foreach ($entries->take(3) as $entry)
                    <article
                        @class([
                            'rounded-lg border bg-white p-6 text-center shadow-sm relative',
                            'border-gold-400 ring-1 ring-gold-400/50' => $loop->first,
                            'border-navy-100' => ! $loop->first,
                        ])
                        aria-labelledby="podium-{{ $loop->index }}-name"
                    >
                        {{-- Rank Badge --}}
                        <div class="absolute -top-4 left-1/2 -translate-x-1/2">
                            <span
                                @class([
                                    'inline-flex h-10 w-10 items-center justify-center rounded-full font-serif text-base font-bold',
                                    'bg-gold-500 text-navy-950' => $loop->first,
                                    'bg-navy-900 text-gold-300' => ! $loop->first,
                                ])
                                aria-label="{{ \Illuminate\Support\Number::ordinal($entry->leaderboard_rank) }} place"
                            >
                                {{ $entry->leaderboard_rank }}
                            </span>
                        </div>

                        <span class="sr-only">{{ \Illuminate\Support\Number::ordinal($entry->leaderboard_rank) }} place</span>

                        {{-- Profile Photo --}}
                        <div class="mt-8 flex justify-center">
                            @if ($entry->profile_photo)
                                <img src="{{ Storage::disk('public')->url($entry->profile_photo) }}" alt="Portrait of {{ $entry->alumni_name }}" class="h-20 w-20 rounded-full object-cover ring-4 ring-gold-500/30">
                            @else
                                <span class="flex h-20 w-20 items-center justify-center rounded-full bg-navy-900 font-serif text-xl font-semibold text-gold-300 ring-4 ring-gold-500/30" aria-hidden="true">
                                    {{ \Illuminate\Support\Str::initials($entry->alumni_name) }}
                                </span>
                            @endif
                        </div>

                        {{-- Name --}}
                        <h3 class="mt-4 truncate font-serif text-lg font-semibold text-navy-950" id="podium-{{ $loop->index }}-name">
                            {{ $entry->alumni_name }}
                        </h3>

                        {{-- Tier Badge --}}
                        @if ($entry->tier_name)
                            <div class="mt-2">
                                <span class="inline-flex items-center gap-1.5 rounded-full border border-gold-500/50 bg-gold-500/15 px-3 py-1 text-[11px] font-semibold uppercase tracking-widest text-gold-700">
                                    <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                        <path d="M10 2l1.9 4.05 4.45.55-3.28 3.1.85 4.4L10 11.95 6.08 14.1l.85-4.4L3.65 6.6l4.45-.55L10 2z" />
                                    </svg>
                                    {{ $entry->tier_name }} Member
                                </span>
                            </div>
                        @endif

                        {{-- Contribution --}}
                        <div class="mt-4 pt-4 border-t border-navy-100">
                            <p class="text-[11px] font-semibold uppercase tracking-widest text-maroon-700">Verified Contribution</p>
                            <p class="mt-1 text-2xl font-bold tabular-nums text-navy-950">{{ $entry->formatted_contribution }}</p>
                            <p class="mt-1 text-xs text-ink-soft">{{ $entry->valid_payment_count }} payment{{ $entry->valid_payment_count !== 1 ? 's' : '' }}</p>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- 3. Full Ranked List --}}
    <section class="section-pad bg-white" aria-labelledby="ranked-list-heading">
        <div class="container-page">
            <h2 id="ranked-list-heading" class="sr-only">Full Leaderboard</h2>

            {{-- Filters --}}
            <form method="GET" action="{{ route('leaderboard.index') }}" class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm" aria-label="Leaderboard filters">
                <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-5">
                    {{-- Search --}}
                    <div class="sm:col-span-2 lg:col-span-3">
                        <label for="q" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Search</label>
                        <input
                            type="search"
                            id="q"
                            name="q"
                            value="{{ $filters['q'] }}"
                            placeholder="Search by name or student ID…"
                            class="w-full rounded-md border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 placeholder-navy-400 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none"
                        >
                    </div>

                    {{-- Membership Type --}}
                    <div>
                        <label for="type" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Membership Type</label>
                        <select id="type" name="type" class="w-full rounded-md border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none">
                            <option value="">All Types</option>
                            @foreach ($types as $type)
                                <option value="{{ $type->slug }}" @selected($filters['type'] === $type->slug)>{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Membership Tier --}}
                    <div>
                        <label for="tier" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Membership Tier</label>
                        <select id="tier" name="tier" class="w-full rounded-md border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none">
                            <option value="">All Tiers</option>
                            @foreach ($tiers as $tier)
                                <option value="{{ $tier->slug }}" @selected($filters['tier'] === $tier->slug)>{{ $tier->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Batch --}}
                    <div>
                        <label for="batch" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Batch</label>
                        <select id="batch" name="batch" class="w-full rounded-md border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none">
                            <option value="">All Batches</option>
                            @foreach ($batches as $batch)
                                <option value="{{ $batch }}" @selected($filters['batch'] === (string) $batch)>{{ $batch }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Submit --}}
                    <div class="flex items-end gap-2">
                        <x-button type="submit" variant="navy">Apply</x-button>
                        <a href="{{ route('leaderboard.index') }}" class="focus-ring inline-flex h-10 items-center justify-center rounded-md px-4 text-sm font-semibold text-navy-600 transition-colors hover:bg-navy-50 hover:text-navy-900">Clear</a>
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
                                    <th class="px-6 py-3.5 font-semibold hidden md:table-cell">Tier</th>
                                    <th class="px-6 py-3.5 font-semibold hidden lg:table-cell">Type</th>
                                    <th class="px-6 py-3.5 font-semibold text-right">Verified Contribution</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-navy-100">
                                @foreach ($entries as $entry)
                                    <tr class="transition-colors hover:bg-cream/70">
                                        <td class="px-6 py-4 font-mono text-sm font-semibold text-navy-900">
                                            <span class="inline-flex h-8 w-8 items-center justify-center rounded-full font-serif text-xs font-bold {{ $entry->leaderboard_rank <= 3 ? 'bg-gold-500 text-navy-950' : 'bg-navy-100 text-navy-950' }}">
                                                {{ $entry->leaderboard_rank }}
                                            </span>
                                            <span class="sr-only">{{ \Illuminate\Support\Number::ordinal($entry->leaderboard_rank) }} place</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                @if ($entry->profile_photo)
                                                    <img src="{{ Storage::disk('public')->url($entry->profile_photo) }}" alt="{{ $entry->alumni_name }}" class="h-10 w-10 rounded-full object-cover ring-2 ring-gold-500/40">
                                                @else
                                                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-navy-900 font-serif text-xs font-semibold text-gold-300" aria-hidden="true">
                                                        {{ \Illuminate\Support\Str::initials($entry->alumni_name) }}
                                                    </span>
                                                @endif
                                                <div>
                                                    <a href="{{ route('alumni.show', $entry->alumni_slug) }}" class="focus-ring font-medium text-navy-950 transition-colors hover:text-maroon-700">{{ $entry->alumni_name }}</a>
                                                    @if ($entry->student_id)
                                                        <p class="text-xs text-ink-soft">{{ $entry->student_id }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 hidden md:table-cell">
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
                                        <td class="px-6 py-4 hidden lg:table-cell text-ink-soft">{{ $entry->type_name ?? '—' }}</td>
                                        <td class="px-6 py-4 text-right font-bold tabular-nums text-navy-950">{{ $entry->formatted_contribution }}</td>
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
                        title="No contributors found"
                        description="No members match your current filters. Try adjusting your search or filter criteria."
                        compact
                    />
                </div>
            @endif
        </div>
    </section>

</x-layouts.app>