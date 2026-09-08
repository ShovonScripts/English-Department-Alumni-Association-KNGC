<?php if (isset($component)) { $__componentOriginal5863877a5171c196453bfa0bd807e410 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5863877a5171c196453bfa0bd807e410 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.app','data' => ['title' => 'Financial Transparency','description' => 'View the aggregate financial overview and transparency information of '.e(config('site.name')).'.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.app'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Financial Transparency','description' => 'View the aggregate financial overview and transparency information of '.e(config('site.name')).'.']); ?>

    <?php if (isset($component)) { $__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.page-header','data' => ['title' => 'Financial Transparency','description' => 'A transparent overview of the financial position of '.e(config('site.short_name')).'.','eyebrow' => 'Transparency','breadcrumbs' => [['label' => 'Finance']]]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('page-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Financial Transparency','description' => 'A transparent overview of the financial position of '.e(config('site.short_name')).'.','eyebrow' => 'Transparency','breadcrumbs' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([['label' => 'Finance']])]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e)): ?>
<?php $attributes = $__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e; ?>
<?php unset($__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e)): ?>
<?php $component = $__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e; ?>
<?php unset($__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e); ?>
<?php endif; ?>

    
    <section class="section-pad bg-white">
        <div class="container-page">
            <?php if (isset($component)) { $__componentOriginal755230460fd16c04121658d92fbf99f7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal755230460fd16c04121658d92fbf99f7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.section-heading','data' => ['eyebrow' => 'Financial Overview','title' => 'Association Funds','description' => 'Aggregate financial records maintained by the Association. Individual member payments and expense records are not publicly disclosed.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('section-heading'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['eyebrow' => 'Financial Overview','title' => 'Association Funds','description' => 'Aggregate financial records maintained by the Association. Individual member payments and expense records are not publicly disclosed.']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal755230460fd16c04121658d92fbf99f7)): ?>
<?php $attributes = $__attributesOriginal755230460fd16c04121658d92fbf99f7; ?>
<?php unset($__attributesOriginal755230460fd16c04121658d92fbf99f7); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal755230460fd16c04121658d92fbf99f7)): ?>
<?php $component = $__componentOriginal755230460fd16c04121658d92fbf99f7; ?>
<?php unset($__componentOriginal755230460fd16c04121658d92fbf99f7); ?>
<?php endif; ?>

            <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                
                <div class="rounded-lg border border-emerald-200 bg-emerald-50 p-8 text-center">
                    <p class="text-sm font-medium uppercase tracking-wider text-emerald-700">Total Collections</p>
                    <p class="mt-3 font-serif text-4xl font-semibold tracking-tight text-emerald-800">
                        <?php echo e(\App\Services\FinanceService::formatBalance($totalCollections)); ?>

                    </p>
                    <p class="mt-2 text-xs text-emerald-600">Organizational dues collected (paid + partial)</p>
                </div>

                
                <div class="rounded-lg border border-maroon-200 bg-maroon-50 p-8 text-center">
                    <p class="text-sm font-medium uppercase tracking-wider text-maroon-700">Total Expenses</p>
                    <p class="mt-3 font-serif text-4xl font-semibold tracking-tight text-maroon-800">
                        <?php echo e(\App\Services\FinanceService::formatBalance($totalExpenses)); ?>

                    </p>
                    <p class="mt-2 text-xs text-maroon-600">Association spending (recorded expenses)</p>
                </div>

                
                <div class="rounded-lg border border-navy-200 bg-white p-8 text-center shadow-sm sm:col-span-2 lg:col-span-1">
                    <p class="text-sm font-medium uppercase tracking-wider text-ink-soft">Current Balance</p>
                    <p class="mt-3 font-serif text-4xl font-semibold tracking-tight <?php echo e($currentBalance < 0 ? 'text-maroon-700' : 'text-navy-950'); ?>">
                        <?php echo e(\App\Services\FinanceService::formatBalance($currentBalance)); ?>

                    </p>
                    <p class="mt-2 text-xs text-ink-soft">Total collections minus total expenses</p>
                </div>
            </div>
        </div>
    </section>

    
    <section class="bg-cream py-16 sm:py-20 lg:py-24">
        <div class="container-page">
            <?php if (isset($component)) { $__componentOriginal755230460fd16c04121658d92fbf99f7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal755230460fd16c04121658d92fbf99f7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.section-heading','data' => ['eyebrow' => 'Current Period','title' => ''.e(now()->format('F Y')).'','description' => 'Monthly financial activity for the current period.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('section-heading'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['eyebrow' => 'Current Period','title' => ''.e(now()->format('F Y')).'','description' => 'Monthly financial activity for the current period.']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal755230460fd16c04121658d92fbf99f7)): ?>
