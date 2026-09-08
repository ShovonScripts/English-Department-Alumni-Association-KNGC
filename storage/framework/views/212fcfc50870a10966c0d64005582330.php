<?php if (isset($component)) { $__componentOriginal5863877a5171c196453bfa0bd807e410 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5863877a5171c196453bfa0bd807e410 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.app','data' => ['title' => 'My Profile']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.app'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('My Profile')]); ?>
    
    <section class="relative bg-navy-950 py-12 lg:py-14 overflow-hidden border-b border-navy-900/60">
        <div class="absolute inset-0 hero-gradient-mesh opacity-90"></div>
        <div class="absolute -top-24 -right-24 h-96 w-96 rounded-full bg-gold-500/10 blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -left-24 h-96 w-96 rounded-full bg-maroon-700/15 blur-3xl pointer-events-none"></div>

        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <div class="flex items-center gap-2 mb-1.5">
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-500/15 px-2.5 py-0.5 text-xs font-semibold text-emerald-400 ring-1 ring-emerald-500/30">
                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-400"></span>
                            Member Account
                        </span>
                    </div>
                    <h1 class="font-serif text-2xl sm:text-3xl font-bold tracking-tight text-white">My Profile</h1>
                    <p class="mt-1 text-sm text-white/60">Your verified alumni credentials and academic directory record</p>
                </div>
                <div class="flex items-center gap-3">
                    <?php if($membership->is_public): ?>
                        <a href="<?php echo e(route('alumni.show', $alumni->slug)); ?>" target="_blank" class="focus-ring inline-flex items-center gap-2 rounded-lg bg-white/10 px-3.5 py-2 text-xs font-semibold text-white/90 ring-1 ring-white/15 transition-all hover:bg-white/15">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                            </svg>
                            View Public Profile
                        </a>
                    <?php endif; ?>
                    <a href="<?php echo e(route('member.profile.edit')); ?>" class="focus-ring inline-flex items-center gap-2 rounded-lg bg-maroon-700 px-4 py-2 text-xs font-bold uppercase tracking-wider text-white shadow-sm hover:bg-maroon-800 transition-all hover:-translate-y-0.5 active:translate-y-0">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/>
                        </svg>
                        Edit Profile
                    </a>
                </div>
            </div>
        </div>
    </section>

    
    <section class="py-10 bg-slate-50/60 min-h-screen">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                
                <aside class="lg:col-span-1">
                    <div class="rounded-2xl border border-navy-100/70 bg-white p-4 shadow-sm sticky top-24">
                        <?php if (isset($component)) { $__componentOriginal045cf4da59ba09f546a14c8bea6c081a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal045cf4da59ba09f546a14c8bea6c081a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.member.sidebar','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('member.sidebar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal045cf4da59ba09f546a14c8bea6c081a)): ?>
<?php $attributes = $__attributesOriginal045cf4da59ba09f546a14c8bea6c081a; ?>
<?php unset($__attributesOriginal045cf4da59ba09f546a14c8bea6c081a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal045cf4da59ba09f546a14c8bea6c081a)): ?>
<?php $component = $__componentOriginal045cf4da59ba09f546a14c8bea6c081a; ?>
<?php unset($__componentOriginal045cf4da59ba09f546a14c8bea6c081a); ?>
<?php endif; ?>
                    </div>
                </aside>

                
                <main class="lg:col-span-3 space-y-6">
                    
                    <?php if(session('success')): ?>
                        <div class="rounded-2xl border border-emerald-200/80 bg-gradient-to-r from-emerald-50 to-emerald-50/30 p-4 shadow-sm flex items-center gap-3.5">
                            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-emerald-100 text-emerald-700">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                                </svg>
                            </div>
                            <p class="text-sm font-semibold text-emerald-900"><?php echo e(session('success')); ?></p>
                        </div>
                    <?php endif; ?>

                    
                    <div class="overflow-hidden rounded-2xl border border-navy-100/80 bg-white shadow-sm">
                        
                        <div class="relative h-40 bg-gradient-to-r from-navy-950 via-navy-900 to-maroon-950 overflow-hidden">
                            <div class="absolute inset-0 hero-gradient-mesh opacity-80"></div>
                            <div class="absolute -right-12 -top-12 h-44 w-44 rounded-full bg-gold-500/15 blur-2xl"></div>
                            <div class="absolute -left-12 -bottom-12 h-44 w-44 rounded-full bg-maroon-600/20 blur-2xl"></div>
                            <div class="absolute top-4 right-6">
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-white/10 px-3 py-1 text-xs font-semibold text-white/80 ring-1 ring-white/15 backdrop-blur-md">
                                    <?php echo e($membership->tier?->name ?? 'Member'); ?>

                                </span>
                            </div>
                        </div>

                        
                        <div class="relative px-6 sm:px-8 pb-6">
                            <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 -mt-16 mb-5">
                                <div class="flex items-end gap-5">
                                    <div class="relative">
                                        <div class="h-28 w-28 sm:h-32 sm:w-32 shrink-0 overflow-hidden rounded-2xl bg-white ring-4 ring-white shadow-xl shadow-navy-950/20">
                                            <?php if($alumni->profile_photo): ?>
                                                <img src="<?php echo e($alumni->profile_photo_url); ?>" alt="<?php echo e($alumni->full_name); ?>" class="h-full w-full object-cover">
                                            <?php else: ?>
                                                <div class="flex h-full w-full items-center justify-center font-serif text-4xl font-bold text-navy-400 bg-gradient-to-br from-slate-100 to-slate-200">
                                                    <?php echo e(strtoupper(substr($alumni->full_name, 0, 2))); ?>

                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <span class="absolute -bottom-1.5 -right-1.5 flex h-7 w-7 items-center justify-center rounded-full bg-emerald-500 ring-2 ring-white shadow-sm" title="Active">
                                            <svg class="h-4 w-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                            </svg>
                                        </span>
                                    </div>

                                    <div class="min-w-0 pb-1">
                                        <h2 class="font-serif text-2xl sm:text-3xl font-bold tracking-tight text-navy-950 truncate">
                                            <?php echo e($alumni->full_name); ?>

                                        </h2>
                                        <p class="text-sm font-medium text-ink-soft mt-0.5 truncate"><?php echo e($alumni->email); ?></p>
                                        <?php if($alumni->phone): ?>
                                            <p class="text-xs text-ink-soft mt-0.5 font-mono"><?php echo e($alumni->phone); ?></p>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div class="flex items-center gap-2.5 sm:self-end sm:pb-2">
                                    <a href="<?php echo e(route('member.profile.edit')); ?>" class="inline-flex items-center gap-2 rounded-xl bg-navy-900 px-4 py-2 text-xs font-semibold text-white shadow-xs hover:bg-navy-800 transition-colors">
                                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/></svg>
                                        Edit Details
                                    </a>
                                </div>
                            </div>

                            
                            <div class="rounded-xl border border-navy-100/70 bg-slate-50/70 p-4 mt-2">
                                <div class="flex items-center justify-between mb-2">
                                    <div class="flex items-center gap-2">
                                        <span class="h-2 w-2 rounded-full <?php echo e($alumni->profileCompletionPercentage() >= 80 ? 'bg-emerald-500' : 'bg-amber-500'); ?>"></span>
                                        <span class="text-xs font-bold text-navy-950 uppercase tracking-wider">Profile Strength</span>
                                    </div>
                                    <span class="text-xs font-bold text-navy-900 font-mono"><?php echo e($alumni->profileCompletionPercentage()); ?>%</span>
                                </div>
                                <div class="w-full h-2 rounded-full bg-navy-100 overflow-hidden">
                                    <div class="h-full rounded-full <?php echo e($alumni->profileCompletionPercentage() >= 80 ? 'bg-emerald-500' : 'bg-amber-500'); ?> transition-all duration-500" style="width: <?php echo e($alumni->profileCompletionPercentage()); ?>%"></div>
                                </div>
                                <?php if($alumni->profileCompletionPercentage() < 100): ?>
                                    <p class="mt-2 text-[11px] text-ink-soft">
                                        Complete remaining fields in your profile to maximize professional networking and alumni directory discovery.
                                    </p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        <div class="rounded-2xl border border-navy-100/80 bg-white p-6 shadow-sm">
                            <div class="flex items-center gap-3 border-b border-navy-50 pb-4 mb-5">
                                <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-navy-50 text-navy-700">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5"/>
                                    </svg>
                                </div>
                                <h3 class="font-serif text-base font-bold text-navy-950">Academic Heritage</h3>
                            </div>

                            <dl class="space-y-4 text-xs">
                                <div>
                                    <dt class="font-bold uppercase tracking-wider text-ink-soft">Student ID</dt>
                                    <dd class="mt-1 text-sm font-semibold font-mono text-navy-950"><?php echo e($alumni->student_id); ?></dd>
                                </div>
                                <div>
                                    <dt class="font-bold uppercase tracking-wider text-ink-soft">Batch & Graduation</dt>
                                    <dd class="mt-1 text-sm font-semibold text-navy-950">
                                        Batch <?php echo e($alumni->batch ?? '-'); ?> &bull; Class of <?php echo e($alumni->graduation_year ?? '-'); ?>

                                    </dd>
                                </div>
                                <div>
                                    <dt class="font-bold uppercase tracking-wider text-ink-soft">Department & Institution</dt>
                                    <dd class="mt-1 text-sm font-medium text-navy-900">
                                        Department of English<br>
                                        <span class="text-ink-soft">Govt. Kabi Nazrul College, Dhaka</span>
                                    </dd>
                                </div>
                            </dl>
                        </div>

                        
                        <div class="rounded-2xl border border-navy-100/80 bg-white p-6 shadow-sm">
                            <div class="flex items-center gap-3 border-b border-navy-50 pb-4 mb-5">
                                <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-navy-50 text-navy-700">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z"/>
                                    </svg>
                                </div>
                                <h3 class="font-serif text-base font-bold text-navy-950">Professional Journey</h3>
                            </div>

                            <dl class="space-y-4 text-xs">
                                <div>
                                    <dt class="font-bold uppercase tracking-wider text-ink-soft">Profession & Role</dt>
                                    <dd class="mt-1 text-sm font-semibold text-navy-950">
                                        <?php echo e($alumni->profession ?? '-'); ?>

                                    </dd>
                                </div>
                                <div>
                                    <dt class="font-bold uppercase tracking-wider text-ink-soft">Organization / Employer</dt>
                                    <dd class="mt-1 text-sm font-semibold text-navy-950">
                                        <?php echo e($alumni->organization ?: 'Not specified'); ?>

                                    </dd>
                                </div>
                                <div>
                                    <dt class="font-bold uppercase tracking-wider text-ink-soft">Location</dt>
                                    <dd class="mt-1 text-sm font-medium text-navy-900">
                                        <?php echo e(collect([$alumni->city, $alumni->country])->filter()->implode(', ') ?: 'Not specified'); ?>

                                    </dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                    
                    <div class="rounded-2xl border border-navy-100/80 bg-white p-6 shadow-sm space-y-6">
                        <?php if($alumni->website_url || $alumni->linkedin_url): ?>
                            <div>
                                <h3 class="text-xs font-bold uppercase tracking-wider text-ink-soft mb-3">Online Presence</h3>
                                <div class="flex flex-wrap items-center gap-3">
                                    <?php if($alumni->website_url): ?>
                                        <a href="<?php echo e(\App\Support\UrlHelper::safeHref($alumni->website_url)); ?>" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 rounded-xl border border-navy-100 bg-slate-50 px-4 py-2 text-xs font-semibold text-navy-800 hover:bg-navy-100/80 hover:text-navy-950 transition-colors">
                                            <svg class="h-4 w-4 text-navy-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-1.605.42-3.113 1.157-4.418"/></svg>
                                            Website
                                        </a>
                                    <?php endif; ?>
                                    <?php if($alumni->linkedin_url): ?>
                                        <a href="<?php echo e(\App\Support\UrlHelper::safeHref($alumni->linkedin_url)); ?>" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 rounded-xl border border-navy-100 bg-slate-50 px-4 py-2 text-xs font-semibold text-navy-800 hover:bg-navy-100/80 hover:text-navy-950 transition-colors">
                                            <svg class="h-4 w-4 text-[#0A66C2]" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                                            LinkedIn Profile
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        
                        <div class="border-t border-navy-50 pt-5">
                            <h3 class="text-xs font-bold uppercase tracking-wider text-ink-soft mb-2.5">Biography & Statement</h3>
                            <?php if($alumni->bio): ?>
                                <div class="rounded-xl bg-slate-50/70 border border-navy-100/60 p-5 text-sm text-navy-900 leading-relaxed italic relative">
                                    <span class="text-3xl text-navy-300 font-serif absolute top-2 left-3">"</span>
                                    <p class="relative z-10 pl-4"><?php echo e($alumni->bio); ?></p>
                                </div>
                            <?php else: ?>
                                <div class="rounded-xl border border-dashed border-navy-200 p-6 text-center">
                                    <p class="text-sm font-medium text-navy-700">No biography provided yet.</p>
                                    <p class="text-xs text-ink-soft mt-1">Share a few words about your educational background and career journey.</p>
                                    <a href="<?php echo e(route('member.profile.edit')); ?>" class="mt-3 inline-flex items-center gap-1.5 text-xs font-semibold text-maroon-700 hover:text-maroon-800 hover:underline">
                                        Add Biography &rarr;
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </main>
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
<?php /**PATH C:\xampp\htdocs\ProDo\EDAA\resources\views\member\profile\show.blade.php ENDPATH**/ ?>