<?php
    use App\Models\ContactMessage;
    use App\Models\MembershipApplication;
    use App\Models\CorrectionRequest;
    use App\Enums\ApplicationStatus;

    $pendingApps = MembershipApplication::where('status', ApplicationStatus::Pending)->count();
    $unreadMsgs = ContactMessage::unread()->count();
    $pendingCorrections = CorrectionRequest::where('status', CorrectionRequest::STATUS_PENDING)->count();
    $totalNotifications = $pendingApps + $unreadMsgs + $pendingCorrections;
?>

<header class="sticky top-0 z-30 flex h-16 items-center justify-between gap-4 border-b border-navy-100 bg-white/90 backdrop-blur-md px-4 sm:px-6 lg:px-8 shadow-xs">
    
    <div class="flex items-center gap-3">
        <button
            type="button"
            class="focus-ring inline-flex h-9 w-9 items-center justify-center rounded-xl text-navy-600 hover:bg-navy-50 hover:text-navy-950 transition lg:hidden"
            @click="$dispatch('toggle-sidebar')"
            aria-label="Toggle navigation sidebar"
        >
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>

        <div>
            <h1 class="text-sm font-bold text-navy-950 tracking-tight sm:text-base font-serif"><?php echo e($heading ?? 'Administration'); ?></h1>
            <p class="hidden text-xs text-navy-500 sm:block">Alumni Association Command & Management</p>
        </div>
    </div>

    
    <div class="hidden md:flex flex-1 max-w-md mx-4">
        <button
            type="button"
            @click="$dispatch('open-command-palette')"
            class="flex w-full items-center justify-between rounded-xl bg-navy-50/70 hover:bg-navy-50 border border-navy-200/80 px-3.5 py-1.5 text-xs text-navy-500 transition-all duration-200 group hover:border-gold-400 hover:text-navy-800 shadow-inner"
            title="Press Ctrl+K or Cmd+K to search"
        >
            <span class="flex items-center gap-2">
                <svg class="h-4 w-4 text-navy-400 group-hover:text-gold-600 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <span>Search pages, members, events...</span>
            </span>
            <span class="flex items-center gap-1 font-mono text-[10px] text-navy-400 bg-white px-1.5 py-0.5 rounded border border-navy-200/60 shadow-xs">
                <span>Ctrl</span>
                <span>K</span>
            </span>
        </button>
    </div>

    
    <div class="flex items-center gap-2 sm:gap-3">
        
        <button
            type="button"
            @click="$dispatch('open-command-palette')"
            class="flex h-9 w-9 items-center justify-center rounded-xl text-navy-600 hover:bg-navy-50 md:hidden"
            aria-label="Search"
        >
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </button>

        
        <div class="relative" x-data="{ open: false }" @click.outside="open = false">
            <button
                type="button"
                @click="open = !open"
                class="focus-ring inline-flex items-center gap-1.5 rounded-xl bg-gradient-to-r from-maroon-700 to-maroon-800 hover:from-maroon-800 hover:to-maroon-900 text-white px-3 py-1.5 text-xs font-semibold shadow-xs transition-all duration-200 hover:shadow-md"
            >
                <svg class="h-4 w-4 text-gold-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                <span class="hidden sm:inline">Create</span>
                <svg class="h-3 w-3 text-white/70" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                </svg>
            </button>

            <div
                x-show="open"
                x-transition:enter="transition ease-out duration-150"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-100"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="absolute right-0 mt-2 w-56 origin-top-right rounded-2xl bg-white p-2 shadow-xl ring-1 ring-black/5 focus:outline-none z-50 border border-navy-100"
                style="display: none;"
            >
                <p class="px-3 py-1 text-[10px] font-bold uppercase tracking-wider text-navy-400">Quick Record</p>
                <div class="space-y-0.5">
                    <a href="<?php echo e(route('admin.events.create')); ?>" class="flex items-center gap-2.5 rounded-xl px-3 py-2 text-xs font-medium text-navy-700 hover:bg-gold-50/60 hover:text-gold-900 transition">
                        <span class="flex h-6 w-6 items-center justify-center rounded-lg bg-gold-100 text-gold-700 text-xs font-bold">E</span>
                        <span>New Event</span>
                    </a>
                    <a href="<?php echo e(route('admin.news.create')); ?>" class="flex items-center gap-2.5 rounded-xl px-3 py-2 text-xs font-medium text-navy-700 hover:bg-navy-50 hover:text-navy-950 transition">
                        <span class="flex h-6 w-6 items-center justify-center rounded-lg bg-navy-100 text-navy-700 text-xs font-bold">N</span>
                        <span>New News Article</span>
                    </a>
                    <a href="<?php echo e(route('admin.stories.create')); ?>" class="flex items-center gap-2.5 rounded-xl px-3 py-2 text-xs font-medium text-navy-700 hover:bg-navy-50 hover:text-navy-950 transition">
                        <span class="flex h-6 w-6 items-center justify-center rounded-lg bg-navy-100 text-navy-700 text-xs font-bold">S</span>
                        <span>New Alumni Story</span>
                    </a>
                    <a href="<?php echo e(route('admin.payments.create')); ?>" class="flex items-center gap-2.5 rounded-xl px-3 py-2 text-xs font-medium text-navy-700 hover:bg-emerald-50 hover:text-emerald-900 transition">
                        <span class="flex h-6 w-6 items-center justify-center rounded-lg bg-emerald-100 text-emerald-700 text-xs font-bold">৳</span>
                        <span>Record Payment</span>
                    </a>
                    <a href="<?php echo e(route('admin.expenses.create')); ?>" class="flex items-center gap-2.5 rounded-xl px-3 py-2 text-xs font-medium text-navy-700 hover:bg-rose-50 hover:text-rose-900 transition">
                        <span class="flex h-6 w-6 items-center justify-center rounded-lg bg-rose-100 text-rose-700 text-xs font-bold">X</span>
                        <span>Record Expense</span>
                    </a>
                </div>
            </div>
        </div>

        
        <div class="relative" x-data="{ open: false }" @click.outside="open = false">
            <button
                type="button"
                @click="open = !open"
                class="relative flex h-9 w-9 items-center justify-center rounded-xl text-navy-600 hover:bg-navy-50 hover:text-navy-900 transition"
                aria-label="Pending notifications"
            >
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                </svg>
                <?php if($totalNotifications > 0): ?>
                    <span class="absolute top-1.5 right-1.5 flex h-4 min-w-4 items-center justify-center rounded-full bg-rose-600 px-1 text-[9px] font-bold text-white ring-2 ring-white animate-pulse">
                        <?php echo e($totalNotifications); ?>

                    </span>
                <?php endif; ?>
            </button>

            <div
                x-show="open"
                x-transition:enter="transition ease-out duration-150"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-100"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="absolute right-0 mt-2 w-80 origin-top-right rounded-2xl bg-white p-3 shadow-xl ring-1 ring-black/5 focus:outline-none z-50 border border-navy-100"
                style="display: none;"
            >
                <div class="flex items-center justify-between pb-2 border-b border-navy-100 px-1">
                    <span class="font-serif text-sm font-bold text-navy-950">Action Items</span>
                    <span class="text-xs font-semibold text-navy-500"><?php echo e($totalNotifications); ?> pending</span>
                </div>

                <div class="mt-2 space-y-1.5 max-h-72 overflow-y-auto">
                    <?php if($pendingApps > 0): ?>
                        <a href="<?php echo e(route('admin.membership-applications.index')); ?>" class="flex items-start gap-3 rounded-xl p-2.5 hover:bg-amber-50/60 transition group">
                            <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-amber-100 text-amber-700">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </span>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-bold text-navy-900 group-hover:text-amber-800"><?php echo e($pendingApps); ?> Applications Pending</p>
                                <p class="text-[11px] text-navy-500 truncate">Awaiting admin review and approval</p>
                            </div>
                        </a>
                    <?php endif; ?>

                    <?php if($pendingCorrections > 0): ?>
                        <a href="<?php echo e(route('admin.correction-requests.index')); ?>" class="flex items-start gap-3 rounded-xl p-2.5 hover:bg-rose-50/60 transition group">
                            <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-rose-100 text-rose-700">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </span>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-bold text-navy-900 group-hover:text-rose-800"><?php echo e($pendingCorrections); ?> Data Corrections</p>
                                <p class="text-[11px] text-navy-500 truncate">Alumni requested profile edits</p>
                            </div>
                        </a>
                    <?php endif; ?>

                    <?php if($unreadMsgs > 0): ?>
                        <a href="<?php echo e(route('admin.messages.index')); ?>" class="flex items-start gap-3 rounded-xl p-2.5 hover:bg-blue-50/60 transition group">
                            <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-blue-100 text-blue-700">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </span>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-bold text-navy-900 group-hover:text-blue-800"><?php echo e($unreadMsgs); ?> Unread Messages</p>
                                <p class="text-[11px] text-navy-500 truncate">Inquiries sent via contact form</p>
                            </div>
                        </a>
                    <?php endif; ?>

                    <?php if($totalNotifications === 0): ?>
                        <div class="py-6 text-center text-navy-400">
                            <svg class="h-8 w-8 mx-auto text-emerald-500/80 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="text-xs font-semibold text-navy-800">All caught up!</p>
                            <p class="text-[11px] text-navy-500">No pending actions required.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        
        <div class="h-6 w-px bg-navy-200"></div>

        
        <div class="relative" x-data="{ open: false }" @click.outside="open = false">
            <button
                type="button"
                @click="open = !open"
                class="flex items-center gap-2.5 rounded-xl p-1 hover:bg-navy-50 transition focus:outline-none"
                aria-label="User menu"
            >
                <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-gradient-to-br from-maroon-700 to-navy-900 font-serif text-xs font-bold text-gold-300 ring-2 ring-gold-400/50 shadow-xs">
                    <?php echo e(strtoupper(substr(Auth::user()->name, 0, 2))); ?>

                </span>
                <div class="hidden text-left lg:block">
                    <p class="text-xs font-bold text-navy-900 leading-tight"><?php echo e(Auth::user()->name); ?></p>
                    <p class="text-[10px] font-medium text-navy-500">Administrator</p>
                </div>
                <svg class="hidden lg:block h-3.5 w-3.5 text-navy-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                </svg>
            </button>

            <div
                x-show="open"
                x-transition:enter="transition ease-out duration-150"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-100"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="absolute right-0 mt-2 w-56 origin-top-right rounded-2xl bg-white p-2 shadow-xl ring-1 ring-black/5 focus:outline-none z-50 border border-navy-100"
                style="display: none;"
            >
                <div class="px-3 py-2 border-b border-navy-100 mb-1">
                    <p class="text-xs font-bold text-navy-950"><?php echo e(Auth::user()->name); ?></p>
                    <p class="text-[10px] text-navy-500 truncate"><?php echo e(Auth::user()->email); ?></p>
                </div>

                <a href="<?php echo e(route('admin.settings.index')); ?>" class="flex items-center gap-2.5 rounded-xl px-3 py-2 text-xs font-medium text-navy-700 hover:bg-navy-50 hover:text-navy-950 transition">
                    <svg class="h-4 w-4 text-navy-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span>System Settings</span>
                </a>

                <a href="<?php echo e(route('home')); ?>" target="_blank" class="flex items-center gap-2.5 rounded-xl px-3 py-2 text-xs font-medium text-navy-700 hover:bg-navy-50 hover:text-navy-950 transition">
                    <svg class="h-4 w-4 text-navy-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                    </svg>
                    <span>Public Website</span>
                </a>

                <div class="my-1 border-t border-navy-100"></div>

                <form method="POST" action="<?php echo e(route('admin.logout')); ?>">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button
                        type="submit"
                        class="flex w-full items-center gap-2.5 rounded-xl px-3 py-2 text-xs font-medium text-rose-600 hover:bg-rose-50 transition"
                    >
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        <span>Sign Out</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>
<?php /**PATH C:\xampp\htdocs\ProDo\EDAA\resources\views/components/admin/topbar.blade.php ENDPATH**/ ?>