@php
    use App\Models\ContactMessage;
    use App\Models\MembershipApplication;
    use App\Models\CorrectionRequest;
    use App\Enums\ApplicationStatus;

    $unreadCount = ContactMessage::unread()->count();
    $pendingApplicationCount = MembershipApplication::where('status', ApplicationStatus::Pending)->count();
    $pendingCorrectionCount = CorrectionRequest::where('status', CorrectionRequest::STATUS_PENDING)->count();

    $navGroups = [
        [
            'title' => 'Overview',
            'items' => [
                ['label' => 'Dashboard', 'route' => 'admin.dashboard', 'route_is' => 'admin.dashboard*', 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
                ['label' => 'Site Settings', 'route' => 'admin.settings.index', 'route_is' => 'admin.settings.*', 'icon' => 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z'],
            ],
        ],
        [
            'title' => 'Community & Directory',
            'items' => [
                ['label' => 'Alumni Directory', 'route' => 'admin.alumni.index', 'route_is' => 'admin.alumni.*', 'icon' => 'M17 20h5v-2a3 3 0 00-5.4-1.7M9 20H4v-2a3 3 0 015.4-1.7M16 3.1a3 3 0 110 5.8M11 7a3 3 0 11-6 0 3 3 0 016 0z'],
                ['label' => 'Batches', 'route' => 'admin.batches.index', 'route_is' => 'admin.batches.*', 'icon' => 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10'],
                ['label' => 'Members', 'route' => 'admin.members.index', 'route_is' => 'admin.members.*', 'icon' => 'M12 4.35a2.65 2.65 0 110 5.3 2.65 2.65 0 010-5.3zM5 21v-1.6A5.4 5.4 0 0110.4 14h3.2A5.4 5.4 0 0119 19.4V21m2-9.5l1.6 1.6M21 5.5L19.4 7M3 11.5L4.6 13.1M5 5.5L6.6 7.1'],
                ['label' => 'Applications', 'route' => 'admin.membership-applications.index', 'route_is' => 'admin.membership-applications.*', 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4', 'badge' => $pendingApplicationCount > 0 ? $pendingApplicationCount : null, 'badge_color' => 'bg-amber-500'],
                ['label' => 'Correction Requests', 'route' => 'admin.correction-requests.index', 'route_is' => 'admin.correction-requests.*', 'icon' => 'M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z', 'badge' => $pendingCorrectionCount > 0 ? $pendingCorrectionCount : null, 'badge_color' => 'bg-rose-500'],
                ['label' => 'Committees', 'route' => 'admin.committee-types.index', 'route_is' => 'admin.committee*', 'icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4'],
                ['label' => 'Membership Types', 'route' => 'admin.membership-types.index', 'route_is' => 'admin.membership-types.*', 'icon' => 'M7 7h10M7 11h6m-9 9V5a2 2 0 012-2h12a2 2 0 012 2v14a2 2 0 01-2 2H5a2 2 0 01-2-2z'],
                ['label' => 'Membership Tiers', 'route' => 'admin.membership-tiers.index', 'route_is' => 'admin.membership-tiers.*', 'icon' => 'M5 3l4 6-4 12-4-12 4-6zm14 0l4 6-4 12-4-6 4-6zM12 9l3 4.5L12 21l-3-7.5L12 9z'],
            ],
        ],
        [
            'title' => 'Content & Editorial',
            'items' => [
                ['label' => 'Events', 'route' => 'admin.events.index', 'route_is' => 'admin.events.index', 'icon' => 'M8 7V3m8 4V3M4 11h16M5 5h14a1 1 0 011 1v13a1 1 0 01-1 1H5a1 1 0 01-1-1V6a1 1 0 011-1z'],
                ['label' => 'Event Categories', 'route' => 'admin.events.categories.index', 'route_is' => 'admin.events.categories.*', 'icon' => 'M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z'],
                ['label' => 'News Articles', 'route' => 'admin.news.index', 'route_is' => 'admin.news.index', 'icon' => 'M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z'],
                ['label' => 'News Categories', 'route' => 'admin.news-categories.index', 'route_is' => 'admin.news-categories.*', 'icon' => 'M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z'],
                ['label' => 'Alumni Stories', 'route' => 'admin.stories.index', 'route_is' => 'admin.stories.*', 'icon' => 'M9.6 4C5.4 5.4 3 8.6 3 13.2V20h6.8v-6.8H6.4c0-2.8 1.4-4.9 4.2-5.8L9.6 4zm11 0c-4.2 1.4-6.6 4.6-6.6 9.2V20h6.8v-6.8h-3.4c0-2.8 1.4-4.9 4.2-5.8L20.6 4z'],
                ['label' => 'Photo Gallery', 'route' => 'admin.gallery.index', 'route_is' => 'admin.gallery*', 'icon' => 'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z'],
                ['label' => 'Publications', 'route' => 'admin.publications.index', 'route_is' => 'admin.publications.index', 'icon' => 'M12 6.3v11.4m0-11.4A3.2 3.2 0 009.5 3.5H6.5v13h3a3.2 3.2 0 013 2.8m-.5-12.9a3.2 3.2 0 012.5-2.8h3v13h-3a3.2 3.2 0 00-3 2.8m0-12.9v11.4'],
                ['label' => 'Publication Categories', 'route' => 'admin.publication-categories.index', 'route_is' => 'admin.publication-categories.*', 'icon' => 'M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z'],
                ['label' => 'Press Releases', 'route' => 'admin.press-releases.index', 'route_is' => 'admin.press-releases*', 'icon' => 'M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z'],
                ['label' => 'Home Slider', 'route' => 'admin.home-slider.index', 'route_is' => 'admin.home-slider*', 'icon' => 'M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2'],
                ['label' => 'Testimonials', 'route' => 'admin.testimonials.index', 'route_is' => 'admin.testimonials*', 'icon' => 'M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z'],
            ],
        ],
        [
            'title' => 'Finance & Treasury',
            'items' => [
                ['label' => 'Financial Overview', 'route' => 'admin.finance.index', 'route_is' => 'admin.finance.index', 'icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z'],
                ['label' => 'Payments & Dues', 'route' => 'admin.payments.index', 'route_is' => 'admin.payments.*', 'icon' => 'M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z'],
                ['label' => 'Association Expenses', 'route' => 'admin.expenses.index', 'route_is' => 'admin.expenses.*', 'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
                ['label' => 'Expense Categories', 'route' => 'admin.expense-categories.index', 'route_is' => 'admin.expense-categories.*', 'icon' => 'M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z'],
                ['label' => 'Donor Leaderboard', 'route' => 'admin.leaderboard.index', 'route_is' => 'admin.leaderboard*', 'icon' => 'M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z'],
            ],
        ],
        [
            'title' => 'Communications',
            'items' => [
                ['label' => 'Contact Inquiries', 'route' => 'admin.messages.index', 'route_is' => 'admin.messages.*', 'icon' => 'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z', 'badge' => $unreadCount > 0 ? $unreadCount : null, 'badge_color' => 'bg-maroon-600'],
            ],
        ],
        [
            'title' => 'Administration',
            'items' => [
                ['label' => 'Admin Management', 'route' => 'admin.admins.index', 'route_is' => 'admin.admins.*', 'icon' => 'M12 4.35a2.65 2.65 0 110 5.3 2.65 2.65 0 010-5.3zM5 21v-1.6A5.4 5.4 0 0110.4 14h3.2A5.4 5.4 0 0119 19.4V21M9 21v-2a4 4 0 014-4h0a4 4 0 014 4v2'],
                ['label' => 'Activity Log', 'route' => 'admin.activity-log.index', 'route_is' => 'admin.activity-log.*', 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
            ],
        ],
    ];
@endphp

<aside
    x-cloak
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    class="fixed inset-y-0 left-0 z-50 flex w-72 flex-col overflow-y-auto bg-navy-950 border-r border-navy-800/80 text-navy-100 transition-transform duration-200 ease-out lg:static lg:z-auto lg:translate-x-0 lg:transition-none shadow-2xl lg:shadow-none scrollbar-thin scrollbar-thumb-navy-800"
    aria-label="Admin sidebar"
>
    {{-- Brand Header --}}
    <div class="sticky top-0 z-20 flex items-center justify-between gap-3 bg-navy-950/95 backdrop-blur-md px-5 py-4 border-b border-navy-800/60">
        <a href="{{ route('admin.dashboard') }}" class="focus-ring flex items-center gap-3 group rounded-lg" aria-label="Admin home">
            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-gradient-to-br from-maroon-700 to-maroon-900 font-serif text-xs font-bold text-white shadow-md shadow-maroon-950/40 ring-1 ring-gold-500/50 group-hover:ring-gold-400 transition-all duration-300">
                EDAA
            </span>
            <span class="leading-tight">
                <span class="block font-serif text-base font-semibold text-white group-hover:text-gold-300 transition-colors">EDAA Portal</span>
                <span class="block text-[10px] font-semibold uppercase tracking-widest text-gold-400/90">Executive Admin</span>
            </span>
        </a>

        <button
            type="button"
            class="focus-ring inline-flex h-8 w-8 items-center justify-center rounded-lg text-navy-400 hover:text-white hover:bg-white/10 lg:hidden"
            @click="sidebarOpen = false"
            aria-label="Close sidebar"
        >
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    {{-- Quick Spotlight Trigger Button in Sidebar --}}
    <div class="px-4 pt-3 pb-1">
        <button
            type="button"
            @click="$dispatch('open-command-palette')"
            class="flex w-full items-center justify-between rounded-xl bg-navy-900/80 hover:bg-navy-900 border border-navy-800/80 px-3.5 py-2 text-xs text-navy-300 transition-all duration-200 group hover:border-gold-500/40 shadow-inner"
        >
            <span class="flex items-center gap-2.5">
                <svg class="h-4 w-4 text-navy-400 group-hover:text-gold-400 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <span>Jump to module...</span>
            </span>
            <kbd class="rounded bg-navy-950 px-1.5 py-0.5 font-mono text-[10px] font-semibold text-navy-400 border border-navy-800 group-hover:text-gold-300">Ctrl K</kbd>
        </button>
    </div>

    {{-- Navigation Groups --}}
    <nav class="flex-1 px-3 py-2 space-y-5" aria-label="Admin navigation">
        @foreach ($navGroups as $group)
            <div>
                <p class="px-3 text-[10px] font-bold uppercase tracking-widest text-navy-400/80">
                    {{ $group['title'] }}
                </p>
                <ul class="mt-1.5 space-y-0.5">
                    @foreach ($group['items'] as $item)
                        @php
                            $itemRoute = $item['route'] ?? null;
                            $routeIs = $item['route_is'] ?? $itemRoute;
                            $isActive = $routeIs && request()->routeIs($routeIs);
                            $badgeColor = $item['badge_color'] ?? 'bg-maroon-700';
                        @endphp
                        <li>
                            @if ($itemRoute)
                                @if ($isActive)
                                    <span class="flex items-center gap-3 rounded-xl bg-gradient-to-r from-navy-800 to-navy-850 px-3 py-2 text-xs font-semibold text-white border-l-4 border-gold-400 shadow-sm" aria-current="page">
                                        <svg class="h-4 w-4 shrink-0 text-gold-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}" />
                                        </svg>
                                        <span class="truncate">{{ $item['label'] }}</span>
                                        @if ($item['badge'] ?? null)
                                            <span class="ml-auto rounded-full {{ $badgeColor }} px-2 py-0.5 text-[10px] font-bold text-white shadow-sm ring-1 ring-white/20">
                                                {{ $item['badge'] }}
                                            </span>
                                        @endif
                                    </span>
                                @else
                                    <a href="{{ route($itemRoute) }}" class="group flex items-center gap-3 rounded-xl px-3 py-2 text-xs text-navy-300 transition-all duration-150 hover:bg-navy-900/90 hover:text-white hover:translate-x-0.5">
                                        <svg class="h-4 w-4 shrink-0 text-navy-400 group-hover:text-gold-400 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}" />
                                        </svg>
                                        <span class="truncate">{{ $item['label'] }}</span>
                                        @if ($item['badge'] ?? null)
                                            <span class="ml-auto rounded-full {{ $badgeColor }} px-2 py-0.5 text-[10px] font-bold text-white shadow-sm ring-1 ring-white/10">
                                                {{ $item['badge'] }}
                                            </span>
                                        @endif
                                    </a>
                                @endif
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
        @endforeach
    </nav>

    {{-- Footer Actions --}}
    <div class="sticky bottom-0 z-20 border-t border-navy-800/80 bg-navy-950/95 backdrop-blur-md p-3 space-y-2">
        <a
            href="{{ route('home') }}"
            target="_blank"
            rel="noopener noreferrer"
            class="focus-ring flex items-center justify-between rounded-xl bg-navy-900/60 hover:bg-navy-900 border border-navy-800/60 px-3.5 py-2 text-xs font-medium text-navy-200 transition-all hover:text-white group"
        >
            <span class="flex items-center gap-2">
                <svg class="h-4 w-4 text-navy-400 group-hover:text-gold-400 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                </svg>
                <span>Live Public Site</span>
            </span>
            <span class="text-[10px] text-navy-400 group-hover:text-gold-300">↗</span>
        </a>
    </div>
</aside>