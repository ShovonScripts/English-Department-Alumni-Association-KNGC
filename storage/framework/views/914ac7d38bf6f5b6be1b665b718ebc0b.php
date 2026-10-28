<?php if (isset($component)) { $__componentOriginal5863877a5171c196453bfa0bd807e410 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5863877a5171c196453bfa0bd807e410 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.app','data' => ['title' => 'Publications','description' => 'Browse our collection of reports, magazines, research papers, and other publications from the English Department Alumni Association KNGC.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.app'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Publications','description' => 'Browse our collection of reports, magazines, research papers, and other publications from the English Department Alumni Association KNGC.']); ?>
    <?php if (isset($component)) { $__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.page-header','data' => ['eyebrow' => 'Resources','title' => 'Publications','description' => 'Browse our collection of reports, magazines, research papers, and other publications.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('page-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['eyebrow' => 'Resources','title' => 'Publications','description' => 'Browse our collection of reports, magazines, research papers, and other publications.']); ?>
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

    <section class="bg-cream py-8 sm:py-10">
        <div class="container-page">
            <form method="GET" action="<?php echo e(route('publications.index')); ?>" class="flex flex-col gap-4 sm:flex-row sm:items-end">
                <div class="flex-1">
                    <label for="search" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Search</label>
                    <input type="search" id="search" name="search" value="<?php echo e($filters['search'] ?? ''); ?>" placeholder="Search publications..."
                        class="w-full rounded-md border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 placeholder-navy-400 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none">
                </div>
                <div class="sm:w-48">
                    <label for="author" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Author</label>
                    <input type="text" id="author" name="author" value="<?php echo e($filters['author'] ?? ''); ?>" placeholder="Filter by author..."
                        class="w-full rounded-md border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 placeholder-navy-400 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none">
                </div>
                <div class="sm:w-48">
                    <label for="publisher" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Publisher</label>
                    <input type="text" id="publisher" name="publisher" value="<?php echo e($filters['publisher'] ?? ''); ?>" placeholder="Filter by publisher..."
                        class="w-full rounded-md border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 placeholder-navy-400 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none">
                </div>
                <div class="sm:w-48">
                    <label for="category" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Category</label>
                    <select id="category" name="category" class="w-full rounded-md border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none">
                        <option value="">All Categories</option>
                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($cat->slug); ?>" <?php if(($filters['category'] ?? '') === $cat->slug): echo 'selected'; endif; ?>><?php echo e($cat->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="sm:w-48">
                    <label for="year" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Year</label>
                    <select id="year" name="year" class="w-full rounded-md border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none">
                        <option value="">All Years</option>
                        <?php $__currentLoopData = $years; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $y): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($y); ?>" <?php if(($filters['year'] ?? '') == $y): echo 'selected'; endif; ?>><?php echo e($y); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="flex gap-3">
                    <button type="submit" class="focus-ring inline-flex items-center gap-2 rounded-md bg-navy-900 px-5 py-2.5 text-sm font-semibold text-white transition-colors hover:bg-navy-800">Search</button>
                    <?php if(!empty($filters['search']) || !empty($filters['category']) || !empty($filters['author']) || !empty($filters['publisher']) || !empty($filters['year'])): ?>
                        <a href="<?php echo e(route('publications.index')); ?>" class="focus-ring inline-flex items-center gap-2 rounded-md px-3.5 py-2 text-sm font-semibold text-navy-800 transition-colors hover:bg-navy-50">Clear</a>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </section>

    <?php if($featuredPublications && $featuredPublications->isNotEmpty()): ?>
        <section class="bg-white py-12 sm:py-16">
            <div class="container-page">
                <?php if (isset($component)) { $__componentOriginal755230460fd16c04121658d92fbf99f7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal755230460fd16c04121658d92fbf99f7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.section-heading','data' => ['eyebrow' => 'Featured','title' => 'Featured Publications','description' => 'Highlighted selections from our publication collection.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('section-heading'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['eyebrow' => 'Featured','title' => 'Featured Publications','description' => 'Highlighted selections from our publication collection.']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal755230460fd16c04121658d92fbf99f7)): ?>
<?php $attributes = $__attributesOriginal755230460fd16c04121658d92fbf99f7; ?>
<?php unset($__attributesOriginal755230460fd16c04121658d92fbf99f7); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal755230460fd16c04121658d92fbf99f7)): ?>
<?php $component = $__componentOriginal755230460fd16c04121658d92fbf99f7; ?>
<?php unset($__componentOriginal755230460fd16c04121658d92fbf99f7); ?>
<?php endif; ?>

                <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    <?php $__currentLoopData = $featuredPublications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pub): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if (isset($component)) { $__componentOriginal4b48c940f0ffe0bae9e547acb74f1315 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4b48c940f0ffe0bae9e547acb74f1315 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.publication-card','data' => ['title' => $pub->title,'type' => $pub->document_original_name ? pathinfo($pub->document_original_name, PATHINFO_EXTENSION) : null,'author' => $pub->author,'year' => $pub->publication_date?->format('Y'),'description' => $pub->description,'href' => route('publications.show', $pub)]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('publication-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($pub->title),'type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($pub->document_original_name ? pathinfo($pub->document_original_name, PATHINFO_EXTENSION) : null),'author' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($pub->author),'year' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($pub->publication_date?->format('Y')),'description' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($pub->description),'href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('publications.show', $pub))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal4b48c940f0ffe0bae9e547acb74f1315)): ?>
