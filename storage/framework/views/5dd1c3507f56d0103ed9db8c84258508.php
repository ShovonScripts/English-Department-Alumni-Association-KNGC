<?php
    $jsonLd = [
        '@context' => 'https://schema.org',
        '@type' => 'Event',
        'name' => $event->title,
        'description' => $event->short_description,
        'startDate' => $event->event_date->toIso8601String(),
        'organizer' => [
            '@type' => 'Organization',
            'name' => $event->organizer ?? 'English Department Alumni Association KNGC',
        ],
    ];

    if ($event->start_time) {
        $startDateTime = $event->event_date->copy()->setTimeFromTimeString($event->start_time);
        $jsonLd['startDate'] = $startDateTime->toIso8601String();
        if ($event->end_time) {
            $endDateTime = $event->event_date->copy()->setTimeFromTimeString($event->end_time);
            $jsonLd['endDate'] = $endDateTime->toIso8601String();
        }
    }

    if ($event->venue) {
        $jsonLd['location'] = [
            '@type' => 'Place',
            'name' => $event->venue,
        ];
        if ($event->address || $event->city || $event->country) {
            $jsonLd['location']['address'] = [
                '@type' => 'PostalAddress',
                'streetAddress' => $event->address,
                'addressLocality' => $event->city,
                'addressCountry' => $event->country,
            ];
        }
    }

    if ($event->cover_image_url) {
        $jsonLd['image'] = [url($event->cover_image_url)];
    }
    if ($event->capacity) {
        $jsonLd['maximumAttendeeCapacity'] = $event->capacity;
    }
    if ($event->registration_deadline) {
        $jsonLd['registrationDeadline'] = $event->registration_deadline->toIso8601String();
    }
    $jsonLd['url'] = route('events.show', $event);
?>

