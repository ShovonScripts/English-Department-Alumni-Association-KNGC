<?php if (isset($component)) { $__componentOriginalc8c9fd5d7827a77a31381de67195f0c3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc8c9fd5d7827a77a31381de67195f0c3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.admin','data' => ['title' => 'Executive Dashboard']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.admin'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Executive Dashboard']); ?>
    <?php
        $hour = now()->format('H');
        $greeting = $hour < 12 ? 'Good morning' : ($hour < 18 ? 'Good afternoon' : 'Good evening');
        $totalPendingActions = $applicationPendingCount + $unreadMessageCount + $pendingCorrectionCount;
    ?>

    
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-navy-950 via-navy-900 to-maroon-950 p-6 sm:p-8 text-white shadow-xl ring-1 ring-white/10 mb-8">
        
        <div class="pointer-events-none absolute -right-16 -top-16 h-64 w-64 rounded-full bg-gold-500/10 blur-3xl"></div>
        <div class="pointer-events-none absolute -left-16 -bottom-16 h-64 w-64 rounded-full bg-maroon-500/15 blur-3xl"></div>

        <div class="relative flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div class="space-y-2">
                <div class="flex items-center gap-2 text-xs font-semibold uppercase tracking-widest text-gold-300">
                    <span class="flex h-2 w-2 rounded-full bg-emerald-400 animate-ping"></span>
                    <span>EDAA Executive Terminal · <?php echo e(now()->format('l, F j, Y')); ?></span>
                </div>
                <h1 class="font-serif text-3xl sm:text-4xl font-bold tracking-tight text-white">
                    <?php echo e($greeting); ?>, <?php echo e(Auth::user()->name); ?>

                </h1>
                <p class="text-sm text-navy-200 max-w-xl leading-relaxed">
                    Here is the operational status of the English Department Alumni Association today.
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <a
                    href="<?php echo e(route('admin.membership-applications.index')); ?>"
                    class="focus-ring inline-flex items-center gap-2 rounded-xl bg-white/10 hover:bg-white/20 border border-white/20 px-4 py-2.5 text-xs font-semibold text-white backdrop-blur-md transition-all duration-200 shadow-sm hover:scale-102"
                >
                    <svg class="h-4 w-4 text-gold-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span>Applications (<?php echo e($applicationPendingCount); ?>)</span>
                </a>

                <a
                    href="<?php echo e(route('admin.events.create')); ?>"
                    class="focus-ring inline-flex items-center gap-2 rounded-xl bg-gold-500 hover:bg-gold-400 text-navy-950 px-4 py-2.5 text-xs font-bold transition-all duration-200 shadow-md shadow-gold-500/20 hover:scale-102"
                >
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    <span>+ New Event</span>
                </a>
            </div>
        </div>
    </div>

    
    <?php if($totalPendingActions > 0): ?>
        <div class="mb-8 rounded-2xl bg-amber-500/10 border border-amber-500/30 p-4 sm:p-5 text-navy-900 shadow-xs backdrop-blur-sm">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="flex items-center gap-3.5">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-amber-500 text-white shadow-sm">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </span>
                    <div>
                        <h2 class="text-sm font-bold text-navy-950">
                            <?php echo e($totalPendingActions); ?> Action <?php echo e(Str::plural('Item', $totalPendingActions)); ?> Requiring Administrative Attention
                        </h2>
                        <p class="text-xs text-navy-600">
                            Members and alumni are waiting for verification, correction, or replies.
                        </p>
                    </div>
                </div>

                <div class="flex flex-wrap items-center gap-2">
                    <?php if($applicationPendingCount > 0): ?>
                        <a href="<?php echo e(route('admin.membership-applications.index')); ?>" class="inline-flex items-center gap-1.5 rounded-lg bg-amber-100/90 hover:bg-amber-200 text-amber-950 px-3 py-1.5 text-xs font-semibold transition">
                            <span><?php echo e($applicationPendingCount); ?> Applications</span>
                            <span>→</span>
                        </a>
                    <?php endif; ?>

                    <?php if($pendingCorrectionCount > 0): ?>
                        <a href="<?php echo e(route('admin.correction-requests.index')); ?>" class="inline-flex items-center gap-1.5 rounded-lg bg-rose-100/90 hover:bg-rose-200 text-rose-950 px-3 py-1.5 text-xs font-semibold transition">
                            <span><?php echo e($pendingCorrectionCount); ?> Corrections</span>
                            <span>→</span>
                        </a>
                    <?php endif; ?>

                    <?php if($unreadMessageCount > 0): ?>
                        <a href="<?php echo e(route('admin.messages.index')); ?>" class="inline-flex items-center gap-1.5 rounded-lg bg-blue-100/90 hover:bg-blue-200 text-blue-950 px-3 py-1.5 text-xs font-semibold transition">
                            <span><?php echo e($unreadMessageCount); ?> Inquiries</span>
                            <span>→</span>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

    
    <div class="mb-10">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h2 class="font-serif text-xl font-bold tracking-tight text-navy-950">Community & Directory</h2>
                <p class="text-xs text-navy-500">Alumni enrollment, verified members, and incoming applications</p>
            </div>
            <a href="<?php echo e(route('admin.alumni.index')); ?>" class="text-xs font-semibold text-maroon-700 hover:text-maroon-900 transition flex items-center gap-1">
                <span>View Directory</span>
                <span>→</span>
            </a>
        </div>

        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <?php if (isset($component)) { $__componentOriginal3c3cb599308b2d9971dae437d0b6bab6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.stat-card','data' => ['label' => 'Total Alumni','value' => ''.e(number_format($alumniCount)).'','hint' => 'Active alumni records','href' => ''.e(route('admin.alumni.index')).'','icon' => 'M17 20h5v-2a3 3 0 00-5.4-1.7M9 20H4v-2a3 3 0 015.4-1.7M16 3.1a3 3 0 110 5.8M11 7a3 3 0 11-6 0 3 3 0 016 0z']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.stat-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Total Alumni','value' => ''.e(number_format($alumniCount)).'','hint' => 'Active alumni records','href' => ''.e(route('admin.alumni.index')).'','icon' => 'M17 20h5v-2a3 3 0 00-5.4-1.7M9 20H4v-2a3 3 0 015.4-1.7M16 3.1a3 3 0 110 5.8M11 7a3 3 0 11-6 0 3 3 0 016 0z']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6)): ?>
