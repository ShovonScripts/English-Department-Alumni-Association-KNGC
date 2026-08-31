<x-layouts.admin title="Alumni">
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="font-serif text-3xl font-semibold tracking-tight text-navy-950">Alumni</h1>
            <p class="mt-1 text-sm text-ink-soft">
                Manage the association's alumni directory records.
            </p>
        </div>
        <x-button href="{{ route('admin.alumni.create') }}" variant="gold">Add Alumni</x-button>
    </div>

    @if (session('status'))
        <div class="mb-6 flex items-center gap-3 rounded-md border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800" role="status">
            <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            {{ session('status') }}
        </div>
    @endif

    <form method="GET" action="{{ route('admin.alumni.index') }}" class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm">
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-6">
            <div class="lg:col-span-2">
                <label for="search" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Search</label>
                <input
                    type="search"
                    id="search"
                    name="search"
                    value="{{ $filters['search'] }}"
                    placeholder="Name, student ID, organization…"
                    class="w-full rounded-md border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 placeholder-navy-400 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none"
                >
            </div>

            <div>
                <label for="batch" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Batch</label>
                <select id="batch" name="batch" class="w-full rounded-md border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none">
                    <option value="">All</option>
                    @foreach ($batches as $batch)
                        <option value="{{ $batch }}" @selected($filters['batch'] == $batch)>{{ $batch }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="graduation_year" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Grad Year</label>
                <select id="graduation_year" name="graduation_year" class="w-full rounded-md border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none">
                    <option value="">All</option>
                    @foreach ($years as $year)
                        <option value="{{ $year }}" @selected($filters['graduation_year'] == $year)>{{ $year }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="country" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Country</label>
                <select id="country" name="country" class="w-full rounded-md border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none">
                    <option value="">All</option>
                    @foreach ($countries as $option)
                        <option value="{{ $option }}" @selected($filters['country'] == $option)>{{ $option }}</option>
                    @endforeach
                </select>
            </div>

            <div class="sm:col-span-2 lg:col-span-6">
                <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    <div>
                        <label for="status" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Status</label>
                        <select id="status" name="status" class="w-full rounded-md border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none">
                            <option value="">All</option>
                            <option value="active" @selected($filters['status'] === 'active')>Active</option>
                            <option value="inactive" @selected($filters['status'] === 'inactive')>Inactive</option>
                        </select>
                    </div>

                    <div>
                        <label for="featured" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Featured</label>
                        <select id="featured" name="featured" class="w-full rounded-md border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none">
                            <option value="">All</option>
                            <option value="1" @selected($filters['featured'] === '1')>Featured</option>
                            <option value="0" @selected($filters['featured'] === '0')>Not featured</option>
                        </select>
                    </div>

                    <div class="flex items-end gap-3 lg:col-span-2">
                        <x-button type="submit" variant="navy">Apply Filters</x-button>
                        <a href="{{ route('admin.alumni.index') }}" class="focus-ring inline-flex items-center gap-2 rounded-md px-3.5 py-2 text-sm font-semibold text-navy-800 transition-colors hover:bg-navy-50">
                            Reset
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>

    @if ($alumni->isNotEmpty())
        <div class="mt-8 overflow-hidden rounded-lg border border-navy-100 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="border-b border-navy-100 bg-navy-50/60 text-xs uppercase tracking-wider text-ink-soft">
                            <th class="px-6 py-3.5 font-semibold">Alumni</th>
                            <th class="px-6 py-3.5 font-semibold">Batch</th>
                            <th class="px-6 py-3.5 font-semibold">Grad Year</th>
                            <th class="px-6 py-3.5 font-semibold">Profession</th>
                            <th class="px-6 py-3.5 font-semibold">Organization</th>
                            <th class="px-6 py-3.5 font-semibold">Location</th>
                            <th class="px-6 py-3.5 font-semibold">Status</th>
                            <th class="px-6 py-3.5 font-semibold">Featured</th>
                            <th class="px-6 py-3.5 text-right font-semibold">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-navy-100">
                        @foreach ($alumni as $alumnus)
                            <tr class="transition-colors hover:bg-cream/70">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        @if ($alumnus->profile_photo_url)
                                            <img src="{{ $alumnus->profile_photo_url }}" alt="" class="h-10 w-10 shrink-0 rounded-full object-cover">
                                        @else
                                            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-navy-900 font-serif text-xs font-semibold text-gold-300" aria-hidden="true">
                                                {{ \Illuminate\Support\Str::initials($alumnus->full_name) }}
                                            </span>
                                        @endif
                                        <div>
                                            <a href="{{ route('admin.alumni.show', $alumnus) }}" class="focus-ring rounded font-semibold text-navy-950 transition-colors hover:text-maroon-700">
                                                {{ $alumnus->full_name }}
                                            </a>
                                            @if ($alumnus->student_id)
                                                <p class="text-xs text-ink-soft">{{ $alumnus->student_id }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-navy-950">{{ $alumnus->batch ?? '—' }}</td>
                                <td class="px-6 py-4 text-navy-950">{{ $alumnus->graduation_year ?? '—' }}</td>
                                <td class="px-6 py-4 text-navy-950">{{ $alumnus->profession ?? '—' }}</td>
                                <td class="px-6 py-4 text-navy-950">{{ $alumnus->organization ?? '—' }}</td>
                                <td class="px-6 py-4 text-ink-soft">{{ $alumnus->location ?? '—' }}</td>
                                <td class="px-6 py-4">
                                    @if ($alumnus->status === 'active')
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
                                <td class="px-6 py-4">
                                    @if ($alumnus->is_featured)
                                        <span class="inline-flex rounded-full bg-gold-500/20 px-2.5 py-1 text-xs font-semibold text-gold-700">Featured</span>
                                    @else
                                        <span class="text-xs text-ink-soft">—</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-end gap-1">
                                        <a href="{{ route('admin.alumni.show', $alumnus) }}" class="focus-ring inline-flex h-8 w-8 items-center justify-center rounded-md text-navy-600 transition-colors hover:bg-navy-50 hover:text-navy-900" aria-label="View {{ $alumnus->full_name }}">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.5 12S6 5.5 12 5.5 21.5 12 21.5 12 18 18.5 12 18.5 2.5 12 2.5 12z" />
                                            </svg>
                                        </a>
                                        <a href="{{ route('admin.alumni.edit', $alumnus) }}" class="focus-ring inline-flex h-8 w-8 items-center justify-center rounded-md text-navy-600 transition-colors hover:bg-navy-50 hover:text-navy-900" aria-label="Edit {{ $alumnus->full_name }}">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.4-9.4a2 2 0 112.8 2.8L11 15l-4 1 1-4 9.6-9.4z" />
                                            </svg>
                                        </a>
                                        <form method="POST" action="{{ route('admin.alumni.destroy', $alumnus) }}" onsubmit="return confirm('Delete {{ addslashes($alumnus->full_name) }}? This cannot be undone.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="focus-ring inline-flex h-8 w-8 items-center justify-center rounded-md text-maroon-600 transition-colors hover:bg-maroon-50 hover:text-maroon-800" aria-label="Delete {{ $alumnus->full_name }}">
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
                {{ $alumni->links() }}
            </div>
        </div>
    @else
        <div class="mt-8">
            <x-empty-state
                title="No alumni found"
                description="No records match your current filters. Adjust the filters or add a new alumni record to get started."
                action_label="Add Alumni"
                action_href="{{ route('admin.alumni.create') }}"
            />
        </div>
    @endif
</x-layouts.admin>