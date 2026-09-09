@props([
'title' => null,
])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full antialiased">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="noindex, nofollow">

    <title>{{ $title ? $title . ' · Admin | ' . config('site.name') : 'Admin Portal · ' . config('site.name') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Playfair+Display:ital,wght@0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('build/assets/styles.css') }}">

    @stack('head')
</head>

<body class="min-h-full bg-slate-50 font-sans text-navy-950">
    <a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:z-[100] focus:m-4 focus:rounded-xl focus:bg-gold-500 focus:px-4 focus:py-2.5 focus:text-sm focus:font-bold focus:text-navy-950 focus:shadow-xl">
        Skip to content
    </a>

    <div id="admin-layout" class="min-h-screen lg:flex">
        {{-- Mobile Backdrop Overlay --}}
        <div
            id="sidebar-backdrop"
            class="fixed inset-0 z-40 bg-navy-950/70 backdrop-blur-xs hidden lg:hidden"
            aria-hidden="true"></div>

        {{-- Sidebar Component --}}
        <x-admin.sidebar :open="false" />

        {{-- Main Content Canvas --}}
        <div class="flex min-w-0 flex-1 flex-col">
            <x-admin.topbar @toggle-sidebar="toggleSidebar()" @open-command-palette="openCommandPalette()" />

            <main id="main-content" class="flex-1 p-4 sm:p-6 lg:p-8">
                <div class="mx-auto w-full max-w-7xl">
                    {{ $slot }}
                </div>
            </main>

            <footer class="border-t border-navy-100 bg-white/70 px-4 py-4 sm:px-6 lg:px-8">
                <div class="mx-auto flex max-w-7xl flex-col sm:flex-row items-center justify-between gap-2 text-xs text-navy-500">
                    <p>&copy; {{ date('Y') }} {{ config('site.name') }} · Executive Management Suite</p>
                    <p class="text-[11px] text-navy-400">English Department Alumni Association · KNGC</p>
                </div>
            </footer>
        </div>
    </div>

    {{-- Global Spotlight Command Palette (Ctrl+K / Cmd+K) --}}
    <div
        id="command-palette-overlay"
        class="fixed inset-0 z-50 bg-navy-950/70 backdrop-blur-sm hidden items-start justify-center pt-16 sm:pt-24 px-4"
        aria-hidden="true">
        <div
            id="command-palette-panel"
            class="w-full max-w-xl overflow-hidden rounded-2xl bg-white shadow-2xl ring-1 ring-navy-900/10 border border-navy-100 transform scale-95 opacity-0 transition-all duration-200">
            {{-- Search Input Bar --}}
            <div class="relative flex items-center border-b border-navy-100 px-4 py-3 bg-navy-50/50">
                <svg class="h-5 w-5 text-navy-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <input
                    id="command-palette-input"
                    type="text"
                    placeholder="Type a command, page, or action..."
                    class="w-full border-0 bg-transparent px-3 py-1.5 text-sm text-navy-950 placeholder:text-navy-400 focus:outline-none focus:ring-0"
                    autocomplete="off">
                <kbd class="rounded bg-white px-2 py-0.5 font-mono text-[10px] font-semibold text-navy-400 border border-navy-200 shadow-2xs">ESC</kbd>
            </div>

            {{-- Search Results List --}}
            <div id="command-palette-results" class="max-h-80 overflow-y-auto p-2">
                <div id="command-palette-empty" class="py-10 text-center text-xs text-navy-400 hidden">
                    No matching admin modules or actions found for "<span id="command-palette-query-display" class="font-semibold text-navy-700"></span>"
                </div>
                <div id="command-palette-list" class="space-y-1"></div>
            </div>

            {{-- Footer Hints --}}
            <div class="flex items-center justify-between border-t border-navy-100 bg-navy-50/70 px-4 py-2 text-[11px] text-navy-500">
                <div class="flex items-center gap-2">
                    <span>Navigation:</span>
                    <kbd class="font-mono text-[10px] bg-white px-1.5 py-0.5 rounded border border-navy-200">↑</kbd>
                    <kbd class="font-mono text-[10px] bg-white px-1.5 py-0.5 rounded border border-navy-200">↓</kbd>
                    <kbd class="font-mono text-[10px] bg-white px-1.5 py-0.5 rounded border border-navy-200">↵</kbd>
                </div>
                <span>EDAA Quick Switcher</span>
            </div>
        </div>
    </div>

    {{-- Global Animated Toast Notification System --}}
    <div
        id="toast-container"
        class="fixed bottom-5 right-5 z-50 flex flex-col gap-2.5 max-w-sm w-full pointer-events-none px-4 sm:px-0"></div>

    <script src="{{ asset('build/assets/app.js') }}"></script>
    @stack('scripts')
</body>

</html>