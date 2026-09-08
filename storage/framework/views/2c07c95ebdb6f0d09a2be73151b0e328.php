<?php
    $committee = $committee ?? null;
    $inputClass = 'w-full rounded-md border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 placeholder-navy-400 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none';
?>

<section class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm sm:p-8">
    <h2 class="font-serif text-xl font-semibold text-navy-950">Committee Details</h2>

    <div class="mt-6 grid gap-6 sm:grid-cols-2">
        <div>
            <label for="committee_type_id" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Committee Type *</label>
            <select id="committee_type_id" name="committee_type_id" required class="<?php echo e($inputClass); ?> <?php echo e($errors->has('committee_type_id') ? 'border-maroon-400 ring-2 ring-maroon-500/20' : ''); ?>">
                <option value="">Select type...</option>
                <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($type->id); ?>" <?php if(old('committee_type_id', $committee?->committee_type_id) == $type->id): echo 'selected'; endif; ?>><?php echo e($type->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <?php $__errorArgs = ['committee_type_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1.5 text-xs font-medium text-maroon-700"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div>
            <label for="name" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Name *</label>
            <input type="text" id="name" name="name" value="<?php echo e(old('name', $committee?->name)); ?>" required placeholder="e.g. Executive Committee 2025-2026" class="<?php echo e($inputClass); ?> <?php echo e($errors->has('name') ? 'border-maroon-400 ring-2 ring-maroon-500/20' : ''); ?>">
            <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1.5 text-xs font-medium text-maroon-700"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div>
            <label for="start_year" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Start Year *</label>
            <input type="number" id="start_year" name="start_year" value="<?php echo e(old('start_year', $committee?->start_year ?? date('Y'))); ?>" required min="1960" max="<?php echo e((int) date('Y') + 2); ?>" class="<?php echo e($inputClass); ?> <?php echo e($errors->has('start_year') ? 'border-maroon-400 ring-2 ring-maroon-500/20' : ''); ?>">
            <?php $__errorArgs = ['start_year'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1.5 text-xs font-medium text-maroon-700"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div>
            <label for="end_year" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">End Year *</label>
            <input type="number" id="end_year" name="end_year" value="<?php echo e(old('end_year', $committee?->end_year ?? ((int) date('Y') + 1))); ?>" required min="1960" max="<?php echo e((int) date('Y') + 2); ?>" class="<?php echo e($inputClass); ?> <?php echo e($errors->has('end_year') ? 'border-maroon-400 ring-2 ring-maroon-500/20' : ''); ?>">
            <?php $__errorArgs = ['end_year'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1.5 text-xs font-medium text-maroon-700"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="sm:col-span-2">
            <label for="description" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Description</label>
            <textarea id="description" name="description" rows="3" class="<?php echo e($inputClass); ?>"><?php echo e(old('description', $committee?->description)); ?></textarea>
        </div>

        <div>
            <label for="sort_order" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Sort Order</label>
            <input type="number" id="sort_order" name="sort_order" value="<?php echo e(old('sort_order', $committee?->sort_order ?? 0)); ?>" min="0" class="<?php echo e($inputClass); ?>">
        </div>

        <div class="flex items-end">
            <label class="inline-flex items-center gap-3 rounded-md border border-navy-200 bg-cream px-4 py-3">
                <input type="checkbox" name="is_current" value="1" class="h-4 w-4 rounded border-navy-300 text-maroon-700 focus:ring-maroon-500" <?php if(old('is_current', $committee?->is_current ?? false)): echo 'checked'; endif; ?>>
                <span class="text-sm font-medium text-navy-950">Mark as current (publicly visible)</span>
            </label>
        </div>
    </div>
</section>
<?php /**PATH C:\xampp\htdocs\ProDo\EDAA\resources\views\admin\committees\_form.blade.php ENDPATH**/ ?>