<?php if (isset($component)) { $__componentOriginal5863877a5171c196453bfa0bd807e410 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5863877a5171c196453bfa0bd807e410 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.app','data' => ['title' => $event->title . ' — Events','description' => $event->short_description]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.app'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($event->title . ' — Events'),'description' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($event->short_description)]); ?>

    <?php $__env->startPush('head'); ?>
        <script type="application/ld+json"><?php echo json_encode($jsonLd, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?></script>
    <?php $__env->stopPush(); ?>

    <?php if (isset($component)) { $__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.page-header','data' => ['title' => $event->title,'description' => $event->short_description,'eyebrow' => $event->category?->name ?? 'Event','breadcrumbs' => [
            ['label' => 'Events', 'href' => route('events.index')],
            ['label' => $event->title],
        ]]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('page-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($event->title),'description' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($event->short_description),'eyebrow' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($event->category?->name ?? 'Event'),'breadcrumbs' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
            ['label' => 'Events', 'href' => route('events.index')],
            ['label' => $event->title],
        ])]); ?>
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

    <?php if($event->cover_image): ?>
        <section class="bg-white">
            <div class="container-page pb-10">
                <div class="overflow-hidden rounded-2xl">
                    <img src="<?php echo e($event->cover_image_url); ?>" alt="<?php echo e($event->title); ?>" class="h-64 w-full object-cover sm:h-80 lg:h-96">
                </div>
            </div>
        </section>
    <?php endif; ?>

    <section class="section-pad bg-white">
        <div class="container-page">
            <div class="grid gap-10 lg:grid-cols-3">
                <div class="lg:col-span-2 space-y-8">
                    <div class="rounded-2xl border border-navy-100 bg-white p-6 shadow-sm sm:p-8">
                        <h2 class="font-serif text-xl font-semibold text-navy-950 mb-4">About This Event</h2>
                        <div class="prose prose-navy max-w-none text-sm leading-relaxed text-navy-900">
                            <?php echo nl2br(e($event->description)); ?>

                        </div>
                    </div>

                    <div class="rounded-2xl border border-navy-100 bg-white p-6 shadow-sm sm:p-8">
                        <h2 class="font-serif text-xl font-semibold text-navy-950 mb-4">Location</h2>
                        <div class="flex items-start gap-3">
                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-navy-900 text-white">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M17.7 11.9l-6.8 6.9a2 2 0 01-2.8 0l-3-3a2 2 0 010-2.8l6.9-6.8M14.8 3.2L20.8 9.2m-2-2l-4.5 4.5a4 4 0 00-1 2.1l-.2 1.5a.5.5 0 00.6.6l1.5-.2a4 4 0 002.1-1l4.5-4.5a2 2 0 000-2.8l-2.5-2.5a2 2 0 00-2.8 0z" /></svg>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-navy-950"><?php echo e($event->venue ?? 'Venue not specified'); ?></p>
                                <?php if($event->address || $event->location): ?>
                                    <p class="mt-1 text-sm text-ink-soft"><?php echo e(collect([$event->address, $event->location])->filter()->implode(', ')); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-2xl border border-navy-100 bg-white p-6 shadow-sm sm:p-8">
                        <h2 class="font-serif text-xl font-semibold text-navy-950 mb-4">Organizer</h2>
                        <div class="flex items-start gap-3">
                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-navy-900 text-white">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-navy-950"><?php echo e($event->organizer ?? 'English Department Alumni Association KNGC'); ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <aside class="space-y-6">
                    <div class="rounded-2xl border border-navy-100 bg-cream p-6 shadow-sm">
                        <h2 class="font-serif text-lg font-semibold text-navy-950 mb-5">Event Details</h2>
                        <dl class="space-y-4 text-sm">
                            <div class="flex items-start gap-3">
                                <dt class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-navy-900 text-white">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3M4 11h16M5 5h14a1 1 0 011 1v13a1 1 0 01-1 1H5a1 1 0 01-1-1V6a1 1 0 011-1z" /></svg>
                                </dt>
                                <dd>
                                    <span class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Date</span>
                                    <p class="mt-1 font-medium text-navy-950"><?php echo e($event->formatted_date); ?></p>
                                </dd>
                            </div>

                            <?php if($event->formatted_time): ?>
                                <div class="flex items-start gap-3">
                                    <dt class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-navy-900 text-white">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    </dt>
                                    <dd>
                                        <span class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Time</span>
                                        <p class="mt-1 font-medium text-navy-950"><?php echo e($event->formatted_time); ?></p>
                                    </dd>
                                </div>
                            <?php endif; ?>

                            <?php if($event->capacity): ?>
                                <div class="flex items-start gap-3">
                                    <dt class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-navy-900 text-white">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                                    </dt>
                                    <dd>
                                        <span class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Capacity</span>
                                        <p class="mt-1 font-medium text-navy-950"><?php echo e(number_format($event->capacity)); ?> attendees</p>
                                    </dd>
                                </div>
                            <?php endif; ?>

                            <?php if($event->registration_deadline): ?>
                                <div class="flex items-start gap-3">
                                    <dt class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-navy-900 text-white">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    </dt>
                                    <dd>
                                        <span class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Registration Deadline</span>
                                        <p class="mt-1 font-medium text-navy-950"><?php echo e($event->registration_deadline->format('l, F j, Y')); ?></p>
                                    </dd>
                                </div>
                            <?php endif; ?>

                            <?php if($event->category): ?>
                                <div class="flex items-start gap-3">
                                    <dt class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-navy-900 text-white">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z" /></svg>
                                    </dt>
                                    <dd>
                                        <span class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Category</span>
                                        <p class="mt-1 font-medium text-navy-950"><?php echo e($event->category->name); ?></p>
                                    </dd>
                                </div>
                            <?php endif; ?>
                        </dl>
                    </div>

                    <a href="<?php echo e(route('events.index')); ?>" class="focus-ring flex w-full items-center justify-center gap-2 rounded-lg border border-navy-200 bg-white px-4 py-3 text-sm font-semibold text-navy-800 transition-colors hover:bg-navy-50">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M7 17L3 12m0 0l4-5m-4 5h18" /></svg>
                        Back to Events
                    </a>
                </aside>
            </div>
        </div>
    </section>

    
    <section class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        <?php if (isset($component)) { $__componentOriginal1a6e5077f335bc664c1e6423ce0001f6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1a6e5077f335bc664c1e6423ce0001f6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.comment-form','data' => ['commentableType' => 'App\Models\Event','commentableId' => $event->id]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('comment-form'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['commentable-type' => 'App\Models\Event','commentable-id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($event->id)]); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.comment-list','data' => ['commentableType' => 'App\Models\Event','commentableId' => $event->id]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('comment-list'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['commentable-type' => 'App\Models\Event','commentable-id' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($event->id)]); ?>
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
<?php /**PATH C:\xampp\htdocs\ProDo\EDAA\resources\views/pages/event-show.blade.php ENDPATH**/ ?>