<?php $attributes = $__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6; ?>
<?php unset($__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3c3cb599308b2d9971dae437d0b6bab6)): ?>
<?php $component = $__componentOriginal3c3cb599308b2d9971dae437d0b6bab6; ?>
<?php unset($__componentOriginal3c3cb599308b2d9971dae437d0b6bab6); ?>
<?php endif; ?>
            <?php if (isset($component)) { $__componentOriginal3c3cb599308b2d9971dae437d0b6bab6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.stat-card','data' => ['label' => 'Registered Members','value' => ''.e(number_format($membershipActiveCount)).'','hint' => ''.e(number_format($membershipLifetimeCount)).' lifetime members','href' => ''.e(route('admin.members.index')).'','icon' => 'M12 4.35a2.65 2.65 0 110 5.3 2.65 2.65 0 010-5.3zM5 21v-1.6A5.4 5.4 0 0110.4 14h3.2A5.4 5.4 0 0119 19.4V21m2-9.5l1.6 1.6M21 5.5L19.4 7M3 11.5L4.6 13.1M5 5.5L6.6 7.1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.stat-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Registered Members','value' => ''.e(number_format($membershipActiveCount)).'','hint' => ''.e(number_format($membershipLifetimeCount)).' lifetime members','href' => ''.e(route('admin.members.index')).'','icon' => 'M12 4.35a2.65 2.65 0 110 5.3 2.65 2.65 0 010-5.3zM5 21v-1.6A5.4 5.4 0 0110.4 14h3.2A5.4 5.4 0 0119 19.4V21m2-9.5l1.6 1.6M21 5.5L19.4 7M3 11.5L4.6 13.1M5 5.5L6.6 7.1']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6)): ?>
<?php $attributes = $__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6; ?>
<?php unset($__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3c3cb599308b2d9971dae437d0b6bab6)): ?>
<?php $component = $__componentOriginal3c3cb599308b2d9971dae437d0b6bab6; ?>
<?php unset($__componentOriginal3c3cb599308b2d9971dae437d0b6bab6); ?>
<?php endif; ?>
            <?php if (isset($component)) { $__componentOriginal3c3cb599308b2d9971dae437d0b6bab6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.stat-card','data' => ['label' => 'Public Members','value' => ''.e(number_format($publicMemberCount)).'','hint' => 'Visible in directory','href' => ''.e(route('admin.members.index')).'','icon' => 'M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.stat-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Public Members','value' => ''.e(number_format($publicMemberCount)).'','hint' => 'Visible in directory','href' => ''.e(route('admin.members.index')).'','icon' => 'M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6)): ?>
