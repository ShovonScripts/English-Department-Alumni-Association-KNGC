<x-layouts.admin title="Dashboard">
    <div class="mb-8 flex flex-col gap-2">
        <h1 class="font-serif text-3xl font-semibold tracking-tight text-navy-950">Dashboard</h1>
        <p class="text-sm text-ink-soft">
            Welcome to the Association admin area. Overview and placeholder statistics are shown below — content modules will be added in upcoming releases.
        </p>
    </div>

    {{-- Statistics --}}
    <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6">
        <x-admin.stat-card
            label="Total Alumni"
            value="{{ number_format($alumniCount) }}"
            hint="Active directory records"
            icon="M17 20h5v-2a3 3 0 00-5.4-1.7M9 20H4v-2a3 3 0 015.4-1.7M16 3.1a3 3 0 110 5.8M11 7a3 3 0 11-6 0 3 3 0 016 0z"
        />
        <x-admin.stat-card
            label="Active Committee"
            value="{{ number_format($committeeCount) }}"
            hint="Executive committee members"
            icon="M9 12l2 2 4-4m5.6 3.6a9 9 0 11-12.7-12.7 9 9 0 0112.7 12.7z"
        />
        <x-admin.stat-card
            label="Upcoming Events"
            value="{{ number_format($eventCount) }}"
            hint="Published events"
            icon="M8 7V3m8 4V3M4 11h16M5 5h14a1 1 0 011 1v13a1 1 0 01-1 1H5a1 1 0 01-1-1V6a1 1 0 011-1z"
        />
        <x-admin.stat-card
            label="Published News"
            value="{{ number_format($newsPublishedCount) }}"
            hint="{{ $newsDraftCount }} drafts"
            icon="M3 6a2 2 0 012-2h8l2 2h6a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V6z"
        />
        <x-admin.stat-card
            label="Published Stories"
            value="{{ number_format($storyPublishedCount) }}"
            hint="{{ $storyDraftCount }} drafts"
            icon="M9.6 4C5.4 5.4 3 8.6 3 13.2V20h6.8v-6.8H6.4c0-2.8 1.4-4.9 4.2-5.8L9.6 4zm11 0c-4.2 1.4-6.6 4.6-6.6 9.2V20h6.8v-6.8h-3.4c0-2.8 1.4-4.9 4.2-5.8L20.6 4z"
        />
        <x-admin.stat-card
            label="Gallery Albums"
            value="{{ number_format($albumPublishedCount) }}"
            hint="{{ $photoCount }} total photos"
            icon="M3 5a2 2 0 012-2h14a2 2 0 012 2v14a2 2 0 01-2 2H5a2 2 0 01-2-2V5zm6 5a2 2 0 11-4 0 2 2 0 014 0zm-2 8l4-4 3 3 4-4 4 4"
        />
        <x-admin.stat-card
            label="Publications"
            value="{{ number_format($publicationPublishedCount) }}"
            hint="{{ $publicationDraftCount }} drafts"
            icon="M12 6.3v11.4m0-11.4A3.2 3.2 0 009.5 3.5H6.5v13h3a3.2 3.2 0 013 2.8m-.5-12.9a3.2 3.2 0 012.5-2.8h3v13h-3a3.2 3.2 0 00-3 2.8m0-12.9v11.4"
        />
        <x-admin.stat-card
            label="Unread Messages"
            value="{{ number_format($unreadMessageCount) }}"
            hint="Awaiting review"
            icon="M8 10h8m-8 4h5M3 5a2 2 0 012-2h14a2 2 0 012 2v10a2 2 0 01-2 2H8l-4 4V5z"
        />
        <x-admin.stat-card
            label="Total Members"
            value="{{ number_format($membershipTotalCount) }}"
            hint="Registered memberships"
            icon="M12 4.35a2.65 2.65 0 110 5.3 2.65 2.65 0 010-5.3zM5 21v-1.6A5.4 5.4 0 0110.4 14h3.2A5.4 5.4 0 0119 19.4V21m2-9.5l1.6 1.6M21 5.5L19.4 7M3 11.5L4.6 13.1M5 5.5L6.6 7.1"
        />
        <x-admin.stat-card
            label="Active Members"
            value="{{ number_format($membershipActiveCount) }}"
            hint="{{ number_format($membershipPendingCount) }} pending approval"
            icon="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
        />
        <x-admin.stat-card
            label="Lifetime Members"
            value="{{ number_format($membershipLifetimeCount) }}"
            hint="Active lifetime classifications"
            icon="M12 3l2.7 5.6 6.3.9-4.5 4.4 1 6.1-5.5-2.9-5.5 2.9 1-6.1L3 9.5l6.3-.9L12 3z"
        />
        <x-admin.stat-card
            label="Active Fee Plans"
            value="{{ number_format($feePlanActiveCount) }}"
            hint="{{ number_format($feePlanCurrentCount) }} currently applicable"
            icon="M12 1v22m5.5-18.2c-.8-1.7-3-2.8-5.5-2.8C9 2 7 3.4 7 5.5 7 11 17 10 17 15.7c0 2.1-2 3.5-5 3.5s-4.7-1.1-5.5-2.8"
        />
        <a href="{{ route('admin.membership-applications.index') }}" class="card-lift block rounded-lg border border-navy-100 bg-white p-5 shadow-sm transition-shadow hover:shadow-md">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Applications</p>
                    <p class="mt-2 font-serif text-3xl font-semibold tracking-tight text-navy-950">{{ number_format($applicationPendingCount) }}</p>
                    <p class="mt-1 text-xs text-ink-soft">Pending Applications</p>
                </div>
                <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-md bg-gold-500 text-navy-950">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                    </svg>
                </span>
            </div>
            <div class="mt-3 flex items-center gap-2 text-xs text-ink-soft">
                <span class="text-maroon-700 font-semibold">Review Applications</span>
                <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                </svg>
            </div>
        </a>
        <x-admin.stat-card
            label="Public Members"
            value="{{ number_format($publicMemberCount) }}"
            hint="Currently visible on directory"
            icon="M12 4.35a2.65 2.65 0 110 5.3 2.65 2.65 0 010-5.3zM5 21v-1.6A5.4 5.4 0 0110.4 14h3.2A5.4 5.4 0 0119 19.4V21m2-9.5l1.6 1.6M21 5.5L19.4 7M3 11.5L4.6 13.1M5 5.5L6.6 7.1"
        />
    </div>

    {{-- Collections summary (organizational dues, not website revenue) --}}
    <section class="mt-10">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <h2 class="font-serif text-xl font-semibold text-navy-950">Financial Overview</h2>
            <a href="{{ route('admin.payments.index') }}" class="focus-ring inline-flex items-center gap-2 rounded-md px-3 py-1.5 text-sm font-semibold text-maroon-700 transition-colors hover:bg-maroon-50">
                View Payments →
            </a>
        </div>
        <p class="mt-1 text-sm text-ink-soft">Manually collected organizational dues recorded by administrators.</p>

        <div class="mt-6 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
            <x-admin.stat-card
                label="Total Collections"
                value="৳{{ number_format($totalCollections) }}"
                hint="Paid + partial, excl. void/waived"
                icon="M3 6h18v12H3V6zm0 3h18m-4 6h2"
                accent
            />
            <x-admin.stat-card
                label="Collections This Month"
                value="৳{{ number_format($collectionsThisMonth) }}"
                hint="{{ now()->format('F Y') }}"
                icon="M8 7V3m8 4V3M4 11h16M5 5h14a1 1 0 011 1v13a1 1 0 01-1 1H5a1 1 0 01-1-1V6a1 1 0 011-1z"
            />
            <x-admin.stat-card
                label="Expenses This Month"
                value="{{ \App\Services\FinanceService::formatBalance((float) $expensesThisMonth) }}"
                hint="{{ now()->format('F Y') }}"
                icon="M12 8v8m-4-4h8M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
            />
            <x-admin.stat-card
                label="Total Expenses"
                value="{{ \App\Services\FinanceService::formatBalance((float) $totalExpenses) }}"
                hint="Recorded, excl. void"
                icon="M3 3h2l2 12h10l2-8H6M9 20a1 1 0 100 2 1 1 0 000-2zm8 0a1 1 0 100 2 1 1 0 000-2z"
            />
            <x-admin.stat-card
                label="Current Balance"
                value="{{ \App\Services\FinanceService::formatBalance((float) $currentBalance) }}"
                hint="Collections minus expenses"
                icon="M3 12h4l2-6 4 12 2-6h6"
            />
            <x-admin.stat-card
                label="Outstanding Fees"
                value="৳{{ number_format($outstandingFees) }}"
                hint="Active members with applicable fees"
                icon="M12 9v4m0 4h.01M10.3 3.9L1.8 18a2 2 0 001.7 3h17a2 2 0 001.7-3L13.7 3.9a2 2 0 00-3.4 0z"
            />
            <x-admin.stat-card
                label="Paid Members"
                value="{{ number_format($paidMembers) }}"
                hint="Obligations fully satisfied"
                icon="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
            />
        </div>
    </section>

    {{-- Getting started --}}
    <section class="mt-10">
        <h2 class="font-serif text-xl font-semibold text-navy-950">Getting Started</h2>
        <p class="mt-1 text-sm text-ink-soft">
            This foundation is ready to grow. Here is what is already in place.
        </p>

        <div class="mt-6 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ([
                ['title' => 'Public website', 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6', 'text' => 'Ten public pages, responsive design, SEO metadata, and a reusable component library.'],
                ['title' => 'Design system', 'icon' => 'M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.5M7 21v-4', 'text' => 'Academic navy, burgundy, and gold tokens with serif headings and readable sans-serif body text.'],
                ['title' => 'Admin shell', 'icon' => 'M12 6.3v11.4m0-11.4A3.2 3.2 0 009.5 3.5H6.5v13h3a3.2 3.2 0 013 2.8m-.5-12.9a3.2 3.2 0 012.5-2.8h3v13h-3a3.2 3.2 0 00-3 2.8m0-12.9v11.4', 'text' => 'Sidebar, top navigation, and dashboard ready for alumni, events, news, and message modules.'],
            ] as $card)
                <div class="card-lift flex gap-4 rounded-lg border border-navy-100 bg-white p-6 shadow-sm">
                    <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-md bg-navy-900 text-gold-300">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $card['icon'] }}" />
                        </svg>
                    </span>
                    <div>
                        <h3 class="font-semibold text-navy-950">{{ $card['title'] }}</h3>
                        <p class="mt-1 text-sm leading-relaxed text-ink-soft">{{ $card['text'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    {{-- Recent activity --}}
    <section class="mt-10">
        <h2 class="font-serif text-xl font-semibold text-navy-950">Recent Activity</h2>
        <div class="mt-6">
            <x-empty-state
                title="No activity yet"
                description="Once content modules are connected, recent events, news, and messages will appear here."
            />
        </div>
    </section>
</x-layouts.admin>