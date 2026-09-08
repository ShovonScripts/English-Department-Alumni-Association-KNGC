<?php if (isset($component)) { $__componentOriginal5863877a5171c196453bfa0bd807e410 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5863877a5171c196453bfa0bd807e410 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.app','data' => ['title' => 'News & Announcements','description' => 'Stay up to date with the latest news, announcements, and updates from the English Department Alumni Association KNGC.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.app'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'News & Announcements','description' => 'Stay up to date with the latest news, announcements, and updates from the English Department Alumni Association KNGC.']); ?>
    <?php if (isset($component)) { $__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.page-header','data' => ['eyebrow' => 'News & Announcements','title' => 'Latest from the Association','description' => 'Updates, stories, and announcements from the English Department Alumni Association KNGC community.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('page-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['eyebrow' => 'News & Announcements','title' => 'Latest from the Association','description' => 'Updates, stories, and announcements from the English Department Alumni Association KNGC community.']); ?>
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

    <?php if($featuredNews): ?>
        <section class="bg-white py-12 sm:py-16">
            <div class="container-page">
                <a href="<?php echo e(route('news.show', $featuredNews)); ?>" class="group">
                    <article class="grid gap-8 rounded-xl border border-navy-100 bg-cream p-8 shadow-sm transition-colors hover:border-gold-500/40 sm:p-10 lg:grid-cols-2">
                        <?php if($featuredNews->featured_image_url): ?>
                            <div class="relative overflow-hidden rounded-lg">
                                <img src="<?php echo e($featuredNews->featured_image_url); ?>" alt="<?php echo e($featuredNews->title); ?>" class="h-64 w-full object-cover transition duration-500 group-hover:scale-105 lg:h-full">
                            </div>
                        <?php else: ?>
                            <div class="flex h-64 items-center justify-center rounded-lg bg-gradient-to-br from-navy-800 via-navy-900 to-maroon-900 lg:h-full">
                                <svg class="h-16 w-16 text-gold-400/70" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.4" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 6a2 2 0 012-2h8l2 2h6a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V6z" />
                                </svg>
                            </div>
                        <?php endif; ?>

                        <div class="flex flex-col justify-center">
                            <div class="flex items-center gap-3">
                                <?php if($featuredNews->category): ?>
                                    <span class="rounded-full bg-navy-900 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-gold-300"><?php echo e($featuredNews->category->name); ?></span>
                                <?php endif; ?>
                                <span class="text-xs font-medium uppercase tracking-wider text-maroon-600">Featured</span>
                            </div>
                            <h2 class="mt-4 font-serif text-2xl font-semibold leading-snug text-navy-950 group-hover:text-maroon-700 sm:text-3xl"><?php echo e($featuredNews->title); ?></h2>
                            <p class="mt-4 text-ink-soft leading-relaxed"><?php echo e($featuredNews->excerpt); ?></p>
                            <div class="mt-6 flex items-center gap-4 text-sm text-ink-soft">
                                <?php if($featuredNews->author_name): ?>
                                    <span>By <?php echo e($featuredNews->author_name); ?></span>
                                <?php endif; ?>
                                <span><?php echo e($featuredNews->published_at?->format('F j, Y')); ?></span>
                            </div>
                        </div>
                    </article>
                </a>
            </div>
        </section>
    <?php endif; ?>

    <section class="bg-cream py-8 sm:py-10">
        <div class="container-page">
            <form method="GET" action="<?php echo e(route('news.index')); ?>" class="flex flex-col gap-4 sm:flex-row sm:items-end">
                <div class="flex-1">
                    <label for="search" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Search</label>
                    <input type="search" id="search" name="search" value="<?php echo e($filters['search'] ?? ''); ?>" placeholder="Search news..."
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
                <div class="flex gap-3">
                    <button type="submit" class="focus-ring inline-flex items-center gap-2 rounded-md bg-navy-900 px-5 py-2.5 text-sm font-semibold text-white transition-colors hover:bg-navy-800">Search</button>
                    <?php if(!empty($filters['search']) || !empty($filters['category'])): ?>
                        <a href="<?php echo e(route('news.index')); ?>" class="focus-ring inline-flex items-center gap-2 rounded-md px-3.5 py-2 text-sm font-semibold text-navy-800 transition-colors hover:bg-navy-50">Clear</a>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </section>

    <section class="section-pad bg-white">
        <div class="container-page">
            <?php if($allNews->isNotEmpty()): ?>
                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    <?php $__currentLoopData = $allNews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if (isset($component)) { $__componentOriginal1a2825a6708c27e00d3538c2a0d29d90 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1a2825a6708c27e00d3538c2a0d29d90 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.news-card','data' => ['title' => $article->title,'excerpt' => $article->excerpt,'date' => $article->published_at,'category' => $article->category?->name,'author' => $article->author_name,'href' => route('news.show', $article),'image' => $article->featured_image_url]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('news-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($article->title),'excerpt' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($article->excerpt),'date' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($article->published_at),'category' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($article->category?->name),'author' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($article->author_name),'href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('news.show', $article)),'image' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($article->featured_image_url)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1a2825a6708c27e00d3538c2a0d29d90)): ?>
<?php $attributes = $__attributesOriginal1a2825a6708c27e00d3538c2a0d29d90; ?>
<?php unset($__attributesOriginal1a2825a6708c27e00d3538c2a0d29d90); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1a2825a6708c27e00d3538c2a0d29d90)): ?>
<?php $component = $__componentOriginal1a2825a6708c27e00d3538c2a0d29d90; ?>
<?php unset($__componentOriginal1a2825a6708c27e00d3538c2a0d29d90); ?>
<?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <div class="mt-12">
                    <?php echo e($allNews->links()); ?>

                </div>
            <?php else: ?>
                <?php if (isset($component)) { $__componentOriginal074a021b9d42f490272b5eefda63257c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal074a021b9d42f490272b5eefda63257c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.empty-state','data' => ['title' => 'No news articles found','description' => 'No articles match your current search. Try different keywords or browse all news.','actionLabel' => 'View All News','actionHref' => ''.e(route('news.index')).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('empty-state'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'No news articles found','description' => 'No articles match your current search. Try different keywords or browse all news.','action_label' => 'View All News','action_href' => ''.e(route('news.index')).'']); ?>
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
<?php /**PATH C:\xampp\htdocs\ProDo\EDAA\resources\views\pages\news.blade.php ENDPATH**/ ?>