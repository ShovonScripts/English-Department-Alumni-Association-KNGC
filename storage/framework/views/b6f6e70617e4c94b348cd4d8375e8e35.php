<?php if (isset($component)) { $__componentOriginalc8c9fd5d7827a77a31381de67195f0c3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc8c9fd5d7827a77a31381de67195f0c3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.admin','data' => ['title' => 'Member Details']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.admin'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Member Details']); ?>
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="font-serif text-3xl font-semibold tracking-tight text-navy-950">Membership <?php echo e($membership->membership_number); ?></h1>
            <p class="mt-1 text-sm text-ink-soft">Detailed record for this registered member.</p>
        </div>
        <a href="<?php echo e(route('admin.members.index')); ?>" class="focus-ring inline-flex items-center gap-2 rounded-md px-3.5 py-2 text-sm font-semibold text-navy-800 transition-colors hover:bg-navy-50">
            &larr; Back to Members
        </a>
    </div>

    <?php if(session('status')): ?>
        <div class="mb-6 flex items-center gap-3 rounded-md border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800" role="status">
            <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <?php echo e(session('status')); ?>

        </div>
    <?php endif; ?>

    <div class="grid gap-8 lg:grid-cols-3">
        
        <div>
            <section class="rounded-lg border border-navy-100 bg-white p-8 shadow-sm">
                <div class="flex flex-col items-center text-center">
                    <?php if($membership->alumni?->profile_photo_url): ?>
                        <img src="<?php echo e($membership->alumni->profile_photo_url); ?>" alt="" class="h-24 w-24 rounded-full object-cover ring-4 ring-gold-500/30">
                    <?php else: ?>
                        <span class="flex h-24 w-24 items-center justify-center rounded-full bg-navy-900 font-serif text-2xl font-semibold text-gold-300 ring-4 ring-gold-500/30" aria-hidden="true">
                            <?php echo e(\Illuminate\Support\Str::initials($membership->alumni?->full_name ?? '')); ?>

                        </span>
                    <?php endif; ?>

                    <h2 class="mt-5 font-serif text-xl font-semibold text-navy-950"><?php echo e($membership->alumni?->full_name ?? 'Unknown alumni'); ?></h2>

                    <?php if($membership->alumni?->student_id): ?>
                        <p class="mt-1 font-mono text-xs text-ink-soft"><?php echo e($membership->alumni->student_id); ?></p>
                    <?php endif; ?>

                    <p class="mt-1 text-sm text-ink-soft"><?php echo e($membership->alumni?->profession ?? '—'); ?></p>
                    <p class="text-xs text-ink-soft">
                        Batch <?php echo e($membership->alumni?->batch ?? '—'); ?><?php if($membership->alumni?->graduation_year): ?> · Class of <?php echo e($membership->alumni->graduation_year); ?><?php endif; ?>
                    </p>
                    <?php if($membership->alumni?->location): ?>
                        <p class="mt-1 text-xs text-ink-soft"><?php echo e($membership->alumni->location); ?></p>
                    <?php endif; ?>
                </div>

                <dl class="mt-6 space-y-3 border-t border-navy-100 pt-6 text-sm">
                    <div class="flex justify-between gap-4">
                        <dt class="font-medium text-ink-soft">Alumni profile</dt>
                        <dd><a href="<?php echo e(route('admin.alumni.show', $membership->alumni)); ?>" class="focus-ring rounded font-semibold text-maroon-700 transition-colors hover:text-maroon-900">View record</a></dd>
                    </div>
                    <div class="flex justify-between gap-4">
                        <dt class="font-medium text-ink-soft">Public page</dt>
                        <dd><a href="<?php echo e(route('alumni.show', $membership->alumni)); ?>" target="_blank" rel="noopener noreferrer" class="focus-ring rounded font-semibold text-maroon-700 transition-colors hover:text-maroon-900">Open</a></dd>
                    </div>
                </dl>
            </section>
        </div>

        
        <div class="lg:col-span-2">
            <section class="rounded-lg border border-navy-100 bg-white p-8 shadow-sm sm:p-10">
                <div class="flex flex-wrap items-start justify-between gap-4">
                    <div>
                        <h2 class="font-serif text-xl font-semibold text-navy-950">Membership Record</h2>
                        <p class="mt-1 font-mono text-sm font-semibold text-maroon-700"><?php echo e($membership->membership_number); ?></p>
                    </div>
                    <?php if (isset($component)) { $__componentOriginalb341886620c268b94677189315a84e7d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb341886620c268b94677189315a84e7d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.membership-badge','data' => ['type' => $membership->type,'tier' => $membership->tier]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('membership-badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($membership->type),'tier' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($membership->tier)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb341886620c268b94677189315a84e7d)): ?>
