<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'type' => null,
    'tier' => null,
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
    'type' => null,
    'tier' => null,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $label = $tier?->badge_label
        ? trim($tier->badge_label.' Member')
        : ($type?->name ?? null);
?>

<?php if($label): ?>
    <span <?php echo e($attributes->merge(['class' => 'inline-flex items-center gap-1.5 rounded-full border border-gold-500/50 bg-gold-500/15 px-3 py-1 text-[11px] font-semibold uppercase tracking-widest text-gold-700'])); ?>>
        <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
            <path d="M10 2l1.9 4.05 4.45.55-3.28 3.1.85 4.4L10 11.95 6.08 14.1l.85-4.4L3.65 6.6l4.45-.55L10 2z" />
        </svg>
        <?php echo e($label); ?>

    </span>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\ProDo\EDAA\resources\views/components/membership-badge.blade.php ENDPATH**/ ?>