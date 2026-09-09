@php
$dropdowns = [
    [
        'label' => 'Community',
        'items' => [
            [
                'label' => 'Alumni Directory',
                'route' => 'alumni.index',
                'description' => 'Browse alumni directory & connect',
                'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z',
            ],
            [
                'label' => 'Verified Members',
                'route' => 'members.index',
                'description' => 'Directory of registered members',
                'icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z',
            ],
            [
                'label' => 'Executive Committee',
                'route' => 'committees.index',
                'description' => 'Leadership & committee history',
                'icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4',
            ],
        ],
    ],
    [
        'label' => 'Content',
        'items' => [
            [
                'label' => 'Events',
                'route' => 'events.index',
                'description' => 'Upcoming reunions & gatherings',
                'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z',
            ],
            [
                'label' => 'News & Notices',
                'route' => 'news.index',
                'description' => 'Latest departmental announcements',
                'icon' => 'M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z',
            ],
            [
                'label' => 'Alumni Stories',
                'route' => 'stories.index',
                'description' => 'Memories, journeys & reflections',
                'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253',
            ],
            [
                'label' => 'Photo Gallery',
                'route' => 'gallery.index',
                'description' => 'Archival & event photography',
                'icon' => 'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z',
            ],
            [
                'label' => 'Publications',
                'route' => 'publications.index',
                'description' => 'Department journals & magazines',
                'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z',
            ],
            [
                'label' => 'Press Releases',
                'route' => 'press-releases.index',
                'description' => 'Official statements & media kits',
                'icon' => 'M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z',
            ],
        ],
    ],
];

if (\App\Models\SiteSetting::leaderboardEnabled() || \App\Models\SiteSetting::financePublicEnabled()) {
    $insightItems = [];
    if (\App\Models\SiteSetting::leaderboardEnabled()) {
        $insightItems[] = [
            'label' => 'Leaderboard',
            'route' => 'leaderboard.index',
            'description' => 'Top contributing alumni',
            'icon' => 'M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z',
        ];
    }
    if (\App\Models\SiteSetting::financePublicEnabled()) {
        $insightItems[] = [
            'label' => 'Finance',
            'route' => 'finance.public',
            'description' => 'Public accounts & transparency',
            'icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z',
        ];
    }
    $dropdowns[] = [
        'label' => 'Insights',
        'items' => $insightItems,
    ];
}

$singles = [
    ['label' => 'Home', 'route' => 'home'],
    ['label' => 'About', 'route' => 'about'],
    ['label' => 'Contact', 'route' => 'contact'],
];

$announcementEnabled = \App\Models\SiteSetting::announcementEnabled();
$announcementText = \App\Models\SiteSetting::announcementText();

$currentUser = auth()->user();
$currentAlumni = $currentUser?->alumni;
$isMember = $currentUser && ! $currentUser->isAdmin();
$isAdmin = $currentUser && $currentUser->isAdmin();
@endphp

