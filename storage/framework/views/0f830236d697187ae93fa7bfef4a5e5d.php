<?php if (isset($component)) { $__componentOriginal5863877a5171c196453bfa0bd807e410 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5863877a5171c196453bfa0bd807e410 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.app','data' => ['title' => 'Our Committees','description' => 'Meet the committees of the English Department Alumni Association KNGC.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.app'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Our Committees','description' => 'Meet the committees of the English Department Alumni Association KNGC.']); ?>

    <?php $__env->startPush('styles'); ?>
    <style>
        .committee-sidebar {
            position: sticky;
            top: 100px;
            max-height: calc(100vh - 120px);
            overflow-y: auto;
            scrollbar-width: thin;
            scrollbar-color: rgba(212,170,62,0.3) transparent;
        }
        .committee-sidebar::-webkit-scrollbar { width: 4px; }
        .committee-sidebar::-webkit-scrollbar-track { background: transparent; }
        .committee-sidebar::-webkit-scrollbar-thumb { background: rgba(212,170,62,0.3); border-radius: 4px; }

        .committee-item {
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
        }
        .committee-item:hover {
            border-left-color: rgba(212,170,62,0.5);
            background: rgba(212,170,62,0.05);
        }
        .committee-item.active {
            border-left-color: #d4aa3e;
            background: rgba(212,170,62,0.1);
        }

        .member-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .member-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
        }

        .role-section {
            position: relative;
        }
        .role-section::before {
            content: '';
            position: absolute;
            left: 50%;
            top: 0;
            bottom: 0;
            width: 1px;
            background: linear-gradient(to bottom, transparent, rgba(212,170,62,0.3), transparent);
            transform: translateX(-50%);
        }

        @keyframes fade-in-up {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in-up {
            animation: fade-in-up 0.5s ease-out forwards;
        }

        .hero-pattern {
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23d4aa3e' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
    </style>
    <?php $__env->stopPush(); ?>

    
    <?php if($selectedCommittee): ?>
    <section class="relative overflow-hidden bg-gradient-to-br from-navy-950 via-navy-900 to-maroon-950 py-16 sm:py-20 hero-pattern">
        <div class="absolute inset-0 bg-gradient-to-t from-navy-950/50 to-transparent"></div>
        <div class="relative container-page text-center">
            <span class="inline-flex items-center gap-2 rounded-full border border-gold-500/30 bg-gold-500/10 px-4 py-1.5 text-xs font-semibold uppercase tracking-widest text-gold-300 mb-6">
                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z"/></svg>
                Leadership
            </span>
            <h1 class="font-serif text-4xl font-bold text-white sm:text-5xl lg:text-6xl">
                Executive Committee
            </h1>
            <p class="mt-4 text-lg text-navy-200 max-w-2xl mx-auto">
                The dedicated volunteers who guide our alumni association with vision, integrity, and passion.
            </p>
            <div class="mt-8 flex items-center justify-center gap-8 text-sm">
                <div class="text-center">
                    <span class="block text-3xl font-bold text-gold-300"><?php echo e($groupedMembers->sum(fn($g) => $g['members']->count())); ?></span>
                    <span class="text-navy-300">Members</span>
                </div>
                <div class="h-8 w-px bg-white/20"></div>
                <div class="text-center">
                    <span class="block text-3xl font-bold text-gold-300"><?php echo e($groupedMembers->count()); ?></span>
                    <span class="text-navy-300">Roles</span>
                </div>
                <div class="h-8 w-px bg-white/20"></div>
                <div class="text-center">
                    <span class="block text-3xl font-bold text-gold-300"><?php echo e($selectedCommittee->yearRange()); ?></span>
                    <span class="text-navy-300">Term</span>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <section class="section-pad bg-cream">
        <div class="container-page">

            <?php if($allCommittees->isEmpty()): ?>
                <div class="mx-auto max-w-lg rounded-2xl border border-dashed border-navy-200 bg-white/80 p-12 text-center">
                    <svg class="mx-auto h-12 w-12 text-navy-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                    <h3 class="mt-4 font-serif text-xl font-semibold text-navy-950">Committees Coming Soon</h3>
                    <p class="mt-2 text-sm text-ink-soft">Our committee information will be available here shortly.</p>
                </div>
            <?php else: ?>
                <div class="flex flex-col gap-8 lg:flex-row">

                    
                    <aside class="w-full shrink-0 lg:w-80">
                        <div class="committee-sidebar rounded-2xl border border-navy-100 bg-white p-5 shadow-sm">
                            <h3 class="mb-5 px-3 font-serif text-sm font-semibold uppercase tracking-wider text-navy-500 flex items-center gap-2">
                                <svg class="h-4 w-4 text-gold-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 10h16M4 14h16M4 18h16" /></svg>
                                All Committees
                            </h3>
                            <nav class="space-y-1.5">
                                <?php $__currentLoopData = $allCommittees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $committee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <a href="<?php echo e(route('committees.show', [$committee->type, $committee])); ?>"
                                       class="committee-item flex items-center gap-3 rounded-xl px-3.5 py-3 text-sm transition-all <?php echo e($selectedCommittee?->id === $committee->id ? 'active' : ''); ?>">
                                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl <?php echo e($committee->is_current ? 'bg-gradient-to-br from-gold-500 to-gold-600 text-navy-950 shadow-md shadow-gold-500/20' : 'bg-navy-100 text-navy-500'); ?>">
                                            <?php if($committee->is_current): ?>
                                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z"/></svg>
                                            <?php else: ?>
                                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                                            <?php endif; ?>
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <div class="flex items-center gap-2">
                                                <span class="truncate font-semibold text-navy-950 <?php echo e($selectedCommittee?->id === $committee->id ? 'text-maroon-700' : ''); ?>">
                                                    <?php echo e($committee->name); ?>

                                                </span>
                                                <?php if($committee->is_current): ?>
                                                    <span class="shrink-0 rounded-full bg-gold-500/15 px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider text-gold-600">Current</span>
                                                <?php endif; ?>
                                            </div>
                                            <span class="text-xs text-ink-soft"><?php echo e($committee->yearRange()); ?></span>
                                        </div>
                                        <svg class="h-4 w-4 shrink-0 text-navy-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg>
                                    </a>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </nav>
                        </div>
                    </aside>

                    
                    <div class="min-w-0 flex-1">
                        <?php if($selectedCommittee): ?>
                            <div class="animate-fade-in-up">

                                
                                <div class="rounded-2xl border border-navy-100 bg-white p-6 shadow-sm sm:p-8 mb-8">
                                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                                        <div>
                                            <?php if($selectedCommittee->is_current): ?>
                                                <span class="inline-flex items-center gap-1.5 rounded-full bg-gold-500/15 px-3 py-1 text-xs font-semibold uppercase tracking-widest text-gold-700 mb-3">
                                                    <span class="h-1.5 w-1.5 rounded-full bg-gold-500 animate-pulse"></span>
                                                    Current Committee
                                                </span>
                                            <?php endif; ?>
                                            <h2 class="font-serif text-2xl font-bold text-navy-950 sm:text-3xl"><?php echo e($selectedCommittee->name); ?></h2>
                                            <p class="mt-1 text-sm text-ink-soft"><?php echo e($selectedCommittee->type?->name); ?> &middot; <?php echo e($selectedCommittee->yearRange()); ?></p>
                                        </div>
                                        <div class="flex items-center gap-3">
                                            <div class="text-center px-4 py-2 rounded-xl bg-navy-50">
                                                <span class="block text-2xl font-bold text-navy-950"><?php echo e($groupedMembers->sum(fn($g) => $g['members']->count())); ?></span>
                                                <span class="text-xs text-ink-soft">Members</span>
                                            </div>
                                            <div class="text-center px-4 py-2 rounded-xl bg-navy-50">
                                                <span class="block text-2xl font-bold text-navy-950"><?php echo e($groupedMembers->count()); ?></span>
                                                <span class="text-xs text-ink-soft">Roles</span>
                                            </div>
                                        </div>
                                    </div>
                                    <?php if($selectedCommittee->description): ?>
                                        <p class="mt-4 text-ink-soft max-w-3xl leading-relaxed"><?php echo e($selectedCommittee->description); ?></p>
                                    <?php endif; ?>
                                </div>

                                
                                <?php if($groupedMembers->isEmpty()): ?>
                                    <div class="rounded-2xl border border-dashed border-navy-200 bg-white/60 p-12 text-center">
                                        <svg class="mx-auto h-12 w-12 text-navy-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                                        <p class="mt-4 text-ink-soft">No members assigned to this committee yet.</p>
                                    </div>
                                <?php else: ?>
                                    <?php $__currentLoopData = $groupedMembers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $groupIndex => $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="mb-10 last:mb-0" style="animation-delay: <?php echo e($groupIndex * 0.05); ?>s">
                                            
                                            <div class="mb-6 flex items-center gap-4">
                                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-gradient-to-br from-maroon-700 to-maroon-900 text-gold-300 shadow-lg shadow-maroon-900/20">
                                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                                </div>
                                                <div>
                                                    <h3 class="font-serif text-xl font-bold text-navy-950"><?php echo e($group['role']->name); ?></h3>
                                                    <div class="mt-1 h-0.5 w-8 rounded-full bg-gradient-to-r from-gold-500 to-gold-600"></div>
                                                </div>
                                                <span class="ml-auto rounded-full bg-navy-100 px-3 py-1 text-xs font-semibold text-navy-600">
                                                    <?php echo e($group['members']->count()); ?> <?php echo e(Str::plural('Member', $group['members']->count())); ?>

                                                </span>
                                            </div>

                                            
                                            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                                                <?php $__currentLoopData = $group['members']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $memberIndex => $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <div class="member-card group relative overflow-hidden rounded-2xl border border-navy-100 bg-white p-5 shadow-sm" style="animation-delay: <?php echo e(($groupIndex * 0.05) + ($memberIndex * 0.03)); ?>s">
                                                        
                                                        <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-gold-500 to-gold-600 opacity-0 group-hover:opacity-100 transition-opacity"></div>

                                                        <div class="flex items-start gap-4">
                                                            
                                                            <?php if($member->alumni?->profile_photo_url): ?>
                                                                <img src="<?php echo e($member->alumni->profile_photo_url); ?>" alt="<?php echo e($member->alumni?->full_name); ?>" class="h-14 w-14 shrink-0 rounded-xl object-cover object-top ring-2 ring-gold-500/30 shadow-sm">
                                                            <?php else: ?>
                                                                <span class="flex h-14 w-14 shrink-0 items-center justify-center rounded-xl bg-gradient-to-br from-navy-800 to-navy-900 font-serif text-lg font-bold text-gold-300 shadow-inner">
                                                                    <?php echo e(\Illuminate\Support\Str::initials($member->alumni?->full_name ?? '')); ?>

                                                                </span>
                                                            <?php endif; ?>

                                                            <div class="min-w-0 flex-1">
                                                                <p class="font-bold text-navy-950 truncate group-hover:text-maroon-700 transition-colors"><?php echo e($member->alumni?->full_name ?? 'Unknown'); ?></p>
                                                                <?php if($member->alumni?->batch): ?>
                                                                    <p class="mt-1 text-xs font-medium text-gold-600 bg-gold-50 inline-flex items-center gap-1 px-2 py-0.5 rounded-full">
                                                                        <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                                                                        Batch <?php echo e($member->alumni->batch); ?>

                                                                    </p>
                                                                <?php endif; ?>
                                                                <?php if($member->alumni?->profession): ?>
                                                                    <p class="mt-1.5 text-xs text-ink-soft truncate flex items-center gap-1">
                                                                        <svg class="h-3 w-3 shrink-0 text-navy-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                                                                        <?php echo e($member->alumni->profession); ?>

                                                                    </p>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>

                            </div>
                        <?php else: ?>
                            <div class="rounded-2xl border border-dashed border-navy-200 bg-white/60 p-12 text-center">
                                <svg class="mx-auto h-12 w-12 text-navy-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122" /></svg>
                                <p class="mt-4 text-ink-soft">Select a committee from the sidebar to view its members.</p>
                            </div>
                        <?php endif; ?>
                    </div>

                </div>
            <?php endif; ?>

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
<?php /**PATH C:\xampp\htdocs\ProDo\EDAA\resources\views/pages/committees/index.blade.php ENDPATH**/ ?>