<?php $attributes = $__attributesOriginalb341886620c268b94677189315a84e7d; ?>
<?php unset($__attributesOriginalb341886620c268b94677189315a84e7d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb341886620c268b94677189315a84e7d)): ?>
<?php $component = $__componentOriginalb341886620c268b94677189315a84e7d; ?>
<?php unset($__componentOriginalb341886620c268b94677189315a84e7d); ?>
<?php endif; ?>
                </div>

                <dl class="mt-8 grid gap-x-8 gap-y-6 sm:grid-cols-2">
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Membership Type</dt>
                        <dd class="mt-1 text-sm text-navy-950"><?php echo e($membership->type?->name ?? '—'); ?></dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Membership Tier</dt>
                        <dd class="mt-1 text-sm text-navy-950"><?php echo e($membership->tier?->badge_label ? $membership->tier->badge_label.' — '.$membership->tier->name : 'Not assigned'); ?></dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Verified Contributions</dt>
                        <dd class="mt-1 text-sm font-semibold text-navy-950">৳<?php echo e(number_format($membership->verifiedContributionTotal())); ?></dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Status</dt>
                        <dd class="mt-1">
                            <?php
                                $statusStyles = [
                                    'active' => ['bg-emerald-100', 'text-emerald-800', 'bg-emerald-500'],
                                    'pending' => ['bg-gold-500/20', 'text-gold-700', 'bg-gold-500'],
                                    'suspended' => ['bg-maroon-100', 'text-maroon-800', 'bg-maroon-600'],
                                    'cancelled' => ['bg-navy-100', 'text-navy-600', 'bg-navy-400'],
                                    'expired' => ['bg-navy-100', 'text-navy-600', 'bg-navy-400'],
                                ];
                                [$bg, $text, $dot] = $statusStyles[$membership->status] ?? ['bg-navy-100', 'text-navy-600', 'bg-navy-400'];
                            ?>
                            <span class="inline-flex items-center gap-1.5 rounded-full <?php echo e($bg); ?> px-2.5 py-1 text-xs font-semibold <?php echo e($text); ?>">
                                <span class="h-1.5 w-1.5 rounded-full <?php echo e($dot); ?>" aria-hidden="true"></span>
                                <?php echo e(ucfirst($membership->status)); ?>

                            </span>
                        </dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Visibility</dt>
                        <dd class="mt-1 text-sm text-navy-950"><?php echo e($membership->is_public ? 'Public — shown on the alumni profile' : 'Private — admin only'); ?></dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Leaderboard</dt>
                        <dd class="mt-1 text-sm text-navy-950">
                            <span class="font-semibold <?php echo e($membership->show_on_leaderboard ? 'text-emerald-700' : 'text-maroon-700'); ?>">
                                <?php echo e($membership->show_on_leaderboard ? 'Visible' : 'Hidden'); ?>

                            </span>
                            <?php if($membership->verifiedContributionTotal() > 0): ?>
                                — Verified contribution ৳<?php echo e(number_format($membership->verifiedContributionTotal())); ?>

                            <?php endif; ?>
                        </dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Joined Date</dt>
                        <dd class="mt-1 text-sm text-navy-950"><?php echo e($membership->joined_at?->format('M j, Y') ?? '—'); ?></dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Approved Date</dt>
                        <dd class="mt-1 text-sm text-navy-950"><?php echo e($membership->approved_at?->format('M j, Y') ?? '—'); ?></dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Admin Notes</dt>
                        <dd class="mt-1 text-sm leading-relaxed text-navy-950"><?php echo e($membership->notes ?: 'No notes recorded.'); ?></dd>
                    </div>
                </dl>

                <div class="mt-10 flex flex-wrap items-center gap-3 border-t border-navy-100 pt-8">
                    <?php if (isset($component)) { $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.button','data' => ['href' => ''.e(route('admin.members.edit', $membership)).'','variant' => 'navy']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => ''.e(route('admin.members.edit', $membership)).'','variant' => 'navy']); ?>Edit Membership <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561)): ?>
<?php $attributes = $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561; ?>
<?php unset($__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald0f1fd2689e4bb7060122a5b91fe8561)): ?>
<?php $component = $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561; ?>
<?php unset($__componentOriginald0f1fd2689e4bb7060122a5b91fe8561); ?>
<?php endif; ?>

                    <form method="POST" action="<?php echo e(route('admin.members.recalculate-tier', $membership)); ?>">
                        <?php echo csrf_field(); ?>
                        <?php if (isset($component)) { $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.button','data' => ['type' => 'submit','variant' => 'outline']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'submit','variant' => 'outline']); ?>Recalculate Tier <?php echo $__env->renderComponent(); ?>
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

                    <form method="POST" action="<?php echo e(route('admin.members.public-toggle', $membership)); ?>">
                        <?php echo csrf_field(); ?>
                        <?php if (isset($component)) { $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.button','data' => ['type' => 'submit','variant' => ''.e($membership->is_public ? 'outline' : 'gold').'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'submit','variant' => ''.e($membership->is_public ? 'outline' : 'gold').'']); ?>
                            <?php echo e($membership->is_public ? 'Hide Publicly' : 'Show Publicly'); ?>

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

                    <?php if($membership->status === \App\Models\Membership::STATUS_ACTIVE): ?>
                        <form method="POST" action="<?php echo e(route('admin.members.suspend', $membership)); ?>">
                            <?php echo csrf_field(); ?>
                            <?php if (isset($component)) { $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.button','data' => ['type' => 'submit','variant' => 'outline']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'submit','variant' => 'outline']); ?>Suspend <?php echo $__env->renderComponent(); ?>
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
                    <?php else: ?>
                        <form method="POST" action="<?php echo e(route('admin.members.activate', $membership)); ?>">
                            <?php echo csrf_field(); ?>
                            <?php if (isset($component)) { $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.button','data' => ['type' => 'submit','variant' => 'gold']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'submit','variant' => 'gold']); ?>Activate <?php echo $__env->renderComponent(); ?>
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
                    <?php endif; ?>

                    <form method="POST" action="<?php echo e(route('admin.members.destroy', $membership)); ?>" onsubmit="return confirm('Delete membership <?php echo e($membership->membership_number); ?>? This cannot be undone.');">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="focus-ring inline-flex items-center rounded-md px-3.5 py-2 text-sm font-semibold text-maroon-600 transition-colors hover:bg-maroon-50">
                            Delete
                        </button>
                    </form>
                </div>
            </section>

            
            <section class="mt-8 rounded-lg border border-navy-100 bg-white p-8 shadow-sm sm:p-10">
                <div class="flex flex-wrap items-start justify-between gap-4">
                    <div>
                        <h2 class="font-serif text-xl font-semibold text-navy-950">Member Portal Account</h2>
                        <p class="mt-1 text-sm text-ink-soft">Linked user account for the member portal.</p>
                    </div>
                </div>

                <dl class="mt-6 grid gap-x-8 gap-y-6 sm:grid-cols-2">
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Account Status</dt>
                        <dd class="mt-1">
                            <?php if($membership->alumni?->user): ?>
                                <span class="inline-flex items-center gap-1.5 rounded-full <?php echo e($membership->alumni->user->isDisabled() ? 'bg-red-100 text-red-800' : 'bg-emerald-100 text-emerald-800'); ?> px-2.5 py-1 text-xs font-semibold">
                                    <span class="h-1.5 w-1.5 rounded-full <?php echo e($membership->alumni->user->isDisabled() ? 'bg-red-500' : 'bg-emerald-500'); ?>" aria-hidden="true"></span>
                                    <?php echo e($membership->alumni->user->isDisabled() ? 'Disabled' : 'Active'); ?>

                                </span>
                            <?php else: ?>
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-navy-100 px-2.5 py-1 text-xs font-semibold text-navy-600">
                                    <span class="h-1.5 w-1.5 rounded-full bg-navy-400" aria-hidden="true"></span>
                                    No Account
                                </span>
                            <?php endif; ?>
                        </dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Verification Status</dt>
                        <dd class="mt-1">
                            <?php if($membership->alumni?->user): ?>
                                <span class="inline-flex items-center gap-1.5 rounded-full <?php echo e($membership->alumni->user->isVerified() ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800'); ?> px-2.5 py-1 text-xs font-semibold">
                                    <span class="h-1.5 w-1.5 rounded-full <?php echo e($membership->alumni->user->isVerified() ? 'bg-emerald-500' : 'bg-amber-500'); ?>" aria-hidden="true"></span>
                                    <?php echo e($membership->alumni->user->isVerified() ? 'Verified' : 'Unverified'); ?>

                                </span>
                            <?php else: ?>
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-navy-100 px-2.5 py-1 text-xs font-semibold text-navy-600">
                                    <span class="h-1.5 w-1.5 rounded-full bg-navy-400" aria-hidden="true"></span>
                                    N/A
                                </span>
                            <?php endif; ?>
                        </dd>
                    </div>
                    <?php if($membership->alumni?->user): ?>
                        <div>
                            <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Email</dt>
                            <dd class="mt-1 text-sm text-navy-950"><?php echo e($membership->alumni->user->email); ?></dd>
                        </div>
                        <div>
                            <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Registered</dt>
                            <dd class="mt-1 text-sm text-navy-950"><?php echo e($membership->alumni->user->created_at->format('M j, Y')); ?></dd>
                        </div>
                        <div>
                            <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Verified At</dt>
                            <dd class="mt-1 text-sm text-navy-950"><?php echo e($membership->alumni->user->verified_at?->format('M j, Y') ?? '—'); ?></dd>
                        </div>
                    <?php endif; ?>
                </dl>

                <?php if($membership->alumni?->user): ?>
                    <div class="mt-10 flex flex-wrap items-center gap-3 border-t border-navy-100 pt-8">
                        <?php if($membership->alumni->user->isVerified()): ?>
                            <form method="POST" action="<?php echo e(route('admin.members.unverify', $membership)); ?>" onsubmit="return confirm('Revoke verification for this account? This will restrict their access.');">
                                <?php echo csrf_field(); ?>
                                <?php if (isset($component)) { $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.button','data' => ['type' => 'submit','variant' => 'outline']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'submit','variant' => 'outline']); ?>Revoke Verification <?php echo $__env->renderComponent(); ?>
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
                        <?php else: ?>
                            <form method="POST" action="<?php echo e(route('admin.members.verify', $membership)); ?>">
                                <?php echo csrf_field(); ?>
                                <?php if (isset($component)) { $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.button','data' => ['type' => 'submit','variant' => 'gold']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'submit','variant' => 'gold']); ?>Verify Account <?php echo $__env->renderComponent(); ?>
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
                        <?php endif; ?>

                        <?php if($membership->alumni->user->isDisabled()): ?>
                            <form method="POST" action="<?php echo e(route('admin.members.enable', $membership)); ?>">
                                <?php echo csrf_field(); ?>
                                <?php if (isset($component)) { $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.button','data' => ['type' => 'submit','variant' => 'navy']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'submit','variant' => 'navy']); ?>Enable Account <?php echo $__env->renderComponent(); ?>
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
                        <?php else: ?>
                            <form method="POST" action="<?php echo e(route('admin.members.disable', $membership)); ?>" onsubmit="return confirm('Disable this account? They will be immediately logged out and unable to log in.');">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="focus-ring inline-flex items-center rounded-md px-3.5 py-2 text-sm font-semibold text-maroon-600 transition-colors hover:bg-maroon-50">
                                    Disable Account
                                </button>
                            </form>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </section>

            
            <section class="mt-8 rounded-lg border border-navy-100 bg-white p-8 shadow-sm sm:p-10">
                <div class="flex flex-wrap items-start justify-between gap-4">
                    <div>
                        <h2 class="font-serif text-xl font-semibold text-navy-950">Fee & Payment Summary</h2>
                        <p class="mt-1 text-sm text-ink-soft">Manual collections recorded for this member.</p>
                    </div>
                    <?php if (isset($component)) { $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.button','data' => ['href' => ''.e(route('admin.payments.create', ['membership_id' => $membership->id])).'','variant' => 'gold','size' => 'sm']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => ''.e(route('admin.payments.create', ['membership_id' => $membership->id])).'','variant' => 'gold','size' => 'sm']); ?>Record Payment <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561)): ?>
<?php $attributes = $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561; ?>
<?php unset($__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald0f1fd2689e4bb7060122a5b91fe8561)): ?>
<?php $component = $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561; ?>
<?php unset($__componentOriginald0f1fd2689e4bb7060122a5b91fe8561); ?>
<?php endif; ?>
                </div>

                <?php if($summary && !$summary['waived']): ?>
                    <dl class="mt-6 grid gap-x-8 gap-y-6 sm:grid-cols-3">
                        <div>
                            <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Expected (Current Fee)</dt>
                            <dd class="mt-1 font-serif text-2xl font-semibold text-navy-950">৳<?php echo e(number_format($summary['expected'])); ?></dd>
                        </div>
                        <div>
                            <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Total Collected</dt>
                            <dd class="mt-1 font-serif text-2xl font-semibold text-emerald-700">৳<?php echo e(number_format($summary['collected'])); ?></dd>
                        </div>
                        <div>
                            <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Outstanding</dt>
                            <dd class="mt-1 font-serif text-2xl font-semibold <?php echo e($summary['outstanding'] > 0 ? 'text-maroon-700' : 'text-navy-950'); ?>">৳<?php echo e(number_format($summary['outstanding'])); ?></dd>
                        </div>
                    </dl>
                    <?php if($summary['overpaid'] > 0): ?>
                        <p class="mt-4 rounded-md bg-gold-500/10 px-4 py-2.5 text-sm font-medium text-gold-700">
                            Overpaid by ৳<?php echo e(number_format($summary['overpaid'])); ?> against the current fee. No refund has been created.
                        </p>
                    <?php endif; ?>
                <?php elseif($summary?->waived): ?>
                    <p class="mt-6 rounded-md bg-navy-50 px-4 py-3 text-sm text-navy-700">
                        This obligation has been waived by the association — nothing is outstanding and no cash was collected.
                    </p>
                <?php else: ?>
                    <p class="mt-6 rounded-md bg-navy-50 px-4 py-3 text-sm text-navy-700">
                        No active fee plan applies to this membership type, so there is no outstanding obligation.
                    </p>
                <?php endif; ?>

                <?php if($recentPayments->isNotEmpty()): ?>
                    <h3 class="mt-8 text-xs font-bold uppercase tracking-wider text-ink-soft">Recent Payments</h3>
                    <ul class="mt-3 divide-y divide-navy-100 rounded-md border border-navy-100">
                        <?php $__currentLoopData = $recentPayments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="flex flex-wrap items-center justify-between gap-3 px-4 py-3 text-sm">
                                <span class="font-mono text-xs font-semibold text-navy-900"><?php echo e($payment->payment_number); ?></span>
                                <span class="font-semibold text-navy-950"><?php echo e($payment->formattedAmount()); ?></span>
                                <?php
                                    $styles = [
                                        'paid' => ['bg-emerald-100', 'text-emerald-800'],
                                        'partial' => ['bg-gold-500/20', 'text-gold-700'],
                                        'waived' => ['bg-navy-100', 'text-navy-600'],
                                        'void' => ['bg-maroon-100', 'text-maroon-800'],
                                    ];
                                    [$bg, $text] = $styles[$payment->status->value] ?? ['bg-navy-100', 'text-navy-600'];
                                ?>
                                <span class="inline-flex rounded-full <?php echo e($bg); ?> px-2 py-0.5 text-[11px] font-bold uppercase tracking-wide <?php echo e($text); ?>"><?php echo e($payment->status->label()); ?></span>
                                <span class="text-ink-soft"><?php echo e($payment->paid_at?->format('M j, Y')); ?></span>
                                <?php if($payment->reference): ?>
                                    <span class="hidden text-xs text-ink-soft sm:inline"><?php echo e($payment->reference); ?></span>
                                <?php endif; ?>
                                <a href="<?php echo e(route('admin.payments.show', $payment)); ?>" class="focus-ring rounded font-medium text-maroon-700 hover:text-maroon-900">View</a>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                    <a href="<?php echo e(route('admin.payments.index', ['membership_id' => $membership->id])); ?>" class="focus-ring mt-4 inline-flex items-center gap-2 rounded-md text-sm font-semibold text-maroon-700 hover:text-maroon-900">
                        View Payment History →
                    </a>
                <?php else: ?>
                    <p class="mt-6 text-sm text-ink-soft">No payments have been recorded for this membership yet.</p>
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
<?php /**PATH C:\xampp\htdocs\ProDo\EDAA\resources\views/admin/members/show.blade.php ENDPATH**/ ?>