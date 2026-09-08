<?php
    $event = $event ?? null;
    $inputClass = 'w-full rounded-md border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 placeholder-navy-400 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none';
?>


<section class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm sm:p-8">
    <h2 class="font-serif text-xl font-semibold text-navy-950">Basic Information</h2>
    <p class="mt-1 text-sm text-ink-soft">Core details about the event.</p>

    <div class="mt-6 grid gap-6 sm:grid-cols-2">
        <div class="sm:col-span-2">
            <label for="title" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Title *</label>
            <input type="text" id="title" name="title" value="<?php echo e(old('title', $event?->title)); ?>" required placeholder="e.g. Annual Alumni Lecture" class="<?php echo e($inputClass); ?> <?php echo e($errors->has('title') ? 'border-maroon-400 ring-2 ring-maroon-500/20' : ''); ?>">
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
            <label for="category_id" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Category</label>
            <select id="category_id" name="category_id" class="<?php echo e($inputClass); ?>">
                <option value="">No category</option>
                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($cat->id); ?>" <?php if(old('category_id', $event?->category_id) == $cat->id): echo 'selected'; endif; ?>><?php echo e($cat->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <?php $__errorArgs = ['category_id'];
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
            <label for="short_description" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Short description *</label>
            <input type="text" id="short_description" name="short_description" value="<?php echo e(old('short_description', $event?->short_description)); ?>" maxlength="500" placeholder="Brief summary for cards" class="<?php echo e($inputClass); ?> <?php echo e($errors->has('short_description') ? 'border-maroon-400 ring-2 ring-maroon-500/20' : ''); ?>">
            <?php $__errorArgs = ['short_description'];
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
            <label for="description" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Full description *</label>
            <textarea id="description" name="description" rows="8" maxlength="10000" class="<?php echo e($inputClass); ?> <?php echo e($errors->has('description') ? 'border-maroon-400 ring-2 ring-maroon-500/20' : ''); ?>"><?php echo e(old('description', $event?->description)); ?></textarea>
            <?php $__errorArgs = ['description'];
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
    <h2 class="font-serif text-xl font-semibold text-navy-950">Date & Time</h2>
    <p class="mt-1 text-sm text-ink-soft">When the event takes place.</p>

    <div class="mt-6 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
        <div>
            <label for="event_date" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Event date *</label>
            <input type="date" id="event_date" name="event_date" value="<?php echo e(old('event_date', $event?->event_date?->format('Y-m-d'))); ?>" required class="<?php echo e($inputClass); ?> <?php echo e($errors->has('event_date') ? 'border-maroon-400 ring-2 ring-maroon-500/20' : ''); ?>">
            <?php $__errorArgs = ['event_date'];
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
            <label for="start_time" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Start time</label>
            <input type="time" id="start_time" name="start_time" value="<?php echo e(old('start_time', $event?->start_time)); ?>" class="<?php echo e($inputClass); ?>">
            <?php $__errorArgs = ['start_time'];
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
            <label for="end_time" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">End time</label>
            <input type="time" id="end_time" name="end_time" value="<?php echo e(old('end_time', $event?->end_time)); ?>" class="<?php echo e($inputClass); ?>">
            <?php $__errorArgs = ['end_time'];
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
            <label for="registration_deadline" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Registration deadline</label>
            <input type="date" id="registration_deadline" name="registration_deadline" value="<?php echo e(old('registration_deadline', $event?->registration_deadline?->format('Y-m-d'))); ?>" class="<?php echo e($inputClass); ?>">
            <?php $__errorArgs = ['registration_deadline'];
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
    <h2 class="font-serif text-xl font-semibold text-navy-950">Location</h2>
    <p class="mt-1 text-sm text-ink-soft">Where the event is held.</p>

    <div class="mt-6 grid gap-6 sm:grid-cols-2">
        <div>
            <label for="venue" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Venue</label>
            <input type="text" id="venue" name="venue" value="<?php echo e(old('venue', $event?->venue)); ?>" placeholder="e.g. Faculty of Arts, Great Hall" class="<?php echo e($inputClass); ?>">
            <?php $__errorArgs = ['venue'];
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
            <label for="address" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Address</label>
            <input type="text" id="address" name="address" value="<?php echo e(old('address', $event?->address)); ?>" placeholder="Street address" class="<?php echo e($inputClass); ?>">
            <?php $__errorArgs = ['address'];
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
            <input type="text" id="city" name="city" value="<?php echo e(old('city', $event?->city)); ?>" placeholder="e.g. Lagos" class="<?php echo e($inputClass); ?>">
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
            <input type="text" id="country" name="country" value="<?php echo e(old('country', $event?->country)); ?>" placeholder="e.g. Nigeria" class="<?php echo e($inputClass); ?>">
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
    <h2 class="font-serif text-xl font-semibold text-navy-950">Organizer</h2>
    <p class="mt-1 text-sm text-ink-soft">Who is hosting the event.</p>

    <div class="mt-6">
        <label for="organizer" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Organizer</label>
        <input type="text" id="organizer" name="organizer" value="<?php echo e(old('organizer', $event?->organizer)); ?>" placeholder="e.g. EDAA Events Committee" class="<?php echo e($inputClass); ?>">
        <?php $__errorArgs = ['organizer'];
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
    <h2 class="font-serif text-xl font-semibold text-navy-950">Event Settings</h2>
    <p class="mt-1 text-sm text-ink-soft">Visibility, ordering, and capacity.</p>

    <div class="mt-6 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
        <div>
            <label for="capacity" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Capacity</label>
            <input type="number" id="capacity" name="capacity" value="<?php echo e(old('capacity', $event?->capacity)); ?>" min="1" placeholder="e.g. 200" class="<?php echo e($inputClass); ?>">
            <?php $__errorArgs = ['capacity'];
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
            <label for="status" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Status *</label>
            <select id="status" name="status" class="<?php echo e($inputClass); ?>">
                <option value="draft" <?php if(old('status', $event?->status ?? 'draft') === 'draft'): echo 'selected'; endif; ?>>Draft — not visible publicly</option>
                <option value="published" <?php if(old('status', $event?->status ?? 'draft') === 'published'): echo 'selected'; endif; ?>>Published — visible publicly</option>
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
            <input type="number" id="sort_order" name="sort_order" value="<?php echo e(old('sort_order', $event?->sort_order ?? 0)); ?>" min="0" class="<?php echo e($inputClass); ?>">
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
                <input type="checkbox" name="is_featured" value="1" class="h-4 w-4 rounded border-navy-300 text-maroon-700 focus:ring-maroon-500" <?php if(old('is_featured', $event?->is_featured)): echo 'checked'; endif; ?>>
                <span class="text-sm font-medium text-navy-950">Featured on homepage</span>
            </label>
        </div>
    </div>
