<?php
    $expense = $expense ?? null;
    $inputClass = 'w-full rounded-md border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 placeholder-navy-400 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none';
?>

<section class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm sm:p-8">
    <h2 class="font-serif text-xl font-semibold text-navy-950">Expense Details</h2>
    <p class="mt-1 text-sm text-ink-soft">
        <?php if($expense): ?>
            The expense number, status, and recorder are permanent financial identifiers and cannot be changed.
        <?php else: ?>
            Record money spent by the association. This is an association expense, not a business purchase.
        <?php endif; ?>
    </p>

    <div class="mt-6 grid gap-6 sm:grid-cols-2">
        <div>
            <label for="expense_category_id" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Category *</label>
            <?php if($expense && $expense->status->isVoid()): ?>
                <div class="rounded-md border border-navy-200 bg-cream px-4 py-2.5 text-sm font-medium text-navy-950"><?php echo e($expense->category?->name); ?></div>
            <?php else: ?>
                <select id="expense_category_id" name="expense_category_id" required class="<?php echo e($inputClass); ?> <?php echo e($errors->has('expense_category_id') ? 'border-maroon-400 ring-2 ring-maroon-500/20' : ''); ?>">
                    <option value="">Select a category…</option>
                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($category->id); ?>" <?php if(old('expense_category_id', $expense?->expense_category_id) == $category->id): echo 'selected'; endif; ?>><?php echo e($category->name); ?><?php echo e($category->is_active ? '' : ' (inactive)'); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            <?php endif; ?>
            <?php $__errorArgs = ['expense_category_id'];
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
            <label for="title" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Title *</label>
            <input type="text" id="title" name="title" value="<?php echo e(old('title', $expense?->title)); ?>" required maxlength="255" placeholder="e.g. Annual reunion venue booking" class="<?php echo e($inputClass); ?> <?php echo e($errors->has('title') ? 'border-maroon-400 ring-2 ring-maroon-500/20' : ''); ?>">
            <?php $__errorArgs = ['title'];
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
            <label for="amount" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Amount (৳) *</label>
            <input type="number" id="amount" name="amount" value="<?php echo e(old('amount', $expense?->amount)); ?>" required min="0" step="0.01" placeholder="e.g. 5000" class="<?php echo e($inputClass); ?> <?php echo e($errors->has('amount') ? 'border-maroon-400 ring-2 ring-maroon-500/20' : ''); ?>">
            <?php $__errorArgs = ['amount'];
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
            <label for="expense_date" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Expense Date *</label>
            <input type="date" id="expense_date" name="expense_date" value="<?php echo e(old('expense_date', $expense?->expense_date?->format('Y-m-d') ?? now()->toDateString())); ?>" max="<?php echo e(now()->toDateString()); ?>" required class="<?php echo e($inputClass); ?> <?php echo e($errors->has('expense_date') ? 'border-maroon-400 ring-2 ring-maroon-500/20' : ''); ?>">
            <?php $__errorArgs = ['expense_date'];
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
            <label for="reference" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Reference</label>
            <input type="text" id="reference" name="reference" value="<?php echo e(old('reference', $expense?->reference)); ?>" placeholder="e.g. Voucher 2026-011" maxlength="255" class="<?php echo e($inputClass); ?>">
            <?php $__errorArgs = ['reference'];
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
            <textarea id="description" name="description" rows="3" maxlength="2000" placeholder="What was this association spending for?" class="<?php echo e($inputClass); ?>"><?php echo e(old('description', $expense?->description)); ?></textarea>
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
    </div>
</section>
<?php /**PATH C:\xampp\htdocs\ProDo\EDAA\resources\views/admin/expenses/_form.blade.php ENDPATH**/ ?>