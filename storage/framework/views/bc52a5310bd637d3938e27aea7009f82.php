<?php if (isset($component)) { $__componentOriginalc8c9fd5d7827a77a31381de67195f0c3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc8c9fd5d7827a77a31381de67195f0c3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.admin','data' => ['title' => 'Committees']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.admin'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Committees']); ?>
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="font-serif text-3xl font-semibold tracking-tight text-navy-950">Committees</h1>
            <p class="mt-1 text-sm text-ink-soft">Manage all committees across every type and year.</p>
        </div>
        <?php if (isset($component)) { $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.button','data' => ['href' => ''.e(route('admin.committees.create')).'','variant' => 'gold']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => ''.e(route('admin.committees.create')).'','variant' => 'gold']); ?>Add Committee <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561)): ?>
<?php $attributes = $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561; ?>
<?php unset($__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald0f1fd2689e4bb7060122a5b91fe8561)): ?>
<?php $component = $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561; ?>
<?php unset($__componentOriginald0f1fd2689e4bb7060122a5b91fe8561); ?>
<?php endif; ?>
    </div>

    <?php if(session('status')): ?>
        <div class="mb-6 flex items-center gap-3 rounded-md border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800" role="status">
            <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            <?php echo e(session('status')); ?>

        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="mb-6 flex items-center gap-3 rounded-md border border-maroon-200 bg-maroon-50 px-4 py-3 text-sm text-maroon-800" role="alert">
            <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v4m0 4h.01M10.3 3.9L1.8 18a2 2 0 001.7 3h17a2 2 0 001.7-3L13.7 3.9a2 2 0 00-3.4 0z" /></svg>
            <?php echo e(session('error')); ?>

        </div>
    <?php endif; ?>

    
    <form method="GET" action="<?php echo e(route('admin.committees.index')); ?>" class="mb-6 rounded-lg border border-navy-100 bg-white p-6 shadow-sm">
        <div class="grid gap-4 sm:grid-cols-3">
            <div class="sm:col-span-2">
                <label for="search" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Search</label>
                <input type="search" id="search" name="search" value="<?php echo e($filters['search']); ?>" placeholder="Committee name..." class="w-full rounded-md border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 placeholder-navy-400 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none">
            </div>
            <div>
                <label for="committee_type_id" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Type</label>
                <select id="committee_type_id" name="committee_type_id" class="w-full rounded-md border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none">
                    <option value="">All</option>
                    <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($type->id); ?>" <?php if($filters['committee_type_id'] == $type->id): echo 'selected'; endif; ?>><?php echo e($type->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
        </div>
        <div class="mt-4 flex items-center gap-3">
            <button type="submit" class="focus-ring inline-flex items-center gap-2 rounded-md bg-navy-900 px-4 py-2 text-sm font-semibold text-white transition-colors hover:bg-navy-800">Filter</button>
            <a href="<?php echo e(route('admin.committees.index')); ?>" class="text-sm font-medium text-maroon-700 hover:text-maroon-900">Clear</a>
        </div>
    </form>

    
    <div class="overflow-hidden rounded-lg border border-navy-100 bg-white shadow-sm">
        <table class="min-w-full divide-y divide-navy-100">
            <thead class="bg-navy-50/50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-ink-soft">Committee</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-ink-soft">Type</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-ink-soft">Years</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-ink-soft">Members</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-ink-soft">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-navy-100">
                <?php $__empty_1 = true; $__currentLoopData = $committees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $committee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-cream/50 transition-colors">
                        <td class="px-6 py-4">
                            <a href="<?php echo e(route('admin.committees.show', $committee)); ?>" class="font-semibold text-navy-950 hover:text-maroon-700 transition-colors"><?php echo e($committee->name); ?></a>
                        </td>
                        <td class="px-6 py-4 text-sm text-ink-soft"><?php echo e($committee->type?->name ?? '---'); ?></td>
                        <td class="px-6 py-4 text-sm text-ink-soft"><?php echo e($committee->yearRange()); ?></td>
                        <td class="px-6 py-4 text-sm text-ink-soft"><?php echo e($committee->members()->count()); ?></td>
                        <td class="px-6 py-4">
                            <?php if($committee->is_current): ?>
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-gold-500/15 px-2.5 py-1 text-[10px] font-semibold uppercase tracking-widest text-gold-700">Current</span>
                            <?php else: ?>
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-navy-100 px-2.5 py-1 text-[10px] font-semibold uppercase tracking-widest text-navy-500">Past</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-sm text-ink-soft">No committees found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <div class="border-t border-navy-100 px-6 py-4">
            <?php echo e($committees->links()); ?>

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
<?php /**PATH C:\xampp\htdocs\ProDo\EDAA\resources\views/admin/committees/index.blade.php ENDPATH**/ ?>