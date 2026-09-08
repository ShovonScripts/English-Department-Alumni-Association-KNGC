<?php if (isset($component)) { $__componentOriginal5863877a5171c196453bfa0bd807e410 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5863877a5171c196453bfa0bd807e410 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.app','data' => ['title' => 'Home','description' => 'The English Department Alumni Association KNGC connects graduates, students, and teachers through a shared love of language, literature, and lifelong community.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.app'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Home'),'description' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('The English Department Alumni Association KNGC connects graduates, students, and teachers through a shared love of language, literature, and lifelong community.')]); ?>

    
    <section class="relative overflow-hidden bg-navy-950 text-white">
        <div class="pointer-events-none absolute inset-0 hero-gradient-mesh" aria-hidden="true">
            <div class="absolute -right-32 -top-32 h-[30rem] w-[30rem] rounded-full bg-gold-400 bg-ambient-orb"></div>
            <div class="absolute -left-24 bottom-0 h-96 w-96 rounded-full bg-maroon-600 bg-ambient-orb" style="animation-delay: -5s;"></div>
            <div class="absolute bottom-24 left-1/3 h-52 w-52 rounded-full bg-navy-500 bg-ambient-orb" style="animation-delay: -10s;"></div>
        </div>

        <div class="container-page relative grid items-center gap-12 py-16 sm:py-24 lg:grid-cols-12 lg:py-32">
            <div class="lg:col-span-7 xl:col-span-8">
                <div class="mb-5 inline-flex items-center gap-2 rounded-full border border-gold-400/30 bg-gold-500/10 px-3.5 py-1.5 text-xs font-semibold uppercase tracking-[0.2em] text-gold-300 backdrop-blur-sm">
                    <span class="h-2 w-2 rounded-full bg-gold-400 animate-pulse"></span>
                    <?php echo e(config('site.name')); ?>

                </div>

                <h1 x-data="{ shown: false }" x-intersect.once="shown = true" :class="shown ? 'aos-animate' : ''" class="aos-init aos-fade-up font-serif text-4xl font-semibold leading-[1.08] tracking-tight sm:text-6xl lg:text-7xl">
                    Connected by English.<br>
                    <span class="italic bg-gradient-to-r from-gold-200 via-gold-300 to-gold-400 bg-clip-text text-transparent">United by Memories.</span>
                </h1>

                <p x-data="{ shown: false }" x-intersect.once="shown = true" :class="shown ? 'aos-animate' : ''" class="aos-init aos-fade-up aos-delay-200 mt-6 max-w-2xl text-base leading-relaxed text-navy-100 sm:text-lg">
                    The <?php echo e(config('site.name')); ?> unites graduates, students, and teachers of the English Department of Kabi Nazrul Government College, Dhaka — a lifelong sanctuary built on language, literature, and fellowship since 1874.
                </p>

                
                <div x-data="{ shown: false }" x-intersect.once="shown = true" :class="shown ? 'aos-animate' : ''" class="aos-init aos-fade-up aos-delay-300 mt-8 max-w-xl">
                    <form action="<?php echo e(route('alumni.index')); ?>" method="GET" class="relative flex items-center rounded-2xl border border-white/20 bg-white/10 p-1.5 shadow-2xl backdrop-blur-xl transition-all focus-within:border-gold-400 focus-within:bg-white/15 focus-within:ring-2 focus-within:ring-gold-500/30">
                        <div class="pointer-events-none pl-3 text-gold-300">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input
                            type="search"
                            name="search"
                            placeholder="Search alumni by name, batch, designation..."
                            class="w-full bg-transparent px-3 py-2 text-sm text-white placeholder-navy-200 focus:outline-none"
                        />
                        <button type="submit" class="shrink-0 rounded-xl bg-gradient-to-r from-gold-500 to-gold-600 px-4 py-2 text-xs font-bold text-navy-950 shadow-md transition-all hover:from-gold-400 hover:to-gold-500 hover:shadow-lg">
                            Search
                        </button>
                    </form>
                    <div class="mt-3 flex flex-wrap items-center gap-2 text-xs text-navy-200">
                        <span class="font-medium text-gold-300">Quick explore:</span>
                        <a href="<?php echo e(route('alumni.index')); ?>" class="rounded-full bg-white/10 px-2.5 py-0.5 transition-colors hover:bg-gold-500/20 hover:text-gold-200">All Alumni</a>
                        <a href="<?php echo e(route('members.index')); ?>" class="rounded-full bg-white/10 px-2.5 py-0.5 transition-colors hover:bg-gold-500/20 hover:text-gold-200">Verified Members</a>
                        <a href="<?php echo e(route('membership.apply')); ?>" class="rounded-full bg-maroon-600/60 px-2.5 py-0.5 text-white transition-colors hover:bg-maroon-600">Join EDAA</a>
                    </div>
                </div>

                <div x-data="{ shown: false }" x-intersect.once="shown = true" :class="shown ? 'aos-animate' : ''" class="aos-init aos-fade-up aos-delay-400 mt-8 flex flex-col gap-3 sm:flex-row">
                    <?php if (isset($component)) { $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.button','data' => ['href' => ''.e(route('alumni.index')).'','variant' => 'gold','size' => 'lg','icon' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => ''.e(route('alumni.index')).'','variant' => 'gold','size' => 'lg','icon' => true]); ?>
                        Explore Directory
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
                    <?php if (isset($component)) { $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.button','data' => ['href' => ''.e(route('about')).'','variant' => 'outline-on-dark','size' => 'lg']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => ''.e(route('about')).'','variant' => 'outline-on-dark','size' => 'lg']); ?>
                        About the Association
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

            
            <div x-data="{ shown: false }" x-intersect.once="shown = true" :class="shown ? 'aos-animate' : ''" class="aos-init aos-fade-right aos-delay-500 hidden lg:col-span-5 xl:col-span-4 lg:block">
                <div class="relative mx-auto max-w-sm">
                    
                    <div class="absolute -left-6 -top-4 z-20 flex items-center gap-2 rounded-xl border border-white/20 bg-navy-900/90 px-3.5 py-2 shadow-xl backdrop-blur-md">
                        <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-gold-500/20 text-gold-300">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </span>
                        <div>
                            <p class="text-[10px] uppercase font-bold tracking-wider text-navy-300">Campus Legacy</p>
                            <p class="text-xs font-semibold text-white">Est. 1874 Heritage</p>
                        </div>
                    </div>

                    
                    <div class="relative overflow-hidden rounded-3xl border border-white/20 bg-white/10 p-10 text-center shadow-2xl backdrop-blur-xl">
                        <div class="absolute inset-0 bg-gradient-to-b from-white/10 via-transparent to-black/20 pointer-events-none"></div>
                        <?php
                            $logoLight = \App\Models\SiteSetting::get('logo_light_path');
                        ?>
                        <?php if($logoLight): ?>
                            <img src="<?php echo e(Storage::disk('public')->url($logoLight)); ?>" alt="<?php echo e(config('site.short_name')); ?>" class="mx-auto h-28 w-auto object-contain drop-shadow-md">
                        <?php else: ?>
                            <span class="mx-auto flex h-24 w-24 items-center justify-center rounded-2xl bg-gradient-to-br from-maroon-700 to-maroon-900 font-serif text-2xl font-bold tracking-wider text-white shadow-xl ring-2 ring-gold-500/60">
                                KNGC
                            </span>
                        <?php endif; ?>
                        <p class="mt-6 font-serif text-2xl italic font-semibold text-gold-300">Est. 2017</p>
                        <p class="mt-2 text-xs uppercase tracking-[0.25em] font-semibold text-navy-200">English Dept. Alumni</p>
                        <div class="mt-6 border-t border-white/10 pt-4">
                            <span class="inline-flex items-center gap-1.5 text-xs text-gold-200 font-medium">
                                <svg class="h-3.5 w-3.5 text-gold-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd"/>
                                </svg>
                                Non-Political &bull; Non-Profit
                            </span>
                        </div>
                    </div>

                    
                    <div class="absolute -bottom-4 -right-4 z-20 flex items-center gap-2 rounded-xl border border-white/20 bg-navy-900/90 px-3.5 py-2 shadow-xl backdrop-blur-md">
                        <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-maroon-500/20 text-maroon-300">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.4-1.7M9 20H4v-2a3 3 0 015.4-1.7M16 3.1a3 3 0 110 5.8M11 7a3 3 0 11-6 0 3 3 0 016 0zm5 7.5a3 3 0 10-6 0" />
                            </svg>
                        </span>
                        <div>
                            <p class="text-[10px] uppercase font-bold tracking-wider text-navy-300">Global Network</p>
                            <p class="text-xs font-semibold text-white">Active Community</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    
    <?php if($facebookGroupUrl && $sliderImages->isNotEmpty()): ?>
    <section class="relative overflow-hidden bg-gradient-to-br from-[#1877F2] via-[#0D47A1] to-[#0A2463] py-16 text-white sm:py-20">
        <div class="pointer-events-none absolute inset-0 opacity-10" aria-hidden="true">
            <div class="absolute -right-20 -top-20 h-80 w-80 rounded-full border-2 border-white"></div>
            <div class="absolute bottom-0 left-1/4 h-48 w-48 rounded-full border border-white/50"></div>
        </div>

        <div class="container-page relative">
            <div class="grid items-center gap-12 lg:grid-cols-2">
                
                <div x-data="{ shown: false }" x-intersect.once="shown = true" :class="shown ? 'aos-animate' : ''" class="aos-init aos-fade-up">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="flex h-12 w-12 items-center justify-center rounded-full bg-white/20">
                            <svg class="h-6 w-6 text-white" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </div>
                        <span class="text-sm font-semibold uppercase tracking-wider text-white/80">Join Our Community</span>
                    </div>

                    <h2 class="font-serif text-3xl font-semibold leading-tight sm:text-4xl lg:text-5xl">
                        Join Our Facebook Group
                    </h2>

                    <p class="mt-4 max-w-lg text-base leading-relaxed text-white/80 sm:text-lg">
                        Connect with fellow alumni, share memories, stay updated on events, and be part of the conversation. Our Facebook group is where the EDAA community comes together.
                    </p>

                    <div class="mt-8 flex flex-col gap-4 sm:flex-row">
                        <a
                            href="<?php echo e($facebookGroupUrl); ?>"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="focus-ring inline-flex items-center justify-center gap-2 rounded-lg bg-white px-6 py-3 text-base font-semibold text-[#1877F2] shadow-lg transition-all hover:bg-white/90 hover:shadow-xl"
                        >
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                            Join Now
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                            </svg>
                        </a>
                        <div class="flex items-center gap-2 text-sm text-white/70">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.4-1.7M9 20H4v-2a3 3 0 015.4-1.7M16 3.1a3 3 0 110 5.8M11 7a3 3 0 11-6 0 3 3 0 016 0zm5 7.5a3 3 0 10-6 0" />
                            </svg>
                            <span>Free to join · 100% community-driven</span>
                        </div>
                    </div>
                </div>

                
                <div
                    x-data="{
                        shown: false,
                        current: 0,
                        total: <?php echo e($sliderImages->count()); ?>,
                        autoPlay: null,
                        startAutoPlay() {
                            this.autoPlay = setInterval(() => { this.current = (this.current + 1) % this.total }, 4000);
                        },
                        resetAutoPlay() {
                            clearInterval(this.autoPlay);
                            this.startAutoPlay();
                        }
                    }"
                    x-init="startAutoPlay(); $watch('current', () => resetAutoPlay())"
                    x-intersect.once="shown = true"
                    :class="shown ? 'aos-animate' : ''"
                    class="aos-init aos-fade-right aos-delay-300"
                >
                    <div class="relative overflow-hidden rounded-2xl bg-white/10 p-4 backdrop-blur-sm shadow-2xl">
                        
                        <div class="relative aspect-[16/9] overflow-hidden rounded-xl">
                            <?php $__currentLoopData = $sliderImages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <img
                                src="<?php echo e($image->image_url); ?>"
                                alt="<?php echo e($image->alt_text); ?>"
                                class="absolute inset-0 h-full w-full object-cover transition-all duration-700 ease-in-out"
                                :class="current === <?php echo e($index); ?> ? 'opacity-100 scale-100' : 'opacity-0 scale-105'"
                                x-show="current === <?php echo e($index); ?>"
                                x-transition:enter="transition ease-out duration-700"
                                x-transition:enter-start="opacity-0 scale-105"
                                x-transition:enter-end="opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-500"
                                x-transition:leave-start="opacity-100 scale-100"
                                x-transition:leave-end="opacity-0 scale-105"
                            >
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>

                        
                        <?php if($sliderImages->count() > 1): ?>
                        <div class="flex items-center justify-center gap-2 mt-4">
                            <?php $__currentLoopData = $sliderImages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <button
                                type="button"
                                @click="current = <?php echo e($index); ?>"
                                :class="current === <?php echo e($index); ?> ? 'bg-white w-6' : 'bg-white/40 hover:bg-white/60'"
                                class="h-2 rounded-full transition-all duration-300"
                                aria-label="Go to slide <?php echo e($index + 1); ?>"
                            ></button>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>

    
    <section class="section-pad bg-white">
        <div class="container-page grid items-center gap-12 lg:grid-cols-2 lg:gap-16">
            <div>
                <div x-data="{ shown: false }" x-intersect.once="shown = true" :class="shown ? 'aos-animate' : ''" class="aos-init aos-fade-up"><?php if (isset($component)) { $__componentOriginal755230460fd16c04121658d92fbf99f7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal755230460fd16c04121658d92fbf99f7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.section-heading','data' => ['eyebrow' => 'About the Association','title' => 'A lifelong home for lovers of language and literature','description' => 'Rooted in an institution that has served learners in Laxmi Bazar since 1874, the English Department Alumni Association KNGC unites graduates in a non-political, non-profit community. We support current students, organise cultural and humanitarian activities, and nurture a professional network that spans classrooms, careers, and continents.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('section-heading'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['eyebrow' => 'About the Association','title' => 'A lifelong home for lovers of language and literature','description' => 'Rooted in an institution that has served learners in Laxmi Bazar since 1874, the English Department Alumni Association KNGC unites graduates in a non-political, non-profit community. We support current students, organise cultural and humanitarian activities, and nurture a professional network that spans classrooms, careers, and continents.']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal755230460fd16c04121658d92fbf99f7)): ?>
<?php $attributes = $__attributesOriginal755230460fd16c04121658d92fbf99f7; ?>
<?php unset($__attributesOriginal755230460fd16c04121658d92fbf99f7); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal755230460fd16c04121658d92fbf99f7)): ?>
<?php $component = $__componentOriginal755230460fd16c04121658d92fbf99f7; ?>
<?php unset($__componentOriginal755230460fd16c04121658d92fbf99f7); ?>
<?php endif; ?></div>

                <ul class="mt-8 space-y-4">
                    <?php $__currentLoopData = [
                    ['icon' => 'M17 20h5v-2a3 3 0 00-5.4-1.7M9 20H4v-2a3 3 0 015.4-1.7M16 3.1a3 3 0 110 5.8M11 7a3 3 0 11-6 0 3 3 0 016 0z', 'text' => 'Fostering lifelong connections between alumni, students, and faculty.'],
                    ['icon' => 'M12 6.3v11.4m0-11.4A3.2 3.2 0 009.5 3.5H6.5v13h3a3.2 3.2 0 013 2.8m-.5-12.9a3.2 3.2 0 012.5-2.8h3v13h-3a3.2 3.2 0 00-3 2.8m0-12.9v11.4', 'text' => 'Celebrating scholarship, mentorship, and the written word.'],
                    ['icon' => 'M17 20h5v-2a3 3 0 00-3-3 3 3 0 00-1 .17M14 20H9m5-13a3 3 0 11-6 0 3 3 0 016 0zm5 7.5a3 3 0 10-6 0', 'text' => 'Building a professional network that supports careers and community.'],
                    ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="flex items-start gap-4">
                        <span class="mt-0.5 flex h-10 w-10 shrink-0 items-center justify-center rounded-md bg-navy-900 text-gold-300">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="<?php echo e($item['icon']); ?>" />
                            </svg>
                        </span>
                        <p class="text-base leading-relaxed text-ink-soft"><?php echo e($item['text']); ?></p>
                    </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>

                <div class="mt-9">
                    <?php if (isset($component)) { $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.button','data' => ['href' => ''.e(route('about')).'','variant' => 'outline','icon' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => ''.e(route('about')).'','variant' => 'outline','icon' => true]); ?>More About Us <?php echo $__env->renderComponent(); ?>
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

            <div class="relative" x-data="{
                current: 0,
                total: <?php echo e($testimonials->count()); ?>,
                autoPlay: null,
                startAutoPlay() {
                    this.autoPlay = setInterval(() => { this.current = (this.current + 1) % this.total }, 5000);
                },
                resetAutoPlay() {
                    clearInterval(this.autoPlay);
                    this.startAutoPlay();
                }
            }" x-init="if (total > 0) startAutoPlay(); $watch('current', () => resetAutoPlay())">
                <div class="absolute -left-6 -top-6 hidden h-40 w-40 rounded-lg border-2 border-gold-400/40 sm:block" aria-hidden="true"></div>
                <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-navy-800/80 via-navy-900/80 to-maroon-900/80 p-10 backdrop-blur-md shadow-2xl shadow-navy-950/30 sm:p-14">
                    <?php if($testimonials->isNotEmpty()): ?>
                    <div class="flex h-full flex-col justify-between gap-10">
                        <div>
                            <p class="font-serif text-5xl italic leading-tight text-white sm:text-6xl">"</p>
                            <?php $__currentLoopData = $testimonials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <blockquote
                                class="mt-4 font-serif text-2xl italic leading-snug text-navy-100 sm:text-3xl"
                                x-show="current === <?php echo e($index); ?>"
                                x-transition:enter="transition ease-out duration-500"
                                x-transition:enter-start="opacity-0 translate-x-4"
                                x-transition:enter-end="opacity-100 translate-x-0"
                                x-transition:leave="transition ease-in duration-300"
                                x-transition:leave-start="opacity-100"
                                x-transition:leave-end="opacity-0"
                            >
                                <?php echo e($t->quote); ?>

                            </blockquote>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        <div class="flex items-center justify-between">
                            <div>
                                <?php $__currentLoopData = $testimonials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div x-show="current === <?php echo e($index); ?>" x-transition>
                                    <div class="flex items-center gap-4">
                                        <?php if($t->image_url): ?>
                                            <img src="<?php echo e($t->image_url); ?>" alt="<?php echo e($t->author_name); ?>" class="h-14 w-14 rounded-full object-cover ring-2 ring-gold-500/40">
                                        <?php else: ?>
                                            <span class="flex h-14 w-14 shrink-0 items-center justify-center rounded-full bg-maroon-700 font-serif text-base font-semibold text-white ring-2 ring-gold-500/40">
                                                <?php echo e(\Illuminate\Support\Str::initials($t->author_name)); ?>

                                            </span>
                                        <?php endif; ?>
                                        <div>
                                            <p class="font-semibold text-gold-300"><?php echo e($t->author_name); ?></p>
                                            <p class="mt-1 text-sm text-navy-200">
                                                <?php if($t->author_title): ?><?php echo e($t->author_title); ?><?php endif; ?>
                                                <?php if($t->author_title && $t->author_batch): ?> · <?php endif; ?>
                                                <?php if($t->author_batch): ?><?php echo e($t->author_batch); ?><?php endif; ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>

                            
                            <?php if($testimonials->count() > 1): ?>
                            <div class="flex items-center gap-2">
                                <?php $__currentLoopData = $testimonials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <button
                                    type="button"
                                    @click="current = <?php echo e($index); ?>"
                                    :class="current === <?php echo e($index); ?> ? 'bg-gold-400 w-6' : 'bg-white/30 hover:bg-white/50'"
                                    class="h-2 rounded-full transition-all duration-300"
                                    aria-label="Go to slide <?php echo e($index + 1); ?>"
                                ></button>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php else: ?>
                    <div class="flex h-full flex-col justify-between gap-10">
                        <div>
                            <p class="font-serif text-5xl italic leading-tight text-white sm:text-6xl">"</p>
                            <blockquote class="mt-4 font-serif text-2xl italic leading-snug text-navy-100 sm:text-3xl">
                                The Department shaped our minds; the Association keeps our hearts together.
                            </blockquote>
                        </div>
                        <div>
                            <p class="font-semibold text-gold-300">Professor Milki Amatul Mogni</p>
                            <p class="mt-1 text-sm text-navy-200">Past President, EDAA · Class of 1987</p>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    
    <section class="bg-gradient-to-b from-cream via-white to-cream py-16 sm:py-20 border-y border-navy-100/60">
        <div class="container-page">
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                <?php if (isset($component)) { $__componentOriginal3b387acd2c997737a257e1ec014549fd = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3b387acd2c997737a257e1ec014549fd = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.stat','data' => ['value' => '1874','label' => 'Institution Established','accent' => true,'icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('stat'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['value' => '1874','label' => 'Institution Established','accent' => true,'icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3b387acd2c997737a257e1ec014549fd)): ?>
<?php $attributes = $__attributesOriginal3b387acd2c997737a257e1ec014549fd; ?>
<?php unset($__attributesOriginal3b387acd2c997737a257e1ec014549fd); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3b387acd2c997737a257e1ec014549fd)): ?>
<?php $component = $__componentOriginal3b387acd2c997737a257e1ec014549fd; ?>
<?php unset($__componentOriginal3b387acd2c997737a257e1ec014549fd); ?>
<?php endif; ?>
                <?php if (isset($component)) { $__componentOriginal3b387acd2c997737a257e1ec014549fd = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3b387acd2c997737a257e1ec014549fd = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.stat','data' => ['value' => '150+','label' => 'Years of Heritage','icon' => 'M12 14l9-5-9-5-9 5 9 5z M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('stat'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['value' => '150+','label' => 'Years of Heritage','icon' => 'M12 14l9-5-9-5-9 5 9 5z M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3b387acd2c997737a257e1ec014549fd)): ?>
<?php $attributes = $__attributesOriginal3b387acd2c997737a257e1ec014549fd; ?>
<?php unset($__attributesOriginal3b387acd2c997737a257e1ec014549fd); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3b387acd2c997737a257e1ec014549fd)): ?>
<?php $component = $__componentOriginal3b387acd2c997737a257e1ec014549fd; ?>
<?php unset($__componentOriginal3b387acd2c997737a257e1ec014549fd); ?>
<?php endif; ?>
                <?php if (isset($component)) { $__componentOriginal3b387acd2c997737a257e1ec014549fd = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3b387acd2c997737a257e1ec014549fd = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.stat','data' => ['value' => '3','label' => 'Membership Tiers','icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('stat'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['value' => '3','label' => 'Membership Tiers','icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3b387acd2c997737a257e1ec014549fd)): ?>
<?php $attributes = $__attributesOriginal3b387acd2c997737a257e1ec014549fd; ?>
<?php unset($__attributesOriginal3b387acd2c997737a257e1ec014549fd); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3b387acd2c997737a257e1ec014549fd)): ?>
<?php $component = $__componentOriginal3b387acd2c997737a257e1ec014549fd; ?>
<?php unset($__componentOriginal3b387acd2c997737a257e1ec014549fd); ?>
<?php endif; ?>
                <?php if (isset($component)) { $__componentOriginal3b387acd2c997737a257e1ec014549fd = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3b387acd2c997737a257e1ec014549fd = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.stat','data' => ['value' => '21+','label' => 'Executive Leaders','icon' => 'M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('stat'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['value' => '21+','label' => 'Executive Leaders','icon' => 'M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3b387acd2c997737a257e1ec014549fd)): ?>
<?php $attributes = $__attributesOriginal3b387acd2c997737a257e1ec014549fd; ?>
<?php unset($__attributesOriginal3b387acd2c997737a257e1ec014549fd); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3b387acd2c997737a257e1ec014549fd)): ?>
<?php $component = $__componentOriginal3b387acd2c997737a257e1ec014549fd; ?>
<?php unset($__componentOriginal3b387acd2c997737a257e1ec014549fd); ?>
<?php endif; ?>
            </div>
        </div>
    </section>

    
    <?php if($committeeMembers->isNotEmpty()): ?>
    <section class="section-pad bg-white">
        <div class="container-page">
            <div class="flex flex-col items-start justify-between gap-6 sm:flex-row sm:items-end">
                <div x-data="{ shown: false }" x-intersect.once="shown = true" :class="shown ? 'aos-animate' : ''" class="aos-init aos-fade-up"><?php if (isset($component)) { $__componentOriginal755230460fd16c04121658d92fbf99f7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal755230460fd16c04121658d92fbf99f7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.section-heading','data' => ['eyebrow' => 'Leadership','title' => 'Meet the executive committee','description' => 'The volunteers who guide our community and keep the association running.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('section-heading'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['eyebrow' => 'Leadership','title' => 'Meet the executive committee','description' => 'The volunteers who guide our community and keep the association running.']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal755230460fd16c04121658d92fbf99f7)): ?>
<?php $attributes = $__attributesOriginal755230460fd16c04121658d92fbf99f7; ?>
<?php unset($__attributesOriginal755230460fd16c04121658d92fbf99f7); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal755230460fd16c04121658d92fbf99f7)): ?>
<?php $component = $__componentOriginal755230460fd16c04121658d92fbf99f7; ?>
<?php unset($__componentOriginal755230460fd16c04121658d92fbf99f7); ?>
<?php endif; ?></div>
                <?php if (isset($component)) { $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.button','data' => ['href' => ''.e(route('committees.index')).'','variant' => 'outline']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => ''.e(route('committees.index')).'','variant' => 'outline']); ?>View Full Committee <?php echo $__env->renderComponent(); ?>
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

            <div x-data="{ shown: false }" x-intersect.once="shown = true" :class="shown ? 'aos-animate' : ''" class="aos-init aos-fade-up aos-delay-200 mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                <?php $__currentLoopData = $committeeMembers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <article class="card-lift shine glow-top flex h-full flex-col rounded-xl border border-white/20 bg-white/80 p-8 shadow-sm backdrop-blur-sm transition-colors group-hover:border-gold-500/40">
                    <div class="flex items-center gap-5">
                        <?php if($member->alumni?->profile_photo_url): ?>
                        <img src="<?php echo e($member->alumni->profile_photo_url); ?>" alt="<?php echo e($member->alumni?->full_name); ?>" class="h-14 w-14 rounded-full object-cover ring-2 ring-gold-500/40">
                        <?php else: ?>
                        <span class="flex h-14 w-14 shrink-0 items-center justify-center rounded-full bg-maroon-700 font-serif text-base font-semibold text-white" aria-hidden="true">
                            <?php echo e(\Illuminate\Support\Str::initials($member->alumni?->full_name ?? '')); ?>

                        </span>
                        <?php endif; ?>
                        <div>
                            <h3 class="font-serif text-lg font-semibold text-navy-950"><?php echo e($member->alumni?->full_name ?? 'Unknown'); ?></h3>
                            <p class="text-sm font-medium uppercase tracking-wide text-maroon-600"><?php echo e($member->pivot_committee_role_id ? \App\Models\CommitteeRole::find($member->pivot_committee_role_id)?->name : ''); ?></p>
                        </div>
                    </div>
                </article>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    
    <section class="section-pad bg-white">
        <div class="container-page">
            <div class="flex flex-col items-start justify-between gap-6 sm:flex-row sm:items-end">
                <div x-data="{ shown: false }" x-intersect.once="shown = true" :class="shown ? 'aos-animate' : ''" class="aos-init aos-fade-up"><?php if (isset($component)) { $__componentOriginal755230460fd16c04121658d92fbf99f7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal755230460fd16c04121658d92fbf99f7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.section-heading','data' => ['eyebrow' => 'Upcoming Events','title' => 'What\'s happening in our community','description' => 'Lectures, reunions, and literary evenings — there is always a reason to come home.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('section-heading'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['eyebrow' => 'Upcoming Events','title' => 'What\'s happening in our community','description' => 'Lectures, reunions, and literary evenings — there is always a reason to come home.']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal755230460fd16c04121658d92fbf99f7)): ?>
<?php $attributes = $__attributesOriginal755230460fd16c04121658d92fbf99f7; ?>
<?php unset($__attributesOriginal755230460fd16c04121658d92fbf99f7); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal755230460fd16c04121658d92fbf99f7)): ?>
<?php $component = $__componentOriginal755230460fd16c04121658d92fbf99f7; ?>
<?php unset($__componentOriginal755230460fd16c04121658d92fbf99f7); ?>
<?php endif; ?></div>
                <?php if (isset($component)) { $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.button','data' => ['href' => ''.e(route('events.index')).'','variant' => 'outline']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => ''.e(route('events.index')).'','variant' => 'outline']); ?>View All Events <?php echo $__env->renderComponent(); ?>
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

            <?php if($upcomingEvents->isNotEmpty()): ?>
            <div x-data="{ shown: false }" x-intersect.once="shown = true" :class="shown ? 'aos-animate' : ''" class="aos-init aos-fade-up aos-delay-200 mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                <?php $__currentLoopData = $upcomingEvents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if (isset($component)) { $__componentOriginal07bdbe031a4c57e4cd3488994f94e999 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal07bdbe031a4c57e4cd3488994f94e999 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.event-card','data' => ['title' => $event->title,'date' => $event->event_date,'time' => $event->formatted_time,'location' => $event->venue,'category' => $event->category?->name,'href' => route('events.show', $event)]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('event-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($event->title),'date' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($event->event_date),'time' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($event->formatted_time),'location' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($event->venue),'category' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($event->category?->name),'href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('events.show', $event))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal07bdbe031a4c57e4cd3488994f94e999)): ?>
<?php $attributes = $__attributesOriginal07bdbe031a4c57e4cd3488994f94e999; ?>
<?php unset($__attributesOriginal07bdbe031a4c57e4cd3488994f94e999); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal07bdbe031a4c57e4cd3488994f94e999)): ?>
<?php $component = $__componentOriginal07bdbe031a4c57e4cd3488994f94e999; ?>
<?php unset($__componentOriginal07bdbe031a4c57e4cd3488994f94e999); ?>
<?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <?php else: ?>
            <div class="mt-12">
                <?php if (isset($component)) { $__componentOriginal074a021b9d42f490272b5eefda63257c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal074a021b9d42f490272b5eefda63257c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.empty-state','data' => ['title' => 'No upcoming events','description' => 'Check back soon for our next gathering.','compact' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('empty-state'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'No upcoming events','description' => 'Check back soon for our next gathering.','compact' => true]); ?>
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
            </div>
            <?php endif; ?>
        </div>
    </section>

    
    <section class="bg-navy-950 py-16 text-white sm:py-20 lg:py-24">
        <div class="container-page">
            <div class="flex flex-col items-start justify-between gap-6 sm:flex-row sm:items-end">
                <div x-data="{ shown: false }" x-intersect.once="shown = true" :class="shown ? 'aos-animate' : ''" class="aos-init aos-fade-up"><?php if (isset($component)) { $__componentOriginal755230460fd16c04121658d92fbf99f7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal755230460fd16c04121658d92fbf99f7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.section-heading','data' => ['eyebrow' => 'Featured Alumni','title' => 'Where our graduates have landed','description' => 'From acclaimed writers to educators and cultural leaders, our alumni carry the Department\'s name across the world.','dark' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('section-heading'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['eyebrow' => 'Featured Alumni','title' => 'Where our graduates have landed','description' => 'From acclaimed writers to educators and cultural leaders, our alumni carry the Department\'s name across the world.','dark' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal755230460fd16c04121658d92fbf99f7)): ?>
<?php $attributes = $__attributesOriginal755230460fd16c04121658d92fbf99f7; ?>
<?php unset($__attributesOriginal755230460fd16c04121658d92fbf99f7); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal755230460fd16c04121658d92fbf99f7)): ?>
<?php $component = $__componentOriginal755230460fd16c04121658d92fbf99f7; ?>
<?php unset($__componentOriginal755230460fd16c04121658d92fbf99f7); ?>
<?php endif; ?></div>
                <?php if (isset($component)) { $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.button','data' => ['href' => ''.e(route('alumni.index')).'','variant' => 'light']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => ''.e(route('alumni.index')).'','variant' => 'light']); ?>Meet More Alumni <?php echo $__env->renderComponent(); ?>
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

            <?php if($featuredAlumni->isNotEmpty()): ?>
            <div x-data="{ shown: false }" x-intersect.once="shown = true" :class="shown ? 'aos-animate' : ''" class="aos-init aos-fade-up aos-delay-200 mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                <?php $__currentLoopData = $featuredAlumni; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $alumnus): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if (isset($component)) { $__componentOriginal98907a067cf0b7ee0a65abc9eeb4175a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal98907a067cf0b7ee0a65abc9eeb4175a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.alumni-card','data' => ['name' => $alumnus->full_name,'graduationYear' => $alumnus->graduation_year,'role' => $alumnus->designation,'field' => $alumnus->organization,'image' => $alumnus->profile_photo_url,'batch' => $alumnus->batch,'country' => $alumnus->country,'membershipType' => $alumnus->publicMembership?->type,'membershipTier' => $alumnus->publicMembership?->tier,'href' => ''.e(route('alumni.show', $alumnus)).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('alumni-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($alumnus->full_name),'graduation_year' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($alumnus->graduation_year),'role' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($alumnus->designation),'field' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($alumnus->organization),'image' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($alumnus->profile_photo_url),'batch' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($alumnus->batch),'country' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($alumnus->country),'membership_type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($alumnus->publicMembership?->type),'membership_tier' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($alumnus->publicMembership?->tier),'href' => ''.e(route('alumni.show', $alumnus)).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal98907a067cf0b7ee0a65abc9eeb4175a)): ?>
<?php $attributes = $__attributesOriginal98907a067cf0b7ee0a65abc9eeb4175a; ?>
<?php unset($__attributesOriginal98907a067cf0b7ee0a65abc9eeb4175a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal98907a067cf0b7ee0a65abc9eeb4175a)): ?>
<?php $component = $__componentOriginal98907a067cf0b7ee0a65abc9eeb4175a; ?>
<?php unset($__componentOriginal98907a067cf0b7ee0a65abc9eeb4175a); ?>
<?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <?php else: ?>
            <div class="mt-12">
                <?php if (isset($component)) { $__componentOriginal074a021b9d42f490272b5eefda63257c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal074a021b9d42f490272b5eefda63257c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.empty-state','data' => ['title' => 'Featured alumni coming soon','description' => 'We are adding stories from featured graduates. Check back soon to meet them.','compact' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('empty-state'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Featured alumni coming soon','description' => 'We are adding stories from featured graduates. Check back soon to meet them.','compact' => true]); ?>
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
            </div>
            <?php endif; ?>
        </div>
    </section>

    
    <?php if($publicMembers->isNotEmpty()): ?>
    <section class="section-pad bg-white">
        <div class="container-page">
            <div class="flex flex-col items-start justify-between gap-6 sm:flex-row sm:items-end">
                <div x-data="{ shown: false }" x-intersect.once="shown = true" :class="shown ? 'aos-animate' : ''" class="aos-init aos-fade-up"><?php if (isset($component)) { $__componentOriginal755230460fd16c04121658d92fbf99f7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal755230460fd16c04121658d92fbf99f7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.section-heading','data' => ['eyebrow' => 'Our Members','title' => 'Meet our members','description' => 'Alumni who are part of the EDAA-KNGC family.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('section-heading'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['eyebrow' => 'Our Members','title' => 'Meet our members','description' => 'Alumni who are part of the EDAA-KNGC family.']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal755230460fd16c04121658d92fbf99f7)): ?>
