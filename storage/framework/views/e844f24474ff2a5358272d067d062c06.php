<?php if (isset($component)) { $__componentOriginal5863877a5171c196453bfa0bd807e410 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5863877a5171c196453bfa0bd807e410 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.app','data' => ['title' => 'Credits & Acknowledgements','description' => 'Meet the developer and technical contributors behind the English Department Alumni Association KNGC web platform.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.app'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Credits & Acknowledgements','description' => 'Meet the developer and technical contributors behind the English Department Alumni Association KNGC web platform.']); ?>

    
    <?php if (isset($component)) { $__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.page-header','data' => ['title' => 'Credits & Acknowledgements','description' => 'Recognizing the development, architectural craftsmanship, and dedicated alumni contribution behind the EDAA-KNGC digital portal.','eyebrow' => 'Platform & Engineering','breadcrumbs' => [['label' => 'Credits']]]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('page-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Credits & Acknowledgements','description' => 'Recognizing the development, architectural craftsmanship, and dedicated alumni contribution behind the EDAA-KNGC digital portal.','eyebrow' => 'Platform & Engineering','breadcrumbs' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([['label' => 'Credits']])]); ?>
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

            <div class="overflow-hidden rounded-3xl border border-navy-100 bg-gradient-to-b from-cream/60 via-white to-white shadow-sm transition-all duration-300 hover:shadow-md">
                <div class="grid items-center gap-10 p-8 sm:p-12 lg:grid-cols-12 lg:gap-14">

                    
                    <div class="flex flex-col items-center text-center lg:col-span-5">
                        <div class="relative">
                            
                            <div class="relative h-56 w-56 overflow-hidden rounded-2xl border-4 border-white shadow-xl ring-2 ring-gold-400/40 sm:h-64 sm:w-64">
                                <img
                                    src="<?php echo e(asset('storage/branding/Johirul Islam.jpg')); ?>"
                                    alt="Johirul Islam"
                                    class="h-full w-full object-cover object-top transition-transform duration-500 hover:scale-105"
                                >
                            </div>

                            
                            <div class="absolute -bottom-3 -right-3 flex h-10 w-10 items-center justify-center rounded-full border-2 border-white bg-emerald-600 text-white shadow-md" title="Verified Alumnus & Creator">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                        </div>

                        <div class="mt-6">
                            <span class="inline-flex items-center gap-1.5 rounded-full border border-gold-500/30 bg-gold-50 px-4 py-1.5 text-xs font-bold uppercase tracking-wider text-maroon-700">
                                <svg class="h-3.5 w-3.5 text-gold-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                                </svg>
                                Batch 2018–19
                            </span>
                            <p class="mt-2 text-xs font-semibold uppercase tracking-widest text-navy-400">Department of English</p>
                            <p class="text-xs text-ink-soft">Kabi Nazrul Government College, Dhaka</p>
                        </div>

                        
                        <div class="mt-6 flex flex-wrap justify-center gap-3">
                            <a
                                href="https://wa.me/8801733956590"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="focus-ring inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-4 py-2.5 text-xs font-bold text-white shadow-sm transition-all hover:bg-emerald-700 hover:shadow-md"
                            >
                                <svg class="h-4 w-4 fill-current" viewBox="0 0 24 24">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                                </svg>
                                WhatsApp
                            </a>

                            <a
                                href="https://facebook.com/shovon.5271"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="focus-ring inline-flex items-center gap-2 rounded-xl border border-navy-200 bg-white px-4 py-2.5 text-xs font-bold text-navy-800 shadow-sm transition-all hover:border-navy-400 hover:bg-navy-50"
                            >
                                <svg class="h-4 w-4 fill-current text-blue-600" viewBox="0 0 24 24">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                                Facebook
                            </a>
                        </div>
                    </div>

                    
                    <div class="lg:col-span-7">
                        <div class="inline-flex items-center gap-2 text-xs font-bold uppercase tracking-[0.2em] text-maroon-700">
                            <span class="h-1.5 w-1.5 rounded-full bg-maroon-600"></span>
                            Lead Developer &amp; Web Architect
                        </div>

                        <h2 class="mt-2 font-serif text-3xl font-bold tracking-tight text-navy-950 sm:text-4xl">
                            Johirul Islam (Shovon)
                        </h2>

                        <p class="mt-1 text-sm font-medium text-navy-600">
                            Alumnus &bull; Full-Stack Web Developer &bull; UI/UX Craftsperson
                        </p>

                        
                        <div class="relative mt-6 rounded-2xl border-l-4 border-gold-500 bg-cream p-6 sm:p-7">
                            <svg class="absolute -top-3 right-4 h-8 w-8 text-gold-500/20" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z" />
                            </svg>
                            <p class="text-sm leading-relaxed text-ink-soft sm:text-base italic">
                                "As a proud alumnus of the English Department at Kabi Nazrul Government College, conceptualizing and engineering this platform has been a deeply meaningful privilege. The mission was to build a secure, elegant, and seamless digital home that unites generations of alumni, supports our beloved department, and carries our academic heritage forward."
                            </p>
                        </div>

                        
                        <div class="mt-8">
                            <h3 class="text-xs font-bold uppercase tracking-wider text-navy-900">Key Engineering Contributions</h3>
                            <div class="mt-3 grid gap-3 sm:grid-cols-2">
                                <div class="flex items-start gap-2.5 rounded-xl border border-navy-100 bg-white p-3 shadow-xs">
                                    <div class="mt-0.5 flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-navy-50 text-navy-700">
                                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                    </div>
                                    <span class="text-xs font-medium text-navy-900">Complete Full-Stack Platform Architecture</span>
                                </div>
                                <div class="flex items-start gap-2.5 rounded-xl border border-navy-100 bg-white p-3 shadow-xs">
                                    <div class="mt-0.5 flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-navy-50 text-navy-700">
                                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                    </div>
                                    <span class="text-xs font-medium text-navy-900">Responsive UI/UX &amp; Academic Design System</span>
                                </div>
                                <div class="flex items-start gap-2.5 rounded-xl border border-navy-100 bg-white p-3 shadow-xs">
                                    <div class="mt-0.5 flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-navy-50 text-navy-700">
                                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                    </div>
                                    <span class="text-xs font-medium text-navy-900">Member Portal &amp; Authentication Management</span>
                                </div>
                                <div class="flex items-start gap-2.5 rounded-xl border border-navy-100 bg-white p-3 shadow-xs">
                                    <div class="mt-0.5 flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-navy-50 text-navy-700">
                                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                    </div>
                                    <span class="text-xs font-medium text-navy-900">Database Design &amp; Directory Optimization</span>
                                </div>
                            </div>
                        </div>

                        
                        <div class="mt-8 flex flex-wrap items-center gap-3">
                            <?php if (isset($component)) { $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.button','data' => ['href' => route('home'),'variant' => 'navy','size' => 'md']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('home')),'variant' => 'navy','size' => 'md']); ?>
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                </svg>
                                Back to Homepage
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.button','data' => ['href' => route('contact'),'variant' => 'outline','size' => 'md']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('contact')),'variant' => 'outline','size' => 'md']); ?>
                                Contact Association
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

        </div>
    </section>

    
    <section class="border-y border-navy-100 bg-cream/50 py-16 sm:py-20 lg:py-24">
        <div class="container-page">
            <?php if (isset($component)) { $__componentOriginal755230460fd16c04121658d92fbf99f7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal755230460fd16c04121658d92fbf99f7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.section-heading','data' => ['eyebrow' => 'Platform Engineering','title' => 'Built with Modern Web Standards','description' => 'The EDAA platform is built with modern, battle-tested technologies prioritising speed, data security, accessibility, and intuitive user experiences.','align' => 'center']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('section-heading'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['eyebrow' => 'Platform Engineering','title' => 'Built with Modern Web Standards','description' => 'The EDAA platform is built with modern, battle-tested technologies prioritising speed, data security, accessibility, and intuitive user experiences.','align' => 'center']); ?>
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

                
                <div class="card-lift rounded-2xl border border-navy-100 bg-white p-7 shadow-xs">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-navy-900 text-gold-300">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01" />
                        </svg>
                    </div>
                    <h3 class="mt-5 font-serif text-lg font-bold text-navy-950">Laravel Framework</h3>
                    <p class="mt-2 text-xs font-semibold uppercase tracking-wider text-maroon-700">Backend &amp; MVC Architecture</p>
                    <p class="mt-3 text-sm leading-relaxed text-ink-soft">
                        Powers clean business logic, Eloquent object-relational mapping, secure session handling, and robust routing infrastructure.
                    </p>
                </div>

                
                <div class="card-lift rounded-2xl border border-navy-100 bg-white p-7 shadow-xs">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-maroon-700 text-white">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
                        </svg>
                    </div>
                    <h3 class="mt-5 font-serif text-lg font-bold text-navy-950">Tailwind CSS</h3>
                    <p class="mt-2 text-xs font-semibold uppercase tracking-wider text-maroon-700">Academic Design Tokens</p>
                    <p class="mt-3 text-sm leading-relaxed text-ink-soft">
                        Delivers a bespoke visual aesthetic with deep academic navy, burgundy, and warm gold accents harmonized for readability.
                    </p>
                </div>

                
                <div class="card-lift rounded-2xl border border-navy-100 bg-white p-7 shadow-xs">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-navy-800 text-gold-300">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <h3 class="mt-5 font-serif text-lg font-bold text-navy-950">Alpine.js &amp; Vite</h3>
                    <p class="mt-2 text-xs font-semibold uppercase tracking-wider text-maroon-700">High-Performance Frontend</p>
                    <p class="mt-3 text-sm leading-relaxed text-ink-soft">
                        Lightweight declarative interactivity paired with next-generation Vite bundling for near-instantaneous page rendering.
                    </p>
                </div>

                
                <div class="card-lift rounded-2xl border border-navy-100 bg-white p-7 shadow-xs">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-navy-900 text-gold-300">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4" />
                        </svg>
                    </div>
                    <h3 class="mt-5 font-serif text-lg font-bold text-navy-950">Relational Database</h3>
                    <p class="mt-2 text-xs font-semibold uppercase tracking-wider text-maroon-700">Structured Data Integrity</p>
                    <p class="mt-3 text-sm leading-relaxed text-ink-soft">
                        Organized data architecture supporting alumni directories, member registrations, financial records, and historical archives.
                    </p>
                </div>

                
                <div class="card-lift rounded-2xl border border-navy-100 bg-white p-7 shadow-xs">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-maroon-700 text-white">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <h3 class="mt-5 font-serif text-lg font-bold text-navy-950">Enterprise Security</h3>
                    <p class="mt-2 text-xs font-semibold uppercase tracking-wider text-maroon-700">Role-Based Access Control</p>
                    <p class="mt-3 text-sm leading-relaxed text-ink-soft">
                        Strict separation of roles between visitors, registered alumni, and committee administrators with password hashing and CSRF defenses.
                    </p>
                </div>

                
                <div class="card-lift rounded-2xl border border-navy-100 bg-white p-7 shadow-xs">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-navy-800 text-gold-300">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="mt-5 font-serif text-lg font-bold text-navy-950">Mobile-First &amp; Accessible</h3>
                    <p class="mt-2 text-xs font-semibold uppercase tracking-wider text-maroon-700">Every Device &amp; Screen</p>
                    <p class="mt-3 text-sm leading-relaxed text-ink-soft">
                        Fully responsive layout complying with accessible contrast ratios, semantic HTML landmarks, and intuitive touch interactions.
                    </p>
                </div>

            </div>
        </div>
    </section>

    
    <section class="section-pad bg-white">
        <div class="container-page">
            <?php if (isset($component)) { $__componentOriginal755230460fd16c04121658d92fbf99f7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal755230460fd16c04121658d92fbf99f7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.section-heading','data' => ['eyebrow' => 'Institutional Fellowship','title' => 'Acknowledgements & Gratitude','description' => 'The development and success of this digital portal is made possible through the collaboration, trust, and guidance of our academic fraternity.','align' => 'center']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('section-heading'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['eyebrow' => 'Institutional Fellowship','title' => 'Acknowledgements & Gratitude','description' => 'The development and success of this digital portal is made possible through the collaboration, trust, and guidance of our academic fraternity.','align' => 'center']); ?>
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

            <div class="mt-12 grid gap-6 md:grid-cols-3">

                <div class="rounded-2xl border border-navy-100 bg-cream/40 p-8">
                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-navy-950 text-gold-300">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <h3 class="mt-6 font-serif text-lg font-bold text-navy-950">EDAA Executive Committee</h3>
                    <p class="mt-2 text-xs font-bold uppercase tracking-wider text-maroon-700">Governance &amp; Vision</p>
                    <p class="mt-3 text-sm leading-relaxed text-ink-soft">
                        Grateful appreciation to the Executive Committee members for their vision, trust, and constitutional guidance in realizing an official portal for the Association.
                    </p>
                </div>

                <div class="rounded-2xl border border-navy-100 bg-cream/40 p-8">
                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-maroon-700 text-gold-300">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <h3 class="mt-6 font-serif text-lg font-bold text-navy-950">Respected Faculty of English</h3>
                    <p class="mt-2 text-xs font-bold uppercase tracking-wider text-maroon-700">Department Heritage</p>
                    <p class="mt-3 text-sm leading-relaxed text-ink-soft">
                        Heartfelt respect to all current and former teachers of the Department of English at Kabi Nazrul Government College for inspiring generations of scholars and thinkers.
                    </p>
                </div>

                <div class="rounded-2xl border border-navy-100 bg-cream/40 p-8">
                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-navy-900 text-gold-300">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.4-1.7M9 20H4v-2a3 3 0 015.4-1.7M16 3.1a3 3 0 110 5.8M11 7a3 3 0 11-6 0 3 3 0 016 0zm5 7.5a3 3 0 10-6 0" />
                        </svg>
                    </div>
                    <h3 class="mt-6 font-serif text-lg font-bold text-navy-950">Alumni Community &amp; Testers</h3>
                    <p class="mt-2 text-xs font-bold uppercase tracking-wider text-maroon-700">Feedback &amp; Collaboration</p>
                    <p class="mt-3 text-sm leading-relaxed text-ink-soft">
                        Sincere thanks to the batch representatives and early alumni beta testers who provided invaluable suggestions to refine and polish every feature of this site.
                    </p>
                </div>

            </div>
        </div>
    </section>

    
    <section class="bg-cream py-16">
        <div class="container-page">
            <div class="relative overflow-hidden rounded-3xl bg-navy-950 px-8 py-12 text-white shadow-xl sm:px-14 sm:py-16">

                
                <div class="pointer-events-none absolute inset-0 opacity-10" aria-hidden="true">
                    <div class="absolute -right-20 -top-20 h-80 w-80 rounded-full border-2 border-gold-400"></div>
                    <div class="absolute -bottom-10 left-10 h-64 w-64 rounded-full border border-white/60"></div>
                </div>

                <div class="relative z-10 mx-auto max-w-3xl text-center">
                    <span class="inline-flex items-center gap-2 rounded-full border border-gold-500/30 bg-gold-500/10 px-4 py-1.5 text-xs font-bold uppercase tracking-widest text-gold-300">
                        Feedback &amp; Improvement
                    </span>
                    <h2 class="mt-4 font-serif text-2xl font-bold sm:text-3xl lg:text-4xl text-white">
                        Have Feedback or Suggestions for the Platform?
                    </h2>
                    <p class="mt-4 text-sm leading-relaxed text-navy-100 sm:text-base">
                        Continuous refinement is vital to serving our growing alumni family. If you encounter an anomaly or have an idea to enhance the portal experience, we welcome your input.
                    </p>

                    <div class="mt-8 flex flex-wrap items-center justify-center gap-4">
                        <?php if (isset($component)) { $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.button','data' => ['href' => route('contact'),'variant' => 'gold','size' => 'lg']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('contact')),'variant' => 'gold','size' => 'lg']); ?>
                            Submit Feedback
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

                        <a
                            href="https://wa.me/8801733956590"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="focus-ring inline-flex items-center justify-center gap-2 rounded-lg border border-white/30 px-6 py-3 text-base font-semibold text-white transition-all hover:border-gold-300 hover:text-gold-300 hover:bg-white/5"
                        >
                            <svg class="h-5 w-5 fill-current" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                            </svg>
                            Direct Message
                        </a>
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
<?php /**PATH C:\xampp\htdocs\ProDo\EDAA\resources\views\pages\credits.blade.php ENDPATH**/ ?>