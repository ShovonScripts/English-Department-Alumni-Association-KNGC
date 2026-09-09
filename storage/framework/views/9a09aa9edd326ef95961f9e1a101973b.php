<?php if (isset($component)) { $__componentOriginal5863877a5171c196453bfa0bd807e410 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5863877a5171c196453bfa0bd807e410 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.app','data' => ['title' => $alumni->full_name . ' | Alumni','description' => trim($alumni->designation.' · '.$alumni->organization, ' · '),'image' => $alumni->profile_photo_url]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.app'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($alumni->full_name . ' | Alumni'),'description' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(trim($alumni->designation.' · '.$alumni->organization, ' · ')),'image' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($alumni->profile_photo_url)]); ?>

    
    <section class="relative overflow-hidden bg-navy-950 pt-20 pb-16">
        <div class="absolute inset-0 bg-gradient-to-br from-navy-950 via-navy-900 to-maroon-950/40"></div>
        <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg%20width%3D%2260%22%20height%3D%2260%22%20viewBox%3D%220%200%2060%2060%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%3E%3Cg%20fill%3D%22none%22%20fill-rule%3D%22evenodd%22%3E%3Cg%20fill%3D%22%23ffffff%22%20fill-opacity%3D%220.03%22%3E%3Cpath%20d%3D%22M36%2034v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6%2034v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6%204V0H4v4H0v2h4v4h2V6h4V4H6z%22%2F%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E')] opacity-50"></div>

        <div class="container-page relative z-10">
            
            <nav class="mb-8" aria-label="Breadcrumb">
                <ol class="flex items-center gap-2 text-xs text-navy-300">
                    <li><a href="<?php echo e(route('home')); ?>" class="transition-colors hover:text-gold-300">Home</a></li>
                    <li><span class="text-navy-500">/</span></li>
                    <li><a href="<?php echo e(route('alumni.index')); ?>" class="transition-colors hover:text-gold-300">Alumni</a></li>
                    <li><span class="text-navy-500">/</span></li>
                    <li class="text-gold-300"><?php echo e($alumni->full_name); ?></li>
                </ol>
            </nav>

            <div class="flex flex-col items-center gap-8 text-center sm:flex-row sm:text-left">
                
                <?php if($alumni->profile_photo_url): ?>
                    <img
                        src="<?php echo e($alumni->profile_photo_url); ?>"
                        alt="Portrait of <?php echo e($alumni->full_name); ?>"
                        class="h-32 w-32 shrink-0 rounded-full object-cover ring-4 ring-gold-500/40 shadow-xl shadow-gold-500/10 sm:h-40 sm:w-40"
                    >
                <?php else: ?>
                    <span class="flex h-32 w-32 shrink-0 items-center justify-center rounded-full bg-gradient-to-br from-gold-500/20 to-maroon-500/20 font-serif text-4xl font-bold text-gold-300 ring-4 ring-gold-500/40 shadow-xl shadow-gold-500/10 sm:h-40 sm:w-40" aria-hidden="true">
                        <?php echo e(\Illuminate\Support\Str::initials($alumni->full_name)); ?>

                    </span>
                <?php endif; ?>

                <div class="flex-1">
                    <h1 class="font-serif text-3xl font-bold tracking-tight text-white sm:text-4xl"><?php echo e($alumni->full_name); ?></h1>

                    <?php if($alumni->designation || $alumni->organization): ?>
                        <p class="mt-2 text-lg text-gold-300/90">
                            <?php echo e(collect([$alumni->designation, $alumni->organization])->filter()->implode(' at ')); ?>

                        </p>
                    <?php endif; ?>

                    <?php if($alumni->location): ?>
                        <p class="mt-1.5 flex items-center justify-center gap-1.5 text-sm text-navy-200 sm:justify-start">
                            <svg class="h-4 w-4 text-navy-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                            <?php echo e($alumni->location); ?>

                        </p>
                    <?php endif; ?>

                    <?php if($alumni->publicMembership): ?>
                        <div class="mt-4">
                            <?php if (isset($component)) { $__componentOriginalb341886620c268b94677189315a84e7d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb341886620c268b94677189315a84e7d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.membership-badge','data' => ['type' => $alumni->publicMembership->type,'tier' => $alumni->publicMembership->tier]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('membership-badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($alumni->publicMembership->type),'tier' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($alumni->publicMembership->tier)]); ?>
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

                    <?php if($leaderboard): ?>
                        <div class="mt-4 rounded-md border border-gold-500/40 bg-gold-500/10 px-4 py-3 text-center backdrop-blur-sm">
                            <p class="text-sm font-semibold text-white">
                                <span class="text-gold-300">#<?php echo e($leaderboard['rank']); ?></span>
                                <span class="sr-only"><?php echo e(\Illuminate\Support\Number::ordinal($leaderboard['rank'])); ?> place</span>
                                on Member Leaderboard
                            </p>
                            <p class="mt-2 text-[11px] font-semibold uppercase tracking-widest text-gold-200/70">Verified Contribution</p>
                            <p class="text-base font-bold tabular-nums text-gold-100">৳<?php echo e(number_format($leaderboard['contribution'])); ?></p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    
    <section class="section-pad bg-cream">
        <div class="container-page">
            <div class="grid gap-8 lg:grid-cols-3">

                
                <div class="lg:col-span-1">
                    <div class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm lg:sticky lg:top-8">
                        <?php if($alumni->linkedin_url || $alumni->website_url): ?>
                            <h2 class="text-xs font-semibold uppercase tracking-widest text-ink-soft">Links</h2>
                            <ul class="mt-5 space-y-4">
                                <?php if($alumni->linkedin_url): ?>
                                    <li>
                                        <a href="<?php echo e(\App\Support\UrlHelper::safeHref($alumni->linkedin_url)); ?>" target="_blank" rel="noopener noreferrer" class="group flex items-center gap-3 rounded-md p-2 -m-2 transition-colors hover:bg-cream">
                                            <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-navy-50 text-navy-600 transition-colors group-hover:bg-maroon-50 group-hover:text-maroon-700">
                                                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M6.9 8.6H3.6V20h3.3V8.6zM5.3 7.2a1.9 1.9 0 100-3.8 1.9 1.9 0 000 3.8zM20.4 13.4c0-3.3-1.8-4.9-4.2-4.9-1.9 0-2.8 1.1-3.3 1.8V8.6H9.6V20h3.3v-6c0-1.6.8-2.6 2.1-2.6 1.3 0 1.9.9 1.9 2.6v6h3.5v-6.6z" /></svg>
                                            </span>
                                            <span class="text-sm text-navy-950 transition-colors group-hover:text-maroon-700">LinkedIn Profile</span>
                                        </a>
                                    </li>
                                <?php endif; ?>
                                <?php if($alumni->website_url): ?>
                                    <li>
                                        <a href="<?php echo e(\App\Support\UrlHelper::safeHref($alumni->website_url)); ?>" target="_blank" rel="noopener noreferrer" class="group flex items-center gap-3 rounded-md p-2 -m-2 transition-colors hover:bg-cream">
                                            <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-navy-50 text-navy-600 transition-colors group-hover:bg-maroon-50 group-hover:text-maroon-700">
                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" /></svg>
                                            </span>
                                            <span class="text-sm text-navy-950 transition-colors group-hover:text-maroon-700">Personal Website</span>
                                        </a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        <?php endif; ?>

                        <div class="mt-6 border-t border-navy-100 pt-6">
                            <a href="<?php echo e(route('alumni.index')); ?>" class="focus-ring flex items-center justify-center gap-2 rounded-md border border-navy-200 px-4 py-2.5 text-sm font-semibold text-navy-800 transition-colors hover:bg-navy-50">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                                Back to Directory
                            </a>
                        </div>
                    </div>
                </div>

                
                <div class="space-y-8 lg:col-span-2">

                    
                    <?php if($alumni->bio): ?>
                        <div class="rounded-lg border border-navy-100 bg-white p-8 shadow-sm">
                            <h2 class="flex items-center gap-2 font-serif text-lg font-semibold text-navy-950">
                                <svg class="h-5 w-5 text-maroon-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                About
                            </h2>
                            <p class="mt-4 text-[15px] leading-relaxed text-ink-soft"><?php echo e($alumni->bio); ?></p>
                        </div>
                    <?php endif; ?>

                    
                    <div class="rounded-lg border border-navy-100 bg-white p-8 shadow-sm">
                        <h2 class="flex items-center gap-2 font-serif text-lg font-semibold text-navy-950">
                            <svg class="h-5 w-5 text-maroon-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                            Quick Facts
                        </h2>
                        <dl class="mt-6 grid gap-5 sm:grid-cols-2">
                            <?php if($alumni->batch): ?>
                                <div class="flex items-start gap-3 rounded-md bg-cream/60 p-3">
                                    <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Batch</dt>
                                    <dd class="ml-auto text-sm font-semibold text-navy-950"><?php echo e($alumni->batch); ?></dd>
                                </div>
                            <?php endif; ?>
                            <?php if($alumni->session): ?>
                                <div class="flex items-start gap-3 rounded-md bg-cream/60 p-3">
                                    <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Session</dt>
                                    <dd class="ml-auto text-sm font-semibold text-navy-950"><?php echo e($alumni->session); ?></dd>
                                </div>
                            <?php endif; ?>
                            <?php if($alumni->graduation_year): ?>
                                <div class="flex items-start gap-3 rounded-md bg-cream/60 p-3">
                                    <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Graduation</dt>
                                    <dd class="ml-auto text-sm font-semibold text-navy-950"><?php echo e($alumni->graduation_year); ?></dd>
                                </div>
                            <?php endif; ?>
                            <?php if($alumni->degree): ?>
                                <div class="flex items-start gap-3 rounded-md bg-cream/60 p-3">
                                    <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Degree</dt>
                                    <dd class="ml-auto text-sm font-semibold text-navy-950"><?php echo e($alumni->degree); ?></dd>
                                </div>
                            <?php endif; ?>
                            <?php if($alumni->student_id): ?>
                                <div class="flex items-start gap-3 rounded-md bg-cream/60 p-3">
                                    <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Student ID</dt>
                                    <dd class="ml-auto font-mono text-sm font-semibold text-navy-950"><?php echo e($alumni->student_id); ?></dd>
                                </div>
                            <?php endif; ?>
                            <?php if($alumni->profession): ?>
                                <div class="flex items-start gap-3 rounded-md bg-cream/60 p-3">
                                    <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Profession</dt>
                                    <dd class="ml-auto text-sm font-semibold text-navy-950"><?php echo e($alumni->profession); ?></dd>
                                </div>
                            <?php endif; ?>
                        </dl>
                    </div>

                    
                    <?php if($stories->isNotEmpty()): ?>
                        <div class="rounded-lg border border-navy-100 bg-white p-8 shadow-sm">
                            <h2 class="flex items-center gap-2 font-serif text-lg font-semibold text-navy-950">
                                <svg class="h-5 w-5 text-maroon-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" /></svg>
                                Alumni Stories
                            </h2>
                            <div class="mt-6 grid gap-4 sm:grid-cols-2">
                                <?php $__currentLoopData = $stories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $story): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <a href="<?php echo e(route('stories.show', $story)); ?>" class="group block rounded-lg border border-navy-100 p-5 transition-all duration-200 hover:border-gold-500/40 hover:bg-cream hover:shadow-sm">
                                        <h3 class="font-serif text-base font-semibold text-navy-950 transition-colors group-hover:text-maroon-700"><?php echo e($story->title); ?></h3>
                                        <p class="mt-2 line-clamp-2 text-sm leading-relaxed text-ink-soft"><?php echo e($story->excerpt); ?></p>
                                        <time class="mt-3 flex items-center gap-1.5 text-xs text-ink-soft" datetime="<?php echo e($story->published_at?->format('Y-m-d')); ?>">
                                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                            <?php echo e($story->published_at?->format('M j, Y')); ?>

                                        </time>
                                    </a>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    <?php endif; ?>

                </div>
            </div>
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
<?php /**PATH C:\xampp\htdocs\ProDo\EDAA\resources\views/pages/alumni-show.blade.php ENDPATH**/ ?>