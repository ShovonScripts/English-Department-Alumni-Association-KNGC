@php
    use App\Models\ContactMessage;
    use App\Models\MembershipApplication;
    use App\Enums\ApplicationStatus;
    $unreadCount = ContactMessage::unread()->count();
    $pendingApplicationCount = MembershipApplication::where('status', ApplicationStatus::Pending)->count();

    $nav = [
        [
            'label' => 'Overview',
            'items' => [
                ['label' => 'Dashboard', 'route' => 'admin.dashboard', 'route_is' => 'admin.dashboard*', 'icon' => 'M4 5a2 2 0 012-2h12a2 2 0 012 2v14a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm4 3h8m-8 4h8m-8 4h4'],
                ['label' => 'Site Settings', 'route' => 'admin.settings.index', 'route_is' => 'admin.settings.*', 'icon' => 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z'],
            ],
        ],
        [
            'label' => 'Content',
            'items' => [
                ['label' => 'Events', 'route' => 'admin.events.index', 'route_is' => 'admin.events.*', 'icon' => 'M8 7V3m8 4V3M4 11h16M5 5h14a1 1 0 011 1v13a1 1 0 01-1 1H5a1 1 0 01-1-1V6a1 1 0 011-1z'],
                ['label' => 'News', 'route' => 'admin.news.index', 'route_is' => 'admin.news*', 'icon' => 'M3 6a2 2 0 012-2h8l2 2h6a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V6z'],
                ['label' => 'Stories', 'route' => 'admin.stories.index', 'route_is' => 'admin.stories.*', 'icon' => 'M9.6 4C5.4 5.4 3 8.6 3 13.2V20h6.8v-6.8H6.4c0-2.8 1.4-4.9 4.2-5.8L9.6 4zm11 0c-4.2 1.4-6.6 4.6-6.6 9.2V20h6.8v-6.8h-3.4c0-2.8 1.4-4.9 4.2-5.8L20.6 4z'],
                ['label' => 'Gallery', 'route' => 'admin.gallery.index', 'route_is' => 'admin.gallery*', 'icon' => 'M3 5a2 2 0 012-2h14a2 2 0 012 2v14a2 2 0 01-2 2H5a2 2 0 01-2-2V5zm6 5a2 2 0 11-4 0 2 2 0 014 0zm-2 8l4-4 3 3 4-4 4 4'],
                ['label' => 'Publications', 'route' => 'admin.publications.index', 'route_is' => 'admin.publications*', 'icon' => 'M12 6.3v11.4m0-11.4A3.2 3.2 0 009.5 3.5H6.5v13h3a3.2 3.2 0 013 2.8m-.5-12.9a3.2 3.2 0 012.5-2.8h3v13h-3a3.2 3.2 0 00-3 2.8m0-12.9v11.4'],
            ],
        ],
        [
            'label' => 'Community',
            'items' => [
                ['label' => 'Alumni', 'route' => 'admin.alumni.index', 'route_is' => 'admin.alumni.*', 'icon' => 'M17 20h5v-2a3 3 0 00-5.4-1.7M9 20H4v-2a3 3 0 015.4-1.7M16 3.1a3 3 0 110 5.8M11 7a3 3 0 11-6 0 3 3 0 016 0z'],
                ['label' => 'Members', 'route' => 'admin.members.index', 'route_is' => 'admin.members.*', 'icon' => 'M12 4.35a2.65 2.65 0 110 5.3 2.65 2.65 0 010-5.3zM5 21v-1.6A5.4 5.4 0 0110.4 14h3.2A5.4 5.4 0 0119 19.4V21m2-9.5l1.6 1.6M21 5.5L19.4 7M3 11.5L4.6 13.1M5 5.5L6.6 7.1', 'badge' => null],
                ['label' => 'Membership Types', 'route' => 'admin.membership-types.index', 'route_is' => 'admin.membership-types.*', 'icon' => 'M7 7h10M7 11h6m-9 9V5a2 2 0 012-2h12a2 2 0 012 2v14a2 2 0 01-2 2H5a2 2 0 01-2-2z'],
                ['label' => 'Membership Tiers', 'route' => 'admin.membership-tiers.index', 'route_is' => 'admin.membership-tiers.*', 'icon' => 'M5 3l4 6-4 12-4-12 4-6zm14 0l4 6-4 12-4-6 4-6zM12 9l3 4.5L12 21l-3-7.5L12 9z'],
                ['label' => 'Fee Plans', 'route' => 'admin.fee-plans.index', 'route_is' => 'admin.fee-plans.*', 'icon' => 'M12 1v22m5.5-18.2c-.8-1.7-3-2.8-5.5-2.8C9 2 7 3.4 7 5.5 7 11 17 10 17 15.7c0 2.1-2 3.5-5 3.5s-4.7-1.1-5.5-2.8'],
                ['label' => 'Committee', 'route' => 'admin.committee.index', 'route_is' => 'admin.committee.*', 'icon' => 'M9 12l2 2 4-4m5.6 3.6a9 9 0 11-12.7-12.7 9 9 0 0112.7 12.7z'],
                ['label' => 'Applications', 'route' => 'admin.membership-applications.index', 'route_is' => 'admin.membership-applications.*', 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4', 'badge' => $pendingApplicationCount > 0 ? $pendingApplicationCount : null],
                ['label' => 'Messages', 'route' => 'admin.messages.index', 'route_is' => 'admin.messages.*', 'icon' => 'M8 10h8m-8 4h5M3 5a2 2 0 012-2h14a2 2 0 012 2v10a2 2 0 01-2 2H8l-4 4V5z', 'badge' => $unreadCount > 0 ? $unreadCount : null],
            ],
        ],
        [
            'label' => 'Finance',
            'items' => [
                ['label' => 'Finance', 'route' => 'admin.finance.index', 'route_is' => 'admin.finance*', 'icon' => 'M3 12h4l2-6 4 12 2-6h6'],
                ['label' => 'Payments', 'route' => 'admin.payments.index', 'route_is' => 'admin.payments.*', 'icon' => 'M3 6h18v12H3V6zm0 3h18m-4 6h2'],
                ['label' => 'Expenses', 'route' => 'admin.expenses.index', 'route_is' => 'admin.expenses.*', 'icon' => 'M12 8v8m-4-4h8M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
                ['label' => 'Expense Categories', 'route' => 'admin.expense-categories.index', 'route_is' => 'admin.expense-categories.*', 'icon' => 'M3 7a2 2 0 012-2h4l2 2h8a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V7z'],
                ['label' => 'Leaderboard', 'route' => 'admin.leaderboard.index', 'route_is' => 'admin.leaderboard*', 'icon' => 'M4 20V10m6 10V4m6 16v-7m-14 7h18'],
            ],
        ],
    ];
@endphp

<aside
    x-cloak
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    class="fixed inset-y-0 left-0 z-50 flex w-72 flex-col overflow-y-auto bg-navy-950 text-navy-100 transition-transform duration-200 ease-out lg:static lg:z-auto lg:translate-x-0 lg:transition-none"
    aria-label="Admin sidebar"
>
    {{-- Brand --}}
    <div class="flex items-center justify-between gap-3 px-5 py-5">
        <a href="{{ route('admin.dashboard') }}" class="focus-ring flex items-center gap-3 rounded-md" aria-label="Admin home">
            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-md bg-maroon-700 font-serif text-xs font-bold text-white ring-1 ring-gold-500/60">
                EDAA
            </span>
            <span class="leading-tight">
                <span class="block font-serif text-base font-semibold text-white">Admin</span>
                <span class="block text-[10px] font-medium uppercase tracking-widest text-gold-300">Association Hub</span>
            </span>
        </a>

        <button
            type="button"
            class="focus-ring inline-flex h-9 w-9 items-center justify-center rounded-md text-navy-100 hover:bg-white/10 lg:hidden"
            @click="sidebarOpen = false"
            aria-label="Close sidebar"
        >
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    {{-- Navigation --}}
    <nav class="flex-1 px-3 pb-6" aria-label="Admin navigation">
        @foreach ($nav as $group)
            <p class="mt-6 px-3 text-[11px] font-semibold uppercase tracking-widest text-navy-400">{{ $group['label'] }}</p>
            <ul class="mt-2 space-y-1">
                @foreach ($group['items'] as $item)
                    @php
                        $itemRoute = $item['route'] ?? null;
                        $routeIs = $item['route_is'] ?? $itemRoute;
                        $isActive = $routeIs && request()->routeIs($routeIs);
                    @endphp
                    <li>
                        @if ($itemRoute)
                            @if ($isActive)
                                <span class="flex items-center gap-3 rounded-md bg-gold-500 px-3 py-2.5 text-sm font-semibold text-navy-950" aria-current="page">
                                    <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}" />
                                    </svg>
                                    {{ $item['label'] }}
                                    @if ($item['badge'] ?? null)
                                        <span class="ml-auto rounded-full bg-navy-950 px-2 py-0.5 text-[10px] font-bold text-gold-300">{{ $item['badge'] }}</span>
                                    @endif
                                </span>
                            @else
                                <a href="{{ route($itemRoute) }}" class="focus-ring flex items-center gap-3 rounded-md px-3 py-2.5 text-sm text-navy-200 transition-colors hover:bg-white/5">
                                    <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}" />
                                    </svg>
                                    {{ $item['label'] }}
                                    @if ($item['badge'] ?? null)
                                        <span class="ml-auto rounded-full bg-maroon-700 px-2 py-0.5 text-[10px] font-bold text-white">{{ $item['badge'] }}</span>
                                    @endif
                                </a>
                            @endif
                        @else
                            <span class="flex items-center justify-between rounded-md px-3 py-2.5 text-sm text-navy-200 hover:bg-white/5">
                                <span class="flex items-center gap-3">
                                    <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}" />
                                    </svg>
                                    {{ $item['label'] }}
                                </span>
                                <span class="rounded-full bg-maroon-700/70 px-2 py-0.5 text-[10px] font-semibold uppercase tracking-wider text-maroon-100">Soon</span>
                            </span>
                        @endif
                    </li>
                @endforeach
            </ul>
        @endforeach
    </nav>

    {{-- Footer actions --}}
    <div class="border-t border-white/10 px-3 py-4">
        <a href="{{ route('home') }}" target="_blank" rel="noopener noreferrer" class="focus-ring flex items-center justify-center gap-2 rounded-md px-3 py-2.5 text-sm font-medium text-navy-100 transition-colors hover:bg-white/5">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
            </svg>
            View Public Site
        </a>
    </div>
</aside>