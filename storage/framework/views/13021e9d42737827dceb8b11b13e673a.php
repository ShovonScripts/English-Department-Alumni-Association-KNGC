<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'label' => null,
    'value' => null,
    'hint' => null,
    'icon' => null,
    'accent' => false,
    'href' => null,
    'badge' => null,
    'trend' => null,
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
    'label' => null,
    'value' => null,
    'hint' => null,
    'icon' => null,
    'accent' => false,
    'href' => null,
    'badge' => null,
    'trend' => null,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $tag = $href ? 'a' : 'div';
    $baseClass = $accent
        ? 'bg-gradient-to-br from-maroon-700 via-maroon-800 to-navy-950 text-white border border-maroon-600/50 shadow-md shadow-maroon-950/20'
        : 'bg-white text-navy-950 border border-navy-100 shadow-sm hover:border-gold-300/80 hover:shadow-md';
    $interactiveClass = $href
        ? 'group cursor-pointer transition-all duration-300 transform hover:-translate-y-1 block focus:outline-none focus:ring-2 focus:ring-gold-500 focus:ring-offset-2'
        : 'group transition-all duration-300';
?>

<<?php echo e($tag); ?>

    <?php if($href): ?> href="<?php echo e($href); ?>" <?php endif; ?>
    class="relative overflow-hidden rounded-2xl p-6 <?php echo e($baseClass); ?> <?php echo e($interactiveClass); ?>"
>
    
    <div class="pointer-events-none absolute -right-6 -top-6 h-28 w-28 rounded-full <?php echo e($accent ? 'bg-gold-400/10' : 'bg-navy-500/5 group-hover:bg-gold-400/10'); ?> blur-2xl transition-all duration-500 group-hover:scale-150"></div>

    <div class="relative flex items-center justify-between">
        <p class="text-xs font-bold uppercase tracking-wider <?php echo e($accent ? 'text-gold-200/90' : 'text-navy-500'); ?>">
            <?php echo e($label); ?>

        </p>
        <div class="flex items-center gap-2">
            <?php if($badge): ?>
                <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-semibold <?php echo e($accent ? 'bg-white/20 text-white' : 'bg-gold-50 text-gold-700 border border-gold-200'); ?>">
                    <?php echo e($badge); ?>

                </span>
            <?php endif; ?>
            <?php if($icon): ?>
                <span class="flex h-11 w-11 items-center justify-center rounded-xl <?php echo e($accent ? 'bg-white/10 text-gold-300 ring-1 ring-white/20 shadow-inner' : 'bg-gradient-to-br from-navy-50 to-navy-100/80 text-navy-700 ring-1 ring-navy-200/60 shadow-sm group-hover:from-gold-50 group-hover:to-gold-100 group-hover:text-gold-600 group-hover:ring-gold-300/70 transition-all duration-300'); ?>">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="<?php echo e($icon); ?>" />
                    </svg>
                </span>
            <?php endif; ?>
        </div>
    </div>

    <div class="relative mt-4 flex items-baseline justify-between">
        <p class="font-serif text-3xl sm:text-4xl font-semibold tracking-tight <?php echo e($accent ? 'text-white' : 'text-navy-950'); ?>">
            <?php echo e($value); ?>

        </p>
        <?php if($href): ?>
            <span class="opacity-0 translate-x-1 group-hover:opacity-100 group-hover:translate-x-0 transition-all duration-300 <?php echo e($accent ? 'text-gold-300' : 'text-navy-400 group-hover:text-gold-600'); ?>">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                </svg>
            </span>
        <?php endif; ?>
    </div>

    <?php if($hint || $trend): ?>
        <div class="relative mt-2 flex items-center justify-between text-xs <?php echo e($accent ? 'text-maroon-100/80' : 'text-navy-500'); ?>">
            <?php if($hint): ?>
                <span><?php echo e($hint); ?></span>
            <?php endif; ?>
            <?php if($trend): ?>
                <span class="font-medium text-emerald-600"><?php echo e($trend); ?></span>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</<?php echo e($tag); ?>><?php /**PATH C:\xampp\htdocs\ProDo\EDAA\resources\views/components/admin/stat-card.blade.php ENDPATH**/ ?>