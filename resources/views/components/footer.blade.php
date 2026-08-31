@php
    $explore = [
        ['label' => 'About the Association', 'route' => 'about'],
        ['label' => 'Our Alumni', 'route' => 'alumni.index'],
        ['label' => 'Events', 'route' => 'events.index'],
        ['label' => 'News & Updates', 'route' => 'news.index'],
        ['label' => 'Alumni Stories', 'route' => 'stories.index'],
        ['label' => 'Publications', 'route' => 'publications.index'],
        ['label' => 'Photo Gallery', 'route' => 'gallery.index'],
        ['label' => 'Become a Member', 'route' => 'membership.apply'],
    ];

    // Only advertised publicly while the contribution leaderboard is enabled.
    if (\App\Models\SiteSetting::leaderboardEnabled()) {
        $explore[] = ['label' => 'Member Leaderboard', 'route' => 'leaderboard.index'];
    }

    // Public finance transparency (Feature 16) — hidden while disabled.
    if (\App\Models\SiteSetting::financePublicEnabled()) {
        $explore[] = ['label' => 'Financial Transparency', 'route' => 'finance.public'];
    }

    $site = config('site');

    $socials = [
        'facebook' => ['label' => 'Facebook', 'path' => 'M13.5 9H16l.5-3h-3V4.5c0-.9.3-1.5 1.6-1.5H16.6V.2C16.3.2 15.3 0 14.1 0 11.5 0 9.7 1.6 9.7 4.4V6H7v3h2.7v9h3.8V9z'],
        'twitter' => ['label' => 'Twitter / X', 'path' => 'M17.5 3H20l-6.1 7 7.2 9.5h-5.6l-4.4-5.8-5 5.8H4.3l6.5-7.5L3.7 3h5.7l4 5.3L17.5 3zm-1 16h1.6L7.4 4.5H5.7L16.5 19z'],
        'instagram' => ['label' => 'Instagram', 'path' => 'M12 2.2c3.2 0 3.6 0 4.9.1 1.2.1 1.8.2 2.2.4.6.2 1 .5 1.4.9.4.4.7.8.9 1.4.2.4.4 1 .4 2.2.1 1.3.1 1.7.1 4.9s0 3.6-.1 4.9c-.1 1.2-.2 1.8-.4 2.2-.2.6-.5 1-.9 1.4-.4.4-.8.7-1.4.9-.4.2-1 .4-2.2.4-1.3.1-1.7.1-4.9.1s-3.6 0-4.9-.1c-1.2-.1-1.8-.2-2.2-.4-.6-.2-1-.5-1.4-.9-.4-.4-.7-.8-.9-1.4-.2-.4-.4-1-.4-2.2C2.2 15.6 2.2 15.2 2.2 12s0-3.6.1-4.9c.1-1.2.2-1.8.4-2.2.2-.6.5-1 .9-1.4.4-.4.8-.7 1.4-.9.4-.2 1-.4 2.2-.4C8.4 2.2 8.8 2.2 12 2.2zm0 2.3c-3.1 0-3.5 0-4.7.1-1.1.1-1.7.2-2.1.4-.5.2-.9.4-1.2.8-.4.4-.6.7-.8 1.2-.2.4-.4 1-.4 2.1-.1 1.2-.1 1.6-.1 4.7s0 3.5.1 4.7c.1 1.1.2 1.7.4 2.1.2.5.4.9.8 1.2.4.4.7.6 1.2.8.4.2 1 .4 2.1.4 1.2.1 1.6.1 4.7.1s3.5 0 4.7-.1c1.1-.1 1.7-.2 2.1-.4.5-.2.9-.4 1.2-.8.4-.4.6-.7.8-1.2.2-.4.4-1 .4-2.1.1-1.2.1-1.6.1-4.7s0-3.5-.1-4.7c-.1-1.1-.2-1.7-.4-2.1-.2-.5-.4-.9-.8-1.2-.4-.4-.7-.6-1.2-.8-.4-.2-1-.4-2.1-.4-1.2-.1-1.6-.1-4.7-.1zm0 3.9a3.6 3.6 0 100 7.2 3.6 3.6 0 000-7.2zm0 5.9a2.3 2.3 0 110-4.6 2.3 2.3 0 010 4.6zm4.6-6a.8.8 0 11-1.6 0 .8.8 0 011.6 0z'],
        'linkedin' => ['label' => 'LinkedIn', 'path' => 'M6.9 8.6H3.6V20h3.3V8.6zM5.3 7.2a1.9 1.9 0 100-3.8 1.9 1.9 0 000 3.8zM20.4 13.4c0-3.3-1.8-4.9-4.2-4.9-1.9 0-2.8 1.1-3.3 1.8V8.6H9.6V20h3.3v-6c0-1.6.8-2.6 2.1-2.6 1.3 0 1.9.9 1.9 2.6v6h3.5v-6.6z'],
        'youtube' => ['label' => 'YouTube', 'path' => 'M21.6 7.2a2.5 2.5 0 00-1.8-1.8C18.2 5 12 5 12 5s-6.2 0-7.8.4A2.5 2.5 0 002.4 7.2 26 26 0 002 12a26 26 0 00.4 4.8 2.5 2.5 0 001.8 1.8c1.6.4 7.8.4 7.8.4s6.2 0 7.8-.4a2.5 2.5 0 001.8-1.8A26 26 0 0022 12a26 26 0 00-.4-4.8zM10 15.2V8.8L15.5 12 10 15.2z'],
    ];
