<?php if (isset($component)) { $__componentOriginal5863877a5171c196453bfa0bd807e410 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5863877a5171c196453bfa0bd807e410 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.app','data' => ['title' => 'Payment History']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.app'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Payment History')]); ?>
    <section class="bg-navy-950 py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <h1 class="font-serif text-3xl font-bold text-white">Payment History</h1>
            <p class="mt-2 text-sm text-white/60">All recorded payments for your membership</p>
        </div>
    </section>

    <section class="py-10">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                <aside class="lg:col-span-1">
                    <div class="rounded-lg border border-navy-100 bg-white p-4 shadow-sm">
                        <?php if (isset($component)) { $__componentOriginal045cf4da59ba09f546a14c8bea6c081a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal045cf4da59ba09f546a14c8bea6c081a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.member.sidebar','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('member.sidebar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal045cf4da59ba09f546a14c8bea6c081a)): ?>
<?php $attributes = $__attributesOriginal045cf4da59ba09f546a14c8bea6c081a; ?>
<?php unset($__attributesOriginal045cf4da59ba09f546a14c8bea6c081a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal045cf4da59ba09f546a14c8bea6c081a)): ?>
<?php $component = $__componentOriginal045cf4da59ba09f546a14c8bea6c081a; ?>
<?php unset($__componentOriginal045cf4da59ba09f546a14c8bea6c081a); ?>
<?php endif; ?>
                    </div>
                </aside>

                <main class="lg:col-span-3">
                    <div class="premium-card">
                        <div class="border-b border-navy-100 px-6 py-4 bg-white">
                            <h2 class="font-serif text-lg font-semibold text-navy-950">Payments</h2>
                        </div>

                        <?php if($payments->count() > 0): ?>
                            <div class="overflow-x-auto">
                                <table class="w-full text-sm">
                                    <thead class="bg-navy-50/50">
                                        <tr>
                                            <th class="px-5 py-3 text-left text-xs font-medium uppercase tracking-wider text-ink-soft">Date</th>
                                            <th class="px-5 py-3 text-left text-xs font-medium uppercase tracking-wider text-ink-soft">Description</th>
                                            <th class="px-5 py-3 text-left text-xs font-medium uppercase tracking-wider text-ink-soft">Method</th>
                                            <th class="px-5 py-3 text-right text-xs font-medium uppercase tracking-wider text-ink-soft">Amount</th>
                                            <th class="px-5 py-3 text-center text-xs font-medium uppercase tracking-wider text-ink-soft">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-navy-50 bg-white">
                                        <?php $__currentLoopData = $payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr class="hover:bg-navy-50/30 transition-colors">
                                                <td class="whitespace-nowrap px-5 py-4 text-sm text-navy-900">
                                                    <?php echo e($payment->paid_at?->format('M d, Y') ?? '-'); ?>

                                                </td>
                                                <td class="px-5 py-4 text-sm text-navy-900">
                                                    <?php echo e($payment->description ?? 'Payment'); ?>

                                                </td>
                                                <td class="whitespace-nowrap px-5 py-4 text-sm text-ink-soft capitalize">
                                                    <?php echo e($payment->payment_method ?? '-'); ?>

                                                </td>
                                                <td class="whitespace-nowrap px-5 py-4 text-sm font-semibold text-navy-900 text-right">
                                                    <?php echo e(number_format($payment->amount)); ?>&#2547;
                                                </td>
                                                <td class="whitespace-nowrap px-5 py-4 text-center">
                                                    <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium
                                                        <?php echo e(match($payment->status) {
                                                            \App\Enums\PaymentStatus::Paid => 'bg-emerald-50 text-emerald-700',
                                                            \App\Enums\PaymentStatus::Partial => 'bg-amber-50 text-amber-700',
                                                            \App\Enums\PaymentStatus::Void => 'bg-navy-50 text-navy-500 line-through',
                                                            \App\Enums\PaymentStatus::Waived => 'bg-blue-50 text-blue-700',
                                                            default => 'bg-navy-50 text-navy-600',
                                                        }); ?>">
                                                        <?php echo e(ucfirst($payment->status->value)); ?>

                                                    </span>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>

                            <div class="border-t border-navy-100 px-6 py-4 bg-white">
                                <?php echo e($payments->withQueryString()->links()); ?>

                            </div>
                        <?php else: ?>
                            <div class="px-6 py-12 text-center bg-white">
                                <svg class="mx-auto h-12 w-12 text-navy-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z"/></svg>
                                <p class="mt-3 text-sm text-ink-soft">No payments have been recorded for your membership yet.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </main>
            </div>
        </div>
    </section>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5863877a5171c196453bfa0bd807e410)): ?>
<?php $attributes = $__attributesOriginal5863877a5171c196453bfa0bd807e410; ?>
<?php unset($__attributesOriginal5863877a5171c196453bfa0bd807e410); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5863877a5171c196453bfa0bd807e410)): ?>
<?php $component = $__componentOriginal5863877a5171c196453bfa0bd807e410; ?>
<?php unset($__componentOriginal5863877a5171c196453bfa0bd807e410); ?>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\ProDo\EDAA\resources\views\member\payments\index.blade.php ENDPATH**/ ?>