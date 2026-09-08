<x-layouts.admin title="Activity Log">
    <div class="mb-8">
        <h1 class="font-serif text-3xl font-semibold tracking-tight text-navy-950">Activity Log</h1>
        <p class="mt-1 text-sm text-ink-soft">Track all administrator actions across the system.</p>
    </div>

    {{-- Filters --}}
    <div class="mb-6 rounded-lg border border-navy-100 bg-white p-4 shadow-sm">
        <form method="GET" class="flex flex-wrap items-end gap-4">
            <div class="flex-1 min-w-[200px]">
                <label for="user_id" class="mb-1 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Admin</label>
                <select id="user_id" name="user_id" class="focus-ring w-full rounded-md border border-navy-200 bg-white px-3 py-2 text-sm text-navy-950">
                    <option value="">All Admins</option>
                    @foreach ($admins as $admin)
                        <option value="{{ $admin->id }}" @selected(request('user_id') == $admin->id)>{{ $admin->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex-1 min-w-[200px]">
                <label for="action" class="mb-1 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Action</label>
                <select id="action" name="action" class="focus-ring w-full rounded-md border border-navy-200 bg-white px-3 py-2 text-sm text-navy-950">
                    <option value="">All Actions</option>
                    @foreach ($actions as $action)
                        <option value="{{ $action }}" @selected(request('action') === $action)>{{ ucfirst(str_replace('_', ' ', $action)) }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="focus-ring inline-flex items-center gap-2 rounded-lg bg-navy-900 px-4 py-2 text-sm font-semibold text-white transition-colors hover:bg-navy-800">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" /></svg>
                Filter
            </button>
            @if (request()->hasAny(['user_id', 'action']))
                <a href="{{ route('admin.activity-log.index') }}" class="focus-ring inline-flex items-center gap-2 rounded-lg border border-navy-200 px-4 py-2 text-sm font-semibold text-navy-700 transition-colors hover:bg-navy-50">
                    Clear
                </a>
            @endif
        </form>
    </div>

    <div class="overflow-hidden rounded-lg border border-navy-100 bg-white shadow-sm">
        @if ($logs->isEmpty())
            <div class="px-6 py-12 text-center text-sm text-ink-soft">No activity logs found.</div>
        @else
            <table class="min-w-full divide-y divide-navy-100">
                <thead class="bg-navy-50/50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-ink-soft">Admin</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-ink-soft">Action</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-ink-soft">Description</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-ink-soft">Time</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-ink-soft">IP</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-navy-100">
                    @foreach ($logs as $log)
                        <tr class="hover:bg-cream/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <div class="flex h-7 w-7 items-center justify-center rounded-full bg-navy-900 text-[10px] font-bold text-gold-300">
                                        {{ \Illuminate\Support\Str::initials($log->user?->name ?? 'System') }}
                                    </div>
                                    <span class="text-sm font-medium text-navy-950">{{ $log->user?->name ?? 'System' }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-semibold
                                    {{ match(true) {
                                        str_contains($log->action, 'login') => 'bg-emerald-100 text-emerald-700',
                                        str_contains($log->action, 'create') => 'bg-blue-100 text-blue-700',
                                        str_contains($log->action, 'update') || str_contains($log->action, 'toggle') => 'bg-gold-100 text-gold-700',
                                        str_contains($log->action, 'delete') => 'bg-maroon-100 text-maroon-700',
                                        default => 'bg-navy-100 text-navy-700',
                                    } }}">
                                    {{ ucfirst(str_replace('_', ' ', $log->action)) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-navy-950">{{ $log->description }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-ink-soft">{{ $log->created_at->diffForHumans() }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-xs text-ink-soft font-mono">{{ $log->ip_address ?? '-' }}</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="border-t border-navy-100 px-6 py-4">
                {{ $logs->links() }}
            </div>
        @endif
    </div>
</x-layouts.admin>
