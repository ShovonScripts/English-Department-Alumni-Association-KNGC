<x-layouts.app :title="$title ?? 'Member Dashboard'">
    <section class="bg-navy-950 py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div class="flex items-center gap-4">
                    @if ($alumni->profile_photo)
                        <img src="{{ $alumni->profile_photo_url }}" alt="{{ $alumni->full_name }}" class="h-16 w-16 rounded-full object-cover border-2 border-navy-800 shadow-sm">
                    @else
                        <div class="flex h-16 w-16 items-center justify-center rounded-full bg-navy-800 text-white font-medium text-xl border-2 border-navy-700 shadow-sm">
                            {{ substr($alumni->full_name, 0, 1) }}
                        </div>
                    @endif
                    <div>
                        <h1 class="font-serif text-3xl font-bold text-white flex items-center gap-2">
                            {{ $alumni->full_name }}
                            @if(auth()->user()->isVerified())
                                <svg class="h-6 w-6 text-emerald-400" fill="currentColor" viewBox="0 0 24 24" aria-label="Verified Member"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
                            @endif
                        </h1>
                        <p class="mt-1 text-sm text-white/70">Your EDAA-KNGC member space. &bull; {{ $membership->membership_number }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    @if ($membership->is_public)
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-500/10 px-3 py-1 text-xs font-medium text-emerald-400 ring-1 ring-emerald-500/20">
                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-400"></span>
                            Public Profile
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-navy-500/30 px-3 py-1 text-xs font-medium text-white/50 ring-1 ring-white/10">
                            <span class="h-1.5 w-1.5 rounded-full bg-white/40"></span>
                            Private Profile
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <section class="py-10">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                {{-- Sidebar --}}
                <aside class="lg:col-span-1">
                    <div class="rounded-lg border border-navy-100 bg-white p-4 shadow-sm">
                        <x-member.sidebar />
                    </div>
                </aside>

                {{-- Main content --}}
                <main class="lg:col-span-3 space-y-6">
                    {{-- Success messages --}}
                    @if (session('success'))
                        <div class="rounded-md border border-green-200 bg-green-50 p-4">
                            <p class="text-sm text-green-800">{{ session('success') }}</p>
                        </div>
                    @endif

                    {{-- Stats row --}}
                    <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
                        <div class="premium-card p-5">
                            <p class="text-xs font-medium uppercase tracking-wider text-ink-soft">Status</p>
                            <p class="mt-1 text-lg font-semibold text-navy-900">{{ ucfirst($membership->status) }}</p>
                        </div>
                        <div class="premium-card p-5">
                            <p class="text-xs font-medium uppercase tracking-wider text-ink-soft">Total Paid</p>
                            <p class="mt-1 text-lg font-semibold text-navy-900">{{ number_format($totalPaid) }}&#2547;</p>
                        </div>
                        <div class="premium-card p-5">
                            <p class="text-xs font-medium uppercase tracking-wider text-ink-soft">Outstanding</p>
                            <p class="mt-1 text-lg font-semibold text-navy-900">{{ number_format($outstandingBalance) }}&#2547;</p>
                            <p class="text-xs text-ink-soft mt-1">Outstanding balance</p>
                        </div>
                        <div class="premium-card p-5 relative overflow-hidden group">
                            <p class="text-xs font-medium uppercase tracking-wider text-ink-soft">Profile Completion</p>
                            <div class="mt-1 flex items-baseline gap-2">
                                <p class="text-lg font-semibold text-navy-900">{{ $alumni->profileCompletionPercentage() }}%</p>
                            </div>
                            @if($alumni->profileCompletionPercentage() < 100)
                                <a href="{{ route('member.profile.edit') }}" class="absolute inset-0 flex items-center justify-center bg-white/90 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <span class="text-sm font-medium text-navy-600 underline">Complete Profile</span>
                                </a>
                            @endif
                        </div>
                    </div>

                    {{-- Quick actions --}}
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <a href="{{ route('member.profile') }}" class="premium-card p-5 group card-lift hover:border-gold-300">
                            <div class="flex flex-col gap-3">
                                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-navy-50 text-navy-700">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                                </div>
                                <div>
                                    <p class="font-medium text-navy-900 group-hover:text-navy-700">My Profile</p>
                                </div>
                            </div>
                        </a>
                        <a href="{{ route('member.membership') }}" class="premium-card p-5 group card-lift hover:border-gold-300">
                            <div class="flex flex-col gap-3">
                                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-navy-50 text-navy-700">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5zm6-10.125a1.875 1.875 0 11-3.75 0 1.875 1.875 0 013.75 0zm1.294 6.336a6.721 6.721 0 01-3.17.789 6.721 6.721 0 01-3.168-.789 3.376 3.376 0 016.338 0z"/></svg>
                                </div>
                                <div>
                                    <p class="font-medium text-navy-900 group-hover:text-navy-700">Membership</p>
                                </div>
                            </div>
                        </a>
                        <a href="{{ route('member.payments') }}" class="premium-card p-5 group card-lift hover:border-gold-300">
                            <div class="flex flex-col gap-3">
                                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-navy-50 text-navy-700">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z"/></svg>
                                </div>
                                <div>
                                    <p class="font-medium text-navy-900 group-hover:text-navy-700">Payments</p>
                                </div>
                            </div>
                        </a>
                    </div>

                    {{-- Recent payments --}}
                    <div class="premium-card">
                        <div class="border-b border-navy-100 px-5 py-4">
                            <div class="flex items-center justify-between">
                                <h2 class="font-serif text-lg font-semibold text-navy-950">Recent Payments</h2>
                                <a href="{{ route('member.payments') }}" class="text-sm font-medium text-maroon-700 hover:text-maroon-800">View all &rarr;</a>
                            </div>
                        </div>
                        <div class="divide-y divide-navy-50">
                            @forelse ($recentPayments as $payment)
                                <div class="flex items-center justify-between px-5 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-navy-50 text-navy-600">
                                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z"/></svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-navy-900">{{ $payment->feePlan?->name ?? 'Payment' }}</p>
                                            <p class="text-xs text-ink-soft">{{ $payment->paid_at?->format('M d, Y') ?? '-' }}</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm font-semibold text-navy-900">{{ number_format($payment->amount) }}&#2547;</p>
                                        <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-medium
                                            {{ match($payment->status) {
                                                \App\Enums\PaymentStatus::Paid => 'bg-emerald-50 text-emerald-700',
                                                \App\Enums\PaymentStatus::Partial => 'bg-amber-50 text-amber-700',
                                                default => 'bg-navy-50 text-navy-600',
                                            } }}">
                                            {{ ucfirst($payment->status->value) }}
                                        </span>
                                    </div>
                                </div>
                            @empty
                                <div class="px-5 py-8 text-center">
                                    <p class="text-sm text-ink-soft">No payments recorded yet.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </section>
</x-layouts.app>