<?php $attributes = $__attributesOriginal755230460fd16c04121658d92fbf99f7; ?>
<?php unset($__attributesOriginal755230460fd16c04121658d92fbf99f7); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal755230460fd16c04121658d92fbf99f7)): ?>
<?php $component = $__componentOriginal755230460fd16c04121658d92fbf99f7; ?>
<?php unset($__componentOriginal755230460fd16c04121658d92fbf99f7); ?>
<?php endif; ?></div>
                <?php if (isset($component)) { $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.button','data' => ['href' => ''.e(route('members.index')).'','variant' => 'outline']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => ''.e(route('members.index')).'','variant' => 'outline']); ?>View All Members <?php echo $__env->renderComponent(); ?>
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

            <div x-data="{ shown: false }" x-intersect.once="shown = true" :class="shown ? 'aos-animate' : ''" class="aos-init aos-fade-up aos-delay-200 mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                <?php $__currentLoopData = $publicMembers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $membership): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if (isset($component)) { $__componentOriginal57cab686fbeade0e782d3b3efed1ac6f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal57cab686fbeade0e782d3b3efed1ac6f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.member-card','data' => ['alumni' => $membership->alumni,'membership' => $membership]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('member-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['alumni' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($membership->alumni),'membership' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($membership)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal57cab686fbeade0e782d3b3efed1ac6f)): ?>
<?php $attributes = $__attributesOriginal57cab686fbeade0e782d3b3efed1ac6f; ?>
<?php unset($__attributesOriginal57cab686fbeade0e782d3b3efed1ac6f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal57cab686fbeade0e782d3b3efed1ac6f)): ?>
<?php $component = $__componentOriginal57cab686fbeade0e782d3b3efed1ac6f; ?>
<?php unset($__componentOriginal57cab686fbeade0e782d3b3efed1ac6f); ?>
<?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    
    <section class="section-pad bg-white">
        <div class="container-page">
            <div class="flex flex-col items-start justify-between gap-6 sm:flex-row sm:items-end">
                <div x-data="{ shown: false }" x-intersect.once="shown = true" :class="shown ? 'aos-animate' : ''" class="aos-init aos-fade-up"><?php if (isset($component)) { $__componentOriginal755230460fd16c04121658d92fbf99f7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal755230460fd16c04121658d92fbf99f7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.section-heading','data' => ['eyebrow' => 'Latest News','title' => 'From the Department and the Association','description' => 'Updates, announcements, and notes from the community.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('section-heading'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['eyebrow' => 'Latest News','title' => 'From the Department and the Association','description' => 'Updates, announcements, and notes from the community.']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal755230460fd16c04121658d92fbf99f7)): ?>
