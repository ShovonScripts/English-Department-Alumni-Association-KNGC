@php
$dropdowns = [
[
'label' => 'Community',
'items' => [
['label' => 'Alumni', 'route' => 'alumni.index', 'description' => 'Browse alumni directory'],
['label' => 'Committee', 'route' => 'committee.index', 'description' => 'Meet the executive committee'],
],
],
[
'label' => 'Content',
'items' => [
['label' => 'Events', 'route' => 'events.index', 'description' => 'Upcoming & past events'],
['label' => 'News', 'route' => 'news.index', 'description' => 'Latest announcements'],
['label' => 'Stories', 'route' => 'stories.index', 'description' => 'Alumni stories & memories'],
['label' => 'Gallery', 'route' => 'gallery.index', 'description' => 'Photos & media'],
['label' => 'Publications', 'route' => 'publications.index', 'description' => 'Department publications'],
],
],
];

if (\App\Models\SiteSetting::leaderboardEnabled() || \App\Models\SiteSetting::financePublicEnabled()) {
$insightItems = [];
if (\App\Models\SiteSetting::leaderboardEnabled()) {
$insightItems[] = ['label' => 'Leaderboard', 'route' => 'leaderboard.index', 'description' => 'Top contributors'];
}
if (\App\Models\SiteSetting::financePublicEnabled()) {
$insightItems[] = ['label' => 'Finance', 'route' => 'finance.public', 'description' => 'Financial transparency'];
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
@endphp

<header
    x-data="{ mobileOpen: false, openDropdown: null }"
    @keydown.escape.window="openDropdown = null; mobileOpen = false"
    x-on:mouseleave="openDropdown = null"
    class="sticky top-0 z-50 navbar-glass text-white">
    {{-- Announcement Bar --}}
    @if ($announcementEnabled && $announcementText)
    <div class="bg-maroon-700">
        <div class="announcement-track flex w-full h-10 items-center overflow-hidden">
            <div class="announcement-scroll flex w-max items-center" aria-hidden="true">
                <span class="inline-flex items-center gap-2 text-white text-sm font-medium px-2 sm:px-3 whitespace-nowrap flex-shrink-0">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path>
                    </svg>
                    <span>{{ $announcementText }}</span>
                </span>
                <span class="inline-flex items-center gap-2 text-white text-sm font-medium px-2 sm:px-3 whitespace-nowrap flex-shrink-0">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path>
                    </svg>
                    <span>{{ $announcementText }}</span>
                </span>
            </div>
        </div>
    </div>
    @endif

    {{-- Main Navigation --}}
    <nav class="border-b border-white/10 shadow-sm" aria-label="Primary">
        <div class="container-page flex items-center justify-between gap-4 py-3">
            {{-- Brand --}}
            <a href="{{ route('home') }}" class="focus-ring flex items-center gap-3 rounded-md" aria-label="{{ config('site.name') }} home">
                <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-md bg-maroon-700 font-serif text-sm font-bold tracking-wide text-white ring-1 ring-gold-500/60">
                    EDAA
                </span>
                <span class="leading-tight">
                    <span class="block font-serif text-lg font-semibold tracking-tight text-white">
                        {{ config('site.short_name') }}
                    </span>
                    <span class="block text-[11px] font-medium uppercase tracking-widest text-gold-300">
                        KNGC · Dhaka
                    </span>
                </span>
            </a>

            {{-- Desktop links --}}
            <ul class="hidden items-center gap-0.5 xl:flex" role="menubar">
                {{-- Single links --}}
                @foreach ($singles as $item)
                @php $active = request()->routeIs($item['route']); @endphp
                <li role="none">
                    <a
                        href="{{ route($item['route']) }}"
                        role="menuitem"
                        class="focus-ring inline-flex items-center rounded-md px-3 py-2 text-sm font-medium transition-colors duration-200 hover:text-gold-300 {{ $active ? 'text-gold-300' : 'text-white' }}"
                        @if ($active) aria-current="page" @endif>
                        {{ $item['label'] }}
                    </a>
                </li>
                @endforeach

                {{-- Dropdowns --}}
                @foreach ($dropdowns as $dropdown)
                @php
                $isDropdownActive = in_array(request()->route()->getName(), array_column($dropdown['items'], 'route'));
                @endphp
                <li role="none" class="relative" x-data="{ open: false }" @mouseenter="open = true; openDropdown = '{{ $dropdown['label'] }}'" @mouseleave="open = false" x-on:mouseleave.window="if (openDropdown !== '{{ $dropdown['label'] }}') open = false">
                    <button
                        type="button"
                        role="menuitem"
                        aria-haspopup="true"
                        :aria-expanded="open.toString()"
                        @click="open = !open; openDropdown = open ? '{{ $dropdown['label'] }}' : null"
                        @focus="open = true; openDropdown = '{{ $dropdown['label'] }}'"
                        @blur="setTimeout(() => { open = false; openDropdown = null }, 150)"
                        class="focus-ring inline-flex items-center gap-1.5 rounded-md px-3 py-2 text-sm font-medium transition-colors duration-200 hover:text-gold-300 {{ $isDropdownActive ? 'text-gold-300' : 'text-white' }}">
                        {{ $dropdown['label'] }}
                        <svg class="h-3.5 w-3.5 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    {{-- Dropdown panel --}}
                    <div
                        x-show="open"
                        x-cloak
                        x-transition:enter="transition ease-out duration-150"
                        x-transition:enter-start="opacity-0 translate-y-1"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-100"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 translate-y-1"
                        @click="open = false; openDropdown = null"
                        class="absolute left-0 top-full z-50 mt-1 w-64 overflow-hidden rounded-xl border border-white/10 bg-navy-800/80 shadow-2xl shadow-black/30 backdrop-blur-xl"
                        role="menu"
                        aria-label="{{ $dropdown['label'] }} submenu">
                        <div class="p-1.5">
                            @foreach ($dropdown['items'] as $item)
                            @php $active = request()->routeIs($item['route']); @endphp
                            <a
                                href="{{ route($item['route']) }}"
                                role="menuitem"
                                class="focus-ring group flex items-start gap-3 rounded-lg px-3 py-2.5 text-sm transition-colors duration-150 {{ $active ? 'bg-gold-500/10 text-gold-300' : 'text-white hover:bg-white/5 hover:text-gold-300' }}"
                                @if ($active) aria-current="page" @endif>
                                <span class="mt-0.5 block h-1.5 w-1.5 shrink-0 rounded-full {{ $active ? 'bg-gold-400' : 'bg-white/20 group-hover:bg-gold-400' }}"></span>
                                <span>
                                    <span class="block font-medium leading-tight">{{ $item['label'] }}</span>
                                    <span class="block text-xs text-white/50 group-hover:text-white/70">{{ $item['description'] }}</span>
                                </span>
                            </a>
                            @endforeach
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>

            <div class="flex items-center gap-3">
                <x-button href="{{ route('membership.apply') }}" variant="gold" class="hidden sm:inline-flex">
                    Become a Member
                </x-button>

                {{-- Mobile toggle --}}
                <button
                    type="button"
                    class="focus-ring inline-flex h-11 w-11 items-center justify-center rounded-md text-white hover:bg-white/10 xl:hidden"
                    @click="mobileOpen = !mobileOpen; openDropdown = null"
                    :aria-expanded="mobileOpen.toString()"
                    aria-controls="mobile-menu"
                    aria-label="Toggle navigation menu">
                    <svg x-show="!mobileOpen" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg x-show="mobileOpen" x-cloak class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </nav>

    {{-- Mobile menu --}}
    <div
        x-cloak
        x-show="mobileOpen"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-2"
        id="mobile-menu"
        class="border-t border-white/10 bg-navy-900/80 backdrop-blur-xl xl:hidden">
        <nav class="container-page py-4" aria-label="Mobile">
            <ul class="flex flex-col" role="menu">
                {{-- Single links --}}
                @foreach ($singles as $item)
                @php $active = request()->routeIs($item['route']); @endphp
                <li role="none">
                    <a
                        href="{{ route($item['route']) }}"
                        role="menuitem"
                        @click="mobileOpen = false"
                        class="focus-ring flex items-center justify-between rounded-md px-3 py-3 text-base font-medium transition-colors hover:bg-white/5 {{ $active ? 'text-gold-300' : 'text-white' }}"
                        @if ($active) aria-current="page" @endif>
                        {{ $item['label'] }}
                        @if ($active)
                        <span class="h-1.5 w-1.5 rounded-full bg-gold-400" aria-hidden="true"></span>
                        @endif
                    </a>
                </li>
                @endforeach

                {{-- Mobile accordion dropdowns --}}
                @foreach ($dropdowns as $dropdown)
                @php
                $isDropdownActive = in_array(request()->route()->getName(), array_column($dropdown['items'], 'route'));
                @endphp
                <li role="none" x-data="{ open: {{ $isDropdownActive ? 'true' : 'false' }} }">
                    <button
                        type="button"
                        role="menuitem"
                        aria-haspopup="true"
                        :aria-expanded="open.toString()"
                        @click="open = !open"
                        class="focus-ring flex w-full items-center justify-between rounded-md px-3 py-3 text-base font-medium transition-colors hover:bg-white/5 {{ $isDropdownActive ? 'text-gold-300' : 'text-white' }}">
                        {{ $dropdown['label'] }}
                        <svg
                            class="h-4 w-4 transition-transform duration-200"
                            :class="open ? 'rotate-180' : ''"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div
                        x-show="open"
                        x-cloak
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 -translate-y-1"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 -translate-y-1"
                        class="ml-3 border-l-2 border-white/10 pl-3">
                        <ul class="flex flex-col py-1" role="menu">
                            @foreach ($dropdown['items'] as $item)
                            @php $active = request()->routeIs($item['route']); @endphp
                            <li role="none">
                                <a
                                    href="{{ route($item['route']) }}"
                                    role="menuitem"
                                    @click="mobileOpen = false"
                                    class="focus-ring flex items-center justify-between rounded-md px-3 py-2.5 text-sm font-medium transition-colors hover:bg-white/5 {{ $active ? 'text-gold-300' : 'text-white/80' }}"
                                    @if ($active) aria-current="page" @endif>
                                    {{ $item['label'] }}
                                    @if ($active)
                                    <span class="h-1.5 w-1.5 rounded-full bg-gold-400" aria-hidden="true"></span>
                                    @endif
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </li>
                @endforeach

                <li class="mt-3 border-t border-white/10 pt-3">
                    <x-button href="{{ route('membership.apply') }}" variant="gold" class="w-full" @click="mobileOpen = false">
                        Become a Member
                    </x-button>
                </li>
            </ul>
        </nav>
    </div>
</header>