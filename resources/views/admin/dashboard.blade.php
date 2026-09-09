<x-layouts.admin title="Executive Dashboard">
    @php
        $hour = now()->format('H');
        $greeting = $hour < 12 ? 'Good morning' : ($hour < 18 ? 'Good afternoon' : 'Good evening');
        $totalPendingActions = $applicationPendingCount + $unreadMessageCount + $pendingCorrectionCount;
    @endphp

    {{-- Welcome Executive Header --}}
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-navy-950 via-navy-900 to-maroon-950 p-6 sm:p-8 text-white shadow-xl ring-1 ring-white/10 mb-8">
        {{-- Ambient decorative glow --}}
        <div class="pointer-events-none absolute -right-16 -top-16 h-64 w-64 rounded-full bg-gold-500/10 blur-3xl"></div>
        <div class="pointer-events-none absolute -left-16 -bottom-16 h-64 w-64 rounded-full bg-maroon-500/15 blur-3xl"></div>

        <div class="relative flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div class="space-y-2">
                <div class="flex items-center gap-2 text-xs font-semibold uppercase tracking-widest text-gold-300">
                    <span class="flex h-2 w-2 rounded-full bg-emerald-400 animate-ping"></span>
                    <span>EDAA Executive Terminal · {{ now()->format('l, F j, Y') }}</span>
                </div>
                <h1 class="font-serif text-3xl sm:text-4xl font-bold tracking-tight text-white">
                    {{ $greeting }}, {{ Auth::user()->name }}
                </h1>
                <p class="text-sm text-navy-200 max-w-xl leading-relaxed">
                    Here is the operational status of the English Department Alumni Association today.
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <a
                    href="{{ route('admin.membership-applications.index') }}"
                    class="focus-ring inline-flex items-center gap-2 rounded-xl bg-white/10 hover:bg-white/20 border border-white/20 px-4 py-2.5 text-xs font-semibold text-white backdrop-blur-md transition-all duration-200 shadow-sm hover:scale-102"
                >
                    <svg class="h-4 w-4 text-gold-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span>Applications ({{ $applicationPendingCount }})</span>
                </a>

                <a
                    href="{{ route('admin.events.create') }}"
                    class="focus-ring inline-flex items-center gap-2 rounded-xl bg-gold-500 hover:bg-gold-400 text-navy-950 px-4 py-2.5 text-xs font-bold transition-all duration-200 shadow-md shadow-gold-500/20 hover:scale-102"
                >
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    <span>+ New Event</span>
                </a>
            </div>
        </div>
    </div>

    {{-- Urgent Attention Notification Banner (if any pending items) --}}
    @if ($totalPendingActions > 0)
        <div class="mb-8 rounded-2xl bg-amber-500/10 border border-amber-500/30 p-4 sm:p-5 text-navy-900 shadow-xs backdrop-blur-sm">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="flex items-center gap-3.5">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-amber-500 text-white shadow-sm">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </span>
                    <div>
                        <h2 class="text-sm font-bold text-navy-950">
                            {{ $totalPendingActions }} Action {{ Str::plural('Item', $totalPendingActions) }} Requiring Administrative Attention
                        </h2>
                        <p class="text-xs text-navy-600">
                            Members and alumni are waiting for verification, correction, or replies.
                        </p>
                    </div>
                </div>

                <div class="flex flex-wrap items-center gap-2">
                    @if ($applicationPendingCount > 0)
                        <a href="{{ route('admin.membership-applications.index') }}" class="inline-flex items-center gap-1.5 rounded-lg bg-amber-100/90 hover:bg-amber-200 text-amber-950 px-3 py-1.5 text-xs font-semibold transition">
                            <span>{{ $applicationPendingCount }} Applications</span>
                            <span>→</span>
                        </a>
                    @endif

                    @if ($pendingCorrectionCount > 0)
                        <a href="{{ route('admin.correction-requests.index') }}" class="inline-flex items-center gap-1.5 rounded-lg bg-rose-100/90 hover:bg-rose-200 text-rose-950 px-3 py-1.5 text-xs font-semibold transition">
                            <span>{{ $pendingCorrectionCount }} Corrections</span>
                            <span>→</span>
                        </a>
                    @endif

                    @if ($unreadMessageCount > 0)
                        <a href="{{ route('admin.messages.index') }}" class="inline-flex items-center gap-1.5 rounded-lg bg-blue-100/90 hover:bg-blue-200 text-blue-950 px-3 py-1.5 text-xs font-semibold transition">
                            <span>{{ $unreadMessageCount }} Inquiries</span>
                            <span>→</span>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    @endif

    {{-- Domain 1: Community & Membership KPIs --}}
    <div class="mb-10">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h2 class="font-serif text-xl font-bold tracking-tight text-navy-950">Community & Directory</h2>
                <p class="text-xs text-navy-500">Alumni enrollment, verified members, and incoming applications</p>
            </div>
            <a href="{{ route('admin.alumni.index') }}" class="text-xs font-semibold text-maroon-700 hover:text-maroon-900 transition flex items-center gap-1">
                <span>View Directory</span>
                <span>→</span>
            </a>
        </div>

        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <x-admin.stat-card
                label="Total Alumni"
                value="{{ number_format($alumniCount) }}"
                hint="Active alumni records"
                href="{{ route('admin.alumni.index') }}"
                icon="M17 20h5v-2a3 3 0 00-5.4-1.7M9 20H4v-2a3 3 0 015.4-1.7M16 3.1a3 3 0 110 5.8M11 7a3 3 0 11-6 0 3 3 0 016 0z"
            />
            <x-admin.stat-card
                label="Registered Members"
                value="{{ number_format($membershipActiveCount) }}"
                hint="{{ number_format($membershipLifetimeCount) }} lifetime members"
                href="{{ route('admin.members.index') }}"
                icon="M12 4.35a2.65 2.65 0 110 5.3 2.65 2.65 0 010-5.3zM5 21v-1.6A5.4 5.4 0 0110.4 14h3.2A5.4 5.4 0 0119 19.4V21m2-9.5l1.6 1.6M21 5.5L19.4 7M3 11.5L4.6 13.1M5 5.5L6.6 7.1"
            />
            <x-admin.stat-card
                label="Public Members"
                value="{{ number_format($publicMemberCount) }}"
                hint="Visible in directory"
                href="{{ route('admin.members.index') }}"
                icon="M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
            />
            <x-admin.stat-card
                label="Pending Applications"
                value="{{ number_format($applicationPendingCount) }}"
                hint="{{ number_format($applicationUnderReviewCount) }} under active review"
                href="{{ route('admin.membership-applications.index') }}"
                badge="{{ $applicationPendingCount > 0 ? 'Action' : null }}"
                accent="{{ $applicationPendingCount > 0 }}"
                icon="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"
            />
            <x-admin.stat-card
                label="Correction Requests"
                value="{{ number_format($pendingCorrectionCount) }}"
                hint="Alumni profile edits"
                href="{{ route('admin.correction-requests.index') }}"
                icon="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
            />
        </div>
    </div>

    {{-- Domain 2: Financial Health & Treasury --}}
    <div class="mb-10">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h2 class="font-serif text-xl font-bold tracking-tight text-navy-950">Financial Health & Treasury</h2>
                <p class="text-xs text-navy-500">Manual dues collections, association expenses, and current ledger balance</p>
            </div>
            <a href="{{ route('admin.finance.index') }}" class="text-xs font-semibold text-maroon-700 hover:text-maroon-900 transition flex items-center gap-1">
                <span>Detailed Ledger</span>
                <span>→</span>
            </a>
        </div>

        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <x-admin.stat-card
                label="Total Collections"
                value="৳{{ number_format($totalCollections) }}"
                hint="{{ number_format($validPaymentCount) }} verified receipts"
                href="{{ route('admin.payments.index') }}"
                icon="M3 6h18v12H3V6zm0 3h18m-4 6h2"
                accent
            />
            <x-admin.stat-card
                label="Month Collections"
                value="৳{{ number_format($collectionsThisMonth) }}"
                hint="{{ now()->format('F Y') }}"
                href="{{ route('admin.payments.index') }}"
                icon="M8 7V3m8 4V3M4 11h16M5 5h14a1 1 0 011 1v13a1 1 0 01-1 1H5a1 1 0 01-1-1V6a1 1 0 011-1z"
            />
            <x-admin.stat-card
                label="Association Expenses"
                value="{{ \App\Services\FinanceService::formatBalance((float) $totalExpenses) }}"
                hint="Total expenditures recorded"
                href="{{ route('admin.expenses.index') }}"
                icon="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
            />
            <x-admin.stat-card
                label="Net Balance"
                value="{{ \App\Services\FinanceService::formatBalance((float) $currentBalance) }}"
                hint="Collections less expenses"
                href="{{ route('admin.finance.index') }}"
                icon="M3 12h4l2-6 4 12 2-6h6"
            />
        </div>
    </div>

    {{-- Live Activity & Operational Feeds (2x2 Grid) --}}
    <div class="grid gap-6 lg:grid-cols-2 mb-10">
        {{-- Card 1: Recent Membership Applications --}}
        <div class="rounded-3xl bg-white border border-navy-100 p-6 shadow-sm">
            <div class="flex items-center justify-between pb-4 border-b border-navy-100">
                <div class="flex items-center gap-2.5">
                    <span class="flex h-8 w-8 items-center justify-center rounded-xl bg-amber-100 text-amber-800 font-bold text-xs">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </span>
                    <div>
                        <h2 class="font-serif text-base font-bold text-navy-950">Recent Applications</h2>
                        <p class="text-[11px] text-navy-500">Prospective alumni awaiting review</p>
                    </div>
                </div>
                <a href="{{ route('admin.membership-applications.index') }}" class="text-xs font-semibold text-navy-600 hover:text-navy-950 transition">
                    View All →
                </a>
            </div>

            <div class="mt-4 divide-y divide-navy-50">
                @forelse ($recentApplications as $app)
                    <div class="py-3 flex items-center justify-between gap-3 group hover:bg-slate-50/80 rounded-xl px-2 transition">
                        <div class="min-w-0">
                            <p class="text-xs font-bold text-navy-900 truncate">{{ $app->full_name }}</p>
                            <p class="text-[11px] text-navy-500">
                                {{ $app->membershipType?->name ?? 'Membership' }} · Batch {{ $app->batch ?? 'N/A' }}
                            </p>
                        </div>
                        <div class="flex items-center gap-2 shrink-0">
                            <span class="rounded-full px-2 py-0.5 text-[10px] font-semibold {{ $app->isPending() ? 'bg-amber-100 text-amber-800' : ($app->isApproved() ? 'bg-emerald-100 text-emerald-800' : 'bg-navy-100 text-navy-700') }}">
                                {{ ucfirst($app->status->value ?? 'Pending') }}
                            </span>
                            <a href="{{ route('admin.membership-applications.show', $app) }}" class="text-xs font-semibold text-maroon-700 hover:text-maroon-900 group-hover:translate-x-0.5 transition">
                                Review →
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="py-8 text-center text-xs text-navy-400">
                        No pending membership applications found.
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Card 2: Recent Payments & Receipts --}}
        <div class="rounded-3xl bg-white border border-navy-100 p-6 shadow-sm">
            <div class="flex items-center justify-between pb-4 border-b border-navy-100">
                <div class="flex items-center gap-2.5">
                    <span class="flex h-8 w-8 items-center justify-center rounded-xl bg-emerald-100 text-emerald-800 font-bold text-xs">
                        ৳
                    </span>
                    <div>
                        <h2 class="font-serif text-base font-bold text-navy-950">Recent Collections</h2>
                        <p class="text-[11px] text-navy-500">Audited dues and registration payments</p>
                    </div>
                </div>
                <a href="{{ route('admin.payments.index') }}" class="text-xs font-semibold text-navy-600 hover:text-navy-950 transition">
                    View All →
                </a>
            </div>

            <div class="mt-4 divide-y divide-navy-50">
                @forelse ($recentPayments as $payment)
                    <div class="py-3 flex items-center justify-between gap-3 group hover:bg-slate-50/80 rounded-xl px-2 transition">
                        <div class="min-w-0">
                            <p class="text-xs font-bold text-navy-900 truncate">
                                {{ $payment->membership?->alumni?->full_name ?? $payment->payment_number }}
                            </p>
                            <p class="text-[11px] text-navy-500">
                                {{ $payment->payment_number }} · {{ $payment->paid_at?->format('M d, Y') ?? $payment->created_at->format('M d, Y') }}
                            </p>
                        </div>
                        <div class="flex items-center gap-3 shrink-0">
                            <span class="font-serif text-sm font-bold text-navy-950">
                                {{ $payment->formattedAmount() }}
                            </span>
                            <a href="{{ route('admin.payments.show', $payment) }}" class="text-xs font-semibold text-maroon-700 hover:text-maroon-900 group-hover:translate-x-0.5 transition">
                                View →
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="py-8 text-center text-xs text-navy-400">
                        No recent payments recorded.
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Card 3: Upcoming Events & Calendar --}}
        <div class="rounded-3xl bg-white border border-navy-100 p-6 shadow-sm">
            <div class="flex items-center justify-between pb-4 border-b border-navy-100">
                <div class="flex items-center gap-2.5">
                    <span class="flex h-8 w-8 items-center justify-center rounded-xl bg-gold-100 text-gold-800 font-bold text-xs">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3M4 11h16M5 5h14a1 1 0 011 1v13a1 1 0 01-1 1H5a1 1 0 01-1-1V6a1 1 0 011-1z" />
                        </svg>
                    </span>
                    <div>
                        <h2 class="font-serif text-base font-bold text-navy-950">Upcoming Events</h2>
                        <p class="text-[11px] text-navy-500">Scheduled gatherings & seminars</p>
                    </div>
                </div>
                <a href="{{ route('admin.events.index') }}" class="text-xs font-semibold text-navy-600 hover:text-navy-950 transition">
                    View All →
                </a>
            </div>

            <div class="mt-4 divide-y divide-navy-50">
                @forelse ($upcomingEvents as $event)
                    <div class="py-3 flex items-center justify-between gap-3 group hover:bg-slate-50/80 rounded-xl px-2 transition">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="flex flex-col items-center justify-center h-10 w-10 rounded-xl bg-navy-50 border border-navy-100 text-navy-900 shrink-0">
                                <span class="text-[9px] font-bold uppercase text-maroon-700">{{ $event->event_date?->format('M') }}</span>
                                <span class="text-sm font-extrabold">{{ $event->event_date?->format('d') }}</span>
                            </div>
                            <div class="min-w-0">
                                <p class="text-xs font-bold text-navy-900 truncate">{{ $event->title }}</p>
                                <p class="text-[11px] text-navy-500 truncate">{{ $event->venue ?? 'Venue TBA' }}</p>
                            </div>
                        </div>
                        <a href="{{ route('admin.events.edit', $event) }}" class="text-xs font-semibold text-maroon-700 hover:text-maroon-900 shrink-0 group-hover:translate-x-0.5 transition">
                            Edit →
                        </a>
                    </div>
                @empty
                    <div class="py-8 text-center text-xs text-navy-400">
                        No upcoming events scheduled.
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Card 4: Contact Inquiries --}}
        <div class="rounded-3xl bg-white border border-navy-100 p-6 shadow-sm">
            <div class="flex items-center justify-between pb-4 border-b border-navy-100">
                <div class="flex items-center gap-2.5">
                    <span class="flex h-8 w-8 items-center justify-center rounded-xl bg-blue-100 text-blue-800 font-bold text-xs">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </span>
                    <div>
                        <h2 class="font-serif text-base font-bold text-navy-950">Recent Inquiries</h2>
                        <p class="text-[11px] text-navy-500">Contact submissions from alumni & visitors</p>
                    </div>
                </div>
                <a href="{{ route('admin.messages.index') }}" class="text-xs font-semibold text-navy-600 hover:text-navy-950 transition">
                    View All →
                </a>
            </div>

            <div class="mt-4 divide-y divide-navy-50">
                @forelse ($recentMessages as $message)
                    <div class="py-3 flex items-center justify-between gap-3 group hover:bg-slate-50/80 rounded-xl px-2 transition">
                        <div class="flex items-center gap-2.5 min-w-0">
                            @if ($message->isUnread())
                                <span class="h-2 w-2 rounded-full bg-blue-600 shrink-0"></span>
                            @else
                                <span class="h-2 w-2 rounded-full bg-navy-200 shrink-0"></span>
                            @endif
                            <div class="min-w-0">
                                <p class="text-xs font-bold text-navy-900 truncate">{{ $message->name }}</p>
                                <p class="text-[11px] text-navy-500 truncate">{{ $message->subject ?: 'No subject' }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 shrink-0">
                            <span class="text-[10px] text-navy-400">{{ $message->created_at->diffForHumans(null, true) }}</span>
                            <a href="{{ route('admin.messages.show', $message) }}" class="text-xs font-semibold text-maroon-700 hover:text-maroon-900 group-hover:translate-x-0.5 transition">
                                Open →
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="py-8 text-center text-xs text-navy-400">
                        No contact messages received yet.
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Domain 3: Content & Publication Management --}}
    <div class="mb-10">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h2 class="font-serif text-xl font-bold tracking-tight text-navy-950">Editorial & Publishing</h2>
                <p class="text-xs text-navy-500">Articles, alumni success stories, galleries, and publications</p>
            </div>
        </div>

        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <x-admin.stat-card
                label="News Articles"
                value="{{ number_format($newsPublishedCount) }}"
                hint="{{ $newsDraftCount }} unpublished drafts"
                href="{{ route('admin.news.index') }}"
                icon="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"
            />
            <x-admin.stat-card
                label="Alumni Stories"
                value="{{ number_format($storyPublishedCount) }}"
                hint="{{ $storyDraftCount }} draft stories"
                href="{{ route('admin.stories.index') }}"
                icon="M9.6 4C5.4 5.4 3 8.6 3 13.2V20h6.8v-6.8H6.4c0-2.8 1.4-4.9 4.2-5.8L9.6 4zm11 0c-4.2 1.4-6.6 4.6-6.6 9.2V20h6.8v-6.8h-3.4c0-2.8 1.4-4.9 4.2-5.8L20.6 4z"
            />
            <x-admin.stat-card
                label="Press Releases"
                value="{{ number_format($pressReleasePublishedCount) }}"
                hint="{{ $pressReleaseDraftCount }} drafts"
                href="{{ route('admin.press-releases.index') }}"
                icon="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"
            />
            <x-admin.stat-card
                label="Publications"
                value="{{ number_format($publicationPublishedCount) }}"
                hint="{{ $publicationDraftCount }} drafts in review"
                href="{{ route('admin.publications.index') }}"
                icon="M12 6.3v11.4m0-11.4A3.2 3.2 0 009.5 3.5H6.5v13h3a3.2 3.2 0 013 2.8m-.5-12.9a3.2 3.2 0 012.5-2.8h3v13h-3a3.2 3.2 0 00-3 2.8m0-12.9v11.4"
            />
        </div>
    </div>
</x-layouts.admin>