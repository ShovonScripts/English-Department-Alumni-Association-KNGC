<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'href' => null,
    'variant' => 'navy',
    'size' => 'md',
    'icon' => false,
    'type' => 'button',
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
    'href' => null,
    'variant' => 'navy',
    'size' => 'md',
    'icon' => false,
    'type' => 'button',
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $variants = [
        'navy' => 'shine bg-navy-800 text-white hover:bg-navy-700 focus-visible:ring-navy-500 shadow-lg shadow-navy-900/20',
        'gold' => 'shine bg-gold-500 text-navy-950 hover:bg-gold-400 focus-visible:ring-gold-400 shadow-lg shadow-gold-500/25',
        'maroon' => 'shine bg-maroon-700 text-white hover:bg-maroon-600 focus-visible:ring-maroon-500 shadow-lg shadow-maroon-900/20',
        'outline' => 'shine border border-navy-300 text-navy-900 hover:border-navy-600 hover:bg-navy-50 focus-visible:ring-navy-500',
        'outline-on-dark' => 'shine border border-white/30 text-white hover:border-gold-300 hover:text-gold-300 hover:bg-white/5 focus-visible:ring-white',
        'ghost' => 'text-navy-800 hover:bg-navy-50 focus-visible:ring-navy-500',
        'light' => 'shine bg-white text-navy-900 hover:bg-cream focus-visible:ring-white shadow-lg shadow-gray-200/50',
    ];

    $sizes = [
        'sm' => 'px-3.5 py-2 text-sm',
        'md' => 'px-5 py-2.5 text-sm',
        'lg' => 'px-6 py-3 text-base',
    ];

    $classes = $variants[$variant] ?? $variants['navy'];
    $sizeClasses = $sizes[$size] ?? $sizes['md'];
    $base = 'focus-ring inline-flex items-center justify-center gap-2 rounded-lg font-semibold transition-all duration-200 disabled:cursor-not-allowed disabled:opacity-60';
?>

<?php if($href): ?>
    <a href="<?php echo e($href); ?>" <?php echo e($attributes->merge(['class' => "{$base} {$classes} {$sizeClasses}"])); ?>>
        <?php echo e($slot); ?>

        <?php if($icon): ?>
            <svg class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" />
            </svg>
        <?php endif; ?>
    </a>
<?php else: ?>
    <button type="<?php echo e($type); ?>" <?php echo e($attributes->merge(['class' => "{$base} {$classes} {$sizeClasses}"])); ?>>
        <?php echo e($slot); ?>

        <?php if($icon): ?>
            <svg class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" />
            </svg>
        <?php endif; ?>
    </button>
<?php endif; ?><?php /**PATH C:\xampp\htdocs\ProDo\EDAA\resources\views/components/button.blade.php ENDPATH**/ ?>