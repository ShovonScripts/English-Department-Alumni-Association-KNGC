<?php if (isset($component)) { $__componentOriginal5863877a5171c196453bfa0bd807e410 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5863877a5171c196453bfa0bd807e410 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.app','data' => ['title' => 'Edit Profile']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.app'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Edit Profile')]); ?>
    
    <section class="relative bg-navy-950 py-14 overflow-hidden">
        <div class="absolute inset-0 hero-gradient-mesh"></div>
        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="font-serif text-2xl sm:text-3xl font-bold text-white">Edit Profile</h1>
                    <p class="mt-1.5 text-sm text-white/50">Update your personal and professional information</p>
                </div>
                <a href="<?php echo e(route('member.profile')); ?>" class="focus-ring inline-flex items-center gap-1.5 rounded-md bg-white/10 px-3 py-1.5 text-xs font-medium text-white/80 ring-1 ring-white/10 transition-all hover:bg-white/15">
                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5h3m-6.75 2.25h10.5a2.25 2.25 0 002.25-2.25v-15a2.25 2.25 0 00-2.25-2.25H6.75A2.25 2.25 0 004.5 4.5v15a2.25 2.25 0 002.25 2.25z" /></svg>
                    View Profile
                </a>
            </div>
        </div>
    </section>

    
    <section class="py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                <aside class="lg:col-span-1">
                    <div class="rounded-xl border border-navy-100/60 bg-white p-3 shadow-sm sticky top-24">
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

                <main class="lg:col-span-3 space-y-6">
                    
                    <?php if($errors->any()): ?>
                        <div class="rounded-xl border border-red-200 bg-red-50 p-4 flex items-start gap-3">
                            <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-red-100 mt-0.5">
                                <svg class="h-4 w-4 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" /></svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-red-800">Please fix the following errors:</p>
                                <ul class="mt-1 list-inside list-disc space-y-0.5 text-sm text-red-700">
                                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li><?php echo e($error); ?></li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if(session('success')): ?>
                        <div class="rounded-xl border border-emerald-200 bg-emerald-50 p-4 flex items-center gap-3">
                            <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-emerald-100">
                                <svg class="h-4 w-4 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                            </div>
                            <p class="text-sm font-medium text-emerald-800"><?php echo e(session('success')); ?></p>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="<?php echo e(route('member.profile.update')); ?>" enctype="multipart/form-data" class="space-y-6">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>

                        
                        <div class="premium-card p-6">
                            <h2 class="font-serif text-lg font-semibold text-navy-950 mb-1">Profile Photo</h2>
                            <p class="text-sm text-ink-soft mb-5">This appears on your public profile and membership card.</p>
                            <div class="flex items-start gap-6">
                                <div class="h-24 w-24 shrink-0 overflow-hidden rounded-full bg-navy-100 ring-2 ring-navy-200 shadow-sm" id="photo-preview-container">
                                    <img id="photo-preview-img" src="<?php echo e($alumni->profile_photo_url ?? ''); ?>" alt="Preview" class="h-full w-full object-cover <?php echo e($alumni->profile_photo ? '' : 'hidden'); ?>">
                                    <div id="photo-preview-fallback" class="h-full w-full <?php echo e($alumni->profile_photo ? 'hidden' : ''); ?>">
                                        <?php if($alumni->profile_photo): ?>
                                            <img src="<?php echo e($alumni->profile_photo_url); ?>" alt="<?php echo e($alumni->full_name); ?>" class="h-full w-full object-cover">
                                        <?php else: ?>
                                            <div class="flex h-full w-full items-center justify-center text-2xl font-bold text-navy-400">
                                                <?php echo e(strtoupper(substr($alumni->full_name, 0, 2))); ?>

                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <label for="profile_photo" class="block text-sm font-medium text-navy-900">Upload new photo</label>
                                    <input type="file" id="profile_photo" name="profile_photo" accept="image/*"
                                           class="mt-1.5 block w-full text-sm text-ink-soft file:mr-4 file:rounded-lg file:border-0 file:bg-maroon-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-maroon-700 hover:file:bg-maroon-100 file:transition-colors" />
                                    <p class="mt-1.5 text-xs text-ink-soft">JPG, PNG, or WebP. Max 2MB.</p>
                                    <?php if($alumni->profile_photo): ?>
                                        <label class="mt-3 flex items-center gap-2 text-sm text-navy-700 cursor-pointer">
                                            <input type="checkbox" name="remove_photo" value="1" class="h-4 w-4 rounded border-navy-300 text-gold-500 focus:ring-gold-500" />
                                            Remove current photo
                                        </label>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        
                        <div class="premium-card p-6">
                            <h2 class="font-serif text-lg font-semibold text-navy-950 mb-1">Contact Information</h2>
                            <p class="text-sm text-ink-soft mb-5">How other members and the admin team can reach you.</p>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                <div>
                                    <label for="email" class="form-label">Email Address</label>
                                    <input type="email" id="email" name="email" value="<?php echo e(old('email', $user->email)); ?>" required
                                           class="input-field" />
                                    <p class="mt-1.5 text-xs text-ink-soft">Used for login. Contact admin if you lose access.</p>
                                </div>
                                <div>
                                    <label for="phone" class="form-label">Phone</label>
                                    <input type="text" id="phone" name="phone" value="<?php echo e(old('phone', $alumni->phone)); ?>" placeholder="+880..."
                                           class="input-field" />
                                </div>
                            </div>
                        </div>

                        
                        <div class="premium-card p-6">
                            <h2 class="font-serif text-lg font-semibold text-navy-950 mb-1">Location</h2>
                            <p class="text-sm text-ink-soft mb-5">Where you're based now.</p>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                <div>
                                    <label for="city" class="form-label">City</label>
                                    <input type="text" id="city" name="city" value="<?php echo e(old('city', $alumni->city)); ?>" placeholder="e.g. Dhaka"
                                           class="input-field" />
                                </div>
                                <div>
                                    <label for="country" class="form-label">Country</label>
                                    <input type="text" id="country" name="country" value="<?php echo e(old('country', $alumni->country)); ?>" placeholder="e.g. Bangladesh"
                                           class="input-field" />
                                </div>
                            </div>
                        </div>

                        
                        <div class="premium-card p-6">
                            <h2 class="font-serif text-lg font-semibold text-navy-950 mb-1">Professional Information</h2>
                            <p class="text-sm text-ink-soft mb-5">Your career details and online presence.</p>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                <div>
                                    <label for="profession" class="form-label">Profession / Title</label>
                                    <input type="text" id="profession" name="profession" value="<?php echo e(old('profession', $alumni->profession)); ?>" placeholder="e.g. Software Engineer"
                                           class="input-field" />
                                </div>
                                <div>
                                    <label for="organization" class="form-label">Organization</label>
                                    <input type="text" id="organization" name="organization" value="<?php echo e(old('organization', $alumni->organization)); ?>" placeholder="e.g. Google"
                                           class="input-field" />
                                </div>
                                <div>
                                    <label for="website_url" class="form-label">Website URL</label>
                                    <input type="url" id="website_url" name="website_url" value="<?php echo e(old('website_url', $alumni->website_url)); ?>" placeholder="https://"
                                           class="input-field" />
                                </div>
                                <div>
                                    <label for="linkedin_url" class="form-label">LinkedIn URL</label>
                                    <input type="url" id="linkedin_url" name="linkedin_url" value="<?php echo e(old('linkedin_url', $alumni->linkedin_url)); ?>" placeholder="https://linkedin.com/in/..."
                                           class="input-field" />
                                </div>
                            </div>
                        </div>

                        
                        <div class="premium-card p-6">
                            <h2 class="font-serif text-lg font-semibold text-navy-950 mb-1">About You</h2>
                            <p class="text-sm text-ink-soft mb-5">A short bio visible on your public profile.</p>
                            <div>
                                <label for="bio" class="form-label">Bio</label>
                                <textarea id="bio" name="bio" rows="4" maxlength="1000"
                                          class="input-field resize-none"
                                          placeholder="Tell us a bit about yourself..."><?php echo e(old('bio', $alumni->bio)); ?></textarea>
                                <p class="mt-1.5 text-xs text-ink-soft">Max 1000 characters. <span id="bio-count" class="font-medium text-navy-600">0</span>/1000</p>
                            </div>
                        </div>

                        
                        <div class="flex items-center gap-3 justify-end">
                            <a href="<?php echo e(route('member.profile')); ?>" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary gap-2">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                                Save Changes
                            </button>
                        </div>
                    </form>

                    
                    <div class="premium-card p-6">
                        <h2 class="font-serif text-lg font-semibold text-navy-950 mb-1">Authoritative Records</h2>
                        <p class="text-sm text-ink-soft mb-6">These fields are tied to official alumni records and cannot be directly modified. If there is an error, you may request a correction.</p>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <?php $__currentLoopData = [
                                ['field' => 'full_name', 'label' => 'Full Name', 'value' => $alumni->full_name],
                                ['field' => 'student_id', 'label' => 'Student ID', 'value' => $alumni->student_id ?: '-'],
                                ['field' => 'batch', 'label' => 'Batch', 'value' => $alumni->batch ?: '-'],
                                ['field' => 'graduation_year', 'label' => 'Graduation Year', 'value' => $alumni->graduation_year ?: '-'],
                            ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="rounded-xl bg-navy-50/50 border border-navy-100 px-4 py-3">
                                    <p class="text-[11px] font-semibold uppercase tracking-wider text-ink-soft mb-1"><?php echo e($item['label']); ?></p>
                                    <div class="flex items-center justify-between gap-2">
                                        <span class="text-sm font-medium text-navy-900 truncate"><?php echo e($item['value']); ?></span>
                                        <button type="button" class="shrink-0 text-xs font-medium text-maroon-700 hover:text-maroon-800 hover:underline transition-colors correction-trigger" data-field="<?php echo e($item['field']); ?>" data-label="<?php echo e($item['label']); ?>">Correct</button>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>

                        
                        <div id="correction-modal" class="fixed inset-0 z-50 hidden items-center justify-center p-4 bg-navy-900/50 backdrop-blur-sm">
                            <div id="correction-modal-panel" class="bg-white rounded-2xl shadow-xl w-full max-w-md overflow-hidden transform scale-95 opacity-0 transition-all duration-200">
                                <form method="POST" action="<?php echo e(route('member.correction-requests.store')); ?>">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="requested_field" id="correction-field">

                                    <div class="px-6 py-4 border-b border-navy-100 flex items-center justify-between">
                                        <h3 class="font-serif text-lg font-semibold text-navy-900">Request Correction</h3>
                                        <button type="button" id="correction-close" class="flex h-8 w-8 items-center justify-center rounded-lg text-navy-400 hover:text-navy-600 hover:bg-navy-50 transition-colors">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                        </button>
                                    </div>
                                    <div class="p-6 space-y-4">
                                        <div>
                                            <label class="block text-sm font-medium text-navy-900">Field</label>
                                            <p class="mt-1 text-sm text-ink-soft font-medium" id="correction-label"></p>
                                        </div>
                                        <div>
                                            <label for="requested_value" class="block text-sm font-medium text-navy-900">Correct Value</label>
                                            <input type="text" id="requested_value" name="requested_value" required
                                                   class="mt-1.5 input-field" placeholder="Enter the correct value">
                                        </div>
                                        <div>
                                            <label for="reason" class="block text-sm font-medium text-navy-900">Reason / Proof</label>
                                            <textarea id="reason" name="reason" rows="3" required
                                                      class="mt-1.5 input-field resize-none" placeholder="Please provide context or proof for this correction..."></textarea>
                                        </div>
                                    </div>
                                    <div class="px-6 py-4 bg-navy-50/50 border-t border-navy-100 flex justify-end gap-3">
                                        <button type="button" id="correction-cancel" class="btn btn-secondary">Cancel</button>
                                        <button type="submit" class="btn btn-primary">Submit Request</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </section>

    <?php $__env->startPush('scripts'); ?>
        <script>
        (function() {
            'use strict';

            const profilePhotoInput = document.getElementById('profile_photo');
            const photoPreviewImg = document.getElementById('photo-preview-img');
            const photoPreviewFallback = document.getElementById('photo-preview-fallback');
            const bioTextarea = document.getElementById('bio');
            const bioCount = document.getElementById('bio-count');
            const correctionModal = document.getElementById('correction-modal');
            const correctionModalPanel = document.getElementById('correction-modal-panel');
            const correctionField = document.getElementById('correction-field');
            const correctionLabel = document.getElementById('correction-label');
            const correctionClose = document.getElementById('correction-close');
            const correctionCancel = document.getElementById('correction-cancel');

            if (profilePhotoInput && photoPreviewImg) {
                profilePhotoInput.addEventListener('change', function(event) {
                    const file = event.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            photoPreviewImg.src = e.target.result;
                            photoPreviewImg.classList.remove('hidden');
                            if (photoPreviewFallback) {
                                photoPreviewFallback.classList.add('hidden');
                            }
                        };
                        reader.readAsDataURL(file);
                    }
                });
            }

            if (bioTextarea && bioCount) {
                bioTextarea.addEventListener('input', function() {
                    bioCount.textContent = bioTextarea.value.length;
                });
                bioCount.textContent = bioTextarea.value.length;
            }

            function openCorrectionModal(field, label) {
                correctionField.value = field;
                correctionLabel.textContent = label;
                correctionModal.classList.remove('hidden');
                correctionModal.classList.add('flex');
                setTimeout(function() {
                    correctionModalPanel.classList.remove('scale-95', 'opacity-0');
                    correctionModalPanel.classList.add('scale-100', 'opacity-100');
                }, 10);
            }

            function closeCorrectionModal() {
                correctionModalPanel.classList.remove('scale-100', 'opacity-100');
                correctionModalPanel.classList.add('scale-95', 'opacity-0');
                setTimeout(function() {
                    correctionModal.classList.add('hidden');
                    correctionModal.classList.remove('flex');
                }, 200);
            }

            document.querySelectorAll('.correction-trigger').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    openCorrectionModal(btn.getAttribute('data-field'), btn.getAttribute('data-label'));
                });
            });

            if (correctionClose) correctionClose.addEventListener('click', closeCorrectionModal);
            if (correctionCancel) correctionCancel.addEventListener('click', closeCorrectionModal);

            correctionModal.addEventListener('click', function(e) {
                if (e.target === correctionModal) {
                    closeCorrectionModal();
                }
            });

            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && !correctionModal.classList.contains('hidden')) {
                    closeCorrectionModal();
                }
            });
        })();
        </script>
    <?php $__env->stopPush(); ?>
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
<?php /**PATH C:\xampp\htdocs\ProDo\EDAA\resources\views/member/profile/edit.blade.php ENDPATH**/ ?>