<?php $attributes = $__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6; ?>
<?php unset($__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3c3cb599308b2d9971dae437d0b6bab6)): ?>
<?php $component = $__componentOriginal3c3cb599308b2d9971dae437d0b6bab6; ?>
<?php unset($__componentOriginal3c3cb599308b2d9971dae437d0b6bab6); ?>
<?php endif; ?>
            <?php if (isset($component)) { $__componentOriginal3c3cb599308b2d9971dae437d0b6bab6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.stat-card','data' => ['label' => 'Pending Applications','value' => ''.e(number_format($applicationPendingCount)).'','hint' => ''.e(number_format($applicationUnderReviewCount)).' under active review','href' => ''.e(route('admin.membership-applications.index')).'','badge' => ''.e($applicationPendingCount > 0 ? 'Action' : null).'','accent' => ''.e($applicationPendingCount > 0).'','icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.stat-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Pending Applications','value' => ''.e(number_format($applicationPendingCount)).'','hint' => ''.e(number_format($applicationUnderReviewCount)).' under active review','href' => ''.e(route('admin.membership-applications.index')).'','badge' => ''.e($applicationPendingCount > 0 ? 'Action' : null).'','accent' => ''.e($applicationPendingCount > 0).'','icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6)): ?>
<?php $attributes = $__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6; ?>
<?php unset($__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3c3cb599308b2d9971dae437d0b6bab6)): ?>
<?php $component = $__componentOriginal3c3cb599308b2d9971dae437d0b6bab6; ?>
<?php unset($__componentOriginal3c3cb599308b2d9971dae437d0b6bab6); ?>
<?php endif; ?>
            <?php if (isset($component)) { $__componentOriginal3c3cb599308b2d9971dae437d0b6bab6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.stat-card','data' => ['label' => 'Correction Requests','value' => ''.e(number_format($pendingCorrectionCount)).'','hint' => 'Alumni profile edits','href' => ''.e(route('admin.correction-requests.index')).'','icon' => 'M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.stat-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Correction Requests','value' => ''.e(number_format($pendingCorrectionCount)).'','hint' => 'Alumni profile edits','href' => ''.e(route('admin.correction-requests.index')).'','icon' => 'M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6)): ?>
