<?php if (isset($component)) { $__componentOriginalc8c9fd5d7827a77a31381de67195f0c3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc8c9fd5d7827a77a31381de67195f0c3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.admin','data' => ['title' => 'Edit Admin']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.admin'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Edit Admin']); ?>
    <div class="mb-8">
        <h1 class="font-serif text-3xl font-semibold tracking-tight text-navy-950">Edit Admin User</h1>
        <p class="mt-1 text-sm text-ink-soft">Update administrator account details.</p>
    </div>

    <?php if($errors->any()): ?>
        <div class="mb-6 rounded-md border border-maroon-200 bg-maroon-50 px-4 py-3 text-sm font-medium text-maroon-800">
            <ul class="list-inside list-disc">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST" action="<?php echo e(route('admin.admins.update', $admin)); ?>" class="max-w-2xl">
        <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>

        <div class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm space-y-5">
            <div>
                <label for="name" class="mb-1.5 block text-sm font-semibold text-navy-950">Full Name <span class="text-maroon-600">*</span></label>
                <input type="text" id="name" name="name" value="<?php echo e(old('name', $admin->name)); ?>" required
                    class="focus-ring w-full rounded-md border border-navy-200 bg-white px-4 py-2.5 text-sm text-navy-950 placeholder-navy-400">
            </div>

            <div>
                <label for="email" class="mb-1.5 block text-sm font-semibold text-navy-950">Email Address <span class="text-maroon-600">*</span></label>
                <input type="email" id="email" name="email" value="<?php echo e(old('email', $admin->email)); ?>" required
                    class="focus-ring w-full rounded-md border border-navy-200 bg-white px-4 py-2.5 text-sm text-navy-950 placeholder-navy-400">
            </div>

            <div>
                <label for="password" class="mb-1.5 block text-sm font-semibold text-navy-950">New Password</label>
                <input type="password" id="password" name="password"
                    class="focus-ring w-full rounded-md border border-navy-200 bg-white px-4 py-2.5 text-sm text-navy-950 placeholder-navy-400"
                    placeholder="Leave blank to keep current password">
                <p class="mt-1 text-xs text-ink-soft">Minimum 8 characters. Leave blank to keep current password.</p>
            </div>

            <div>
                <label for="password_confirmation" class="mb-1.5 block text-sm font-semibold text-navy-950">Confirm New Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation"
                    class="focus-ring w-full rounded-md border border-navy-200 bg-white px-4 py-2.5 text-sm text-navy-950 placeholder-navy-400"
                    placeholder="Repeat new password">
            </div>

            <div>
                <label for="status" class="mb-1.5 block text-sm font-semibold text-navy-950">Status</label>
                <select id="status" name="status"
                    class="focus-ring w-full rounded-md border border-navy-200 bg-white px-4 py-2.5 text-sm text-navy-950">
                    <option value="active" <?php if(old('status', $admin->status) === 'active'): echo 'selected'; endif; ?>>Active</option>
                    <option value="disabled" <?php if(old('status', $admin->status) === 'disabled'): echo 'selected'; endif; ?>>Disabled</option>
                </select>
            </div>
        </div>

        <div class="mt-6 flex items-center justify-end gap-3">
            <a href="<?php echo e(route('admin.admins.index')); ?>" class="focus-ring inline-flex items-center justify-center rounded-md px-4 py-2.5 text-sm font-semibold text-navy-600 transition-colors hover:bg-navy-50">
                Cancel
            </a>
            <button type="submit" class="focus-ring inline-flex items-center justify-center rounded-lg bg-gold-500 px-6 py-2.5 text-sm font-semibold text-navy-950 shadow-sm transition-colors hover:bg-gold-400">
                Update Admin
            </button>
        </div>
    </form>
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
<?php /**PATH C:\xampp\htdocs\ProDo\EDAA\resources\views\admin\admins\edit.blade.php ENDPATH**/ ?>