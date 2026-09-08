<?php if (isset($component)) { $__componentOriginalc8c9fd5d7827a77a31381de67195f0c3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc8c9fd5d7827a77a31381de67195f0c3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.admin','data' => ['title' => $pressRelease->title]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.admin'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($pressRelease->title)]); ?>
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="font-serif text-3xl font-semibold tracking-tight text-navy-950"><?php echo e($pressRelease->title); ?></h1>
            <p class="mt-1 text-sm text-ink-soft">Press release details and preview.</p>
        </div>
        <div class="flex items-center gap-3">
            <?php if($pressRelease->isPublished()): ?>
                <a href="<?php echo e(route('press-releases.show', $pressRelease)); ?>" target="_blank" class="focus-ring inline-flex items-center gap-2 rounded-md px-3.5 py-2 text-sm font-semibold text-navy-800 transition-colors hover:bg-navy-50">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" /></svg>
                    View Public
                </a>
            <?php endif; ?>
            <a href="<?php echo e(route('admin.press-releases.edit', $pressRelease)); ?>" class="focus-ring inline-flex items-center gap-2 rounded-md px-3.5 py-2 text-sm font-semibold text-navy-800 transition-colors hover:bg-navy-50">Edit</a>
        </div>
    </div>

    <?php if(session('status')): ?>
        <div class="mb-6 flex items-center gap-3 rounded-md border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800" role="status">
            <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            <?php echo e(session('status')); ?>

        </div>
    <?php endif; ?>

    <div class="grid gap-8 lg:grid-cols-3">
        <div class="lg:col-span-2 space-y-6">
            <?php if($pressRelease->excerpt): ?>
                <div class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm">
                    <h2 class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Excerpt</h2>
                    <p class="mt-2 text-sm leading-relaxed text-navy-950"><?php echo e($pressRelease->excerpt); ?></p>
                </div>
            <?php endif; ?>

            <?php if($pressRelease->content): ?>
                <div class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm">
                    <h2 class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Content</h2>
                    <div class="mt-2 whitespace-pre-line text-sm leading-relaxed text-navy-950"><?php echo e($pressRelease->content); ?></div>
                </div>
            <?php endif; ?>

            <?php if(! $pressRelease->excerpt && ! $pressRelease->content): ?>
                <div class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm">
                    <p class="text-sm text-ink-soft">No text content.</p>
                </div>
            <?php endif; ?>

            <?php if($pressRelease->external_url): ?>
                <div class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm">
                    <h2 class="text-xs font-semibold uppercase tracking-wider text-ink-soft">External URL</h2>
                    <a href="<?php echo e($pressRelease->external_url); ?>" target="_blank" rel="noopener noreferrer" class="mt-2 inline-flex items-center gap-1 text-sm text-maroon-700 hover:text-maroon-800">
                        <?php echo e($pressRelease->external_url); ?>

                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" /></svg>
                    </a>
                </div>
            <?php endif; ?>
        </div>

        <div class="space-y-6">
            <div class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm">
                <h2 class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Details</h2>
                <dl class="mt-4 space-y-3 text-sm">
                    <div class="flex justify-between">
                        <dt class="text-ink-soft">Status</dt>
                        <dd>
                            <?php if($pressRelease->status === 'published'): ?>
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-navy-100 px-2.5 py-1 text-xs font-semibold text-navy-800">
                                    <span class="h-1.5 w-1.5 rounded-full bg-navy-600"></span>
                                    Published
                                </span>
                            <?php else: ?>
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-maroon-100 px-2.5 py-1 text-xs font-semibold text-maroon-800">
                                    <span class="h-1.5 w-1.5 rounded-full bg-maroon-600"></span>
                                    Draft
                                </span>
                            <?php endif; ?>
                        </dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-ink-soft">Featured</dt>
                        <dd class="font-medium text-navy-950"><?php echo e($pressRelease->is_featured ? 'Yes' : 'No'); ?></dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-ink-soft">Published</dt>
                        <dd class="font-medium text-navy-950"><?php echo e($pressRelease->published_at?->format('M j, Y g:i A') ?? '—'); ?></dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-ink-soft">Sort Order</dt>
                        <dd class="font-medium text-navy-950"><?php echo e($pressRelease->sort_order); ?></dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-ink-soft">Slug</dt>
                        <dd class="font-mono text-xs text-navy-950"><?php echo e($pressRelease->slug); ?></dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-ink-soft">Created</dt>
                        <dd class="text-navy-950"><?php echo e($pressRelease->created_at?->format('M j, Y g:i A')); ?></dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-ink-soft">Updated</dt>
                        <dd class="text-navy-950"><?php echo e($pressRelease->updated_at?->format('M j, Y g:i A')); ?></dd>
                    </div>
                </dl>
            </div>

            <?php if($pressRelease->cover_image): ?>
                <div class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm">
                    <h2 class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Cover Image</h2>
                    <img src="<?php echo e($pressRelease->cover_image_url); ?>" alt="<?php echo e($pressRelease->title); ?>" class="mt-3 w-full rounded-lg object-cover">
                </div>
            <?php endif; ?>

            <?php if($pressRelease->document_path): ?>
                <div class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm">
                    <h2 class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Document</h2>
                    <div class="mt-3 flex items-center gap-3 rounded-md border border-navy-200 bg-cream px-4 py-3">
                        <svg class="h-8 w-8 shrink-0 text-maroon-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                        </svg>
                        <div>
                            <p class="text-sm font-medium text-navy-950"><?php echo e($pressRelease->document_original_name); ?></p>
                            <p class="text-xs text-ink-soft">PDF · <?php echo e(\Illuminate\Support\Number::format($pressRelease->document_size ?? 0)); ?>B</p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <div class="flex gap-3">
                <form method="POST" action="<?php echo e(route('admin.press-releases.destroy', $pressRelease)); ?>" onsubmit="return confirm('Delete this press release? This cannot be undone.');">
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
<?php /**PATH C:\xampp\htdocs\ProDo\EDAA\resources\views\admin\press-releases\show.blade.php ENDPATH**/ ?>