<?php $attributes = $__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6; ?>
<?php unset($__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3c3cb599308b2d9971dae437d0b6bab6)): ?>
<?php $component = $__componentOriginal3c3cb599308b2d9971dae437d0b6bab6; ?>
<?php unset($__componentOriginal3c3cb599308b2d9971dae437d0b6bab6); ?>
<?php endif; ?>
        </div>
    </div>

    
    <div class="mb-10">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h2 class="font-serif text-xl font-bold tracking-tight text-navy-950">Financial Health & Treasury</h2>
                <p class="text-xs text-navy-500">Manual dues collections, association expenses, and current ledger balance</p>
            </div>
            <a href="<?php echo e(route('admin.finance.index')); ?>" class="text-xs font-semibold text-maroon-700 hover:text-maroon-900 transition flex items-center gap-1">
                <span>Detailed Ledger</span>
                <span>→</span>
            </a>
        </div>

        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <?php if (isset($component)) { $__componentOriginal3c3cb599308b2d9971dae437d0b6bab6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.stat-card','data' => ['label' => 'Total Collections','value' => '৳'.e(number_format($totalCollections)).'','hint' => ''.e(number_format($validPaymentCount)).' verified receipts','href' => ''.e(route('admin.payments.index')).'','icon' => 'M3 6h18v12H3V6zm0 3h18m-4 6h2','accent' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.stat-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Total Collections','value' => '৳'.e(number_format($totalCollections)).'','hint' => ''.e(number_format($validPaymentCount)).' verified receipts','href' => ''.e(route('admin.payments.index')).'','icon' => 'M3 6h18v12H3V6zm0 3h18m-4 6h2','accent' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6)): ?>
<?php $attributes = $__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6; ?>
<?php unset($__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3c3cb599308b2d9971dae437d0b6bab6)): ?>
<?php $component = $__componentOriginal3c3cb599308b2d9971dae437d0b6bab6; ?>
<?php unset($__componentOriginal3c3cb599308b2d9971dae437d0b6bab6); ?>
<?php endif; ?>
            <?php if (isset($component)) { $__componentOriginal3c3cb599308b2d9971dae437d0b6bab6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.stat-card','data' => ['label' => 'Month Collections','value' => '৳'.e(number_format($collectionsThisMonth)).'','hint' => ''.e(now()->format('F Y')).'','href' => ''.e(route('admin.payments.index')).'','icon' => 'M8 7V3m8 4V3M4 11h16M5 5h14a1 1 0 011 1v13a1 1 0 01-1 1H5a1 1 0 01-1-1V6a1 1 0 011-1z']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.stat-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Month Collections','value' => '৳'.e(number_format($collectionsThisMonth)).'','hint' => ''.e(now()->format('F Y')).'','href' => ''.e(route('admin.payments.index')).'','icon' => 'M8 7V3m8 4V3M4 11h16M5 5h14a1 1 0 011 1v13a1 1 0 01-1 1H5a1 1 0 01-1-1V6a1 1 0 011-1z']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6)): ?>
<?php $attributes = $__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6; ?>
<?php unset($__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3c3cb599308b2d9971dae437d0b6bab6)): ?>
<?php $component = $__componentOriginal3c3cb599308b2d9971dae437d0b6bab6; ?>
<?php unset($__componentOriginal3c3cb599308b2d9971dae437d0b6bab6); ?>
<?php endif; ?>
            <?php if (isset($component)) { $__componentOriginal3c3cb599308b2d9971dae437d0b6bab6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.stat-card','data' => ['label' => 'Association Expenses','value' => ''.e(\App\Services\FinanceService::formatBalance((float) $totalExpenses)).'','hint' => 'Total expenditures recorded','href' => ''.e(route('admin.expenses.index')).'','icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.stat-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Association Expenses','value' => ''.e(\App\Services\FinanceService::formatBalance((float) $totalExpenses)).'','hint' => 'Total expenditures recorded','href' => ''.e(route('admin.expenses.index')).'','icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6)): ?>