<?php $attributes = $__attributesOriginal755230460fd16c04121658d92fbf99f7; ?>
<?php unset($__attributesOriginal755230460fd16c04121658d92fbf99f7); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal755230460fd16c04121658d92fbf99f7)): ?>
<?php $component = $__componentOriginal755230460fd16c04121658d92fbf99f7; ?>
<?php unset($__componentOriginal755230460fd16c04121658d92fbf99f7); ?>
<?php endif; ?>

            <div class="mt-10 grid gap-6 sm:grid-cols-3">
                <div class="rounded-lg border border-navy-100 bg-white p-8 text-center shadow-sm">
                    <p class="text-sm font-medium uppercase tracking-wider text-ink-soft">Collected</p>
                    <p class="mt-3 font-serif text-3xl font-semibold tracking-tight text-navy-950">
                        <?php echo e(\App\Services\FinanceService::formatBalance($monthCollections)); ?>

                    </p>
                </div>
                <div class="rounded-lg border border-navy-100 bg-white p-8 text-center shadow-sm">
                    <p class="text-sm font-medium uppercase tracking-wider text-ink-soft">Spent</p>
                    <p class="mt-3 font-serif text-3xl font-semibold tracking-tight text-navy-950">
                        <?php echo e(\App\Services\FinanceService::formatBalance($monthExpenses)); ?>

                    </p>
                </div>
                <div class="rounded-lg border border-navy-100 bg-white p-8 text-center shadow-sm">
                    <p class="text-sm font-medium uppercase tracking-wider text-ink-soft">Balance</p>
                    <p class="mt-3 font-serif text-3xl font-semibold tracking-tight <?php echo e($monthBalance < 0 ? 'text-maroon-700' : 'text-navy-950'); ?>">
                        <?php echo e(\App\Services\FinanceService::formatBalance($monthBalance)); ?>

                    </p>
                </div>
            </div>
        </div>
    </section>

    
    <section class="section-pad bg-white">
        <div class="container-page">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                <?php if (isset($component)) { $__componentOriginal755230460fd16c04121658d92fbf99f7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal755230460fd16c04121658d92fbf99f7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.section-heading','data' => ['eyebrow' => 'Annual Report','title' => 'Yearly Summary — '.e($year).'','description' => 'Month-by-month overview of collections and expenses.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('section-heading'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['eyebrow' => 'Annual Report','title' => 'Yearly Summary — '.e($year).'','description' => 'Month-by-month overview of collections and expenses.']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal755230460fd16c04121658d92fbf99f7)): ?>
<?php $attributes = $__attributesOriginal755230460fd16c04121658d92fbf99f7; ?>
<?php unset($__attributesOriginal755230460fd16c04121658d92fbf99f7); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal755230460fd16c04121658d92fbf99f7)): ?>
<?php $component = $__componentOriginal755230460fd16c04121658d92fbf99f7; ?>
<?php unset($__componentOriginal755230460fd16c04121658d92fbf99f7); ?>
<?php endif; ?>

                
                <form method="GET" action="<?php echo e(route('finance.public')); ?>" class="shrink-0">
                    <label for="year" class="sr-only">Select year</label>
                    <select id="year" name="year" onchange="this.form.submit()" class="rounded-md border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none">
                        <?php $__currentLoopData = $availableYears; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $y): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($y); ?>" <?php if($y === $year): echo 'selected'; endif; ?>><?php echo e($y); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </form>
            </div>

            <div class="mt-8 overflow-hidden rounded-lg border border-navy-100 bg-white shadow-sm">
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
                                    <td class="px-6 py-3.5 text-right text-navy-950">
                                        <?php echo e($row['collections'] > 0 ? '৳'.number_format($row['collections']) : '—'); ?>

                                    </td>
                                    <td class="px-6 py-3.5 text-right text-navy-950">
                                        <?php echo e($row['expenses'] > 0 ? '৳'.number_format($row['expenses']) : '—'); ?>

                                    </td>
                                    <td class="px-6 py-3.5 text-right font-semibold <?php echo e($row['balance'] < 0 ? 'text-maroon-700' : 'text-navy-950'); ?>">
                                        <?php echo e(\App\Services\FinanceService::formatBalance($row['balance'])); ?>

                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                        <tfoot class="bg-cream font-semibold">
                            <tr>
                                <td class="px-6 py-3.5 text-xs font-semibold uppercase tracking-wider text-ink-soft">Year Total</td>
                                <td class="px-6 py-3.5 text-right text-navy-950"><?php echo e(\App\Services\FinanceService::formatBalance(collect($yearly)->sum('collections'))); ?></td>
                                <td class="px-6 py-3.5 text-right text-navy-950"><?php echo e(\App\Services\FinanceService::formatBalance(collect($yearly)->sum('expenses'))); ?></td>
                                <td class="px-6 py-3.5 text-right <?php echo e(collect($yearly)->sum('balance') < 0 ? 'text-maroon-700' : 'text-navy-950'); ?>">
                                    <?php echo e(\App\Services\FinanceService::formatBalance(collect($yearly)->sum('balance'))); ?>

                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </section>

    
    <section class="bg-cream py-16 sm:py-20 lg:py-24">
        <div class="container-page">
            <?php if (isset($component)) { $__componentOriginal755230460fd16c04121658d92fbf99f7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal755230460fd16c04121658d92fbf99f7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.section-heading','data' => ['eyebrow' => 'Where Funds Go','title' => 'Expense Breakdown','description' => 'How association funds are allocated across activity categories.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('section-heading'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['eyebrow' => 'Where Funds Go','title' => 'Expense Breakdown','description' => 'How association funds are allocated across activity categories.']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal755230460fd16c04121658d92fbf99f7)): ?>
