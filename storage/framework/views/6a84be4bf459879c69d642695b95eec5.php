<?php if (isset($component)) { $__componentOriginal5863877a5171c196453bfa0bd807e410 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5863877a5171c196453bfa0bd807e410 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.app','data' => ['title' => 'Press Releases','description' => 'Official announcements and press releases from the English Department Alumni Association KNGC.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.app'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Press Releases','description' => 'Official announcements and press releases from the English Department Alumni Association KNGC.']); ?>
    <?php if (isset($component)) { $__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.page-header','data' => ['eyebrow' => 'Press Releases','title' => 'Official Announcements','description' => 'Stay informed with the latest official communications from EDAA-KNGC.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('page-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['eyebrow' => 'Press Releases','title' => 'Official Announcements','description' => 'Stay informed with the latest official communications from EDAA-KNGC.']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e)): ?>
<?php $attributes = $__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e; ?>
<?php unset($__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e)): ?>
<?php $component = $__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e; ?>
<?php unset($__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e); ?>
<?php endif; ?>

    <?php if($featuredRelease): ?>
        <section class="bg-white py-12 sm:py-16">
            <div class="container-page">
                <a href="<?php echo e(route('press-releases.show', $featuredRelease)); ?>" class="group">
                    <article class="grid gap-8 rounded-xl border border-navy-100 bg-cream p-8 shadow-sm transition-colors hover:border-gold-500/40 sm:p-10 lg:grid-cols-2">
                        <?php if($featuredRelease->cover_image): ?>
                            <div class="overflow-hidden rounded-lg">
                                <img src="<?php echo e($featuredRelease->cover_image_url); ?>" alt="<?php echo e($featuredRelease->title); ?>" class="h-64 w-full object-cover transition-transform duration-500 group-hover:scale-105 sm:h-80">
                            </div>
                        <?php else: ?>
                            <div class="flex items-center justify-center rounded-lg bg-gradient-to-br from-navy-900 to-navy-800 p-8">
                                <span class="font-serif text-4xl font-bold text-gold-300/40">EDAA</span>
                            </div>
                        <?php endif; ?>

                        <div class="flex flex-col justify-center">
                            <div class="flex items-center gap-3">
                                <span class="inline-flex rounded-full bg-maroon-700 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-white">Featured</span>
                                <?php if($featuredRelease->document_path): ?>
                                    <span class="inline-flex rounded-full bg-navy-100 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-navy-700">PDF</span>
                                <?php endif; ?>
                            </div>
                            <h2 class="mt-4 font-serif text-2xl font-bold text-navy-950 transition-colors group-hover:text-maroon-700 sm:text-3xl">
                                <?php echo e($featuredRelease->title); ?>

                            </h2>
                            <?php if($featuredRelease->excerpt): ?>
                                <p class="mt-3 text-ink-soft leading-relaxed line-clamp-3"><?php echo e($featuredRelease->excerpt); ?></p>
                            <?php endif; ?>
                            <p class="mt-4 text-sm text-ink-soft">
                                <?php echo e($featuredRelease->formatted_date); ?>

                            </p>
                        </div>
                    </article>
                </a>
            </div>
        </section>
    <?php endif; ?>

    <section class="bg-cream py-8 sm:py-10">
        <div class="container-page">
            <form method="GET" action="<?php echo e(route('press-releases.index')); ?>" class="flex flex-col gap-4 sm:flex-row sm:items-end">
                <div class="flex-1">
                    <label for="search" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Search</label>
                    <input
                        type="search"
                        id="search"
                        name="search"
                        value="<?php echo e($filters['search'] ?? ''); ?>"
                        placeholder="Search press releases…"
                        class="w-full rounded-md border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 placeholder-navy-400 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none"
                    >
                </div>
                <div class="flex gap-3">
                    <?php if (isset($component)) { $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.button','data' => ['type' => 'submit','variant' => 'navy']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'submit','variant' => 'navy']); ?>Search <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561)): ?>
<?php $attributes = $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561; ?>
<?php unset($__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald0f1fd2689e4bb7060122a5b91fe8561)): ?>
<?php $component = $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561; ?>
<?php unset($__componentOriginald0f1fd2689e4bb7060122a5b91fe8561); ?>
<?php endif; ?>
                    <?php if(! empty($filters['search'])): ?>
                        <a href="<?php echo e(route('press-releases.index')); ?>" class="focus-ring inline-flex items-center gap-2 rounded-md px-3.5 py-2 text-sm font-semibold text-navy-800 transition-colors hover:bg-navy-50">Clear</a>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </section>

    <section class="section-pad bg-white">
        <div class="container-page">
            <?php if($pressReleases->isNotEmpty()): ?>
                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    <?php $__currentLoopData = $pressReleases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $release): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a href="<?php echo e(route('press-releases.show', $release)); ?>" class="card-lift shine glow-top group flex h-full flex-col overflow-hidden rounded-xl border border-white/20 bg-white/80 shadow-sm backdrop-blur-sm">
                            <?php if($release->cover_image): ?>
                                <div class="overflow-hidden">
                                    <img src="<?php echo e($release->cover_image_url); ?>" alt="<?php echo e($release->title); ?>" class="aspect-[16/9] w-full object-cover transition-transform duration-500 group-hover:scale-105">
                                </div>
                            <?php else: ?>
                                <div class="flex aspect-[16/9] items-center justify-center bg-gradient-to-br from-navy-900 to-navy-800">
                                    <span class="font-serif text-2xl font-bold text-gold-300/30">EDAA</span>
                                </div>
                            <?php endif; ?>

                            <div class="flex flex-1 flex-col p-6">
                                <div class="flex items-center gap-2">
                                    <time class="text-xs font-medium text-ink-soft" datetime="<?php echo e($release->published_at?->toIso8601String()); ?>">
                                        <?php echo e($release->formatted_date); ?>

                                    </time>
                                    <?php if($release->document_path): ?>
                                        <span class="inline-flex rounded-full bg-maroon-50 px-2 py-0.5 text-[10px] font-semibold uppercase text-maroon-700">PDF</span>
                                    <?php endif; ?>
                                </div>

                                <h3 class="mt-3 font-serif text-lg font-bold text-navy-950 transition-colors group-hover:text-maroon-700">
                                    <?php echo e($release->title); ?>

                                </h3>

                                <?php if($release->excerpt): ?>
                                    <p class="mt-2 flex-1 text-sm leading-relaxed text-ink-soft line-clamp-3"><?php echo e($release->excerpt); ?></p>
                                <?php else: ?>
                                    <p class="mt-2 flex-1 text-sm leading-relaxed text-ink-soft line-clamp-3"><?php echo e(\Illuminate\Support\Str::limit(strip_tags($release->content ?? ''), 120)); ?></p>
                                <?php endif; ?>

                                <div class="mt-4 flex items-center text-sm font-semibold text-maroon-700 transition-colors group-hover:text-maroon-800">
                                    Read more
                                    <svg class="ml-1 h-4 w-4 transition-transform group-hover:translate-x-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg>
                                </div>
                            </div>
                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <div class="mt-12">
                    <?php echo e($pressReleases->links()); ?>

                </div>
            <?php else: ?>
                <?php if (isset($component)) { $__componentOriginal074a021b9d42f490272b5eefda63257c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal074a021b9d42f490272b5eefda63257c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.empty-state','data' => ['title' => 'No press releases found','description' => 'No official announcements have been published yet. Check back soon for updates.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('empty-state'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'No press releases found','description' => 'No official announcements have been published yet. Check back soon for updates.']); ?>
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
        </div>
    </section>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5863877a5171c196453bfa0bd807e410)): ?>
<?php $attributes = $__attributesOriginal5863877a5171c196453bfa0bd807e410; ?>
<?php unset($__attributesOriginal5863877a5171c196453bfa0bd807e410); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5863877a5171c196453bfa0bd807e410)): ?>
<?php $component = $__componentOriginal5863877a5171c196453bfa0bd807e410; ?>
<?php unset($__componentOriginal5863877a5171c196453bfa0bd807e410); ?>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\ProDo\EDAA\resources\views\pages\press-releases.blade.php ENDPATH**/ ?>