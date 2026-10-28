<?php
    $alumni = $alumni ?? null;
    $inputClass = 'w-full rounded-md border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 placeholder-navy-400 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none';
?>


<section class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm sm:p-8">
    <h2 class="font-serif text-xl font-semibold text-navy-950">Identity</h2>
    <p class="mt-1 text-sm text-ink-soft">The alumni's name and directory photo.</p>

    <div class="mt-6 grid gap-6 sm:grid-cols-2">
        <div class="sm:col-span-2">
            <label for="full_name" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Full name *</label>
            <input type="text" id="full_name" name="full_name" value="<?php echo e(old('full_name', $alumni?->full_name)); ?>" required class="<?php echo e($inputClass); ?> <?php echo e($errors->has('full_name') ? 'border-maroon-400 ring-2 ring-maroon-500/20' : ''); ?>">
            <?php $__errorArgs = ['full_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="mt-1.5 text-xs font-medium text-maroon-700"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="sm:col-span-2">
            <label for="profile_photo" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Profile photo</label>
            <div class="flex items-center gap-4">
                <img id="preview-img" src="<?php echo e($alumni?->profile_photo_url ?? ''); ?>" alt="" class="h-20 w-20 rounded-full object-cover ring-4 ring-gold-500/30 <?php echo e($alumni?->profile_photo_url ? '' : 'hidden'); ?>">
                <span id="preview-fallback" class="flex h-20 w-20 items-center justify-center rounded-full bg-navy-900 font-serif text-lg font-semibold text-gold-300 ring-4 ring-gold-500/30 <?php echo e($alumni?->profile_photo_url ? 'hidden' : ''); ?>" aria-hidden="true">
                    <?php echo e(\Illuminate\Support\Str::initials(old('full_name', $alumni?->full_name ?? ''))); ?>

                </span>
                <input
                    type="file"
                    id="profile_photo"
                    name="profile_photo"
                    accept="image/*"
                    class="block w-full text-sm text-ink-soft file:mr-4 file:rounded-md file:border-0 file:bg-navy-900 file:px-4 file:py-2.5 file:text-sm file:font-semibold file:text-white hover:file:bg-navy-800"
                >
            </div>
                <p class="mt-2 text-xs text-ink-soft">JPEG, PNG or WebP, up to 8MB.</p>
                <?php $__errorArgs = ['profile_photo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-1.5 text-xs font-medium text-maroon-700"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
        </div>

        <div>
            <label for="student_id" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Student ID</label>
            <input type="text" id="student_id" name="student_id" value="<?php echo e(old('student_id', $alumni?->student_id)); ?>" class="<?php echo e($inputClass); ?>">
            <?php $__errorArgs = ['student_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="mt-1.5 text-xs font-medium text-maroon-700"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
    </div>
</section>


<section class="mt-6 rounded-lg border border-navy-100 bg-white p-6 shadow-sm sm:p-8">
    <h2 class="font-serif text-xl font-semibold text-navy-950">Education</h2>
    <p class="mt-1 text-sm text-ink-soft">Batch, session, and academic record.</p>

    <div class="mt-6 grid gap-6 sm:grid-cols-2">
        <div>
            <label for="batch" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Batch</label>
            <input type="text" id="batch" name="batch" value="<?php echo e(old('batch', $alumni?->batch)); ?>" placeholder="e.g. 2010" class="<?php echo e($inputClass); ?>">
            <?php $__errorArgs = ['batch'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="mt-1.5 text-xs font-medium text-maroon-700"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div>
            <label for="session" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Session</label>
            <input type="text" id="session" name="session" value="<?php echo e(old('session', $alumni?->session)); ?>" placeholder="e.g. 2010/2011" class="<?php echo e($inputClass); ?>">
            <?php $__errorArgs = ['session'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="mt-1.5 text-xs font-medium text-maroon-700"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div>
            <label for="graduation_year" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Graduation year</label>
            <input type="number" id="graduation_year" name="graduation_year" value="<?php echo e(old('graduation_year', $alumni?->graduation_year)); ?>" placeholder="e.g. 2014" min="1950" max="2100" class="<?php echo e($inputClass); ?>">
            <?php $__errorArgs = ['graduation_year'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="mt-1.5 text-xs font-medium text-maroon-700"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div>
            <label for="degree" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Degree</label>
            <input type="text" id="degree" name="degree" value="<?php echo e(old('degree', $alumni?->degree)); ?>" placeholder="e.g. BA English" class="<?php echo e($inputClass); ?>">
            <?php $__errorArgs = ['degree'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="mt-1.5 text-xs font-medium text-maroon-700"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
    </div>
</section>


<section class="mt-6 rounded-lg border border-navy-100 bg-white p-6 shadow-sm sm:p-8">
    <h2 class="font-serif text-xl font-semibold text-navy-950">Career</h2>
    <p class="mt-1 text-sm text-ink-soft">Where the alumni works and what they do.</p>

    <div class="mt-6 grid gap-6 sm:grid-cols-2">
        <div>
            <label for="profession" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Profession</label>
            <input type="text" id="profession" name="profession" value="<?php echo e(old('profession', $alumni?->profession)); ?>" placeholder="e.g. Publishing" class="<?php echo e($inputClass); ?>">
            <?php $__errorArgs = ['profession'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="mt-1.5 text-xs font-medium text-maroon-700"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div>
            <label for="designation" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Designation</label>
            <input type="text" id="designation" name="designation" value="<?php echo e(old('designation', $alumni?->designation)); ?>" placeholder="e.g. Publishing Manager" class="<?php echo e($inputClass); ?>">
            <?php $__errorArgs = ['designation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="mt-1.5 text-xs font-medium text-maroon-700"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="sm:col-span-2">
            <label for="organization" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Organization</label>
            <input type="text" id="organization" name="organization" value="<?php echo e(old('organization', $alumni?->organization)); ?>" placeholder="e.g. Harborline Publishers" class="<?php echo e($inputClass); ?>">
            <?php $__errorArgs = ['organization'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="mt-1.5 text-xs font-medium text-maroon-700"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div>
            <label for="city" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">City</label>
            <input type="text" id="city" name="city" value="<?php echo e(old('city', $alumni?->city)); ?>" placeholder="e.g. Lagos" class="<?php echo e($inputClass); ?>">
            <?php $__errorArgs = ['city'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="mt-1.5 text-xs font-medium text-maroon-700"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div>
            <label for="country" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Country</label>
            <input type="text" id="country" name="country" value="<?php echo e(old('country', $alumni?->country)); ?>" placeholder="e.g. Nigeria" class="<?php echo e($inputClass); ?>">
            <?php $__errorArgs = ['country'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="mt-1.5 text-xs font-medium text-maroon-700"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
    </div>
</section>


<section class="mt-6 rounded-lg border border-navy-100 bg-white p-6 shadow-sm sm:p-8">
    <h2 class="font-serif text-xl font-semibold text-navy-950">Biography</h2>
    <p class="mt-1 text-sm text-ink-soft">A short introduction shown on the alumni's public profile.</p>

    <div class="mt-6">
        <label for="bio" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Bio</label>
        <textarea id="bio" name="bio" rows="5" maxlength="2000" class="<?php echo e($inputClass); ?>"><?php echo e(old('bio', $alumni?->bio)); ?></textarea>
        <?php $__errorArgs = ['bio'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <p class="mt-1.5 text-xs font-medium text-maroon-700"><?php echo e($message); ?></p>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>
</section>


<section class="mt-6 rounded-lg border border-navy-100 bg-white p-6 shadow-sm sm:p-8">
    <h2 class="font-serif text-xl font-semibold text-navy-950">Contact details</h2>
    <p class="mt-1 text-sm text-ink-soft">Stored for the association only — never shown publicly.</p>

    <div class="mt-6 grid gap-6 sm:grid-cols-2">
        <div>
            <label for="email" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Email</label>
            <input type="email" id="email" name="email" value="<?php echo e(old('email', $alumni?->email)); ?>" class="<?php echo e($inputClass); ?>">
            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="mt-1.5 text-xs font-medium text-maroon-700"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div>
            <label for="phone" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Phone</label>
            <input type="tel" id="phone" name="phone" value="<?php echo e(old('phone', $alumni?->phone)); ?>" class="<?php echo e($inputClass); ?>">
            <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="mt-1.5 text-xs font-medium text-maroon-700"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div>
            <label for="linkedin_url" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">LinkedIn URL</label>
            <input type="url" id="linkedin_url" name="linkedin_url" value="<?php echo e(old('linkedin_url', $alumni?->linkedin_url)); ?>" placeholder="https://linkedin.com/in/…" class="<?php echo e($inputClass); ?>">
            <?php $__errorArgs = ['linkedin_url'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="mt-1.5 text-xs font-medium text-maroon-700"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div>
            <label for="website_url" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Website URL</label>
            <input type="url" id="website_url" name="website_url" value="<?php echo e(old('website_url', $alumni?->website_url)); ?>" placeholder="https://example.com" class="<?php echo e($inputClass); ?>">
            <?php $__errorArgs = ['website_url'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="mt-1.5 text-xs font-medium text-maroon-700"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
    </div>
</section>


<section class="mt-6 rounded-lg border border-navy-100 bg-white p-6 shadow-sm sm:p-8">
    <h2 class="font-serif text-xl font-semibold text-navy-950">Directory settings</h2>
    <p class="mt-1 text-sm text-ink-soft">Visibility, highlighting, and ordering in the directory.</p>

    <div class="mt-6 grid gap-6 sm:grid-cols-3">
        <div>
            <label for="status" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Status</label>
            <select id="status" name="status" class="<?php echo e($inputClass); ?>">
                <option value="active" <?php if(old('status', $alumni?->status ?? 'active') === 'active'): echo 'selected'; endif; ?>>Active — visible publicly</option>
                <option value="inactive" <?php if(old('status', $alumni?->status ?? 'active') === 'inactive'): echo 'selected'; endif; ?>>Inactive — hidden</option>
            </select>
            <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="mt-1.5 text-xs font-medium text-maroon-700"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div>
            <label for="sort_order" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Sort order</label>
            <input type="number" id="sort_order" name="sort_order" value="<?php echo e(old('sort_order', $alumni?->sort_order ?? 0)); ?>" min="0" class="<?php echo e($inputClass); ?>">
            <?php $__errorArgs = ['sort_order'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="mt-1.5 text-xs font-medium text-maroon-700"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="flex items-end">
            <label class="inline-flex items-center gap-3 rounded-md border border-navy-200 bg-cream px-4 py-3">
                <input type="checkbox" name="is_featured" value="1" class="h-4 w-4 rounded border-navy-300 text-maroon-700 focus:ring-maroon-500" <?php if(old('is_featured', $alumni?->is_featured)): echo 'checked'; endif; ?>>
                <span class="text-sm font-medium text-navy-950">Feature on homepage</span>
            </label>
        </div>
    </div>
</section>

<?php $__env->startPush('scripts'); ?>
    <script>
    (function() {
        const input = document.getElementById('profile_photo');
        const img = document.getElementById('preview-img');
        const fallback = document.getElementById('preview-fallback');
        if (input && img) {
            input.addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        img.src = e.target.result;
                        img.classList.remove('hidden');
                        if (fallback) fallback.classList.add('hidden');
                    };
                    reader.readAsDataURL(file);
                }
            });
        }
    })();
    </script>
<?php $__env->stopPush(); ?><?php /**PATH C:\xampp\htdocs\ProDo\EDAA\resources\views/admin/alumni/_form.blade.php ENDPATH**/ ?>