<?php
    $category = $category ?? null;
    $inputClass = 'w-full rounded-md border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 placeholder-navy-400 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none';
?>

<section class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm sm:p-8">
    <h2 class="font-serif text-xl font-semibold text-navy-950">Category Details</h2>
    <p class="mt-1 text-sm text-ink-soft">
        <?php if($category): ?>
            Categories are referenced by historical expenses — deactivation is safer than renaming into confusion.
        <?php else: ?>
            Classify association spending so the finance dashboard can break expenses down meaningfully.
        <?php endif; ?>
    </p>

    <div class="mt-6 grid gap-6 sm:grid-cols-2">
        <div class="sm:col-span-2">
            <label for="name" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Name *</label>
            <input type="text" id="name" name="name" value="<?php echo e(old('name', $category?->name)); ?>" required maxlength="255" placeholder="e.g. Events & Programs" class="<?php echo e($inputClass); ?> <?php echo e($errors->has('name') ? 'border-maroon-400 ring-2 ring-maroon-500/20' : ''); ?>">
            <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="mt-1.5 text-xs font-medium text-maroon-700"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="sm:col-span-2">
            <label for="description" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Description</label>
            <textarea id="description" name="description" rows="3" maxlength="1000" placeholder="What kind of expenses belong here?" class="<?php echo e($inputClass); ?>"><?php echo e(old('description', $category?->description)); ?></textarea>
            <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="mt-1.5 text-xs font-medium text-maroon-700"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div>
            <label for="sort_order" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Sort Order</label>
            <input type="number" id="sort_order" name="sort_order" value="<?php echo e(old('sort_order', $category?->sort_order ?? 0)); ?>" min="0" step="1" class="<?php echo e($inputClass); ?>">
            <?php $__errorArgs = ['sort_order'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="mt-1.5 text-xs font-medium text-maroon-700"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div>
            <span class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Status</span>
            <label class="flex items-center gap-3 rounded-md border border-navy-200 bg-cream px-4 py-2.5 text-sm text-navy-950">
                <input type="checkbox" name="is_active" value="1" <?php if(old('is_active', $category?->is_active ?? true)): echo 'checked'; endif; ?> class="h-4 w-4 rounded border-navy-300 text-gold-500 focus:ring-gold-500">
                Active — available for new expenses
            </label>
            <p class="mt-1.5 text-xs text-ink-soft">Inactive categories remain on historical records but cannot receive new expenses.</p>
        </div>
    </div>
</section>
<?php /**PATH C:\xampp\htdocs\ProDo\EDAA\resources\views/admin/expense-categories/_form.blade.php ENDPATH**/ ?>