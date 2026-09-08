<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
        <meta name="robots" content="noindex, nofollow">

        <title>403 — Forbidden | EDAA</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">

        <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    </head>
    <body class="bg-cream font-sans text-ink antialiased">
        <div class="flex min-h-screen flex-col items-center justify-center px-4 py-12 sm:px-6 lg:px-8">
            <div class="flex flex-col items-center text-center">
                <a href="/" class="focus-ring flex items-center gap-3 rounded-md" aria-label="EDAA Home">
                    <span class="flex h-12 w-12 items-center justify-center rounded-md bg-maroon-700 font-serif text-sm font-bold tracking-wide text-white ring-1 ring-gold-500/60">
                        EDAA
                    </span>
                </a>

                <p class="mt-8 font-serif text-7xl font-semibold text-navy-100 sm:text-9xl">403</p>

                <h1 class="mt-4 font-serif text-3xl font-semibold text-navy-950 sm:text-4xl">Access Denied</h1>

                <p class="mt-4 max-w-md text-sm leading-relaxed text-ink-soft sm:text-base">
                    You do not have permission to access this page. If you believe this is an error, please contact the site administrator.
                </p>

                <div class="mt-9">
                    <a
                        href="<?php echo e(route('home')); ?>"
                        class="focus-ring inline-flex items-center gap-2 rounded-md bg-navy-900 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition-colors hover:bg-navy-800 focus:outline-none focus:ring-2 focus:ring-navy-500 focus:ring-offset-2"
                    >
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Return to Homepage
                    </a>
                </div>
            </div>

            <p class="mt-16 text-xs text-ink-soft">
                &copy; <?php echo e(date('Y')); ?> EDAA. All rights reserved.
            </p>
        </div>
    </body>
</html>
<?php /**PATH C:\xampp\htdocs\ProDo\EDAA\resources\views\errors\403.blade.php ENDPATH**/ ?>