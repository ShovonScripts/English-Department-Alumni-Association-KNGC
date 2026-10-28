<?php if (isset($component)) { $__componentOriginalc8c9fd5d7827a77a31381de67195f0c3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc8c9fd5d7827a77a31381de67195f0c3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.admin','data' => ['title' => 'Testimonials']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.admin'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Testimonials']); ?>
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="font-serif text-3xl font-semibold tracking-tight text-navy-950">Testimonials</h1>
            <p class="mt-1 text-sm text-ink-soft">
                Manage quotes shown on the home page slider.
            </p>
        </div>
        <?php if (isset($component)) { $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.button','data' => ['href' => ''.e(route('admin.testimonials.create')).'','variant' => 'gold']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => ''.e(route('admin.testimonials.create')).'','variant' => 'gold']); ?>Add Testimonial <?php echo $__env->renderComponent(); ?>
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
            <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <?php echo e(session('status')); ?>

        </div>
    <?php endif; ?>

    <?php if($testimonials->isEmpty()): ?>
        <div class="rounded-lg border-2 border-dashed border-navy-200 bg-white px-6 py-12 text-center">
            <svg class="mx-auto h-12 w-12 text-navy-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
            </svg>
            <p class="mt-3 text-sm font-medium text-navy-600">No testimonials yet</p>
            <p class="mt-1 text-xs text-ink-soft">Add your first testimonial to display on the home page.</p>
            <div class="mt-4">
                <?php if (isset($component)) { $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.button','data' => ['href' => ''.e(route('admin.testimonials.create')).'','variant' => 'gold']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => ''.e(route('admin.testimonials.create')).'','variant' => 'gold']); ?>Add Testimonial <?php echo $__env->renderComponent(); ?>
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
        </div>
    <?php else: ?>
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            <?php $__currentLoopData = $testimonials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $testimonial): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="rounded-lg border border-navy-100 bg-white p-5 shadow-sm transition-colors hover:border-gold-500/40">
                <div class="flex items-start gap-4">
                    
                    <div class="shrink-0">
                        <?php if($testimonial->image_url): ?>
                            <img src="<?php echo e($testimonial->image_url); ?>" alt="<?php echo e($testimonial->author_name); ?>" class="h-14 w-14 rounded-full object-cover ring-2 ring-gold-500/40">
                        <?php else: ?>
                            <span class="flex h-14 w-14 shrink-0 items-center justify-center rounded-full bg-maroon-700 font-serif text-base font-semibold text-white">
                                <?php echo e(\Illuminate\Support\Str::initials($testimonial->author_name)); ?>

                            </span>
                        <?php endif; ?>
                    </div>

                    
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2">
                            <span class="inline-flex rounded-full px-2 py-0.5 text-xs font-medium <?php echo e($testimonial->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-navy-100 text-navy-500'); ?>">
                                <?php echo e($testimonial->is_active ? 'Active' : 'Inactive'); ?>

                            </span>
                            <span class="text-xs text-ink-soft">Order: <?php echo e($testimonial->sort_order); ?></span>
                        </div>
                        <p class="mt-2 font-semibold text-navy-950"><?php echo e($testimonial->author_name); ?></p>
                        <?php if($testimonial->author_title): ?>
                            <p class="text-xs text-ink-soft"><?php echo e($testimonial->author_title); ?></p>
                        <?php endif; ?>
                        <?php if($testimonial->author_batch): ?>
                            <p class="text-xs text-ink-soft"><?php echo e($testimonial->author_batch); ?></p>
                        <?php endif; ?>
                    </div>
                </div>

                
                <p class="mt-4 font-serif text-sm italic leading-relaxed text-navy-700 line-clamp-3">"<?php echo e($testimonial->quote); ?>"</p>

                
                <div class="mt-4 flex items-center gap-2 border-t border-navy-100 pt-4">
                    <a href="<?php echo e(route('admin.testimonials.edit', $testimonial)); ?>" class="inline-flex items-center gap-1 rounded-md bg-navy-50 px-3 py-1.5 text-xs font-medium text-navy-700 transition-colors hover:bg-navy-100">
                        Edit
                    </a>
                    <form method="POST" action="<?php echo e(route('admin.testimonials.destroy', $testimonial)); ?>" onsubmit="return confirm('Delete this testimonial?')">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="inline-flex items-center gap-1 rounded-md bg-maroon-50 px-3 py-1.5 text-xs font-medium text-maroon-700 transition-colors hover:bg-maroon-100">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
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
<?php /**PATH C:\xampp\htdocs\ProDo\EDAA\resources\views/admin/testimonials/index.blade.php ENDPATH**/ ?>