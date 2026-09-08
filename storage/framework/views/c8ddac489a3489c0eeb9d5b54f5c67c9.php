<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['commentableType', 'commentableId']));

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

foreach (array_filter((['commentableType', 'commentableId']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<section id="comments" class="mt-12 rounded-xl border border-navy-100 bg-white p-6 shadow-sm sm:p-8">
    <h3 class="font-serif text-xl font-semibold text-navy-950">
        Discussion
        <span class="text-sm font-normal text-ink-soft">(<?php echo e($commentableType::find($commentableId)->comments()->approved()->count()); ?> comments)</span>
    </h3>

    
    <?php if(auth()->guard()->check()): ?>
        <form method="POST" action="<?php echo e(route('comments.store')); ?>" class="mt-6">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="commentable_type" value="<?php echo e($commentableType); ?>">
            <input type="hidden" name="commentable_id" value="<?php echo e($commentableId); ?>">

            <div class="flex gap-3">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-navy-900 font-serif text-xs font-bold text-gold-300">
                    <?php echo e(\Illuminate\Support\Str::initials(auth()->user()->name ?? '')); ?>

                </div>
                <div class="flex-1">
                    <textarea
                        name="body"
                        rows="3"
                        required
                        maxlength="2000"
                        placeholder="Share your thoughts..."
                        class="focus-ring w-full rounded-lg border border-navy-200 bg-navy-50/50 px-4 py-3 text-sm text-navy-950 placeholder-navy-400 resize-none transition-colors focus:bg-white focus:border-gold-500"
                    ></textarea>
                    <div class="mt-2 flex items-center justify-between">
                        <p class="text-xs text-ink-soft">Be respectful. No spam.</p>
                        <button type="submit" class="focus-ring inline-flex items-center gap-2 rounded-lg bg-gold-500 px-4 py-2 text-sm font-semibold text-navy-950 shadow-sm transition-colors hover:bg-gold-400">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" /></svg>
                            Post Comment
                        </button>
                    </div>
                </div>
            </div>
        </form>
    <?php else: ?>
        <div class="mt-6 rounded-lg border border-dashed border-navy-200 bg-navy-50/50 p-6 text-center">
            <p class="text-sm text-ink-soft">
                <a href="<?php echo e(route('member.login')); ?>" class="font-semibold text-maroon-600 hover:text-maroon-700">Login</a>
                or
                <a href="<?php echo e(route('membership.apply')); ?>" class="font-semibold text-maroon-600 hover:text-maroon-700">become a member</a>
                to join the discussion.
            </p>
        </div>
    <?php endif; ?>
</section>
<?php /**PATH C:\xampp\htdocs\ProDo\EDAA\resources\views\components\comment-form.blade.php ENDPATH**/ ?>