@endphp

<footer class="bg-navy-950/95 backdrop-blur-sm text-navy-100 footer-glow">
    <div class="container-page grid gap-12 py-16 sm:grid-cols-2 lg:grid-cols-12 lg:gap-8 lg:py-20">
        {{-- Brand --}}
        <div class="lg:col-span-4">
            <a href="{{ route('home') }}" class="focus-ring inline-flex items-center gap-3 rounded-md" aria-label="{{ $site['name'] }} home">
                <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-md bg-maroon-700 font-serif text-sm font-bold tracking-wide text-white ring-1 ring-gold-500/60">
                    EDAA
                </span>
                <span class="leading-tight">
                    <span class="block font-serif text-lg font-semibold tracking-tight text-white">
                        {{ $site['short_name'] }}
                    </span>
                    <span class="block text-[11px] font-medium uppercase tracking-widest text-gold-300">
                        KNGC · Dhaka
                    </span>
                </span>
            </a>

            <p class="mt-5 max-w-sm text-sm leading-relaxed text-navy-200">
                {{ $site['description'] }}
            </p>

            <ul class="mt-6 flex items-center gap-3">
                @foreach ($socials as $key => $social)
                    @if (($site['social'][$key] ?? '#') !== '#')
                    <li>
                        <a
                            href="{{ \App\Support\UrlHelper::safeHref($site['social'][$key]) }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            aria-label="{{ $social['label'] }} (opens in a new tab)"
                            class="focus-ring flex h-10 w-10 items-center justify-center rounded-lg border border-white/10 bg-white/5 text-navy-100 backdrop-blur-sm transition-all duration-300 hover:border-gold-500/50 hover:bg-gold-500/10 hover:text-gold-300 hover:shadow-lg hover:shadow-gold-500/10"
                        >
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                <path d="{{ $social['path'] }}" />
                            </svg>
                        </a>
                    </li>
                    @endif
                @endforeach
            </ul>
        </div>

        {{-- Explore --}}
        <nav class="lg:col-span-2" aria-label="Footer explore links">
            <h2 class="font-serif text-base font-semibold text-white">Explore</h2>
            <ul class="mt-4 space-y-2.5 text-sm">
                @foreach ($explore as $link)
                    <li>
                        <a href="{{ route($link['route']) }}" class="focus-ring rounded text-navy-200 transition-colors hover:text-gold-300">
                            {{ $link['label'] }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </nav>

        {{-- Important --}}
        <nav class="lg:col-span-2" aria-label="Footer information links">
            <h2 class="font-serif text-base font-semibold text-white">Information</h2>
            <ul class="mt-4 space-y-2.5 text-sm">
                <li>
                    <a href="{{ route('about') }}" class="focus-ring rounded text-navy-200 transition-colors hover:text-gold-300">
                        About the Association
                    </a>
                </li>
                <li>
                    <a href="{{ route('committee.index') }}" class="focus-ring rounded text-navy-200 transition-colors hover:text-gold-300">
                        Executive Committee
                    </a>
                </li>
                <li>
                    <a href="{{ route('membership.apply') }}" class="focus-ring rounded text-navy-200 transition-colors hover:text-gold-300">
                        Become a Member
                    </a>
                </li>
                <li>
                    <a href="{{ route('contact') }}" class="focus-ring rounded text-navy-200 transition-colors hover:text-gold-300">
                        Contact Us
                    </a>
                </li>
            </ul>
        </nav>

        {{-- Contact --}}
        <div class="lg:col-span-4">
            <h2 class="font-serif text-base font-semibold text-white">Get in Touch</h2>
            <ul class="mt-4 space-y-4 text-sm">
                <li class="flex items-start gap-3">
                    <svg class="mt-0.5 h-5 w-5 shrink-0 text-gold-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l9 6 9-6M4 5h16a1 1 0 011 1v12a1 1 0 01-1 1H4a1 1 0 01-1-1V6a1 1 0 011-1z" />
                    </svg>
                    <a href="mailto:{{ $site['email'] }}" class="focus-ring rounded break-all text-navy-200 transition-colors hover:text-gold-300">
                        {{ $site['email'] }}
                    </a>
                </li>
                <li class="flex items-start gap-3">
                    <svg class="mt-0.5 h-5 w-5 shrink-0 text-gold-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.3a1 1 0 011 .8l.8 3a1 1 0 01-.4 1l-1.6 1.2a12 12 0 005 5l1.2-1.6a1 1 0 011-.4l3 .8a1 1 0 01.8 1V19a2 2 0 01-2 2A16 16 0 013 5z" />
                    </svg>
                    <a href="tel:{{ preg_replace('/[^0-9+]/', '', $site['phone']) }}" class="focus-ring rounded text-navy-200 transition-colors hover:text-gold-300">
                        {{ $site['phone'] }}
                    </a>
                </li>
                <li class="flex items-start gap-3">
                    <svg class="mt-0.5 h-5 w-5 shrink-0 text-gold-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.7 11.9l-6.8 6.9a2 2 0 01-2.8 0l-3-3a2 2 0 010-2.8l6.9-6.8M14.8 3.2L20.8 9.2m-2-2l-4.5 4.5a4 4 0 00-1 2.1l-.2 1.5a.5.5 0 00.6.6l1.5-.2a4 4 0 002.1-1l4.5-4.5a2 2 0 000-2.8l-2.5-2.5a2 2 0 00-2.8 0z" />
                    </svg>
                    <span class="leading-relaxed text-navy-200">{{ $site['address'] }}</span>
                </li>
            </ul>
        </div>
    </div>

    {{-- Bottom bar --}}
    <div class="border-t border-white/10">
        <div class="container-page flex flex-col items-center justify-between gap-3 py-6 text-xs text-navy-300 sm:flex-row">
            <p>
                &copy; {{ date('Y') }} {{ $site['name'] }}. All rights reserved.
            </p>
            <ul class="flex items-center gap-5">
                <li>
                    <a href="https://facebook.com/shovon.5271" target="_blank" rel="noopener noreferrer" class="focus-ring rounded transition-colors hover:text-gold-300">
                        Crafted by Shovon | 18-19
                    </a>
                </li>
            </ul>
        </div>
    </div>
</footer>