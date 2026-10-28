<?php
    $alumniStory = $alumniStory ?? null;
    $inputClass = 'w-full rounded-md border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 placeholder-navy-400 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none';
?>


<section class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm sm:p-8">
    <h2 class="font-serif text-xl font-semibold text-navy-950">Story Information</h2>
    <p class="mt-1 text-sm text-ink-soft">Core details about the story.</p>

    <div class="mt-6 grid gap-6 sm:grid-cols-2">
        <div class="sm:col-span-2">
            <label for="title" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Title *</label>
            <input type="text" id="title" name="title" value="<?php echo e(old('title', $alumniStory?->title)); ?>" required placeholder="e.g. From Classroom to Global Career" class="<?php echo e($inputClass); ?> <?php echo e($errors->has('title') ? 'border-maroon-400 ring-2 ring-maroon-500/20' : ''); ?>">
            <?php $__errorArgs = ['title'];
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
            <label for="alumni_id" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Alumni *</label>
            <select id="alumni_id" name="alumni_id" required class="<?php echo e($inputClass); ?> <?php echo e($errors->has('alumni_id') ? 'border-maroon-400 ring-2 ring-maroon-500/20' : ''); ?>">
                <option value="">Select alumni</option>
                <?php $__currentLoopData = $alumniList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($a->id); ?>" <?php if(old('alumni_id', $alumniStory?->alumni_id) == $a->id): echo 'selected'; endif; ?>><?php echo e($a->full_name); ?><?php echo e($a->batch ? " — Batch {$a->batch}" : ''); ?><?php echo e($a->graduation_year ? " ({$a->graduation_year})" : ''); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <?php $__errorArgs = ['alumni_id'];
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
            <label for="author_name" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Author Name</label>
            <input type="text" id="author_name" name="author_name" value="<?php echo e(old('author_name', $alumniStory?->author_name)); ?>" placeholder="e.g. Mercy Uche" class="<?php echo e($inputClass); ?>">
            <?php $__errorArgs = ['author_name'];
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
            <label for="excerpt" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Excerpt *</label>
            <textarea id="excerpt" name="excerpt" rows="3" maxlength="1000" class="<?php echo e($inputClass); ?> <?php echo e($errors->has('excerpt') ? 'border-maroon-400 ring-2 ring-maroon-500/20' : ''); ?>"><?php echo e(old('excerpt', $alumniStory?->excerpt)); ?></textarea>
            <?php $__errorArgs = ['excerpt'];
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
            <label for="content" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Content *</label>
            <textarea id="content" name="content" rows="12" class="<?php echo e($inputClass); ?> <?php echo e($errors->has('content') ? 'border-maroon-400 ring-2 ring-maroon-500/20' : ''); ?>"><?php echo e(old('content', $alumniStory?->content)); ?></textarea>
            <?php $__errorArgs = ['content'];
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
    <h2 class="font-serif text-xl font-semibold text-navy-950">Publishing</h2>
    <p class="mt-1 text-sm text-ink-soft">Control when and how the story appears.</p>

    <div class="mt-6 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        <div>
            <label for="status" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Status *</label>
            <select id="status" name="status" class="<?php echo e($inputClass); ?>">
                <option value="draft" <?php if(old('status', $alumniStory?->status ?? 'draft') === 'draft'): echo 'selected'; endif; ?>>Draft — not visible publicly</option>
                <option value="published" <?php if(old('status', $alumniStory?->status ?? 'draft') === 'published'): echo 'selected'; endif; ?>>Published — visible publicly</option>
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
            <label for="published_at" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Published At</label>
            <input type="datetime-local" id="published_at" name="published_at" value="<?php echo e(old('published_at', $alumniStory?->published_at?->format('Y-m-d\TH:i'))); ?>" class="<?php echo e($inputClass); ?>">
            <?php $__errorArgs = ['published_at'];
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
    <h2 class="font-serif text-xl font-semibold text-navy-950">Display</h2>
    <p class="mt-1 text-sm text-ink-soft">Featured state and ordering.</p>

    <div class="mt-6 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        <div>
            <label for="sort_order" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Sort order</label>
            <input type="number" id="sort_order" name="sort_order" value="<?php echo e(old('sort_order', $alumniStory?->sort_order ?? 0)); ?>" min="0" class="<?php echo e($inputClass); ?>">
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
                <input type="checkbox" name="is_featured" value="1" class="h-4 w-4 rounded border-navy-300 text-maroon-700 focus:ring-maroon-500" <?php if(old('is_featured', $alumniStory?->is_featured)): echo 'checked'; endif; ?>>
                <span class="text-sm font-medium text-navy-950">Featured on homepage</span>
            </label>
        </div>
    </div>
</section>


<section class="mt-6 rounded-lg border border-navy-100 bg-white p-6 shadow-sm sm:p-8">
    <h2 class="font-serif text-xl font-semibold text-navy-950">Media</h2>
    <p class="mt-1 text-sm text-ink-soft">Cover image for the story.</p>

    <div class="mt-6">
        <label for="cover_image" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Cover image</label>
            <div class="flex items-center gap-4">
                <img id="preview-img" src="<?php echo e($alumniStory?->cover_image_url ?? ''); ?>" alt="" class="h-24 w-40 rounded-lg object-cover ring-4 ring-gold-500/30 <?php echo e($alumniStory?->cover_image_url ? '' : 'hidden'); ?>">
                <span id="preview-fallback" class="flex h-24 w-40 items-center justify-center rounded-lg border-2 border-dashed border-navy-200 bg-cream text-xs text-ink-soft <?php echo e($alumniStory?->cover_image_url ? 'hidden' : ''); ?>" aria-hidden="true">
                    No image
                </span>
                <input
                    type="file"
                    id="cover_image"
                    name="cover_image"
                    accept="image/*"
                    class="block w-full text-sm text-ink-soft file:mr-4 file:rounded-md file:border-0 file:bg-navy-900 file:px-4 file:py-2.5 file:text-sm file:font-semibold file:text-white hover:file:bg-navy-800"
                >
            </div>
            <p class="mt-2 text-xs text-ink-soft">JPEG, PNG or WebP, up to 8MB.</p>
            <?php $__errorArgs = ['cover_image'];
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
        <?php if($alumniStory?->cover_image): ?>
            <label class="mt-3 inline-flex items-center gap-2">
                <input type="checkbox" name="clear_image" value="1" class="h-4 w-4 rounded border-navy-300 text-maroon-700 focus:ring-maroon-500">
                <span class="text-sm text-navy-950">Remove current image</span>
            </label>
        <?php endif; ?>
    </div>
</section>

<?php $__env->startPush('scripts'); ?>
    <script>
    (function() {
        const input = document.getElementById('cover_image');
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
<?php $__env->stopPush(); ?>
<?php /**PATH C:\xampp\htdocs\ProDo\EDAA\resources\views/admin/stories/_form.blade.php ENDPATH**/ ?>