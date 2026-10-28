<?php if (isset($component)) { $__componentOriginalc8c9fd5d7827a77a31381de67195f0c3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc8c9fd5d7827a77a31381de67195f0c3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.admin','data' => ['title' => 'Expense Details']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.admin'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Expense Details']); ?>
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="font-serif text-3xl font-semibold tracking-tight text-navy-950"><?php echo e($expense->expense_number); ?></h1>
            <p class="mt-1 text-sm text-ink-soft">Association expense record.</p>
        </div>
        <a href="<?php echo e(route('admin.expenses.index')); ?>" class="focus-ring inline-flex items-center gap-2 rounded-md px-3.5 py-2 text-sm font-semibold text-navy-800 transition-colors hover:bg-navy-50">
            &larr; Back to Expenses
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
            <section class="rounded-lg border p-8 text-center shadow-sm <?php echo e($expense->status->isVoid() ? 'border-maroon-200 bg-maroon-50' : 'border-navy-100 bg-white'); ?>">
                <p class="text-xs font-semibold uppercase tracking-widest text-ink-soft">Amount Spent</p>
                <p class="mt-3 font-serif text-5xl font-semibold tracking-tight <?php echo e($expense->status->isVoid() ? 'text-maroon-400 line-through' : 'text-navy-950'); ?>"><?php echo e($expense->formattedAmount()); ?></p>

                <?php
                    $styles = [
                        'recorded' => ['bg-emerald-100', 'text-emerald-800'],
                        'void' => ['bg-maroon-100', 'text-maroon-800'],
                    ];
                    [$bg, $text] = $styles[$expense->status->value] ?? ['bg-navy-100', 'text-navy-600'];
                ?>
                <span class="mt-4 inline-flex rounded-full <?php echo e($bg); ?> px-3 py-1 text-xs font-bold uppercase tracking-wide <?php echo e($text); ?>"><?php echo e($expense->status->label()); ?></span>

                <?php if($expense->status->isVoid()): ?>
                    <p class="mt-6 rounded-md bg-maroon-100/60 px-3 py-2 text-xs font-medium text-maroon-800">
                        This expense is void — it does not count toward total expenses or the current balance.
                    </p>
                <?php endif; ?>

                <div class="mt-10 flex flex-wrap items-center justify-center gap-3 border-t border-navy-100 pt-8">
                    <?php if (! ($expense->status->isVoid())): ?>
                        <?php if (isset($component)) { $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.button','data' => ['href' => ''.e(route('admin.expenses.edit', $expense)).'','variant' => 'navy']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => ''.e(route('admin.expenses.edit', $expense)).'','variant' => 'navy']); ?>Edit Expense <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561)): ?>
<?php $attributes = $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561; ?>
<?php unset($__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald0f1fd2689e4bb7060122a5b91fe8561)): ?>
<?php $component = $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561; ?>
<?php unset($__componentOriginald0f1fd2689e4bb7060122a5b91fe8561); ?>
<?php endif; ?>
                    <?php else: ?>
                        <p class="max-w-xs text-xs text-ink-soft">
                            Voided expenses are locked. If a correction is needed, record a new expense — history stays intact.
                        </p>
                    <?php endif; ?>
                </div>

                <?php if (! ($expense->status->isVoid())): ?>
                    <details class="mt-8 border-t border-navy-100 pt-6">
                        <summary class="focus-ring cursor-pointer rounded text-sm font-semibold text-maroon-700 hover:text-maroon-900">Void this expense…</summary>
                        <form method="POST" action="<?php echo e(route('admin.expenses.void', $expense)); ?>" class="mt-4 max-w-xl" onsubmit="return confirm('Are you sure you want to void this expense? <?php echo e($expense->expense_number); ?> (<?php echo e($expense->formattedAmount()); ?>) will be retained for audit but excluded from all totals.');">
                            <?php echo csrf_field(); ?>
                            <label for="void_reason" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Void Reason (required, kept in audit trail) *</label>
                            <textarea id="void_reason" name="void_reason" rows="2" required minlength="5" maxlength="1000" placeholder="e.g. Duplicate entry." class="w-full rounded-md border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 placeholder-navy-400 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none"></textarea>
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
<?php $component->withAttributes(['type' => 'submit','variant' => 'maroon','size' => 'sm']); ?>Void Expense <?php echo $__env->renderComponent(); ?>
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

                <details class="mt-4 pt-6">
                    <summary class="focus-ring cursor-pointer rounded text-sm font-semibold text-maroon-700 hover:text-maroon-900">Delete this expense permanently…</summary>
                    <form method="POST" action="<?php echo e(route('admin.expenses.destroy', $expense)); ?>" class="mt-4 max-w-xl" onsubmit="return confirm('PERMANENTLY DELETE <?php echo e($expense->expense_number); ?>? This cannot be undone.');">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <p class="mb-3 text-xs text-maroon-700">This will permanently remove the expense record from the database. Consider voiding instead for audit trail purposes.</p>
                        <?php if (isset($component)) { $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.button','data' => ['type' => 'submit','variant' => 'maroon','size' => 'sm']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'submit','variant' => 'maroon','size' => 'sm']); ?>Delete Permanently <?php echo $__env->renderComponent(); ?>
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
            </section>
        </div>

        
        <div class="lg:col-span-2">
            <section class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm sm:p-8">
                <h2 class="font-serif text-xl font-semibold text-navy-950">Record Information</h2>

                <dl class="mt-6 grid gap-6 sm:grid-cols-2">
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Expense Number</dt>
                        <dd class="mt-1 font-mono text-sm font-semibold text-navy-950"><?php echo e($expense->expense_number); ?></dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Status</dt>
                        <dd class="mt-1 text-sm text-navy-950"><?php echo e($expense->status->label()); ?></dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Category</dt>
                        <dd class="mt-1 text-sm text-navy-950"><?php echo e($expense->category?->name ?? '—'); ?></dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Currency</dt>
                        <dd class="mt-1 text-sm text-navy-950"><?php echo e($expense->currency); ?></dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Expense Date</dt>
                        <dd class="mt-1 text-sm text-navy-950"><?php echo e($expense->expense_date?->format('M j, Y')); ?></dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Reference</dt>
                        <dd class="mt-1 text-sm text-navy-950"><?php echo e($expense->reference ?: 'No reference recorded.'); ?></dd>
                    </div>
                    <div class="sm:col-span-2">
                        <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Title</dt>
                        <dd class="mt-1 text-sm font-medium text-navy-950"><?php echo e($expense->title); ?></dd>
                    </div>
                    <div class="sm:col-span-2">
                        <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Description</dt>
                        <dd class="mt-1 text-sm leading-relaxed text-navy-950"><?php echo e($expense->description ?: 'No description recorded.'); ?></dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Recorded By</dt>
                        <dd class="mt-1 text-sm text-navy-950"><?php echo e($expense->recordedBy?->name); ?></dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Recorded / Updated</dt>
                        <dd class="mt-1 text-sm text-navy-950"><?php echo e($expense->created_at?->format('M j, Y')); ?> · <?php echo e($expense->updated_at?->format('M j, Y')); ?></dd>
                    </div>

                    <?php if($expense->status->isVoid()): ?>
                        <div class="sm:col-span-2 rounded-md border border-maroon-200 bg-maroon-50 p-4">
                            <dt class="text-xs font-bold uppercase tracking-wider text-maroon-800">Voided</dt>
                            <dd class="mt-1 text-sm text-maroon-800">
                                <?php echo e($expense->voided_at?->format('M j, Y, g:i A')); ?>

                                by <?php echo e($expense->voidedBy?->name); ?><br>
                                <span class="italic">“<?php echo e($expense->void_reason); ?>”</span>
                            </dd>
                        </div>
                    <?php endif; ?>
                </dl>
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
<?php /**PATH C:\xampp\htdocs\ProDo\EDAA\resources\views/admin/expenses/show.blade.php ENDPATH**/ ?>