<?php if (isset($component)) { $__componentOriginal5863877a5171c196453bfa0bd807e410 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5863877a5171c196453bfa0bd807e410 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.app','data' => ['title' => 'Privacy Settings']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.app'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Privacy Settings')]); ?>
    <section class="bg-navy-950 py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <h1 class="font-serif text-3xl font-bold text-white">Privacy Settings</h1>
            <p class="mt-2 text-sm text-white/60">Control your profile visibility and privacy</p>
        </div>
    </section>

    <section class="py-10">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                <aside class="lg:col-span-1">
                    <div class="rounded-lg border border-navy-100 bg-white p-4 shadow-sm">
                        <?php if (isset($component)) { $__componentOriginal045cf4da59ba09f546a14c8bea6c081a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal045cf4da59ba09f546a14c8bea6c081a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.member.sidebar','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('member.sidebar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal045cf4da59ba09f546a14c8bea6c081a)): ?>
<?php $attributes = $__attributesOriginal045cf4da59ba09f546a14c8bea6c081a; ?>
<?php unset($__attributesOriginal045cf4da59ba09f546a14c8bea6c081a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal045cf4da59ba09f546a14c8bea6c081a)): ?>
<?php $component = $__componentOriginal045cf4da59ba09f546a14c8bea6c081a; ?>
<?php unset($__componentOriginal045cf4da59ba09f546a14c8bea6c081a); ?>
<?php endif; ?>
                    </div>
                </aside>

                <main class="lg:col-span-3 space-y-6">
                    <?php if(session('success')): ?>
                        <div class="rounded-md border border-emerald-200 bg-emerald-50 p-4">
                            <p class="text-sm text-emerald-800"><?php echo e(session('success')); ?></p>
                        </div>
                    <?php endif; ?>

                    
                    <div class="premium-card p-6">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <h2 class="font-serif text-lg font-semibold text-navy-950">Public Profile</h2>
                                <p class="mt-1 text-sm text-ink-soft">Allow other alumni and visitors to see your profile in the public directory.</p>
                            </div>
                            <form method="POST" action="<?php echo e(route('member.visibility.toggle')); ?>">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PATCH'); ?>
                                <button type="submit"
                                        class="relative inline-flex h-6 w-11 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus-ring <?php echo e($membership->is_public ? 'bg-emerald-500' : 'bg-navy-200'); ?>"
                                        aria-label="<?php echo e($membership->is_public ? 'Make profile private' : 'Make profile public'); ?>">
                                    <span class="pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out <?php echo e($membership->is_public ? 'translate-x-5' : 'translate-x-0'); ?>"></span>
                                </button>
                            </form>
                        </div>

                        <div class="mt-6 border-t border-navy-100 pt-6">
                            <h3 class="text-sm font-medium text-navy-900 mb-3">Current Status</h3>
                            <?php if($membership->is_public): ?>
                                <div class="flex items-center gap-3 p-4 bg-emerald-50 rounded-lg border border-emerald-100">
                                    <svg class="h-5 w-5 text-emerald-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                                    </svg>
                                    <div>
                                        <p class="text-sm font-medium text-emerald-800">Your profile is public</p>
                                        <p class="text-xs text-emerald-700 mt-0.5">Others can find you in the <a href="<?php echo e(route('members.index')); ?>" target="_blank" class="underline">member directory</a>.</p>
                                    </div>
                                </div>
                            <?php else: ?>
                                <div class="flex items-center gap-3 p-4 bg-navy-50 rounded-lg border border-navy-100">
                                    <svg class="h-5 w-5 text-navy-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                                    </svg>
                                    <div>
                                        <p class="text-sm font-medium text-navy-800">Your profile is private</p>
                                        <p class="text-xs text-navy-600 mt-0.5">Only you can see your full profile details.</p>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    
                    <div class="premium-card p-6">
                        <h2 class="font-serif text-lg font-semibold text-navy-950 mb-4">What's Visible Publicly</h2>
                        <p class="text-sm text-ink-soft mb-4">When your profile is public, the following information is visible in the member directory:</p>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="flex items-center gap-3 p-3 bg-navy-50 rounded-lg">
                                <svg class="h-5 w-5 text-emerald-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                </svg>
                                <span class="text-sm text-navy-900">Name & Profile Photo</span>
                            </div>
                            <div class="flex items-center gap-3 p-3 bg-navy-50 rounded-lg">
                                <svg class="h-5 w-5 text-emerald-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                </svg>
                                <span class="text-sm text-navy-900">Profession & Organization</span>
                            </div>
                            <div class="flex items-center gap-3 p-3 bg-navy-50 rounded-lg">
                                <svg class="h-5 w-5 text-emerald-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                </svg>
                                <span class="text-sm text-navy-900">City & Country</span>
                            </div>
                            <div class="flex items-center gap-3 p-3 bg-navy-50 rounded-lg">
                                <svg class="h-5 w-5 text-emerald-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                </svg>
                                <span class="text-sm text-navy-900">Bio</span>
                            </div>
                        </div>

                        <div class="mt-4 p-4 bg-amber-50 rounded-lg border border-amber-100">
                            <div class="flex items-start gap-3">
                                <svg class="h-5 w-5 text-amber-600 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                                </svg>
                                <div>
                                    <p class="text-sm font-medium text-amber-800">Private information is always hidden</p>
                                    <p class="text-xs text-amber-700 mt-0.5">Payment details, membership status, and admin notes are never shown publicly.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    
                    <?php if($membership->is_public): ?>
                    <div class="premium-card p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="font-serif text-lg font-semibold text-navy-950">Preview Your Public Profile</h2>
                            <a href="<?php echo e(route('alumni.show', $alumni->slug)); ?>" target="_blank" class="focus-ring inline-flex items-center gap-1.5 rounded-md border border-navy-200 bg-white px-3 py-1.5 text-xs font-medium text-navy-700 shadow-sm transition-colors hover:bg-navy-50">
                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                                </svg>
                                Open Public Profile
                            </a>
                        </div>
                        <p class="text-sm text-ink-soft">See exactly what others see when they visit your public profile in the member directory.</p>
                    </div>
                    <?php endif; ?>
                </main>
            </div>
        </div>
    </section>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5863877a5171c196453bfa0bd807e410)): ?>
<?php $attributes = $__attributesOriginal5863877a5171c196453bfa0bd807e410; ?>
<?php unset($__attributesOriginal5863877a5171c196453bfa0bd807e410); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5863877a5171c196453bfa0bd807e410)): ?>
<?php $component = $__componentOriginal5863877a5171c196453bfa0bd807e410; ?>
<?php unset($__componentOriginal5863877a5171c196453bfa0bd807e410); ?>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\ProDo\EDAA\resources\views\member\privacy.blade.php ENDPATH**/ ?>