<x-layouts.app :title="'Security & Account'">
    <section class="bg-navy-950 py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <h1 class="font-serif text-3xl font-bold text-white">Security & Account</h1>
            <p class="mt-2 text-sm text-white/60">Manage your password and account security settings</p>
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

                    <div class="premium-card p-6">
                        <h2 class="font-serif text-lg font-semibold text-navy-950 mb-4">Account Status</h2>
                        <div class="flex items-center gap-4">
                            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-navy-50 text-navy-700">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" /></svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-navy-900">Verified Member</p>
                                @if($user->isVerified())
                                    <p class="text-xs text-ink-soft">Your account has been officially verified by the administration team on {{ $user->verified_at->format('M d, Y') }}.</p>
                                @else
                                    <p class="text-xs text-amber-600">Your account is currently pending verification from the administration team. Some features may be restricted.</p>
                                @endif
                            </div>
                            @if($user->isVerified())
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-3 py-1 text-xs font-medium text-emerald-700">
                                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                    Verified
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="premium-card">
                        <div class="border-b border-navy-100 px-6 py-4 flex items-center justify-between bg-white">
                            <h2 class="font-serif text-lg font-semibold text-navy-950">Update Password</h2>
                        </div>
                        
                        <form method="POST" action="{{ route('member.security.password.update') }}" class="p-6 space-y-6">
                            @csrf
                            @method('PUT')

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <div class="sm:col-span-2">
                                    <label for="current_password" class="block text-sm font-medium text-navy-900">Current Password</label>
                                    <input type="password" id="current_password" name="current_password" required
                                           class="mt-1.5 block w-full rounded-lg border border-navy-200 px-3.5 py-2.5 text-sm text-ink shadow-sm focus-ring @error('current_password') border-red-300 ring-red-300 @enderror" />
                                    @error('current_password')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="password" class="block text-sm font-medium text-navy-900">New Password</label>
                                    <input type="password" id="password" name="password" required
                                           class="mt-1.5 block w-full rounded-lg border border-navy-200 px-3.5 py-2.5 text-sm text-ink shadow-sm focus-ring @error('password') border-red-300 ring-red-300 @enderror" />
                                    <p class="mt-1 text-xs text-ink-soft">Must be at least 8 characters with letters and numbers.</p>
                                    @error('password')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="password_confirmation" class="block text-sm font-medium text-navy-900">Confirm New Password</label>
                                    <input type="password" id="password_confirmation" name="password_confirmation" required
                                           class="mt-1.5 block w-full rounded-lg border border-navy-200 px-3.5 py-2.5 text-sm text-ink shadow-sm focus-ring" />
                                </div>
                            </div>
                            
                            <div class="flex justify-end pt-4 border-t border-navy-50">
                                <button type="submit" class="btn btn-primary">Update Password</button>
                            </div>
                        </form>
                    </div>

                    <div class="premium-card p-6">
                        <h2 class="font-serif text-lg font-semibold text-navy-950 mb-4">Email Address</h2>
                        <div class="flex items-center justify-between p-4 bg-navy-50 rounded-lg border border-navy-100">
                            <div>
                                <p class="text-sm font-medium text-navy-900">{{ $user->email }}</p>
                                @if($user->hasVerifiedEmail())
                                    <p class="text-xs text-emerald-600 mt-1 flex items-center gap-1"><svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Email Verified</p>
                                @else
                                    <p class="text-xs text-amber-600 mt-1">Email not verified</p>
                                @endif
                            </div>
                            @if(!$user->hasVerifiedEmail())
                                <form method="POST" action="{{ route('member.verification.send') }}">
                                    @csrf
                                    <button type="submit" class="btn btn-secondary text-xs py-1.5">Resend Verification</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </section>
</x-layouts.app>
