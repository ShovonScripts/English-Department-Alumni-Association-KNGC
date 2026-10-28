<?php if (isset($component)) { $__componentOriginal5863877a5171c196453bfa0bd807e410 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5863877a5171c196453bfa0bd807e410 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.app','data' => ['title' => 'Member Leaderboard | EDAA-KNGC','description' => 'Recognizing members who have made verified financial contributions to EDAA-KNGC.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.app'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Member Leaderboard | EDAA-KNGC'),'description' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Recognizing members who have made verified financial contributions to EDAA-KNGC.')]); ?>

    
    <section class="section-pad bg-white">
        <div class="container-page">
            <div class="flex flex-col items-start justify-between gap-6 sm:flex-row sm:items-end">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-wider text-maroon-700">Member Leaderboard</p>
                    <h1 class="mt-2 font-serif text-4xl font-semibold tracking-tight text-navy-950 sm:text-5xl">
                        Recognizing Our Contributors
                    </h1>
                </div>
            </div>

            <div class="mt-8 rounded-lg border border-navy-100 bg-cream p-6 md:p-8">
                <p class="text-base leading-relaxed text-ink-soft">
                    This leaderboard recognizes members who have made <strong>verified financial contributions</strong> to the English Department Alumni Association KNGC.
                    Contributions are derived solely from manually recorded membership payments (paid and partial) — void and waived records are excluded.
                </p>
                <p class="mt-3 text-sm text-ink-soft">
                    Rankings are calculated using competition ranking: members with equal verified totals share the same rank,
                    and the next rank skips accordingly. Tier and type are displayed for context but do not determine ranking.
                </p>
            </div>
        </div>
    </section>

    
    <?php if($entries->isNotEmpty() && $entries->onFirstPage()): ?>
    <section class="bg-cream py-16 sm:py-20" aria-labelledby="podium-heading">
        <div class="container-page">
            <h2 id="podium-heading" class="sr-only">Top Contributors</h2>

            <div class="mx-auto grid max-w-4xl gap-5 sm:grid-cols-3">
                <?php $__currentLoopData = $entries->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $entry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <article
                        class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                            'rounded-lg border bg-white p-6 text-center shadow-sm relative',
                            'border-gold-400 ring-1 ring-gold-400/50' => $loop->first,
                            'border-navy-100' => ! $loop->first,
                        ]); ?>"
                        aria-labelledby="podium-<?php echo e($loop->index); ?>-name"
                    >
                        
                        <div class="absolute -top-4 left-1/2 -translate-x-1/2">
                            <span
                                class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                                    'inline-flex h-10 w-10 items-center justify-center rounded-full font-serif text-base font-bold',
                                    'bg-gold-500 text-navy-950' => $loop->first,
                                    'bg-navy-900 text-gold-300' => ! $loop->first,
                                ]); ?>"
                                aria-label="<?php echo e(\Illuminate\Support\Number::ordinal($entry->leaderboard_rank)); ?> place"
                            >
                                <?php echo e($entry->leaderboard_rank); ?>

                            </span>
                        </div>

                        <span class="sr-only"><?php echo e(\Illuminate\Support\Number::ordinal($entry->leaderboard_rank)); ?> place</span>

                        
                        <div class="mt-8 flex justify-center">
                            <?php if($entry->profile_photo): ?>
                                <img src="<?php echo e(Storage::disk('public')->url($entry->profile_photo)); ?>" alt="Portrait of <?php echo e($entry->alumni_name); ?>" class="h-20 w-20 rounded-full object-cover ring-4 ring-gold-500/30">
                            <?php else: ?>
                                <span class="flex h-20 w-20 items-center justify-center rounded-full bg-navy-900 font-serif text-xl font-semibold text-gold-300 ring-4 ring-gold-500/30" aria-hidden="true">
                                    <?php echo e(\Illuminate\Support\Str::initials($entry->alumni_name)); ?>

                                </span>
                            <?php endif; ?>
                        </div>

                        
                        <h3 class="mt-4 truncate font-serif text-lg font-semibold text-navy-950" id="podium-<?php echo e($loop->index); ?>-name">
                            <?php echo e($entry->alumni_name); ?>

                        </h3>

                        
                        <?php if($entry->tier_name): ?>
                            <div class="mt-2">
                                <span class="inline-flex items-center gap-1.5 rounded-full border border-gold-500/50 bg-gold-500/15 px-3 py-1 text-[11px] font-semibold uppercase tracking-widest text-gold-700">
                                    <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                        <path d="M10 2l1.9 4.05 4.45.55-3.28 3.1.85 4.4L10 11.95 6.08 14.1l.85-4.4L3.65 6.6l4.45-.55L10 2z" />
                                    </svg>
                                    <?php echo e($entry->tier_name); ?> Member
                                </span>
                            </div>
                        <?php endif; ?>

                        
                        <div class="mt-4 pt-4 border-t border-navy-100">
                            <p class="text-[11px] font-semibold uppercase tracking-widest text-maroon-700">Verified Contribution</p>
                            <p class="mt-1 text-2xl font-bold tabular-nums text-navy-950"><?php echo e($entry->formatted_contribution); ?></p>
                            <p class="mt-1 text-xs text-ink-soft"><?php echo e($entry->valid_payment_count); ?> payment<?php echo e($entry->valid_payment_count !== 1 ? 's' : ''); ?></p>
                        </div>
                    </article>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    
    <section class="section-pad bg-white" aria-labelledby="ranked-list-heading">
        <div class="container-page">
            <h2 id="ranked-list-heading" class="sr-only">Full Leaderboard</h2>

            
            <form method="GET" action="<?php echo e(route('leaderboard.index')); ?>" class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm" aria-label="Leaderboard filters">
                <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-5">
                    
                    <div class="sm:col-span-2 lg:col-span-3">
                        <label for="q" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Search</label>
                        <input
                            type="search"
                            id="q"
                            name="q"
                            value="<?php echo e($filters['q']); ?>"
                            placeholder="Search by name or student ID…"
                            class="w-full rounded-md border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 placeholder-navy-400 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none"
                        >
                    </div>

                    
                    <div>
                        <label for="type" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Membership Type</label>
                        <select id="type" name="type" class="w-full rounded-md border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none">
                            <option value="">All Types</option>
                            <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($type->slug); ?>" <?php if($filters['type'] === $type->slug): echo 'selected'; endif; ?>><?php echo e($type->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    
                    <div>
                        <label for="tier" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Membership Tier</label>
                        <select id="tier" name="tier" class="w-full rounded-md border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none">
                            <option value="">All Tiers</option>
                            <?php $__currentLoopData = $tiers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($tier->slug); ?>" <?php if($filters['tier'] === $tier->slug): echo 'selected'; endif; ?>><?php echo e($tier->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    
                    <div>
                        <label for="batch" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Batch</label>
                        <select id="batch" name="batch" class="w-full rounded-md border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none">
                            <option value="">All Batches</option>
                            <?php $__currentLoopData = $batches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $batch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($batch); ?>" <?php if($filters['batch'] === (string) $batch): echo 'selected'; endif; ?>><?php echo e($batch); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    
                    <div class="flex items-end gap-2">
                        <?php if (isset($component)) { $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.button','data' => ['type' => 'submit','variant' => 'navy']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'submit','variant' => 'navy']); ?>Apply <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561)): ?>
<?php $attributes = $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561; ?>
<?php unset($__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald0f1fd2689e4bb7060122a5b91fe8561)): ?>
<?php $component = $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561; ?>
<?php unset($__componentOriginald0f1fd2689e4bb7060122a5b91fe8561); ?>
<?php endif; ?>
                        <a href="<?php echo e(route('leaderboard.index')); ?>" class="focus-ring inline-flex h-10 items-center justify-center rounded-md px-4 text-sm font-semibold text-navy-600 transition-colors hover:bg-navy-50 hover:text-navy-900">Clear</a>
                    </div>
                </div>
            </form>

            
            <?php if($entries->isNotEmpty()): ?>
                <div class="mt-8 overflow-hidden rounded-lg border border-navy-100 bg-white shadow-sm">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm" role="table">
                            <thead>
                                <tr class="border-b border-navy-100 bg-navy-50/60 text-xs uppercase tracking-wider text-ink-soft">
                                    <th class="px-6 py-3.5 font-semibold w-16">Rank</th>
                                    <th class="px-6 py-3.5 font-semibold">Member</th>
                                    <th class="px-6 py-3.5 font-semibold hidden md:table-cell">Tier</th>
                                    <th class="px-6 py-3.5 font-semibold hidden lg:table-cell">Type</th>
                                    <th class="px-6 py-3.5 font-semibold text-right">Verified Contribution</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-navy-100">
                                <?php $__currentLoopData = $entries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $entry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr class="transition-colors hover:bg-cream/70">
                                        <td class="px-6 py-4 font-mono text-sm font-semibold text-navy-900">
                                            <span class="inline-flex h-8 w-8 items-center justify-center rounded-full font-serif text-xs font-bold <?php echo e($entry->leaderboard_rank <= 3 ? 'bg-gold-500 text-navy-950' : 'bg-navy-100 text-navy-950'); ?>">
                                                <?php echo e($entry->leaderboard_rank); ?>

                                            </span>
                                            <span class="sr-only"><?php echo e(\Illuminate\Support\Number::ordinal($entry->leaderboard_rank)); ?> place</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                <?php if($entry->profile_photo): ?>
                                                    <img src="<?php echo e(Storage::disk('public')->url($entry->profile_photo)); ?>" alt="<?php echo e($entry->alumni_name); ?>" class="h-10 w-10 rounded-full object-cover ring-2 ring-gold-500/40">
                                                <?php else: ?>
                                                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-navy-900 font-serif text-xs font-semibold text-gold-300" aria-hidden="true">
                                                        <?php echo e(\Illuminate\Support\Str::initials($entry->alumni_name)); ?>

                                                    </span>
                                                <?php endif; ?>
                                                <div>
                                                    <a href="<?php echo e(route('alumni.show', $entry->alumni_slug)); ?>" class="focus-ring font-medium text-navy-950 transition-colors hover:text-maroon-700"><?php echo e($entry->alumni_name); ?></a>
                                                    <?php if($entry->student_id): ?>
                                                        <p class="text-xs text-ink-soft"><?php echo e($entry->student_id); ?></p>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 hidden md:table-cell">
                                            <?php if($entry->tier_name): ?>
                                                <span class="inline-flex items-center gap-1.5 rounded-full border border-gold-500/50 bg-gold-500/15 px-2.5 py-1 text-[10px] font-semibold uppercase tracking-widest text-gold-700">
                                                    <svg class="h-2.5 w-2.5" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                                        <path d="M10 2l1.9 4.05 4.45.55-3.28 3.1.85 4.4L10 11.95 6.08 14.1l.85-4.4L3.65 6.6l4.45-.55L10 2z" />
                                                    </svg>
                                                    <?php echo e($entry->tier_name); ?>

                                                </span>
                                            <?php else: ?>
                                                <span class="text-ink-soft">—</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="px-6 py-4 hidden lg:table-cell text-ink-soft"><?php echo e($entry->type_name ?? '—'); ?></td>
                                        <td class="px-6 py-4 text-right font-bold tabular-nums text-navy-950"><?php echo e($entry->formatted_contribution); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>

                    
                    <div class="border-t border-navy-100 px-6 py-4">
                        <?php echo e($entries->appends(request()->query())->links()); ?>

                    </div>
                </div>
            <?php else: ?>
                <div class="mt-8">
                    <?php if (isset($component)) { $__componentOriginal074a021b9d42f490272b5eefda63257c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal074a021b9d42f490272b5eefda63257c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.empty-state','data' => ['title' => 'No contributors found','description' => 'No members match your current filters. Try adjusting your search or filter criteria.','compact' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('empty-state'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'No contributors found','description' => 'No members match your current filters. Try adjusting your search or filter criteria.','compact' => true]); ?>
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

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5863877a5171c196453bfa0bd807e410)): ?>
<?php $attributes = $__attributesOriginal5863877a5171c196453bfa0bd807e410; ?>
<?php unset($__attributesOriginal5863877a5171c196453bfa0bd807e410); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5863877a5171c196453bfa0bd807e410)): ?>
<?php $component = $__componentOriginal5863877a5171c196453bfa0bd807e410; ?>
<?php unset($__componentOriginal5863877a5171c196453bfa0bd807e410); ?>
<?php endif; ?><?php /**PATH C:\xampp\htdocs\ProDo\EDAA\resources\views/pages/leaderboard.blade.php ENDPATH**/ ?>