<?php $attributes = $__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6; ?>
<?php unset($__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3c3cb599308b2d9971dae437d0b6bab6)): ?>
<?php $component = $__componentOriginal3c3cb599308b2d9971dae437d0b6bab6; ?>
<?php unset($__componentOriginal3c3cb599308b2d9971dae437d0b6bab6); ?>
<?php endif; ?>
            <?php if (isset($component)) { $__componentOriginal3c3cb599308b2d9971dae437d0b6bab6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.stat-card','data' => ['label' => 'Net Balance','value' => ''.e(\App\Services\FinanceService::formatBalance((float) $currentBalance)).'','hint' => 'Collections less expenses','href' => ''.e(route('admin.finance.index')).'','icon' => 'M3 12h4l2-6 4 12 2-6h6']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.stat-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Net Balance','value' => ''.e(\App\Services\FinanceService::formatBalance((float) $currentBalance)).'','hint' => 'Collections less expenses','href' => ''.e(route('admin.finance.index')).'','icon' => 'M3 12h4l2-6 4 12 2-6h6']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6)): ?>
<?php $attributes = $__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6; ?>
<?php unset($__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3c3cb599308b2d9971dae437d0b6bab6)): ?>
<?php $component = $__componentOriginal3c3cb599308b2d9971dae437d0b6bab6; ?>
<?php unset($__componentOriginal3c3cb599308b2d9971dae437d0b6bab6); ?>
<?php endif; ?>
        </div>
    </div>

    
    <div class="grid gap-6 lg:grid-cols-2 mb-10">
        
        <div class="rounded-3xl bg-white border border-navy-100 p-6 shadow-sm">
            <div class="flex items-center justify-between pb-4 border-b border-navy-100">
                <div class="flex items-center gap-2.5">
                    <span class="flex h-8 w-8 items-center justify-center rounded-xl bg-amber-100 text-amber-800 font-bold text-xs">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </span>
                    <div>
                        <h2 class="font-serif text-base font-bold text-navy-950">Recent Applications</h2>
                        <p class="text-[11px] text-navy-500">Prospective alumni awaiting review</p>
                    </div>
                </div>
                <a href="<?php echo e(route('admin.membership-applications.index')); ?>" class="text-xs font-semibold text-navy-600 hover:text-navy-950 transition">
                    View All →
                </a>
            </div>

            <div class="mt-4 divide-y divide-navy-50">
                <?php $__empty_1 = true; $__currentLoopData = $recentApplications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $app): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="py-3 flex items-center justify-between gap-3 group hover:bg-slate-50/80 rounded-xl px-2 transition">
                        <div class="min-w-0">
                            <p class="text-xs font-bold text-navy-900 truncate"><?php echo e($app->full_name); ?></p>
                            <p class="text-[11px] text-navy-500">
                                <?php echo e($app->membershipType?->name ?? 'Membership'); ?> · Batch <?php echo e($app->batch ?? 'N/A'); ?>

                            </p>
                        </div>
                        <div class="flex items-center gap-2 shrink-0">
                            <span class="rounded-full px-2 py-0.5 text-[10px] font-semibold <?php echo e($app->isPending() ? 'bg-amber-100 text-amber-800' : ($app->isApproved() ? 'bg-emerald-100 text-emerald-800' : 'bg-navy-100 text-navy-700')); ?>">
                                <?php echo e(ucfirst($app->status->value ?? 'Pending')); ?>

                            </span>
                            <a href="<?php echo e(route('admin.membership-applications.show', $app)); ?>" class="text-xs font-semibold text-maroon-700 hover:text-maroon-900 group-hover:translate-x-0.5 transition">
                                Review →
                            </a>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="py-8 text-center text-xs text-navy-400">
                        No pending membership applications found.
                    </div>
                <?php endif; ?>
            </div>
        </div>

        
        <div class="rounded-3xl bg-white border border-navy-100 p-6 shadow-sm">
            <div class="flex items-center justify-between pb-4 border-b border-navy-100">
                <div class="flex items-center gap-2.5">
                    <span class="flex h-8 w-8 items-center justify-center rounded-xl bg-emerald-100 text-emerald-800 font-bold text-xs">
                        ৳
                    </span>
                    <div>
                        <h2 class="font-serif text-base font-bold text-navy-950">Recent Collections</h2>
                        <p class="text-[11px] text-navy-500">Audited dues and registration payments</p>
                    </div>
                </div>
                <a href="<?php echo e(route('admin.payments.index')); ?>" class="text-xs font-semibold text-navy-600 hover:text-navy-950 transition">
                    View All →
                </a>
            </div>

            <div class="mt-4 divide-y divide-navy-50">
                <?php $__empty_1 = true; $__currentLoopData = $recentPayments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="py-3 flex items-center justify-between gap-3 group hover:bg-slate-50/80 rounded-xl px-2 transition">
                        <div class="min-w-0">
                            <p class="text-xs font-bold text-navy-900 truncate">
                                <?php echo e($payment->membership?->alumni?->full_name ?? $payment->payment_number); ?>

                            </p>
                            <p class="text-[11px] text-navy-500">
                                <?php echo e($payment->payment_number); ?> · <?php echo e($payment->paid_at?->format('M d, Y') ?? $payment->created_at->format('M d, Y')); ?>

                            </p>
                        </div>
                        <div class="flex items-center gap-3 shrink-0">
                            <span class="font-serif text-sm font-bold text-navy-950">
                                <?php echo e($payment->formattedAmount()); ?>

                            </span>
                            <a href="<?php echo e(route('admin.payments.show', $payment)); ?>" class="text-xs font-semibold text-maroon-700 hover:text-maroon-900 group-hover:translate-x-0.5 transition">
                                View →
                            </a>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="py-8 text-center text-xs text-navy-400">
                        No recent payments recorded.
                    </div>
                <?php endif; ?>
            </div>
        </div>

        
        <div class="rounded-3xl bg-white border border-navy-100 p-6 shadow-sm">
            <div class="flex items-center justify-between pb-4 border-b border-navy-100">
                <div class="flex items-center gap-2.5">
                    <span class="flex h-8 w-8 items-center justify-center rounded-xl bg-gold-100 text-gold-800 font-bold text-xs">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3M4 11h16M5 5h14a1 1 0 011 1v13a1 1 0 01-1 1H5a1 1 0 01-1-1V6a1 1 0 011-1z" />
                        </svg>
                    </span>
                    <div>
                        <h2 class="font-serif text-base font-bold text-navy-950">Upcoming Events</h2>
                        <p class="text-[11px] text-navy-500">Scheduled gatherings & seminars</p>
                    </div>
                </div>
                <a href="<?php echo e(route('admin.events.index')); ?>" class="text-xs font-semibold text-navy-600 hover:text-navy-950 transition">
                    View All →
                </a>
            </div>

            <div class="mt-4 divide-y divide-navy-50">
                <?php $__empty_1 = true; $__currentLoopData = $upcomingEvents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="py-3 flex items-center justify-between gap-3 group hover:bg-slate-50/80 rounded-xl px-2 transition">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="flex flex-col items-center justify-center h-10 w-10 rounded-xl bg-navy-50 border border-navy-100 text-navy-900 shrink-0">
                                <span class="text-[9px] font-bold uppercase text-maroon-700"><?php echo e($event->event_date?->format('M')); ?></span>
                                <span class="text-sm font-extrabold"><?php echo e($event->event_date?->format('d')); ?></span>
                            </div>
                            <div class="min-w-0">
                                <p class="text-xs font-bold text-navy-900 truncate"><?php echo e($event->title); ?></p>
                                <p class="text-[11px] text-navy-500 truncate"><?php echo e($event->venue ?? 'Venue TBA'); ?></p>
                            </div>
                        </div>
                        <a href="<?php echo e(route('admin.events.edit', $event)); ?>" class="text-xs font-semibold text-maroon-700 hover:text-maroon-900 shrink-0 group-hover:translate-x-0.5 transition">
                            Edit →
                        </a>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="py-8 text-center text-xs text-navy-400">
                        No upcoming events scheduled.
                    </div>
                <?php endif; ?>
            </div>
        </div>

        
        <div class="rounded-3xl bg-white border border-navy-100 p-6 shadow-sm">
            <div class="flex items-center justify-between pb-4 border-b border-navy-100">
                <div class="flex items-center gap-2.5">
                    <span class="flex h-8 w-8 items-center justify-center rounded-xl bg-blue-100 text-blue-800 font-bold text-xs">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </span>
                    <div>
                        <h2 class="font-serif text-base font-bold text-navy-950">Recent Inquiries</h2>
                        <p class="text-[11px] text-navy-500">Contact submissions from alumni & visitors</p>
                    </div>
                </div>
                <a href="<?php echo e(route('admin.messages.index')); ?>" class="text-xs font-semibold text-navy-600 hover:text-navy-950 transition">
                    View All →
                </a>
            </div>

            <div class="mt-4 divide-y divide-navy-50">
                <?php $__empty_1 = true; $__currentLoopData = $recentMessages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="py-3 flex items-center justify-between gap-3 group hover:bg-slate-50/80 rounded-xl px-2 transition">
                        <div class="flex items-center gap-2.5 min-w-0">
                            <?php if($message->isUnread()): ?>
                                <span class="h-2 w-2 rounded-full bg-blue-600 shrink-0"></span>
                            <?php else: ?>
                                <span class="h-2 w-2 rounded-full bg-navy-200 shrink-0"></span>
                            <?php endif; ?>
                            <div class="min-w-0">
                                <p class="text-xs font-bold text-navy-900 truncate"><?php echo e($message->name); ?></p>
                                <p class="text-[11px] text-navy-500 truncate"><?php echo e($message->subject ?: 'No subject'); ?></p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 shrink-0">
                            <span class="text-[10px] text-navy-400"><?php echo e($message->created_at->diffForHumans(null, true)); ?></span>
                            <a href="<?php echo e(route('admin.messages.show', $message)); ?>" class="text-xs font-semibold text-maroon-700 hover:text-maroon-900 group-hover:translate-x-0.5 transition">
                                Open →
                            </a>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="py-8 text-center text-xs text-navy-400">
                        No contact messages received yet.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    
    <div class="mb-10">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h2 class="font-serif text-xl font-bold tracking-tight text-navy-950">Editorial & Publishing</h2>
                <p class="text-xs text-navy-500">Articles, alumni success stories, galleries, and publications</p>
            </div>
        </div>

        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <?php if (isset($component)) { $__componentOriginal3c3cb599308b2d9971dae437d0b6bab6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.stat-card','data' => ['label' => 'News Articles','value' => ''.e(number_format($newsPublishedCount)).'','hint' => ''.e($newsDraftCount).' unpublished drafts','href' => ''.e(route('admin.news.index')).'','icon' => 'M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.stat-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'News Articles','value' => ''.e(number_format($newsPublishedCount)).'','hint' => ''.e($newsDraftCount).' unpublished drafts','href' => ''.e(route('admin.news.index')).'','icon' => 'M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6)): ?>
<?php $attributes = $__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6; ?>
<?php unset($__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3c3cb599308b2d9971dae437d0b6bab6)): ?>
<?php $component = $__componentOriginal3c3cb599308b2d9971dae437d0b6bab6; ?>
<?php unset($__componentOriginal3c3cb599308b2d9971dae437d0b6bab6); ?>
<?php endif; ?>
            <?php if (isset($component)) { $__componentOriginal3c3cb599308b2d9971dae437d0b6bab6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.stat-card','data' => ['label' => 'Alumni Stories','value' => ''.e(number_format($storyPublishedCount)).'','hint' => ''.e($storyDraftCount).' draft stories','href' => ''.e(route('admin.stories.index')).'','icon' => 'M9.6 4C5.4 5.4 3 8.6 3 13.2V20h6.8v-6.8H6.4c0-2.8 1.4-4.9 4.2-5.8L9.6 4zm11 0c-4.2 1.4-6.6 4.6-6.6 9.2V20h6.8v-6.8h-3.4c0-2.8 1.4-4.9 4.2-5.8L20.6 4z']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.stat-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Alumni Stories','value' => ''.e(number_format($storyPublishedCount)).'','hint' => ''.e($storyDraftCount).' draft stories','href' => ''.e(route('admin.stories.index')).'','icon' => 'M9.6 4C5.4 5.4 3 8.6 3 13.2V20h6.8v-6.8H6.4c0-2.8 1.4-4.9 4.2-5.8L9.6 4zm11 0c-4.2 1.4-6.6 4.6-6.6 9.2V20h6.8v-6.8h-3.4c0-2.8 1.4-4.9 4.2-5.8L20.6 4z']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6)): ?>
