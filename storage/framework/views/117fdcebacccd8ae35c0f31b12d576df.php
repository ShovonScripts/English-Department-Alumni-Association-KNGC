<?php if (isset($component)) { $__componentOriginalc8c9fd5d7827a77a31381de67195f0c3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc8c9fd5d7827a77a31381de67195f0c3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.admin','data' => ['title' => 'Membership Applications']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.admin'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Membership Applications']); ?>
    <div class="mb-8 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="font-serif text-3xl font-semibold tracking-tight text-navy-950">Membership Applications</h1>
            <p class="text-sm text-ink-soft"><?php echo e($applications->total()); ?> application<?php echo e($applications->total() !== 1 ? 's' : ''); ?> total</p>
        </div>
    </div>

    
    <form method="GET" class="mb-6 rounded-lg border border-navy-100 bg-white p-4 shadow-sm">
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <div>
                <label for="q" class="mb-1 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Search</label>
                <input
                    id="q"
                    type="text"
                    name="q"
                    value="<?php echo e(request('q')); ?>"
                    placeholder="Number, name, email, phone…"
                    class="input-field"
                >
            </div>
            <div>
                <label for="status" class="mb-1 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Status</label>
                <select id="status" name="status" class="input-field">
                    <option value="">All Statuses</option>
                    <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($status->value); ?>" <?php echo e(request('status') === $status->value ? 'selected' : ''); ?>>
                            <?php echo e($status->label()); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div>
                <label for="membership_type_id" class="mb-1 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Membership Type</label>
                <select id="membership_type_id" name="membership_type_id" class="input-field">
                    <option value="">All Types</option>
                    <?php $__currentLoopData = $membershipTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($type->id); ?>" <?php echo e(request('membership_type_id') == $type->id ? 'selected' : ''); ?>>
                            <?php echo e($type->name); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div>
                <label for="requested_tier_id" class="mb-1 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Tier</label>
                <select id="requested_tier_id" name="requested_tier_id" class="input-field">
                    <option value="">All Tiers</option>
                    <?php $__currentLoopData = $membershipTiers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($tier->id); ?>" <?php echo e(request('requested_tier_id') == $tier->id ? 'selected' : ''); ?>>
                            <?php echo e($tier->name); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
        </div>
        <div class="mt-4 flex items-end gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <div>
                <label for="date_from" class="mb-1 block text-xs font-semibold uppercase tracking-wider text-ink-soft">From</label>
                <input id="date_from" type="date" name="date_from" value="<?php echo e(request('date_from')); ?>" class="input-field">
            </div>
            <div>
                <label for="date_to" class="mb-1 block text-xs font-semibold uppercase tracking-wider text-ink-soft">To</label>
                <input id="date_to" type="date" name="date_to" value="<?php echo e(request('date_to')); ?>" class="input-field">
            </div>
            <div class="flex gap-2">
                <button type="submit" class="focus-ring inline-flex items-center gap-2 rounded-md bg-navy-900 px-4 py-2.5 text-sm font-semibold text-white transition-colors hover:bg-navy-800">
                    Filter
                </button>
                <?php if(request()->hasAny(['q', 'status', 'membership_type_id', 'requested_tier_id', 'date_from', 'date_to'])): ?>
                    <a href="<?php echo e(route('admin.membership-applications.index')); ?>" class="focus-ring inline-flex items-center gap-2 rounded-md border border-navy-200 px-4 py-2.5 text-sm font-semibold text-navy-600 transition-colors hover:bg-navy-50">
                        Clear
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </form>

    <?php if(session('success')): ?>
        <div class="mb-6 flex items-start gap-3 rounded-lg border border-green-200 bg-green-50 p-5 text-green-800" role="status">
            <svg class="mt-0.5 h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <p class="text-sm"><?php echo e(session('success')); ?></p>
        </div>
    <?php endif; ?>

    
    <?php if($applications->isNotEmpty()): ?>
        <div class="overflow-hidden rounded-lg border border-navy-100 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-navy-100 text-sm">
                    <thead class="bg-cream">
                        <tr>
                            <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-ink-soft">Application</th>
                            <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-ink-soft">Applicant</th>
                            <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-ink-soft">Type</th>
                            <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-ink-soft">Tier</th>
                            <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-ink-soft">Status</th>
                            <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-ink-soft">Submitted</th>
                            <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-ink-soft">Reviewed</th>
                            <th scope="col" class="px-6 py-3.5 text-right text-xs font-semibold uppercase tracking-wider text-ink-soft">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-navy-50">
                        <?php $__currentLoopData = $applications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $application): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $statusColor = match($application->status->value) {
                                    'pending' => 'bg-gold-100 text-gold-800',
                                    'under_review' => 'bg-navy-100 text-navy-800',
                                    'approved' => 'bg-emerald-100 text-emerald-800',
                                    'rejected' => 'bg-maroon-100 text-maroon-800',
                                    'changes_requested' => 'bg-amber-100 text-amber-800',
                                    'cancelled' => 'bg-navy-100 text-navy-800',
                                    default => 'bg-navy-100 text-navy-800',
                                };
                            ?>
                            <tr class="transition-colors hover:bg-cream/60">
                                <td class="whitespace-nowrap px-6 py-3.5">
                                    <a href="<?php echo e(route('admin.membership-applications.show', $application)); ?>" class="font-medium text-maroon-700 hover:text-maroon-800">
                                        <?php echo e($application->application_number); ?>

                                    </a>
                                </td>
                                <td class="px-6 py-3.5">
                                    <div class="font-medium text-navy-950"><?php echo e($application->full_name); ?></div>
                                    <div class="text-xs text-ink-soft"><?php echo e($application->email); ?></div>
                                </td>
                                <td class="px-6 py-3.5 text-ink-soft"><?php echo e($application->membershipType->name ?? '—'); ?></td>
                                <td class="px-6 py-3.5 text-ink-soft"><?php echo e($application->requestedTier->name ?? '—'); ?></td>
                                <td class="px-6 py-3.5">
                                    <span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-semibold <?php echo e($statusColor); ?>">
                                        <?php echo e($application->status->label()); ?>

                                    </span>
                                </td>
                                <td class="whitespace-nowrap px-6 py-3.5 text-ink-soft"><?php echo e($application->submitted_at?->format('d M Y') ?? '—'); ?></td>
                                <td class="whitespace-nowrap px-6 py-3.5 text-ink-soft"><?php echo e($application->reviewed_at?->format('d M Y') ?? '—'); ?></td>
                                <td class="whitespace-nowrap px-6 py-3.5 text-right">
                                    <a href="<?php echo e(route('admin.membership-applications.show', $application)); ?>" class="focus-ring inline-flex items-center gap-1 rounded-md px-2.5 py-1.5 text-xs font-semibold text-navy-600 transition-colors hover:bg-navy-50">
                                        View
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-6">
            <?php echo e($applications->links()); ?>

        </div>
    <?php else: ?>
        <?php if (isset($component)) { $__componentOriginal074a021b9d42f490272b5eefda63257c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal074a021b9d42f490272b5eefda63257c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.empty-state','data' => ['title' => 'No applications found','description' => ''.e(request()->hasAny(['q', 'status', 'membership_type_id', 'requested_tier_id', 'date_from', 'date_to']) ? 'Try adjusting your filters.' : 'No membership applications have been submitted yet.').'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('empty-state'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'No applications found','description' => ''.e(request()->hasAny(['q', 'status', 'membership_type_id', 'requested_tier_id', 'date_from', 'date_to']) ? 'Try adjusting your filters.' : 'No membership applications have been submitted yet.').'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal074a021b9d42f490272b5eefda63257c)): ?>
<?php $attributes = $__attributesOriginal074a021b9d42f490272b5eefda63257c; ?>
<?php unset($__attributesOriginal074a021b9d42f490272b5eefda63257c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal074a021b9d42f490272b5eefda63257c)): ?>
<?php $component = $__componentOriginal074a021b9d42f490272b5eefda63257c; ?>
<?php unset($__componentOriginal074a021b9d42f490272b5eefda63257c); ?>
<?php endif; ?>
    <?php endif; ?>
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
<?php /**PATH C:\xampp\htdocs\ProDo\EDAA\resources\views\admin\membership-applications\index.blade.php ENDPATH**/ ?>