@props([
    'title' => null,
    'description' => null,
    'image' => null,
])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500&display=swap" rel="stylesheet">

        <x-seo :title="$title" :description="$description" :image="$image" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @stack('head')
    </head>
    <body class="flex min-h-screen flex-col bg-white font-sans text-ink antialiased">
        <a href="#main-content" class="sr-only focus:not-sr-only focus:fixed focus:left-4 focus:top-4 focus:z-[100] focus:rounded-md focus:bg-navy-900 focus:px-4 focus:py-2 focus:text-white">
            Skip to content
        </a>

        <x-navbar />

        <main id="main-content" class="flex-1">
            {{ $slot }}
        </main>

        <x-footer />

        @stack('scripts')
    </body>
</html>