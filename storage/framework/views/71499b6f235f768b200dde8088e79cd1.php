<?php if (isset($component)) { $__componentOriginal5863877a5171c196453bfa0bd807e410 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5863877a5171c196453bfa0bd807e410 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.app','data' => ['title' => 'My Membership']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.app'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('My Membership')]); ?>
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

                    
                    <div class="premium-card overflow-hidden">
                        <div class="bg-gradient-to-r from-navy-950 to-navy-800 px-6 py-8 relative">
                            <div class="absolute right-0 top-0 h-full w-1/3 bg-gradient-to-l from-white/5 to-transparent"></div>
                            <div class="relative z-10 flex items-center justify-between">
                                <div>
                                    <p class="text-xs font-medium text-white/50 uppercase tracking-widest mb-1">Membership ID</p>
                                    <h2 class="font-serif text-3xl font-bold text-white tracking-tight"><?php echo e($membership->membership_number); ?></h2>
                                </div>
                                <div class="text-right">
                                    <p class="text-xs font-medium text-white/50 uppercase tracking-widest mb-1">Tier</p>
                                    <p class="text-lg font-semibold text-white bg-white/10 px-3 py-1 rounded-full backdrop-blur-sm border border-white/10"><?php echo e($membership->tier?->name ?? 'Standard'); ?></p>
                                </div>
                            </div>
                            <div class="relative z-10 mt-8 flex items-center gap-6 text-sm text-white/70">
                                <div class="flex flex-col">
                                    <span class="text-xs text-white/50 uppercase tracking-wider mb-0.5">Type</span>
                                    <strong class="text-white"><?php echo e($membership->type?->name ?? '-'); ?></strong>
                                </div>
                                <div class="w-px h-8 bg-white/10"></div>
                                <div class="flex flex-col">
                                    <span class="text-xs text-white/50 uppercase tracking-wider mb-0.5">Member Since</span>
                                    <strong class="text-white"><?php echo e($membership->joined_at?->format('F Y') ?? '-'); ?></strong>
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 sm:grid-cols-4 divide-x divide-y sm:divide-y-0 divide-navy-50">
                            <div class="px-5 py-5 text-center bg-white">
                                <p class="text-xs font-medium uppercase tracking-wider text-ink-soft mb-1">Status</p>
                                <p class="text-sm font-semibold
                                    <?php echo e($membership->status === 'active' ? 'text-emerald-600' : 'text-amber-600'); ?>">
                                    <?php echo e(ucfirst($membership->status)); ?>

                                </p>
                            </div>
                            <div class="px-5 py-5 text-center bg-white">
                                <p class="text-xs font-medium uppercase tracking-wider text-ink-soft mb-1">Total Paid</p>
                                <p class="text-sm font-semibold text-navy-900"><?php echo e(number_format($totalPaid)); ?>&#2547;</p>
                            </div>
                            <div class="px-5 py-5 text-center bg-white">
                                <p class="text-xs font-medium uppercase tracking-wider text-ink-soft mb-1">Outstanding</p>
                                <p class="text-sm font-semibold <?php echo e($outstandingBalance > 0 ? 'text-red-600' : 'text-emerald-600'); ?>"><?php echo e(number_format($outstandingBalance)); ?>&#2547;</p>
                            </div>
                            <div class="px-5 py-5 text-center bg-white">
                                <p class="text-xs font-medium uppercase tracking-wider text-ink-soft mb-1">Visibility</p>
                                <p class="text-sm font-semibold text-navy-900"><?php echo e($membership->is_public ? 'Public' : 'Private'); ?></p>
                            </div>
                        </div>
                    </div>

                    
                    <div class="premium-card p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="font-medium text-navy-950">Public Directory Visibility</h3>
                                <p class="mt-1 text-sm text-ink-soft max-w-xl">Allow other alumni and visitors to see your profile in the public directory. Your personal contact information remains hidden.</p>
                            </div>
                            <form method="POST" action="<?php echo e(route('member.visibility.toggle')); ?>">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PATCH'); ?>
                                <button type="submit"
                                        class="relative inline-flex h-6 w-11 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus-ring <?php echo e($membership->is_public ? 'bg-emerald-500' : 'bg-navy-200'); ?>">
                                    <span class="pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out <?php echo e($membership->is_public ? 'translate-x-5' : 'translate-x-0'); ?>"></span>
                                </button>
                            </form>
                        </div>
                    </div>
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
<?php /**PATH C:\xampp\htdocs\ProDo\EDAA\resources\views\member\membership\show.blade.php ENDPATH**/ ?>