<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'value' => null,
    'label' => null,
    'accent' => false,
    'icon' => null,
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
    'value' => null,
    'label' => null,
    'accent' => false,
    'icon' => null,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<div class="card-lift shine group relative overflow-hidden rounded-2xl border p-6 text-center shadow-sm transition-all duration-300 sm:p-8 <?php echo e($accent ? 'border-gold-500/40 bg-gradient-to-br from-maroon-800 via-maroon-700 to-maroon-900 text-white shadow-maroon-950/20' : 'border-navy-100 bg-white/90 backdrop-blur-md hover:border-gold-400/50 hover:shadow-md'); ?>">
    <?php if($icon): ?>
        <div class="mx-auto mb-3 flex h-10 w-10 items-center justify-center rounded-xl <?php echo e($accent ? 'bg-white/15 text-gold-300' : 'bg-navy-50 text-navy-800 group-hover:bg-gold-500/15 group-hover:text-gold-600'); ?> transition-colors">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="<?php echo e($icon); ?>" />
            </svg>
        </div>
    <?php endif; ?>
    <p class="font-serif text-3xl font-bold tracking-tight sm:text-4xl lg:text-5xl <?php echo e($accent ? 'text-gold-300' : 'text-navy-950 group-hover:text-maroon-700'); ?> transition-colors">
        <?php echo e($value); ?>

    </p>
    <p class="mt-2 text-xs sm:text-sm font-semibold uppercase tracking-wider <?php echo e($accent ? 'text-maroon-100' : 'text-ink-soft'); ?>">
        <?php echo e($label); ?>

    </p>
    <div class="mx-auto mt-4 h-0.5 w-8 rounded-full transition-all duration-300 group-hover:w-16 <?php echo e($accent ? 'bg-gold-400' : 'bg-gold-400/40 group-hover:bg-gold-500'); ?>"></div>
</div><?php /**PATH C:\xampp\htdocs\ProDo\EDAA\resources\views/components/stat.blade.php ENDPATH**/ ?>