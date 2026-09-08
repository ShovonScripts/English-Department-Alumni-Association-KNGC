<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'name' => null,
    'graduation_year' => null,
    'quote' => null,
    'role' => null,
    'image' => null,
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
    'name' => null,
    'graduation_year' => null,
    'quote' => null,
    'role' => null,
    'image' => null,
    'href' => null,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<figure class="card-lift shine group relative flex h-full flex-col rounded-2xl border border-navy-100 bg-white/95 p-7 sm:p-8 shadow-sm backdrop-blur-md transition-all duration-300 hover:border-gold-400/60 hover:shadow-xl">
    <?php if($href): ?>
        <a href="<?php echo e($href); ?>" class="focus-ring absolute inset-0 z-10 rounded-2xl" aria-label="Read story by <?php echo e($name); ?>"></a>
    <?php endif; ?>

    <div class="flex items-center justify-between">
        <svg class="h-8 w-8 text-gold-500/80 transition-transform duration-300 group-hover:scale-110" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
            <path d="M9.6 4C5.4 5.4 3 8.6 3 13.2V20h6.8v-6.8H6.4c0-2.8 1.4-4.9 4.2-5.8L9.6 4zm11 0c-4.2 1.4-6.6 4.6-6.6 9.2V20h6.8v-6.8h-3.4c0-2.8 1.4-4.9 4.2-5.8L20.6 4z" />
        </svg>
        <span class="text-[10px] font-bold uppercase tracking-widest text-maroon-600">Alumni Story</span>
    </div>

    <?php if($quote): ?>
        <blockquote class="mt-4 flex-1 font-serif text-base italic leading-relaxed text-navy-950 sm:text-lg">
            &ldquo;<?php echo e($quote); ?>&rdquo;
        </blockquote>
    <?php endif; ?>

    <figcaption class="mt-6 flex items-center gap-3.5 border-t border-navy-50 pt-5">
        <?php if($image): ?>
            <img src="<?php echo e($image); ?>" alt="<?php echo e($name); ?>" class="h-12 w-12 rounded-full object-cover ring-2 ring-gold-500/40 transition-transform duration-300 group-hover:scale-105">
        <?php else: ?>
            <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-gradient-to-br from-navy-900 to-navy-800 font-serif text-sm font-bold text-gold-300 ring-2 ring-gold-500/40" aria-hidden="true">
                <?php echo e(\Illuminate\Support\Str::initials($name ?? '')); ?>

            </span>
        <?php endif; ?>
        <div class="min-w-0 flex-1">
            <p class="font-serif font-bold text-navy-950 transition-colors group-hover:text-maroon-700 truncate"><?php echo e($name); ?></p>
            <?php if($role || $graduation_year): ?>
                <p class="text-xs text-ink-soft truncate">
                    <?php echo e(collect([$role, $graduation_year ? "Class of {$graduation_year}" : null])->filter()->implode(' · ')); ?>

                </p>
            <?php endif; ?>
        </div>
        <span class="text-xs font-bold text-maroon-600 transition-transform group-hover:translate-x-1">&rarr;</span>
    </figcaption>
</figure><?php /**PATH C:\xampp\htdocs\ProDo\EDAA\resources\views\components\story-card.blade.php ENDPATH**/ ?>