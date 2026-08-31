<x-layouts.admin title="Membership Types">
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="font-serif text-3xl font-semibold tracking-tight text-navy-950">Membership Types</h1>
            <p class="mt-1 text-sm text-ink-soft">
                Membership classifications from the EDAA-KNGC Constitution (Article 4).
            </p>
        </div>
        <x-button href="{{ route('admin.membership-types.create') }}" variant="gold">Add Type</x-button>
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

    @if ($types->isNotEmpty())
        <div class="overflow-hidden rounded-lg border border-navy-100 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="border-b border-navy-100 bg-navy-50/60 text-xs uppercase tracking-wider text-ink-soft">
                            <th class="px-6 py-3.5 font-semibold">Name</th>
                            <th class="px-6 py-3.5 font-semibold">Slug</th>
                            <th class="px-6 py-3.5 font-semibold">Members</th>
                            <th class="px-6 py-3.5 font-semibold">Sort Order</th>
                            <th class="px-6 py-3.5 font-semibold">Status</th>
                            <th class="px-6 py-3.5 text-right font-semibold">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-navy-100">
                        @foreach ($types as $type)
                            <tr class="transition-colors hover:bg-cream/70">
                                <td class="px-6 py-4">
                                    <p class="font-semibold text-navy-950">{{ $type->name }}</p>
                                    @if ($type->description)
                                        <p class="mt-0.5 max-w-md truncate text-xs text-ink-soft">{{ $type->description }}</p>
                                    @endif
                                </td>
                                <td class="px-6 py-4 font-mono text-xs text-ink-soft">{{ $type->slug }}</td>
                                <td class="px-6 py-4 text-navy-950">{{ $type->memberships_count }}</td>
                                <td class="px-6 py-4 text-navy-950">{{ $type->sort_order }}</td>
                                <td class="px-6 py-4">
                                    @if ($type->is_active)
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
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-end gap-1">
                                        <a href="{{ route('admin.membership-types.edit', $type) }}" class="focus-ring inline-flex h-8 w-8 items-center justify-center rounded-md text-navy-600 transition-colors hover:bg-navy-50 hover:text-navy-900" aria-label="Edit {{ $type->name }}">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.4-9.4a2 2 0 112.8 2.8L11 15l-4 1 1-4 9.6-9.4z" />
                                            </svg>
                                        </a>
                                        @if ($type->memberships_count > 0)
                                            <span class="inline-flex h-8 w-8 cursor-not-allowed items-center justify-center rounded-md text-navy-300" title="In use — deactivate instead of deleting" aria-label="Delete disabled for {{ $type->name }}">
                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.8 12a2 2 0 01-2 1.8H7.8a2 2 0 01-2-1.8L5 7m5 4v6m4-6v6m-9-10h14M9 7V5a2 2 0 012-2h2a2 2 0 012 2v2" />
                                                </svg>
                                            </span>
                                        @else
                                            <form method="POST" action="{{ route('admin.membership-types.destroy', $type) }}" onsubmit="return confirm('Delete this membership type?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="focus-ring inline-flex h-8 w-8 items-center justify-center rounded-md text-maroon-600 transition-colors hover:bg-maroon-50 hover:text-maroon-800" aria-label="Delete {{ $type->name }}">
                                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.8 12a2 2 0 01-2 1.8H7.8a2 2 0 01-2-1.8L5 7m5 4v6m4-6v6m-9-10h14M9 7V5a2 2 0 012-2h2a2 2 0 012 2v2" />
                                                    </svg>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="mt-8">
            <x-empty-state
                title="No membership types yet"
                description="Create your first membership type classification."
                action_label="Add Type"
                action_href="{{ route('admin.membership-types.create') }}"
            />
        </div>
    @endif
</x-layouts.admin>
