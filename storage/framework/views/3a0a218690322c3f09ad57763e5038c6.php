<?php if (isset($component)) { $__componentOriginal5863877a5171c196453bfa0bd807e410 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5863877a5171c196453bfa0bd807e410 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.app','data' => ['title' => ''.e($type->name).' — Committee History','description' => 'Browse all past and present '.e(strtolower($type->name)).' of the EDAA.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.app'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => ''.e($type->name).' — Committee History','description' => 'Browse all past and present '.e(strtolower($type->name)).' of the EDAA.']); ?>

    <?php if (isset($component)) { $__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.page-header','data' => ['title' => ''.e($type->name).'','description' => 'Committee history — past and present.','eyebrow' => 'History','breadcrumbs' => [
            ['label' => 'Home', 'href' => route('home')],
            ['label' => 'Committees', 'href' => route('committees.index')],
            ['label' => 'History'],
        ]]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('page-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => ''.e($type->name).'','description' => 'Committee history — past and present.','eyebrow' => 'History','breadcrumbs' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
            ['label' => 'Home', 'href' => route('home')],
            ['label' => 'Committees', 'href' => route('committees.index')],
            ['label' => 'History'],
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
        <div class="container-page mx-auto max-w-4xl">

            <?php if($committees->isEmpty()): ?>
                <div class="rounded-2xl border border-dashed border-navy-200 bg-white/60 p-12 text-center">
                    <p class="text-ink-soft">No committees of this type exist yet.</p>
                </div>
            <?php else: ?>
                <div class="space-y-8">
                    <?php $__currentLoopData = $committees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $committee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a href="<?php echo e(route('committees.show', ['type' => $type, 'committee' => $committee])); ?>" class="group block rounded-2xl border border-navy-100 bg-white p-6 shadow-sm transition-all hover:shadow-md hover:-translate-y-0.5 relative overflow-hidden">
                            <?php if($committee->is_current): ?>
                                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-gold-500 via-gold-400 to-maroon-500"></div>
                            <?php endif; ?>

                            <div class="flex flex-wrap items-center justify-between gap-4">
                                <div>
                                    <div class="flex items-center gap-3">
                                        <h3 class="font-serif text-lg font-semibold text-navy-950 group-hover:text-maroon-700 transition-colors"><?php echo e($committee->name); ?></h3>
                                        <?php if($committee->is_current): ?>
                                            <span class="inline-flex items-center gap-1 rounded-full bg-gold-500/15 px-2 py-0.5 text-[10px] font-semibold uppercase tracking-widest text-gold-700">Current</span>
                                        <?php endif; ?>
                                    </div>
                                    <p class="mt-1 text-sm text-ink-soft"><?php echo e($committee->yearRange()); ?> &middot; <?php echo e($committee->members()->count()); ?> <?php echo e(Str::plural('member', $committee->members()->count())); ?></p>
                                    <?php if($committee->description): ?>
                                        <p class="mt-2 text-sm text-ink-soft line-clamp-2"><?php echo e($committee->description); ?></p>
                                    <?php endif; ?>
                                </div>
                                <svg class="h-5 w-5 text-navy-300 group-hover:text-maroon-500 transition-colors shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg>
                            </div>
                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
<?php /**PATH C:\xampp\htdocs\ProDo\EDAA\resources\views\pages\committees\history.blade.php ENDPATH**/ ?>