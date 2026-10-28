<?php if (isset($component)) { $__componentOriginalc8c9fd5d7827a77a31381de67195f0c3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc8c9fd5d7827a77a31381de67195f0c3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.admin','data' => ['title' => $alumni->full_name]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.admin'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($alumni->full_name)]); ?>
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="font-serif text-3xl font-semibold tracking-tight text-navy-950"><?php echo e($alumni->full_name); ?></h1>
            <p class="mt-1 text-sm text-ink-soft">
                <?php echo e(collect([$alumni->designation, $alumni->organization])->filter()->implode(' · ')); ?>

            </p>
        </div>
        <div class="flex flex-wrap items-center gap-3">
            <?php if (isset($component)) { $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.button','data' => ['href' => ''.e(route('admin.alumni.edit', $alumni)).'','variant' => 'navy']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => ''.e(route('admin.alumni.edit', $alumni)).'','variant' => 'navy']); ?>Edit Record <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561)): ?>
<?php $attributes = $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561; ?>
<?php unset($__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald0f1fd2689e4bb7060122a5b91fe8561)): ?>
<?php $component = $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561; ?>
<?php unset($__componentOriginald0f1fd2689e4bb7060122a5b91fe8561); ?>
<?php endif; ?>
            <form method="POST" action="<?php echo e(route('admin.alumni.destroy', $alumni)); ?>" onsubmit="return confirm('Delete <?php echo e(addslashes($alumni->full_name)); ?>? This cannot be undone.');">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
                <?php if (isset($component)) { $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.button','data' => ['type' => 'submit','variant' => 'outline']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'submit','variant' => 'outline']); ?>Delete <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561)): ?>
<?php $attributes = $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561; ?>
<?php unset($__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald0f1fd2689e4bb7060122a5b91fe8561)): ?>
<?php $component = $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561; ?>
<?php unset($__componentOriginald0f1fd2689e4bb7060122a5b91fe8561); ?>
<?php endif; ?>
            </form>
        </div>
    </div>

    <?php if(session('status')): ?>
        <div class="mb-6 flex items-center gap-3 rounded-md border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800" role="status">
            <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <?php echo e(session('status')); ?>

        </div>
    <?php endif; ?>

    <div class="grid gap-6 lg:grid-cols-3">
        
        <div class="lg:col-span-1">
            <div class="rounded-lg border border-navy-100 bg-white p-8 text-center shadow-sm">
                <?php if($alumni->profile_photo_url): ?>
                    <img src="<?php echo e($alumni->profile_photo_url); ?>" alt="" class="mx-auto h-32 w-32 rounded-full object-cover ring-4 ring-gold-500/30">
                <?php else: ?>
                    <span class="mx-auto flex h-32 w-32 items-center justify-center rounded-full bg-navy-900 font-serif text-3xl font-semibold text-gold-300 ring-4 ring-gold-500/30" aria-hidden="true">
                        <?php echo e(\Illuminate\Support\Str::initials($alumni->full_name)); ?>

                    </span>
                <?php endif; ?>

                <div class="mt-5 flex flex-wrap items-center justify-center gap-2">
                    <?php if($alumni->status === 'active'): ?>
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-navy-100 px-2.5 py-1 text-xs font-semibold text-navy-800">
                            <span class="h-1.5 w-1.5 rounded-full bg-navy-600" aria-hidden="true"></span>
                            Active
                        </span>
                    <?php else: ?>
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-maroon-100 px-2.5 py-1 text-xs font-semibold text-maroon-800">
                            <span class="h-1.5 w-1.5 rounded-full bg-maroon-600" aria-hidden="true"></span>
                            Inactive
                        </span>
                    <?php endif; ?>

                    <?php if($alumni->is_featured): ?>
                        <span class="inline-flex rounded-full bg-gold-500/20 px-2.5 py-1 text-xs font-semibold text-gold-700">Featured</span>
                    <?php endif; ?>
                </div>

                <?php if($alumni->status === 'active'): ?>
                    <div class="mt-6">
                        <?php if (isset($component)) { $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.button','data' => ['href' => ''.e(route('alumni.show', $alumni)).'','variant' => 'outline','icon' => true,'target' => '_blank','rel' => 'noopener noreferrer']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => ''.e(route('alumni.show', $alumni)).'','variant' => 'outline','icon' => true,'target' => '_blank','rel' => 'noopener noreferrer']); ?>View Public Profile <?php echo $__env->renderComponent(); ?>
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
                <?php endif; ?>
            </div>
        </div>

        
        <div class="grid gap-6 lg:col-span-2">
            <div class="rounded-lg border border-navy-100 bg-white p-8 shadow-sm">
                <h2 class="font-serif text-xl font-semibold text-navy-950">Record details</h2>
                <dl class="mt-6 grid gap-x-8 gap-y-6 sm:grid-cols-2">
                    <?php $__currentLoopData = [
                        'Student ID' => $alumni->student_id,
                        'Batch' => $alumni->batch,
                        'Session' => $alumni->session,
                        'Graduation Year' => $alumni->graduation_year,
                        'Degree' => $alumni->degree,
                        'Profession' => $alumni->profession,
                        'Designation' => $alumni->designation,
                        'Organization' => $alumni->organization,
                        'City' => $alumni->city,
                        'Country' => $alumni->country,
                        'Email' => $alumni->email,
                        'Phone' => $alumni->phone,
                        'LinkedIn' => $alumni->linkedin_url,
                        'Website' => $alumni->website_url,
                        'Sort Order' => $alumni->sort_order,
                        'Created' => $alumni->created_at?->format('M j, Y g:i A'),
                        'Updated' => $alumni->updated_at?->format('M j, Y g:i A'),
                    ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $label => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($value): ?>
                            <div>
                                <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft"><?php echo e($label); ?></dt>
                                <?php if(in_array($label, ['LinkedIn', 'Website'])): ?>
                                    <dd class="mt-1 text-sm text-navy-950">
                                        <a href="<?php echo e(\App\Support\UrlHelper::safeHref($value)); ?>" target="_blank" rel="noopener noreferrer" class="focus-ring rounded text-maroon-700 hover:text-maroon-600"><?php echo e($value); ?></a>
                                    </dd>
                                <?php else: ?>
                                    <dd class="mt-1 break-words text-sm text-navy-950"><?php echo e($value); ?></dd>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </dl>
            </div>

            <?php if($alumni->bio): ?>
                <div class="rounded-lg border border-navy-100 bg-white p-8 shadow-sm">
                    <h2 class="font-serif text-xl font-semibold text-navy-950">Biography</h2>
                    <p class="mt-4 text-sm leading-relaxed text-ink-soft"><?php echo e($alumni->bio); ?></p>
                </div>
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
<?php endif; ?><?php /**PATH C:\xampp\htdocs\ProDo\EDAA\resources\views/admin/alumni/show.blade.php ENDPATH**/ ?>