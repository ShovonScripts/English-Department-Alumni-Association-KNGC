<?php
    $payment = $payment ?? null;
    $inputClass = 'w-full rounded-md border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 placeholder-navy-400 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none';
?>

<section class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm sm:p-8">
    <h2 class="font-serif text-xl font-semibold text-navy-950">Collection Details</h2>
    <p class="mt-1 text-sm text-ink-soft">
        <?php if($payment): ?>
            Payment number and member relationships are permanent financial identifiers.
        <?php else: ?>
            Record money collected manually by an authorized administrator. Select a member and enter the amount.
        <?php endif; ?>
    </p>

    <div
        x-data="{
            membershipOptions: <?php echo \Illuminate\Support\Js::from($memberships->map(fn ($m) => ['id' => $m->id, 'label' => trim(($m->alumni?->full_name ?? 'Unknown').' — '.$m->membership_number.' · '.($m->type?->name ?? ''))])->values()->all())->toHtml() ?>,
            membershipId: <?php echo \Illuminate\Support\Js::from(old('membership_id', $payment?->membership_id))->toHtml() ?>,
            get selectedMembership() { return this.membershipOptions.find(m => m.id == this.membershipId) || null },
        }"
    >
        <div class="mt-6 grid gap-6 sm:grid-cols-2">
            <div class="sm:col-span-2">
                <label for="membership_id" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Member *</label>
                <?php if($payment): ?>
                    <div class="rounded-md border border-navy-200 bg-cream px-4 py-2.5 text-sm font-medium text-navy-950">
                        <?php echo e($payment->membership?->alumni?->full_name); ?> — <?php echo e($payment->membership?->membership_number); ?>

                    </div>
                <?php else: ?>
                    <select id="membership_id" name="membership_id" required x-model.number="membershipId" class="<?php echo e($inputClass); ?> <?php echo e($errors->has('membership_id') ? 'border-maroon-400 ring-2 ring-maroon-500/20' : ''); ?>">
                        <option value="">Select a member…</option>
                        <template x-for="option in membershipOptions" :key="option.id">
                            <option :value="option.id" x-text="option.label" :selected="option.id === membershipId"></option>
                        </template>
                    </select>
                    <p class="mt-1.5 text-xs text-ink-soft">Select the member who made this payment.</p>
                <?php endif; ?>
                <?php $__errorArgs = ['membership_id'];
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
                <label for="amount" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Amount Collected (BDT) *</label>
                <input type="number" id="amount" name="amount" value="<?php echo e(old('amount', $payment?->amount)); ?>" required min="0" step="0.01" placeholder="e.g. 500" class="<?php echo e($inputClass); ?> <?php echo e($errors->has('amount') ? 'border-maroon-400 ring-2 ring-maroon-500/20' : ''); ?>">
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
                <label for="status" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Status *</label>
                <select id="status" name="status" required class="<?php echo e($inputClass); ?> <?php echo e($errors->has('status') ? 'border-maroon-400 ring-2 ring-maroon-500/20' : ''); ?>">
                    <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($status->value); ?>" <?php if(old('status', $payment?->status?->value ?? \App\Enums\PaymentStatus::Paid->value) === $status->value): echo 'selected'; endif; ?>><?php echo e($status->label()); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <p class="mt-1.5 text-xs text-ink-soft">Waived records clear the obligation but never count as collected cash.</p>
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
                <label for="paid_at" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Payment Date *</label>
                <input type="date" id="paid_at" name="paid_at" value="<?php echo e(old('paid_at', $payment?->paid_at?->format('Y-m-d') ?? now()->toDateString())); ?>" max="<?php echo e(now()->toDateString()); ?>" required class="<?php echo e($inputClass); ?> <?php echo e($errors->has('paid_at') ? 'border-maroon-400 ring-2 ring-maroon-500/20' : ''); ?>">
                <?php $__errorArgs = ['paid_at'];
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
                <input type="text" id="reference" name="reference" value="<?php echo e(old('reference', $payment?->reference)); ?>" placeholder="e.g. Cash Receipt #1024" maxlength="255" class="<?php echo e($inputClass); ?>">
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
                <label for="notes" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Admin Notes</label>
                <textarea id="notes" name="notes" rows="3" maxlength="2000" placeholder="Internal only — never shown publicly." class="<?php echo e($inputClass); ?>"><?php echo e(old('notes', $payment?->notes)); ?></textarea>
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
        </div>
    </div>
</section>
<?php /**PATH C:\xampp\htdocs\ProDo\EDAA\resources\views/admin/payments/_form.blade.php ENDPATH**/ ?>