@props([
    'title' => null,
])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="robots" content="noindex, nofollow">

        <title>{{ $title ? $title . ' · Admin | ' . config('site.name') : 'Admin | ' . config('site.name') }}</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @stack('head')
    </head>
    <body class="bg-cream font-sans text-ink antialiased">
        <a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:z-[100] focus:m-4 focus:rounded-md focus:bg-gold-500 focus:px-4 focus:py-2 focus:text-sm focus:font-semibold focus:text-navy-950 focus:shadow-lg">Skip to content</a>
        <div
            x-data="{ sidebarOpen: false }"
            @keydown.escape.window="sidebarOpen = false"
            class="min-h-screen lg:flex"
        >
            {{-- Mobile overlay --}}
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
                class="fixed inset-0 z-40 bg-navy-950/60 lg:hidden"
                aria-hidden="true"
            ></div>

            <x-admin.sidebar :open="false" />

            <div class="flex min-w-0 flex-1 flex-col">
                <x-admin.topbar @toggle-sidebar="sidebarOpen = true" />

                <main id="main-content" class="flex-1 p-4 sm:p-6 lg:p-8">
                    <div class="mx-auto w-full max-w-6xl">
                        {{ $slot }}
                    </div>
                </main>

                <footer class="border-t border-navy-100 bg-white px-4 py-4 text-center text-xs text-ink-soft sm:px-6">
                    &copy; {{ date('Y') }} {{ config('site.name') }} · Admin Area
                </footer>
            </div>
        </div>

        @stack('scripts')
    </body>
</html>