<?php if (isset($component)) { $__componentOriginal5863877a5171c196453bfa0bd807e410 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5863877a5171c196453bfa0bd807e410 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.app','data' => ['title' => 'Application Status','description' => 'Track the status of your EDAA-KNGC membership application.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.app'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Application Status','description' => 'Track the status of your EDAA-KNGC membership application.']); ?>

    <?php $__env->startPush('head'); ?>
        <meta name="robots" content="noindex, nofollow">
        <meta property="og:title" content="EDAA-KNGC Application <?php echo e($application->application_number); ?>">
        <meta property="og:description" content="My membership application to EDAA-KNGC has been submitted!">
        <meta property="og:type" content="website">
    <?php $__env->stopPush(); ?>

    <?php if (isset($component)) { $__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.page-header','data' => ['title' => 'Application Status','description' => 'Track the progress of your membership application.','eyebrow' => 'Status','breadcrumbs' => [
            ['label' => 'Membership', 'href' => route('membership')],
            ['label' => 'Application Status'],
        ]]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('page-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Application Status','description' => 'Track the progress of your membership application.','eyebrow' => 'Status','breadcrumbs' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
            ['label' => 'Membership', 'href' => route('membership')],
            ['label' => 'Application Status'],
        ])]); ?>
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
            <div class="mx-auto max-w-2xl">
                <?php if(session('application_submitted')): ?>
                    <div class="mb-6 flex items-start gap-3 rounded-lg border border-green-200 bg-green-50 p-5 text-green-800" role="status">
                        <svg class="mt-0.5 h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div>
                            <p class="font-semibold">Application Submitted</p>
                            <p class="mt-1 text-sm">Your membership application has been received and is being processed.</p>
                        </div>
                    </div>
                <?php endif; ?>

                
                <div id="welcome-card" class="overflow-hidden rounded-2xl shadow-2xl">
                    <div class="relative bg-gradient-to-br from-navy-950 via-navy-900 to-maroon-900 px-8 py-10 sm:px-12 sm:py-12">
                        
                        <div class="pointer-events-none absolute inset-0" aria-hidden="true">
                            <div class="absolute -right-20 -top-20 h-64 w-64 rounded-full bg-gold-400/10 blur-3xl"></div>
                            <div class="absolute -bottom-20 -left-20 h-48 w-48 rounded-full bg-maroon-500/10 blur-3xl"></div>
                            <div class="absolute right-0 top-0 h-full w-1/3 bg-gradient-to-l from-white/5 to-transparent"></div>
                        </div>

                        <div class="relative z-10">
                            
                            <div class="mb-8 flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <span class="flex h-12 w-12 items-center justify-center rounded-lg bg-maroon-700 font-serif text-xs font-bold tracking-wide text-white ring-1 ring-gold-500/60">
                                        EDAA
                                    </span>
                                    <div>
                                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-white/70">EDAA-KNGC</p>
                                        <p class="text-[10px] text-white/40">English Department Alumni Association</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-[10px] font-medium uppercase tracking-[0.2em] text-white/40">Application</p>
                                    <p class="font-serif text-sm font-bold text-gold-300"><?php echo e($application->application_number); ?></p>
                                </div>
                            </div>

                            
                            <div class="flex items-center gap-6">
                                
                                <div class="h-24 w-24 shrink-0 overflow-hidden rounded-full bg-white/10 ring-4 ring-gold-500/30 shadow-lg shadow-gold-500/20">
                                    <?php if($application->profile_photo_url): ?>
                                        <img src="<?php echo e($application->profile_photo_url); ?>" alt="<?php echo e($application->full_name); ?>" class="h-full w-full object-cover">
                                    <?php else: ?>
                                        <div class="flex h-full w-ful items-center justify-center font-serif text-2xl font-bold text-white/60">
                                            <?php echo e(strtoupper(substr($application->full_name, 0, 2))); ?>

                                        </div>
                                    <?php endif; ?>
                                </div>

                                
                                <div class="flex-1 min-w-0">
                                    <h2 class="font-serif text-2xl font-bold text-white sm:text-3xl"><?php echo e($application->full_name); ?></h2>
                                    <?php if($application->batch || $application->graduation_year): ?>
                                        <p class="mt-1.5 text-sm text-white/60">
                                            <?php if($application->batch): ?>Batch <?php echo e($application->batch); ?><?php endif; ?>
                                            <?php if($application->batch && $application->graduation_year): ?> · <?php endif; ?>
                                            <?php if($application->graduation_year): ?>Graduated <?php echo e($application->graduation_year); ?><?php endif; ?>
                                        </p>
                                    <?php endif; ?>
                                    <?php if($application->profession): ?>
                                        <p class="mt-1 text-sm text-white/50"><?php echo e($application->profession); ?><?php if($application->current_organization): ?> at <?php echo e($application->current_organization); ?><?php endif; ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>

                            
                            <div class="my-8 h-px bg-gradient-to-r from-transparent via-white/20 to-transparent"></div>

                            
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-[10px] font-semibold uppercase tracking-[0.2em] text-white/40">Status</p>
                                    <?php
                                        $statusColor = match($application->status->value) {
                                            'pending' => 'text-gold-300',
                                            'under_review' => 'text-blue-300',
                                            'approved' => 'text-emerald-300',
                                            'rejected' => 'text-red-300',
                                            default => 'text-white/70',
                                        };
                                    ?>
                                    <p class="mt-1 text-lg font-semibold <?php echo e($statusColor); ?>"><?php echo e($application->status->label()); ?></p>
                                </div>
                                <div class="text-right">
                                    <p class="text-[10px] font-semibold uppercase tracking-[0.2em] text-white/40">Submitted</p>
                                    <p class="mt-1 text-sm font-medium text-white/70"><?php echo e($application->submitted_at->format('d M Y')); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    
                    <div class="bg-navy-800 px-8 py-4 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="h-2 w-2 rounded-full bg-gold-400 animate-pulse"></span>
                            <p class="text-[10px] font-medium uppercase tracking-[0.2em] text-white/50">Welcome to the Family</p>
                        </div>
                        <p class="text-[10px] text-white/30">edaa.kngc.edu.bd</p>
                    </div>
                </div>

                
                <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                    <button
                        onclick="downloadCard()"
                        class="focus-ring flex flex-1 items-center justify-center gap-2 rounded-lg bg-maroon-700 px-6 py-3 text-sm font-semibold text-white shadow-sm transition-colors hover:bg-maroon-800"
                    >
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                        </svg>
                        Download Card
                    </button>
                    <button
                        onclick="shareCard()"
                        class="focus-ring flex flex-1 items-center justify-center gap-2 rounded-lg border border-navy-200 bg-white px-6 py-3 text-sm font-medium text-navy-700 shadow-sm transition-colors hover:bg-navy-50"
                    >
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7.217 10.907a2.25 2.25 0 100 2.186m0-2.186c.18.324.283.696.283 1.093s-.103.77-.283 1.093m0-2.186l9.566-5.314m-9.566 7.5l9.566 5.314m0 0a2.25 2.25 0 103.935 2.186 2.25 2.25 0 00-3.935-2.186zm0-12.814a2.25 2.25 0 103.933-2.185 2.25 2.25 0 00-3.933 2.185z" />
                        </svg>
                        Share
                    </button>
                </div>

                
                <div class="mt-8 rounded-xl border border-navy-100 bg-white p-8 shadow-sm sm:p-10">
                    <div class="text-center">
                        <span class="inline-flex h-14 w-14 items-center justify-center rounded-full bg-navy-900 font-serif text-lg font-bold text-gold-300">
                            <?php echo e(strtoupper(substr($application->application_number, -4))); ?>

                        </span>
                        <h2 class="mt-4 font-serif text-2xl font-semibold text-navy-950">Application <?php echo e($application->application_number); ?></h2>
                        <p class="mt-2 text-sm text-ink-soft">
                            Submitted <?php echo e($application->submitted_at->format('d M Y')); ?>

                        </p>
                    </div>

                    
                    <div class="mt-6 flex justify-center">
                        <?php
                            $statusBadge = match($application->status->value) {
                                'pending' => 'bg-gold-100 text-gold-800 border-gold-300',
                                'under_review' => 'bg-navy-100 text-navy-800 border-navy-300',
                                'approved' => 'bg-emerald-100 text-emerald-800 border-emerald-300',
                                'rejected' => 'bg-maroon-100 text-maroon-800 border-maroon-300',
                                'changes_requested' => 'bg-amber-100 text-amber-800 border-amber-300',
                                'cancelled' => 'bg-navy-100 text-navy-800 border-navy-300',
                                default => 'bg-navy-100 text-navy-800 border-navy-300',
                            };
                        ?>
                        <span class="inline-flex items-center gap-2 rounded-full border px-4 py-2 text-sm font-semibold <?php echo e($statusBadge); ?>">
                            <?php echo e($application->status->label()); ?>

                        </span>
                    </div>

                    
                    <div class="mt-8 space-y-4 text-sm">
                        <div class="flex items-center justify-between border-b border-navy-100 pb-3">
                            <span class="text-ink-soft">Membership Type</span>
                            <span class="font-medium text-navy-950"><?php echo e($application->membershipType->name ?? '—'); ?></span>
                        </div>
                        <?php if($application->requestedTier): ?>
                            <div class="flex items-center justify-between border-b border-navy-100 pb-3">
                                <span class="text-ink-soft">Requested Tier</span>
                                <span class="font-medium text-navy-950"><?php echo e($application->requestedTier->name); ?></span>
                            </div>
                        <?php endif; ?>
                        <div class="flex items-center justify-between border-b border-navy-100 pb-3">
                            <span class="text-ink-soft">Submitted</span>
                            <span class="font-medium text-navy-950"><?php echo e($application->submitted_at->format('d M Y, h:i A')); ?></span>
                        </div>
                    </div>

                    
                    <div class="mt-8 rounded-lg bg-cream p-6">
                        <h3 class="font-semibold text-navy-950">What happens next?</h3>
                        <div class="mt-3 space-y-2 text-sm text-ink-soft">
                            <?php switch($application->status->value):
                                case ('pending'): ?>
                                    <p>Your application is in the queue and will be reviewed by the Executive Committee. This typically takes a few business days.</p>
                                    <?php break; ?>
                                <?php case ('under_review'): ?>
                                    <p>Your application is currently being reviewed by the Executive Committee. You will be notified of any updates.</p>
                                    <?php break; ?>
                                <?php case ('approved'): ?>
                                    <p>Congratulations! Your membership has been approved. You will receive further instructions regarding fee payment and onboarding.</p>
                                    <?php break; ?>
                                <?php case ('rejected'): ?>
                                    <p>We appreciate your interest. Unfortunately, your application was not approved at this time. You may reapply in the future.</p>
                                    <?php break; ?>
                                <?php case ('changes_requested'): ?>
                                    <p>The committee has requested changes or additional information. Please check your email for details and resubmit when ready.</p>
                                    <?php break; ?>
                                <?php default: ?>
                                    <p>Your application status has been updated. Please check back later for more information.</p>
                            <?php endswitch; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script>
        function downloadCard() {
            const card = document.getElementById('welcome-card');
            html2canvas(card, {
                scale: 2,
                backgroundColor: null,
                useCORS: true,
            }).then(canvas => {
                const link = document.createElement('a');
                link.download = 'edaa-kngc-application-<?php echo e($application->application_number); ?>.png';
                link.href = canvas.toDataURL('image/png');
                link.click();
            });
        }

        function shareCard() {
            if (navigator.share) {
                navigator.share({
                    title: 'EDAA-KNGC Application <?php echo e($application->application_number); ?>',
                    text: 'My membership application to EDAA-KNGC has been submitted!',
                    url: window.location.href,
                });
            } else {
                navigator.clipboard.writeText(window.location.href).then(() => {
                    alert('Link copied to clipboard!');
                });
            }
        }
    </script>
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
<?php /**PATH C:\xampp\htdocs\ProDo\EDAA\resources\views\pages\membership-application-status.blade.php ENDPATH**/ ?>