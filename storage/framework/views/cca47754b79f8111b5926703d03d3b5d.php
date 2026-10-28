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

<?php
    $comments = $commentableType::find($commentableId)
        ->comments()
        ->approved()
        ->with('user')
        ->latest()
        ->get();
?>

<?php if($comments->isNotEmpty()): ?>
    <div class="mt-6 space-y-4">
        <?php $__currentLoopData = $comments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="group flex gap-3 rounded-lg border border-navy-100 bg-navy-50/30 p-4 transition-colors hover:bg-navy-50/60" id="comment-<?php echo e($comment->id); ?>">
                
                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-navy-900 font-serif text-xs font-bold text-gold-300">
                    <?php echo e(\Illuminate\Support\Str::initials($comment->user?->name ?? 'U')); ?>

                </div>

                <div class="min-w-0 flex-1">
                    
                    <div class="flex items-center gap-2">
                        <span class="text-sm font-semibold text-navy-950"><?php echo e($comment->user?->name ?? 'Unknown'); ?></span>
                        <span class="text-xs text-ink-soft">&middot;</span>
                        <span class="text-xs text-ink-soft"><?php echo e($comment->created_at->diffForHumans()); ?></span>
                    </div>

                    
                    <p class="mt-1.5 text-sm leading-relaxed text-navy-800"><?php echo e($comment->body); ?></p>

                    
                    <?php if($comment->canBeDeleted()): ?>
                        <div class="mt-2 opacity-0 group-hover:opacity-100 transition-opacity">
                            <form method="POST" action="<?php echo e(route('comments.destroy', $comment)); ?>" onsubmit="return confirm('Delete this comment?');" class="inline">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="text-xs font-medium text-maroon-500 hover:text-maroon-700 transition-colors">
                                    Delete
                                </button>
                            </form>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
<?php else: ?>
    <div class="mt-6 rounded-lg border border-dashed border-navy-200 bg-navy-50/30 p-8 text-center">
        <svg class="mx-auto h-8 w-8 text-navy-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
        </svg>
        <p class="mt-2 text-sm text-ink-soft">No comments yet. Be the first to share your thoughts!</p>
    </div>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\ProDo\EDAA\resources\views/components/comment-list.blade.php ENDPATH**/ ?>