<?php $attributes = $__attributesOriginal4b48c940f0ffe0bae9e547acb74f1315; ?>
<?php unset($__attributesOriginal4b48c940f0ffe0bae9e547acb74f1315); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal4b48c940f0ffe0bae9e547acb74f1315)): ?>
<?php $component = $__componentOriginal4b48c940f0ffe0bae9e547acb74f1315; ?>
<?php unset($__componentOriginal4b48c940f0ffe0bae9e547acb74f1315); ?>
<?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <section class="section-pad bg-white">
        <div class="container-page">
            <?php if($publications->isNotEmpty()): ?>
                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    <?php $__currentLoopData = $publications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pub): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <article class="card-lift group flex h-full flex-col overflow-hidden rounded-lg border border-navy-100 bg-white shadow-sm">
                            <?php if($pub->cover_image_url): ?>
                                <div class="relative aspect-[16/9] overflow-hidden bg-navy-100">
                                    <img src="<?php echo e($pub->cover_image_url); ?>" alt="<?php echo e($pub->title); ?>" class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                                    <?php if($pub->category): ?>
                                        <span class="absolute left-4 top-4 rounded-full bg-navy-900/90 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-gold-300">
                                            <?php echo e($pub->category->name); ?>

                                        </span>
                                    <?php endif; ?>
                                </div>
                            <?php else: ?>
                                <div class="relative flex aspect-[16/9] items-center justify-center bg-gradient-to-br from-navy-800 via-navy-900 to-maroon-900">
                                    <svg class="h-10 w-10 text-gold-400/70" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.4" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.3v11.4m0-11.4A3.2 3.2 0 009.5 3.5H6.5v13h3a3.2 3.2 0 013 2.8m-.5-12.9a3.2 3.2 0 012.5-2.8h3v13h-3a3.2 3.2 0 00-3 2.8m0-12.9v11.4" />
                                    </svg>
                                    <?php if($pub->category): ?>
                                        <span class="absolute left-4 top-4 rounded-full bg-navy-900/90 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-gold-300">
                                            <?php echo e($pub->category->name); ?>

                                        </span>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>

                            <div class="flex flex-1 flex-col p-6">
                                <?php if($pub->publication_date): ?>
                                    <p class="text-xs font-medium uppercase tracking-wider text-ink-soft">
                                        <?php echo e($pub->publication_date->format('F j, Y')); ?>

                                    </p>
                                <?php endif; ?>

                                <h3 class="mt-2 font-serif text-xl font-semibold leading-snug text-navy-950">
                                    <a href="<?php echo e(route('publications.show', $pub)); ?>" class="focus-ring rounded transition-colors group-hover:text-maroon-700"><?php echo e($pub->title); ?></a>
                                </h3>

                                <?php if($pub->author || $pub->publisher): ?>
                                    <p class="mt-2 text-sm text-ink-soft">
                                        <?php echo e(collect([$pub->author, $pub->publisher])->filter()->implode(' · ')); ?>

                                    </p>
                                <?php endif; ?>

                                <?php if($pub->description): ?>
                                    <p class="mt-3 line-clamp-3 flex-1 text-sm leading-relaxed text-ink-soft">
                                        <?php echo e($pub->description); ?>

                                    </p>
                                <?php endif; ?>

                                <div class="mt-4 flex items-center justify-between">
                                    <?php if($pub->document_original_name): ?>
                                        <span class="inline-flex rounded-full bg-maroon-50 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-maroon-700">
                                            <?php echo e(strtoupper(pathinfo($pub->document_original_name, PATHINFO_EXTENSION))); ?>

                                        </span>
                                    <?php endif; ?>
                                    <a href="<?php echo e(route('publications.show', $pub)); ?>" class="focus-ring inline-flex items-center gap-1.5 text-sm font-semibold text-maroon-700 transition-colors group-hover:text-maroon-600">
                                        View details
                                        <svg class="h-4 w-4 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </article>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <div class="mt-12">
                    <?php echo e($publications->links()); ?>

                </div>
            <?php else: ?>
                <?php if (isset($component)) { $__componentOriginal074a021b9d42f490272b5eefda63257c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal074a021b9d42f490272b5eefda63257c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.empty-state','data' => ['title' => 'No publications found','description' => 'No publications match your current search. Try different keywords or browse all publications.','actionLabel' => 'View All Publications','actionHref' => ''.e(route('publications.index')).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('empty-state'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'No publications found','description' => 'No publications match your current search. Try different keywords or browse all publications.','action_label' => 'View All Publications','action_href' => ''.e(route('publications.index')).'']); ?>
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
<?php /**PATH C:\xampp\htdocs\ProDo\EDAA\resources\views/pages/publications.blade.php ENDPATH**/ ?>