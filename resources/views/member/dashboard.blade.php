<x-layouts.app :title="'Member Dashboard'">
    {{-- Hero Section --}}
    <section class="relative bg-navy-950 py-12 lg:py-16 overflow-hidden border-b border-navy-900/60">
        <div class="absolute inset-0 hero-gradient-mesh opacity-90"></div>
        <div class="absolute -top-24 -right-24 h-96 w-96 rounded-full bg-gold-500/10 blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -left-24 h-96 w-96 rounded-full bg-maroon-700/15 blur-3xl pointer-events-none"></div>

        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="relative shrink-0">
                        @if ($alumni->profile_photo)
                            <img src="{{ $alumni->profile_photo_url }}" alt="{{ $alumni->full_name }}" class="h-14 w-14 sm:h-16 sm:w-16 rounded-xl object-cover ring-2 ring-gold-400/30 shadow-lg shadow-navy-950/40">
                        @else
                            <div class="flex h-14 w-14 sm:h-16 sm:w-16 items-center justify-center rounded-xl bg-gradient-to-br from-navy-800 to-maroon-900 text-white font-serif font-bold text-xl ring-2 ring-gold-400/30 shadow-lg shadow-navy-950/40">
                                {{ strtoupper(substr($alumni->full_name, 0, 2)) }}
                            </div>
                        @endif
                        <span class="absolute -bottom-0.5 -right-0.5 flex h-5 w-5 items-center justify-center rounded-full bg-emerald-500 ring-2 ring-navy-950 shadow-sm" title="Active Account">
                            <svg class="h-3 w-3 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        </span>
                    </div>

                    <div>
                        <h1 class="font-serif text-2xl sm:text-3xl font-bold tracking-tight text-white">
                            Welcome back, {{ explode(' ', $alumni->full_name)[0] }}
                        </h1>
                        <div class="mt-1 flex flex-wrap items-center gap-x-3 gap-y-0.5 text-sm text-white/60">
                            <span class="font-mono text-gold-300/80">{{ $membership->membership_number }}</span>
                            <span class="text-white/25">&bull;</span>
                            @if($alumni->batch)
                                <span>Batch {{ $alumni->batch }}</span>
                                <span class="text-white/25">&bull;</span>
                            @endif
                            <span>{{ $alumni->profession ?: 'Alumni Member' }}</span>
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    @if ($membership->is_public)
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-500/10 px-3 py-1.5 text-xs font-semibold text-emerald-300 ring-1 ring-emerald-500/25">
                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                            Public Profile
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-white/10 px-3 py-1.5 text-xs font-medium text-white/60 ring-1 ring-white/10">
                            <span class="h-1.5 w-1.5 rounded-full bg-white/40"></span>
                            Private
                        </span>
                    @endif

                    <a href="{{ route('member.membership.card') }}" class="focus-ring inline-flex items-center gap-1.5 rounded-lg bg-gradient-to-r from-gold-500 to-gold-600 px-5 py-2.5 text-sm font-bold uppercase tracking-wider text-navy-950 shadow-md shadow-gold-500/10 transition-all duration-200 hover:from-gold-400 hover:to-gold-500 hover:-translate-y-0.5 active:translate-y-0">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 013 3m3 0a6 6 0 01-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1121.75 8.25z"/></svg>
                        Card
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- Main Workspace --}}
    <section class="py-10 bg-slate-50/60 min-h-screen">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                {{-- Sidebar --}}
                <aside class="lg:col-span-1">
                    <div class="rounded-xl border border-navy-100/60 bg-white p-4 shadow-sm sticky top-20">
                        <x-member.sidebar />
                    </div>
                </aside>

                {{-- Main Dashboard Column --}}
                <main class="lg:col-span-3 space-y-6">
                    {{-- Success messages --}}
                    @if (session('success'))
                        <div class="rounded-xl border border-emerald-200 bg-gradient-to-r from-emerald-50 to-emerald-50/30 px-4 py-3 shadow-sm flex items-center gap-3">
                            <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-emerald-100 text-emerald-700">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                            </div>
                            <p class="text-sm font-semibold text-emerald-900">{{ session('success') }}</p>
                        </div>
                    @endif

                    {{-- Metric Cards --}}
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-5">
                        <div class="group relative overflow-hidden rounded-xl border border-navy-100/80 bg-white p-5 shadow-sm transition-all duration-200 hover:shadow-md hover:border-navy-200">
                            <div class="flex items-center justify-between mb-2.5">
                                <span class="text-xs font-bold uppercase tracking-wider text-ink-soft">Status</span>
                                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-navy-50 text-navy-700 group-hover:bg-navy-100 transition-colors">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/></svg>
                                </div>
                            </div>
                            <p class="text-xl font-bold tracking-tight text-navy-950 capitalize">{{ $membership->status }}</p>
                            <p class="mt-0.5 text-xs text-ink-soft truncate font-mono">{{ $membership->tier?->name ?? 'Standard Tier' }}</p>
                        </div>

                        <div class="group relative overflow-hidden rounded-xl border border-navy-100/80 bg-white p-5 shadow-sm transition-all duration-200 hover:shadow-md hover:border-emerald-200">
                            <div class="flex items-center justify-between mb-2.5">
                                <span class="text-xs font-bold uppercase tracking-wider text-ink-soft">Paid</span>
                                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-emerald-50 text-emerald-600 group-hover:bg-emerald-100 transition-colors">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </div>
                            </div>
                            <p class="text-xl font-bold tracking-tight text-navy-950">{{ number_format($totalPaid) }}&#2547;</p>
                            <p class="mt-0.5 text-xs text-emerald-600 font-medium">Verified Contributions</p>
                        </div>

                        <div class="group relative overflow-hidden rounded-xl border border-navy-100/80 bg-white p-5 shadow-sm transition-all duration-200 hover:shadow-md hover:border-amber-200">
                            <div class="flex items-center justify-between mb-2.5">
                                <span class="text-xs font-bold uppercase tracking-wider text-ink-soft">Due</span>
                                <div class="flex h-8 w-8 items-center justify-center rounded-lg {{ $outstandingBalance > 0 ? 'bg-amber-50 text-amber-600 group-hover:bg-amber-100' : 'bg-emerald-50 text-emerald-600 group-hover:bg-emerald-100' }} transition-colors">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z"/></svg>
                                </div>
                            </div>
                            <p class="text-xl font-bold tracking-tight {{ $outstandingBalance > 0 ? 'text-amber-600' : 'text-emerald-600' }}">{{ number_format($outstandingBalance) }}&#2547;</p>
                            <p class="mt-0.5 text-xs text-ink-soft">{{ $outstandingBalance > 0 ? 'Outstanding balance' : 'All dues settled' }}</p>
                        </div>

                        <div class="group relative overflow-hidden rounded-xl border border-navy-100/80 bg-white p-5 shadow-sm transition-all duration-200 hover:shadow-md hover:border-gold-300">
                            <div class="flex items-center justify-between mb-2.5">
                                <span class="text-xs font-bold uppercase tracking-wider text-ink-soft">Rank</span>
                                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-gold-50 text-gold-600 group-hover:bg-gold-100 transition-colors">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9m9 0a3 3 0 013 3h-15a3 3 0 013-3m9 0v-3.375c0-.621-.504-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.007 0H9.497m5.007 0a7.454 7.454 0 01-.982-3.172M9.497 14.25a7.454 7.454 0 00.981-3.172M5.25 4.236c-.996.188-1.882.836-2.257 1.662A11.966 11.966 0 002.25 12c0 2.17.655 4.202 1.802 5.904.375.826.981 1.384 1.662 2.257M5.25 4.236V4.5c0 2.17.655 4.202 1.802 5.904M18.75 4.236c.996.188 1.882.836 2.257 1.662A11.966 11.966 0 0121.75 12c0 2.17-.655 4.202-1.802 5.904-.375.826-.981 1.384-1.662 2.257M18.75 4.236V4.5c0 2.17-.655 4.202-1.802 5.904M12 12v.008"/></svg>
                                </div>
                            </div>
                            @if($rank)
                                <p class="text-xl font-bold tracking-tight text-navy-950">#{{ $rank['rank'] }} <span class="text-xs font-normal text-ink-soft">/ {{ $rank['total'] }}</span></p>
                            @else
                                <p class="text-xl font-bold tracking-tight text-navy-950">#—</p>
                            @endif
                            <p class="mt-0.5 text-xs text-ink-soft">Contributor rank</p>
                        </div>
                    </div>

                    {{-- Quick Services --}}
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <h2 class="font-serif text-lg font-semibold text-navy-950">Quick Services</h2>
                            <span class="text-xs font-medium text-ink-soft">Shortcuts</span>
                        </div>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                            <a href="{{ route('member.membership') }}" class="group relative rounded-xl border border-navy-100/80 bg-white p-4 shadow-sm transition-all duration-200 hover:shadow-md hover:border-navy-300">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-navy-50 text-navy-700 group-hover:bg-navy-900 group-hover:text-white transition-all duration-200">
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5zm6-10.125a1.875 1.875 0 11-3.75 0 1.875 1.875 0 013.75 0zm1.294 6.336a6.721 6.721 0 01-3.17.789 6.721 6.721 0 01-3.168-.789 3.376 3.376 0 016.338 0z"/></svg>
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-sm font-bold text-navy-950 group-hover:text-maroon-700 transition-colors truncate">Membership</p>
                                        <p class="text-xs text-ink-soft font-mono truncate">{{ $membership->membership_number }}</p>
                                    </div>
                                </div>
                            </a>

                            <a href="{{ route('member.profile.edit') }}" class="group relative rounded-xl border border-navy-100/80 bg-white p-4 shadow-sm transition-all duration-200 hover:shadow-md hover:border-navy-300">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-navy-50 text-navy-700 group-hover:bg-navy-900 group-hover:text-white transition-all duration-200">
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/></svg>
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-sm font-bold text-navy-950 group-hover:text-maroon-700 transition-colors truncate">Edit Profile</p>
                                        <p class="text-xs text-ink-soft">{{ $alumni->profileCompletionPercentage() }}% complete</p>
                                    </div>
                                </div>
                            </a>

                            <a href="{{ route('member.membership.card') }}" class="group relative rounded-xl border border-navy-100/80 bg-white p-4 shadow-sm transition-all duration-200 hover:shadow-md hover:border-gold-400">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-gold-50 text-gold-700 group-hover:bg-gold-500 group-hover:text-navy-950 transition-all duration-200">
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 013 3m3 0a6 6 0 01-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1121.75 8.25z"/></svg>
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-sm font-bold text-navy-950 group-hover:text-gold-700 transition-colors truncate">Card</p>
                                        <p class="text-xs text-ink-soft">Print or digital</p>
                                    </div>
                                </div>
                            </a>

                            <a href="{{ route('member.payments') }}" class="group relative rounded-xl border border-navy-100/80 bg-white p-4 shadow-sm transition-all duration-200 hover:shadow-md hover:border-navy-300">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-navy-50 text-navy-700 group-hover:bg-navy-900 group-hover:text-white transition-all duration-200">
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z"/></svg>
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-sm font-bold text-navy-950 group-hover:text-maroon-700 transition-colors truncate">Payments</p>
                                        <p class="text-xs text-ink-soft">Statement & dues</p>
                                    </div>
                                </div>
                            </a>

                            <a href="{{ route('member.security') }}" class="group relative rounded-xl border border-navy-100/80 bg-white p-4 shadow-sm transition-all duration-200 hover:shadow-md hover:border-navy-300">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-navy-50 text-navy-700 group-hover:bg-navy-900 group-hover:text-white transition-all duration-200">
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/></svg>
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-sm font-bold text-navy-950 group-hover:text-maroon-700 transition-colors truncate">Security</p>
                                        <p class="text-xs text-ink-soft">Password & auth</p>
                                    </div>
                                </div>
                            </a>

                            @if($membership->is_public)
                                <a href="{{ route('alumni.show', $alumni->slug) }}" target="_blank" class="group relative rounded-xl border border-navy-100/80 bg-white p-4 shadow-sm transition-all duration-200 hover:shadow-md hover:border-maroon-300">
                                    <div class="flex items-center gap-3">
                                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-maroon-50 text-maroon-700 group-hover:bg-maroon-700 group-hover:text-white transition-all duration-200">
                                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/></svg>
                                        </div>
                                        <div class="min-w-0">
                                            <p class="text-sm font-bold text-navy-950 group-hover:text-maroon-700 transition-colors truncate">Public Profile</p>
                                            <p class="text-xs text-ink-soft">Directory listing</p>
                                        </div>
                                    </div>
                                </a>
                            @else
                                <a href="{{ route('member.privacy') }}" class="group relative rounded-xl border border-navy-100/80 bg-white p-4 shadow-sm transition-all duration-200 hover:shadow-md hover:border-navy-300">
                                    <div class="flex items-center gap-3">
                                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-navy-50 text-navy-700 group-hover:bg-navy-900 group-hover:text-white transition-all duration-200">
                                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88"/></svg>
                                        </div>
                                        <div class="min-w-0">
                                            <p class="text-sm font-bold text-navy-950 group-hover:text-maroon-700 transition-colors truncate">Privacy</p>
                                            <p class="text-xs text-ink-soft">Visibility controls</p>
                                        </div>
                                    </div>
                                </a>
                            @endif
                        </div>
                    </div>

                    {{-- Recent Activity --}}
                    <div class="overflow-hidden rounded-xl border border-navy-100/80 bg-white shadow-sm">
                        <div class="px-4 py-3 flex items-center justify-between border-b border-navy-50 bg-white">
                            <div class="flex items-center gap-2">
                                <span class="h-1.5 w-1.5 rounded-full bg-maroon-600"></span>
                                <h2 class="font-serif text-lg font-semibold text-navy-950">Recent Activity</h2>
                            </div>
                            @if($recentPayments->count())
                                <a href="{{ route('member.payments') }}" class="text-xs font-semibold text-maroon-700 hover:text-maroon-800 hover:underline inline-flex items-center gap-0.5 transition-colors">
                                    View all
                                    <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                </a>
                            @endif
                        </div>

                        <div class="divide-y divide-navy-50/70">
                            @forelse ($recentPayments as $payment)
                                @php
                                    $isPaid = $payment->status->value === 'paid';
                                    $isPartial = $payment->status->value === 'partial';
                                    $iconBg = $isPaid ? 'bg-emerald-50 text-emerald-600 ring-1 ring-emerald-200/50' : ($isPartial ? 'bg-amber-50 text-amber-600 ring-1 ring-amber-200/50' : 'bg-navy-50 text-navy-600 ring-1 ring-navy-200/50');
                                    $badgeBg = $isPaid ? 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200/70' : ($isPartial ? 'bg-amber-50 text-amber-700 ring-1 ring-amber-200/70' : 'bg-navy-50 text-navy-700 ring-1 ring-navy-200/70');
                                @endphp
                                <div class="px-4 py-2.5 hover:bg-slate-50/60 transition-colors">
                                    <div class="flex items-center justify-between gap-3">
                                        <div class="flex items-center gap-3 min-w-0">
                                            <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg {{ $iconBg }}">
                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            </div>
                                            <div class="min-w-0">
                                                <p class="text-sm font-semibold text-navy-950 truncate">{{ number_format($payment->amount) }}&#2547;</p>
                                                <p class="text-xs text-ink-soft">
                                                    {{ $payment->paid_at?->format('M d, Y') ?? '—' }}
                                                    @if($payment->feePlan)
                                                        &middot; {{ $payment->feePlan->name }}
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                        <span class="shrink-0 inline-flex items-center rounded-full px-2 py-0.5 text-xs font-semibold {{ $badgeBg }}">
                                            {{ ucfirst($payment->status->value) }}
                                        </span>
                                    </div>
                                </div>
                            @empty
                                <div class="px-4 py-8 text-center">
                                    <div class="mx-auto flex h-10 w-10 items-center justify-center rounded-xl bg-navy-50/70 text-navy-400 border border-navy-100">
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" /></svg>
                                    </div>
                                    <p class="mt-3 text-sm font-semibold text-navy-900">No recent activity yet</p>
                                    <p class="mt-0.5 text-xs text-ink-soft">Payments will appear here once recorded.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </section>
</x-layouts.app>
