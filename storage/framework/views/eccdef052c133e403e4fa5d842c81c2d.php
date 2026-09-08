<?php if (isset($component)) { $__componentOriginal5863877a5171c196453bfa0bd807e410 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5863877a5171c196453bfa0bd807e410 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.app','data' => ['title' => ''.e($committee->name).'','description' => ''.e($committee->description).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.app'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => ''.e($committee->name).'','description' => ''.e($committee->description).'']); ?>

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

        @keyframes fade-in {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in { animation: fade-in 0.4s ease-out forwards; }
    </style>
    <?php $__env->stopPush(); ?>

    <?php if (isset($component)) { $__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.page-header','data' => ['title' => ''.e($committee->name).'','description' => ''.e($committee->type?->name).' &middot; '.e($committee->yearRange()).'','eyebrow' => 'Committee','breadcrumbs' => [
            ['label' => 'Home', 'href' => route('home')],
            ['label' => 'Committees', 'href' => route('committees.index')],
            ['label' => $committee->name],
        ]]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('page-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => ''.e($committee->name).'','description' => ''.e($committee->type?->name).' &middot; '.e($committee->yearRange()).'','eyebrow' => 'Committee','breadcrumbs' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
            ['label' => 'Home', 'href' => route('home')],
            ['label' => 'Committees', 'href' => route('committees.index')],
            ['label' => $committee->name],
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

    <section class="section-pad bg-cream">
        <div class="container-page">
            <div class="flex flex-col gap-8 lg:flex-row">

                
                <aside class="w-full shrink-0 lg:w-72">
                    <div class="committee-sidebar rounded-xl border border-navy-100 bg-white p-4 shadow-sm">
                        <h3 class="mb-4 px-3 font-serif text-sm font-semibold uppercase tracking-wider text-navy-500">All Committees</h3>
                        <nav class="space-y-1">
                            <?php $__currentLoopData = $allCommittees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <a href="<?php echo e(route('committees.show', $c)); ?>"
                                   class="committee-item flex items-center gap-3 rounded-lg px-3 py-3 text-sm transition-all <?php echo e($committee->id === $c->id ? 'active' : ''); ?>">
                                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg <?php echo e($c->is_current ? 'bg-gold-500/15 text-gold-600' : 'bg-navy-100 text-navy-500'); ?>">
                                        <?php if($c->is_current): ?>
                                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z" /></svg>
                                        <?php else: ?>
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                                        <?php endif; ?>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <div class="flex items-center gap-2">
                                            <span class="truncate font-medium text-navy-950 <?php echo e($committee->id === $c->id ? 'text-maroon-700' : ''); ?>">
                                                <?php echo e($c->name); ?>

                                            </span>
                                            <?php if($c->is_current): ?>
                                                <span class="shrink-0 rounded-full bg-gold-500/15 px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider text-gold-600">Current</span>
                                            <?php endif; ?>
                                        </div>
                                        <span class="text-xs text-ink-soft"><?php echo e($c->yearRange()); ?></span>
                                    </div>
                                    <svg class="h-4 w-4 shrink-0 text-navy-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg>
                                </a>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </nav>
                    </div>
                </aside>

                
                <div class="min-w-0 flex-1">
                    <div class="animate-fade-in rounded-xl border border-navy-100 bg-white p-6 shadow-sm sm:p-8">

                        
                        <div class="mb-8 text-center">
                            <?php if($committee->is_current): ?>
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-gold-500/15 px-3 py-1 text-xs font-semibold uppercase tracking-widest text-gold-700 mb-3">
                                    <span class="h-1.5 w-1.5 rounded-full bg-gold-500"></span>
                                    Current Committee
                                </span>
                            <?php endif; ?>
                            <h2 class="font-serif text-2xl font-bold text-navy-950 sm:text-3xl"><?php echo e($committee->name); ?></h2>
                            <p class="mt-1 text-sm text-ink-soft"><?php echo e($type->name); ?> &middot; <?php echo e($committee->yearRange()); ?></p>
                            <?php if($committee->description): ?>
                                <p class="mt-3 text-ink-soft max-w-2xl mx-auto"><?php echo e($committee->description); ?></p>
                            <?php endif; ?>
                        </div>

                        
                        <?php if($groupedMembers->isEmpty()): ?>
                            <div class="rounded-lg border border-dashed border-navy-200 bg-navy-50/50 p-12 text-center">
                                <p class="text-ink-soft">No members assigned to this committee yet.</p>
                            </div>
                        <?php else: ?>
                            <?php $__currentLoopData = $groupedMembers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="mb-8 last:mb-0">
                                    <div class="mb-4 text-center">
                                        <h3 class="font-serif text-lg font-semibold text-navy-950"><?php echo e($group['role']->name); ?></h3>
                                        <div class="mt-1.5 mx-auto h-px w-12 bg-gold-500"></div>
                                    </div>
                                    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                                        <?php $__currentLoopData = $group['members']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="group flex items-center gap-4 rounded-lg border border-navy-100 p-4 transition-all hover:shadow-md hover:-translate-y-0.5">
                                                <?php if($member->alumni?->profile_photo_url): ?>
                                                    <img src="<?php echo e($member->alumni->profile_photo_url); ?>" alt="<?php echo e($member->alumni?->full_name); ?>" class="h-12 w-12 shrink-0 rounded-full object-cover object-top ring-2 ring-gold-500/30">
                                                <?php else: ?>
                                                    <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-navy-900 font-serif text-sm font-bold text-gold-300">
                                                        <?php echo e(\Illuminate\Support\Str::initials($member->alumni?->full_name ?? '')); ?>

                                                    </span>
                                                <?php endif; ?>
                                                <div class="min-w-0">
                                                    <p class="font-semibold text-navy-950 truncate"><?php echo e($member->alumni?->full_name ?? 'Unknown'); ?></p>
                                                    <?php if($member->alumni?->batch): ?>
                                                        <p class="text-xs text-ink-soft flex items-center gap-1 truncate">
                                                            <svg class="h-3 w-3 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                                                            Batch <?php echo e($member->alumni->batch); ?>

                                                        </p>
                                                    <?php endif; ?>
                                                    <?php if($member->alumni?->profession): ?>
                                                        <p class="text-xs text-ink-soft truncate"><?php echo e($member->alumni->profession); ?></p>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
<?php /**PATH C:\xampp\htdocs\ProDo\EDAA\resources\views\pages\committees\show.blade.php ENDPATH**/ ?>