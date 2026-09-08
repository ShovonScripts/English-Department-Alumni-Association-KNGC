<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'title' => null,
    'description' => null,
    'eyebrow' => null,
    'breadcrumbs' => [],
]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter(([
    'title' => null,
    'description' => null,
    'eyebrow' => null,
    'breadcrumbs' => [],
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<section class="relative overflow-hidden bg-navy-950 text-white">
    
    <div class="pointer-events-none absolute inset-0 opacity-[0.06]" aria-hidden="true">
        <div class="absolute -right-24 -top-24 h-96 w-96 rounded-full border-2 border-gold-400"></div>
        <div class="absolute -right-10 top-10 h-64 w-64 rounded-full border border-white/60"></div>
        <div class="absolute bottom-0 left-1/4 h-40 w-40 rounded-full border border-gold-500/70"></div>
    </div>

    <div class="container-page relative py-14 sm:py-20 lg:py-24">
        <?php if (isset($component)) { $__componentOriginale19f62b34dfe0bfdf95075badcb45bc2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale19f62b34dfe0bfdf95075badcb45bc2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.breadcrumb','data' => ['items' => $breadcrumbs,'class' => 'mb-6 sm:mb-8']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('breadcrumb'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['items' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($breadcrumbs),'class' => 'mb-6 sm:mb-8']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale19f62b34dfe0bfdf95075badcb45bc2)): ?>
<?php $attributes = $__attributesOriginale19f62b34dfe0bfdf95075badcb45bc2; ?>
<?php unset($__attributesOriginale19f62b34dfe0bfdf95075badcb45bc2); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale19f62b34dfe0bfdf95075badcb45bc2)): ?>
<?php $component = $__componentOriginale19f62b34dfe0bfdf95075badcb45bc2; ?>
<?php unset($__componentOriginale19f62b34dfe0bfdf95075badcb45bc2); ?>
<?php endif; ?>

        <div class="max-w-3xl">
            <?php if($eyebrow): ?>
                <p class="mb-3 inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-[0.2em] text-gold-300">
                    <span class="inline-block h-px w-8 bg-gold-500" aria-hidden="true"></span>
                    <?php echo e($eyebrow); ?>

                </p>
            <?php endif; ?>

            <?php if($title): ?>
                <h1 class="font-serif text-4xl font-semibold leading-tight tracking-tight sm:text-5xl">
                    <?php echo e($title); ?>

                </h1>
            <?php endif; ?>

            <?php if($description): ?>
                <p class="mt-5 max-w-2xl text-base leading-relaxed text-navy-100 sm:text-lg">
                    <?php echo e($description); ?>

                </p>
            <?php endif; ?>
        </div>
    </div>
</section><?php /**PATH C:\xampp\htdocs\ProDo\EDAA\resources\views\components\page-header.blade.php ENDPATH**/ ?>