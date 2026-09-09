<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'eyebrow' => null,
    'title' => null,
    'description' => null,
    'align' => 'left',
    'dark' => false,
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
    'eyebrow' => null,
    'title' => null,
    'description' => null,
    'align' => 'left',
    'dark' => false,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $alignment = $align === 'center' ? 'items-center text-center mx-auto' : 'items-start text-left';
    $width = $align === 'center' ? 'max-w-2xl' : 'max-w-3xl';
    $titleColor = $dark ? 'text-white' : 'text-navy-950';
    $descColor = $dark ? 'text-navy-100' : 'text-ink-soft';
    $eyebrowColor = $dark ? 'text-gold-300' : 'text-maroon-600';
?>

<div class="<?php echo e($alignment); ?> flex flex-col <?php echo e($width); ?>">
    <?php if($eyebrow): ?>
        <p class="mb-3 inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-[0.2em] <?php echo e($eyebrowColor); ?>">
            <span class="inline-block h-px w-8 bg-gold-500" aria-hidden="true"></span>
            <?php echo e($eyebrow); ?>

        </p>
    <?php endif; ?>

    <?php if($title): ?>
        <h2 class="font-serif text-3xl font-semibold leading-tight tracking-tight <?php echo e($titleColor); ?> sm:text-4xl">
            <?php echo e($title); ?>

        </h2>
    <?php endif; ?>

    <?php if($description): ?>
        <p class="mt-4 text-base leading-relaxed <?php echo e($descColor); ?> sm:text-lg">
            <?php echo e($description); ?>

        </p>
    <?php endif; ?>
</div><?php /**PATH C:\xampp\htdocs\ProDo\EDAA\resources\views/components/section-heading.blade.php ENDPATH**/ ?>