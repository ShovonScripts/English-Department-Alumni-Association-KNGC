<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
        <meta name="robots" content="noindex, nofollow">

        <title>Sign In · Member Portal | EDAA</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">

        <link rel="stylesheet" href="<?php echo e(asset('build/assets/styles.css')); ?>">
        <script src="<?php echo e(asset('build/assets/app.js')); ?>" defer></script>
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
                    <h1 class="mt-6 font-serif text-2xl font-semibold text-navy-950 sm:text-3xl">Member Portal</h1>
                    <p class="mt-2 text-sm text-ink-soft">Sign in to your member account</p>
                </div>

                <?php if(session('error')): ?>
                    <div class="mt-6 rounded-md border border-red-200 bg-red-50 p-4" role="alert">
                        <div class="flex items-start gap-3">
                            <svg class="mt-0.5 h-5 w-5 shrink-0 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                            </svg>
                            <p class="text-sm text-red-800"><?php echo e(session('error')); ?></p>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if($errors->any()): ?>
                    <div class="mt-6 rounded-md border border-red-200 bg-red-50 p-4" role="alert">
                        <div class="flex items-start gap-3">
                            <svg class="mt-0.5 h-5 w-5 shrink-0 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                            </svg>
                            <div>
                                <p class="text-sm font-medium text-red-800">Please fix the following errors:</p>
                                <ul class="mt-1 list-inside list-disc space-y-1 text-sm text-red-700">
                                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li><?php echo e($error); ?></li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <form method="POST" action="<?php echo e(route('member.login.store')); ?>" class="mt-8 space-y-5">
                    <?php echo csrf_field(); ?>

                    <div>
                        <label for="email" class="block text-sm font-medium text-navy-900">Email address</label>
                        <input
                            id="email"
                            name="email"
                            type="email"
                            autocomplete="email"
                            required
                            value="<?php echo e(old('email')); ?>"
                            class="mt-1.5 block w-full rounded-md border border-navy-200 bg-white px-3.5 py-2.5 text-sm text-ink shadow-sm placeholder:text-ink-soft focus:border-gold-500 focus:outline-none focus:ring-1 focus:ring-gold-500"
                            placeholder="you@example.com"
                        />
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-navy-900">Password</label>
                        <input
                            id="password"
                            name="password"
                            type="password"
                            autocomplete="current-password"
                            required
                            class="mt-1.5 block w-full rounded-md border border-navy-200 bg-white px-3.5 py-2.5 text-sm text-ink shadow-sm placeholder:text-ink-soft focus:border-gold-500 focus:outline-none focus:ring-1 focus:ring-gold-500"
                            placeholder="Enter your password"
                        />
                    </div>

                    <div class="flex items-center justify-between">
                        <label for="remember" class="flex items-center gap-2 text-sm text-navy-700">
                            <input
                                id="remember"
                                name="remember"
                                type="checkbox"
                                class="h-4 w-4 rounded border-navy-300 text-gold-500 focus:ring-gold-500"
                            />
                            Remember me
                        </label>
                        <a href="<?php echo e(route('member.password.request')); ?>" class="text-sm font-medium text-maroon-700 hover:text-maroon-800">Forgot password?</a>
                    </div>

                    <button
                        type="submit"
                        class="focus-ring flex w-full items-center justify-center gap-2 rounded-md bg-maroon-700 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition-colors hover:bg-maroon-800 focus:outline-none focus:ring-2 focus:ring-maroon-500 focus:ring-offset-2 disabled:opacity-50"
                    >
                        Sign In
                    </button>
                </form>

                <div class="mt-6 text-center">
                    <p class="text-sm text-ink-soft">
                        Don't have an account?
                        <a href="<?php echo e(route('member.register')); ?>" class="font-medium text-maroon-700 hover:text-maroon-800">Register here</a>
                    </p>
                </div>

                <p class="mt-8 text-center text-xs text-ink-soft">
                    &copy; <?php echo e(date('Y')); ?> EDAA. All rights reserved.
                </p>
            </div>
        </div>
    </body>
</html>
<?php /**PATH C:\xampp\htdocs\ProDo\EDAA\resources\views/member/auth/login.blade.php ENDPATH**/ ?>