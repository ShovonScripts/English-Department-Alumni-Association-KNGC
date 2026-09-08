<?php
    $ogImage = $story->cover_image_url;
    $authorName = $story->author_name;
    $imageUrl = $story->cover_image_url;
    $publishedDate = $story->published_at?->toIso8601String();
    $modifiedDate = $story->updated_at?->toIso8601String();
    $headline = $story->title;
    $description = $story->excerpt;
?>

<?php if (isset($component)) { $__componentOriginal5863877a5171c196453bfa0bd807e410 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5863877a5171c196453bfa0bd807e410 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.app','data' => ['title' => $story->title . ' | Alumni Stories','description' => $story->excerpt,'image' => $ogImage]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.app'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($story->title . ' | Alumni Stories'),'description' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($story->excerpt),'image' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($ogImage)]); ?>
    <?php $__env->startPush('head'); ?>
        <script type="application/ld+json">
        <?php echo json_encode(array_filter([
            '<?php $__contextArgs = [];
if (context()->has($__contextArgs[0])) :
if (isset($value)) { $__contextPrevious[] = $value; }
$value = context()->get($__contextArgs[0]); ?>' => 'https://schema.org',
            '@type' => 'Article',
            'headline' => $headline,
            'description' => $description,
            'image' => $imageUrl ? [url($imageUrl)] : null,
            'datePublished' => $publishedDate,
            'dateModified' => $modifiedDate,
            'author' => $authorName ? ['@type' => 'Person', 'name' => $authorName] : ($story->alumni ? ['@type' => 'Person', 'name' => $story->alumni->full_name, 'url' => route('alumni.show', $story->alumni)] : null),
            'publisher' => ['@type' => 'Organization', 'name' => 'English Department Alumni Association KNGC'],
            'url' => route('stories.show', $story),
        ], fn ($v) => $v !== null), JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>

        </script>
    <?php $__env->stopPush(); ?>

    <nav class="bg-cream py-4" aria-label="Breadcrumb">
        <div class="container-page">
            <ol class="flex flex-wrap items-center gap-2 text-sm text-ink-soft">
                <li><a href="<?php echo e(route('home')); ?>" class="transition-colors hover:text-maroon-700">Home</a></li>
                <li aria-hidden="true"><svg class="h-3 w-3 text-navy-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg></li>
                <li><a href="<?php echo e(route('stories.index')); ?>" class="transition-colors hover:text-maroon-700">Stories</a></li>
                <li aria-hidden="true"><svg class="h-3 w-3 text-navy-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg></li>
                <li class="font-medium text-navy-950" aria-current="page"><?php echo e(\Illuminate\Support\Str::limit($story->title, 50)); ?></li>
            </ol>
        </div>
    </nav>

    <article class="section-pad bg-white">
        <div class="container-page max-w-4xl">
            <h1 class="font-serif text-3xl font-semibold tracking-tight text-navy-950 sm:text-4xl lg:text-5xl"><?php echo e($story->title); ?></h1>

            <div class="mt-6 flex flex-wrap items-center gap-4 text-sm text-ink-soft">
                <?php if($story->author_name): ?>
                    <span class="font-medium text-navy-900">By <?php echo e($story->author_name); ?></span>
                <?php endif; ?>
                <time datetime="<?php echo e($story->published_at?->format('Y-m-d')); ?>"><?php echo e($story->published_at?->format('F j, Y')); ?></time>
            </div>

            <?php if($story->cover_image_url): ?>
                <figure class="mt-10">
                    <img src="<?php echo e($story->cover_image_url); ?>" alt="<?php echo e($story->title); ?>" class="w-full rounded-xl object-cover" style="max-height: 480px;">
                </figure>
            <?php endif; ?>

            <div class="prose prose-lg mt-10 max-w-none text-navy-950">
                <?php echo nl2br(e($story->content)); ?>

            </div>

            
            <?php if($story->alumni): ?>
                <div class="mt-12 rounded-lg border border-navy-100 bg-cream p-8">
                    <h2 class="font-serif text-lg font-semibold text-navy-950">About the Alumni</h2>
                    <div class="mt-4 flex items-center gap-4">
                        <?php if($story->alumni->profile_photo_url): ?>
                            <img src="<?php echo e($story->alumni->profile_photo_url); ?>" alt="<?php echo e($story->alumni->full_name); ?>" class="h-16 w-16 rounded-full object-cover ring-4 ring-gold-500/30">
                        <?php else: ?>
                            <span class="flex h-16 w-16 shrink-0 items-center justify-center rounded-full bg-navy-900 font-serif text-lg font-semibold text-gold-300 ring-4 ring-gold-500/30" aria-hidden="true">
                                <?php echo e(\Illuminate\Support\Str::initials($story->alumni->full_name)); ?>

                            </span>
                        <?php endif; ?>
                        <div>
                            <a href="<?php echo e(route('alumni.show', $story->alumni)); ?>" class="font-serif text-lg font-semibold text-navy-950 transition-colors hover:text-maroon-700"><?php echo e($story->alumni->full_name); ?></a>
                            <?php if($story->alumni->batch || $story->alumni->graduation_year): ?>
                                <p class="mt-0.5 text-sm text-ink-soft">
                                    <?php echo e(collect([$story->alumni->batch ? "Batch {$story->alumni->batch}" : null, $story->alumni->graduation_year])->filter()->implode(' · ')); ?>

                                </p>
                            <?php endif; ?>
                            <?php if($story->alumni->profession || $story->alumni->organization): ?>
                                <p class="mt-0.5 text-sm text-ink-soft">
                                    <?php echo e(collect([$story->alumni->profession, $story->alumni->organization])->filter()->implode(' · ')); ?>

                                </p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </article>

    <?php if($relatedStories->isNotEmpty()): ?>
        <section class="bg-cream py-16 sm:py-20">
            <div class="container-page">
                <?php if (isset($component)) { $__componentOriginal755230460fd16c04121658d92fbf99f7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal755230460fd16c04121658d92fbf99f7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.section-heading','data' => ['eyebrow' => 'More Stories','title' => 'Related stories','description' => 'You may also be interested in these stories.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('section-heading'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['eyebrow' => 'More Stories','title' => 'Related stories','description' => 'You may also be interested in these stories.']); ?>
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
                    <?php $__currentLoopData = $relatedStories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $related): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if (isset($component)) { $__componentOriginal5cb6f8d98bd8c07e7a8458167c190092 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5cb6f8d98bd8c07e7a8458167c190092 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.story-card','data' => ['name' => $related->alumni?->full_name,'graduationYear' => $related->alumni?->graduation_year,'quote' => $related->excerpt,'role' => $related->alumni?->designation,'image' => $related->cover_image_url,'href' => route('stories.show', $related)]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('story-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($related->alumni?->full_name),'graduation_year' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($related->alumni?->graduation_year),'quote' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($related->excerpt),'role' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($related->alumni?->designation),'image' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($related->cover_image_url),'href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('stories.show', $related))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5cb6f8d98bd8c07e7a8458167c190092)): ?>
<?php $attributes = $__attributesOriginal5cb6f8d98bd8c07e7a8458167c190092; ?>
<?php unset($__attributesOriginal5cb6f8d98bd8c07e7a8458167c190092); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5cb6f8d98bd8c07e7a8458167c190092)): ?>
<?php $component = $__componentOriginal5cb6f8d98bd8c07e7a8458167c190092; ?>
<?php unset($__componentOriginal5cb6f8d98bd8c07e7a8458167c190092); ?>
<?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    
    <section class="mx-auto max-w-4xl px-4 py-8 sm:px-6 lg:px-8">
        <?php if (isset($component)) { $__componentOriginal1a6e5077f335bc664c1e6423ce0001f6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1a6e5077f335bc664c1e6423ce0001f6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.comment-form','data' => ['commentableType' => 'App\Models\AlumniStory','commentableId' => $story->id]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('comment-form'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['commentable-type' => 'App\Models\AlumniStory','commentable-id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($story->id)]); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.comment-list','data' => ['commentableType' => 'App\Models\AlumniStory','commentableId' => $story->id]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('comment-list'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['commentable-type' => 'App\Models\AlumniStory','commentable-id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($story->id)]); ?>
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
<?php /**PATH C:\xampp\htdocs\ProDo\EDAA\resources\views\pages\story-show.blade.php ENDPATH**/ ?>