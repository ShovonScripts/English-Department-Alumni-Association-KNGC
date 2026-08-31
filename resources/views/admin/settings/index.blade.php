<x-layouts.admin title="Site Settings">
    <div class="mb-8">
        <h1 class="font-serif text-3xl font-semibold tracking-tight text-navy-950">Site Settings</h1>
        <p class="mt-1 text-sm text-ink-soft">
            Manage global site settings including the public announcement bar.
        </p>
    </div>

    @if (session('status'))
        <div class="mb-6 flex items-center gap-3 rounded-md border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800" role="status">
            <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('admin.settings.update') }}" class="space-y-8">
        @csrf
        @method('PUT')

        {{-- Announcement Bar --}}
        <div class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm">
            <div class="flex items-center gap-3 mb-4">
                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-maroon-100">
                    <svg class="h-5 w-5 text-maroon-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-lg font-semibold text-navy-950">Announcement Bar</h2>
                    <p class="text-sm text-ink-soft">Display a scrolling announcement banner at the top of the site.</p>
                </div>
            </div>

            {{-- Enable/Disable Toggle --}}
            <div class="flex items-center gap-4 rounded-lg bg-navy-50/60 px-4 py-3 mb-4">
                <label for="announcement_enabled" class="flex items-center gap-3 cursor-pointer">
                    <input
                        type="checkbox"
                        name="announcement_enabled"
                        id="announcement_enabled"
                        value="1"
                        {{ $announcementEnabled ? 'checked' : '' }}
                        class="h-5 w-5 rounded border-navy-300 text-gold-500 focus:ring-gold-500/30 cursor-pointer"
                    >
                    <span class="text-sm font-medium text-navy-950">Enable Announcement Bar</span>
                </label>
                <span class="ml-auto text-xs {{ $announcementEnabled ? 'text-emerald-600' : 'text-ink-soft' }}">
                    {{ $announcementEnabled ? 'Currently visible on the site' : 'Hidden from visitors' }}
                </span>
            </div>

            {{-- Announcement Text --}}
            <div>
                <label for="announcement_text" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Announcement Text</label>
                <textarea
                    id="announcement_text"
                    name="announcement_text"
                    rows="3"
                    maxlength="500"
                    placeholder="e.g. Special Launch Offer – Use Coupon Code NAS100 and get 100% OFF your setup fee!"
                    class="w-full rounded-md border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 placeholder-navy-400 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none resize-none"
                >{{ $announcementText }}</textarea>
                <p class="mt-1 text-xs text-ink-soft">Maximum 500 characters. This text will scroll across the announcement bar.</p>
            </div>

            {{-- Preview --}}
            @if ($announcementEnabled && $announcementText)
                <div class="mt-4 rounded-lg border border-navy-200 bg-navy-900 overflow-hidden">
                    <p class="px-4 py-2 text-[11px] font-semibold uppercase tracking-widest text-navy-400 border-b border-white/10">Preview</p>
                    <div class="overflow-hidden h-10 flex items-center">
                        <div class="announcement-track flex w-max h-full items-center" style="animation: scroll 20s linear infinite;">
                            <span class="inline-flex items-center gap-2 text-white text-sm font-medium px-3 whitespace-nowrap">
                                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
                                <span>{{ $announcementText }}</span>
                            </span>
                            <span class="inline-flex items-center gap-2 text-white text-sm font-medium px-3 whitespace-nowrap" aria-hidden="true">
                                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
                                <span>{{ $announcementText }}</span>
                            </span>
                        </div>
                    </div>
                </div>
                <style>
                    @keyframes scroll {
                        0% { transform: translateX(0); }
                        100% { transform: translateX(-50%); }
                    }
                </style>
            @endif
        </div>

        {{-- Submit --}}
        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('admin.dashboard') }}" class="focus-ring inline-flex items-center justify-center rounded-md px-4 py-2.5 text-sm font-semibold text-navy-600 transition-colors hover:bg-navy-50">
                Cancel
            </a>
            <x-button type="submit" variant="gold">
                Save Settings
            </x-button>
        </div>
    </form>
</x-layouts.admin>
