<?php
    $ogImage = $pressRelease->cover_image_url ?? null;
    $headline = $pressRelease->title;
    $description = $pressRelease->excerpt ?? \Illuminate\Support\Str::limit(strip_tags($pressRelease->content ?? ''), 160);
    $publishedDate = $pressRelease->published_at?->toIso8601String();
    $modifiedDate = $pressRelease->updated_at?->toIso8601String();
?>

<?php if (isset($component)) { $__componentOriginal5863877a5171c196453bfa0bd807e410 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5863877a5171c196453bfa0bd807e410 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.app','data' => ['title' => $headline . ' | Press Releases','description' => $description,'image' => $ogImage,'type' => 'article']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.app'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($headline . ' | Press Releases'),'description' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($description),'image' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($ogImage),'type' => 'article']); ?>
    <?php $__env->startPush('head'); ?>
        <script type="application/ld+json">
        <?php echo json_encode(array_filter([
            '<?php $__contextArgs = [];
if (context()->has($__contextArgs[0])) :
if (isset($value)) { $__contextPrevious[] = $value; }
$value = context()->get($__contextArgs[0]); ?>' => 'https://schema.org',
            '@type' => 'NewsArticle',
            'headline' => $headline,
            'description' => $description,
            'image' => $ogImage ? url($ogImage) : null,
            'datePublished' => $publishedDate,
            'dateModified' => $modifiedDate,
            'author' => ['@type' => 'Organization', 'name' => 'English Department Alumni Association KNGC'],
            'publisher' => ['@type' => 'Organization', 'name' => 'English Department Alumni Association KNGC'],
            'url' => url()->current(),
        ], fn ($v) => $v !== null), JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>

        </script>
    <?php $__env->stopPush(); ?>

    <nav class="bg-cream py-4" aria-label="Breadcrumb">
        <div class="container-page">
            <ol class="flex flex-wrap items-center gap-2 text-sm text-ink-soft">
                <li>
                    <a href="<?php echo e(route('home')); ?>" class="focus-ring inline-flex items-center gap-1.5 rounded transition-colors hover:text-gold-300">
                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-4 0a1 1 0 01-1-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 01-1 1h-2z" /></svg>
                        Home
                    </a>
                </li>
                <li aria-hidden="true">
                    <svg class="h-3.5 w-3.5 text-navy-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg>
                </li>
                <li>
                    <a href="<?php echo e(route('press-releases.index')); ?>" class="focus-ring inline-flex items-center gap-1.5 rounded transition-colors hover:text-gold-300">Press Releases</a>
                </li>
                <li aria-hidden="true">
                    <svg class="h-3.5 w-3.5 text-navy-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg>
                </li>
                <li class="font-medium text-navy-950" aria-current="page"><?php echo e(\Illuminate\Support\Str::limit($headline, 50)); ?></li>
            </ol>
        </div>
    </nav>

    <article class="section-pad bg-white">
        <div class="container-page">
            <div class="mx-auto max-w-3xl">
                <div class="flex items-center gap-3">
                    <span class="inline-flex rounded-full bg-maroon-700 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-white">Official Press Release</span>
                    <?php if($pressRelease->document_path): ?>
                        <span class="inline-flex rounded-full bg-navy-100 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-navy-700">PDF</span>
                    <?php endif; ?>
                </div>

                <h1 class="mt-4 font-serif text-3xl font-bold text-navy-950 sm:text-4xl"><?php echo e($headline); ?></h1>

                <div class="mt-4 flex items-center gap-3 text-sm text-ink-soft">
                    <time datetime="<?php echo e($pressRelease->published_at?->toIso8601String()); ?>">
                        <?php echo e($pressRelease->formatted_date); ?>

                    </time>
                    <?php if($pressRelease->external_url): ?>
                        <span aria-hidden="true">·</span>
                        <a href="<?php echo e(\App\Support\UrlHelper::safeHref($pressRelease->external_url)); ?>" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1 text-maroon-700 hover:text-maroon-800">
                            External Source
                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" /></svg>
                        </a>
                    <?php endif; ?>
                </div>

                <?php if($pressRelease->cover_image): ?>
                    <div class="mt-8 overflow-hidden rounded-xl">
                        <img src="<?php echo e($pressRelease->cover_image_url); ?>" alt="<?php echo e($headline); ?>" class="w-full object-cover">
                    </div>
                <?php endif; ?>

                <?php if($pressRelease->excerpt): ?>
                    <p class="mt-8 text-lg font-medium leading-relaxed text-navy-900"><?php echo e($pressRelease->excerpt); ?></p>
                <?php endif; ?>

                <?php if($pressRelease->content): ?>
                    <div class="prose prose-lg mt-8 max-w-none text-navy-950">
                        <?php echo nl2br(e($pressRelease->content)); ?>

                    </div>
                <?php endif; ?>

                <?php if($pressRelease->document_path): ?>
                    <div class="mt-10 rounded-xl border border-navy-100 bg-cream p-6">
                        <div class="flex items-center gap-4">
                            <span class="inline-flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-maroon-700 text-white">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                </svg>
                            </span>
                            <div>
                                <p class="text-sm font-semibold text-navy-950">Download Press Release</p>
                                <?php if($pressRelease->document_original_name): ?>
                                    <p class="text-xs text-ink-soft"><?php echo e($pressRelease->document_original_name); ?> · <?php echo e($pressRelease->formatted_document_size); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="mt-4 flex flex-col gap-3 sm:flex-row">
                            <a href="<?php echo e(\App\Support\UrlHelper::safeHref($pressRelease->document_url)); ?>" target="_blank" rel="noopener noreferrer"
                                class="focus-ring inline-flex items-center justify-center gap-2 rounded-lg bg-maroon-700 px-5 py-2.5 text-sm font-semibold text-white transition-colors hover:bg-maroon-800">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" /></svg>
                                View PDF
                            </a>
                            <a href="<?php echo e(\App\Support\UrlHelper::safeHref($pressRelease->document_url)); ?>" download
                                class="focus-ring inline-flex items-center justify-center gap-2 rounded-lg border border-navy-300 px-5 py-2.5 text-sm font-semibold text-navy-950 transition-colors hover:bg-navy-50">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
                                Download PDF
                            </a>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="mt-12 border-t border-navy-100 pt-8">
                    <a href="<?php echo e(route('press-releases.index')); ?>" class="focus-ring inline-flex items-center gap-2 text-sm font-semibold text-navy-950 transition-colors hover:text-maroon-700">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M7 16l-4-4m0 0l4-4m-4 4h18" /></svg>
                        Back to Press Releases
                    </a>
                </div>
            </div>
        </div>
    </article>

    <?php if($relatedReleases->isNotEmpty()): ?>
        <section class="bg-cream py-16 sm:py-20">
            <div class="container-page">
                <?php if (isset($component)) { $__componentOriginal755230460fd16c04121658d92fbf99f7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal755230460fd16c04121658d92fbf99f7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.section-heading','data' => ['eyebrow' => 'More Releases','title' => 'Latest Press Releases','description' => 'Stay up to date with official EDAA-KNGC communications.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('section-heading'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['eyebrow' => 'More Releases','title' => 'Latest Press Releases','description' => 'Stay up to date with official EDAA-KNGC communications.']); ?>
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
                    <?php $__currentLoopData = $relatedReleases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $related): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a href="<?php echo e(route('press-releases.show', $related)); ?>" class="card-lift shine glow-top group flex h-full flex-col overflow-hidden rounded-xl border border-white/20 bg-white/80 shadow-sm backdrop-blur-sm">
                            <?php if($related->cover_image): ?>
                                <div class="overflow-hidden">
                                    <img src="<?php echo e($related->cover_image_url); ?>" alt="<?php echo e($related->title); ?>" class="aspect-[16/9] w-full object-cover transition-transform duration-500 group-hover:scale-105">
                                </div>
                            <?php else: ?>
                                <div class="flex aspect-[16/9] items-center justify-center bg-gradient-to-br from-navy-900 to-navy-800">
                                    <span class="font-serif text-2xl font-bold text-gold-300/30">EDAA</span>
                                </div>
                            <?php endif; ?>
                            <div class="flex flex-1 flex-col p-6">
                                <time class="text-xs font-medium text-ink-soft" datetime="<?php echo e($related->published_at?->toIso8601String()); ?>"><?php echo e($related->formatted_date); ?></time>
                                <h3 class="mt-2 font-serif text-lg font-bold text-navy-950 transition-colors group-hover:text-maroon-700"><?php echo e($related->title); ?></h3>
                                <?php if($related->excerpt): ?>
                                    <p class="mt-2 flex-1 text-sm text-ink-soft line-clamp-2"><?php echo e($related->excerpt); ?></p>
                                <?php endif; ?>
                            </div>
                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    
    <section class="mx-auto max-w-4xl px-4 py-8 sm:px-6 lg:px-8">
        <?php if (isset($component)) { $__componentOriginal1a6e5077f335bc664c1e6423ce0001f6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1a6e5077f335bc664c1e6423ce0001f6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.comment-form','data' => ['commentableType' => 'App\Models\PressRelease','commentableId' => $pressRelease->id]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('comment-form'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['commentable-type' => 'App\Models\PressRelease','commentable-id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($pressRelease->id)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1a6e5077f335bc664c1e6423ce0001f6)): ?>
