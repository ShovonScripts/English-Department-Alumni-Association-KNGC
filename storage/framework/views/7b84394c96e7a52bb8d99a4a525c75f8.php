<?php if (isset($component)) { $__componentOriginalc8c9fd5d7827a77a31381de67195f0c3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc8c9fd5d7827a77a31381de67195f0c3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.admin','data' => ['title' => ''.e($admin->name).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.admin'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => ''.e($admin->name).'']); ?>
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="font-serif text-3xl font-semibold tracking-tight text-navy-950"><?php echo e($admin->name); ?></h1>
            <p class="mt-1 text-sm text-ink-soft"><?php echo e($admin->email); ?></p>
        </div>
        <div class="flex items-center gap-3">
            <a href="<?php echo e(route('admin.admins.edit', $admin)); ?>" class="focus-ring inline-flex items-center gap-2 rounded-lg border border-navy-300 px-4 py-2.5 text-sm font-semibold text-navy-900 transition-colors hover:bg-navy-50">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                Edit
            </a>
            <a href="<?php echo e(route('admin.admins.index')); ?>" class="focus-ring inline-flex items-center gap-2 rounded-md px-3.5 py-2.5 text-sm font-semibold text-navy-800 transition-colors hover:bg-navy-50">&larr; Back</a>
        </div>
    </div>

    <?php if(session('status')): ?>
        <div class="mb-6 flex items-center gap-3 rounded-md border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800" role="status">
            <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            <?php echo e(session('status')); ?>

        </div>
    <?php endif; ?>

    <div class="grid gap-8 lg:grid-cols-3">
        
        <div>
            <section class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm text-center">
                <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-navy-900 font-serif text-2xl font-bold text-gold-300">
                    <?php echo e(\Illuminate\Support\Str::initials($admin->name)); ?>

                </div>
                <h2 class="mt-4 font-serif text-xl font-semibold text-navy-950"><?php echo e($admin->name); ?></h2>
                <p class="mt-1 text-sm text-ink-soft"><?php echo e($admin->email); ?></p>

                <div class="mt-4 flex items-center justify-center gap-2">
                    <?php if($admin->id === auth()->id()): ?>
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">
                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span> You
                        </span>
                    <?php elseif($admin->status === 'active'): ?>
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">
                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span> Active
                        </span>
                    <?php else: ?>
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-navy-100 px-3 py-1 text-xs font-semibold text-navy-500">
                            <span class="h-1.5 w-1.5 rounded-full bg-navy-400"></span> Disabled
                        </span>
                    <?php endif; ?>
                </div>

                <div class="mt-6 space-y-2 text-sm text-ink-soft">
                    <p>Joined <?php echo e($admin->created_at->format('M d, Y')); ?></p>
                    <p><?php echo e($admin->activity_logs_count ?? 0); ?> total actions</p>
                </div>
            </section>
        </div>

        
        <div class="lg:col-span-2">
            <section class="rounded-lg border border-navy-100 bg-white shadow-sm">
                <div class="border-b border-navy-100 px-6 py-4">
                    <h3 class="font-serif text-lg font-semibold text-navy-950">Activity Log</h3>
                </div>

                <?php if($activityLogs->isEmpty()): ?>
                    <div class="px-6 py-12 text-center text-sm text-ink-soft">No activity recorded yet.</div>
                <?php else: ?>
                    <ul class="divide-y divide-navy-100">
                        <?php $__currentLoopData = $activityLogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="px-6 py-4 hover:bg-cream/50 transition-colors">
                                <div class="flex items-start gap-3">
                                    <div class="mt-0.5 flex h-8 w-8 shrink-0 items-center justify-center rounded-full
                                        <?php echo e(match($log->action) {
                                            'login' => 'bg-emerald-100 text-emerald-600',
                                            'admin_created', 'create' => 'bg-blue-100 text-blue-600',
                                            'admin_updated', 'update' => 'bg-gold-100 text-gold-600',
                                            'admin_deleted', 'delete' => 'bg-maroon-100 text-maroon-600',
                                            default => 'bg-navy-100 text-navy-600',
                                        }); ?>">
                                        <?php if(str_contains($log->action, 'login')): ?>
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" /></svg>
                                        <?php elseif(str_contains($log->action, 'create')): ?>
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" /></svg>
                                        <?php elseif(str_contains($log->action, 'update') || str_contains($log->action, 'toggle')): ?>
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                        <?php elseif(str_contains($log->action, 'delete')): ?>
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                        <?php else: ?>
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                        <?php endif; ?>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <p class="text-sm text-navy-950"><?php echo e($log->description); ?></p>
                                        <div class="mt-1 flex items-center gap-3 text-xs text-ink-soft">
                                            <span><?php echo e($log->created_at->diffForHumans()); ?></span>
                                            <?php if($log->ip_address): ?>
                                                <span>&middot; IP: <?php echo e($log->ip_address); ?></span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>

                    <div class="border-t border-navy-100 px-6 py-4">
                        <?php echo e($activityLogs->links()); ?>

                    </div>
                <?php endif; ?>
            </section>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc8c9fd5d7827a77a31381de67195f0c3)): ?>
<?php $attributes = $__attributesOriginalc8c9fd5d7827a77a31381de67195f0c3; ?>
<?php unset($__attributesOriginalc8c9fd5d7827a77a31381de67195f0c3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc8c9fd5d7827a77a31381de67195f0c3)): ?>
<?php $component = $__componentOriginalc8c9fd5d7827a77a31381de67195f0c3; ?>
<?php unset($__componentOriginalc8c9fd5d7827a77a31381de67195f0c3); ?>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\ProDo\EDAA\resources\views\admin\admins\show.blade.php ENDPATH**/ ?>