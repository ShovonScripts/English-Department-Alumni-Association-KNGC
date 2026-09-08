<?php if (isset($component)) { $__componentOriginalc8c9fd5d7827a77a31381de67195f0c3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc8c9fd5d7827a77a31381de67195f0c3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.admin','data' => ['title' => 'Site Settings']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.admin'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Site Settings']); ?>
    <div class="mb-8">
        <h1 class="font-serif text-3xl font-semibold tracking-tight text-navy-950">Site Settings</h1>
        <p class="mt-1 text-sm text-ink-soft">
            Manage site branding, announcement bar, and social links.
        </p>
    </div>

    <?php if(session('status')): ?>
        <div class="mb-6 flex items-center gap-3 rounded-md border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800" role="status">
            <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <?php echo e(session('status')); ?>

        </div>
    <?php endif; ?>

    <?php if($errors->any()): ?>
        <div class="mb-6 rounded-md border border-maroon-200 bg-maroon-50 px-4 py-3 text-sm font-medium text-maroon-800">
            <ul class="list-inside list-disc">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST" action="<?php echo e(route('admin.settings.update')); ?>" enctype="multipart/form-data" class="space-y-6">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        
        <div class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm">
            <div class="flex items-center gap-3 mb-6">
                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-navy-100">
                    <svg class="h-5 w-5 text-navy-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-lg font-semibold text-navy-950">Site Identity</h2>
                    <p class="text-sm text-ink-soft">Configure your site name and tagline.</p>
                </div>
            </div>

            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="site_name" class="mb-1.5 block text-sm font-semibold text-navy-950">
                        Full Name <span class="text-maroon-600">*</span>
                    </label>
                    <input
                        type="text"
                        id="site_name"
                        name="site_name"
                        value="<?php echo e(old('site_name', config('site.name'))); ?>"
                        placeholder="English Department Alumni Association KNGC"
                        required
                        class="focus-ring w-full rounded-md border border-navy-200 bg-white px-4 py-2.5 text-sm text-navy-950 placeholder-navy-400"
                    >
                    <p class="mt-1 text-xs text-ink-soft">Shown in browser tab and SEO meta tags.</p>
                </div>
                <div>
                    <label for="site_short_name" class="mb-1.5 block text-sm font-semibold text-navy-950">
                        Short Name <span class="text-maroon-600">*</span>
                    </label>
                    <input
                        type="text"
                        id="site_short_name"
                        name="site_short_name"
                        value="<?php echo e(old('site_short_name', config('site.short_name'))); ?>"
                        placeholder="EDAA-KNGC"
                        required
                        class="focus-ring w-full rounded-md border border-navy-200 bg-white px-4 py-2.5 text-sm text-navy-950 placeholder-navy-400"
                    >
                    <p class="mt-1 text-xs text-ink-soft">Shown in navbar and footer.</p>
                </div>
            </div>

            <div class="mt-5">
                <label for="site_tagline" class="mb-1.5 block text-sm font-semibold text-navy-950">Tagline</label>
                <input
                    type="text"
                    id="site_tagline"
                    name="site_tagline"
                    value="<?php echo e(old('site_tagline', \App\Models\SiteSetting::get('site_tagline', config('site.tagline')))); ?>"
                    placeholder="Connected by English. United by Memories."
                    class="focus-ring w-full rounded-md border border-navy-200 bg-white px-4 py-2.5 text-sm text-navy-950 placeholder-navy-400"
                >
            </div>

            <div class="mt-5">
                <label for="site_description" class="mb-1.5 block text-sm font-semibold text-navy-950">Description</label>
                <textarea
                    id="site_description"
                    name="site_description"
                    rows="3"
                    maxlength="1000"
                    placeholder="About your association..."
                    class="focus-ring w-full rounded-md border border-navy-200 bg-white px-4 py-2.5 text-sm text-navy-950 placeholder-navy-400 resize-none"
                ><?php echo e(old('site_description', \App\Models\SiteSetting::get('site_description', config('site.description')))); ?></textarea>
                <p class="mt-1 text-xs text-ink-soft">Used in SEO meta tags and about sections.</p>
            </div>
        </div>

        
        <div class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm">
            <div class="flex items-center gap-3 mb-6">
                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-gold-100">
                    <svg class="h-5 w-5 text-gold-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-lg font-semibold text-navy-950">Logo & Favicon</h2>
                    <p class="text-sm text-ink-soft">Upload your brand assets.</p>
                </div>
            </div>

            <div class="grid gap-6 lg:grid-cols-3">
                
                <div class="rounded-lg border border-navy-100 bg-navy-50/50 p-4">
                    <label class="mb-3 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Favicon</label>
                    <div class="flex flex-col items-center">
                        <div class="mb-3 flex h-16 w-16 items-center justify-center rounded-lg border-2 border-dashed border-navy-200 bg-white">
                            <?php if(\App\Models\SiteSetting::get('favicon_path')): ?>
                                <img src="<?php echo e(Storage::disk('public')->url(\App\Models\SiteSetting::get('favicon_path'))); ?>" alt="Current favicon" class="h-12 w-12 rounded object-contain">
                            <?php else: ?>
                                <svg class="h-8 w-8 text-navy-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5V9.75m0 0l3 3m-3-3l-3 3M6.75 19.5a4.5 4.5 0 01-1.41-8.775 5.25 5.25 0 0110.233-2.33 3 3 0 013.758 3.848A3.752 3.752 0 0118 19.5H6.75z" />
                                </svg>
                            <?php endif; ?>
                        </div>
                        <input
                            type="file"
                            id="favicon"
                            name="favicon"
                            accept="image/x-icon,image/png,image/svg+xml"
                            class="w-full text-xs text-ink-soft file:mr-2 file:rounded file:border-0 file:bg-navy-900 file:px-3 file:py-1.5 file:text-xs file:font-semibold file:text-white hover:file:bg-navy-800"
                        >
                        <p class="mt-2 text-center text-xs text-ink-soft">SVG, PNG or ICO<br>32×32px recommended</p>
                    </div>
                </div>

                
                <div class="rounded-lg border border-navy-100 bg-navy-50/50 p-4">
                    <label class="mb-3 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Logo (Light BG)</label>
                    <div class="flex flex-col items-center">
                        <div class="mb-3 flex h-16 w-full items-center justify-center rounded-lg border-2 border-dashed border-navy-200 bg-white p-2">
                            <?php if(\App\Models\SiteSetting::get('logo_light_path')): ?>
                                <img src="<?php echo e(Storage::disk('public')->url(\App\Models\SiteSetting::get('logo_light_path'))); ?>" alt="Current light logo" class="max-h-12 w-auto object-contain">
                            <?php else: ?>
                                <svg class="h-8 w-8 text-navy-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 21h16.5a1.5 1.5 0 001.5-1.5V5.25a1.5 1.5 0 00-1.5-1.5H3.75a1.5 1.5 0 00-1.5 1.5v14.25a1.5 1.5 0 001.5 1.5z" />
                                </svg>
                            <?php endif; ?>
                        </div>
                        <input
                            type="file"
                            id="logo_light"
                            name="logo_light"
                            accept="image/png,image/jpeg,image/svg+xml"
                            class="w-full text-xs text-ink-soft file:mr-2 file:rounded file:border-0 file:bg-navy-900 file:px-3 file:py-1.5 file:text-xs file:font-semibold file:text-white hover:file:bg-navy-800"
                        >
                        <p class="mt-2 text-center text-xs text-ink-soft">PNG or SVG<br>For light backgrounds</p>
                    </div>
                </div>

                
                <div class="rounded-lg border border-navy-100 bg-navy-50/50 p-4">
                    <label class="mb-3 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Logo (Dark BG)</label>
                    <div class="flex flex-col items-center">
                        <div class="mb-3 flex h-16 w-full items-center justify-center rounded-lg border-2 border-dashed border-navy-200 bg-navy-900 p-2">
                            <?php if(\App\Models\SiteSetting::get('logo_dark_path')): ?>
                                <img src="<?php echo e(Storage::disk('public')->url(\App\Models\SiteSetting::get('logo_dark_path'))); ?>" alt="Current dark logo" class="max-h-12 w-auto object-contain">
                            <?php else: ?>
                                <svg class="h-8 w-8 text-white/30" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 21h16.5a1.5 1.5 0 001.5-1.5V5.25a1.5 1.5 0 00-1.5-1.5H3.75a1.5 1.5 0 00-1.5 1.5v14.25a1.5 1.5 0 001.5 1.5z" />
                                </svg>
                            <?php endif; ?>
                        </div>
                        <input
                            type="file"
                            id="logo_dark"
                            name="logo_dark"
                            accept="image/png,image/jpeg,image/svg+xml"
                            class="w-full text-xs text-ink-soft file:mr-2 file:rounded file:border-0 file:bg-navy-900 file:px-3 file:py-1.5 file:text-xs file:font-semibold file:text-white hover:file:bg-navy-800"
                        >
                        <p class="mt-2 text-center text-xs text-ink-soft">PNG or SVG<br>For navbar & footer</p>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm">
            <div class="flex items-center gap-3 mb-6">
                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-emerald-100">
                    <svg class="h-5 w-5 text-emerald-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-lg font-semibold text-navy-950">Contact Information</h2>
                    <p class="text-sm text-ink-soft">Shown in footer and contact sections.</p>
                </div>
            </div>

            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="contact_email" class="mb-1.5 block text-sm font-semibold text-navy-950">Email Address</label>
                    <input
                        type="email"
                        id="contact_email"
                        name="contact_email"
                        value="<?php echo e(old('contact_email', \App\Models\SiteSetting::get('contact_email', config('site.email')))); ?>"
                        placeholder="alumni@edaa-kngc.org"
                        class="focus-ring w-full rounded-md border border-navy-200 bg-white px-4 py-2.5 text-sm text-navy-950 placeholder-navy-400"
                    >
                </div>
                <div>
                    <label for="contact_phone" class="mb-1.5 block text-sm font-semibold text-navy-950">Phone Number</label>
                    <input
                        type="text"
                        id="contact_phone"
                        name="contact_phone"
                        value="<?php echo e(old('contact_phone', \App\Models\SiteSetting::get('contact_phone', config('site.phone')))); ?>"
                        placeholder="+880 1XXX-XXXXXX"
                        class="focus-ring w-full rounded-md border border-navy-200 bg-white px-4 py-2.5 text-sm text-navy-950 placeholder-navy-400"
                    >
                </div>
            </div>

            <div class="mt-5">
                <label for="contact_address" class="mb-1.5 block text-sm font-semibold text-navy-950">Address</label>
                <textarea
                    id="contact_address"
                    name="contact_address"
                    rows="2"
                    maxlength="500"
                    placeholder="Head Office: English Department, Kabi Nazrul Government College, Laxmi Bazar, Dhaka 1100, Bangladesh"
                    class="focus-ring w-full rounded-md border border-navy-200 bg-white px-4 py-2.5 text-sm text-navy-950 placeholder-navy-400 resize-none"
                ><?php echo e(old('contact_address', \App\Models\SiteSetting::get('contact_address', config('site.address')))); ?></textarea>
            </div>
        </div>

        
        <div class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm">
            <div class="flex items-center gap-3 mb-6">
                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-maroon-100">
                    <svg class="h-5 w-5 text-maroon-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-lg font-semibold text-navy-950">Announcement Bar</h2>
                    <p class="text-sm text-ink-soft">Display a scrolling announcement banner at the top of the site.</p>
                </div>
            </div>

            <div class="flex items-center justify-between rounded-lg bg-navy-50 px-4 py-3">
                <label for="announcement_enabled" class="flex items-center gap-3 cursor-pointer">
                    <input
                        type="checkbox"
                        name="announcement_enabled"
                        id="announcement_enabled"
                        value="1"
                        <?php echo e($announcementEnabled ? 'checked' : ''); ?>

                        class="focus-ring h-5 w-5 rounded border-navy-300 text-maroon-600"
                    >
                    <span class="text-sm font-medium text-navy-950">Enable Announcement Bar</span>
                </label>
                <span class="rounded-full px-2.5 py-0.5 text-xs font-medium <?php echo e($announcementEnabled ? 'bg-emerald-100 text-emerald-700' : 'bg-navy-100 text-navy-500'); ?>">
                    <?php echo e($announcementEnabled ? 'Active' : 'Inactive'); ?>

                </span>
            </div>

            <div class="mt-4">
                <label for="announcement_text" class="mb-1.5 block text-sm font-semibold text-navy-950">Announcement Text</label>
                <textarea
                    id="announcement_text"
                    name="announcement_text"
                    rows="3"
                    maxlength="500"
                    placeholder="e.g. Annual reunion registration is now open!"
                    class="focus-ring w-full rounded-md border border-navy-200 bg-white px-4 py-2.5 text-sm text-navy-950 placeholder-navy-400 resize-none"
                ><?php echo e($announcementText); ?></textarea>
                <div class="mt-1 flex items-center justify-between">
                    <p class="text-xs text-ink-soft">This text will scroll across the announcement bar.</p>
                    <span class="text-xs text-ink-soft"><span id="char-count">0</span>/500</span>
                </div>
            </div>
        </div>

        
        <div class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm">
            <div class="flex items-center gap-3 mb-6">
                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-100">
                    <svg class="h-5 w-5 text-blue-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-lg font-semibold text-navy-950">Social Links</h2>
                    <p class="text-sm text-ink-soft">Add your social media profile URLs.</p>
                </div>
            </div>

            <div class="grid gap-4 sm:grid-cols-2">
                
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-[#1877F2]/10">
                        <svg class="h-5 w-5 text-[#1877F2]" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <label for="social_facebook" class="mb-1 block text-xs font-semibold text-navy-950">Facebook Page</label>
                        <input
                            type="url"
                            id="social_facebook"
                            name="social_facebook"
                            value="<?php echo e(old('social_facebook', \App\Models\SiteSetting::get('social_facebook', ''))); ?>"
                            placeholder="https://facebook.com/..."
                            class="focus-ring w-full rounded-md border border-navy-200 bg-white px-3 py-2 text-sm text-navy-950 placeholder-navy-400"
                        >
                    </div>
                </div>

                
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-[#1877F2]/10">
                        <svg class="h-5 w-5 text-[#1877F2]" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <label for="social_facebook_group" class="mb-1 block text-xs font-semibold text-navy-950">Facebook Group</label>
                        <input
                            type="url"
                            id="social_facebook_group"
                            name="social_facebook_group"
                            value="<?php echo e(old('social_facebook_group', \App\Models\SiteSetting::get('social_facebook_group', ''))); ?>"
                            placeholder="https://facebook.com/groups/..."
                            class="focus-ring w-full rounded-md border border-navy-200 bg-white px-3 py-2 text-sm text-navy-950 placeholder-navy-400"
                        >
                    </div>
                </div>

                
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-black/5">
                        <svg class="h-5 w-5 text-black" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <label for="social_twitter" class="mb-1 block text-xs font-semibold text-navy-950">Twitter / X</label>
                        <input
                            type="url"
                            id="social_twitter"
                            name="social_twitter"
                            value="<?php echo e(old('social_twitter', \App\Models\SiteSetting::get('social_twitter', ''))); ?>"
                            placeholder="https://x.com/..."
                            class="focus-ring w-full rounded-md border border-navy-200 bg-white px-3 py-2 text-sm text-navy-950 placeholder-navy-400"
                        >
                    </div>
                </div>

                
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-[#0A66C2]/10">
                        <svg class="h-5 w-5 text-[#0A66C2]" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <label for="social_linkedin" class="mb-1 block text-xs font-semibold text-navy-950">LinkedIn</label>
                        <input
                            type="url"
                            id="social_linkedin"
                            name="social_linkedin"
                            value="<?php echo e(old('social_linkedin', \App\Models\SiteSetting::get('social_linkedin', ''))); ?>"
                            placeholder="https://linkedin.com/in/..."
                            class="focus-ring w-full rounded-md border border-navy-200 bg-white px-3 py-2 text-sm text-navy-950 placeholder-navy-400"
                        >
                    </div>
                </div>

                
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-[#FF0000]/10">
                        <svg class="h-5 w-5 text-[#FF0000]" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <label for="social_youtube" class="mb-1 block text-xs font-semibold text-navy-950">YouTube</label>
                        <input
                            type="url"
                            id="social_youtube"
                            name="social_youtube"
                            value="<?php echo e(old('social_youtube', \App\Models\SiteSetting::get('social_youtube', ''))); ?>"
                            placeholder="https://youtube.com/..."
                            class="focus-ring w-full rounded-md border border-navy-200 bg-white px-3 py-2 text-sm text-navy-950 placeholder-navy-400"
                        >
                    </div>
                </div>

                
                <div class="flex items-center gap-3 sm:col-span-2 sm:w-1/2">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-gradient-to-br from-[#F56040] via-[#C13584] to-[#833AB4]/10">
                        <svg class="h-5 w-5 text-[#C13584]" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <label for="social_instagram" class="mb-1 block text-xs font-semibold text-navy-950">Instagram</label>
                        <input
                            type="url"
                            id="social_instagram"
                            name="social_instagram"
                            value="<?php echo e(old('social_instagram', \App\Models\SiteSetting::get('social_instagram', ''))); ?>"
                            placeholder="https://instagram.com/..."
                            class="focus-ring w-full rounded-md border border-navy-200 bg-white px-3 py-2 text-sm text-navy-950 placeholder-navy-400"
                        >
                    </div>
                </div>
            </div>
        </div>

        
        <div class="flex items-center justify-end gap-3 rounded-lg border border-navy-100 bg-white px-6 py-4 shadow-sm">
            <a href="<?php echo e(route('admin.dashboard')); ?>" class="focus-ring inline-flex items-center justify-center rounded-md px-4 py-2.5 text-sm font-semibold text-navy-600 transition-colors hover:bg-navy-50">
                Cancel
            </a>
            <?php if (isset($component)) { $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.button','data' => ['type' => 'submit','variant' => 'gold']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'submit','variant' => 'gold']); ?>
                Save Settings
             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561)): ?>
<?php $attributes = $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561; ?>
<?php unset($__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald0f1fd2689e4bb7060122a5b91fe8561)): ?>
<?php $component = $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561; ?>
<?php unset($__componentOriginald0f1fd2689e4bb7060122a5b91fe8561); ?>
<?php endif; ?>
        </div>
    </form>

    <?php $__env->startPush('scripts'); ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const textarea = document.getElementById('announcement_text');
            const charCount = document.getElementById('char-count');
            
            function updateCount() {
                charCount.textContent = textarea.value.length;
            }
            
            textarea.addEventListener('input', updateCount);
            updateCount();
        });
    </script>
    <?php $__env->stopPush(); ?>
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
<?php /**PATH C:\xampp\htdocs\ProDo\EDAA\resources\views\admin\settings\index.blade.php ENDPATH**/ ?>