<x-layouts.admin title="Committee Roles">
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="font-serif text-3xl font-semibold tracking-tight text-navy-950">Committee Roles</h1>
            <p class="mt-1 text-sm text-ink-soft">Define positions for committees. Use arrows to reorder by hierarchy.</p>
        </div>
        <a href="{{ route('admin.committee-types.index') }}" class="focus-ring inline-flex items-center gap-2 rounded-md px-3.5 py-2 text-sm font-semibold text-navy-800 transition-colors hover:bg-navy-50">&larr; Back to Committee Types</a>
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
        {{-- Roles List --}}
        <div class="lg:col-span-2">
            <section class="rounded-lg border border-navy-100 bg-white shadow-sm">
                <div class="border-b border-navy-100 px-6 py-4">
                    <h3 class="font-serif text-lg font-semibold text-navy-950">Roles ({{ $roles->count() }})</h3>
                </div>
                @if ($roles->isEmpty())
                    <div class="px-6 py-12 text-center text-sm text-ink-soft">No roles defined yet. Add one below.</div>
                @else
                    <ul class="divide-y divide-navy-100">
                        @foreach ($roles as $index => $role)
                            <li class="flex items-center justify-between gap-4 px-6 py-4 hover:bg-cream/50 transition-colors">
                                <div class="flex items-center gap-4">
                                    <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-navy-900 font-serif text-xs font-bold text-gold-300">
                                        {{ $index + 1 }}
                                    </span>
                                    <div>
                                        <p class="font-semibold text-navy-950">{{ $role->name }}</p>
                                        <p class="text-xs text-ink-soft font-mono">{{ $role->slug }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-1">
                                    {{-- Up Arrow --}}
                                    <form method="POST" action="{{ route('admin.committee-roles.up', $role) }}">
                                        @csrf
                                        <button
                                            type="submit"
                                            {{ $loop->first ? 'disabled' : '' }}
                                            class="focus-ring inline-flex h-8 w-8 items-center justify-center rounded-md transition-colors {{ $loop->first ? 'cursor-not-allowed text-navy-300' : 'text-navy-600 hover:bg-navy-50 hover:text-navy-900' }}"
                                            title="Move up"
                                        >
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7" /></svg>
                                        </button>
                                    </form>
                                    {{-- Down Arrow --}}
                                    <form method="POST" action="{{ route('admin.committee-roles.down', $role) }}">
                                        @csrf
                                        <button
                                            type="submit"
                                            {{ $loop->last ? 'disabled' : '' }}
                                            class="focus-ring inline-flex h-8 w-8 items-center justify-center rounded-md transition-colors {{ $loop->last ? 'cursor-not-allowed text-navy-300' : 'text-navy-600 hover:bg-navy-50 hover:text-navy-900' }}"
                                            title="Move down"
                                        >
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" /></svg>
                                        </button>
                                    </form>
                                    {{-- Delete --}}
                                    <form method="POST" action="{{ route('admin.committee-roles.destroy', $role) }}" onsubmit="return confirm('Delete \"{{ $role->name }}\" role?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="focus-ring inline-flex h-8 w-8 items-center justify-center rounded-md text-maroon-600 transition-colors hover:bg-maroon-50 hover:text-maroon-800" title="Delete">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                        </button>
                                    </form>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </section>
        </div>

        {{-- Add Role Form --}}
        <div>
            <section class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm">
                <h3 class="font-serif text-lg font-semibold text-navy-950">Add New Role</h3>
                <form method="POST" action="{{ route('admin.committee-roles.store') }}" class="mt-4 space-y-4">
                    @csrf
                    <div>
                        <label for="name" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Role Name *</label>
                        <input type="text" id="name" name="name" required placeholder="e.g. Joint Secretary" class="w-full rounded-md border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 placeholder-navy-400 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none">
                    </div>
                    <button type="submit" class="focus-ring w-full inline-flex items-center justify-center gap-2 rounded-lg bg-gold-500 px-5 py-2.5 text-sm font-semibold text-navy-950 shadow-sm transition-colors hover:bg-gold-400">Add Role</button>
                </form>
                <p class="mt-4 text-xs text-ink-soft">New roles are added to the bottom of the list. Use arrows to reorder.</p>
            </section>
        </div>
    </div>
</x-layouts.admin>