<?php $attributes = $__attributesOriginal755230460fd16c04121658d92fbf99f7; ?>
<?php unset($__attributesOriginal755230460fd16c04121658d92fbf99f7); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal755230460fd16c04121658d92fbf99f7)): ?>
<?php $component = $__componentOriginal755230460fd16c04121658d92fbf99f7; ?>
<?php unset($__componentOriginal755230460fd16c04121658d92fbf99f7); ?>
<?php endif; ?></div>
                <?php if (isset($component)) { $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.button','data' => ['href' => ''.e(route('news.index')).'','variant' => 'outline']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => ''.e(route('news.index')).'','variant' => 'outline']); ?>All News <?php echo $__env->renderComponent(); ?>
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

            <?php if($latestNews->isNotEmpty()): ?>
            <div x-data="{ shown: false }" x-intersect.once="shown = true" :class="shown ? 'aos-animate' : ''" class="aos-init aos-fade-up aos-delay-200 mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                <?php $__currentLoopData = $latestNews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
            <?php else: ?>
            <div class="mt-12">
                <?php if (isset($component)) { $__componentOriginal074a021b9d42f490272b5eefda63257c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal074a021b9d42f490272b5eefda63257c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.empty-state','data' => ['title' => 'No news yet','description' => 'Check back soon for updates from the association.','compact' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('empty-state'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'No news yet','description' => 'Check back soon for updates from the association.','compact' => true]); ?>
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
            </div>
            <?php endif; ?>
        </div>
    </section>

    
    <section class="bg-cream py-16 sm:py-20 lg:py-24">
        <div class="container-page">
            <div class="flex flex-col items-start justify-between gap-6 sm:flex-row sm:items-end">
                <div x-data="{ shown: false }" x-intersect.once="shown = true" :class="shown ? 'aos-animate' : ''" class="aos-init aos-fade-up"><?php if (isset($component)) { $__componentOriginal755230460fd16c04121658d92fbf99f7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal755230460fd16c04121658d92fbf99f7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.section-heading','data' => ['eyebrow' => 'Alumni Stories','title' => 'Memories worth sharing','description' => 'Short reflections from alumni on what the English Department has meant to them.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('section-heading'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['eyebrow' => 'Alumni Stories','title' => 'Memories worth sharing','description' => 'Short reflections from alumni on what the English Department has meant to them.']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal755230460fd16c04121658d92fbf99f7)): ?>
<?php $attributes = $__attributesOriginal755230460fd16c04121658d92fbf99f7; ?>
<?php unset($__attributesOriginal755230460fd16c04121658d92fbf99f7); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal755230460fd16c04121658d92fbf99f7)): ?>
<?php $component = $__componentOriginal755230460fd16c04121658d92fbf99f7; ?>
<?php unset($__componentOriginal755230460fd16c04121658d92fbf99f7); ?>
<?php endif; ?></div>
                <?php if (isset($component)) { $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.button','data' => ['href' => ''.e(route('stories.index')).'','variant' => 'outline']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => ''.e(route('stories.index')).'','variant' => 'outline']); ?>Read All Stories <?php echo $__env->renderComponent(); ?>
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

            <?php if($latestStories->isNotEmpty()): ?>
            <div x-data="{ shown: false }" x-intersect.once="shown = true" :class="shown ? 'aos-animate' : ''" class="aos-init aos-fade-up aos-delay-200 mt-12 grid gap-6 lg:grid-cols-3">
                <?php $__currentLoopData = $latestStories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $story): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if (isset($component)) { $__componentOriginal5cb6f8d98bd8c07e7a8458167c190092 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5cb6f8d98bd8c07e7a8458167c190092 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.story-card','data' => ['name' => $story->alumni?->full_name,'graduationYear' => $story->alumni?->graduation_year,'quote' => $story->excerpt,'role' => $story->alumni?->designation,'image' => $story->cover_image_url,'href' => route('stories.show', $story)]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('story-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($story->alumni?->full_name),'graduation_year' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($story->alumni?->graduation_year),'quote' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($story->excerpt),'role' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($story->alumni?->designation),'image' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($story->cover_image_url),'href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('stories.show', $story))]); ?>
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
            <?php else: ?>
            <div class="mt-12">
                <?php if (isset($component)) { $__componentOriginal074a021b9d42f490272b5eefda63257c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal074a021b9d42f490272b5eefda63257c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.empty-state','data' => ['title' => 'No stories yet','description' => 'Alumni stories will appear here once they are published.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('empty-state'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'No stories yet','description' => 'Alumni stories will appear here once they are published.']); ?>
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
            </div>
            <?php endif; ?>
        </div>
    </section>

    
    <section class="section-pad bg-white">
        <div class="container-page">
            <div class="flex flex-col items-start justify-between gap-6 sm:flex-row sm:items-end">
                <div x-data="{ shown: false }" x-intersect.once="shown = true" :class="shown ? 'aos-animate' : ''" class="aos-init aos-fade-up"><?php if (isset($component)) { $__componentOriginal755230460fd16c04121658d92fbf99f7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal755230460fd16c04121658d92fbf99f7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.section-heading','data' => ['eyebrow' => 'Gallery','title' => 'Moments from our community','description' => 'A glimpse of reunions, lectures, and celebrations.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('section-heading'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['eyebrow' => 'Gallery','title' => 'Moments from our community','description' => 'A glimpse of reunions, lectures, and celebrations.']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal755230460fd16c04121658d92fbf99f7)): ?>
<?php $attributes = $__attributesOriginal755230460fd16c04121658d92fbf99f7; ?>
<?php unset($__attributesOriginal755230460fd16c04121658d92fbf99f7); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal755230460fd16c04121658d92fbf99f7)): ?>
<?php $component = $__componentOriginal755230460fd16c04121658d92fbf99f7; ?>
<?php unset($__componentOriginal755230460fd16c04121658d92fbf99f7); ?>
<?php endif; ?></div>
                <?php if (isset($component)) { $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.button','data' => ['href' => ''.e(route('gallery.index')).'','variant' => 'outline']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => ''.e(route('gallery.index')).'','variant' => 'outline']); ?>View Gallery <?php echo $__env->renderComponent(); ?>
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

            <?php if($latestAlbums->isNotEmpty()): ?>
            <div x-data="{ shown: false }" x-intersect.once="shown = true" :class="shown ? 'aos-animate' : ''" class="aos-init aos-fade-up aos-delay-200 mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                <?php $__currentLoopData = $latestAlbums; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $album): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if (isset($component)) { $__componentOriginal1197806225ccb86fbe1b3848a0f222f6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1197806225ccb86fbe1b3848a0f222f6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.gallery-card','data' => ['title' => $album->title,'category' => $album->event?->title,'image' => $album->cover_image_url,'count' => $album->photos_count,'href' => route('gallery.show', $album)]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('gallery-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($album->title),'category' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($album->event?->title),'image' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($album->cover_image_url),'count' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($album->photos_count),'href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('gallery.show', $album))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1197806225ccb86fbe1b3848a0f222f6)): ?>
<?php $attributes = $__attributesOriginal1197806225ccb86fbe1b3848a0f222f6; ?>
<?php unset($__attributesOriginal1197806225ccb86fbe1b3848a0f222f6); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1197806225ccb86fbe1b3848a0f222f6)): ?>
<?php $component = $__componentOriginal1197806225ccb86fbe1b3848a0f222f6; ?>
<?php unset($__componentOriginal1197806225ccb86fbe1b3848a0f222f6); ?>
<?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <?php else: ?>
            <div class="mt-12">
                <?php if (isset($component)) { $__componentOriginal074a021b9d42f490272b5eefda63257c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal074a021b9d42f490272b5eefda63257c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.empty-state','data' => ['title' => 'No albums yet','description' => 'Photo albums will appear here once they are published.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('empty-state'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'No albums yet','description' => 'Photo albums will appear here once they are published.']); ?>
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
            </div>
            <?php endif; ?>
        </div>
    </section>

    
    <section class="section-pad bg-white">
        <div class="container-page">
            <div class="flex flex-col items-start justify-between gap-6 sm:flex-row sm:items-end">
                <div x-data="{ shown: false }" x-intersect.once="shown = true" :class="shown ? 'aos-animate' : ''" class="aos-init aos-fade-up"><?php if (isset($component)) { $__componentOriginal755230460fd16c04121658d92fbf99f7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal755230460fd16c04121658d92fbf99f7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.section-heading','data' => ['eyebrow' => 'Publications','title' => 'Reports, magazines & research','description' => 'Browse our collection of departmental publications and research documents.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('section-heading'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['eyebrow' => 'Publications','title' => 'Reports, magazines & research','description' => 'Browse our collection of departmental publications and research documents.']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal755230460fd16c04121658d92fbf99f7)): ?>
