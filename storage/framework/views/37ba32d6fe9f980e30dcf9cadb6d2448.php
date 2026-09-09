<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'title' => null,
    'category' => null,
    'image' => null,
    'count' => null,
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
    'category' => null,
    'image' => null,
    'count' => null,
    'href' => null,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<figure class="card-lift shine group relative overflow-hidden rounded-2xl border border-navy-100 bg-white shadow-sm backdrop-blur-md transition-all duration-300 hover:border-gold-400/60 hover:shadow-xl">
    <?php if($href): ?>
        <a href="<?php echo e($href); ?>" class="focus-ring absolute inset-0 z-20 rounded-2xl" aria-label="View album: <?php echo e($title); ?>"></a>
    <?php endif; ?>

    <div class="relative aspect-[4/3] overflow-hidden bg-gradient-to-br from-navy-950 via-navy-900 to-maroon-950">
        <?php if($image): ?>
            <img src="<?php echo e($image); ?>" alt="<?php echo e($title); ?>" class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
        <?php else: ?>
            <div class="flex h-full w-full items-center justify-center text-gold-400/50" aria-hidden="true">
                <svg class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.2">
                    <rect x="3" y="5" width="18" height="14" rx="2" />
                    <circle cx="9" cy="10" r="2" />
                    <path stroke-linecap="round" d="M21 16l-5-5L5 21" />
                </svg>
            </div>
        <?php endif; ?>

        <?php if($count): ?>
            <div class="absolute top-3 right-3 z-10 flex items-center gap-1 rounded-full border border-white/20 bg-navy-950/80 px-2.5 py-1 text-[11px] font-bold text-white shadow backdrop-blur-sm">
                <svg class="h-3 w-3 text-gold-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <span><?php echo e($count); ?></span>
            </div>
        <?php endif; ?>
    </div>

    <figcaption class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-navy-950 via-navy-950/80 to-transparent p-5 pt-14 text-white pointer-events-none">
        <?php if($category): ?>
            <p class="text-[10px] font-bold uppercase tracking-widest text-gold-300"><?php echo e($category); ?></p>
        <?php endif; ?>
        <?php if($title): ?>
            <h3 class="mt-1 font-serif text-lg font-bold leading-snug text-white transition-colors group-hover:text-gold-200 line-clamp-1">
                <?php echo e($title); ?>

            </h3>
        <?php endif; ?>
    </figcaption>
</figure><?php /**PATH C:\xampp\htdocs\ProDo\EDAA\resources\views/components/gallery-card.blade.php ENDPATH**/ ?>