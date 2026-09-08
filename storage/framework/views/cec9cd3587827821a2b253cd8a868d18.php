<?php
    $membership = $membership ?? null;
    $inputClass = 'w-full rounded-md border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 placeholder-navy-400 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none';
?>

<section class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm sm:p-8">
    <h2 class="font-serif text-xl font-semibold text-navy-950">Membership Details</h2>
    <p class="mt-1 text-sm text-ink-soft">
        <?php if($membership): ?>
            Membership number <span class="font-mono font-semibold text-navy-900"><?php echo e($membership->membership_number); ?></span> cannot be changed.
        <?php else: ?>
            The membership number is generated automatically on creation.
        <?php endif; ?>
    </p>

    <div class="mt-6 grid gap-6 sm:grid-cols-2">
        <div class="sm:col-span-2">
            <label for="alumni_id" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Alumni *</label>
            <?php if($membership): ?>
                <div class="flex items-center gap-3 rounded-md border border-navy-200 bg-cream px-4 py-3">
                    <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-navy-900 font-serif text-xs font-semibold text-gold-300" aria-hidden="true">
                        <?php echo e(\Illuminate\Support\Str::initials($membership->alumni?->full_name ?? '')); ?>

                    </span>
                    <div>
                        <p class="text-sm font-semibold text-navy-950"><?php echo e($membership->alumni?->full_name); ?></p>
                        <p class="text-xs text-ink-soft"><?php echo e($membership->alumni?->student_id ? 'Student ID '.$membership->alumni->student_id.' · ' : ''); ?>Batch <?php echo e($membership->alumni?->batch ?? '—'); ?></p>
                    </div>
                </div>
            <?php else: ?>
                <select id="alumni_id" name="alumni_id" required class="<?php echo e($inputClass); ?> <?php echo e($errors->has('alumni_id') ? 'border-maroon-400 ring-2 ring-maroon-500/20' : ''); ?>">
                    <option value="">Select an alumni record…</option>
                    <?php $__currentLoopData = $availableAlumni; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($option->id); ?>" <?php if(old('alumni_id') == $option->id): echo 'selected'; endif; ?>>
                            <?php echo e($option->full_name); ?><?php echo e($option->student_id ? ' ('.$option->student_id.')' : ''); ?><?php echo e($option->batch ? ' — Batch '.$option->batch : ''); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <p class="mt-1.5 text-xs text-ink-soft">Only alumni without an existing membership are listed.</p>
            <?php endif; ?>
            <?php $__errorArgs = ['alumni_id'];
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
            <label for="membership_type_id" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Membership Type *</label>
            <select id="membership_type_id" name="membership_type_id" required class="<?php echo e($inputClass); ?> <?php echo e($errors->has('membership_type_id') ? 'border-maroon-400 ring-2 ring-maroon-500/20' : ''); ?>">
                <option value="">Select type…</option>
                <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($type->id); ?>" <?php if(old('membership_type_id', $membership?->membership_type_id) == $type->id): echo 'selected'; endif; ?>><?php echo e($type->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <?php $__errorArgs = ['membership_type_id'];
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
            <label for="membership_tier_id" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Membership Tier</label>
            <select id="membership_tier_id" name="membership_tier_id" class="<?php echo e($inputClass); ?> <?php echo e($errors->has('membership_tier_id') ? 'border-maroon-400 ring-2 ring-maroon-500/20' : ''); ?>">
                <option value="">No tier assigned</option>
                <?php $__currentLoopData = $tiers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($tier->id); ?>" <?php if(old('membership_tier_id', $membership?->membership_tier_id) == $tier->id): echo 'selected'; endif; ?>><?php echo e($tier->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <?php $__errorArgs = ['membership_tier_id'];
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
            <label for="status" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Status *</label>
            <select id="status" name="status" required class="<?php echo e($inputClass); ?> <?php echo e($errors->has('status') ? 'border-maroon-400 ring-2 ring-maroon-500/20' : ''); ?>">
                <?php $__currentLoopData = \App\Models\Membership::STATUSES; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($value); ?>" <?php if(old('status', $membership?->status ?? \App\Models\Membership::STATUS_PENDING) === $value): echo 'selected'; endif; ?>><?php echo e(ucfirst($value)); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <?php $__errorArgs = ['status'];
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
            <label for="joined_at" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Joined Date</label>
            <input type="date" id="joined_at" name="joined_at" value="<?php echo e(old('joined_at', $membership?->joined_at?->format('Y-m-d'))); ?>" max="<?php echo e(now()->toDateString()); ?>" class="<?php echo e($inputClass); ?> <?php echo e($errors->has('joined_at') ? 'border-maroon-400 ring-2 ring-maroon-500/20' : ''); ?>">
            <?php $__errorArgs = ['joined_at'];
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

        <?php if($membership && $membership->approved_at): ?>
            <div>
                <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Approved Date</label>
                <p class="rounded-md border border-navy-200 bg-cream px-4 py-2.5 text-sm text-navy-950"><?php echo e($membership->approved_at->format('M j, Y')); ?></p>
            </div>
        <?php endif; ?>

        <div class="sm:col-span-2">
            <label for="notes" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Admin Notes</label>
            <textarea id="notes" name="notes" rows="3" placeholder="Internal notes — never shown publicly." class="<?php echo e($inputClass); ?>"><?php echo e(old('notes', $membership?->notes)); ?></textarea>
            <?php $__errorArgs = ['notes'];
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

        <div class="sm:col-span-2 flex items-start">
            <label class="inline-flex items-center gap-3 rounded-md border border-navy-200 bg-cream px-4 py-3">
                <input type="checkbox" name="is_public" value="1" class="h-4 w-4 rounded border-navy-300 text-maroon-700 focus:ring-maroon-500" <?php if(old('is_public', $membership?->is_public ?? false)): echo 'checked'; endif; ?>>
                <span class="text-sm font-medium text-navy-950">Show membership publicly on the alumni profile</span>
            </label>
        </div>

        <div class="sm:col-span-2 flex items-start">
            <div class="inline-flex flex-col gap-1 rounded-md border border-navy-200 bg-cream px-4 py-3">
                <label class="inline-flex items-center gap-3">
                    <input type="checkbox" name="show_on_leaderboard" value="1" class="h-4 w-4 rounded border-navy-300 text-maroon-700 focus:ring-maroon-500" <?php if(old('show_on_leaderboard', $membership?->show_on_leaderboard ?? true)): echo 'checked'; endif; ?>>
                    <span class="text-sm font-medium text-navy-950">Show on Public Leaderboard</span>
                </label>
                <span class="text-xs text-ink-soft">When disabled, this member will not appear on the public contribution leaderboard. This does not affect payment records, contribution totals, or the public alumni profile.</span>
            </div>
        </div>
    </div>
</section>
<?php /**PATH C:\xampp\htdocs\ProDo\EDAA\resources\views\admin\members\_form.blade.php ENDPATH**/ ?>