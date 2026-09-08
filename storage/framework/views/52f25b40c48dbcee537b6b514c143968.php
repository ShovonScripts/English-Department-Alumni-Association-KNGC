<?php if (isset($component)) { $__componentOriginalc8c9fd5d7827a77a31381de67195f0c3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc8c9fd5d7827a77a31381de67195f0c3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.admin','data' => ['title' => 'Add Batch']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.admin'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Add Batch']); ?>
    <div class="mb-8">
        <h1 class="font-serif text-3xl font-semibold tracking-tight text-navy-950">Add Batch</h1>
        <p class="mt-1 text-sm text-ink-soft">Create a new academic batch for the English Department, KNGC.</p>
    </div>

    <?php if($errors->any()): ?>
        <div class="mb-6 rounded-md border border-maroon-200 bg-maroon-50 px-4 py-3 text-sm font-medium text-maroon-800">
            <ul class="list-inside list-disc">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm sm:p-8">
        <form method="POST" action="<?php echo e(route('admin.batches.store')); ?>" class="space-y-6">
            <?php echo csrf_field(); ?>

            <div class="grid gap-6 sm:grid-cols-2">
                <div>
                    <label for="start_year" class="mb-1.5 block text-sm font-semibold text-navy-950">
                        Start Year <span class="text-maroon-600">*</span>
                    </label>
                    <input
                        type="number"
                        id="start_year"
                        name="start_year"
                        value="<?php echo e(old('start_year')); ?>"
                        min="1900"
                        max="2100"
                        required
                        class="focus-ring w-full rounded-md border border-navy-200 bg-white px-4 py-2.5 text-sm <?php echo e($errors->has('start_year') ? 'border-red-400 bg-red-50' : ''); ?>"
                        placeholder="e.g. 2002"
                    >
                </div>

                <div>
                    <label for="end_year" class="mb-1.5 block text-sm font-semibold text-navy-950">
                        End Year <span class="text-maroon-600">*</span>
                    </label>
                    <input
                        type="number"
                        id="end_year"
                        name="end_year"
                        value="<?php echo e(old('end_year')); ?>"
                        min="1900"
                        max="2100"
                        required
                        class="focus-ring w-full rounded-md border border-navy-200 bg-white px-4 py-2.5 text-sm <?php echo e($errors->has('end_year') ? 'border-red-400 bg-red-50' : ''); ?>"
                        placeholder="e.g. 2003"
                    >
                    <p class="mt-1 text-xs text-ink-soft">Label will be auto-generated (e.g. "2002-03").</p>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <input
                    type="checkbox"
                    id="is_active"
                    name="is_active"
                    value="1"
                    <?php echo e(old('is_active', '1') === '1' ? 'checked' : ''); ?>

                    class="focus-ring h-4 w-4 rounded border-navy-300 text-maroon-600"
                >
                <label for="is_active" class="text-sm font-semibold text-navy-950">Active</label>
            </div>

            <div class="flex items-center gap-3">
                <?php if (isset($component)) { $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.button','data' => ['type' => 'submit','variant' => 'gold']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'submit','variant' => 'gold']); ?>Create Batch <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561)): ?>
<?php $attributes = $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561; ?>
<?php unset($__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald0f1fd2689e4bb7060122a5b91fe8561)): ?>
<?php $component = $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561; ?>
<?php unset($__componentOriginald0f1fd2689e4bb7060122a5b91fe8561); ?>
<?php endif; ?>
                <a href="<?php echo e(route('admin.batches.index')); ?>" class="focus-ring inline-flex h-10 items-center justify-center rounded-md px-4 text-sm font-semibold text-navy-600 transition-colors hover:bg-navy-50 hover:text-navy-900">Cancel</a>
            </div>
        </form>
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
<?php /**PATH C:\xampp\htdocs\ProDo\EDAA\resources\views\admin\batches\create.blade.php ENDPATH**/ ?>