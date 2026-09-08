<?php if (isset($component)) { $__componentOriginal5863877a5171c196453bfa0bd807e410 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5863877a5171c196453bfa0bd807e410 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.app','data' => ['title' => 'Membership Card']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.app'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Membership Card')]); ?>
    <?php
        $cardLogoPath = \App\Models\SiteSetting::get('logo_light_path') ?: \App\Models\SiteSetting::get('logo_dark_path');
        $cardLogoUrl = $cardLogoPath ? Storage::disk('public')->url($cardLogoPath) : null;
        $cardShortName = \App\Models\SiteSetting::get('site_short_name') ?: config('site.short_name', 'EDAA-KNGC');
    ?>
    
    <section class="relative bg-navy-950 py-12 lg:py-14 overflow-hidden border-b border-navy-900/60 no-print">
        <div class="absolute inset-0 hero-gradient-mesh opacity-90"></div>
        <div class="absolute -top-24 -right-24 h-96 w-96 rounded-full bg-gold-500/10 blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -left-24 h-96 w-96 rounded-full bg-maroon-700/15 blur-3xl pointer-events-none"></div>

        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <div class="flex items-center gap-2.5 mb-1.5">
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-gold-500/15 px-2.5 py-0.5 text-xs font-semibold text-gold-300 ring-1 ring-gold-500/30">
                            <span class="h-1.5 w-1.5 rounded-full bg-gold-400"></span>
                            Official Credential
                        </span>
                    </div>
                    <h1 class="font-serif text-2xl sm:text-3xl font-bold tracking-tight text-white">Membership Card</h1>
                    <p class="mt-1 text-sm text-white/60">Your digital and printable EDAA-KNGC member identity credential</p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="<?php echo e(route('member.dashboard')); ?>" class="focus-ring inline-flex items-center gap-2 rounded-lg bg-white/10 px-4 py-2 text-xs font-semibold text-white/90 ring-1 ring-white/15 transition-all hover:bg-white/15">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5h3m-6.75 2.25h10.5a2.25 2.25 0 002.25-2.25v-15a2.25 2.25 0 00-2.25-2.25H6.75A2.25 2.25 0 004.5 4.5v15a2.25 2.25 0 002.25 2.25z"/>
                        </svg>
                        Dashboard
                    </a>
                </div>
            </div>
        </div>
    </section>

    
    <section class="py-10 bg-slate-50/60 min-h-screen">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                
                <aside class="lg:col-span-1 no-print">
                    <div class="rounded-2xl border border-navy-100/70 bg-white p-4 shadow-sm sticky top-24">
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
                    
                    <div class="no-print rounded-2xl border border-navy-100/80 bg-white p-4 shadow-sm flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        
                        <div class="flex items-center gap-2.5">
                            <button type="button" onclick="window.print()" class="focus-ring inline-flex items-center gap-2 rounded-xl bg-maroon-700 px-5 py-2.5 text-xs font-bold uppercase tracking-wider text-white shadow-sm hover:bg-maroon-800 hover:shadow-md hover:-translate-y-0.5 active:translate-y-0 transition-all duration-200">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z"/>
                                </svg>
                                Print Card
                            </button>
                            <a href="<?php echo e(route('member.membership')); ?>" class="focus-ring inline-flex items-center gap-2 rounded-xl border border-navy-200 bg-white px-4 py-2.5 text-xs font-semibold text-navy-800 shadow-xs hover:bg-navy-50 hover:border-navy-300 transition-all">
                                Membership Details
                            </a>
                        </div>
                    </div>

                    
                    <div class="print-container flex flex-col items-center justify-center py-4 space-y-8">
                        
                        <div class="w-full max-w-xl">
                            <div class="card-aspect relative overflow-hidden rounded-3xl bg-gradient-to-br from-navy-950 via-navy-900 to-navy-950 p-7 sm:p-9 text-white shadow-2xl ring-1 ring-gold-400/40 print:shadow-none print:ring-1 print:ring-navy-300">
                                
                                <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,_var(--tw-gradient-stops))] from-gold-500/15 via-transparent to-maroon-700/20 pointer-events-none"></div>
                                <div class="absolute -right-20 -bottom-20 h-64 w-64 rounded-full bg-gold-400/10 blur-2xl pointer-events-none"></div>
                                <div class="absolute -left-20 -top-20 h-64 w-64 rounded-full bg-maroon-600/15 blur-2xl pointer-events-none"></div>

                                
                                <?php if($cardLogoUrl): ?>
                                    <div class="absolute inset-0 flex items-center justify-center pointer-events-none select-none" aria-hidden="true">
                                        <img src="<?php echo e($cardLogoUrl); ?>" alt="" class="h-72 w-72 sm:h-80 sm:w-80 object-contain opacity-[0.05]" style="filter: drop-shadow(0 0 30px rgba(199,151,44,0.10));">
                                    </div>
                                <?php endif; ?>

                                <div class="relative z-10 flex flex-col justify-between h-full min-h-[300px]">
                                    
                                    <div class="flex items-start justify-between gap-4 border-b border-white/10 pb-5">
                                        <div class="flex items-center gap-3.5">
                                            <?php if($cardLogoUrl): ?>
                                                <img src="<?php echo e($cardLogoUrl); ?>" alt="<?php echo e($cardShortName); ?>" class="h-12 w-12 shrink-0 rounded-xl object-contain ring-1 ring-gold-400/50 shadow-lg" style="filter: drop-shadow(0 2px 10px rgba(199,151,44,0.35));">
                                            <?php else: ?>
                                                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-gradient-to-br from-maroon-700 to-maroon-900 font-serif text-sm font-bold text-white shadow-md ring-1 ring-gold-400/60">
                                                    EDAA
                                                </div>
                                            <?php endif; ?>
                                            <div>
                                                <p class="font-serif text-sm sm:text-base font-bold tracking-tight text-white">EDAA-KNGC</p>
                                                <p class="text-[10px] sm:text-[11px] font-medium text-gold-300/80 uppercase tracking-widest">English Dept Alumni Association</p>
                                                <p class="text-[9px] text-white/40 tracking-wider">Govt. Kabi Nazrul College, Dhaka</p>
                                            </div>
                                        </div>

                                        <div class="text-right">
                                            <span class="inline-flex items-center rounded-full bg-gold-500/20 px-3 py-1 text-[11px] font-bold tracking-wider uppercase text-gold-300 ring-1 ring-gold-400/40 backdrop-blur-xs">
                                                <?php echo e($membership->tier?->name ?? 'Silver'); ?>

                                            </span>
                                            <p class="text-[9px] text-white/40 mt-1 uppercase tracking-widest"><?php echo e($membership->type?->name ?? 'Regular'); ?></p>
                                        </div>
                                    </div>

                                    
                                    <div class="my-6 flex items-center gap-6">
                                        
                                        <div class="relative shrink-0">
                                            <div class="h-24 w-24 sm:h-26 sm:w-26 overflow-hidden rounded-2xl bg-white/10 ring-2 ring-gold-400/50 shadow-xl">
                                                <?php if($alumni->profile_photo): ?>
                                                    <img src="<?php echo e($alumni->profile_photo_url); ?>" alt="<?php echo e($alumni->full_name); ?>" class="h-full w-full object-cover">
                                                <?php else: ?>
                                                    <div class="flex h-full w-full items-center justify-center font-serif text-3xl font-bold text-white/60 bg-gradient-to-br from-navy-800 to-navy-900">
                                                        <?php echo e(strtoupper(substr($alumni->full_name, 0, 2))); ?>

                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            
                                            <div class="absolute -bottom-2.5 -right-2.5 flex h-7 w-9 items-center justify-center rounded bg-gradient-to-r from-amber-300 via-amber-200 to-yellow-400 shadow-sm ring-1 ring-amber-500/50">
                                                <div class="h-4 w-6 border border-amber-600/40 rounded-xs flex items-center justify-center">
                                                    <div class="h-2 w-3 border-r border-l border-amber-600/40"></div>
                                                </div>
                                            </div>
                                        </div>

                                        
                                        <div class="min-w-0 flex-1">
                                            <h2 class="font-serif text-xl sm:text-2xl font-bold tracking-tight text-white truncate">
                                                <?php echo e($alumni->full_name); ?>

                                            </h2>

                                            <?php if($alumni->profession || $alumni->organization): ?>
                                                <p class="text-xs text-white/70 truncate mt-1">
                                                    <?php echo e($alumni->profession); ?><?php if($alumni->organization): ?> <span class="text-white/40">at</span> <?php echo e($alumni->organization); ?><?php endif; ?>
                                                </p>
                                            <?php endif; ?>

                                            <div class="mt-3 flex flex-wrap items-center gap-x-4 gap-y-1 text-xs">
                                                <?php if($alumni->batch): ?>
                                                    <div class="text-white/60">
                                                        <span class="text-[10px] uppercase tracking-wider text-white/40 block">Batch</span>
                                                        <span class="font-semibold text-white"><?php echo e($alumni->batch); ?></span>
                                                    </div>
                                                <?php endif; ?>
                                                <div>
                                                    <span class="text-[10px] uppercase tracking-wider text-white/40 block">Student ID</span>
                                                    <span class="font-mono font-semibold text-white"><?php echo e($alumni->student_id); ?></span>
                                                </div>
                                                <div>
                                                    <span class="text-[10px] uppercase tracking-wider text-white/40 block">Status</span>
                                                    <span class="font-semibold <?php echo e($membership->status === 'active' ? 'text-emerald-400' : 'text-amber-400'); ?> capitalize">
                                                        <?php echo e($membership->status); ?>

                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    
                                    <div class="flex items-end justify-between border-t border-white/10 pt-4 text-xs">
                                        <div>
                                            <p class="text-[9px] uppercase tracking-widest text-white/40">Membership ID</p>
                                            <p class="font-mono text-sm sm:text-base font-bold tracking-wider text-gold-300">
                                                <?php echo e($membership->membership_number); ?>

                                            </p>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-[9px] uppercase tracking-widest text-white/40">Member Since</p>
                                            <p class="font-semibold text-white/90">
                                                <?php echo e($membership->joined_at?->format('M Y') ?? '—'); ?>

                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        
                        <div class="w-full max-w-xl">
                            <div class="card-aspect relative overflow-hidden rounded-3xl bg-gradient-to-br from-navy-950 via-navy-900 to-navy-950 p-7 sm:p-9 text-white shadow-2xl ring-1 ring-gold-400/40 print:shadow-none print:ring-1 print:ring-navy-300">
                                
                                <div class="absolute top-8 left-0 right-0 h-12 bg-black/90 ring-1 ring-white/5"></div>

                                
                                <?php if($cardLogoUrl): ?>
                                    <div class="absolute inset-0 flex items-center justify-center pointer-events-none select-none mt-10" aria-hidden="true">
                                        <img src="<?php echo e($cardLogoUrl); ?>" alt="" class="h-72 w-72 sm:h-80 sm:w-80 object-contain opacity-[0.04]" style="filter: drop-shadow(0 0 30px rgba(199,151,44,0.10));">
                                    </div>
                                <?php endif; ?>

                                <div class="relative z-10 flex flex-col justify-between h-full min-h-[300px] pt-14">
                                    
                                    <div class="my-4">
                                        <div class="flex items-center gap-3">
                                            <div class="flex-1 rounded-lg bg-slate-100 px-4 py-2 text-slate-700 font-serif italic text-sm tracking-wider shadow-inner flex items-center justify-between">
                                                <span><?php echo e($alumni->full_name); ?></span>
                                                <span class="text-[9px] text-slate-400 font-sans not-italic uppercase tracking-widest">Authorized Signature</span>
                                            </div>
                                            <div class="rounded-lg bg-slate-800 px-3 py-2 text-center font-mono text-xs text-gold-300 font-bold tracking-widest ring-1 ring-white/10">
                                                EDAA
                                            </div>
                                        </div>
                                    </div>

                                    
                                    <div class="space-y-2 text-[10px] text-white/50 leading-relaxed">
                                        <p>
                                            This card is the official property of the English Department Alumni Association (EDAA), Govt. Kabi Nazrul College, Dhaka.
                                            It is non-transferable and must be presented upon request for alumni services, campus access, and events.
                                        </p>
                                        <p class="text-[9px] text-white/40">
                                            If found, please return to: Department of English, Govt. Kabi Nazrul College, Laxmibazar, Dhaka-1100, Bangladesh.
                                        </p>
                                    </div>

                                    
                                    <div class="flex items-center justify-between border-t border-white/10 pt-4 mt-3">
                                        <div>
                                            <p class="text-[9px] uppercase tracking-widest text-gold-300/70">Official Member Identity</p>
                                            <p class="font-mono text-xs text-white/60 tracking-wider">edaa-kngc.org</p>
                                        </div>
                                        <div class="text-right font-mono text-xs text-white/40 tracking-widest">
                                            <?php echo e($membership->membership_number); ?>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    
                    <div class="no-print rounded-2xl border border-navy-100/70 bg-white p-6 shadow-sm flex items-start gap-4">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-gold-50 text-gold-700 ring-1 ring-gold-200">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/>
                            </svg>
                        </div>
                        <div class="text-xs text-ink-soft leading-relaxed">
                            <h3 class="font-semibold text-sm text-navy-950 mb-1">Print & Physical ID Guidelines</h3>
                            <p>
                                When printing, ensure your browser print dialog has <strong>Background Graphics</strong> enabled for optimal colors and golden accents.
                                The card is proportioned to fit standard wallet ID card dimensions (CR-80 standard).
                            </p>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </section>

    
    <style>
        @media print {
            @page {
                size: A4 portrait;
                margin: 1.5cm;
            }
            body {
                background: #ffffff !important;
                color: #0f172a !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            header, footer, nav, aside, .no-print, #main-content > header {
                display: none !important;
            }
            .print-container {
                display: block !important;
                padding: 0 !important;
                margin: 0 auto !important;
            }
            #membership-card-front,
            #membership-card-back {
                display: block !important;
                page-break-inside: avoid;
                margin-bottom: 2rem !important;
                max-width: 480px !important;
                margin-left: auto !important;
                margin-right: auto !important;
                border: 1px solid #cbd5e1 !important;
                border-radius: 1.25rem !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
        }
    </style>
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
<?php /**PATH C:\xampp\htdocs\ProDo\EDAA\resources\views\member\membership\card.blade.php ENDPATH**/ ?>