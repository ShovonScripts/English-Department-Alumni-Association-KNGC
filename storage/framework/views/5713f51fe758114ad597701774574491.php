<?php if (isset($component)) { $__componentOriginal5863877a5171c196453bfa0bd807e410 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5863877a5171c196453bfa0bd807e410 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.app','data' => ['title' => 'Membership','description' => 'Learn about EDAA-KNGC membership categories, tiers, benefits, and how to join the English Department Alumni Association of Kabi Nazrul Government College.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.app'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Membership','description' => 'Learn about EDAA-KNGC membership categories, tiers, benefits, and how to join the English Department Alumni Association of Kabi Nazrul Government College.']); ?>

    <?php if (isset($component)) { $__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.page-header','data' => ['title' => 'Membership','description' => 'Join the English Department Alumni Association KNGC and stay connected with fellow alumni, scholars, and teachers across generations.','eyebrow' => 'Join Us','breadcrumbs' => [['label' => 'Membership']]]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('page-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Membership','description' => 'Join the English Department Alumni Association KNGC and stay connected with fellow alumni, scholars, and teachers across generations.','eyebrow' => 'Join Us','breadcrumbs' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([['label' => 'Membership']])]); ?>
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

    
    <section class="section-pad bg-white">
        <div class="container-page">
            <?php if (isset($component)) { $__componentOriginal755230460fd16c04121658d92fbf99f7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal755230460fd16c04121658d92fbf99f7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.section-heading','data' => ['eyebrow' => 'About Membership','title' => 'What is EDAA-KNGC?','description' => 'The English Department Alumni Association KNGC is a non-political, non-profit, social and welfare-oriented community dedicated to lifelong fellowship, academic mentorship, and community service.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('section-heading'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['eyebrow' => 'About Membership','title' => 'What is EDAA-KNGC?','description' => 'The English Department Alumni Association KNGC is a non-political, non-profit, social and welfare-oriented community dedicated to lifelong fellowship, academic mentorship, and community service.']); ?>
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

            <div class="mt-12 grid gap-8 md:grid-cols-2">
                <div class="card-lift rounded-3xl border border-navy-100 bg-gradient-to-br from-navy-50/60 to-white p-8 sm:p-10 shadow-sm">
                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-navy-900 text-gold-300 shadow">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <h3 class="mt-6 font-serif text-xl font-bold text-navy-950">Academic & Cultural Legacy</h3>
                    <p class="mt-3 text-sm leading-relaxed text-ink-soft">
                        Rooted in Kabi Nazrul Government College's founding in 1874, membership in the Association preserves our shared love of language, literature, and educational excellence. Members actively support departmental lectures, journals, and literary festivals.
                    </p>
                </div>

                <div class="card-lift rounded-3xl border border-navy-100 bg-gradient-to-br from-maroon-50/60 to-white p-8 sm:p-10 shadow-sm">
                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-maroon-700 text-gold-300 shadow">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.4-1.7M9 20H4v-2a3 3 0 015.4-1.7M16 3.1a3 3 0 110 5.8M11 7a3 3 0 11-6 0 3 3 0 016 0zm5 7.5a3 3 0 10-6 0" />
                        </svg>
                    </div>
                    <h3 class="mt-6 font-serif text-xl font-bold text-navy-950">Lifelong Welfare & Networking</h3>
                    <p class="mt-3 text-sm leading-relaxed text-ink-soft">
                        Enjoy mutual welfare support, professional networking spanning diverse fields (academics, civil service, media, enterprise), and a platform to give back to current students through mentorship and scholarships.
                    </p>
                </div>
            </div>
        </div>
    </section>

    
    <?php if($membershipTypes->isNotEmpty()): ?>
        <section class="bg-cream py-16 sm:py-20 lg:py-24 border-y border-navy-100">
            <div class="container-page">
                <?php if (isset($component)) { $__componentOriginal755230460fd16c04121658d92fbf99f7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal755230460fd16c04121658d92fbf99f7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.section-heading','data' => ['eyebrow' => 'Categories','title' => 'Membership Categories','description' => 'Choose the membership category that best corresponds with your departmental graduation.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('section-heading'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['eyebrow' => 'Categories','title' => 'Membership Categories','description' => 'Choose the membership category that best corresponds with your departmental graduation.']); ?>
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

                <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    <?php $__currentLoopData = $membershipTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="card-lift shine group relative flex flex-col justify-between overflow-hidden rounded-3xl border border-navy-100 bg-white/95 p-8 shadow-sm backdrop-blur-md transition-all duration-300 hover:border-gold-400/60 hover:shadow-xl">
                            <div class="h-1.5 w-12 rounded-full bg-gold-400 mb-6 transition-all group-hover:w-20"></div>
                            <div>
                                <h3 class="font-serif text-2xl font-bold text-navy-950 transition-colors group-hover:text-maroon-700"><?php echo e($type->name); ?></h3>
                                <?php if($type->description): ?>
                                    <p class="mt-3 text-sm leading-relaxed text-ink-soft"><?php echo e($type->description); ?></p>
                                <?php endif; ?>
                            </div>
                            <div class="mt-8 border-t border-navy-50 pt-5">
                                <a href="<?php echo e(route('membership.apply')); ?>" class="focus-ring inline-flex items-center gap-1.5 text-xs font-bold uppercase tracking-wider text-maroon-700 transition-colors hover:text-maroon-900">
                                    Apply for this category &rarr;
                                </a>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    
    <?php if($membershipTiers->isNotEmpty()): ?>
        <section class="section-pad bg-white">
            <div class="container-page">
                <?php if (isset($component)) { $__componentOriginal755230460fd16c04121658d92fbf99f7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal755230460fd16c04121658d92fbf99f7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.section-heading','data' => ['eyebrow' => 'Levels','title' => 'Membership Recognition Tiers','description' => 'Tiers reflect levels of ongoing engagement, voluntary contributions, and distinction within the Association.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('section-heading'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['eyebrow' => 'Levels','title' => 'Membership Recognition Tiers','description' => 'Tiers reflect levels of ongoing engagement, voluntary contributions, and distinction within the Association.']); ?>
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

                <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    <?php $__currentLoopData = $membershipTiers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="card-lift group relative flex items-start gap-4 rounded-3xl border border-navy-100 bg-white p-7 shadow-sm transition-all duration-300 hover:border-gold-400/60 hover:shadow-xl">
                            <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-gradient-to-br from-navy-950 to-navy-800 font-serif text-base font-bold text-gold-300 shadow ring-1 ring-gold-500/30">
                                <?php echo e(strtoupper(substr($tier->name, 0, 2))); ?>

                            </span>
                            <div class="min-w-0 flex-1">
                                <h3 class="font-serif text-lg font-bold text-navy-950"><?php echo e($tier->name); ?></h3>
                                <?php if($tier->badge_label): ?>
                                    <span class="mt-1 inline-block rounded-full bg-gold-50 px-2.5 py-0.5 text-[10px] font-bold uppercase tracking-wider text-gold-700 border border-gold-300">
                                        <?php echo e($tier->badge_label); ?>

                                    </span>
                                <?php endif; ?>
                                <?php if($tier->description): ?>
                                    <p class="mt-2.5 text-xs leading-relaxed text-ink-soft"><?php echo e($tier->description); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    
    <section class="bg-gradient-to-b from-navy-950 via-navy-900 to-navy-950 py-20 text-white sm:py-28 relative overflow-hidden">
        <div class="pointer-events-none absolute inset-0 opacity-10" aria-hidden="true">
            <div class="absolute -right-32 -top-32 h-96 w-96 rounded-full bg-gold-400 blur-3xl"></div>
            <div class="absolute -left-32 -bottom-32 h-96 w-96 rounded-full bg-maroon-500 blur-3xl"></div>
        </div>

        <div class="container-page relative">
            <div class="text-center max-w-2xl mx-auto">
                <span class="inline-flex items-center gap-2 rounded-full border border-gold-400/30 bg-gold-500/10 px-4 py-1 text-xs font-bold uppercase tracking-[0.2em] text-gold-300">
                    Simple Process
                </span>
                <h2 class="mt-4 font-serif text-3xl sm:text-4xl lg:text-5xl font-bold tracking-tight">
                    How to <span class="italic text-gold-300">Become a Member</span>
                </h2>
                <p class="mt-4 text-base text-navy-200">
                    The registration procedure is streamlined and transparent. Follow these 4 straightforward steps to activate your membership.
                </p>
            </div>

            <div class="mt-16 grid gap-8 sm:grid-cols-2 lg:grid-cols-4 relative">
                <?php $__currentLoopData = [
                    ['step' => '01', 'title' => 'Learn & Prepare', 'description' => 'Review the membership categories and prepare your academic background details.'],
                    ['step' => '02', 'title' => 'Submit Application', 'description' => 'Fill out our secure online form with your personal, contact, and graduation info.'],
                    ['step' => '03', 'title' => 'Committee Review', 'description' => 'The Executive Committee verifies records. You can track your status live online.'],
                    ['step' => '04', 'title' => 'Access Portal', 'description' => 'Upon approval, receive your digital ID card, directory badge, and portal access.'],
                ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="relative rounded-2xl border border-white/10 bg-white/5 p-6 backdrop-blur-md transition-all duration-300 hover:bg-white/10 hover:border-gold-400/40">
                        <span class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-gold-400 to-gold-600 font-serif text-lg font-bold text-navy-950 shadow-lg shadow-gold-500/20">
                            <?php echo e($item['step']); ?>

                        </span>
                        <h3 class="mt-5 font-serif text-lg font-bold text-white"><?php echo e($item['title']); ?></h3>
                        <p class="mt-2 text-xs leading-relaxed text-navy-200"><?php echo e($item['description']); ?></p>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <div class="mt-14 text-center flex flex-col sm:flex-row items-center justify-center gap-4">
                <?php if (isset($component)) { $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.button','data' => ['href' => ''.e(route('membership.apply')).'','variant' => 'gold','size' => 'lg','icon' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => ''.e(route('membership.apply')).'','variant' => 'gold','size' => 'lg','icon' => true]); ?>
                    Start Membership Application
                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561)): ?>
<?php $attributes = $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561; ?>
<?php unset($__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald0f1fd2689e4bb7060122a5b91fe8561)): ?>
<?php $component = $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561; ?>
<?php unset($__componentOriginald0f1fd2689e4bb7060122a5b91fe8561); ?>
<?php endif; ?>
                <a href="<?php echo e(route('member.login')); ?>" class="focus-ring inline-flex items-center gap-2 rounded-xl border border-white/20 bg-white/5 px-6 py-3.5 text-sm font-semibold text-white transition-colors hover:bg-white/10 hover:border-gold-400">
                    Existing Member Login
                </a>
            </div>
        </div>
    </section>

    
    <section class="bg-cream py-16 sm:py-20">
        <div class="container-page">
            <div class="mx-auto max-w-3xl rounded-3xl border border-navy-100 bg-white p-8 sm:p-12 shadow-sm">
                <div class="flex items-center gap-3 mb-6">
                    <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-navy-100 text-navy-900">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </span>
                    <h3 class="font-serif text-xl font-bold text-navy-950">Your Information & Privacy</h3>
                </div>
                <div class="space-y-4 text-sm leading-relaxed text-ink-soft">
                    <p>
                        Your privacy is paramount. Information submitted in your membership application is used exclusively by the EDAA-KNGC Executive Committee for verification and Association welfare purposes.
                    </p>
                    <p>
                        Members maintain full control over their public alumni directory visibility through their Member Portal settings. Contact details, national identification, and administrative audit records are strictly confidential and never shared publicly.
                    </p>
                </div>
            </div>
        </div>
    </section>

    
    <section class="section-pad bg-white">
        <div class="container-page">
            <div class="rounded-3xl bg-gradient-to-br from-navy-950 via-navy-900 to-maroon-950 p-10 text-white sm:p-14 shadow-2xl">
                <div class="grid items-center gap-8 lg:grid-cols-2">
                    <div>
                        <?php if (isset($component)) { $__componentOriginal755230460fd16c04121658d92fbf99f7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal755230460fd16c04121658d92fbf99f7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.section-heading','data' => ['eyebrow' => 'Directory','title' => 'Meet Our Members','description' => 'Explore our community of verified graduates, educators, and scholars across batches and professions.','dark' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('section-heading'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['eyebrow' => 'Directory','title' => 'Meet Our Members','description' => 'Explore our community of verified graduates, educators, and scholars across batches and professions.','dark' => true]); ?>
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
                    </div>
                    <div class="lg:justify-self-end">
                        <?php if (isset($component)) { $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.button','data' => ['href' => ''.e(route('members.index')).'','variant' => 'gold','size' => 'lg','icon' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => ''.e(route('members.index')).'','variant' => 'gold','size' => 'lg','icon' => true]); ?>
                            View Member Directory
                         <?php echo $__env->renderComponent(); ?>
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
<?php /**PATH C:\xampp\htdocs\ProDo\EDAA\resources\views\pages\membership.blade.php ENDPATH**/ ?>