<?php $attributes = $__attributesOriginal1a6e5077f335bc664c1e6423ce0001f6; ?>
<?php unset($__attributesOriginal1a6e5077f335bc664c1e6423ce0001f6); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1a6e5077f335bc664c1e6423ce0001f6)): ?>
<?php $component = $__componentOriginal1a6e5077f335bc664c1e6423ce0001f6; ?>
<?php unset($__componentOriginal1a6e5077f335bc664c1e6423ce0001f6); ?>
<?php endif; ?>
        <?php if (isset($component)) { $__componentOriginal0a1aee6395256ea06bba9af91931d0ae = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0a1aee6395256ea06bba9af91931d0ae = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.comment-list','data' => ['commentableType' => 'App\Models\PressRelease','commentableId' => $pressRelease->id]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('comment-list'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['commentable-type' => 'App\Models\PressRelease','commentable-id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($pressRelease->id)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0a1aee6395256ea06bba9af91931d0ae)): ?>
<?php $attributes = $__attributesOriginal0a1aee6395256ea06bba9af91931d0ae; ?>
<?php unset($__attributesOriginal0a1aee6395256ea06bba9af91931d0ae); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0a1aee6395256ea06bba9af91931d0ae)): ?>
<?php $component = $__componentOriginal0a1aee6395256ea06bba9af91931d0ae; ?>
<?php unset($__componentOriginal0a1aee6395256ea06bba9af91931d0ae); ?>
<?php endif; ?>
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
<?php /**PATH C:\xampp\htdocs\ProDo\EDAA\resources\views/pages/press-release-show.blade.php ENDPATH**/ ?>