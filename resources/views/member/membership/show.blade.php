<x-layouts.app :title="'My Membership'">
    <section class="bg-navy-950 py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <h1 class="font-serif text-3xl font-bold text-white">Membership Details</h1>
            <p class="mt-2 text-sm text-white/60">Your membership information and status</p>
        </div>
    </section>

    <section class="py-10">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                <aside class="lg:col-span-1">
                    <div class="rounded-lg border border-navy-100 bg-white p-4 shadow-sm">
                        <x-member.sidebar />
                    </div>
                </aside>

                <main class="lg:col-span-3 space-y-6">
                    @if (session('success'))
                        <div class="rounded-md border border-emerald-200 bg-emerald-50 p-4">
                            <p class="text-sm text-emerald-800">{{ session('success') }}</p>
                        </div>
                    @endif

                    {{-- Membership card --}}
                    <div class="premium-card overflow-hidden">
                        <div class="bg-gradient-to-r from-navy-950 to-navy-800 px-6 py-8 relative">
                            <div class="absolute right-0 top-0 h-full w-1/3 bg-gradient-to-l from-white/5 to-transparent"></div>
                            <div class="relative z-10 flex items-center justify-between">
                                <div>
                                    <p class="text-xs font-medium text-white/50 uppercase tracking-widest mb-1">Membership ID</p>
                                    <h2 class="font-serif text-3xl font-bold text-white tracking-tight">{{ $membership->membership_number }}</h2>
                                </div>
                                <div class="text-right">
                                    <p class="text-xs font-medium text-white/50 uppercase tracking-widest mb-1">Tier</p>
                                    <p class="text-lg font-semibold text-white bg-white/10 px-3 py-1 rounded-full backdrop-blur-sm border border-white/10">{{ $membership->tier?->name ?? 'Standard' }}</p>
                                </div>
                            </div>
                            <div class="relative z-10 mt-8 flex items-center gap-6 text-sm text-white/70">
                                <div class="flex flex-col">
                                    <span class="text-xs text-white/50 uppercase tracking-wider mb-0.5">Type</span>
                                    <strong class="text-white">{{ $membership->type?->name ?? '-' }}</strong>
                                </div>
                                <div class="w-px h-8 bg-white/10"></div>
                                <div class="flex flex-col">
                                    <span class="text-xs text-white/50 uppercase tracking-wider mb-0.5">Member Since</span>
                                    <strong class="text-white">{{ $membership->joined_at?->format('F Y') ?? '-' }}</strong>
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 sm:grid-cols-4 divide-x divide-y sm:divide-y-0 divide-navy-50">
                            <div class="px-5 py-5 text-center bg-white">
                                <p class="text-xs font-medium uppercase tracking-wider text-ink-soft mb-1">Status</p>
                                <p class="text-sm font-semibold
                                    {{ $membership->status === 'active' ? 'text-emerald-600' : 'text-amber-600' }}">
                                    {{ ucfirst($membership->status) }}
                                </p>
                            </div>
                            <div class="px-5 py-5 text-center bg-white">
                                <p class="text-xs font-medium uppercase tracking-wider text-ink-soft mb-1">Total Paid</p>
                                <p class="text-sm font-semibold text-navy-900">{{ number_format($totalPaid) }}&#2547;</p>
                            </div>
                            <div class="px-5 py-5 text-center bg-white">
                                <p class="text-xs font-medium uppercase tracking-wider text-ink-soft mb-1">Outstanding</p>
                                <p class="text-sm font-semibold {{ $outstandingBalance > 0 ? 'text-red-600' : 'text-emerald-600' }}">{{ number_format($outstandingBalance) }}&#2547;</p>
                            </div>
                            <div class="px-5 py-5 text-center bg-white">
                                <p class="text-xs font-medium uppercase tracking-wider text-ink-soft mb-1">Visibility</p>
                                <p class="text-sm font-semibold text-navy-900">{{ $membership->is_public ? 'Public' : 'Private' }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Visibility toggle --}}
                    <div class="premium-card p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="font-medium text-navy-950">Public Directory Visibility</h3>
                                <p class="mt-1 text-sm text-ink-soft max-w-xl">Allow other alumni and visitors to see your profile in the public directory. Your personal contact information remains hidden.</p>
                            </div>
                            <form method="POST" action="{{ route('member.visibility.toggle') }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                        class="relative inline-flex h-6 w-11 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus-ring {{ $membership->is_public ? 'bg-emerald-500' : 'bg-navy-200' }}">
                                    <span class="pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out {{ $membership->is_public ? 'translate-x-5' : 'translate-x-0' }}"></span>
                                </button>
                            </form>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </section>
</x-layouts.app>
