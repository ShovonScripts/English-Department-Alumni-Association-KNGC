<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'name' => null,
    'graduation_year' => null,
    'role' => null,
    'field' => null,
    'image' => null,
    'href' => null,
    'batch' => null,
    'country' => null,
    'bio' => null,
    'membership_type' => null,
    'membership_tier' => null,
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
    'role' => null,
    'field' => null,
    'image' => null,
    'href' => null,
    'batch' => null,
    'country' => null,
    'bio' => null,
    'membership_type' => null,
    'membership_tier' => null,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<article 
    class="card-lift shine group relative flex h-full flex-col items-center rounded-2xl border border-navy-100 bg-white/95 p-6 sm:p-7 text-center shadow-sm backdrop-blur-md transition-all duration-300 hover:border-gold-400/60 hover:shadow-xl tilt-card">
    
    <?php if($href): ?>
        <a href="<?php echo e($href); ?>" class="focus-ring absolute inset-0 z-10 rounded-2xl" aria-label="View <?php echo e($name); ?>'s profile"></a>
    <?php endif; ?>

    
    <?php if($batch): ?>
        <div class="absolute top-4 right-4 z-20">
            <span class="inline-flex items-center rounded-full border border-gold-400/40 bg-gold-50 px-2.5 py-0.5 text-[11px] font-bold text-gold-700 shadow-xs">
                Batch <?php echo e($batch); ?>

            </span>
        </div>
    <?php endif; ?>

    <div class="tilt-inner flex flex-col items-center w-full h-full">
        
        <div class="relative mt-2">
            <?php if($image): ?>
                <img src="<?php echo e($image); ?>" alt="<?php echo e($name); ?>" class="h-24 w-24 rounded-full object-cover ring-4 ring-gold-500/30 transition-transform duration-300 group-hover:scale-105">
            <?php else: ?>
                <span class="flex h-24 w-24 items-center justify-center rounded-full bg-gradient-to-br from-navy-900 to-navy-800 font-serif text-2xl font-bold text-gold-300 ring-4 ring-gold-500/30 shadow-md">
                    <?php echo e(\Illuminate\Support\Str::initials($name ?? '')); ?>

                </span>
            <?php endif; ?>
        </div>

        
        <h3 class="mt-4 font-serif text-lg font-bold text-navy-950 transition-colors group-hover:text-maroon-700">
            <?php echo e($name); ?>

        </h3>

        
        <?php if($membership_tier || $membership_type): ?>
            <div class="mt-2">
                <?php if (isset($component)) { $__componentOriginalb341886620c268b94677189315a84e7d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb341886620c268b94677189315a84e7d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.membership-badge','data' => ['type' => $membership_type,'tier' => $membership_tier]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('membership-badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($membership_type),'tier' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($membership_tier)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb341886620c268b94677189315a84e7d)): ?>
<?php $attributes = $__attributesOriginalb341886620c268b94677189315a84e7d; ?>
<?php unset($__attributesOriginalb341886620c268b94677189315a84e7d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb341886620c268b94677189315a84e7d)): ?>
<?php $component = $__componentOriginalb341886620c268b94677189315a84e7d; ?>
<?php unset($__componentOriginalb341886620c268b94677189315a84e7d); ?>
<?php endif; ?>
            </div>
        <?php endif; ?>

        
        <?php if($graduation_year): ?>
            <p class="mt-1.5 text-xs font-semibold uppercase tracking-wider text-maroon-600">
                Class of <?php echo e($graduation_year); ?>

            </p>
        <?php endif; ?>

        
        <?php if($country): ?>
            <p class="mt-1 text-xs font-medium text-navy-400">
                <?php echo e($country); ?>

            </p>
        <?php endif; ?>

        
        <?php if($role || $field): ?>
            <p class="mt-2 text-sm text-ink-soft line-clamp-1">
                <?php echo e(collect([$role, $field])->filter()->implode(' · ')); ?>

            </p>
        <?php endif; ?>

        
        <?php if($bio): ?>
            <p class="mt-3 text-xs leading-relaxed text-ink-soft line-clamp-2"><?php echo e($bio); ?></p>
        <?php endif; ?>

        <div class="mt-auto pt-4">
            <span class="inline-flex items-center gap-1 text-xs font-bold uppercase tracking-wider text-maroon-600 transition-colors group-hover:text-maroon-800">
                View Profile &rarr;
            </span>
        </div>
    </div>
</article><?php /**PATH C:\xampp\htdocs\ProDo\EDAA\resources\views/components/alumni-card.blade.php ENDPATH**/ ?>