<?php if (isset($component)) { $__componentOriginalc8c9fd5d7827a77a31381de67195f0c3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc8c9fd5d7827a77a31381de67195f0c3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.admin','data' => ['title' => 'Edit Testimonial']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.admin'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Edit Testimonial']); ?>
    <div class="mb-8">
        <h1 class="font-serif text-3xl font-semibold tracking-tight text-navy-950">Edit Testimonial</h1>
        <p class="mt-1 text-sm text-ink-soft">Update this testimonial.</p>
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
        <form method="POST" action="<?php echo e(route('admin.testimonials.update', $testimonial)); ?>" enctype="multipart/form-data" class="space-y-6">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <div>
                <label for="quote" class="mb-1.5 block text-sm font-semibold text-navy-950">
                    Quote <span class="text-maroon-600">*</span>
                </label>
                <textarea
                    id="quote"
                    name="quote"
                    rows="4"
                    required
                    maxlength="1000"
                    placeholder="Enter the testimonial quote..."
                    class="focus-ring w-full rounded-md border border-navy-200 bg-white px-4 py-2.5 text-sm text-navy-950 placeholder-navy-400 resize-none"
                ><?php echo e(old('quote', $testimonial->quote)); ?></textarea>
            </div>

            <div class="grid gap-6 sm:grid-cols-2">
                <div>
                    <label for="author_name" class="mb-1.5 block text-sm font-semibold text-navy-950">
                        Author Name <span class="text-maroon-600">*</span>
                    </label>
                    <input
                        type="text"
                        id="author_name"
                        name="author_name"
                        value="<?php echo e(old('author_name', $testimonial->author_name)); ?>"
                        required
                        placeholder="e.g. Professor Milki Amatul Mogni"
                        class="focus-ring w-full rounded-md border border-navy-200 bg-white px-4 py-2.5 text-sm text-navy-950 placeholder-navy-400"
                    >
                </div>
                <div>
                    <label for="author_title" class="mb-1.5 block text-sm font-semibold text-navy-950">Author Title</label>
                    <input
                        type="text"
                        id="author_title"
                        name="author_title"
                        value="<?php echo e(old('author_title', $testimonial->author_title)); ?>"
                        placeholder="e.g. Past President, EDAA"
                        class="focus-ring w-full rounded-md border border-navy-200 bg-white px-4 py-2.5 text-sm text-navy-950 placeholder-navy-400"
                    >
                </div>
            </div>

            <div class="grid gap-6 sm:grid-cols-2">
                <div>
                    <label for="author_batch" class="mb-1.5 block text-sm font-semibold text-navy-950">Author Batch</label>
                    <input
                        type="text"
                        id="author_batch"
                        name="author_batch"
                        value="<?php echo e(old('author_batch', $testimonial->author_batch)); ?>"
                        placeholder="e.g. Class of 1987"
                        class="focus-ring w-full rounded-md border border-navy-200 bg-white px-4 py-2.5 text-sm text-navy-950 placeholder-navy-400"
                    >
                </div>
                <div>
                    <label for="sort_order" class="mb-1.5 block text-sm font-semibold text-navy-950">Sort Order</label>
                    <input
                        type="number"
                        id="sort_order"
                        name="sort_order"
                        value="<?php echo e(old('sort_order', $testimonial->sort_order)); ?>"
                        min="0"
                        class="focus-ring w-full rounded-md border border-navy-200 bg-white px-4 py-2.5 text-sm text-navy-950"
                    >
                </div>
            </div>

            <div>
                <label for="image" class="mb-1.5 block text-sm font-semibold text-navy-950">Speaker Image</label>
                <?php if($testimonial->image_url): ?>
                    <div class="mb-3">
                        <img src="<?php echo e($testimonial->image_url); ?>" alt="<?php echo e($testimonial->author_name); ?>" class="h-20 w-20 rounded-full object-cover ring-2 ring-gold-500/40">
                    </div>
                <?php endif; ?>
                <input
                    type="file"
                    id="image"
                    name="image"
                    accept="image/jpeg,image/png,image/webp"
                    class="focus-ring w-full rounded-md border border-navy-200 bg-white px-4 py-2.5 text-sm text-navy-950 file:mr-4 file:rounded file:border-0 file:bg-navy-900 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white hover:file:bg-navy-800"
                >
                <p class="mt-1 text-xs text-ink-soft">JPEG, PNG or WebP. Max 8MB. Leave empty to keep current image.</p>
            </div>

            <div class="flex items-center gap-3">
                <input
                    type="checkbox"
                    id="is_active"
                    name="is_active"
                    value="1"
                    <?php echo e(old('is_active', $testimonial->is_active ? '1' : '0') === '1' ? 'checked' : ''); ?>

                    class="focus-ring h-4 w-4 rounded border-navy-300 text-maroon-600"
                >
                <label for="is_active" class="text-sm font-semibold text-navy-950">Active (shown on home page)</label>
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
<?php $component->withAttributes(['type' => 'submit','variant' => 'gold']); ?>Update Testimonial <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561)): ?>
<?php $attributes = $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561; ?>
<?php unset($__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald0f1fd2689e4bb7060122a5b91fe8561)): ?>
<?php $component = $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561; ?>
<?php unset($__componentOriginald0f1fd2689e4bb7060122a5b91fe8561); ?>
<?php endif; ?>
                <a href="<?php echo e(route('admin.testimonials.index')); ?>" class="focus-ring inline-flex h-10 items-center justify-center rounded-md px-4 text-sm font-semibold text-navy-600 transition-colors hover:bg-navy-50 hover:text-navy-900">Cancel</a>
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
<?php /**PATH C:\xampp\htdocs\ProDo\EDAA\resources\views\admin\testimonials\edit.blade.php ENDPATH**/ ?>