<?php if (isset($component)) { $__componentOriginalc8c9fd5d7827a77a31381de67195f0c3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc8c9fd5d7827a77a31381de67195f0c3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.admin','data' => ['title' => 'Correction Request Details']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.admin'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Correction Request Details']); ?>
    <?php
        $alumni = $correctionRequest->alumni;
        $currentValue = $alumni?->{$correctionRequest->requested_field} ?? '—';
    ?>

    <div class="mb-6">
        <div class="flex items-center gap-2 text-xs font-semibold text-navy-500 uppercase tracking-wider mb-1">
            <a href="<?php echo e(route('admin.dashboard')); ?>" class="hover:text-navy-900 transition">Dashboard</a>
            <span>/</span>
            <a href="<?php echo e(route('admin.correction-requests.index')); ?>" class="hover:text-navy-900 transition">Correction Requests</a>
            <span>/</span>
            <span class="text-navy-800">#<?php echo e($correctionRequest->id); ?></span>
        </div>
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="font-serif text-2xl sm:text-3xl font-bold tracking-tight text-navy-950">
                    Correction Request #<?php echo e($correctionRequest->id); ?>

                </h1>
                <p class="text-xs sm:text-sm text-navy-500 mt-1">
                    Submitted on <?php echo e($correctionRequest->created_at->format('F j, Y \a\t g:i A')); ?>

                </p>
            </div>

            <div class="flex items-center gap-2">
                <a
                    href="<?php echo e(route('admin.correction-requests.index')); ?>"
                    class="rounded-xl border border-navy-200 bg-white px-4 py-2 text-xs font-semibold text-navy-700 hover:bg-navy-50 transition"
                >
                    ← Back to List
                </a>

                <?php if($correctionRequest->status === 'pending'): ?>
                    <form method="POST" action="<?php echo e(route('admin.correction-requests.reject', $correctionRequest)); ?>" onsubmit="return confirm('Are you sure you want to reject this correction request?')">
                        <?php echo csrf_field(); ?>
                        <button
                            type="submit"
                            class="rounded-xl border border-rose-200 bg-rose-50 px-4 py-2 text-xs font-semibold text-rose-700 hover:bg-rose-100 transition"
                        >
                            Reject
                        </button>
                    </form>

                    <form method="POST" action="<?php echo e(route('admin.correction-requests.approve', $correctionRequest)); ?>" onsubmit="return confirm('Approve this change? The alumni profile record will be updated immediately.')">
                        <?php echo csrf_field(); ?>
                        <button
                            type="submit"
                            class="rounded-xl bg-gradient-to-r from-emerald-600 to-emerald-700 px-4 py-2 text-xs font-bold text-white shadow-md hover:from-emerald-700 hover:to-emerald-800 transition"
                        >
                            Approve & Update Profile
                        </button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="grid gap-6 lg:grid-cols-3">
        
        <div class="rounded-3xl bg-white border border-navy-100 p-6 shadow-sm">
            <h2 class="font-serif text-base font-bold text-navy-950 pb-3 border-b border-navy-100">
                Alumni Member
            </h2>

            <div class="mt-4 space-y-3 text-xs">
                <div>
                    <span class="text-navy-400 block text-[10px] uppercase font-bold tracking-wider">Full Name</span>
                    <span class="font-bold text-navy-950 text-sm"><?php echo e($alumni?->full_name ?? '—'); ?></span>
                </div>
                <div>
                    <span class="text-navy-400 block text-[10px] uppercase font-bold tracking-wider">Email Address</span>
                    <span class="text-navy-800"><?php echo e($alumni?->email ?? '—'); ?></span>
                </div>
                <div>
                    <span class="text-navy-400 block text-[10px] uppercase font-bold tracking-wider">Student ID</span>
                    <span class="text-navy-800 font-mono"><?php echo e($alumni?->student_id ?? '—'); ?></span>
                </div>
                <div>
                    <span class="text-navy-400 block text-[10px] uppercase font-bold tracking-wider">Batch</span>
                    <span class="text-navy-800"><?php echo e($alumni?->batch ?? '—'); ?></span>
                </div>
                <div>
                    <span class="text-navy-400 block text-[10px] uppercase font-bold tracking-wider">Graduation Year</span>
                    <span class="text-navy-800"><?php echo e($alumni?->graduation_year ?? '—'); ?></span>
                </div>
            </div>

            <?php if($alumni): ?>
                <div class="mt-6 pt-4 border-t border-navy-100">
                    <a
                        href="<?php echo e(route('admin.alumni.show', $alumni)); ?>"
                        class="inline-flex items-center gap-1 text-xs font-bold text-maroon-700 hover:text-maroon-900 transition"
                    >
                        <span>View Full Alumni Record</span>
                        <span>→</span>
                    </a>
                </div>
            <?php endif; ?>
        </div>

        
        <div class="lg:col-span-2 space-y-6">
            
            <div class="rounded-3xl bg-white border border-navy-100 p-6 shadow-sm">
                <div class="flex items-center justify-between pb-4 border-b border-navy-100">
                    <div>
                        <h2 class="font-serif text-base font-bold text-navy-950">Field Comparison</h2>
                        <p class="text-xs text-navy-500">Target Field: <strong class="font-mono text-navy-900"><?php echo e($correctionRequest->requested_field); ?></strong></p>
                    </div>

                    <div>
                        <?php if($correctionRequest->status === 'pending'): ?>
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-100 px-3 py-1 text-xs font-bold text-amber-800">
                                <span class="h-2 w-2 rounded-full bg-amber-600 animate-pulse"></span>
                                Pending Review
                            </span>
                        <?php elseif($correctionRequest->status === 'approved'): ?>
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-100 px-3 py-1 text-xs font-bold text-emerald-800">
                                <span class="h-2 w-2 rounded-full bg-emerald-600"></span>
                                Approved
                            </span>
                        <?php else: ?>
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-rose-100 px-3 py-1 text-xs font-bold text-rose-800">
                                <span class="h-2 w-2 rounded-full bg-rose-600"></span>
                                Rejected
                            </span>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="mt-6 grid gap-4 sm:grid-cols-2">
                    <div class="rounded-2xl bg-rose-50/50 border border-rose-200/60 p-4">
                        <span class="text-[10px] font-bold uppercase tracking-wider text-rose-600">Current Value in Database</span>
                        <p class="mt-2 font-mono text-base font-semibold text-navy-900 line-through">
                            <?php echo e($currentValue); ?>

                        </p>
                    </div>

                    <div class="rounded-2xl bg-emerald-50/60 border border-emerald-200/80 p-4">
                        <span class="text-[10px] font-bold uppercase tracking-wider text-emerald-700">Requested New Value</span>
                        <p class="mt-2 font-mono text-base font-bold text-emerald-950">
                            <?php echo e($correctionRequest->requested_value); ?>

                        </p>
                    </div>
                </div>

                <div class="mt-6">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-navy-400">Justification / Reason</h3>
                    <div class="mt-2 rounded-2xl bg-navy-50/50 border border-navy-100 p-4 text-xs leading-relaxed text-navy-800">
                        <?php echo e($correctionRequest->reason ?: 'No explanation was submitted with this request.'); ?>

                    </div>
                </div>
            </div>

            
            <div class="rounded-3xl bg-white border border-navy-100 p-6 shadow-sm">
                <h2 class="font-serif text-base font-bold text-navy-950 pb-3 border-b border-navy-100">
                    Audit Log
                </h2>

                <div class="mt-4 grid gap-4 sm:grid-cols-2 text-xs">
                    <div>
                        <span class="text-navy-400 block text-[10px] uppercase font-bold tracking-wider">Reviewer</span>
                        <span class="font-semibold text-navy-900"><?php echo e($correctionRequest->reviewer?->name ?? 'Not reviewed yet'); ?></span>
                    </div>
                    <div>
                        <span class="text-navy-400 block text-[10px] uppercase font-bold tracking-wider">Reviewed At</span>
                        <span class="text-navy-900"><?php echo e($correctionRequest->reviewed_at ? $correctionRequest->reviewed_at->format('F j, Y \a\t g:i A') : 'Pending'); ?></span>
                    </div>
                </div>
            </div>
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
<?php /**PATH C:\xampp\htdocs\ProDo\EDAA\resources\views\admin\correction_requests\show.blade.php ENDPATH**/ ?>