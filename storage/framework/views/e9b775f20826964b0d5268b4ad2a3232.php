<?php if (isset($component)) { $__componentOriginalc8c9fd5d7827a77a31381de67195f0c3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc8c9fd5d7827a77a31381de67195f0c3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.admin','data' => ['title' => 'Payment Details']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.admin'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Payment Details']); ?>
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="font-serif text-3xl font-semibold tracking-tight text-navy-950"><?php echo e($payment->payment_number); ?></h1>
            <p class="mt-1 text-sm text-ink-soft">Manual collection record.</p>
        </div>
        <a href="<?php echo e(route('admin.payments.index')); ?>" class="focus-ring inline-flex items-center gap-2 rounded-md px-3.5 py-2 text-sm font-semibold text-navy-800 transition-colors hover:bg-navy-50">
            &larr; Back to Payments
        </a>
    </div>

    <?php if(session('status')): ?>
        <div class="mb-6 flex items-center gap-3 rounded-md border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800" role="status">
            <?php echo e(session('status')); ?>

        </div>
    <?php endif; ?>

    <?php if(session('warning')): ?>
        <div class="mb-6 flex items-center gap-3 rounded-md border border-gold-500/50 bg-gold-500/10 px-4 py-3 text-sm text-gold-700" role="alert">
            <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v4m0 4h.01M10.3 3.9L1.8 18a2 2 0 001.7 3h17a2 2 0 001.7-3L13.7 3.9a2 2 0 00-3.4 0z" />
            </svg>
            <?php echo e(session('warning')); ?>

        </div>
    <?php endif; ?>

    <div class="grid gap-8 lg:grid-cols-3">
        
        <div>
            <section class="rounded-lg border p-8 text-center shadow-sm <?php echo e($payment->status->isVoid() ? 'border-maroon-200 bg-maroon-50' : 'border-navy-100 bg-white'); ?>">
                <p class="text-xs font-semibold uppercase tracking-widest text-ink-soft">Amount Collected</p>
                <p class="mt-3 font-serif text-5xl font-semibold tracking-tight <?php echo e($payment->status->isVoid() ? 'text-maroon-400 line-through' : 'text-navy-950'); ?>"><?php echo e($payment->formattedAmount()); ?></p>

                <?php
                    $styles = [
                        'paid' => ['bg-emerald-100', 'text-emerald-800'],
                        'partial' => ['bg-gold-500/20', 'text-gold-700'],
                        'waived' => ['bg-navy-100', 'text-navy-600'],
                        'void' => ['bg-maroon-100', 'text-maroon-800'],
                    ];
                    [$bg, $text] = $styles[$payment->status->value] ?? ['bg-navy-100', 'text-navy-600'];
                ?>
                <span class="mt-4 inline-flex rounded-full <?php echo e($bg); ?> px-3 py-1 text-xs font-bold uppercase tracking-wide <?php echo e($text); ?>"><?php echo e($payment->status->label()); ?></span>
            </section>
        </div>

        
        <div class="lg:col-span-2">
            <section class="rounded-lg border border-navy-100 bg-white p-8 shadow-sm sm:p-10">
                <h2 class="font-serif text-xl font-semibold text-navy-950">Payment Record</h2>

                <dl class="mt-8 grid gap-x-8 gap-y-6 sm:grid-cols-2">
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Member</dt>
                        <dd class="mt-1 text-sm text-navy-950">
                            <a href="<?php echo e(route('admin.members.show', $payment->membership)); ?>" class="focus-ring rounded font-medium text-maroon-700 transition-colors hover:text-maroon-900">
                                <?php echo e($payment->membership?->alumni?->full_name); ?>

                            </a>
                        </dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Membership Number</dt>
                        <dd class="mt-1 font-mono text-xs font-semibold text-navy-900"><?php echo e($payment->membership?->membership_number); ?></dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Membership Type</dt>
                        <dd class="mt-1 text-sm text-navy-950"><?php echo e($payment->membership?->type?->name); ?></dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Membership Tier</dt>
                        <dd class="mt-1 text-sm text-navy-950"><?php echo e($payment->membership?->tier?->badge_label ?? 'Not assigned'); ?></dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Payment Date</dt>
                        <dd class="mt-1 text-sm text-navy-950"><?php echo e($payment->paid_at?->format('M j, Y')); ?></dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Reference</dt>
                        <dd class="mt-1 text-sm text-navy-950"><?php echo e($payment->reference ?: '—'); ?></dd>
                    </div>
                    <div class="sm:col-span-2">
                        <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Admin Notes</dt>
                        <dd class="mt-1 text-sm leading-relaxed text-navy-950"><?php echo e($payment->notes ?: 'No notes recorded.'); ?></dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Recorded By</dt>
                        <dd class="mt-1 text-sm text-navy-950"><?php echo e($payment->recordedBy?->name); ?></dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Recorded / Updated</dt>
                        <dd class="mt-1 text-sm text-navy-950"><?php echo e($payment->created_at?->format('M j, Y')); ?> · <?php echo e($payment->updated_at?->format('M j, Y')); ?></dd>
                    </div>

                    <?php if($payment->status->isVoid()): ?>
                        <div class="sm:col-span-2 rounded-md border border-maroon-200 bg-maroon-50 p-4">
                            <dt class="text-xs font-bold uppercase tracking-wider text-maroon-800">Voided</dt>
                            <dd class="mt-1 text-sm text-maroon-800">
                                <?php echo e($payment->voided_at?->format('M j, Y, g:i A')); ?>

                                by <?php echo e($payment->voidedBy?->name); ?><br>
                                <span class="italic">“<?php echo e($payment->void_reason); ?>”</span>
                            </dd>
                        </div>
                    <?php endif; ?>
                </dl>

                <div class="mt-10 flex flex-wrap items-center gap-3 border-t border-navy-100 pt-8">
                    <?php if (! ($payment->status->isVoid())): ?>
                        <?php if (isset($component)) { $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.button','data' => ['href' => ''.e(route('admin.payments.edit', $payment)).'','variant' => 'navy']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => ''.e(route('admin.payments.edit', $payment)).'','variant' => 'navy']); ?>Edit Payment <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561)): ?>
<?php $attributes = $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561; ?>
<?php unset($__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald0f1fd2689e4bb7060122a5b91fe8561)): ?>
<?php $component = $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561; ?>
<?php unset($__componentOriginald0f1fd2689e4bb7060122a5b91fe8561); ?>
<?php endif; ?>
                    <?php endif; ?>

                    <a href="<?php echo e(route('admin.members.show', $payment->membership)); ?>" class="focus-ring inline-flex items-center gap-2 rounded-md px-3.5 py-2 text-sm font-semibold text-maroon-700 transition-colors hover:bg-maroon-50">
                        View Member Summary
                    </a>
                </div>

                <?php if (! ($payment->status->isVoid())): ?>
                    <details class="mt-8 border-t border-navy-100 pt-6">
                        <summary class="focus-ring cursor-pointer rounded text-sm font-semibold text-maroon-700 hover:text-maroon-900">Void this payment…</summary>
                        <form method="POST" action="<?php echo e(route('admin.payments.void', $payment)); ?>" class="mt-4 max-w-xl" onsubmit="return confirm('Void <?php echo e($payment->payment_number); ?>? The record is retained but excluded from all totals.');">
                            <?php echo csrf_field(); ?>
                            <label for="void_reason" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Void Reason (required, kept in audit trail) *</label>
                            <textarea id="void_reason" name="void_reason" rows="2" required minlength="5" maxlength="1000" placeholder="e.g. Duplicate entry recorded in error." class="w-full rounded-md border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 placeholder-navy-400 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none"></textarea>
                            <?php $__errorArgs = ['void_reason'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="mt-1.5 text-xs font-medium text-maroon-700"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            <?php if (isset($component)) { $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.button','data' => ['type' => 'submit','variant' => 'maroon','size' => 'sm']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'submit','variant' => 'maroon','size' => 'sm']); ?>Void Payment <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561)): ?>
<?php $attributes = $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561; ?>
<?php unset($__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald0f1fd2689e4bb7060122a5b91fe8561)): ?>
<?php $component = $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561; ?>
<?php unset($__componentOriginald0f1fd2689e4bb7060122a5b91fe8561); ?>
<?php endif; ?>
                        </form>
                    </details>
                <?php endif; ?>
            </section>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc8c9fd5d7827a77a31381de67195f0c3)): ?>
<?php $attributes = $__attributesOriginalc8c9fd5d7827a77a31381de67195f0c3; ?>
<?php unset($__attributesOriginalc8c9fd5d7827a77a31381de67195f0c3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc8c9fd5d7827a77a31381de67195f0c3)): ?>
<?php $component = $__componentOriginalc8c9fd5d7827a77a31381de67195f0c3; ?>
<?php unset($__componentOriginalc8c9fd5d7827a77a31381de67195f0c3); ?>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\ProDo\EDAA\resources\views\admin\payments\show.blade.php ENDPATH**/ ?>