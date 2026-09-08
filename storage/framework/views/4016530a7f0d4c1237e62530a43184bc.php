<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'title' => null,
    'date' => null,
    'time' => null,
    'location' => null,
    'category' => null,
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
    'date' => null,
    'time' => null,
    'location' => null,
    'category' => null,
    'href' => null,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<article class="card-lift shine group relative flex h-full flex-col overflow-hidden rounded-2xl border border-navy-100 bg-white/95 shadow-sm backdrop-blur-md transition-all duration-300 hover:border-gold-400/60 hover:shadow-xl">
    <?php if($href): ?>
        <a href="<?php echo e($href); ?>" class="focus-ring absolute inset-0 z-10 rounded-2xl" aria-label="View event: <?php echo e($title); ?>"></a>
    <?php endif; ?>

    <div class="flex-1 p-6 sm:p-7">
        <div class="flex items-center justify-between gap-3">
            <?php if($date): ?>
                <div class="flex h-14 w-14 shrink-0 flex-col items-center justify-center rounded-xl bg-gradient-to-br from-navy-950 via-navy-900 to-navy-800 text-white shadow-md ring-1 ring-gold-500/30 transition-transform duration-300 group-hover:scale-105">
                    <span class="text-xl font-bold leading-none tracking-tight"><?php echo e(\Illuminate\Support\Carbon::parse($date)->format('d')); ?></span>
                    <span class="mt-0.5 text-[10px] font-bold uppercase tracking-widest text-gold-300"><?php echo e(\Illuminate\Support\Carbon::parse($date)->format('M')); ?></span>
                </div>
            <?php endif; ?>

            <?php if($category): ?>
                <span class="inline-flex items-center rounded-full border border-maroon-200 bg-maroon-50 px-3 py-1 text-xs font-bold uppercase tracking-wider text-maroon-700 shadow-xs">
                    <?php echo e($category); ?>

                </span>
            <?php endif; ?>
        </div>

        <?php if($title): ?>
            <h3 class="mt-5 font-serif text-xl font-bold leading-snug text-navy-950 transition-colors group-hover:text-maroon-700">
                <?php echo e($title); ?>

            </h3>
        <?php endif; ?>

        <?php if($time || $location): ?>
            <ul class="mt-4 space-y-2 text-xs text-ink-soft">
                <?php if($time): ?>
                    <li class="flex items-center gap-2">
                        <svg class="h-4 w-4 shrink-0 text-maroon-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span><?php echo e($time); ?></span>
                    </li>
                <?php endif; ?>
                <?php if($location): ?>
                    <li class="flex items-center gap-2">
                        <svg class="h-4 w-4 shrink-0 text-maroon-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span class="truncate"><?php echo e($location); ?></span>
                    </li>
                <?php endif; ?>
            </ul>
        <?php endif; ?>
    </div>

    <?php if($href): ?>
        <div class="mt-auto flex items-center justify-between border-t border-navy-50 bg-navy-50/40 px-6 py-3.5">
            <span class="inline-flex items-center gap-1.5 text-xs font-bold uppercase tracking-wider text-maroon-700 transition-colors group-hover:text-maroon-900">
                View Event Details
                <svg class="h-3.5 w-3.5 transition-transform duration-200 group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </span>
            <span class="text-[10px] font-semibold uppercase tracking-wider text-navy-400">
                EDAA Event
            </span>
        </div>
    <?php endif; ?>
</article><?php /**PATH C:\xampp\htdocs\ProDo\EDAA\resources\views\components\event-card.blade.php ENDPATH**/ ?>