<?php $attributes = $__attributesOriginal755230460fd16c04121658d92fbf99f7; ?>
<?php unset($__attributesOriginal755230460fd16c04121658d92fbf99f7); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal755230460fd16c04121658d92fbf99f7)): ?>
<?php $component = $__componentOriginal755230460fd16c04121658d92fbf99f7; ?>
<?php unset($__componentOriginal755230460fd16c04121658d92fbf99f7); ?>
<?php endif; ?></div>
                <?php if (isset($component)) { $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.button','data' => ['href' => ''.e(route('publications.index')).'','variant' => 'outline']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => ''.e(route('publications.index')).'','variant' => 'outline']); ?>View All <?php echo $__env->renderComponent(); ?>
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

            <?php if($latestPublications->isNotEmpty()): ?>
            <div x-data="{ shown: false }" x-intersect.once="shown = true" :class="shown ? 'aos-animate' : ''" class="aos-init aos-fade-up aos-delay-200 mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                <?php $__currentLoopData = $latestPublications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pub): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if (isset($component)) { $__componentOriginal4b48c940f0ffe0bae9e547acb74f1315 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4b48c940f0ffe0bae9e547acb74f1315 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.publication-card','data' => ['title' => $pub->title,'type' => $pub->category?->name,'author' => $pub->author,'year' => $pub->publication_date?->format('Y'),'description' => $pub->description,'href' => route('publications.show', $pub)]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('publication-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($pub->title),'type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($pub->category?->name),'author' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($pub->author),'year' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($pub->publication_date?->format('Y')),'description' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($pub->description),'href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('publications.show', $pub))]); ?>
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
            <?php else: ?>
            <div class="mt-12">
                <?php if (isset($component)) { $__componentOriginal074a021b9d42f490272b5eefda63257c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal074a021b9d42f490272b5eefda63257c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.empty-state','data' => ['title' => 'No publications yet','description' => 'Publications will appear here once they are published.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('empty-state'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'No publications yet','description' => 'Publications will appear here once they are published.']); ?>
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
            </div>
            <?php endif; ?>
        </div>
    </section>

    
    <?php if($latestPressReleases->isNotEmpty()): ?>
    <section class="section-pad bg-cream">
        <div class="container-page">
            <div class="flex flex-col items-start justify-between gap-6 sm:flex-row sm:items-end">
                <div x-data="{ shown: false }" x-intersect.once="shown = true" :class="shown ? 'aos-animate' : ''" class="aos-init aos-fade-up"><?php if (isset($component)) { $__componentOriginal755230460fd16c04121658d92fbf99f7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal755230460fd16c04121658d92fbf99f7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.section-heading','data' => ['eyebrow' => 'Press Releases','title' => 'Official announcements','description' => 'The latest official communications from EDAA-KNGC.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('section-heading'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['eyebrow' => 'Press Releases','title' => 'Official announcements','description' => 'The latest official communications from EDAA-KNGC.']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal755230460fd16c04121658d92fbf99f7)): ?>
<?php $attributes = $__attributesOriginal755230460fd16c04121658d92fbf99f7; ?>
<?php unset($__attributesOriginal755230460fd16c04121658d92fbf99f7); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal755230460fd16c04121658d92fbf99f7)): ?>
<?php $component = $__componentOriginal755230460fd16c04121658d92fbf99f7; ?>
<?php unset($__componentOriginal755230460fd16c04121658d92fbf99f7); ?>
<?php endif; ?></div>
                <?php if (isset($component)) { $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.button','data' => ['href' => ''.e(route('press-releases.index')).'','variant' => 'outline']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => ''.e(route('press-releases.index')).'','variant' => 'outline']); ?>View All <?php echo $__env->renderComponent(); ?>
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

            <div x-data="{ shown: false }" x-intersect.once="shown = true" :class="shown ? 'aos-animate' : ''" class="aos-init aos-fade-up aos-delay-200 mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                <?php $__currentLoopData = $latestPressReleases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $release): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(route('press-releases.show', $release)); ?>" class="card-lift shine glow-top group flex h-full flex-col overflow-hidden rounded-xl border border-white/20 bg-white/80 shadow-sm backdrop-blur-sm">
                    <?php if($release->cover_image): ?>
                    <div class="overflow-hidden">
                        <img src="<?php echo e($release->cover_image_url); ?>" alt="<?php echo e($release->title); ?>" class="aspect-[16/9] w-full object-cover transition-transform duration-500 group-hover:scale-105">
                    </div>
                    <?php else: ?>
                    <div class="flex aspect-[16/9] items-center justify-center bg-gradient-to-br from-navy-900 to-navy-800">
                        <span class="font-serif text-2xl font-bold text-gold-300/30">EDAA</span>
                    </div>
                    <?php endif; ?>
                    <div class="flex flex-1 flex-col p-6">
                        <div class="flex items-center gap-2">
                            <time class="text-xs font-medium text-ink-soft" datetime="<?php echo e($release->published_at?->toIso8601String()); ?>"><?php echo e($release->formatted_date); ?></time>
                            <?php if($release->document_path): ?>
                            <span class="inline-flex rounded-full bg-maroon-50 px-2 py-0.5 text-[10px] font-semibold uppercase text-maroon-700">PDF</span>
                            <?php endif; ?>
                        </div>
                        <h3 class="mt-3 font-serif text-lg font-bold text-navy-950 transition-colors group-hover:text-maroon-700"><?php echo e($release->title); ?></h3>
                        <?php if($release->excerpt): ?>
                        <p class="mt-2 flex-1 text-sm text-ink-soft line-clamp-2"><?php echo e($release->excerpt); ?></p>
                        <?php endif; ?>
                    </div>
                </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    
    <?php if($leaderboardEnabled): ?>
    <section class="relative overflow-hidden bg-gradient-to-br from-navy-950 via-navy-900 to-maroon-950 py-20 text-white sm:py-24" aria-labelledby="home-leaderboard-heading">
        <div class="pointer-events-none absolute inset-0" aria-hidden="true">
            <div class="absolute -right-32 -top-32 h-96 w-96 rounded-full bg-gold-400/5 blur-3xl"></div>
            <div class="absolute -left-32 bottom-0 h-64 w-64 rounded-full bg-maroon-500/10 blur-3xl"></div>
            <div class="absolute left-1/2 top-1/2 h-px w-3/4 -translate-x-1/2 -translate-y-1/2 bg-gradient-to-r from-transparent via-gold-500/20 to-transparent"></div>
        </div>

        <div class="container-page relative">
            <div x-data="{ shown: false }" x-intersect.once="shown = true" :class="shown ? 'aos-animate' : ''" class="aos-init aos-fade-up text-center">
                <p class="mb-4 inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-[0.25em] text-gold-300">
                    <span class="inline-block h-px w-10 bg-gold-500" aria-hidden="true"></span>
                    Member Leaderboard
                    <span class="inline-block h-px w-10 bg-gold-500" aria-hidden="true"></span>
                </p>
                <h2 class="font-serif text-3xl font-semibold leading-tight tracking-tight sm:text-4xl lg:text-5xl">
                    Recognizing Our <span class="italic text-gold-300">Contributors</span>
                </h2>
                <p class="mx-auto mt-5 max-w-2xl text-base leading-relaxed text-navy-200 sm:text-lg">
                    Members who have made verified financial contributions to EDAA-KNGC.
                </p>
            </div>

            <?php if($topContributors->isEmpty()): ?>
            <div class="mx-auto mt-14 max-w-xl rounded-2xl border border-white/10 bg-white/5 p-10 text-center backdrop-blur-sm">
                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-white/10">
                    <svg class="h-8 w-8 text-gold-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9m9 0a3 3 0 013 3h-15a3 3 0 013-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.007 0H9.497m5.007 0a7.454 7.454 0 01-.982-3.172M9.497 14.25a7.454 7.454 0 00.981-3.172M5.25 4.236c-.982.143-1.954.317-2.916.52A6.003 6.003 0 007.73 9.728M5.25 4.236V4.5c0 2.108.966 3.99 2.48 5.228M5.25 4.236V2.721C7.456 2.41 9.71 2.25 12 2.25c2.291 0 4.545.16 6.75.47v1.516M18.75 4.236c.982.143 1.954.317 2.916.52A6.003 6.003 0 0116.27 9.728M18.75 4.236V4.5c0 2.108-.966 3.99-2.48 5.228m0 0a6.003 6.003 0 01-3.77 1.523m3.77-1.523a6.004 6.004 0 00-.53-5.464" />
                    </svg>
                </div>
                <p class="mt-5 font-serif text-xl font-semibold text-white">No contributors yet</p>
                <p class="mt-2 text-sm text-navy-300">Verified member contributions will be recognized here once recorded.</p>
            </div>
            <?php else: ?>
            <div class="mx-auto mt-14 grid max-w-5xl gap-6 sm:grid-cols-3">
                <?php $__currentLoopData = $topContributors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $contributor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div
                    class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                        'group relative rounded-2xl p-6 text-center transition-all duration-300 sm:p-8',
                        'bg-gradient-to-b from-gold-500/20 to-gold-500/5 border border-gold-400/30 shadow-lg shadow-gold-500/10' => $loop->first,
                        'bg-white/5 border border-white/10 hover:border-white/20 hover:bg-white/10' => ! $loop->first,
                    ]); ?>"
                >
                    
                    <div class="relative mx-auto">
                        <?php if($loop->first): ?>
                            <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-gradient-to-b from-gold-400 to-gold-600 shadow-lg shadow-gold-500/30">
                                <svg class="h-8 w-8 text-navy-950" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                </svg>
                            </div>
                        <?php else: ?>
                            <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-gradient-to-b from-navy-700 to-navy-800 ring-2 ring-gold-500/30">
                                <span class="font-serif text-lg font-bold text-gold-300"><?php echo e($contributor->leaderboard_rank); ?></span>
                            </div>
                        <?php endif; ?>
                        <span class="sr-only"><?php echo e(\Illuminate\Support\Number::ordinal($contributor->leaderboard_rank)); ?> place</span>
                    </div>

                    
                    <div class="mt-5">
                        <?php if($contributor->profile_photo): ?>
                            <img
                                src="<?php echo e(\Illuminate\Support\Facades\Storage::disk('public')->url($contributor->profile_photo)); ?>"
                                alt="<?php echo e($contributor->alumni_name); ?>"
                                class="mx-auto h-20 w-20 rounded-full object-cover ring-2 ring-white/20"
                                loading="lazy"
                            >
                        <?php else: ?>
                            <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-white/10 ring-2 ring-white/20">
                                <span class="font-serif text-xl font-bold text-white"><?php echo e(strtoupper(substr($contributor->alumni_name, 0, 2))); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>

                    
                    <div class="mt-4">
                        <p class="truncate font-serif text-lg font-semibold text-white" title="<?php echo e($contributor->alumni_name); ?>">
                            <?php echo e($contributor->alumni_name); ?>

                        </p>
                        <p class="mt-1 text-xs font-medium uppercase tracking-wider text-gold-300/80">
                            <?php echo e($contributor->tier_name ?? 'Member'); ?>

                        </p>
                    </div>

                    
                    <div class="mt-5 border-t border-white/10 pt-5">
                        <p class="text-[10px] font-semibold uppercase tracking-[0.2em] text-navy-300">Verified Contribution</p>
                        <p class="mt-1 text-2xl font-bold tabular-nums text-white"><?php echo e($contributor->formatted_contribution); ?></p>
                    </div>

                    
                    <?php if(! $loop->first): ?>
                    <div class="pointer-events-none absolute inset-0 rounded-2xl opacity-0 transition-opacity duration-300 group-hover:opacity-100" aria-hidden="true">
                        <div class="absolute inset-0 rounded-2xl bg-gradient-to-b from-white/5 to-transparent"></div>
                    </div>
                    <?php endif; ?>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <?php endif; ?>

            <?php if($leaderboardEnabled): ?>
            <div class="mt-12 text-center">
                <a href="<?php echo e(route('leaderboard.index')); ?>" class="focus-ring inline-flex items-center gap-2 rounded-full border border-gold-500/30 bg-gold-500/10 px-6 py-3 text-sm font-semibold text-gold-300 transition-all hover:border-gold-500/50 hover:bg-gold-500/20 hover:text-white">
                    View Full Leaderboard
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                    </svg>
                </a>
            </div>
            <?php endif; ?>
        </div>
    </section>
    <?php endif; ?>

    
    <section class="relative overflow-hidden bg-gradient-to-br from-maroon-900 via-maroon-800 to-navy-950 py-20 text-white sm:py-24">
        <div class="pointer-events-none absolute inset-0 opacity-15" aria-hidden="true">
            <div class="absolute -right-24 -top-24 h-96 w-96 rounded-full bg-gold-400 blur-3xl"></div>
            <div class="absolute -left-24 -bottom-24 h-80 w-80 rounded-full bg-maroon-500 blur-3xl"></div>
            <div class="absolute left-1/2 top-1/2 h-px w-full -translate-x-1/2 -translate-y-1/2 bg-gradient-to-r from-transparent via-gold-500/20 to-transparent"></div>
        </div>

        <div class="container-page relative text-center">
            <div x-data="{ shown: false }" x-intersect.once="shown = true" :class="shown ? 'aos-animate' : ''" class="aos-init aos-fade-up">
                <span class="mb-4 inline-flex items-center gap-2 rounded-full border border-gold-400/30 bg-gold-500/10 px-4 py-1.5 text-xs font-bold uppercase tracking-[0.2em] text-gold-300 backdrop-blur-sm">
                    Lifelong Community
                </span>
                <h2 class="font-serif text-3xl font-semibold leading-tight tracking-tight sm:text-5xl lg:text-6xl">
                    Become Part of the <span class="italic text-gold-300">EDAA Family</span>
                </h2>
                <p class="mx-auto mt-5 max-w-2xl text-base leading-relaxed text-navy-100 sm:text-lg">
                    Whether you walked our halls decades ago or just recently graduated, you belong here. Connect with your peers, mentor the next generation, and honor our shared legacy.
                </p>
            </div>

            <div class="mt-10 flex flex-col justify-center items-center gap-4 sm:flex-row">
                <?php if(auth()->guard()->check()): ?>
                    <?php if (isset($component)) { $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.button','data' => ['href' => ''.e(route('member.dashboard')).'','variant' => 'gold','size' => 'lg','icon' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => ''.e(route('member.dashboard')).'','variant' => 'gold','size' => 'lg','icon' => true]); ?>
                        Go to Member Portal
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
                    <?php if (isset($component)) { $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.button','data' => ['href' => ''.e(route('events.index')).'','variant' => 'outline-on-dark','size' => 'lg']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => ''.e(route('events.index')).'','variant' => 'outline-on-dark','size' => 'lg']); ?>
                        Browse Upcoming Events
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
                <?php else: ?>
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
                        Apply for Membership
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
                    <?php if (isset($component)) { $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.button','data' => ['href' => ''.e(route('member.login')).'','variant' => 'outline-on-dark','size' => 'lg']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => ''.e(route('member.login')).'','variant' => 'outline-on-dark','size' => 'lg']); ?>
                        Member Portal Login
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
                <?php endif; ?>
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
<?php endif; ?><?php /**PATH C:\xampp\htdocs\ProDo\EDAA\resources\views\pages\home.blade.php ENDPATH**/ ?>