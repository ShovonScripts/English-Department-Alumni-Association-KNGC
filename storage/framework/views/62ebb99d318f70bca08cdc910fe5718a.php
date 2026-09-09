<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'title' => null,
    'type' => null,
    'author' => null,
    'year' => null,
    'description' => null,
    'href' => null,
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
    'type' => null,
    'author' => null,
    'year' => null,
    'description' => null,
    'href' => null,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<article class="card-lift shine group relative flex h-full flex-col rounded-2xl border border-navy-100 bg-white/95 p-6 sm:p-7 shadow-sm backdrop-blur-md transition-all duration-300 hover:border-gold-400/60 hover:shadow-xl">
    <?php if($href): ?>
        <a href="<?php echo e($href); ?>" class="focus-ring absolute inset-0 z-10 rounded-2xl" aria-label="View publication: <?php echo e($title); ?>"></a>
    <?php endif; ?>

    <div class="flex items-start justify-between gap-4">
        <span class="inline-flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-gradient-to-br from-navy-950 to-navy-900 text-gold-300 shadow ring-1 ring-gold-500/30 transition-transform duration-300 group-hover:scale-105">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.3v11.4m0-11.4A3.2 3.2 0 009.5 3.5H6.5v13h3a3.2 3.2 0 013 2.8m-.5-12.9a3.2 3.2 0 012.5-2.8h3v13h-3a3.2 3.2 0 00-3 2.8m0-12.9v11.4" />
            </svg>
        </span>
        <?php if($type): ?>
            <span class="inline-flex rounded-full border border-maroon-200 bg-maroon-50 px-3 py-1 text-xs font-bold uppercase tracking-wider text-maroon-700 shadow-xs">
                <?php echo e($type); ?>

            </span>
        <?php endif; ?>
    </div>

    <?php if($title): ?>
        <h3 class="mt-5 font-serif text-lg font-bold leading-snug text-navy-950 transition-colors group-hover:text-maroon-700">
            <?php echo e($title); ?>

        </h3>
    <?php endif; ?>

    <?php if($author || $year): ?>
        <p class="mt-1.5 text-xs font-semibold uppercase tracking-wider text-ink-soft">
            <?php echo e(collect([$author ? 'By '.$author : null, $year])->filter()->implode(' · ')); ?>

        </p>
    <?php endif; ?>

    <?php if($description): ?>
        <p class="mt-3 flex-1 text-xs leading-relaxed text-ink-soft line-clamp-3">
            <?php echo e($description); ?>

        </p>
    <?php endif; ?>

    <div class="mt-4 flex items-center justify-between border-t border-navy-50 pt-4">
        <span class="inline-flex items-center gap-1 text-xs font-bold uppercase tracking-wider text-maroon-600 transition-colors group-hover:text-maroon-800">
            Read Publication &rarr;
        </span>
        <span class="text-[10px] font-semibold text-navy-400 uppercase">EDAA Library</span>
    </div>
</article><?php /**PATH C:\xampp\htdocs\ProDo\EDAA\resources\views/components/publication-card.blade.php ENDPATH**/ ?>