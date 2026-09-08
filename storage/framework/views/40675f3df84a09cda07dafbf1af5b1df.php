<?php
    $ogImage = $news->featured_image_url;
    $authorName = $news->author_name;
    $imageUrl = $news->featured_image_url;
    $publishedDate = $news->published_at?->toIso8601String();
    $modifiedDate = $news->updated_at?->toIso8601String();
    $headline = $news->title;
    $description = $news->excerpt;
?>

<?php if (isset($component)) { $__componentOriginal5863877a5171c196453bfa0bd807e410 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5863877a5171c196453bfa0bd807e410 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.app','data' => ['title' => $news->title . ' | News','description' => $news->excerpt,'image' => $ogImage]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.app'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($news->title . ' | News'),'description' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($news->excerpt),'image' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($ogImage)]); ?>
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
            'image' => $imageUrl,
            'datePublished' => $publishedDate,
            'dateModified' => $modifiedDate,
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
                <li><a href="<?php echo e(route('news.index')); ?>" class="transition-colors hover:text-maroon-700">News</a></li>
                <li aria-hidden="true"><svg class="h-3 w-3 text-navy-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg></li>
                <li class="font-medium text-navy-950" aria-current="page"><?php echo e(\Illuminate\Support\Str::limit($news->title, 50)); ?></li>
            </ol>
        </div>
    </nav>

    <article class="section-pad bg-white">
        <div class="container-page max-w-4xl">
            <?php if($news->category): ?>
                <span class="inline-flex rounded-full bg-navy-900 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-gold-300"><?php echo e($news->category->name); ?></span>
            <?php endif; ?>

            <h1 class="mt-4 font-serif text-3xl font-semibold tracking-tight text-navy-950 sm:text-4xl lg:text-5xl"><?php echo e($news->title); ?></h1>

            <div class="mt-6 flex flex-wrap items-center gap-4 text-sm text-ink-soft">
                <?php if($news->author_name): ?>
                    <span class="font-medium text-navy-900">By <?php echo e($news->author_name); ?></span>
                <?php endif; ?>
                <time datetime="<?php echo e($news->published_at?->format('Y-m-d')); ?>"><?php echo e($news->published_at?->format('F j, Y')); ?></time>
            </div>

            <?php if($news->featured_image_url): ?>
                <figure class="mt-10">
                    <img src="<?php echo e($news->featured_image_url); ?>" alt="<?php echo e($news->title); ?>" class="w-full rounded-xl object-cover" style="max-height: 480px;">
                </figure>
            <?php endif; ?>

            <div class="prose prose-lg mt-10 max-w-none text-navy-950">
                <?php echo nl2br(e($news->content)); ?>

            </div>
        </div>
    </article>

    <?php if($relatedNews->isNotEmpty()): ?>
        <section class="bg-cream py-16 sm:py-20">
            <div class="container-page">
                <?php if (isset($component)) { $__componentOriginal755230460fd16c04121658d92fbf99f7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal755230460fd16c04121658d92fbf99f7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.section-heading','data' => ['eyebrow' => 'More News','title' => 'Related articles','description' => 'You may also be interested in these stories.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('section-heading'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['eyebrow' => 'More News','title' => 'Related articles','description' => 'You may also be interested in these stories.']); ?>
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
                    <?php $__currentLoopData = $relatedNews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $related): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if (isset($component)) { $__componentOriginal1a2825a6708c27e00d3538c2a0d29d90 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1a2825a6708c27e00d3538c2a0d29d90 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.news-card','data' => ['title' => $related->title,'excerpt' => $related->excerpt,'date' => $related->published_at,'category' => $related->category?->name,'author' => $related->author_name,'href' => route('news.show', $related),'image' => $related->featured_image_url]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('news-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($related->title),'excerpt' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($related->excerpt),'date' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($related->published_at),'category' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($related->category?->name),'author' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($related->author_name),'href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('news.show', $related)),'image' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($related->featured_image_url)]); ?>
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
            </div>
        </section>
    <?php endif; ?>

    
    <section class="mx-auto max-w-4xl px-4 py-8 sm:px-6 lg:px-8">
        <?php if (isset($component)) { $__componentOriginal1a6e5077f335bc664c1e6423ce0001f6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1a6e5077f335bc664c1e6423ce0001f6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.comment-form','data' => ['commentableType' => 'App\Models\News','commentableId' => $news->id]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('comment-form'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['commentable-type' => 'App\Models\News','commentable-id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($news->id)]); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.comment-list','data' => ['commentableType' => 'App\Models\News','commentableId' => $news->id]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('comment-list'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['commentable-type' => 'App\Models\News','commentable-id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($news->id)]); ?>
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
<?php /**PATH C:\xampp\htdocs\ProDo\EDAA\resources\views\pages\news-show.blade.php ENDPATH**/ ?>