<x-layouts.admin title="Messages">
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="font-serif text-3xl font-semibold tracking-tight text-navy-950">Messages</h1>
            <p class="mt-1 text-sm text-ink-soft">Manage contact form submissions.</p>
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

    <form method="GET" action="{{ route('admin.messages.index') }}" class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm">
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <div class="lg:col-span-3">
                <label for="search" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Search</label>
                <input
                    type="search"
                    id="search"
                    name="search"
                    value="{{ $filters['search'] ?? '' }}"
                    placeholder="Name, email, subject…"
                    class="w-full rounded-md border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 placeholder-navy-400 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none"
                >
            </div>

            <div class="flex items-end gap-3">
                <x-button type="submit" variant="navy">Search</x-button>
                <a href="{{ route('admin.messages.index') }}" class="focus-ring inline-flex items-center gap-2 rounded-md px-3.5 py-2 text-sm font-semibold text-navy-800 transition-colors hover:bg-navy-50">Reset</a>
            </div>
        </div>
    </form>

    <div class="mt-6 flex flex-wrap gap-2">
        <a href="{{ route('admin.messages.index', array_merge(['status' => 'all'], request()->except('status', 'page'))) }}" class="focus-ring inline-flex items-center gap-2 rounded-md px-3.5 py-2 text-sm font-semibold transition-colors {{ ($filters['status'] ?? 'all') === 'all' ? 'bg-navy-900 text-white' : 'text-navy-800 hover:bg-navy-50' }}">
            All
            @if ($unreadCount ?? 0)
                <span class="inline-flex h-5 min-w-5 items-center justify-center rounded-full bg-gold-500 px-1.5 text-xs font-bold text-navy-950">{{ $unreadCount }}</span>
            @endif
        </a>
        <a href="{{ route('admin.messages.index', array_merge(['status' => 'unread'], request()->except('status', 'page'))) }}" class="focus-ring inline-flex items-center gap-2 rounded-md px-3.5 py-2 text-sm font-semibold transition-colors {{ ($filters['status'] ?? '') === 'unread' ? 'bg-navy-900 text-white' : 'text-navy-800 hover:bg-navy-50' }}">
            Unread
        </a>
        <a href="{{ route('admin.messages.index', array_merge(['status' => 'read'], request()->except('status', 'page'))) }}" class="focus-ring inline-flex items-center gap-2 rounded-md px-3.5 py-2 text-sm font-semibold transition-colors {{ ($filters['status'] ?? '') === 'read' ? 'bg-navy-900 text-white' : 'text-navy-800 hover:bg-navy-50' }}">
            Read
        </a>
        <a href="{{ route('admin.messages.index', array_merge(['status' => 'archived'], request()->except('status', 'page'))) }}" class="focus-ring inline-flex items-center gap-2 rounded-md px-3.5 py-2 text-sm font-semibold transition-colors {{ ($filters['status'] ?? '') === 'archived' ? 'bg-navy-900 text-white' : 'text-navy-800 hover:bg-navy-50' }}">
            Archived
        </a>
    </div>

    @if ($messages->isNotEmpty())
        <div class="mt-6 overflow-hidden rounded-lg border border-navy-100 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="border-b border-navy-100 bg-navy-50/60 text-xs uppercase tracking-wider text-ink-soft">
                            <th class="px-6 py-3.5 font-semibold">From</th>
                            <th class="px-6 py-3.5 font-semibold">Subject</th>
                            <th class="px-6 py-3.5 font-semibold">Date</th>
                            <th class="px-6 py-3.5 font-semibold">Status</th>
                            <th class="px-6 py-3.5 text-right font-semibold">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-navy-100">
                        @foreach ($messages as $message)
                            <tr class="transition-colors hover:bg-cream/70 {{ $message->read_at ? '' : 'bg-gold-500/5' }}">
                                <td class="px-6 py-4">
                                    <a href="{{ route('admin.messages.show', $message) }}" class="focus-ring rounded text-sm font-semibold text-navy-950 transition-colors hover:text-maroon-700 {{ $message->read_at ? '' : 'font-bold' }}">
                                        {{ $message->name }}
                                    </a>
                                    <p class="mt-0.5 text-xs text-ink-soft">{{ $message->email }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    <a href="{{ route('admin.messages.show', $message) }}" class="text-sm text-navy-950 transition-colors hover:text-maroon-700 {{ $message->read_at ? '' : 'font-semibold' }}">
                                        {{ \Illuminate\Support\Str::limit($message->subject, 60) }}
                                    </a>
                                </td>
                                <td class="px-6 py-4 text-sm text-navy-950">{{ $message->created_at->format('M j, Y') }}</td>
                                <td class="px-6 py-4">
                                    @if (!$message->read_at)
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-gold-500/20 px-2.5 py-1 text-xs font-semibold text-gold-700">
                                            <span class="h-1.5 w-1.5 rounded-full bg-gold-500" aria-hidden="true"></span>
                                            UNREAD
                                        </span>
                                    @elseif ($message->archived_at)
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-navy-100 px-2.5 py-1 text-xs font-semibold text-navy-800">
                                            <span class="h-1.5 w-1.5 rounded-full bg-navy-600" aria-hidden="true"></span>
                                            Archived
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-100 px-2.5 py-1 text-xs font-semibold text-emerald-800">
                                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-600" aria-hidden="true"></span>
                                            Read
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-end gap-1">
                                        <a href="{{ route('admin.messages.show', $message) }}" class="focus-ring inline-flex h-8 w-8 items-center justify-center rounded-md text-navy-600 transition-colors hover:bg-navy-50 hover:text-navy-900" aria-label="View message from {{ $message->name }}">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.5 12S6 5.5 12 5.5 21.5 12 21.5 12 18 18.5 12 18.5 2.5 12 2.5 12z" />
                                            </svg>
                                        </a>
                                        <form method="POST" action="{{ route('admin.messages.destroy', $message) }}" onsubmit="return confirm('Delete this message from {{ addslashes($message->name) }}? This cannot be undone.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="focus-ring inline-flex h-8 w-8 items-center justify-center rounded-md text-maroon-600 transition-colors hover:bg-maroon-50 hover:text-maroon-800" aria-label="Delete message from {{ $message->name }}">
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
                {{ $messages->links() }}
            </div>
        </div>
    @else
        <div class="mt-8">
            <x-empty-state
                title="No messages found"
                description="No contact messages match your current filters. Adjust the filters or check back later."
            />
        </div>
    @endif
</x-layouts.admin>
