<?php if (isset($component)) { $__componentOriginalc8c9fd5d7827a77a31381de67195f0c3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc8c9fd5d7827a77a31381de67195f0c3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.admin','data' => ['title' => 'Leaderboard Management']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.admin'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Leaderboard Management']); ?>
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="font-serif text-3xl font-semibold tracking-tight text-navy-950">Leaderboard Management</h1>
            <p class="mt-1 text-sm text-ink-soft">
                Administrative view of member contribution rankings. All memberships are shown including hidden, private, and zero-contribution records.
                Verified contributions are derived from <code class="bg-navy-50 px-1.5 py-0.5 rounded text-xs font-mono">Payment::valid()</code> (paid + partial) — never manually editable.
            </p>
        </div>

        
        <div class="flex items-center gap-4">
            <div class="inline-flex items-center gap-3 rounded-md border border-navy-200 bg-cream px-4 py-3">
                <span class="text-sm font-medium text-navy-950">Public Leaderboard</span>
                <form method="POST" action="<?php echo e(route('admin.leaderboard.togglePublic')); ?>">
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
                    <?php echo e($publicEnabled ? 'Contributors are visible on /leaderboard' : 'Public leaderboard is hidden'); ?>

                </span>
            </div>
        </div>
    </div>

    <?php if(session('status')): ?>
        <div class="mb-6 flex items-center gap-3 rounded-md border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800" role="status">
            <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <?php echo e(session('status')); ?>

        </div>
    <?php endif; ?>

    
    <form method="GET" action="<?php echo e(route('admin.leaderboard.index')); ?>" class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm" aria-label="Leaderboard filters">
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-8">
            
            <div class="lg:col-span-3">
                <label for="q" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Search</label>
                <input
                    type="search"
                    id="q"
                    name="q"
                    value="<?php echo e($filters['q']); ?>"
                    placeholder="Name, student ID, membership #…"
                    class="w-full rounded-md border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 placeholder-navy-400 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none"
                >
            </div>

            
            <div>
                <label for="type" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Type</label>
                <select id="type" name="type" class="w-full rounded-md border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none">
                    <option value="">All Types</option>
                    <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($type->slug); ?>" <?php if($filters['type'] === $type->slug): echo 'selected'; endif; ?>><?php echo e($type->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            
            <div>
                <label for="tier" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Tier</label>
                <select id="tier" name="tier" class="w-full rounded-md border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none">
                    <option value="">All Tiers</option>
                    <?php $__currentLoopData = $tiers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($tier->slug); ?>" <?php if($filters['tier'] === $tier->slug): echo 'selected'; endif; ?>><?php echo e($tier->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            
            <div>
                <label for="status" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Status</label>
                <select id="status" name="status" class="w-full rounded-md border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none">
                    <option value="">All Statuses</option>
                    <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($status); ?>" <?php if($filters['status'] === $status): echo 'selected'; endif; ?>><?php echo e(ucfirst($status)); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            
            <div>
                <label for="visibility" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Leaderboard</label>
                <select id="visibility" name="visibility" class="w-full rounded-md border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none">
                    <option value="">All</option>
                    <option value="public" <?php if($filters['visibility'] === 'public'): echo 'selected'; endif; ?>>Public</option>
                    <option value="hidden" <?php if($filters['visibility'] === 'hidden'): echo 'selected'; endif; ?>>Hidden</option>
                </select>
            </div>

            
            <div>
                <label for="min_contribution" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Min. Contribution (৳)</label>
                <input
                    type="number"
                    id="min_contribution"
                    name="min_contribution"
                    value="<?php echo e($filters['min_contribution']); ?>"
                    min="0"
                    step="1"
                    placeholder="0"
                    class="w-full rounded-md border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 placeholder-navy-400 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none"
                >
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
<?php $component->withAttributes(['type' => 'submit','variant' => 'navy']); ?>Filter <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561)): ?>
<?php $attributes = $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561; ?>
<?php unset($__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald0f1fd2689e4bb7060122a5b91fe8561)): ?>
<?php $component = $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561; ?>
<?php unset($__componentOriginald0f1fd2689e4bb7060122a5b91fe8561); ?>
<?php endif; ?>
                <a href="<?php echo e(route('admin.leaderboard.index')); ?>" class="focus-ring inline-flex h-10 items-center justify-center rounded-md px-4 text-sm font-semibold text-navy-600 transition-colors hover:bg-navy-50 hover:text-navy-900">Clear</a>
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
                            <th class="px-6 py-3.5 font-semibold hidden md:table-cell">Membership #</th>
                            <th class="px-6 py-3.5 font-semibold hidden lg:table-cell">Type</th>
                            <th class="px-6 py-3.5 font-semibold hidden xl:table-cell">Tier</th>
                            <th class="px-6 py-3.5 font-semibold text-right">Verified Contribution</th>
                            <th class="px-6 py-3.5 font-semibold text-center hidden md:table-cell">Payments</th>
                            <th class="px-6 py-3.5 font-semibold text-center hidden lg:table-cell">Leaderboard</th>
                            <th class="px-6 py-3.5 font-semibold text-center">Status</th>
                            <th class="px-6 py-3.5 font-semibold text-right w-24">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-navy-100">
                        <?php $__currentLoopData = $entries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $entry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="transition-colors <?php echo e($entry->verified_total > 0 ? '' : 'bg-navy-50/30'); ?> <?php echo e($entry->status !== 'active' || ! $entry->is_public || ! $entry->show_on_leaderboard ? 'opacity-70' : ''); ?>">
                                
                                <td class="px-6 py-4 font-mono text-sm font-semibold text-navy-900">
                                    <?php if($entry->verified_total > 0): ?>
                                        <span class="inline-flex h-8 w-8 items-center justify-center rounded-full font-serif text-xs font-bold <?php echo e($entry->leaderboard_rank <= 3 ? 'bg-gold-500 text-navy-950' : 'bg-navy-100 text-navy-950'); ?>">
                                            <?php echo e($entry->leaderboard_rank); ?>

                                        </span>
                                        <span class="sr-only"><?php echo e(\Illuminate\Support\Number::ordinal($entry->leaderboard_rank)); ?> place</span>
                                    <?php else: ?>
                                        <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-navy-100 text-navy-400 text-[10px] font-medium">—</span>
                                        <span class="sr-only">Not ranked</span>
                                    <?php endif; ?>
                                </td>

                                
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <?php if($entry->profile_photo): ?>
                                            <img src="<?php echo e(Storage::disk('public')->url($entry->profile_photo)); ?>" alt="" class="h-10 w-10 rounded-full object-cover ring-2 ring-gold-500/40">
                                        <?php else: ?>
                                            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-navy-900 font-serif text-xs font-semibold text-gold-300" aria-hidden="true">
                                                <?php echo e(\Illuminate\Support\Str::initials($entry->alumni_name)); ?>

                                            </span>
                                        <?php endif; ?>
                                        <div>
                                            <a href="<?php echo e(route('admin.members.show', $entry->membership_id)); ?>" class="focus-ring font-medium text-navy-950 transition-colors hover:text-maroon-700"><?php echo e($entry->alumni_name); ?></a>
                                            <?php if($entry->student_id): ?>
                                                <p class="text-xs text-ink-soft"><?php echo e($entry->student_id); ?></p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </td>

                                
                                <td class="px-6 py-4 hidden md:table-cell font-mono text-xs text-ink-soft"><?php echo e($entry->membership_number); ?></td>

                                
                                <td class="px-6 py-4 hidden lg:table-cell text-ink-soft"><?php echo e($entry->type_name ?? '—'); ?></td>

                                
                                <td class="px-6 py-4 hidden xl:table-cell">
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

                                
                                <td class="px-6 py-4 text-right font-bold tabular-nums text-navy-950">
                                    <?php echo e($entry->formatted_contribution); ?>

                                    <?php if($entry->verified_total === 0): ?>
                                        <span class="ml-1 text-[10px] font-normal uppercase tracking-widest text-ink-soft">(none)</span>
                                    <?php endif; ?>
                                </td>

                                
                                <td class="px-6 py-4 text-center hidden md:table-cell font-mono text-sm text-navy-950"><?php echo e($entry->valid_payment_count); ?></td>

                                
                                <td class="px-6 py-4 text-center hidden lg:table-cell">
                                    <?php if($entry->is_public && $entry->show_on_leaderboard): ?>
                                        <span class="inline-flex rounded-full bg-emerald-100 px-2.5 py-1 text-[10px] font-semibold uppercase tracking-wide text-emerald-800">Public</span>
                                    <?php else: ?>
                                        <span class="inline-flex rounded-full bg-maroon-100 px-2.5 py-1 text-[10px] font-semibold uppercase tracking-wide text-maroon-800">Hidden</span>
                                    <?php endif; ?>
                                </td>

                                
                                <td class="px-6 py-4 text-center">
                                    <?php
                                        $statusStyles = [
                                            'active' => ['bg-emerald-100', 'text-emerald-800'],
                                            'pending' => ['bg-gold-500/20', 'text-gold-700'],
                                            'suspended' => ['bg-maroon-100', 'text-maroon-800'],
                                            'cancelled' => ['bg-navy-100', 'text-navy-600'],
                                            'expired' => ['bg-navy-100', 'text-navy-500'],
                                        ];
                                        [$bg, $text] = $statusStyles[$entry->status] ?? ['bg-navy-100', 'text-navy-600'];
                                    ?>
                                    <span class="inline-flex rounded-full <?php echo e($bg); ?> px-2.5 py-1 text-[10px] font-semibold uppercase tracking-wide <?php echo e($text); ?>"><?php echo e(ucfirst($entry->status)); ?></span>
                                </td>

                                
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-end gap-1">
                                        <a href="<?php echo e(route('admin.members.show', $entry->membership_id)); ?>" class="focus-ring inline-flex h-8 w-8 items-center justify-center rounded-md text-navy-600 transition-colors hover:bg-navy-50 hover:text-navy-900" aria-label="View <?php echo e($entry->membership_number); ?>">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.5 12S6 5.5 12 5.5 21.5 12 21.5 12 18 18.5 12 18.5 2.5 12 2.5 12z" />
                                            </svg>
                                        </a>

                                        
                                        <form method="POST" action="<?php echo e(route('admin.leaderboard.visibility', $entry->membership_id)); ?>" class="inline">
                                            <?php echo csrf_field(); ?>
                                            <?php if (isset($component)) { $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.button','data' => ['type' => 'submit','variant' => $entry->show_on_leaderboard ? 'navy' : 'outline','size' => 'icon','ariaLabel' => ''.e($entry->show_on_leaderboard ? 'Hide from public leaderboard' : 'Show on public leaderboard').'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'submit','variant' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($entry->show_on_leaderboard ? 'navy' : 'outline'),'size' => 'icon','aria-label' => ''.e($entry->show_on_leaderboard ? 'Hide from public leaderboard' : 'Show on public leaderboard').'']); ?>
                                                <?php if($entry->show_on_leaderboard): ?>
                                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                                    </svg>
                                                <?php else: ?>
                                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.5 12S6 5.5 12 5.5 21.5 12 21.5 12 18 18.5 12 18.5 2.5 12 2.5 12z" />
                                                    </svg>
                                                <?php endif; ?>
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
                                    </div>
                                </td>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.empty-state','data' => ['title' => 'No members found','description' => 'No membership records match your current filters. Adjust the filters or create a new membership to get started.','actionLabel' => 'Create Membership','actionHref' => ''.e(route('admin.members.create')).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('empty-state'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'No members found','description' => 'No membership records match your current filters. Adjust the filters or create a new membership to get started.','action_label' => 'Create Membership','action_href' => ''.e(route('admin.members.create')).'']); ?>
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
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc8c9fd5d7827a77a31381de67195f0c3)): ?>
<?php $attributes = $__attributesOriginalc8c9fd5d7827a77a31381de67195f0c3; ?>
<?php unset($__attributesOriginalc8c9fd5d7827a77a31381de67195f0c3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc8c9fd5d7827a77a31381de67195f0c3)): ?>
<?php $component = $__componentOriginalc8c9fd5d7827a77a31381de67195f0c3; ?>
<?php unset($__componentOriginalc8c9fd5d7827a77a31381de67195f0c3); ?>
<?php endif; ?><?php /**PATH C:\xampp\htdocs\ProDo\EDAA\resources\views\admin\leaderboard\index.blade.php ENDPATH**/ ?>