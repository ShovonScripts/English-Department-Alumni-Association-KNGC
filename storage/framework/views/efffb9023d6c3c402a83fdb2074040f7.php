<?php if (isset($component)) { $__componentOriginalc8c9fd5d7827a77a31381de67195f0c3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc8c9fd5d7827a77a31381de67195f0c3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.admin','data' => ['title' => 'Application '.e($application->application_number).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.admin'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Application '.e($application->application_number).'']); ?>
    <div class="mb-8 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <div class="flex items-center gap-3">
                <a href="<?php echo e(route('admin.membership-applications.index')); ?>" class="focus-ring inline-flex items-center gap-1 rounded-md text-sm font-semibold text-navy-600 transition-colors hover:text-navy-900">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                    Applications
                </a>
            </div>
            <h1 class="mt-2 font-serif text-3xl font-semibold tracking-tight text-navy-950"><?php echo e($application->application_number); ?></h1>
        </div>
    </div>

    <?php if(session('success')): ?>
        <div class="mb-6 flex items-start gap-3 rounded-lg border border-green-200 bg-green-50 p-5 text-green-800" role="status">
            <svg class="mt-0.5 h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <p class="text-sm"><?php echo e(session('success')); ?></p>
        </div>
    <?php endif; ?>

    <?php if($errors->any()): ?>
        <div class="mb-6 rounded-lg border border-maroon-200 bg-maroon-50 p-5 text-maroon-800" role="alert">
            <p class="font-semibold">Error</p>
            <ul class="mt-2 list-inside list-disc text-sm space-y-1">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="grid gap-6 lg:grid-cols-3">
        
        <div class="lg:col-span-2 space-y-6">
            
            <div class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm">
                <h2 class="font-serif text-xl font-semibold text-navy-950">Applicant Information</h2>
                <div class="mt-4 grid gap-4 sm:grid-cols-2">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Full Name</p>
                        <p class="mt-1 text-sm font-medium text-navy-950"><?php echo e($application->full_name); ?></p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Email</p>
                        <p class="mt-1 text-sm font-medium text-navy-950"><?php echo e($application->email); ?></p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Phone</p>
                        <p class="mt-1 text-sm font-medium text-navy-950"><?php echo e($application->phone); ?></p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Date of Birth</p>
                        <p class="mt-1 text-sm font-medium text-navy-950"><?php echo e($application->date_of_birth?->format('d M Y') ?? '—'); ?></p>
                    </div>
                    <div class="sm:col-span-2">
                        <p class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Address</p>
                        <p class="mt-1 text-sm font-medium text-navy-950">
                            <?php echo e(collect([$application->address, $application->city])->filter()->implode(', ') ?: '—'); ?>

                        </p>
                    </div>
                </div>
            </div>

            
            <div class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm">
                <h2 class="font-serif text-xl font-semibold text-navy-950">Academic Information</h2>
                <div class="mt-4 grid gap-4 sm:grid-cols-3">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Student ID</p>
                        <p class="mt-1 text-sm font-medium text-navy-950"><?php echo e($application->student_id ?? '—'); ?></p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Batch</p>
                        <p class="mt-1 text-sm font-medium text-navy-950"><?php echo e($application->batch ?? '—'); ?></p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Graduation Year</p>
                        <p class="mt-1 text-sm font-medium text-navy-950"><?php echo e($application->graduation_year ?? '—'); ?></p>
                    </div>
                </div>
            </div>

            
            <div class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm">
                <h2 class="font-serif text-xl font-semibold text-navy-950">Professional Information</h2>
                <div class="mt-4 grid gap-4 sm:grid-cols-3">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Profession</p>
                        <p class="mt-1 text-sm font-medium text-navy-950"><?php echo e($application->profession ?? '—'); ?></p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Organization</p>
                        <p class="mt-1 text-sm font-medium text-navy-950"><?php echo e($application->current_organization ?? '—'); ?></p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Designation</p>
                        <p class="mt-1 text-sm font-medium text-navy-950"><?php echo e($application->current_designation ?? '—'); ?></p>
                    </div>
                </div>
            </div>

            
            <?php if($application->alumni_document_path): ?>
                <div class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm">
                    <h2 class="font-serif text-xl font-semibold text-navy-950">Alumni Proof Document</h2>
                    <div class="mt-4">
                        <div class="flex items-center gap-4 rounded-lg bg-navy-50 p-4">
                            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-lg bg-maroon-100">
                                <svg class="h-6 w-6 text-maroon-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                </svg>
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="truncate text-sm font-medium text-navy-950"><?php echo e($application->alumni_document_original_name); ?></p>
                                <p class="text-xs text-ink-soft">
                                    <?php echo e(strtoupper(pathinfo($application->alumni_document_original_name, PATHINFO_EXTENSION))); ?>

                                    · <?php echo e(round($application->alumni_document_size / 1024)); ?> KB
                                </p>
                            </div>
                            <a
                                href="<?php echo e(\App\Support\UrlHelper::safeHref(Storage::disk('public')->url($application->alumni_document_path))); ?>"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="focus-ring inline-flex items-center gap-1.5 rounded-md bg-maroon-700 px-3 py-2 text-xs font-semibold text-white transition-colors hover:bg-maroon-600"
                            >
                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                </svg>
                                View
                            </a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            
            <div class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm">
                <h2 class="font-serif text-xl font-semibold text-navy-950">Membership Request</h2>
                <div class="mt-4 grid gap-4 sm:grid-cols-2">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Membership Type</p>
                        <p class="mt-1 text-sm font-medium text-navy-950"><?php echo e($application->membershipType->name ?? '—'); ?></p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Requested Tier</p>
                        <p class="mt-1 text-sm font-medium text-navy-950"><?php echo e($application->requestedTier->name ?? '—'); ?></p>
                    </div>
                    <?php if($application->application_message): ?>
                        <div class="sm:col-span-2">
                            <p class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Application Message</p>
                            <p class="mt-1 text-sm leading-relaxed text-navy-950"><?php echo e($application->application_message); ?></p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        
        <div class="space-y-6">
            
            <div class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm">
                <h2 class="font-serif text-xl font-semibold text-navy-950">Status</h2>
                <?php
                    $statusColor = match($application->status->value) {
                        'pending' => 'bg-gold-100 text-gold-800 border-gold-300',
                        'under_review' => 'bg-navy-100 text-navy-800 border-navy-300',
                        'approved' => 'bg-emerald-100 text-emerald-800 border-emerald-300',
                        'rejected' => 'bg-maroon-100 text-maroon-800 border-maroon-300',
                        'changes_requested' => 'bg-amber-100 text-amber-800 border-amber-300',
                        'cancelled' => 'bg-navy-100 text-navy-800 border-navy-300',
                        default => 'bg-navy-100 text-navy-800 border-navy-300',
                    };
                ?>
                <div class="mt-4 flex justify-center">
                    <span class="inline-flex items-center gap-2 rounded-full border px-4 py-2 text-sm font-semibold <?php echo e($statusColor); ?>">
                        <?php echo e($application->status->label()); ?>

                    </span>
                </div>

                <div class="mt-6 space-y-3 text-sm">
                    <div class="flex items-center justify-between">
                        <span class="text-ink-soft">Submitted</span>
                        <span class="font-medium text-navy-950"><?php echo e($application->submitted_at->format('d M Y, h:i A')); ?></span>
                    </div>
                    <?php if($application->reviewed_at): ?>
                        <div class="flex items-center justify-between">
                            <span class="text-ink-soft">Reviewed</span>
                            <span class="font-medium text-navy-950"><?php echo e($application->reviewed_at->format('d M Y, h:i A')); ?></span>
                        </div>
                    <?php endif; ?>
                    <?php if($application->reviewedBy): ?>
                        <div class="flex items-center justify-between">
                            <span class="text-ink-soft">Reviewed By</span>
                            <span class="font-medium text-navy-950"><?php echo e($application->reviewedBy->name); ?></span>
                        </div>
                    <?php endif; ?>
                </div>

                <?php if($application->admin_notes): ?>
                    <div class="mt-4 rounded-lg bg-cream p-4">
                        <p class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Admin Notes</p>
                        <p class="mt-1 text-sm text-navy-950"><?php echo e($application->admin_notes); ?></p>
                    </div>
                <?php endif; ?>

                <?php if($application->rejection_reason): ?>
                    <div class="mt-4 rounded-lg bg-maroon-50 p-4">
                        <p class="text-xs font-semibold uppercase tracking-wider text-maroon-700">Rejection Reason</p>
                        <p class="mt-1 text-sm text-maroon-800"><?php echo e($application->rejection_reason); ?></p>
                    </div>
                <?php endif; ?>
            </div>

            
            <?php if(in_array($application->status->value, ['pending', 'under_review', 'changes_requested'])): ?>
                <div class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm">
                    <h2 class="font-serif text-xl font-semibold text-navy-950">Review Actions</h2>

                    
                    <?php if(in_array($application->status->value, ['pending', 'under_review'])): ?>
                        <form method="POST" action="<?php echo e(route('admin.membership-applications.approve', $application)); ?>" class="mt-4" x-data x-confirm="Are you sure you want to approve this application? This will create a membership record.">
                            <?php echo csrf_field(); ?>
                            <div class="mb-3">
                                <label for="approve_membership_type_id" class="mb-1 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Membership Type <span class="text-maroon-600">*</span></label>
                                <select id="approve_membership_type_id" name="membership_type_id" required class="input-field">
                                    <option value="">Select type</option>
                                    <?php $__currentLoopData = \App\Models\MembershipType::active()->ordered()->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($type->id); ?>" <?php echo e(old('membership_type_id', $application->membership_type_id) == $type->id ? 'selected' : ''); ?>>
                                            <?php echo e($type->name); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <button type="submit" class="w-full focus-ring inline-flex items-center justify-center gap-2 rounded-md bg-emerald-600 px-4 py-2.5 text-sm font-semibold text-white transition-colors hover:bg-emerald-700">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Approve Application
                            </button>
                        </form>
                    <?php endif; ?>

                    
                    <?php if($application->status->value === 'pending'): ?>
                        <form method="POST" action="<?php echo e(route('admin.membership-applications.review', $application)); ?>" class="mt-3">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="status" value="under_review">
                            <button type="submit" class="w-full focus-ring inline-flex items-center justify-center gap-2 rounded-md border border-navy-200 px-4 py-2.5 text-sm font-semibold text-navy-700 transition-colors hover:bg-navy-50">
                                Mark Under Review
                            </button>
                        </form>
                    <?php endif; ?>

                    
                    <form method="POST" action="<?php echo e(route('admin.membership-applications.review', $application)); ?>" class="mt-3" x-data="{ showNotes: false }">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="status" value="changes_requested">
                        <div x-show="showNotes" x-transition class="mb-3">
                            <label for="admin_notes_changes" class="mb-1 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Note to Applicant</label>
                            <textarea id="admin_notes_changes" name="admin_notes" rows="3" class="input-field" required placeholder="Describe what changes are needed…"></textarea>
                        </div>
                        <button type="button" @click="showNotes = !showNotes" class="w-full focus-ring inline-flex items-center justify-center gap-2 rounded-md border border-amber-300 bg-amber-50 px-4 py-2.5 text-sm font-semibold text-amber-800 transition-colors hover:bg-amber-100">
                            Request Changes
                        </button>
                    </form>

                    
                    <form method="POST" action="<?php echo e(route('admin.membership-applications.review', $application)); ?>" class="mt-3" x-data="{ showReason: false }">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="status" value="rejected">
                        <div x-show="showReason" x-transition class="mb-3">
                            <label for="rejection_reason" class="mb-1 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Rejection Reason</label>
                            <textarea id="rejection_reason" name="rejection_reason" rows="3" class="input-field" required placeholder="Provide a reason for rejection…"></textarea>
                        </div>
                        <button type="button" @click="showReason = !showReason" class="w-full focus-ring inline-flex items-center justify-center gap-2 rounded-md border border-maroon-200 bg-maroon-50 px-4 py-2.5 text-sm font-semibold text-maroon-700 transition-colors hover:bg-maroon-100">
                            Reject Application
                        </button>
                    </form>
                </div>
            <?php endif; ?>

            
            <?php if($application->alumni): ?>
                <div class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm">
                    <h2 class="font-serif text-xl font-semibold text-navy-950">Linked Alumni</h2>
                    <div class="mt-4">
                        <a href="<?php echo e(route('admin.alumni.show', $application->alumni)); ?>" class="text-sm font-medium text-maroon-700 hover:text-maroon-800">
                            <?php echo e($application->alumni->full_name); ?>

                        </a>
                        <p class="mt-1 text-xs text-ink-soft"><?php echo e($application->alumni->email); ?></p>
                    </div>
                </div>
            <?php endif; ?>
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
<?php /**PATH C:\xampp\htdocs\ProDo\EDAA\resources\views\admin\membership-applications\show.blade.php ENDPATH**/ ?>