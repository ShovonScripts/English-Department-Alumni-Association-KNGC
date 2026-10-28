<?php if (isset($component)) { $__componentOriginalc8c9fd5d7827a77a31381de67195f0c3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc8c9fd5d7827a77a31381de67195f0c3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.admin','data' => ['title' => ''.e($committee->name).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.admin'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => ''.e($committee->name).'']); ?>
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="font-serif text-3xl font-semibold tracking-tight text-navy-950"><?php echo e($committee->name); ?></h1>
            <p class="mt-1 text-sm text-ink-soft"><?php echo e($committee->type?->name); ?> &middot; <?php echo e($committee->yearRange()); ?></p>
        </div>
        <a href="<?php echo e(route('admin.committees.index')); ?>" class="focus-ring inline-flex items-center gap-2 rounded-md px-3.5 py-2 text-sm font-semibold text-navy-800 transition-colors hover:bg-navy-50">&larr; Back to Committees</a>
    </div>

    <?php if(session('status')): ?>
        <div class="mb-6 flex items-center gap-3 rounded-md border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800" role="status">
            <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            <?php echo e(session('status')); ?>

        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="mb-6 flex items-center gap-3 rounded-md border border-maroon-200 bg-maroon-50 px-4 py-3 text-sm text-maroon-800" role="alert">
            <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v4m0 4h.01M10.3 3.9L1.8 18a2 2 0 001.7 3h17a2 2 0 001.7-3L13.7 3.9a2 2 0 00-3.4 0z" /></svg>
            <?php echo e(session('error')); ?>

        </div>
    <?php endif; ?>

    <div class="grid gap-8 lg:grid-cols-3">
        
        <div>
            <section class="rounded-lg border border-navy-100 bg-white p-8 text-center shadow-sm">
                <div class="flex h-16 w-16 mx-auto items-center justify-center rounded-2xl bg-navy-900 font-serif text-xl font-bold text-gold-300 shadow-md">
                    <?php echo e(strtoupper(substr($committee->type?->slug ?? 'CO', 0, 2))); ?>

                </div>
                <h2 class="mt-4 font-serif text-xl font-semibold text-navy-950"><?php echo e($committee->name); ?></h2>
                <p class="mt-1 text-sm text-ink-soft"><?php echo e($committee->yearRange()); ?></p>
                <div class="mt-4 flex flex-wrap items-center justify-center gap-1.5">
                    <?php if($committee->is_current): ?>
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-gold-500/15 px-2.5 py-1 text-[10px] font-semibold uppercase tracking-widest text-gold-700"><span class="h-1.5 w-1.5 rounded-full bg-gold-500"></span> Current</span>
                    <?php else: ?>
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-navy-100 px-2.5 py-1 text-[10px] font-semibold uppercase tracking-widest text-navy-500">Past</span>
                    <?php endif; ?>
                    <span class="inline-flex items-center gap-1.5 rounded-full bg-navy-100 px-2.5 py-1 text-[10px] font-semibold uppercase tracking-widest text-navy-500"><?php echo e($members->count()); ?> <?php echo e(Str::plural('member', $members->count())); ?></span>
                </div>
                <?php if($committee->description): ?>
                    <p class="mt-4 text-sm text-ink-soft"><?php echo e($committee->description); ?></p>
                <?php endif; ?>
                <div class="mt-6 flex flex-col gap-2">
                    <?php if(! $committee->is_current): ?>
                        <form method="POST" action="<?php echo e(route('admin.committees.make-current', $committee)); ?>">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="focus-ring w-full inline-flex items-center justify-center gap-2 rounded-lg bg-gold-500 px-4 py-2.5 text-sm font-semibold text-navy-950 shadow-sm transition-colors hover:bg-gold-400">Mark as Current</button>
                        </form>
                    <?php endif; ?>
                    <a href="<?php echo e(route('admin.committees.edit', $committee)); ?>" class="focus-ring inline-flex items-center justify-center gap-2 rounded-lg border border-navy-300 px-4 py-2.5 text-sm font-semibold text-navy-900 transition-colors hover:bg-navy-50">Edit Committee</a>
                    <form method="POST" action="<?php echo e(route('admin.committees.destroy', $committee)); ?>" onsubmit="return confirm('Delete this committee? Members will be removed.');">
                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="focus-ring w-full inline-flex items-center justify-center gap-2 rounded-lg px-4 py-2.5 text-sm font-semibold text-maroon-600 transition-colors hover:bg-maroon-50">Delete</button>
                    </form>
                </div>
            </section>

            
            <section class="mt-6 rounded-lg border border-navy-100 bg-white p-6 shadow-sm">
                <h3 class="font-serif text-lg font-semibold text-navy-950">Add Member</h3>
                <form method="POST" action="<?php echo e(route('admin.committees.add-member', $committee)); ?>" class="mt-4 space-y-4">
                    <?php echo csrf_field(); ?>
                    <div>
                        <label for="membership_id" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Member *</label>
                        <select id="membership_id" name="membership_id" required class="w-full rounded-md border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none">
                            <option value="">Select member...</option>
                            <?php
                                $existingIds = $members->pluck('id')->toArray();
                                $availableMembers = \App\Models\Membership::query()->where('status', 'active')->with('alumni')->whereNotIn('id', $existingIds)->orderBy('membership_number')->get();
                            ?>
                            <?php $__currentLoopData = $availableMembers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($m->id); ?>"><?php echo e($m->alumni?->full_name ?? $m->membership_number); ?> (<?php echo e($m->membership_number); ?>)</option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div>
                        <label for="committee_role_id" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Position *</label>
                        <select id="committee_role_id" name="committee_role_id" required class="w-full rounded-md border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none">
                            <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($role->id); ?>"><?php echo e($role->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <button type="submit" class="focus-ring w-full inline-flex items-center justify-center gap-2 rounded-lg bg-gold-500 px-5 py-2.5 text-sm font-semibold text-navy-950 shadow-sm transition-colors hover:bg-gold-400">Add to Committee</button>
                </form>
            </section>
        </div>

        
        <div class="lg:col-span-2">
            <section class="rounded-lg border border-navy-100 bg-white shadow-sm">
                <div class="border-b border-navy-100 px-6 py-4">
                    <h3 class="font-serif text-lg font-semibold text-navy-950">Committee Members</h3>
                </div>

                <?php if($members->isEmpty()): ?>
                    <div class="px-6 py-12 text-center text-sm text-ink-soft">No members assigned yet. Add members using the form.</div>
                <?php else: ?>
                    
                    <?php $__currentLoopData = $groupedMembers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $groupId => $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="<?php echo e(!$loop->first ? 'border-t border-navy-100' : ''); ?>">
                            <div class="bg-navy-50/50 px-6 py-3">
                                <h4 class="text-sm font-semibold uppercase tracking-wider text-navy-700"><?php echo e($group['role']->name); ?></h4>
                            </div>
                            <ul class="divide-y divide-navy-100">
                                <?php $__currentLoopData = $group['members']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li class="flex items-center justify-between gap-4 px-6 py-4 hover:bg-cream/50 transition-colors">
                                        <div class="flex items-center gap-4">
                                            <?php if($member->alumni?->profile_photo_url): ?>
                                                <img src="<?php echo e($member->alumni->profile_photo_url); ?>" alt="" class="h-10 w-10 rounded-full object-cover ring-2 ring-gold-500/30">
                                            <?php else: ?>
                                                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-navy-900 font-serif text-xs font-bold text-gold-300"><?php echo e(\Illuminate\Support\Str::initials($member->alumni?->full_name ?? '')); ?></span>
                                            <?php endif; ?>
                                            <div>
                                                <p class="font-semibold text-navy-950"><?php echo e($member->alumni?->full_name ?? 'Unknown'); ?></p>
                                                <p class="text-xs text-ink-soft"><?php echo e($member->membership_number); ?></p>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            
                                            <form method="POST" action="<?php echo e(route('admin.committees.update-member-role', ['committee' => $committee, 'membership' => $member->id])); ?>" class="inline-flex">
                                                <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                                                <select name="committee_role_id" onchange="this.form.submit()" class="rounded-md border border-navy-200 bg-white px-2 py-1 text-xs text-navy-950 focus:border-gold-500 focus:ring-1 focus:ring-gold-500/30 focus:outline-none">
                                                    <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($role->id); ?>" <?php if($role->id === $member->pivot_committee_role_id): echo 'selected'; endif; ?>><?php echo e($role->name); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </form>
                                            
                                            <form method="POST" action="<?php echo e(route('admin.committees.remove-member', ['committee' => $committee, 'membership' => $member->id])); ?>" onsubmit="return confirm('Remove <?php echo e($member->alumni?->full_name); ?> from this committee?');">
                                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="focus-ring inline-flex h-8 w-8 items-center justify-center rounded-md text-maroon-600 transition-colors hover:bg-maroon-50 hover:text-maroon-800" title="Remove">
                                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    
                    <?php if($unassignedMembers->isNotEmpty()): ?>
                        <div class="border-t border-navy-100">
                            <div class="bg-maroon-50/50 px-6 py-3">
                                <h4 class="text-sm font-semibold uppercase tracking-wider text-maroon-700">Unassigned</h4>
                            </div>
                            <ul class="divide-y divide-navy-100">
                                <?php $__currentLoopData = $unassignedMembers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li class="flex items-center justify-between gap-4 px-6 py-4 hover:bg-cream/50 transition-colors">
                                        <div class="flex items-center gap-4">
                                            <?php if($member->alumni?->profile_photo_url): ?>
                                                <img src="<?php echo e($member->alumni->profile_photo_url); ?>" alt="" class="h-10 w-10 rounded-full object-cover ring-2 ring-gold-500/30">
                                            <?php else: ?>
                                                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-navy-900 font-serif text-xs font-bold text-gold-300"><?php echo e(\Illuminate\Support\Str::initials($member->alumni?->full_name ?? '')); ?></span>
                                            <?php endif; ?>
                                            <div>
                                                <p class="font-semibold text-navy-950"><?php echo e($member->alumni?->full_name ?? 'Unknown'); ?></p>
                                                <p class="text-xs text-ink-soft"><?php echo e($member->membership_number); ?></p>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <form method="POST" action="<?php echo e(route('admin.committees.update-member-role', ['committee' => $committee, 'membership' => $member->id])); ?>" class="inline-flex">
                                                <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                                                <select name="committee_role_id" onchange="this.form.submit()" class="rounded-md border border-navy-200 bg-white px-2 py-1 text-xs text-navy-950 focus:border-gold-500 focus:ring-1 focus:ring-gold-500/30 focus:outline-none">
                                                    <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($role->id); ?>" <?php if($role->id === $member->pivot_committee_role_id): echo 'selected'; endif; ?>><?php echo e($role->name); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </form>
                                            <form method="POST" action="<?php echo e(route('admin.committees.remove-member', ['committee' => $committee, 'membership' => $member->id])); ?>" onsubmit="return confirm('Remove <?php echo e($member->alumni?->full_name); ?> from this committee?');">
                                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="focus-ring inline-flex h-8 w-8 items-center justify-center rounded-md text-maroon-600 transition-colors hover:bg-maroon-50 hover:text-maroon-800" title="Remove">
                                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    <?php endif; ?>
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
<?php /**PATH C:\xampp\htdocs\ProDo\EDAA\resources\views/admin/committees/show.blade.php ENDPATH**/ ?>