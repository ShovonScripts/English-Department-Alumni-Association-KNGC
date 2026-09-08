<?php if (isset($component)) { $__componentOriginalc8c9fd5d7827a77a31381de67195f0c3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc8c9fd5d7827a77a31381de67195f0c3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.admin','data' => ['title' => 'Finance']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.admin'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Finance']); ?>
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="font-serif text-3xl font-semibold tracking-tight text-navy-950">Finance</h1>
            <p class="mt-1 text-sm text-ink-soft">
                Association funds overview — collections, expenses, and balance. Internal only; never shown publicly.
            </p>
        </div>

        
        <div class="flex items-center gap-4">
            <div class="inline-flex items-center gap-3 rounded-md border border-navy-200 bg-cream px-4 py-3">
                <span class="text-sm font-medium text-navy-950">Public Finance</span>
                <form method="POST" action="<?php echo e(route('admin.finance.togglePublic')); ?>">
                    <?php echo csrf_field(); ?>
                    <?php if (isset($component)) { $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.button','data' => ['type' => 'submit','variant' => $publicEnabled ? 'emerald' : 'navy','size' => 'sm']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'submit','variant' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($publicEnabled ? 'emerald' : 'navy'),'size' => 'sm']); ?>
                        <?php echo e($publicEnabled ? 'Enabled' : 'Disabled'); ?>

                     <?php echo $__env->renderComponent(); ?>
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
                <span class="text-xs text-ink-soft">
                    <?php echo e($publicEnabled ? 'Aggregate data visible on /finance' : 'Public finance page is hidden'); ?>

                </span>
            </div>
            <?php if($publicEnabled): ?>
                <a href="<?php echo e(route('finance.public')); ?>" target="_blank" rel="noopener noreferrer" class="focus-ring inline-flex items-center gap-2 rounded-md px-3 py-2 text-sm font-semibold text-maroon-700 transition-colors hover:bg-maroon-50">
                    View Public Finance →
                </a>
            <?php endif; ?>
        </div>
    </div>

    
    <form method="GET" action="<?php echo e(route('admin.finance.index')); ?>" class="mb-8 flex flex-wrap items-end gap-4 rounded-lg border border-navy-100 bg-white p-5 shadow-sm">
        <div>
            <label for="year" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Year</label>
            <select id="year" name="year" class="rounded-md border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none">
                <?php $__currentLoopData = $availableYears; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $availableYear): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($availableYear); ?>" <?php if($availableYear === $year): echo 'selected'; endif; ?>><?php echo e($availableYear); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div>
            <label for="month" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Month (breakdown filter)</label>
            <select id="month" name="month" class="rounded-md border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none">
                <option value="">Whole year</option>
                <?php $__currentLoopData = range(1, 12); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($m); ?>" <?php if($selectedMonth === $m): echo 'selected'; endif; ?>><?php echo e(\Illuminate\Support\Carbon::create($year, $m, 1)->format('F')); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <?php if (isset($component)) { $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.button','data' => ['type' => 'submit','variant' => 'navy','size' => 'sm']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'submit','variant' => 'navy','size' => 'sm']); ?>Apply <?php echo $__env->renderComponent(); ?>
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

    
    <section aria-labelledby="finance-overview">
        <h2 id="finance-overview" class="font-serif text-xl font-semibold text-navy-950">Financial Overview</h2>
        <div class="mt-4 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
            <div class="rounded-lg border border-emerald-200 bg-emerald-50 p-6">
                <p class="text-sm font-medium uppercase tracking-wider text-emerald-700">Total Collections</p>
                <p class="mt-2 font-serif text-4xl font-semibold tracking-tight text-emerald-800"><?php echo e(\App\Services\FinanceService::formatBalance($totalCollections)); ?></p>
                <p class="mt-1 text-xs text-emerald-600"><?php echo e(number_format($collectionCount)); ?> valid payment records · paid + partial only</p>
            </div>
            <div class="rounded-lg border border-maroon-200 bg-maroon-50 p-6">
                <p class="text-sm font-medium uppercase tracking-wider text-maroon-700">Total Expenses</p>
                <p class="mt-2 font-serif text-4xl font-semibold tracking-tight text-maroon-800"><?php echo e(\App\Services\FinanceService::formatBalance($totalExpenses)); ?></p>
                <p class="mt-1 text-xs text-maroon-600"><?php echo e(number_format($expenseCount)); ?> recorded expenses · void excluded</p>
            </div>
            <div class="rounded-lg border border-navy-200 bg-white p-6 shadow-sm sm:col-span-2 lg:col-span-1">
                <p class="text-sm font-medium uppercase tracking-wider text-ink-soft">Current Balance</p>
                <p class="mt-2 font-serif text-4xl font-semibold tracking-tight <?php echo e($currentBalance < 0 ? 'text-maroon-700' : 'text-navy-950'); ?>"><?php echo e(\App\Services\FinanceService::formatBalance($currentBalance)); ?></p>
                <p class="mt-1 text-xs text-ink-soft">Total collections minus total expenses</p>
            </div>
        </div>
    </section>

    
    <section class="mt-10" aria-labelledby="finance-current-month">
        <h2 id="finance-current-month" class="font-serif text-xl font-semibold text-navy-950">This Month — <?php echo e(now()->format('F Y')); ?></h2>
        <div class="mt-4 grid gap-5 sm:grid-cols-3">
            <div class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm">
                <p class="text-sm font-medium uppercase tracking-wider text-ink-soft">Collected</p>
                <p class="mt-2 font-serif text-3xl font-semibold tracking-tight text-navy-950"><?php echo e(\App\Services\FinanceService::formatBalance($monthCollections)); ?></p>
            </div>
            <div class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm">
                <p class="text-sm font-medium uppercase tracking-wider text-ink-soft">Spent</p>
                <p class="mt-2 font-serif text-3xl font-semibold tracking-tight text-navy-950"><?php echo e(\App\Services\FinanceService::formatBalance($monthExpenses)); ?></p>
            </div>
            <div class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm">
                <p class="text-sm font-medium uppercase tracking-wider text-ink-soft">Balance</p>
                <p class="mt-2 font-serif text-3xl font-semibold tracking-tight <?php echo e($monthBalance < 0 ? 'text-maroon-700' : 'text-navy-950'); ?>"><?php echo e(\App\Services\FinanceService::formatBalance($monthBalance)); ?></p>
            </div>
        </div>
    </section>

    
    <section class="mt-10" aria-labelledby="finance-yearly">
        <h2 id="finance-yearly" class="font-serif text-xl font-semibold text-navy-950">Collections vs Expenses — <?php echo e($year); ?></h2>
        <div class="mt-4 overflow-hidden rounded-lg border border-navy-100 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-navy-100 text-sm">
                    <thead class="bg-cream">
                        <tr>
                            <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-ink-soft">Month</th>
                            <th scope="col" class="px-6 py-3.5 text-right text-xs font-semibold uppercase tracking-wider text-ink-soft">Collections</th>
                            <th scope="col" class="px-6 py-3.5 text-right text-xs font-semibold uppercase tracking-wider text-ink-soft">Expenses</th>
                            <th scope="col" class="px-6 py-3.5 text-right text-xs font-semibold uppercase tracking-wider text-ink-soft">Balance</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-navy-50">
                        <?php $__currentLoopData = $yearly; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="transition-colors hover:bg-cream/60">
                                <td class="px-6 py-3.5 font-medium text-navy-950"><?php echo e($row['label']); ?></td>
                                <td class="px-6 py-3.5 text-right text-navy-950"><?php echo e($row['collections'] > 0 ? '৳'.number_format($row['collections']) : '—'); ?></td>
                                <td class="px-6 py-3.5 text-right text-navy-950"><?php echo e($row['expenses'] > 0 ? '৳'.number_format($row['expenses']) : '—'); ?></td>
                                <td class="px-6 py-3.5 text-right font-semibold <?php echo e($row['balance'] < 0 ? 'text-maroon-700' : 'text-navy-950'); ?>"><?php echo e(\App\Services\FinanceService::formatBalance($row['balance'])); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                    <tfoot class="bg-cream font-semibold">
                        <tr>
                            <td class="px-6 py-3.5 text-xs font-semibold uppercase tracking-wider text-ink-soft">Year Total</td>
                            <td class="px-6 py-3.5 text-right text-navy-950"><?php echo e(\App\Services\FinanceService::formatBalance(collect($yearly)->sum('collections'))); ?></td>
                            <td class="px-6 py-3.5 text-right text-navy-950"><?php echo e(\App\Services\FinanceService::formatBalance(collect($yearly)->sum('expenses'))); ?></td>
                            <td class="px-6 py-3.5 text-right <?php echo e(collect($yearly)->sum('balance') < 0 ? 'text-maroon-700' : 'text-navy-950'); ?>"><?php echo e(\App\Services\FinanceService::formatBalance(collect($yearly)->sum('balance'))); ?></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </section>

    
    <section class="mt-10" aria-labelledby="finance-breakdown">
        <h2 id="finance-breakdown" class="font-serif text-xl font-semibold text-navy-950">
            Expense Category Breakdown
            <span class="text-sm font-normal text-ink-soft"><?php echo e($selectedMonth ? \Illuminate\Support\Carbon::create($year, $selectedMonth, 1)->format('F Y') : $year); ?></span>
        </h2>

        <?php if($breakdown->count()): ?>
            <div class="mt-4 overflow-hidden rounded-lg border border-navy-100 bg-white shadow-sm">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-navy-100 text-sm">
                        <thead class="bg-cream">
                            <tr>
                                <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-ink-soft">Category</th>
                                <th scope="col" class="px-6 py-3.5 text-right text-xs font-semibold uppercase tracking-wider text-ink-soft">Total Expenses</th>
                                <th scope="col" class="px-6 py-3.5 text-right text-xs font-semibold uppercase tracking-wider text-ink-soft">Share</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-navy-50">
                            <?php $__currentLoopData = $breakdown; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $percentage = $breakdownTotal > 0 ? round(($item->total / $breakdownTotal) * 100) : 0;
                                ?>
                                <tr class="transition-colors hover:bg-cream/60">
                                    <td class="px-6 py-3.5 font-medium text-navy-950"><?php echo e($item->name); ?> <span class="text-xs font-normal text-ink-soft">(<?php echo e(number_format($item->count)); ?>)</span></td>
                                    <td class="px-6 py-3.5 text-right text-navy-950">৳<?php echo e(number_format($item->total)); ?></td>
                                    <td class="px-6 py-3.5 text-right text-ink-soft"><?php echo e($percentage); ?>%</td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php else: ?>
            <div class="mt-4">
                <?php if (isset($component)) { $__componentOriginal074a021b9d42f490272b5eefda63257c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal074a021b9d42f490272b5eefda63257c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.empty-state','data' => ['compact' => true,'title' => 'No expenses in this period','description' => 'Recorded (non-void) expenses will appear here grouped by category.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('empty-state'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['compact' => true,'title' => 'No expenses in this period','description' => 'Recorded (non-void) expenses will appear here grouped by category.']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal074a021b9d42f490272b5eefda63257c)): ?>
<?php $attributes = $__attributesOriginal074a021b9d42f490272b5eefda63257c; ?>
<?php unset($__attributesOriginal074a021b9d42f490272b5eefda63257c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal074a021b9d42f490272b5eefda63257c)): ?>
<?php $component = $__componentOriginal074a021b9d42f490272b5eefda63257c; ?>
<?php unset($__componentOriginal074a021b9d42f490272b5eefda63257c); ?>
<?php endif; ?>
            </div>
        <?php endif; ?>
    </section>

    
    <section class="mt-10 grid gap-8 lg:grid-cols-2" aria-label="Recent transactions">
        <div>
            <h2 class="font-serif text-xl font-semibold text-navy-950">Recent Collections</h2>
            <div class="mt-4 overflow-hidden rounded-lg border border-navy-100 bg-white shadow-sm">
                <?php if($recentCollections->count()): ?>
                    <ul class="divide-y divide-navy-50">
                        <?php $__currentLoopData = $recentCollections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li>
                                <a href="<?php echo e(route('admin.payments.show', $payment)); ?>" class="focus-ring flex items-center justify-between gap-3 px-5 py-3.5 transition-colors hover:bg-cream/60">
                                    <div class="min-w-0">
                                        <p class="truncate text-sm font-medium text-navy-950"><?php echo e($payment->membership?->alumni?->full_name ?? $payment->membership?->membership_number ?? 'Member'); ?></p>
                                        <p class="font-mono text-xs text-ink-soft"><?php echo e($payment->payment_number); ?> · <?php echo e($payment->paid_at?->format('M j, Y')); ?></p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm font-semibold text-emerald-700">+<?php echo e($payment->formattedAmount()); ?></p>
                                        <p class="text-xs text-ink-soft"><?php echo e($payment->status->label()); ?></p>
                                    </div>
                                </a>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                <?php else: ?>
                    <p class="px-5 py-8 text-center text-sm text-ink-soft">No collections recorded yet.</p>
                <?php endif; ?>
            </div>
        </div>
        <div>
            <h2 class="font-serif text-xl font-semibold text-navy-950">Recent Expenses</h2>
            <div class="mt-4 overflow-hidden rounded-lg border border-navy-100 bg-white shadow-sm">
                <?php if($recentExpenses->count()): ?>
                    <ul class="divide-y divide-navy-50">
                        <?php $__currentLoopData = $recentExpenses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $expense): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li>
                                <a href="<?php echo e(route('admin.expenses.show', $expense)); ?>" class="focus-ring flex items-center justify-between gap-3 px-5 py-3.5 transition-colors hover:bg-cream/60">
                                    <div class="min-w-0">
                                        <p class="truncate text-sm font-medium text-navy-950"><?php echo e($expense->title); ?></p>
                                        <p class="font-mono text-xs text-ink-soft"><?php echo e($expense->expense_number); ?> · <?php echo e($expense->expense_date?->format('M j, Y')); ?></p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm font-semibold text-maroon-700">−<?php echo e($expense->formattedAmount()); ?></p>
                                        <p class="text-xs text-ink-soft"><?php echo e($expense->category?->name); ?></p>
                                    </div>
                                </a>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                <?php else: ?>
                    <p class="px-5 py-8 text-center text-sm text-ink-soft">No expenses recorded yet.</p>
                <?php endif; ?>
            </div>
        </div>
    </section>
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
<?php /**PATH C:\xampp\htdocs\ProDo\EDAA\resources\views\admin\finance\index.blade.php ENDPATH**/ ?>