<?php
    $ogImage = $publication->cover_image_url;
    $authorName = $publication->author;
    $imageUrl = $publication->cover_image_url;
    $publishedDate = $publication->publication_date?->toIso8601String();
    $headline = $publication->title;
    $description = $publication->description;
    $documentType = $publication->document_original_name
        ? strtoupper(pathinfo($publication->document_original_name, PATHINFO_EXTENSION))
        : null;
    $schemaType = in_array($publication->category?->slug, ['research', 'journal', 'thesis'])
        ? 'ScholarlyArticle'
        : 'CreativeWork';
?>

<?php if (isset($component)) { $__componentOriginal5863877a5171c196453bfa0bd807e410 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5863877a5171c196453bfa0bd807e410 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.app','data' => ['title' => $publication->title . ' | Publications','description' => $publication->description,'image' => $ogImage]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.app'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($publication->title . ' | Publications'),'description' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($publication->description),'image' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($ogImage)]); ?>
    <?php $__env->startPush('head'); ?>
        <script type="application/ld+json">
        <?php echo json_encode(array_filter([
            '<?php $__contextArgs = [];
if (context()->has($__contextArgs[0])) :
if (isset($value)) { $__contextPrevious[] = $value; }
$value = context()->get($__contextArgs[0]); ?>' => 'https://schema.org',
            '@type' => $schemaType,
            'headline' => $headline,
            'description' => $description,
            'image' => $imageUrl,
            'datePublished' => $publishedDate,
            'author' => $authorName ? ['@type' => 'Person', 'name' => $authorName] : null,
            'publisher' => ['@type' => 'Organization', 'name' => 'English Department Alumni Association KNGC'],
        ], fn ($v) => $v !== null), JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>

        </script>
    <?php $__env->stopPush(); ?>

    <nav class="bg-cream py-4" aria-label="Breadcrumb">
        <div class="container-page">
            <ol class="flex flex-wrap items-center gap-2 text-sm text-ink-soft">
                <li><a href="<?php echo e(route('home')); ?>" class="transition-colors hover:text-maroon-700">Home</a></li>
                <li aria-hidden="true"><svg class="h-3 w-3 text-navy-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg></li>
                <li><a href="<?php echo e(route('publications.index')); ?>" class="transition-colors hover:text-maroon-700">Publications</a></li>
                <li aria-hidden="true"><svg class="h-3 w-3 text-navy-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg></li>
                <li class="font-medium text-navy-950" aria-current="page"><?php echo e(\Illuminate\Support\Str::limit($publication->title, 50)); ?></li>
            </ol>
        </div>
    </nav>

    <article class="section-pad bg-white">
        <div class="container-page max-w-4xl">
            <?php if($publication->category): ?>
                <span class="inline-flex rounded-full bg-navy-900 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-gold-300"><?php echo e($publication->category->name); ?></span>
            <?php endif; ?>

            <h1 class="mt-4 font-serif text-3xl font-semibold tracking-tight text-navy-950 sm:text-4xl lg:text-5xl"><?php echo e($publication->title); ?></h1>

            <?php if($publication->subtitle): ?>
                <p class="mt-3 text-lg text-ink-soft"><?php echo e($publication->subtitle); ?></p>
            <?php endif; ?>

            <div class="mt-6 flex flex-wrap items-center gap-4 text-sm text-ink-soft">
                <?php if($publication->author): ?>
                    <span class="font-medium text-navy-900">By <?php echo e($publication->author); ?></span>
                <?php endif; ?>
                <?php if($publication->publisher): ?>
                    <span><?php echo e($publication->publisher); ?></span>
                <?php endif; ?>
                <?php if($publication->publication_date): ?>
                    <time datetime="<?php echo e($publication->publication_date->format('Y-m-d')); ?>"><?php echo e($publication->publication_date->format('F j, Y')); ?></time>
                <?php endif; ?>
            </div>

            <?php if($publication->cover_image_url): ?>
                <figure class="mt-10">
                    <img src="<?php echo e($publication->cover_image_url); ?>" alt="<?php echo e($publication->title); ?>" class="w-full rounded-xl object-cover" style="max-height: 480px;">
                </figure>
            <?php endif; ?>

            <div class="mt-10 grid gap-10 lg:grid-cols-[1fr_280px]">
                <div class="prose prose-lg max-w-none text-navy-950">
                    <?php echo nl2br(e($publication->description)); ?>

                </div>

                <?php if($publication->document_url): ?>
                    <aside class="lg:order-last">
                        <div class="sticky top-24 rounded-xl border border-navy-100 bg-cream p-6 shadow-sm">
                            <div class="flex items-center gap-3">
                                <span class="inline-flex h-11 w-11 shrink-0 items-center justify-center rounded-md bg-navy-900 text-gold-300">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.3v11.4m0-11.4A3.2 3.2 0 009.5 3.5H6.5v13h3a3.2 3.2 0 013 2.8m-.5-12.9a3.2 3.2 0 012.5-2.8h3v13h-3a3.2 3.2 0 00-3 2.8m0-12.9v11.4" />
                                    </svg>
                                </span>
                                <div>
                                    <?php if($documentType): ?>
                                        <span class="rounded-full bg-maroon-50 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-maroon-700"><?php echo e($documentType); ?></span>
                                    <?php endif; ?>
                                    <?php if($publication->formatted_document_size): ?>
                                        <p class="mt-1 text-xs text-ink-soft"><?php echo e($publication->formatted_document_size); ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="mt-6 flex flex-col gap-3">
                                <a href="<?php echo e(\App\Support\UrlHelper::safeHref($publication->document_url)); ?>" target="_blank" rel="noopener noreferrer"
                                    class="focus-ring inline-flex items-center justify-center gap-2 rounded-md bg-navy-900 px-5 py-2.5 text-sm font-semibold text-white transition-colors hover:bg-navy-800">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    View PDF
                                </a>
                                <a href="<?php echo e(\App\Support\UrlHelper::safeHref($publication->document_url)); ?>" download
                                    class="focus-ring inline-flex items-center justify-center gap-2 rounded-md border border-navy-300 px-5 py-2.5 text-sm font-semibold text-navy-900 transition-colors hover:bg-navy-50">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                    </svg>
                                    Download PDF
                                </a>
                            </div>

                            <dl class="mt-6 space-y-4 border-t border-navy-200 pt-6 text-sm">
                                <?php if($publication->author): ?>
                                    <div>
                                        <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Author</dt>
                                        <dd class="mt-1 font-medium text-navy-950"><?php echo e($publication->author); ?></dd>
                                    </div>
                                <?php endif; ?>
                                <?php if($publication->publisher): ?>
                                    <div>
                                        <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Publisher</dt>
                                        <dd class="mt-1 font-medium text-navy-950"><?php echo e($publication->publisher); ?></dd>
                                    </div>
                                <?php endif; ?>
                                <?php if($publication->publication_date): ?>
                                    <div>
                                        <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Publication Date</dt>
                                        <dd class="mt-1 font-medium text-navy-950"><?php echo e($publication->publication_date->format('F j, Y')); ?></dd>
                                    </div>
                                <?php endif; ?>
                                <?php if($publication->category): ?>
                                    <div>
                                        <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Category</dt>
                                        <dd class="mt-1 font-medium text-navy-950"><?php echo e($publication->category->name); ?></dd>
                                    </div>
                                <?php endif; ?>
                            </dl>
                        </div>
                    </aside>
                <?php endif; ?>
            </div>

            <div class="mt-12">
                <a href="<?php echo e(route('publications.index')); ?>" class="focus-ring inline-flex items-center gap-2 text-sm font-semibold text-maroon-700 transition-colors hover:text-maroon-600">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 16l-4-4m0 0l4-4m-4 4h18" />
                    </svg>
                    Back to Publications
                </a>
            </div>
        </div>
    </article>

    <?php if($relatedPublications && $relatedPublications->isNotEmpty()): ?>
        <section class="bg-cream py-16 sm:py-20">
            <div class="container-page">
                <?php if (isset($component)) { $__componentOriginal755230460fd16c04121658d92fbf99f7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal755230460fd16c04121658d92fbf99f7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.section-heading','data' => ['eyebrow' => 'More Publications','title' => 'Related publications','description' => 'You may also be interested in these publications.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('section-heading'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['eyebrow' => 'More Publications','title' => 'Related publications','description' => 'You may also be interested in these publications.']); ?>
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
                    <?php $__currentLoopData = $relatedPublications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $related): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if (isset($component)) { $__componentOriginal4b48c940f0ffe0bae9e547acb74f1315 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4b48c940f0ffe0bae9e547acb74f1315 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.publication-card','data' => ['title' => $related->title,'type' => $related->document_original_name ? pathinfo($related->document_original_name, PATHINFO_EXTENSION) : null,'author' => $related->author,'year' => $related->publication_date?->format('Y'),'description' => $related->description,'href' => route('publications.show', $related)]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('publication-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($related->title),'type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($related->document_original_name ? pathinfo($related->document_original_name, PATHINFO_EXTENSION) : null),'author' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($related->author),'year' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($related->publication_date?->format('Y')),'description' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($related->description),'href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('publications.show', $related))]); ?>
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

    
    <section class="mx-auto max-w-4xl px-4 py-8 sm:px-6 lg:px-8">
        <?php if (isset($component)) { $__componentOriginal1a6e5077f335bc664c1e6423ce0001f6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1a6e5077f335bc664c1e6423ce0001f6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.comment-form','data' => ['commentableType' => 'App\Models\Publication','commentableId' => $publication->id]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('comment-form'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['commentable-type' => 'App\Models\Publication','commentable-id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($publication->id)]); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.comment-list','data' => ['commentableType' => 'App\Models\Publication','commentableId' => $publication->id]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('comment-list'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['commentable-type' => 'App\Models\Publication','commentable-id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($publication->id)]); ?>
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
<?php /**PATH C:\xampp\htdocs\ProDo\EDAA\resources\views\pages\publication-show.blade.php ENDPATH**/ ?>