<?php $attributes = $__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6; ?>
<?php unset($__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3c3cb599308b2d9971dae437d0b6bab6)): ?>
<?php $component = $__componentOriginal3c3cb599308b2d9971dae437d0b6bab6; ?>
<?php unset($__componentOriginal3c3cb599308b2d9971dae437d0b6bab6); ?>
<?php endif; ?>
            <?php if (isset($component)) { $__componentOriginal3c3cb599308b2d9971dae437d0b6bab6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.stat-card','data' => ['label' => 'Press Releases','value' => ''.e(number_format($pressReleasePublishedCount)).'','hint' => ''.e($pressReleaseDraftCount).' drafts','href' => ''.e(route('admin.press-releases.index')).'','icon' => 'M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.stat-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Press Releases','value' => ''.e(number_format($pressReleasePublishedCount)).'','hint' => ''.e($pressReleaseDraftCount).' drafts','href' => ''.e(route('admin.press-releases.index')).'','icon' => 'M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6)): ?>
<?php $attributes = $__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6; ?>
<?php unset($__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3c3cb599308b2d9971dae437d0b6bab6)): ?>
<?php $component = $__componentOriginal3c3cb599308b2d9971dae437d0b6bab6; ?>
<?php unset($__componentOriginal3c3cb599308b2d9971dae437d0b6bab6); ?>
<?php endif; ?>
            <?php if (isset($component)) { $__componentOriginal3c3cb599308b2d9971dae437d0b6bab6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.stat-card','data' => ['label' => 'Publications','value' => ''.e(number_format($publicationPublishedCount)).'','hint' => ''.e($publicationDraftCount).' drafts in review','href' => ''.e(route('admin.publications.index')).'','icon' => 'M12 6.3v11.4m0-11.4A3.2 3.2 0 009.5 3.5H6.5v13h3a3.2 3.2 0 013 2.8m-.5-12.9a3.2 3.2 0 012.5-2.8h3v13h-3a3.2 3.2 0 00-3 2.8m0-12.9v11.4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.stat-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Publications','value' => ''.e(number_format($publicationPublishedCount)).'','hint' => ''.e($publicationDraftCount).' drafts in review','href' => ''.e(route('admin.publications.index')).'','icon' => 'M12 6.3v11.4m0-11.4A3.2 3.2 0 009.5 3.5H6.5v13h3a3.2 3.2 0 013 2.8m-.5-12.9a3.2 3.2 0 012.5-2.8h3v13h-3a3.2 3.2 0 00-3 2.8m0-12.9v11.4']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6)): ?>
<?php $attributes = $__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6; ?>
<?php unset($__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3c3cb599308b2d9971dae437d0b6bab6)): ?>
<?php $component = $__componentOriginal3c3cb599308b2d9971dae437d0b6bab6; ?>
<?php unset($__componentOriginal3c3cb599308b2d9971dae437d0b6bab6); ?>
<?php endif; ?>
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
<?php endif; ?><?php /**PATH C:\xampp\htdocs\ProDo\EDAA\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>