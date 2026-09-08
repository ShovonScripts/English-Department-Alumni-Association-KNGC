<x-layouts.admin title="{{ $committee->name }}">
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="font-serif text-3xl font-semibold tracking-tight text-navy-950">{{ $committee->name }}</h1>
            <p class="mt-1 text-sm text-ink-soft">{{ $committee->type?->name }} &middot; {{ $committee->yearRange() }}</p>
        </div>
        <a href="{{ route('admin.committees.index') }}" class="focus-ring inline-flex items-center gap-2 rounded-md px-3.5 py-2 text-sm font-semibold text-navy-800 transition-colors hover:bg-navy-50">&larr; Back to Committees</a>
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

    <div class="grid gap-8 lg:grid-cols-3">
        {{-- Summary Card --}}
        <div>
            <section class="rounded-lg border border-navy-100 bg-white p-8 text-center shadow-sm">
                <div class="flex h-16 w-16 mx-auto items-center justify-center rounded-2xl bg-navy-900 font-serif text-xl font-bold text-gold-300 shadow-md">
                    {{ strtoupper(substr($committee->type?->slug ?? 'CO', 0, 2)) }}
                </div>
                <h2 class="mt-4 font-serif text-xl font-semibold text-navy-950">{{ $committee->name }}</h2>
                <p class="mt-1 text-sm text-ink-soft">{{ $committee->yearRange() }}</p>
                <div class="mt-4 flex flex-wrap items-center justify-center gap-1.5">
                    @if ($committee->is_current)
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-gold-500/15 px-2.5 py-1 text-[10px] font-semibold uppercase tracking-widest text-gold-700"><span class="h-1.5 w-1.5 rounded-full bg-gold-500"></span> Current</span>
                    @else
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-navy-100 px-2.5 py-1 text-[10px] font-semibold uppercase tracking-widest text-navy-500">Past</span>
                    @endif
                    <span class="inline-flex items-center gap-1.5 rounded-full bg-navy-100 px-2.5 py-1 text-[10px] font-semibold uppercase tracking-widest text-navy-500">{{ $members->count() }} {{ Str::plural('member', $members->count()) }}</span>
                </div>
                @if ($committee->description)
                    <p class="mt-4 text-sm text-ink-soft">{{ $committee->description }}</p>
                @endif
                <div class="mt-6 flex flex-col gap-2">
                    @if (! $committee->is_current)
                        <form method="POST" action="{{ route('admin.committees.make-current', $committee) }}">
                            @csrf
                            <button type="submit" class="focus-ring w-full inline-flex items-center justify-center gap-2 rounded-lg bg-gold-500 px-4 py-2.5 text-sm font-semibold text-navy-950 shadow-sm transition-colors hover:bg-gold-400">Mark as Current</button>
                        </form>
                    @endif
                    <a href="{{ route('admin.committees.edit', $committee) }}" class="focus-ring inline-flex items-center justify-center gap-2 rounded-lg border border-navy-300 px-4 py-2.5 text-sm font-semibold text-navy-900 transition-colors hover:bg-navy-50">Edit Committee</a>
                    <form method="POST" action="{{ route('admin.committees.destroy', $committee) }}" onsubmit="return confirm('Delete this committee? Members will be removed.');">
                        @csrf @method('DELETE')
                        <button type="submit" class="focus-ring w-full inline-flex items-center justify-center gap-2 rounded-lg px-4 py-2.5 text-sm font-semibold text-maroon-600 transition-colors hover:bg-maroon-50">Delete</button>
                    </form>
                </div>
            </section>

            {{-- Add Member --}}
            <section class="mt-6 rounded-lg border border-navy-100 bg-white p-6 shadow-sm">
                <h3 class="font-serif text-lg font-semibold text-navy-950">Add Member</h3>
                <form method="POST" action="{{ route('admin.committees.add-member', $committee) }}" class="mt-4 space-y-4">
                    @csrf
                    <div>
                        <label for="membership_id" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Member *</label>
                        <select id="membership_id" name="membership_id" required class="w-full rounded-md border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none">
                            <option value="">Select member...</option>
                            @php
                                $existingIds = $members->pluck('id')->toArray();
                                $availableMembers = \App\Models\Membership::query()->where('status', 'active')->with('alumni')->whereNotIn('id', $existingIds)->orderBy('membership_number')->get();
                            @endphp
                            @foreach ($availableMembers as $m)
                                <option value="{{ $m->id }}">{{ $m->alumni?->full_name ?? $m->membership_number }} ({{ $m->membership_number }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="committee_role_id" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Position *</label>
                        <select id="committee_role_id" name="committee_role_id" required class="w-full rounded-md border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none">
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="focus-ring w-full inline-flex items-center justify-center gap-2 rounded-lg bg-gold-500 px-5 py-2.5 text-sm font-semibold text-navy-950 shadow-sm transition-colors hover:bg-gold-400">Add to Committee</button>
                </form>
            </section>
        </div>

        {{-- Members Grouped by Role --}}
        <div class="lg:col-span-2">
            <section class="rounded-lg border border-navy-100 bg-white shadow-sm">
                <div class="border-b border-navy-100 px-6 py-4">
                    <h3 class="font-serif text-lg font-semibold text-navy-950">Committee Members</h3>
                </div>

                @if ($members->isEmpty())
                    <div class="px-6 py-12 text-center text-sm text-ink-soft">No members assigned yet. Add members using the form.</div>
                @else
                    {{-- Grouped by Role --}}
                    @foreach ($groupedMembers as $groupId => $group)
                        <div class="{{ !$loop->first ? 'border-t border-navy-100' : '' }}">
                            <div class="bg-navy-50/50 px-6 py-3">
                                <h4 class="text-sm font-semibold uppercase tracking-wider text-navy-700">{{ $group['role']->name }}</h4>
                            </div>
                            <ul class="divide-y divide-navy-100">
                                @foreach ($group['members'] as $member)
                                    <li class="flex items-center justify-between gap-4 px-6 py-4 hover:bg-cream/50 transition-colors">
                                        <div class="flex items-center gap-4">
                                            @if ($member->alumni?->profile_photo_url)
                                                <img src="{{ $member->alumni->profile_photo_url }}" alt="" class="h-10 w-10 rounded-full object-cover ring-2 ring-gold-500/30">
                                            @else
                                                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-navy-900 font-serif text-xs font-bold text-gold-300">{{ \Illuminate\Support\Str::initials($member->alumni?->full_name ?? '') }}</span>
                                            @endif
                                            <div>
                                                <p class="font-semibold text-navy-950">{{ $member->alumni?->full_name ?? 'Unknown' }}</p>
                                                <p class="text-xs text-ink-soft">{{ $member->membership_number }}</p>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            {{-- Change Role --}}
                                            <form method="POST" action="{{ route('admin.committees.update-member-role', ['committee' => $committee, 'membership' => $member->id]) }}" class="inline-flex">
                                                @csrf @method('PUT')
                                                <select name="committee_role_id" onchange="this.form.submit()" class="rounded-md border border-navy-200 bg-white px-2 py-1 text-xs text-navy-950 focus:border-gold-500 focus:ring-1 focus:ring-gold-500/30 focus:outline-none">
                                                    @foreach ($roles as $role)
                                                        <option value="{{ $role->id }}" @selected($role->id === $member->pivot_committee_role_id)>{{ $role->name }}</option>
                                                    @endforeach
                                                </select>
                                            </form>
                                            {{-- Remove --}}
                                            <form method="POST" action="{{ route('admin.committees.remove-member', ['committee' => $committee, 'membership' => $member->id]) }}" onsubmit="return confirm('Remove {{ $member->alumni?->full_name }} from this committee?');">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="focus-ring inline-flex h-8 w-8 items-center justify-center rounded-md text-maroon-600 transition-colors hover:bg-maroon-50 hover:text-maroon-800" title="Remove">
                                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endforeach

                    {{-- Unassigned Members --}}
                    @if ($unassignedMembers->isNotEmpty())
                        <div class="border-t border-navy-100">
                            <div class="bg-maroon-50/50 px-6 py-3">
                                <h4 class="text-sm font-semibold uppercase tracking-wider text-maroon-700">Unassigned</h4>
                            </div>
                            <ul class="divide-y divide-navy-100">
                                @foreach ($unassignedMembers as $member)
                                    <li class="flex items-center justify-between gap-4 px-6 py-4 hover:bg-cream/50 transition-colors">
                                        <div class="flex items-center gap-4">
                                            @if ($member->alumni?->profile_photo_url)
                                                <img src="{{ $member->alumni->profile_photo_url }}" alt="" class="h-10 w-10 rounded-full object-cover ring-2 ring-gold-500/30">
                                            @else
                                                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-navy-900 font-serif text-xs font-bold text-gold-300">{{ \Illuminate\Support\Str::initials($member->alumni?->full_name ?? '') }}</span>
                                            @endif
                                            <div>
                                                <p class="font-semibold text-navy-950">{{ $member->alumni?->full_name ?? 'Unknown' }}</p>
                                                <p class="text-xs text-ink-soft">{{ $member->membership_number }}</p>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <form method="POST" action="{{ route('admin.committees.update-member-role', ['committee' => $committee, 'membership' => $member->id]) }}" class="inline-flex">
                                                @csrf @method('PUT')
                                                <select name="committee_role_id" onchange="this.form.submit()" class="rounded-md border border-navy-200 bg-white px-2 py-1 text-xs text-navy-950 focus:border-gold-500 focus:ring-1 focus:ring-gold-500/30 focus:outline-none">
                                                    @foreach ($roles as $role)
                                                        <option value="{{ $role->id }}" @selected($role->id === $member->pivot_committee_role_id)>{{ $role->name }}</option>
                                                    @endforeach
                                                </select>
                                            </form>
                                            <form method="POST" action="{{ route('admin.committees.remove-member', ['committee' => $committee, 'membership' => $member->id]) }}" onsubmit="return confirm('Remove {{ $member->alumni?->full_name }} from this committee?');">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="focus-ring inline-flex h-8 w-8 items-center justify-center rounded-md text-maroon-600 transition-colors hover:bg-maroon-50 hover:text-maroon-800" title="Remove">
                                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                @endif
            </section>
        </div>
    </div>
</x-layouts.admin>
