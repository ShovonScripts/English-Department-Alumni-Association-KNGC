<?php
    $pageDescription = collect([$alumni->designation, $alumni->organization, $alumni->location])->filter()->implode(' · ');
?>

<?php if (isset($component)) { $__componentOriginal5863877a5171c196453bfa0bd807e410 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5863877a5171c196453bfa0bd807e410 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.app','data' => ['title' => $alumni->full_name . ' | Member','description' => $pageDescription,'image' => $alumni->profile_photo_url]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.app'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($alumni->full_name . ' | Member'),'description' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($pageDescription),'image' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($alumni->profile_photo_url)]); ?>

    <?php if (isset($component)) { $__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.page-header','data' => ['title' => $alumni->full_name,'description' => $pageDescription,'eyebrow' => 'Member Profile','breadcrumbs' => [['label' => 'Members', 'url' => route('members.index')], ['label' => $alumni->full_name]]]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('page-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($alumni->full_name),'description' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($pageDescription),'eyebrow' => 'Member Profile','breadcrumbs' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([['label' => 'Members', 'url' => route('members.index')], ['label' => $alumni->full_name]])]); ?>
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

    <section class="section-pad bg-cream">
        <div class="container-page">
            <div class="grid gap-8 lg:grid-cols-3">
                
                <div class="lg:col-span-1">
                    <div class="rounded-lg border border-navy-100 bg-white p-8 text-center shadow-sm lg:sticky lg:top-8">
                        <?php if($alumni->profile_photo_url): ?>
                            <img src="<?php echo e($alumni->profile_photo_url); ?>" alt="Portrait of <?php echo e($alumni->full_name); ?>" class="mx-auto h-36 w-36 rounded-full object-cover ring-4 ring-gold-500/30">
                        <?php else: ?>
                            <span class="mx-auto flex h-36 w-36 items-center justify-center rounded-full bg-navy-900 font-serif text-4xl font-semibold text-gold-300 ring-4 ring-gold-500/30" aria-hidden="true">
                                <?php echo e(\Illuminate\Support\Str::initials($alumni->full_name)); ?>

                            </span>
                        <?php endif; ?>

                        <h2 class="mt-6 font-serif text-2xl font-semibold text-navy-950"><?php echo e($alumni->full_name); ?></h2>

                        <?php if($membership): ?>
                            <div class="mt-3">
                                <?php if (isset($component)) { $__componentOriginalb341886620c268b94677189315a84e7d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb341886620c268b94677189315a84e7d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.membership-badge','data' => ['type' => $membership->type,'tier' => $membership->tier]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('membership-badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($membership->type),'tier' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($membership->tier)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb341886620c268b94677189315a84e7d)): ?>
