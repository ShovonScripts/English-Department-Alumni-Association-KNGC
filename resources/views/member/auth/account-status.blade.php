<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="robots" content="noindex, nofollow">

        <title>Account Status · Member Portal | EDAA</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-cream font-sans text-ink antialiased">
        <div class="flex min-h-screen flex-col items-center justify-center px-4 py-12 sm:px-6 lg:px-8">
            <div class="w-full max-w-md">
                <div class="flex flex-col items-center">
                    <a href="/" class="focus-ring flex items-center gap-3 rounded-md" aria-label="EDAA Home">
                        <span class="flex h-12 w-12 items-center justify-center rounded-md bg-maroon-700 font-serif text-sm font-bold tracking-wide text-white ring-1 ring-gold-500/60">
                            EDAA
                        </span>
                    </a>
                    <h1 class="mt-6 font-serif text-2xl font-semibold text-navy-950 sm:text-3xl">Account Status</h1>
                </div>

                <div class="mt-8 premium-card p-8 text-center">
                    @if($status === 'suspended')
                        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-amber-50 text-amber-600 mb-6">
                            <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                            </svg>
                        </div>
                        <h2 class="font-serif text-xl font-semibold text-navy-950 mb-3">Account Suspended</h2>
                        <p class="text-sm text-ink-soft mb-6">Your member account is currently suspended. Please contact the association for assistance.</p>
                    @elseif($status === 'cancelled')
                        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-red-50 text-red-600 mb-6">
                            <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                            </svg>
                        </div>
                        <h2 class="font-serif text-xl font-semibold text-navy-950 mb-3">Membership Cancelled</h2>
                        <p class="text-sm text-ink-soft mb-6">Your membership is no longer active. If you believe this is an error, please contact the association.</p>
                    @elseif($status === 'expired')
                        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-amber-50 text-amber-600 mb-6">
                            <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h2 class="font-serif text-xl font-semibold text-navy-950 mb-3">Membership Expired</h2>
                        <p class="text-sm text-ink-soft mb-6">Your membership has expired. Please renew your membership to regain access.</p>
                    @elseif($status === 'disabled')
                        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-red-50 text-red-600 mb-6">
                            <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                            </svg>
                        </div>
                        <h2 class="font-serif text-xl font-semibold text-navy-950 mb-3">Account Disabled</h2>
                        <p class="text-sm text-ink-soft mb-6">Your account has been disabled. Please contact the administrator for assistance.</p>
                    @else
                        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-navy-50 text-navy-600 mb-6">
                            <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h2 class="font-serif text-xl font-semibold text-navy-950 mb-3">Account Status</h2>
                        <p class="text-sm text-ink-soft mb-6">Please contact the association for more information about your account status.</p>
                    @endif

                    <div class="space-y-3">
                        <a href="mailto:info@edaa-kngc.org" class="focus-ring flex w-full items-center justify-center gap-2 rounded-md bg-maroon-700 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition-colors hover:bg-maroon-800 focus:outline-none focus:ring-2 focus:ring-maroon-500 focus:ring-offset-2">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                            </svg>
                            Contact Association
                        </a>

                        <form method="POST" action="{{ route('member.logout') }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="focus-ring flex w-full items-center justify-center gap-2 rounded-md border border-navy-200 bg-white px-4 py-2.5 text-sm font-medium text-navy-700 shadow-sm transition-colors hover:bg-navy-50 focus:outline-none focus:ring-2 focus:ring-navy-500 focus:ring-offset-2">
                                Sign Out
                            </button>
                        </form>
                    </div>
                </div>

                <p class="mt-8 text-center text-xs text-ink-soft">
                    &copy; {{ date('Y') }} EDAA. All rights reserved.
                </p>
            </div>
        </div>
    </body>
</html>
