<?php if (isset($component)) { $__componentOriginalc8c9fd5d7827a77a31381de67195f0c3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc8c9fd5d7827a77a31381de67195f0c3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.admin','data' => ['title' => 'Global SEO Settings']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.admin'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Global SEO Settings']); ?>
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="font-serif text-3xl font-semibold tracking-tight text-navy-950">Global SEO Settings</h1>
                <p class="mt-1 text-sm text-ink-soft">
                    Configure default meta tags, Open Graph, and analytics for the entire site.
                </p>
            </div>
            <a href="<?php echo e(route('admin.seo.index')); ?>" class="focus-ring inline-flex items-center gap-2 rounded-lg border border-navy-200 bg-white px-4 py-2.5 text-sm font-semibold text-navy-950 transition-colors hover:bg-navy-50">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back
            </a>
        </div>
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

    <?php
        $inputClass = 'w-full rounded-md border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 placeholder-navy-400 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none';
    ?>

    <form method="POST" action="<?php echo e(route('admin.seo.settings.update')); ?>" enctype="multipart/form-data" class="space-y-6">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        
        <section class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm sm:p-8">
            <div class="flex items-center gap-3 mb-6">
                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-navy-100">
                    <svg class="h-5 w-5 text-navy-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-lg font-semibold text-navy-950">Default Meta Tags</h2>
                    <p class="text-sm text-ink-soft">These apply to pages without custom overrides.</p>
                </div>
            </div>

            <div class="grid gap-5 sm:grid-cols-2">
                <div class="sm:col-span-2">
                    <label for="seo_meta_title" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Default Meta Title</label>
                    <input type="text" id="seo_meta_title" name="seo_meta_title" value="<?php echo e(old('seo_meta_title', \App\Models\SiteSetting::get('seo_meta_title'))); ?>" placeholder="English Department Alumni Association KNGC" class="<?php echo e($inputClass); ?>">
                    <p class="mt-1 text-xs text-ink-soft">Shown in browser tab and search results. Recommended: 50-60 characters.</p>
                </div>

                <div class="sm:col-span-2">
                    <label for="seo_meta_description" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Default Meta Description</label>
                    <textarea id="seo_meta_description" name="seo_meta_description" rows="3" maxlength="500" placeholder="Join the English Department Alumni Association..." class="<?php echo e($inputClass); ?> resize-none"><?php echo e(old('seo_meta_description', \App\Models\SiteSetting::get('seo_meta_description'))); ?></textarea>
                    <div class="mt-1 flex items-center justify-between">
                        <p class="text-xs text-ink-soft">Appears in search results. Recommended: 150-160 characters.</p>
                        <span class="text-xs text-ink-soft"><span id="desc-count">0</span>/500</span>
                    </div>
                </div>

                <div class="sm:col-span-2">
                    <label for="seo_meta_keywords" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Meta Keywords</label>
                    <input type="text" id="seo_meta_keywords" name="seo_meta_keywords" value="<?php echo e(old('seo_meta_keywords', \App\Models\SiteSetting::get('seo_meta_keywords'))); ?>" placeholder="alumni, association, English department, KNGC" class="<?php echo e($inputClass); ?>">
                    <p class="mt-1 text-xs text-ink-soft">Comma-separated. Less important for modern SEO but still used by some engines.</p>
                </div>
            </div>
        </section>

        
        <section class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm sm:p-8">
            <div class="flex items-center gap-3 mb-6">
                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-100">
                    <svg class="h-5 w-5 text-blue-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-lg font-semibold text-navy-950">Open Graph (Facebook, LinkedIn)</h2>
                    <p class="text-sm text-ink-soft">Control how your site appears when shared on social media.</p>
                </div>
            </div>

            <div class="grid gap-5 sm:grid-cols-2">
                <div class="sm:col-span-2">
                    <label for="seo_og_title" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">OG Title</label>
                    <input type="text" id="seo_og_title" name="seo_og_title" value="<?php echo e(old('seo_og_title', \App\Models\SiteSetting::get('seo_og_title'))); ?>" placeholder="English Department Alumni Association" class="<?php echo e($inputClass); ?>">
                    <p class="mt-1 text-xs text-ink-soft">Falls back to meta title if empty. Recommended: 60 characters.</p>
                </div>

                <div class="sm:col-span-2">
                    <label for="seo_og_description" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">OG Description</label>
                    <textarea id="seo_og_description" name="seo_og_description" rows="2" maxlength="500" placeholder="Connected by English. United by Memories." class="<?php echo e($inputClass); ?> resize-none"><?php echo e(old('seo_og_description', \App\Models\SiteSetting::get('seo_og_description'))); ?></textarea>
                    <p class="mt-1 text-xs text-ink-soft">Falls back to meta description if empty.</p>
                </div>

                <div>
                    <label for="seo_og_image" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">OG Image</label>
                    <?php $ogImage = \App\Models\SiteSetting::get('seo_og_image'); ?>
                    <div>
                        <div class="flex items-center gap-4">
                            <img id="og-preview-img" src="<?php echo e($ogImage ? \Illuminate\Support\Facades\Storage::disk('public')->url($ogImage) : ''); ?>" alt="" class="h-20 w-40 rounded-lg object-cover ring-4 ring-gold-500/30 <?php echo e($ogImage ? '' : 'hidden'); ?>">
                            <span id="og-preview-fallback" class="flex h-20 w-40 items-center justify-center rounded-lg border-2 border-dashed border-navy-200 bg-cream text-xs text-ink-soft <?php echo e($ogImage ? 'hidden' : ''); ?>">No image</span>
                            <input type="file" id="seo_og_image" name="seo_og_image" accept="image/jpeg,image/png,image/webp" class="block w-full text-sm text-ink-soft file:mr-4 file:rounded-md file:border-0 file:bg-navy-900 file:px-4 file:py-2.5 file:text-sm file:font-semibold file:text-white hover:file:bg-navy-800">
                        </div>
                        <p class="mt-2 text-xs text-ink-soft">Recommended: 1200x630px for optimal social sharing.</p>
                    </div>
                </div>

                <div>
                    <label for="seo_og_type" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">OG Type</label>
                    <select id="seo_og_type" name="seo_og_type" class="<?php echo e($inputClass); ?>">
                        <option value="website" <?php if(old('seo_og_type', \App\Models\SiteSetting::get('seo_og_type', 'website')) === 'website'): echo 'selected'; endif; ?>>Website</option>
                        <option value="organization" <?php if(old('seo_og_type', \App\Models\SiteSetting::get('seo_og_type', 'website')) === 'organization'): echo 'selected'; endif; ?>>Organization</option>
                        <option value="article" <?php if(old('seo_og_type', \App\Models\SiteSetting::get('seo_og_type', 'website')) === 'article'): echo 'selected'; endif; ?>>Article</option>
                    </select>
                </div>
            </div>
        </section>

        
        <section class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm sm:p-8">
            <div class="flex items-center gap-3 mb-6">
                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-black/5">
                    <svg class="h-5 w-5 text-black" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-lg font-semibold text-navy-950">Twitter / X Card</h2>
                    <p class="text-sm text-ink-soft">Control how your site appears when shared on Twitter/X.</p>
                </div>
            </div>

            <div class="grid gap-5 sm:grid-cols-2">
                <div class="sm:col-span-2">
                    <label for="seo_twitter_title" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Twitter Title</label>
                    <input type="text" id="seo_twitter_title" name="seo_twitter_title" value="<?php echo e(old('seo_twitter_title', \App\Models\SiteSetting::get('seo_twitter_title'))); ?>" placeholder="EDAA-KNGC" class="<?php echo e($inputClass); ?>">
                    <p class="mt-1 text-xs text-ink-soft">Falls back to OG title if empty.</p>
                </div>

                <div class="sm:col-span-2">
                    <label for="seo_twitter_description" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Twitter Description</label>
                    <textarea id="seo_twitter_description" name="seo_twitter_description" rows="2" maxlength="500" placeholder="Connected by English. United by Memories." class="<?php echo e($inputClass); ?> resize-none"><?php echo e(old('seo_twitter_description', \App\Models\SiteSetting::get('seo_twitter_description'))); ?></textarea>
                </div>

                <div>
                    <label for="seo_twitter_image" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Twitter Image</label>
                    <?php $twitterImage = \App\Models\SiteSetting::get('seo_twitter_image'); ?>
                    <div>
                        <div class="flex items-center gap-4">
                            <img id="twitter-preview-img" src="<?php echo e($twitterImage ? \Illuminate\Support\Facades\Storage::disk('public')->url($twitterImage) : ''); ?>" alt="" class="h-20 w-40 rounded-lg object-cover ring-4 ring-gold-500/30 <?php echo e($twitterImage ? '' : 'hidden'); ?>">
                            <span id="twitter-preview-fallback" class="flex h-20 w-40 items-center justify-center rounded-lg border-2 border-dashed border-navy-200 bg-cream text-xs text-ink-soft <?php echo e($twitterImage ? 'hidden' : ''); ?>">No image</span>
                            <input type="file" id="seo_twitter_image" name="seo_twitter_image" accept="image/jpeg,image/png,image/webp" class="block w-full text-sm text-ink-soft file:mr-4 file:rounded-md file:border-0 file:bg-navy-900 file:px-4 file:py-2.5 file:text-sm file:font-semibold file:text-white hover:file:bg-navy-800">
                        </div>
                        <p class="mt-2 text-xs text-ink-soft">Recommended: 1200x628px.</p>
                    </div>
                </div>

                <div>
                    <label for="seo_twitter_card" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Card Type</label>
                    <select id="seo_twitter_card" name="seo_twitter_card" class="<?php echo e($inputClass); ?>">
                        <option value="summary_large_image" <?php if(old('seo_twitter_card', \App\Models\SiteSetting::get('seo_twitter_card', 'summary_large_image')) === 'summary_large_image'): echo 'selected'; endif; ?>>Summary Large Image</option>
                        <option value="summary" <?php if(old('seo_twitter_card', \App\Models\SiteSetting::get('seo_twitter_card', 'summary_large_image')) === 'summary'): echo 'selected'; endif; ?>>Summary</option>
                    </select>
                </div>

                <div>
                    <label for="seo_twitter_handle" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Twitter Handle</label>
                    <input type="text" id="seo_twitter_handle" name="seo_twitter_handle" value="<?php echo e(old('seo_twitter_handle', \App\Models\SiteSetting::get('seo_twitter_handle'))); ?>" placeholder="@edaa_kngc" class="<?php echo e($inputClass); ?>">
                    <p class="mt-1 text-xs text-ink-soft">Include the @ symbol.</p>
                </div>

                <div>
                    <label for="seo_facebook_app_id" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Facebook App ID</label>
                    <input type="text" id="seo_facebook_app_id" name="seo_facebook_app_id" value="<?php echo e(old('seo_facebook_app_id', \App\Models\SiteSetting::get('seo_facebook_app_id'))); ?>" placeholder="123456789" class="<?php echo e($inputClass); ?>">
                    <p class="mt-1 text-xs text-ink-soft">Optional. For Facebook Insights.</p>
                </div>
            </div>
        </section>

        
        <section class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm sm:p-8">
            <div class="flex items-center gap-3 mb-6">
                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-purple-100">
                    <svg class="h-5 w-5 text-purple-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-lg font-semibold text-navy-950">Analytics & Verification</h2>
                    <p class="text-sm text-ink-soft">Track visitors and verify site ownership.</p>
                </div>
            </div>

            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="seo_google_analytics_id" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Google Analytics ID</label>
                    <input type="text" id="seo_google_analytics_id" name="seo_google_analytics_id" value="<?php echo e(old('seo_google_analytics_id', \App\Models\SiteSetting::get('seo_google_analytics_id'))); ?>" placeholder="G-XXXXXXXXXX" class="<?php echo e($inputClass); ?>">
                    <p class="mt-1 text-xs text-ink-soft">Your GA4 measurement ID.</p>
                </div>

                <div>
                    <label for="seo_google_tag_manager" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Google Tag Manager ID</label>
                    <input type="text" id="seo_google_tag_manager" name="seo_google_tag_manager" value="<?php echo e(old('seo_google_tag_manager', \App\Models\SiteSetting::get('seo_google_tag_manager'))); ?>" placeholder="GTM-XXXXXXX" class="<?php echo e($inputClass); ?>">
                    <p class="mt-1 text-xs text-ink-soft">Optional. GTM container ID.</p>
                </div>

                <div class="sm:col-span-2">
                    <label for="seo_verification_code" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Search Console Verification Code</label>
                    <input type="text" id="seo_verification_code" name="seo_verification_code" value="<?php echo e(old('seo_verification_code', \App\Models\SiteSetting::get('seo_verification_code'))); ?>" placeholder="abc123def456" class="<?php echo e($inputClass); ?>">
                    <p class="mt-1 text-xs text-ink-soft">From Google Search Console's meta tag verification method.</p>
                </div>
            </div>
        </section>

        
        <div class="flex items-center justify-end gap-3 rounded-lg border border-navy-100 bg-white px-6 py-4 shadow-sm">
            <a href="<?php echo e(route('admin.seo.index')); ?>" class="focus-ring inline-flex items-center justify-center rounded-md px-4 py-2.5 text-sm font-semibold text-navy-600 transition-colors hover:bg-navy-50">
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
                Save SEO Settings
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
            const textarea = document.getElementById('seo_meta_description');
            const charCount = document.getElementById('desc-count');
            function updateCount() { charCount.textContent = textarea.value.length; }
            textarea.addEventListener('input', updateCount);
            updateCount();
        });
    </script>
    <?php $__env->stopPush(); ?>
    <?php $__env->startPush('scripts'); ?>
        <script>
        (function() {
            function setupPreview(inputId, imgId, fallbackId) {
                const input = document.getElementById(inputId);
                const img = document.getElementById(imgId);
                const fallback = document.getElementById(fallbackId);
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
            }
            setupPreview('seo_og_image', 'og-preview-img', 'og-preview-fallback');
            setupPreview('seo_twitter_image', 'twitter-preview-img', 'twitter-preview-fallback');
        })();
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
<?php /**PATH C:\xampp\htdocs\ProDo\EDAA\resources\views/admin/seo/settings.blade.php ENDPATH**/ ?>