<?php $attributes = $__attributesOriginalb341886620c268b94677189315a84e7d; ?>
<?php unset($__attributesOriginalb341886620c268b94677189315a84e7d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb341886620c268b94677189315a84e7d)): ?>
<?php $component = $__componentOriginalb341886620c268b94677189315a84e7d; ?>
<?php unset($__componentOriginalb341886620c268b94677189315a84e7d); ?>
<?php endif; ?>
                            </div>
                        <?php endif; ?>

                        <?php if($alumni->designation): ?>
                            <p class="mt-1 text-sm font-medium text-maroon-700"><?php echo e($alumni->designation); ?></p>
                        <?php endif; ?>

                        <?php if($alumni->organization): ?>
                            <p class="mt-1 text-sm text-ink-soft"><?php echo e($alumni->organization); ?></p>
                        <?php endif; ?>

                        <?php if($alumni->location): ?>
                            <p class="mt-1 text-sm text-ink-soft"><?php echo e($alumni->location); ?></p>
                        <?php endif; ?>

                        <?php if($alumni->linkedin_url || $alumni->website_url): ?>
                            <div class="mt-7 flex flex-col gap-3">
                                <?php if($alumni->linkedin_url): ?>
                                    <?php if (isset($component)) { $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.button','data' => ['href' => ''.e(\App\Support\UrlHelper::safeHref($alumni->linkedin_url)).'','variant' => 'outline','icon' => true,'target' => '_blank','rel' => 'noopener noreferrer']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => ''.e(\App\Support\UrlHelper::safeHref($alumni->linkedin_url)).'','variant' => 'outline','icon' => true,'target' => '_blank','rel' => 'noopener noreferrer']); ?>LinkedIn <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561)): ?>
<?php $attributes = $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561; ?>
<?php unset($__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald0f1fd2689e4bb7060122a5b91fe8561)): ?>
<?php $component = $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561; ?>
<?php unset($__componentOriginald0f1fd2689e4bb7060122a5b91fe8561); ?>
<?php endif; ?>
                                <?php endif; ?>
                                <?php if($alumni->website_url): ?>
                                    <?php if (isset($component)) { $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.button','data' => ['href' => ''.e(\App\Support\UrlHelper::safeHref($alumni->website_url)).'','variant' => 'outline','icon' => true,'target' => '_blank','rel' => 'noopener noreferrer']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => ''.e(\App\Support\UrlHelper::safeHref($alumni->website_url)).'','variant' => 'outline','icon' => true,'target' => '_blank','rel' => 'noopener noreferrer']); ?>Website <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561)): ?>
<?php $attributes = $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561; ?>
<?php unset($__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald0f1fd2689e4bb7060122a5b91fe8561)): ?>
<?php $component = $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561; ?>
<?php unset($__componentOriginald0f1fd2689e4bb7060122a5b91fe8561); ?>
<?php endif; ?>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="mt-6">
                        <?php if (isset($component)) { $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.button','data' => ['href' => ''.e(route('members.index')).'','variant' => 'navy']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => ''.e(route('members.index')).'','variant' => 'navy']); ?>Back to Directory <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561)): ?>
<?php $attributes = $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561; ?>
<?php unset($__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald0f1fd2689e4bb7060122a5b91fe8561)): ?>
<?php $component = $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561; ?>
<?php unset($__componentOriginald0f1fd2689e4bb7060122a5b91fe8561); ?>
<?php endif; ?>
                    </div>
                </div>

                
                <div class="lg:col-span-2">
                    <?php if($alumni->bio): ?>
                        <div class="rounded-lg border border-navy-100 bg-white p-8 shadow-sm">
                            <h2 class="font-serif text-xl font-semibold text-navy-950">About</h2>
                            <p class="mt-4 text-base leading-relaxed text-ink-soft"><?php echo e($alumni->bio); ?></p>
                        </div>
                    <?php endif; ?>

                    <div class="mt-8 rounded-lg border border-navy-100 bg-white p-8 shadow-sm">
                        <h2 class="font-serif text-xl font-semibold text-navy-950">Academic Record</h2>
                        <dl class="mt-6 grid gap-x-8 gap-y-6 sm:grid-cols-2">
                            <?php if($alumni->degree): ?>
                                <div>
                                    <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Degree</dt>
                                    <dd class="mt-1 text-sm text-navy-950"><?php echo e($alumni->degree); ?></dd>
                                </div>
                            <?php endif; ?>
                            <?php if($alumni->batch): ?>
                                <div>
                                    <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Batch</dt>
                                    <dd class="mt-1 text-sm text-navy-950"><?php echo e($alumni->batch); ?></dd>
                                </div>
                            <?php endif; ?>
                            <?php if($alumni->session): ?>
                                <div>
                                    <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Session</dt>
                                    <dd class="mt-1 text-sm text-navy-950"><?php echo e($alumni->session); ?></dd>
                                </div>
                            <?php endif; ?>
                            <?php if($alumni->graduation_year): ?>
                                <div>
                                    <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Graduation Year</dt>
                                    <dd class="mt-1 text-sm text-navy-950"><?php echo e($alumni->graduation_year); ?></dd>
                                </div>
                            <?php endif; ?>
                        </dl>
                    </div>

                    <div class="mt-8 rounded-lg border border-navy-100 bg-white p-8 shadow-sm">
                        <h2 class="font-serif text-xl font-semibold text-navy-950">Career</h2>
                        <dl class="mt-6 grid gap-x-8 gap-y-6 sm:grid-cols-2">
                            <?php if($alumni->profession): ?>
                                <div>
                                    <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Profession</dt>
                                    <dd class="mt-1 text-sm text-navy-950"><?php echo e($alumni->profession); ?></dd>
                                </div>
                            <?php endif; ?>
                            <?php if($alumni->designation): ?>
                                <div>
                                    <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Designation</dt>
                                    <dd class="mt-1 text-sm text-navy-950"><?php echo e($alumni->designation); ?></dd>
                                </div>
                            <?php endif; ?>
                            <?php if($alumni->organization): ?>
                                <div>
                                    <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Organization</dt>
                                    <dd class="mt-1 text-sm text-navy-950"><?php echo e($alumni->organization); ?></dd>
                                </div>
                            <?php endif; ?>
                            <?php if($alumni->location): ?>
                                <div>
                                    <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Location</dt>
                                    <dd class="mt-1 text-sm text-navy-950"><?php echo e($alumni->location); ?></dd>
                                </div>
                            <?php endif; ?>
                        </dl>
                    </div>

                    
                    <div class="mt-8 rounded-lg border border-navy-100 bg-white p-8 shadow-sm">
                        <h2 class="font-serif text-xl font-semibold text-navy-950">Membership</h2>
                        <dl class="mt-6 grid gap-x-8 gap-y-6 sm:grid-cols-2">
                            <div>
                                <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Membership Type</dt>
                                <dd class="mt-1 text-sm text-navy-950"><?php echo e($membership->type?->name ?? '—'); ?></dd>
                            </div>
                            <div>
                                <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Membership Tier</dt>
                                <dd class="mt-1 text-sm text-navy-950"><?php echo e($membership->tier?->badge_label ?? 'Not assigned'); ?></dd>
                            </div>
                        </dl>
                    </div>

                    
                    <?php if($alumni->stories->isNotEmpty()): ?>
                        <div class="mt-8 rounded-lg border border-navy-100 bg-white p-8 shadow-sm">
                            <h2 class="font-serif text-xl font-semibold text-navy-950">Alumni Stories</h2>
                            <div class="mt-6 grid gap-4 sm:grid-cols-2">
                                <?php $__currentLoopData = $alumni->stories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $story): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <a href="<?php echo e(route('stories.show', $story)); ?>" class="group block rounded-lg border border-navy-100 p-4 transition-colors hover:border-gold-500/40 hover:bg-cream">
                                        <h3 class="font-serif text-base font-semibold text-navy-950 transition-colors group-hover:text-maroon-700"><?php echo e($story->title); ?></h3>
                                        <p class="mt-1 line-clamp-2 text-sm text-ink-soft"><?php echo e($story->excerpt); ?></p>
                                        <time class="mt-2 block text-xs text-ink-soft" datetime="<?php echo e($story->published_at?->format('Y-m-d')); ?>"><?php echo e($story->published_at?->format('M j, Y')); ?></time>
                                    </a>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    
    <?php $__env->startPush('head'); ?>
        <?php
            $ldJson = [
                '@context' => 'https://schema.org',
                '@type' => 'Person',
                'name' => $alumni->full_name,
                'url' => url()->current(),
            ];
            if ($alumni->profile_photo_url) {
                $ldJson['image'] = $alumni->profile_photo_url;
            }
            if ($alumni->profession) {
                $ldJson['jobTitle'] = $alumni->profession;
            }
            if ($alumni->organization) {
                $ldJson['worksFor'] = ['@type' => 'Organization', 'name' => $alumni->organization];
            }
            if ($alumni->linkedin_url) {
                $ldJson['sameAs'] = [$alumni->linkedin_url];
            }
            if ($alumni->website_url) {
                $ldJson['sameAs'][] = $alumni->website_url;
            }
        ?>
        <script type="application/ld+json"><?php echo json_encode($ldJson, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?></script>
    <?php $__env->stopPush(); ?>

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
<?php /**PATH C:\xampp\htdocs\ProDo\EDAA\resources\views\pages\member-show.blade.php ENDPATH**/ ?>