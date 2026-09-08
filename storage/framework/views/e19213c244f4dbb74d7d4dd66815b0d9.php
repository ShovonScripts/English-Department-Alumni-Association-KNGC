<?php if($paginator->hasPages()): ?>
    <nav role="navigation" aria-label="Pagination" class="flex flex-col items-center gap-4 sm:flex-row sm:justify-between">
        <p class="text-sm text-ink-soft">
            Showing
            <span class="font-semibold text-navy-950"><?php echo e($paginator->firstItem() ?? 0); ?></span>
            to
            <span class="font-semibold text-navy-950"><?php echo e($paginator->lastItem() ?? 0); ?></span>
            of
            <span class="font-semibold text-navy-950"><?php echo e($paginator->total()); ?></span>
            results
        </p>

        <div class="flex items-center gap-1.5">
            
            <?php if($paginator->onFirstPage()): ?>
                <span aria-disabled="true" aria-label="<?php echo e(__('pagination.previous')); ?>" class="inline-flex h-9 w-9 items-center justify-center rounded-md border border-navy-200 text-navy-300">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                </span>
            <?php else: ?>
                <a href="<?php echo e($paginator->previousPageUrl()); ?>" rel="prev" aria-label="<?php echo e(__('pagination.previous')); ?>" class="focus-ring inline-flex h-9 w-9 items-center justify-center rounded-md border border-navy-300 text-navy-800 transition-colors hover:border-navy-600 hover:bg-navy-50">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
            <?php endif; ?>

            
            <?php $__currentLoopData = $elements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if(is_string($element)): ?>
                    <span aria-disabled="true" class="inline-flex h-9 items-center px-3 font-medium text-navy-400"><?php echo e($element); ?></span>
                <?php endif; ?>

                <?php if(is_array($element)): ?>
                    <?php $__currentLoopData = $element; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($page == $paginator->currentPage()): ?>
                            <span aria-current="page" class="inline-flex h-9 w-9 items-center justify-center rounded-md bg-gold-500 font-semibold text-navy-950"><?php echo e($page); ?></span>
                        <?php else: ?>
                            <a href="<?php echo e($url); ?>" aria-label="<?php echo e(__('Go to page :page', ['page' => $page])); ?>" class="focus-ring inline-flex h-9 w-9 items-center justify-center rounded-md border border-navy-300 font-medium text-navy-800 transition-colors hover:border-navy-600 hover:bg-navy-50">
                                <?php echo e($page); ?>

                            </a>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            
            <?php if($paginator->hasMorePages()): ?>
                <a href="<?php echo e($paginator->nextPageUrl()); ?>" rel="next" aria-label="<?php echo e(__('pagination.next')); ?>" class="focus-ring inline-flex h-9 w-9 items-center justify-center rounded-md border border-navy-300 text-navy-800 transition-colors hover:border-navy-600 hover:bg-navy-50">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            <?php else: ?>
                <span aria-disabled="true" aria-label="<?php echo e(__('pagination.next')); ?>" class="inline-flex h-9 w-9 items-center justify-center rounded-md border border-navy-200 text-navy-300">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </span>
            <?php endif; ?>
        </div>
    </nav>
<?php endif; ?><?php /**PATH C:\xampp\htdocs\ProDo\EDAA\resources\views/vendor/pagination/tailwind.blade.php ENDPATH**/ ?>