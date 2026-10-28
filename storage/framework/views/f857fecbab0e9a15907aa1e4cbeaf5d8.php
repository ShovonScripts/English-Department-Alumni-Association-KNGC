<?php if (isset($component)) { $__componentOriginalc8c9fd5d7827a77a31381de67195f0c3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc8c9fd5d7827a77a31381de67195f0c3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.admin','data' => ['title' => $alumniStory->title]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.admin'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($alumniStory->title)]); ?>
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="font-serif text-3xl font-semibold tracking-tight text-navy-950"><?php echo e($alumniStory->title); ?></h1>
            <p class="mt-1 text-sm text-ink-soft">Story details and preview.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="<?php echo e(route('admin.stories.edit', $alumniStory)); ?>" class="focus-ring inline-flex items-center gap-2 rounded-md px-3.5 py-2 text-sm font-semibold text-navy-800 transition-colors hover:bg-navy-50">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.4-9.4a2 2 0 112.8 2.8L11 15l-4 1 1-4 9.6-9.4z" />
                </svg>
                Edit
            </a>
            <a href="<?php echo e(route('admin.stories.index')); ?>" class="focus-ring inline-flex items-center gap-2 rounded-md px-3.5 py-2 text-sm font-semibold text-navy-800 transition-colors hover:bg-navy-50">
                &larr; Back to Stories
            </a>
        </div>
    </div>

    <div class="grid gap-8 lg:grid-cols-3">
        <div class="space-y-8 lg:col-span-2">
            <section class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm sm:p-8">
                <h2 class="font-serif text-xl font-semibold text-navy-950">Content</h2>
                <div class="mt-4 whitespace-pre-line text-sm leading-relaxed text-navy-950"><?php echo e($alumniStory->content); ?></div>
            </section>

            <section class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm sm:p-8">
                <h2 class="font-serif text-xl font-semibold text-navy-950">Details</h2>
                <div class="mt-4 grid gap-4 sm:grid-cols-2">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Alumni</p>
                        <p class="mt-1 text-sm text-navy-950"><?php echo e($alumniStory->alumni?->full_name ?? '—'); ?></p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Author</p>
                        <p class="mt-1 text-sm text-navy-950"><?php echo e($alumniStory->author_name ?? '—'); ?></p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Published</p>
                        <p class="mt-1 text-sm text-navy-950"><?php echo e($alumniStory->published_at?->format('M j, Y g:i A') ?? '—'); ?></p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Slug</p>
                        <p class="mt-1 text-sm text-navy-950"><?php echo e($alumniStory->slug); ?></p>
                    </div>
                </div>
            </section>
        </div>

        <aside class="space-y-8">
            <section class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm">
                <h2 class="font-serif text-lg font-semibold text-navy-950">Cover Image</h2>
                <div class="mt-4">
                    <?php if($alumniStory->cover_image): ?>
                        <img src="<?php echo e($alumniStory->cover_image_url); ?>" alt="<?php echo e($alumniStory->title); ?>" class="w-full rounded-lg object-cover ring-4 ring-gold-500/30">
                    <?php else: ?>
                        <div class="flex h-40 items-center justify-center rounded-lg border-2 border-dashed border-navy-200 bg-cream">
                            <span class="text-sm text-ink-soft">No image</span>
                        </div>
                    <?php endif; ?>
                </div>
            </section>

            <section class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm">
                <h2 class="font-serif text-lg font-semibold text-navy-950">Status</h2>
                <div class="mt-4 space-y-3">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Status</p>
                        <?php if($alumniStory->status === 'published'): ?>
                            <span class="mt-1 inline-flex items-center gap-1.5 rounded-full bg-navy-100 px-2.5 py-1 text-xs font-semibold text-navy-800">
                                <span class="h-1.5 w-1.5 rounded-full bg-navy-600" aria-hidden="true"></span>
                                Published
                            </span>
                        <?php else: ?>
                            <span class="mt-1 inline-flex items-center gap-1.5 rounded-full bg-maroon-100 px-2.5 py-1 text-xs font-semibold text-maroon-800">
                                <span class="h-1.5 w-1.5 rounded-full bg-maroon-600" aria-hidden="true"></span>
                                Draft
                            </span>
                        <?php endif; ?>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Featured</p>
                        <p class="mt-1 text-sm text-navy-950"><?php echo e($alumniStory->is_featured ? 'Yes' : 'No'); ?></p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Sort Order</p>
                        <p class="mt-1 text-sm text-navy-950"><?php echo e($alumniStory->sort_order); ?></p>
                    </div>
                </div>
            </section>

            <section class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm">
                <h2 class="font-serif text-lg font-semibold text-navy-950">Timestamps</h2>
                <div class="mt-4 space-y-3">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Created</p>
                        <p class="mt-1 text-sm text-navy-950"><?php echo e($alumniStory->created_at->format('M j, Y g:i A')); ?></p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Updated</p>
                        <p class="mt-1 text-sm text-navy-950"><?php echo e($alumniStory->updated_at->format('M j, Y g:i A')); ?></p>
                    </div>
                </div>
            </section>
        </aside>
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
<?php /**PATH C:\xampp\htdocs\ProDo\EDAA\resources\views/admin/stories/show.blade.php ENDPATH**/ ?>