</section>


<section class="mt-6 rounded-lg border border-navy-100 bg-white p-6 shadow-sm sm:p-8">
    <h2 class="font-serif text-xl font-semibold text-navy-950">Media</h2>
    <p class="mt-1 text-sm text-ink-soft">Cover image for the event listing.</p>

    <div class="mt-6">
        <label for="cover_image" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Cover image</label>
        <div x-data="{ preview: <?php echo \Illuminate\Support\Js::from($event?->cover_image_url)->toHtml() ?>, updatePreview(event) { const file = event.target.files[0]; if (!file) return; const reader = new FileReader(); reader.onload = (e) => this.preview = e.target.result; reader.readAsDataURL(file); } }">
            <div class="flex items-center gap-4">
                <template x-if="preview">
                    <img :src="preview" alt="" class="h-24 w-40 rounded-lg object-cover ring-4 ring-gold-500/30">
                </template>
                <template x-if="!preview">
                    <span class="flex h-24 w-40 items-center justify-center rounded-lg border-2 border-dashed border-navy-200 bg-cream text-xs text-ink-soft" aria-hidden="true">
                        No image
                    </span>
                </template>
                <input
                    type="file"
                    id="cover_image"
                    name="cover_image"
                    accept="image/*"
                    @change="updatePreview"
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
    </div>
</section>
<?php /**PATH C:\xampp\htdocs\ProDo\EDAA\resources\views\admin\events\_form.blade.php ENDPATH**/ ?>