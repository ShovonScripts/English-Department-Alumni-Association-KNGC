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

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @stack('head')
    </head>
    <body class="min-h-full bg-slate-50 font-sans text-navy-950">
        <a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:z-[100] focus:m-4 focus:rounded-xl focus:bg-gold-500 focus:px-4 focus:py-2.5 focus:text-sm focus:font-bold focus:text-navy-950 focus:shadow-xl">
            Skip to content
        </a>

        <div
            x-data="{ sidebarOpen: false }"
            @keydown.escape.window="sidebarOpen = false"
            class="min-h-screen lg:flex"
        >
            {{-- Mobile Backdrop Overlay --}}
            <div
                x-cloak
                x-show="sidebarOpen"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                @click="sidebarOpen = false"
                class="fixed inset-0 z-40 bg-navy-950/70 backdrop-blur-xs lg:hidden"
                aria-hidden="true"
            ></div>

            {{-- Sidebar Component --}}
            <x-admin.sidebar :open="false" />

            {{-- Main Content Canvas --}}
            <div class="flex min-w-0 flex-1 flex-col">
                <x-admin.topbar @toggle-sidebar="sidebarOpen = true" />

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
            x-data="{
                open: false,
                query: '',
                selectedIndex: 0,
                items: [
                    { title: 'Dashboard', url: '{{ route('admin.dashboard') }}', category: 'Navigation', icon: 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6' },
                    { title: 'Alumni Directory', url: '{{ route('admin.alumni.index') }}', category: 'Community', icon: 'M17 20h5v-2a3 3 0 00-5.4-1.7M9 20H4v-2a3 3 0 015.4-1.7M16 3.1a3 3 0 110 5.8M11 7a3 3 0 11-6 0 3 3 0 016 0z' },
                    { title: 'Batches Management', url: '{{ route('admin.batches.index') }}', category: 'Community', icon: 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10' },
                    { title: 'Members List', url: '{{ route('admin.members.index') }}', category: 'Community', icon: 'M12 4.35a2.65 2.65 0 110 5.3 2.65 2.65 0 010-5.3zM5 21v-1.6A5.4 5.4 0 0110.4 14h3.2A5.4 5.4 0 0119 19.4V21m2-9.5l1.6 1.6M21 5.5L19.4 7M3 11.5L4.6 13.1M5 5.5L6.6 7.1' },
                    { title: 'Membership Applications', url: '{{ route('admin.membership-applications.index') }}', category: 'Community', icon: 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2' },
                    { title: 'Correction Requests', url: '{{ route('admin.correction-requests.index') }}', category: 'Community', icon: 'M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z' },
                    { title: 'Committees & Roles', url: '{{ route('admin.committee-types.index') }}', category: 'Community', icon: 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5' },
                    { title: 'Events Calendar', url: '{{ route('admin.events.index') }}', category: 'Content', icon: 'M8 7V3m8 4V3M4 11h16M5 5h14a1 1 0 011 1v13a1 1 0 01-1 1H5a1 1 0 01-1-1V6a1 1 0 011-1z' },
                    { title: 'Create New Event', url: '{{ route('admin.events.create') }}', category: 'Actions', icon: 'M12 4.5v15m7.5-7.5h-15' },
                    { title: 'News & Announcements', url: '{{ route('admin.news.index') }}', category: 'Content', icon: 'M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7' },
                    { title: 'Create News Article', url: '{{ route('admin.news.create') }}', category: 'Actions', icon: 'M12 4.5v15m7.5-7.5h-15' },
                    { title: 'Alumni Stories', url: '{{ route('admin.stories.index') }}', category: 'Content', icon: 'M9.6 4C5.4 5.4 3 8.6 3 13.2V20h6.8' },
                    { title: 'Photo Gallery', url: '{{ route('admin.gallery.index') }}', category: 'Content', icon: 'M4 16l4.586-4.586a2 2 0 012.828 0L16 16' },
                    { title: 'Publications & Research', url: '{{ route('admin.publications.index') }}', category: 'Content', icon: 'M12 6.3v11.4m0-11.4A3.2 3.2 0 009.5 3.5H6.5v13' },
                    { title: 'Financial Overview', url: '{{ route('admin.finance.index') }}', category: 'Finance', icon: 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2' },
                    { title: 'Payments & Fee Dues', url: '{{ route('admin.payments.index') }}', category: 'Finance', icon: 'M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2' },
                    { title: 'Record Payment', url: '{{ route('admin.payments.create') }}', category: 'Actions', icon: 'M12 4.5v15m7.5-7.5h-15' },
                    { title: 'Association Expenses', url: '{{ route('admin.expenses.index') }}', category: 'Finance', icon: 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2' },
                    { title: 'Record Expense', url: '{{ route('admin.expenses.create') }}', category: 'Actions', icon: 'M12 4.5v15m7.5-7.5h-15' },
                    { title: 'Donor Leaderboard', url: '{{ route('admin.leaderboard.index') }}', category: 'Finance', icon: 'M5 3v4M3 5h4M6 17v4m-2-2h4' },
                    { title: 'Contact Messages & Inquiries', url: '{{ route('admin.messages.index') }}', category: 'Inbox', icon: 'M3 8l7.89 5.26a2 2 0 002.22 0L21 8' },
                    { title: 'Site Settings & Branding', url: '{{ route('admin.settings.index') }}', category: 'System', icon: 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0' },
                    { title: 'View Live Public Site', url: '{{ route('home') }}', category: 'System', icon: 'M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10' }
                ],
                get filtered() {
                    if (!this.query.trim()) return this.items;
                    const q = this.query.toLowerCase();
                    return this.items.filter(item =>
                        item.title.toLowerCase().includes(q) ||
                        item.category.toLowerCase().includes(q)
                    );
                },
                navigate(index) {
                    const target = this.filtered[index];
                    if (target) {
                        window.location.href = target.url;
                    }
                }
            }"
            @open-command-palette.window="open = true; $nextTick(() => $refs.searchInput.focus())"
            @keydown.window.prevent.ctrl.k="open = true; $nextTick(() => $refs.searchInput.focus())"
            @keydown.window.prevent.cmd.k="open = true; $nextTick(() => $refs.searchInput.focus())"
            @keydown.escape.window="open = false"
            x-cloak
        >
            <div
                x-show="open"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 z-50 bg-navy-950/70 backdrop-blur-sm flex items-start justify-center pt-16 sm:pt-24 px-4"
                @click.self="open = false"
                style="display: none;"
            >
                <div
                    x-show="open"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                    x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                    x-transition:leave-end="opacity-0 scale-95 translate-y-2"
                    class="w-full max-w-xl overflow-hidden rounded-2xl bg-white shadow-2xl ring-1 ring-navy-900/10 border border-navy-100"
                >
                    {{-- Search Input Bar --}}
                    <div class="relative flex items-center border-b border-navy-100 px-4 py-3 bg-navy-50/50">
                        <svg class="h-5 w-5 text-navy-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <input
                            x-ref="searchInput"
                            type="text"
                            x-model="query"
                            @keydown.arrow-down.prevent="selectedIndex = Math.min(selectedIndex + 1, filtered.length - 1)"
                            @keydown.arrow-up.prevent="selectedIndex = Math.max(selectedIndex - 1, 0)"
                            @keydown.enter.prevent="navigate(selectedIndex)"
                            placeholder="Type a command, page, or action..."
                            class="w-full border-0 bg-transparent px-3 py-1.5 text-sm text-navy-950 placeholder:text-navy-400 focus:outline-none focus:ring-0"
                        >
                        <kbd class="rounded bg-white px-2 py-0.5 font-mono text-[10px] font-semibold text-navy-400 border border-navy-200 shadow-2xs">ESC</kbd>
                    </div>

                    {{-- Search Results List --}}
                    <div class="max-h-80 overflow-y-auto p-2">
                        <template x-if="filtered.length === 0">
                            <div class="py-10 text-center text-xs text-navy-400">
                                No matching admin modules or actions found for "<span x-text="query" class="font-semibold text-navy-700"></span>"
                            </div>
                        </template>

                        <template x-for="(item, index) in filtered" :key="item.url">
                            <a
                                :href="item.url"
                                @mouseenter="selectedIndex = index"
                                :class="selectedIndex === index ? 'bg-navy-50 text-navy-950 ring-1 ring-navy-200/70' : 'text-navy-700 hover:bg-navy-50/60'"
                                class="flex items-center justify-between rounded-xl px-3 py-2 text-xs font-medium transition-colors"
                            >
                                <div class="flex items-center gap-3 min-w-0">
                                    <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-navy-100 text-navy-700 shrink-0">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" :d="item.icon" />
                                        </svg>
                                    </span>
                                    <span x-text="item.title" class="truncate font-semibold"></span>
                                </div>
                                <span x-text="item.category" class="rounded-full bg-navy-100/70 px-2 py-0.5 text-[10px] font-medium text-navy-600"></span>
                            </a>
                        </template>
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
        </div>

        {{-- Global Animated Toast Notification System --}}
        <div
            x-data="{
                toasts: [],
                add(message, type = 'success') {
                    const id = Date.now() + Math.random();
                    this.toasts.push({ id, message, type });
                    setTimeout(() => this.remove(id), 5000);
                },
                remove(id) {
                    this.toasts = this.toasts.filter(t => t.id !== id);
                }
            }"
            x-init="
                @if (session('status'))
                    add('{{ addslashes(session('status')) }}', 'success');
                @endif
                @if (session('success'))
                    add('{{ addslashes(session('success')) }}', 'success');
                @endif
                @if (session('error'))
                    add('{{ addslashes(session('error')) }}', 'error');
                @endif
                @if (session('warning'))
                    add('{{ addslashes(session('warning')) }}', 'warning');
                @endif
            "
            @notify.window="add($event.detail.message, $event.detail.type || 'success')"
            class="fixed bottom-5 right-5 z-50 flex flex-col gap-2.5 max-w-sm w-full pointer-events-none px-4 sm:px-0"
        >
            <template x-for="toast in toasts" :key="toast.id">
                <div
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-3 scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                    :class="{
                        'border-emerald-200 bg-emerald-50/95 text-emerald-950 ring-emerald-500/20': toast.type === 'success',
                        'border-rose-200 bg-rose-50/95 text-rose-950 ring-rose-500/20': toast.type === 'error',
                        'border-amber-200 bg-amber-50/95 text-amber-950 ring-amber-500/20': toast.type === 'warning',
                        'border-navy-200 bg-white/95 text-navy-950 ring-navy-500/20': toast.type === 'info'
                    }"
                    class="pointer-events-auto flex items-start gap-3 rounded-2xl border p-4 shadow-xl backdrop-blur-md ring-1"
                >
                    <div class="shrink-0 mt-0.5">
                        <template x-if="toast.type === 'success'">
                            <span class="flex h-6 w-6 items-center justify-center rounded-full bg-emerald-600 text-white">
                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                </svg>
                            </span>
                        </template>
                        <template x-if="toast.type === 'error'">
                            <span class="flex h-6 w-6 items-center justify-center rounded-full bg-rose-600 text-white">
                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </span>
                        </template>
                        <template x-if="toast.type === 'warning'">
                            <span class="flex h-6 w-6 items-center justify-center rounded-full bg-amber-600 text-white">
                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </span>
                        </template>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-medium leading-relaxed" x-text="toast.message"></p>
                    </div>
                    <button
                        type="button"
                        @click="remove(toast.id)"
                        class="shrink-0 text-navy-400 hover:text-navy-600 focus:outline-none"
                    >
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </template>
        </div>

        @stack('scripts')
    </body>
</html>