<?php $attributes = $__attributesOriginal755230460fd16c04121658d92fbf99f7; ?>
<?php unset($__attributesOriginal755230460fd16c04121658d92fbf99f7); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal755230460fd16c04121658d92fbf99f7)): ?>
<?php $component = $__componentOriginal755230460fd16c04121658d92fbf99f7; ?>
<?php unset($__componentOriginal755230460fd16c04121658d92fbf99f7); ?>
<?php endif; ?>

            <?php if($breakdown->count()): ?>
                <div class="mt-10 overflow-hidden rounded-lg border border-navy-100 bg-white shadow-sm">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-navy-100 text-sm">
                            <thead class="bg-cream">
                                <tr>
                                    <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-ink-soft">Category</th>
                                    <th scope="col" class="px-6 py-3.5 text-right text-xs font-semibold uppercase tracking-wider text-ink-soft">Total</th>
                                    <th scope="col" class="px-6 py-3.5 text-right text-xs font-semibold uppercase tracking-wider text-ink-soft">Share</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-navy-50">
                                <?php $__currentLoopData = $breakdown; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $percentage = $breakdownTotal > 0 ? round(($item->total / $breakdownTotal) * 100) : 0;
                                    ?>
                                    <tr class="transition-colors hover:bg-cream/60">
                                        <td class="px-6 py-3.5 font-medium text-navy-950"><?php echo e($item->name); ?></td>
                                        <td class="px-6 py-3.5 text-right text-navy-950">৳<?php echo e(number_format($item->total)); ?></td>
                                        <td class="px-6 py-3.5 text-right text-ink-soft"><?php echo e($percentage); ?>%</td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php else: ?>
                <div class="mt-10">
                    <?php if (isset($component)) { $__componentOriginal074a021b9d42f490272b5eefda63257c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal074a021b9d42f490272b5eefda63257c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.empty-state','data' => ['compact' => true,'title' => 'No expenses recorded','description' => 'No recorded expenses are available for the selected period.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('empty-state'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['compact' => true,'title' => 'No expenses recorded','description' => 'No recorded expenses are available for the selected period.']); ?>
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
        </div>
    </section>

    
    <section class="section-pad bg-white">
        <div class="container-page">
            <div class="mx-auto max-w-3xl rounded-lg border border-navy-100 bg-cream p-8 sm:p-10">
                <?php if (isset($component)) { $__componentOriginal755230460fd16c04121658d92fbf99f7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal755230460fd16c04121658d92fbf99f7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.section-heading','data' => ['eyebrow' => 'Transparency','title' => 'About This Page','align' => 'center']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('section-heading'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['eyebrow' => 'Transparency','title' => 'About This Page','align' => 'center']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal755230460fd16c04121658d92fbf99f7)): ?>
<?php $attributes = $__attributesOriginal755230460fd16c04121658d92fbf99f7; ?>
<?php unset($__attributesOriginal755230460fd16c04121658d92fbf99f7); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal755230460fd16c04121658d92fbf99f7)): ?>
<?php $component = $__componentOriginal755230460fd16c04121658d92fbf99f7; ?>
<?php unset($__componentOriginal755230460fd16c04121658d92fbf99f7); ?>
<?php endif; ?>

                <div class="mt-6 space-y-4 text-sm leading-relaxed text-ink-soft">
                    <p>
                        Financial information shown on this page represents aggregate records maintained by the
                        <?php echo e(config('site.name')); ?>. Individual member payments and individual expense records
                        are not publicly disclosed.
                    </p>
                    <p>
                        Total Collections reflect organizational dues received from members (paid and partial
                        payments only). Void and waived records are excluded. Total Expenses reflect association
                        spending recorded by administrators. Void expenses are excluded.
                    </p>
                    <p>
                        The Current Balance is calculated as Total Collections minus Total Expenses. A negative
                        balance indicates that recorded expenses exceed recorded collections for the period shown.
                    </p>
                </div>

                <?php if($lastUpdatedAt): ?>
                    <p class="mt-6 text-center text-xs text-ink-soft">
                        Financial data updated through <?php echo e($lastUpdatedAt->format('j F Y')); ?>.
                    </p>
                <?php endif; ?>
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
<?php /**PATH C:\xampp\htdocs\ProDo\EDAA\resources\views\pages\finance.blade.php ENDPATH**/ ?>