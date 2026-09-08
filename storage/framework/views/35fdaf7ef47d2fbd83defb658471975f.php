<?php if (isset($component)) { $__componentOriginalc8c9fd5d7827a77a31381de67195f0c3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc8c9fd5d7827a77a31381de67195f0c3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.admin','data' => ['title' => 'Message from ' . $message->name]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.admin'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Message from ' . $message->name)]); ?>
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="font-serif text-3xl font-semibold tracking-tight text-navy-950">Message from <?php echo e($message->name); ?></h1>
            <p class="mt-1 text-sm text-ink-soft"><?php echo e($message->subject); ?></p>
        </div>
        <div class="flex items-center gap-3">
            <form method="POST" action="<?php echo e(route('admin.messages.update', $message)); ?>">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PATCH'); ?>
                <input type="hidden" name="action" value="<?php echo e($message->read_at ? 'mark_unread' : 'mark_read'); ?>">
                <button type="submit" class="focus-ring inline-flex items-center gap-2 rounded-md px-3.5 py-2 text-sm font-semibold text-navy-800 transition-colors hover:bg-navy-50">
                    <?php if($message->read_at): ?>
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        Mark as Unread
                    <?php else: ?>
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                        Mark as Read
                    <?php endif; ?>
                </button>
            </form>
            <form method="POST" action="<?php echo e(route('admin.messages.update', $message)); ?>">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PATCH'); ?>
                <input type="hidden" name="action" value="<?php echo e($message->archived_at ? 'unarchive' : 'archive'); ?>">
                <button type="submit" class="focus-ring inline-flex items-center gap-2 rounded-md px-3.5 py-2 text-sm font-semibold text-navy-800 transition-colors hover:bg-navy-50">
                    <?php if($message->archived_at): ?>
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                        </svg>
                        Unarchive
                    <?php else: ?>
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                        </svg>
                        Archive
                    <?php endif; ?>
                </button>
            </form>
            <a href="<?php echo e(route('admin.messages.index')); ?>" class="focus-ring inline-flex items-center gap-2 rounded-md px-3.5 py-2 text-sm font-semibold text-navy-800 transition-colors hover:bg-navy-50">
                &larr; Back to Inbox
            </a>
        </div>
    </div>

    <nav class="mb-6 text-sm text-ink-soft" aria-label="Breadcrumb">
        <ol class="flex items-center gap-1.5">
            <li><a href="<?php echo e(route('admin.messages.index')); ?>" class="transition-colors hover:text-navy-950">Messages</a></li>
            <li aria-hidden="true"><svg class="h-3.5 w-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg></li>
            <li class="truncate font-medium text-navy-950"><?php echo e(\Illuminate\Support\Str::limit($message->subject, 50)); ?></li>
        </ol>
    </nav>

    <div class="grid gap-8 lg:grid-cols-3">
        <div class="space-y-8 lg:col-span-2">
            <section class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm sm:p-8">
                <h2 class="font-serif text-xl font-semibold text-navy-950">Message</h2>
                <div class="mt-4 whitespace-pre-line text-sm leading-relaxed text-navy-950"><?php echo e($message->message); ?></div>
            </section>
        </div>

        <aside class="space-y-8">
            <section class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm">
                <h2 class="font-serif text-lg font-semibold text-navy-950">Sender</h2>
                <div class="mt-4 space-y-3">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Name</p>
                        <p class="mt-1 text-sm text-navy-950"><?php echo e($message->name); ?></p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Email</p>
                        <p class="mt-1 text-sm text-navy-950">
                            <a href="mailto:<?php echo e($message->email); ?>" class="transition-colors hover:text-maroon-700"><?php echo e($message->email); ?></a>
                        </p>
                    </div>
                    <?php if($message->phone): ?>
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Phone</p>
                            <p class="mt-1 text-sm text-navy-950">
                                <a href="tel:<?php echo e($message->phone); ?>" class="transition-colors hover:text-maroon-700"><?php echo e($message->phone); ?></a>
                            </p>
                        </div>
                    <?php endif; ?>
                </div>
            </section>

            <section class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm">
                <h2 class="font-serif text-lg font-semibold text-navy-950">Details</h2>
                <div class="mt-4 space-y-3">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Subject</p>
                        <p class="mt-1 text-sm text-navy-950"><?php echo e($message->subject); ?></p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Received</p>
                        <p class="mt-1 text-sm text-navy-950"><?php echo e($message->created_at->format('M j, Y g:i A')); ?></p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Status</p>
                        <?php if(!$message->read_at): ?>
                            <span class="mt-1 inline-flex items-center gap-1.5 rounded-full bg-gold-500/20 px-2.5 py-1 text-xs font-semibold text-gold-700">
                                <span class="h-1.5 w-1.5 rounded-full bg-gold-500" aria-hidden="true"></span>
                                Unread
                            </span>
                        <?php elseif($message->archived_at): ?>
                            <span class="mt-1 inline-flex items-center gap-1.5 rounded-full bg-navy-100 px-2.5 py-1 text-xs font-semibold text-navy-800">
                                <span class="h-1.5 w-1.5 rounded-full bg-navy-600" aria-hidden="true"></span>
                                Archived
                            </span>
                        <?php else: ?>
                            <span class="mt-1 inline-flex items-center gap-1.5 rounded-full bg-emerald-100 px-2.5 py-1 text-xs font-semibold text-emerald-800">
                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-600" aria-hidden="true"></span>
                                Read
                            </span>
                        <?php endif; ?>
                    </div>
                </div>
            </section>

            <?php if($message->ip_address || $message->user_agent): ?>
                <section class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm">
                    <h2 class="font-serif text-lg font-semibold text-navy-950">Metadata</h2>
                    <div class="mt-4 space-y-3">
                        <?php if($message->ip_address): ?>
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-wider text-ink-soft">IP Address</p>
                                <p class="mt-1 text-sm text-navy-950"><?php echo e($message->ip_address); ?></p>
                            </div>
                        <?php endif; ?>
                        <?php if($message->user_agent): ?>
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-wider text-ink-soft">User Agent</p>
                                <p class="mt-1 text-sm break-all text-navy-950"><?php echo e($message->user_agent); ?></p>
                            </div>
                        <?php endif; ?>
                    </div>
                </section>
            <?php endif; ?>

            <section class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm">
                <h2 class="font-serif text-lg font-semibold text-navy-950">Actions</h2>
                <div class="mt-4 space-y-3">
                    <form method="POST" action="<?php echo e(route('admin.messages.update', $message)); ?>">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PATCH'); ?>
                        <input type="hidden" name="action" value="<?php echo e($message->read_at ? 'mark_unread' : 'mark_read'); ?>">
                        <button type="submit" class="focus-ring inline-flex w-full items-center justify-center gap-2 rounded-md border border-navy-200 bg-white px-4 py-2.5 text-sm font-semibold text-navy-800 transition-colors hover:bg-navy-50">
                            <?php if($message->read_at): ?>
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                Mark as Unread
                            <?php else: ?>
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                                Mark as Read
                            <?php endif; ?>
                        </button>
                    </form>
                    <form method="POST" action="<?php echo e(route('admin.messages.update', $message)); ?>">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PATCH'); ?>
                        <input type="hidden" name="action" value="<?php echo e($message->archived_at ? 'unarchive' : 'archive'); ?>">
                        <button type="submit" class="focus-ring inline-flex w-full items-center justify-center gap-2 rounded-md border border-navy-200 bg-white px-4 py-2.5 text-sm font-semibold text-navy-800 transition-colors hover:bg-navy-50">
                            <?php if($message->archived_at): ?>
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                                </svg>
                                Unarchive
                            <?php else: ?>
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                                </svg>
                                Archive
                            <?php endif; ?>
                        </button>
                    </form>
                    <form method="POST" action="<?php echo e(route('admin.messages.destroy', $message)); ?>" onsubmit="return confirm('Delete this message from <?php echo e(addslashes($message->name)); ?>? This cannot be undone.');">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="focus-ring inline-flex w-full items-center justify-center gap-2 rounded-md border border-maroon-200 bg-white px-4 py-2.5 text-sm font-semibold text-maroon-700 transition-colors hover:bg-maroon-50">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.8 12a2 2 0 01-2 1.8H7.8a2 2 0 01-2-1.8L5 7m5 4v6m4-6v6m-9-10h14M9 7V5a2 2 0 012-2h2a2 2 0 012 2v2" />
                            </svg>
                            Delete Message
                        </button>
                    </form>
                </div>
            </section>
        </aside>
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
<?php /**PATH C:\xampp\htdocs\ProDo\EDAA\resources\views\admin\messages\show.blade.php ENDPATH**/ ?>