<header
    id="main-header"
    class="sticky top-0 z-50 border-b border-gold-500/20 bg-navy-950/90 text-white shadow-xl backdrop-blur-md">
    
    {{-- Announcement Bar --}}
    @if ($announcementEnabled && $announcementText)
    <div class="border-b border-white/10 bg-gradient-to-r from-maroon-800 via-maroon-700 to-maroon-800">
        <div class="announcement-track flex w-full h-9 items-center overflow-hidden">
            <div class="announcement-scroll flex w-max items-center" aria-hidden="true">
                <span class="inline-flex items-center gap-2 text-white text-xs sm:text-sm font-medium px-4 whitespace-nowrap flex-shrink-0">
                    <svg class="w-4 h-4 text-gold-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path>
                    </svg>
                    <span>{{ $announcementText }}</span>
                </span>
                <span class="inline-flex items-center gap-2 text-white text-xs sm:text-sm font-medium px-4 whitespace-nowrap flex-shrink-0">
                    <svg class="w-4 h-4 text-gold-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path>
                    </svg>
                    <span>{{ $announcementText }}</span>
                </span>
            </div>
        </div>
    </div>
    @endif

    {{-- Main Navigation --}}
    <nav class="container-page flex items-center justify-between gap-4 py-2.5 sm:py-3" aria-label="Primary">
        {{-- Brand --}}
        <a href="{{ route('home') }}" class="focus-ring flex items-center gap-3 rounded-lg transition-transform hover:scale-[1.01]" aria-label="{{ config('site.name') }} home">
            @php
                $logoDark = \App\Models\SiteSetting::get('logo_dark_path');
                $shortName = \App\Models\SiteSetting::get('site_short_name') ?: config('site.short_name');
            @endphp
            @if ($logoDark)
                <img src="{{ Storage::disk('public')->url($logoDark) }}" alt="{{ $shortName }}" class="h-10 w-auto object-contain sm:h-11">
            @else
                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-gradient-to-br from-maroon-700 to-maroon-900 font-serif text-sm font-bold tracking-wider text-gold-300 shadow-md ring-1 ring-gold-500/50 sm:h-11 sm:w-11">
                    EDAA
                </span>
            @endif
            <span class="leading-tight">
                <span class="block font-serif text-base sm:text-lg font-bold tracking-tight text-white">
                    {{ $shortName }}
                </span>
                <span class="block text-[10px] sm:text-[11px] font-semibold uppercase tracking-widest text-gold-300">
                    Dhaka, Bangladesh
                </span>
            </span>
        </a>

        {{-- Desktop Links --}}
        <ul class="hidden items-center gap-1 xl:flex" role="menubar">
            {{-- Single links --}}
            @foreach ($singles as $item)
            @php $active = request()->routeIs($item['route']); @endphp
            <li role="none">
                <a
                    href="{{ route($item['route']) }}"
                    role="menuitem"
                    class="focus-ring relative rounded-lg px-3 py-2 text-sm font-medium transition-all duration-200 hover:bg-white/5 hover:text-gold-300 {{ $active ? 'text-gold-300 font-semibold' : 'text-navy-100' }}"
                    @if ($active) aria-current="page" @endif>
                    {{ $item['label'] }}
                    @if ($active)
                    <span class="absolute bottom-0 left-3 right-3 h-0.5 rounded-full bg-gold-400"></span>
                    @endif
                </a>
            </li>
            @endforeach

            {{-- Dropdowns --}}
            @foreach ($dropdowns as $dropdown)
            @php
            $routeName = request()->route()?->getName();
            $isDropdownActive = $routeName && in_array($routeName, array_column($dropdown['items'], 'route'));
            @endphp
            <li role="none" class="relative desktop-dropdown" data-dropdown="{{ $dropdown['label'] }}">
                <button
                    type="button"
                    role="menuitem"
                    aria-haspopup="true"
                    aria-expanded="false"
                    class="focus-ring inline-flex items-center gap-1.5 rounded-lg px-3 py-2 text-sm font-medium transition-all duration-200 hover:bg-white/5 hover:text-gold-300 {{ $isDropdownActive ? 'text-gold-300 font-semibold' : 'text-navy-100' }}">
                    {{ $dropdown['label'] }}
                    <svg class="h-3.5 w-3.5 dropdown-chevron transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                {{-- Dropdown panel --}}
                <div
                    class="dropdown-panel absolute left-0 top-full z-50 mt-1.5 w-72 overflow-hidden rounded-2xl border border-white/15 bg-navy-900/95 p-2 shadow-2xl shadow-black/50 backdrop-blur-2xl opacity-0 invisible translate-y-2 scale-95 transition-all duration-200"
                    role="menu"
                    aria-label="{{ $dropdown['label'] }} submenu">
                    
                    <div class="space-y-1">
                        @foreach ($dropdown['items'] as $item)
                        @php $active = request()->routeIs($item['route']); @endphp
                        <a
                            href="{{ route($item['route']) }}"
                            role="menuitem"
                            class="focus-ring group flex items-start gap-3.5 rounded-xl p-2.5 text-sm transition-all duration-150 {{ $active ? 'bg-gold-500/15 text-gold-300' : 'text-navy-100 hover:bg-white/10 hover:text-white' }}"
                            @if ($active) aria-current="page" @endif>
                            <span class="mt-0.5 flex h-8 w-8 shrink-0 items-center justify-center rounded-lg border border-white/10 bg-white/5 text-gold-300 transition-colors group-hover:border-gold-500/40 group-hover:bg-gold-500/20">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}" />
                                </svg>
                            </span>
                            <span class="min-w-0 flex-1">
                                <span class="block font-semibold leading-snug group-hover:text-gold-200">{{ $item['label'] }}</span>
                                <span class="block text-xs text-navy-300 line-clamp-1 group-hover:text-navy-200">{{ $item['description'] }}</span>
                            </span>
                        </a>
                        @endforeach
                    </div>
                </div>
            </li>
            @endforeach
        </ul>

        {{-- Member / Action Controls --}}
        <div class="flex items-center gap-2.5 sm:gap-3">
            @if ($currentUser)
                @if ($isAdmin)
                    {{-- Admin Quick Shortcut --}}
                    <a
                        href="{{ route('admin.dashboard') }}"
                        class="focus-ring hidden sm:inline-flex items-center gap-2 rounded-lg border border-gold-500/40 bg-gold-500/10 px-3 py-1.5 text-xs font-semibold text-gold-300 transition-all hover:bg-gold-500/20 hover:text-white">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.311-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.311 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Admin Panel
                    </a>
                @endif

                {{-- User / Member Dropdown --}}
                <div class="relative" id="user-menu-container">
                    <button
                        type="button"
                        id="user-menu-button"
                        class="focus-ring flex items-center gap-2.5 rounded-full border border-white/20 bg-white/5 py-1 pl-1.5 pr-3 text-left transition-all hover:border-gold-500/40 hover:bg-white/10"
                        aria-expanded="false"
                        aria-haspopup="true">
                        @if ($currentAlumni?->profile_photo_url)
                            <img src="{{ $currentAlumni->profile_photo_url }}" alt="{{ $currentUser->name }}" class="h-8 w-8 rounded-full object-cover ring-1 ring-gold-400">
                        @else
                            <span class="flex h-8 w-8 items-center justify-center rounded-full bg-maroon-700 font-serif text-xs font-bold text-white ring-1 ring-gold-400">
                                {{ \Illuminate\Support\Str::initials($currentUser->name) }}
                            </span>
                        @endif
                        <div class="hidden text-left md:block">
                            <span class="block text-xs font-semibold leading-tight text-white truncate max-w-[110px]">
                                {{ $currentUser->name }}
                            </span>
                            <span class="block text-[10px] font-medium text-gold-300">
                                {{ $isAdmin ? 'Administrator' : ($currentAlumni?->membership?->tier?->name ?? 'Member') }}
                            </span>
                        </div>
                        <svg class="h-3.5 w-3.5 text-white/70 transition-transform duration-200 user-menu-chevron" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    {{-- User Dropdown Menu --}}
                    <div
                        id="user-menu-panel"
                        class="user-menu-panel absolute right-0 mt-2 w-64 rounded-2xl border border-white/15 bg-navy-900/95 p-2 shadow-2xl backdrop-blur-2xl z-50 opacity-0 invisible translate-y-2 scale-95 transition-all duration-200">
                        
                        <div class="border-b border-white/10 px-3 py-2.5">
                            <p class="text-sm font-semibold text-white truncate">{{ $currentUser->name }}</p>
                            <p class="text-xs text-navy-300 truncate">{{ $currentUser->email }}</p>
                        </div>

                        <div class="py-1.5">
                            @if ($isAdmin)
                                <a href="{{ route('admin.dashboard') }}" class="focus-ring flex items-center gap-2.5 rounded-lg px-3 py-2 text-xs font-semibold text-gold-300 hover:bg-gold-500/15 transition-colors">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                                    </svg>
                                    Admin Dashboard
                                </a>
                            @else
                                <a href="{{ route('member.dashboard') }}" class="focus-ring flex items-center gap-2.5 rounded-lg px-3 py-2 text-xs font-semibold text-white hover:bg-white/10 transition-colors">
                                    <svg class="h-4 w-4 text-gold-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                    </svg>
                                    Member Dashboard
                                </a>
                                <a href="{{ route('member.membership.card') }}" class="focus-ring flex items-center gap-2.5 rounded-lg px-3 py-2 text-xs font-semibold text-white hover:bg-white/10 transition-colors">
                                    <svg class="h-4 w-4 text-gold-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                    </svg>
                                    Digital ID Card
                                </a>
                                <a href="{{ route('member.profile') }}" class="focus-ring flex items-center gap-2.5 rounded-lg px-3 py-2 text-xs font-semibold text-white hover:bg-white/10 transition-colors">
                                    <svg class="h-4 w-4 text-gold-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    My Profile
                                </a>
                            @endif
                        </div>

                        <div class="border-t border-white/10 pt-1.5">
                            @if ($isAdmin)
                                <form method="POST" action="{{ route('admin.logout') }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="focus-ring flex w-full items-center gap-2.5 rounded-lg px-3 py-2 text-xs font-semibold text-red-400 hover:bg-red-500/10 transition-colors">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                        </svg>
                                        Admin Sign Out
                                    </button>
                                </form>
                            @else
                                <form method="POST" action="{{ route('member.logout') }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="focus-ring flex w-full items-center gap-2.5 rounded-lg px-3 py-2 text-xs font-semibold text-red-400 hover:bg-red-500/10 transition-colors">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                        </svg>
                                        Member Sign Out
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @else
                {{-- Guest: Member Portal Login link --}}
                <a
                    href="{{ route('member.login') }}"
                    class="focus-ring hidden md:inline-flex items-center gap-1.5 rounded-lg border border-white/20 bg-white/5 px-3 py-2 text-xs font-semibold text-navy-100 transition-all hover:border-gold-400 hover:bg-white/10 hover:text-white">
                    <svg class="h-3.5 w-3.5 text-gold-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                    </svg>
                    Member Portal
                </a>

                {{-- Guest: Become a Member button --}}
                <x-button href="{{ route('membership.apply') }}" variant="gold" class="hidden sm:inline-flex text-xs py-2 px-3.5">
                    Become a Member
                </x-button>
            @endif

            {{-- Mobile menu button --}}
            <button
                type="button"
                id="mobile-menu-button"
                class="focus-ring inline-flex h-10 w-10 items-center justify-center rounded-lg border border-white/15 bg-white/5 text-white transition-colors hover:bg-white/10 xl:hidden"
                aria-expanded="false"
                aria-controls="mobile-menu"
                aria-label="Toggle navigation menu">
                <svg id="mobile-menu-icon-open" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                <svg id="mobile-menu-icon-close" class="h-5 w-5 text-gold-300 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </nav>

    {{-- Mobile Menu --}}
    <div
        id="mobile-menu"
        class="mobile-menu border-t border-white/10 bg-navy-950/95 backdrop-blur-2xl xl:hidden max-h-[calc(100vh-5rem)] overflow-y-auto hidden">
        
        <nav class="container-page py-4 space-y-4" aria-label="Mobile">
            {{-- Member/Guest Header in Mobile --}}
            @if ($currentUser)
                <div class="rounded-2xl border border-white/15 bg-white/5 p-3.5">
                    <div class="flex items-center gap-3">
                        @if ($currentAlumni?->profile_photo_url)
                            <img src="{{ $currentAlumni->profile_photo_url }}" alt="{{ $currentUser->name }}" class="h-10 w-10 rounded-full object-cover ring-2 ring-gold-400">
                        @else
                            <span class="flex h-10 w-10 items-center justify-center rounded-full bg-maroon-700 font-serif text-sm font-bold text-white ring-2 ring-gold-400">
                                {{ \Illuminate\Support\Str::initials($currentUser->name) }}
                            </span>
                        @endif
                        <div class="min-w-0 flex-1">
                            <p class="font-semibold text-sm text-white truncate">{{ $currentUser->name }}</p>
                            <p class="text-xs text-gold-300">{{ $isAdmin ? 'Administrator' : ($currentAlumni?->membership?->tier?->name ?? 'Active Member') }}</p>
                        </div>
                    </div>
                    <div class="mt-3 flex gap-2">
                        @if ($isAdmin)
                            <a href="{{ route('admin.dashboard') }}" class="flex-1 rounded-lg bg-gold-500 px-3 py-2 text-center text-xs font-semibold text-navy-950 shadow">
                                Admin Dashboard
                            </a>
                        @else
                            <a href="{{ route('member.dashboard') }}" class="flex-1 rounded-lg bg-gold-500 px-3 py-2 text-center text-xs font-semibold text-navy-950 shadow">
                                Member Dashboard
                            </a>
                        @endif
                    </div>
                </div>
            @else
                <div class="grid grid-cols-2 gap-2 pb-2">
                    <a href="{{ route('member.login') }}" class="flex items-center justify-center gap-1.5 rounded-xl border border-white/20 bg-white/5 px-3 py-2.5 text-center text-xs font-semibold text-white hover:bg-white/10">
                        <svg class="h-4 w-4 text-gold-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                        </svg>
                        Member Login
                    </a>
                    <a href="{{ route('membership.apply') }}" class="flex items-center justify-center gap-1 rounded-xl bg-gold-500 px-3 py-2.5 text-center text-xs font-bold text-navy-950 shadow hover:bg-gold-400">
                        Join EDAA →
                    </a>
                </div>
            @endif

            {{-- Mobile Links --}}
            <ul class="flex flex-col space-y-1" role="menu">
                @foreach ($singles as $item)
                @php $active = request()->routeIs($item['route']); @endphp
                <li role="none">
                    <a
                        href="{{ route($item['route']) }}"
                        role="menuitem"
                        class="mobile-link focus-ring flex items-center justify-between rounded-xl px-3.5 py-2.5 text-sm font-semibold transition-colors hover:bg-white/5 {{ $active ? 'bg-gold-500/10 text-gold-300' : 'text-white' }}"
                        @if ($active) aria-current="page" @endif>
                        {{ $item['label'] }}
                        @if ($active)
                        <span class="h-1.5 w-1.5 rounded-full bg-gold-400" aria-hidden="true"></span>
                        @endif
                    </a>
                </li>
                @endforeach

                {{-- Mobile Dropdowns --}}
                @foreach ($dropdowns as $dropdown)
                @php
                $routeName = request()->route()?->getName();
                $isDropdownActive = $routeName && in_array($routeName, array_column($dropdown['items'], 'route'));
                @endphp
                <li role="none" class="mobile-dropdown" data-dropdown="{{ $dropdown['label'] }}">
                    <button
                        type="button"
                        role="menuitem"
                        aria-haspopup="true"
                        aria-expanded="false"
                        class="mobile-dropdown-toggle focus-ring flex w-full items-center justify-between rounded-xl px-3.5 py-2.5 text-sm font-semibold transition-colors hover:bg-white/5 {{ $isDropdownActive ? 'text-gold-300' : 'text-white' }}">
                        {{ $dropdown['label'] }}
                        <svg
                            class="h-4 w-4 transition-transform duration-200 mobile-dropdown-chevron"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div
                        class="mobile-dropdown-panel ml-3 mt-1 space-y-1 border-l-2 border-gold-500/30 pl-3 hidden">
                        @foreach ($dropdown['items'] as $item)
                        @php $active = request()->routeIs($item['route']); @endphp
                        <a
                            href="{{ route($item['route']) }}"
                            role="menuitem"
                            class="mobile-link focus-ring flex items-center justify-between rounded-lg px-3 py-2 text-xs font-medium transition-colors hover:bg-white/5 {{ $active ? 'text-gold-300 font-semibold' : 'text-navy-200' }}"
                            @if ($active) aria-current="page" @endif>
                            <span>{{ $item['label'] }}</span>
                            @if ($active)
                            <span class="h-1.5 w-1.5 rounded-full bg-gold-400" aria-hidden="true"></span>
                            @endif
                        </a>
                        @endforeach
                    </div>
                </li>
                @endforeach
            </ul>
        </nav>
    </div>

    <script>
    (function() {
        'use strict';

        const header = document.getElementById('main-header');
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');
        const mobileMenuIconOpen = document.getElementById('mobile-menu-icon-open');
        const mobileMenuIconClose = document.getElementById('mobile-menu-icon-close');
        const userMenuButton = document.getElementById('user-menu-button');
        const userMenuPanel = document.getElementById('user-menu-panel');

        let mobileOpen = false;
        let userMenuOpen = false;
        let activeDesktopDropdown = null;
        let hoverTimeout = null;

        function closeMobileMenu() {
            mobileOpen = false;
            mobileMenu.classList.add('hidden');
            mobileMenuIconOpen.classList.remove('hidden');
            mobileMenuIconClose.classList.add('hidden');
            mobileMenuButton.setAttribute('aria-expanded', 'false');
            document.querySelectorAll('.mobile-dropdown-panel').forEach(function(el) {
                el.classList.add('hidden');
            });
            document.querySelectorAll('.mobile-dropdown-chevron').forEach(function(el) {
                el.style.transform = '';
            });
        }

        function openMobileMenu() {
            mobileOpen = true;
            mobileMenu.classList.remove('hidden');
            mobileMenuIconOpen.classList.add('hidden');
            mobileMenuIconClose.classList.remove('hidden');
            mobileMenuButton.setAttribute('aria-expanded', 'true');
        }

        function closeUserMenu() {
            userMenuOpen = false;
            userMenuPanel.classList.add('opacity-0', 'invisible', 'translate-y-2', 'scale-95');
            userMenuPanel.classList.remove('opacity-100', 'visible', 'translate-y-0', 'scale-100');
            userMenuButton.setAttribute('aria-expanded', 'false');
            userMenuButton.querySelector('.user-menu-chevron').style.transform = '';
        }

        function openUserMenu() {
            userMenuOpen = true;
            userMenuPanel.classList.remove('opacity-0', 'invisible', 'translate-y-2', 'scale-95');
            userMenuPanel.classList.add('opacity-100', 'visible', 'translate-y-0', 'scale-100');
            userMenuButton.setAttribute('aria-expanded', 'true');
            userMenuButton.querySelector('.user-menu-chevron').style.transform = 'rotate(180deg)';
        }

        function closeDesktopDropdowns() {
            document.querySelectorAll('.desktop-dropdown').forEach(function(dropdown) {
                const panel = dropdown.querySelector('.dropdown-panel');
                const chevron = dropdown.querySelector('.dropdown-chevron');
                if (panel) {
                    panel.classList.add('opacity-0', 'invisible', 'translate-y-2', 'scale-95');
                    panel.classList.remove('opacity-100', 'visible', 'translate-y-0', 'scale-100');
                }
                if (chevron) {
                    chevron.style.transform = '';
                }
            });
            activeDesktopDropdown = null;
        }

        function openDesktopDropdown(dropdown) {
            closeDesktopDropdowns();
            activeDesktopDropdown = dropdown;
            const panel = dropdown.querySelector('.dropdown-panel');
            const chevron = dropdown.querySelector('.dropdown-chevron');
            if (panel) {
                panel.classList.remove('opacity-0', 'invisible', 'translate-y-2', 'scale-95');
                panel.classList.add('opacity-100', 'visible', 'translate-y-0', 'scale-100');
            }
            if (chevron) {
                chevron.style.transform = 'rotate(180deg)';
            }
        }

        function closeAll() {
            closeMobileMenu();
            closeUserMenu();
            closeDesktopDropdowns();
        }

        if (mobileMenuButton) {
            mobileMenuButton.addEventListener('click', function() {
                if (mobileOpen) {
                    closeMobileMenu();
                } else {
                    openMobileMenu();
                }
            });
        }

        if (userMenuButton) {
            userMenuButton.addEventListener('click', function(e) {
                e.stopPropagation();
                if (userMenuOpen) {
                    closeUserMenu();
                } else {
                    openUserMenu();
                }
            });
        }

        document.addEventListener('click', function(e) {
            if (userMenuOpen && userMenuPanel && !userMenuPanel.contains(e.target) && e.target !== userMenuButton) {
                closeUserMenu();
            }
        });

        document.querySelectorAll('.desktop-dropdown').forEach(function(dropdown) {
            const button = dropdown.querySelector('button');
            
            dropdown.addEventListener('mouseenter', function() {
                clearTimeout(hoverTimeout);
                openDesktopDropdown(dropdown);
            });

            dropdown.addEventListener('mouseleave', function() {
                hoverTimeout = setTimeout(function() {
                    closeDesktopDropdowns();
                }, 150);
            });

            if (button) {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    if (activeDesktopDropdown === dropdown) {
                        closeDesktopDropdowns();
                    } else {
                        openDesktopDropdown(dropdown);
                    }
                });
            }

            const panel = dropdown.querySelector('.dropdown-panel');
            if (panel) {
                panel.addEventListener('click', function(e) {
                    if (e.target.closest('a')) {
                        closeDesktopDropdowns();
                    }
                });
            }
        });

        document.querySelectorAll('.mobile-dropdown-toggle').forEach(function(toggle) {
            toggle.addEventListener('click', function() {
                const dropdown = toggle.closest('.mobile-dropdown');
                const panel = dropdown.querySelector('.mobile-dropdown-panel');
                const chevron = toggle.querySelector('.mobile-dropdown-chevron');
                const isHidden = panel.classList.contains('hidden');

                document.querySelectorAll('.mobile-dropdown-panel').forEach(function(el) {
                    el.classList.add('hidden');
                });
                document.querySelectorAll('.mobile-dropdown-chevron').forEach(function(el) {
                    el.style.transform = '';
                });

                if (isHidden) {
                    panel.classList.remove('hidden');
                    chevron.style.transform = 'rotate(180deg)';
                }
            });
        });

        document.querySelectorAll('.mobile-link').forEach(function(link) {
            link.addEventListener('click', function() {
                closeMobileMenu();
            });
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeAll();
            }
        });

        if (userMenuPanel) {
            userMenuPanel.addEventListener('click', function(e) {
                if (e.target.closest('a') || e.target.closest('form')) {
                    setTimeout(closeUserMenu, 50);
                }
            });
        }
    })();
    </script>
</header>
