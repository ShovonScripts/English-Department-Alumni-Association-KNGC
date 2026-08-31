<header class="sticky top-0 z-30 flex h-16 items-center justify-between gap-4 border-b border-navy-100 bg-white px-4 sm:px-6 lg:px-8">
    <div class="flex items-center gap-3">
        <button
            type="button"
            class="focus-ring inline-flex h-10 w-10 items-center justify-center rounded-md text-navy-700 hover:bg-cream lg:hidden"
            @click="$dispatch('toggle-sidebar')"
            aria-label="Open sidebar"
        >
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>

        <div>
            <p class="text-sm font-semibold text-navy-950">{{ $heading ?? 'Dashboard' }}</p>
            <p class="hidden text-xs text-ink-soft sm:block">Association admin area</p>
        </div>
    </div>

    <div class="flex items-center gap-3">
        <div class="hidden items-center gap-2 sm:flex">
            <p class="text-sm font-medium text-navy-950">{{ Auth::user()->name }}</p>
            <p class="text-xs text-ink-soft">{{ Auth::user()->email }}</p>
        </div>

        <a
            href="{{ route('home') }}"
            target="_blank"
            rel="noopener noreferrer"
            class="focus-ring hidden items-center gap-2 rounded-md border border-navy-200 px-3 py-2 text-sm font-medium text-navy-700 transition-colors hover:bg-cream sm:inline-flex"
        >
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
            </svg>
            View Site
        </a>

        <form method="POST" action="{{ route('admin.logout') }}" class="hidden sm:inline-flex">
            @csrf
            @method('DELETE')
            <button
                type="submit"
                class="focus-ring items-center gap-2 rounded-md border border-navy-200 px-3 py-2 text-sm font-medium text-navy-700 transition-colors hover:bg-cream"
            >
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                Logout
            </button>
        </form>

        <span class="flex h-10 w-10 items-center justify-center rounded-full bg-navy-900 font-serif text-sm font-semibold text-gold-300" aria-label="Admin user">
            {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
        </span>
    </div>
</header>
