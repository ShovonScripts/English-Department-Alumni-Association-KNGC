document.addEventListener('DOMContentLoaded', function() {
    'use strict';

    // ============================
    // Admin Sidebar Toggle
    // ============================
    const adminLayout = document.getElementById('admin-layout');
    const sidebarBackdrop = document.getElementById('sidebar-backdrop');
    const sidebar = document.querySelector('aside[x-cloak]') || document.querySelector('.admin-sidebar');

    window.toggleSidebar = function() {
        if (!sidebar || !sidebarBackdrop) return;
        const isOpen = sidebar.classList.contains('translate-x-0');
        if (isOpen) {
            sidebar.classList.remove('translate-x-0');
            sidebar.classList.add('-translate-x-full');
            sidebarBackdrop.classList.add('hidden');
            sidebar.setAttribute('aria-hidden', 'true');
        } else {
            sidebar.classList.remove('-translate-x-full');
            sidebar.classList.add('translate-x-0');
            sidebarBackdrop.classList.remove('hidden');
            sidebar.removeAttribute('aria-hidden');
        }
    };

    if (sidebarBackdrop) {
        sidebarBackdrop.addEventListener('click', function() {
            if (sidebar) {
                sidebar.classList.remove('translate-x-0');
                sidebar.classList.add('-translate-x-full');
                sidebarBackdrop.classList.add('hidden');
                sidebar.setAttribute('aria-hidden', 'true');
            }
        });
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeCommandPalette();
            closeAllDropdowns();
        }
    });

    // ============================
    // Command Palette
    // ============================
    const commandItems = [
        { title: 'Dashboard', url: '{{ route('admin.dashboard') }}', category: 'Navigation', icon: 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6' },
        { title: 'Alumni Directory', url: '{{ route('admin.alumni.index') }}', category: 'Community', icon: 'M17 20h5v-2a3 3 0 00-5.4-1.7M9 20H4v-2a3 3 0 015.4-1.7M16 3.1a3 3 0 110 5.8M11 7a3 3 0 11-6 0 3 3 0 016 0z' },
        { title: 'Batches Management', url: '{{ route('admin.batches.index') }}', category: 'Community', icon: 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10' },
        { title: 'Members List', url: '{{ route('admin.members.index') }}', category: 'Community', icon: 'M12 4.35a2.65 2.65 0 110 5.3 2.65 2.65 0 010-5.3zM5 21v-1.6A5.4 5.4 0 0110.4 14h3.2A5.4 5.4 0 0119 19.4V21m2-9.5l1.6 1.6M21 5.5L19.4 7M3 11.5L4.6 13.1M5 5.5L6.6 7.1' },
        { title: 'Membership Applications', url: '{{ route('admin.membership-applications.index') }}', category: 'Community', icon: 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2' },
        { title: 'Correction Requests', url: '{{ route('admin.correction-requests.index') }}', category: 'Community', icon: 'M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z' },
        { title: 'Committees & Roles', url: '{{ route('admin.committee-types.index') }}', category: 'Community', icon: 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5' },
        { title: 'Events Calendar', url: '{{ route('admin.events.index') }}', category: 'Content', icon: 'M8 7V3m8 4V3M4 11h16M5 5h14a1 1 0 011 1v13a1 1 0 01-1 1H5a1 1 0 01-1-1V6a1 1 0 011-1z' },
        { title: 'Create New Event', url: '{{ route('admin.events.create') }}', category: 'Actions', icon: 'M12 4.5v15m7.5-7.5h-15' },
        { title: 'News & Announcements', url: '{{ route('admin.news.index') }}', category: 'Content', icon: 'M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7' },
        { title: 'Create News Article', url: '{{ route('admin.news.create') }}', category: 'Actions', icon: 'M12 4.5v15m7.5-7.5h-15' },
        { title: 'Alumni Stories', url: '{{ route('admin.stories.index') }}', category: 'Content', icon: 'M9.6 4C5.4 5.4 3 8.6 3 13.2V20h6.8' },
        { title: 'Photo Gallery', url: '{{ route('admin.gallery.index') }}', category: 'Content', icon: 'M4 16l4.586-4.586a2 2 0 012.828 0L16 16' },
        { title: 'Publications & Research', url: '{{ route('admin.publications.index') }}', category: 'Content', icon: 'M12 6.3v11.4m0-11.4A3.2 3.2 0 009.5 3.5H6.5v13' },
        { title: 'Financial Overview', url: '{{ route('admin.finance.index') }}', category: 'Finance', icon: 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2' },
        { title: 'Payments & Fee Dues', url: '{{ route('admin.payments.index') }}', category: 'Finance', icon: 'M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2' },
        { title: 'Record Payment', url: '{{ route('admin.payments.create') }}', category: 'Actions', icon: 'M12 4.5v15m7.5-7.5h-15' },
        { title: 'Association Expenses', url: '{{ route('admin.expenses.index') }}', category: 'Finance', icon: 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2' },
        { title: 'Record Expense', url: '{{ route('admin.expenses.create') }}', category: 'Actions', icon: 'M12 4.5v15m7.5-7.5h-15' },
        { title: 'Donor Leaderboard', url: '{{ route('admin.leaderboard.index') }}', category: 'Finance', icon: 'M5 3v4M3 5h4M6 17v4m-2-2h4' },
        { title: 'Contact Messages & Inquiries', url: '{{ route('admin.messages.index') }}', category: 'Inbox', icon: 'M3 8l7.89 5.26a2 2 0 002.22 0L21 8' },
        { title: 'Site Settings & Branding', url: '{{ route('admin.settings.index') }}', category: 'System', icon: 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0' },
        { title: 'View Live Public Site', url: '{{ route('home') }}', category: 'System', icon: 'M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10' }
    ];

    const commandOverlay = document.getElementById('command-palette-overlay');
    const commandPanel = document.getElementById('command-palette-panel');
    const commandInput = document.getElementById('command-palette-input');
    const commandList = document.getElementById('command-palette-list');
    const commandEmpty = document.getElementById('command-palette-empty');
    const commandQueryDisplay = document.getElementById('command-palette-query-display');

    let selectedIndex = 0;
    let filteredItems = commandItems.slice();

    function renderCommandItems() {
        commandList.innerHTML = '';
        filteredItems.forEach(function(item, index) {
            const isSelected = index === selectedIndex;
            const div = document.createElement('div');
            div.className = 'flex items-center justify-between rounded-xl px-3 py-2 text-xs font-medium transition-colors cursor-pointer ' + (isSelected ? 'bg-navy-50 text-navy-950 ring-1 ring-navy-200/70' : 'text-navy-700 hover:bg-navy-50/60');
            div.setAttribute('data-index', index);
            div.innerHTML = '<div class="flex items-center gap-3 min-w-0"><span class="flex h-7 w-7 items-center justify-center rounded-lg bg-navy-100 text-navy-700 shrink-0"><svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="' + item.icon + '" /></svg></span><span class="truncate font-semibold">' + item.title + '</span></div><span class="rounded-full bg-navy-100/70 px-2 py-0.5 text-[10px] font-medium text-navy-600">' + item.category + '</span>';
            div.addEventListener('click', function() {
                window.location.href = item.url;
            });
            div.addEventListener('mouseenter', function() {
                selectedIndex = index;
                renderCommandItems();
            });
            commandList.appendChild(div);
        });
    }

    function filterCommands(query) {
        const q = query.toLowerCase().trim();
        if (!q) {
            filteredItems = commandItems.slice();
        } else {
            filteredItems = commandItems.filter(function(item) {
                return item.title.toLowerCase().includes(q) || item.category.toLowerCase().includes(q);
            });
        }
        selectedIndex = 0;
        renderCommandItems();
        if (filteredItems.length === 0) {
            commandEmpty.classList.remove('hidden');
            commandQueryDisplay.textContent = query;
        } else {
            commandEmpty.classList.add('hidden');
        }
    }

    window.openCommandPalette = function() {
        commandOverlay.classList.remove('hidden');
        commandOverlay.classList.add('flex');
        commandInput.value = '';
        filterCommands('');
        setTimeout(function() { commandInput.focus(); }, 50);
    };

    function closeCommandPalette() {
        commandOverlay.classList.add('hidden');
        commandOverlay.classList.remove('flex');
        commandInput.value = '';
    }

    if (commandOverlay) {
        commandOverlay.addEventListener('click', function(e) {
            if (e.target === commandOverlay) {
                closeCommandPalette();
            }
        });
    }

    if (commandInput) {
        commandInput.addEventListener('input', function() {
            filterCommands(commandInput.value);
        });
        commandInput.addEventListener('keydown', function(e) {
            if (e.key === 'ArrowDown') {
                e.preventDefault();
                selectedIndex = Math.min(selectedIndex + 1, filteredItems.length - 1);
                renderCommandItems();
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                selectedIndex = Math.max(selectedIndex - 1, 0);
                renderCommandItems();
            } else if (e.key === 'Enter') {
                e.preventDefault();
                if (filteredItems[selectedIndex]) {
                    window.location.href = filteredItems[selectedIndex].url;
                }
            } else if (e.key === 'Escape') {
                closeCommandPalette();
            }
        });
    }

    document.addEventListener('keydown', function(e) {
        if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
            e.preventDefault();
            openCommandPalette();
        }
    });

    // ============================
    // Toast Notifications
    // ============================
    const toastContainer = document.getElementById('toast-container');

    function showToast(message, type) {
        type = type || 'success';
        const toast = document.createElement('div');
        const colors = {
            success: 'border-emerald-200 bg-emerald-50/95 text-emerald-950 ring-emerald-500/20',
            error: 'border-rose-200 bg-rose-50/95 text-rose-950 ring-rose-500/20',
            warning: 'border-amber-200 bg-amber-50/95 text-amber-950 ring-amber-500/20',
            info: 'border-navy-200 bg-white/95 text-navy-950 ring-navy-500/20'
        };
        const icons = {
            success: '<svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>',
            error: '<svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>',
            warning: '<svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>',
            info: '<svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" /></svg>'
        };
        toast.className = 'pointer-events-auto flex items-start gap-3 rounded-2xl border p-4 shadow-xl backdrop-blur-md ring-1 ' + colors[type];
        toast.innerHTML = '<div class="shrink-0 mt-0.5 flex h-6 w-6 items-center justify-center rounded-full bg-current text-white">' + icons[type] + '</div><div class="flex-1 min-w-0"><p class="text-xs font-medium leading-relaxed">' + message + '</p></div><button type="button" class="shrink-0 opacity-70 hover:opacity-100"><svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg></button>';
        toast.querySelector('button').addEventListener('click', function() {
            toast.remove();
        });
        toastContainer.appendChild(toast);
        setTimeout(function() {
            if (toast.parentNode) {
                toast.remove();
            }
        }, 5000);
    }

    @if (session('status'))
        showToast(@js(session('status')), 'success');
    @endif
    @if (session('success'))
        showToast(@js(session('success')), 'success');
    @endif
    @if (session('error'))
        showToast(@js(session('error')), 'error');
    @endif
    @if (session('warning'))
        showToast(@js(session('warning')), 'warning');
    @endif

    window.dispatchEvent(new CustomEvent('notify', {
        detail: {
            message: 'Test notification',
            type: 'info'
        }
    }));

    document.addEventListener('notify', function(e) {
        showToast(e.detail.message, e.detail.type || 'success');
    });

    // ============================
    // Admin Topbar Dropdowns
    // ============================
    function closeAllDropdowns() {
        document.querySelectorAll('.admin-dropdown-panel').forEach(function(panel) {
            panel.classList.add('opacity-0', 'invisible', 'translate-y-2', 'scale-95');
            panel.classList.remove('opacity-100', 'visible', 'translate-y-0', 'scale-100');
        });
        document.querySelectorAll('.admin-dropdown-chevron').forEach(function(chevron) {
            chevron.style.transform = '';
        });
        document.querySelectorAll('.admin-dropdown').forEach(function(dropdown) {
            dropdown.setAttribute('data-open', 'false');
        });
    }

    document.querySelectorAll('.admin-dropdown-toggle').forEach(function(toggle) {
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const dropdown = toggle.closest('.admin-dropdown');
            const panel = dropdown.querySelector('.admin-dropdown-panel');
            const chevron = dropdown.querySelector('.admin-dropdown-chevron');
            const isOpen = dropdown.getAttribute('data-open') === 'true';

            closeAllDropdowns();

            if (!isOpen) {
                panel.classList.remove('opacity-0', 'invisible', 'translate-y-2', 'scale-95');
                panel.classList.add('opacity-100', 'visible', 'translate-y-0', 'scale-100');
                chevron.style.transform = 'rotate(180deg)';
                dropdown.setAttribute('data-open', 'true');
            }
        });
    });

    document.querySelectorAll('.admin-dropdown-panel').forEach(function(panel) {
        panel.addEventListener('click', function(e) {
            if (e.target.closest('a') || e.target.closest('form')) {
                setTimeout(closeAllDropdowns, 50);
            }
        });
    });

    document.addEventListener('click', function(e) {
        if (!e.target.closest('.admin-dropdown')) {
            closeAllDropdowns();
        }
    });

    // ============================
    // Initial Setup
    // ============================
    renderCommandItems();

    @if (session('status') || session('success') || session('error') || session('warning'))
        setTimeout(function() {
            const type = '{{ session("error") ? "error" : (session("warning") ? "warning" : "success") }}';
            const message = '{{ session("status") ?? session("success") ?? session("error") ?? session("warning") }}';
            showToast(message, type);
        }, 100);
    @endif
});
