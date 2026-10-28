<?php if (isset($component)) { $__componentOriginalc8c9fd5d7827a77a31381de67195f0c3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc8c9fd5d7827a77a31381de67195f0c3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.admin','data' => ['title' => 'Edit Page SEO: '.e($pageName).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.admin'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Edit Page SEO: '.e($pageName).'']); ?>
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="font-serif text-3xl font-semibold tracking-tight text-navy-950">Edit Page SEO</h1>
                <p class="mt-1 text-sm text-ink-soft">
                    Configure meta tags and social sharing for <strong class="text-navy-950"><?php echo e($pageName); ?></strong>
                    <code class="ml-1 rounded bg-navy-100 px-1.5 py-0.5 text-xs text-navy-700"><?php echo e($uri); ?></code>
                </p>
            </div>
            <a href="<?php echo e(route('admin.seo.pages')); ?>" class="focus-ring inline-flex items-center gap-2 rounded-lg border border-navy-200 bg-white px-4 py-2.5 text-sm font-semibold text-navy-950 transition-colors hover:bg-navy-50">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back
            </a>
        </div>
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

    <?php
        $inputClass = 'w-full rounded-md border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 placeholder-navy-400 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none';
    ?>

    <form method="POST" action="<?php echo e(route('admin.seo.pages.update', urlencode($uri))); ?>" enctype="multipart/form-data" class="space-y-6">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        
        <section class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm sm:p-8">
            <h2 class="font-serif text-xl font-semibold text-navy-950">Basic Meta Tags</h2>
            <p class="mt-1 text-sm text-ink-soft">Core SEO information for this page.</p>

            <div class="mt-6 grid gap-5 sm:grid-cols-2">
                <div class="sm:col-span-2">
                    <label for="title" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Meta Title</label>
                    <input type="text" id="title" name="title" value="<?php echo e(old('title', $meta?->title)); ?>" placeholder="Leave empty to use global default" class="<?php echo e($inputClass); ?>">
                    <div class="mt-1 flex items-center justify-between">
                        <p class="text-xs text-ink-soft">Recommended: 50-60 characters.</p>
                        <span class="text-xs text-ink-soft"><span id="title-count">0</span>/255</span>
                    </div>
                </div>

                <div class="sm:col-span-2">
                    <label for="description" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Meta Description</label>
                    <textarea id="description" name="description" rows="3" maxlength="500" placeholder="Leave empty to use global default" class="<?php echo e($inputClass); ?> resize-none"><?php echo e(old('description', $meta?->description)); ?></textarea>
                    <div class="mt-1 flex items-center justify-between">
                        <p class="text-xs text-ink-soft">Recommended: 150-160 characters.</p>
                        <span class="text-xs text-ink-soft"><span id="desc-count">0</span>/500</span>
                    </div>
                </div>

                <div class="sm:col-span-2">
                    <label for="keywords" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Meta Keywords</label>
                    <input type="text" id="keywords" name="keywords" value="<?php echo e(old('keywords', $meta?->keywords)); ?>" placeholder="alumni, reunion, English department" class="<?php echo e($inputClass); ?>">
                    <p class="mt-1 text-xs text-ink-soft">Comma-separated keywords.</p>
                </div>
            </div>
        </section>

        
        <section class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm sm:p-8">
            <h2 class="font-serif text-xl font-semibold text-navy-950">Open Graph (Facebook, LinkedIn)</h2>
            <p class="mt-1 text-sm text-ink-soft">Customize how this page appears when shared on social media.</p>

            <div class="mt-6 grid gap-5 sm:grid-cols-2">
                <div class="sm:col-span-2">
                    <label for="og_title" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">OG Title</label>
                    <input type="text" id="og_title" name="og_title" value="<?php echo e(old('og_title', $meta?->og_title)); ?>" placeholder="Falls back to meta title" class="<?php echo e($inputClass); ?>">
                </div>

                <div class="sm:col-span-2">
                    <label for="og_description" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">OG Description</label>
                    <textarea id="og_description" name="og_description" rows="2" maxlength="500" placeholder="Falls back to meta description" class="<?php echo e($inputClass); ?> resize-none"><?php echo e(old('og_description', $meta?->og_description)); ?></textarea>
                </div>

                <div>
                    <label for="og_image" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">OG Image</label>
                    <div>
                        <div class="flex items-center gap-4">
                            <img id="og-preview-img" src="<?php echo e($meta?->ogImageUrl() ?? ''); ?>" alt="" class="h-20 w-40 rounded-lg object-cover ring-4 ring-gold-500/30 <?php echo e($meta?->ogImageUrl() ? '' : 'hidden'); ?>">
                            <span id="og-preview-fallback" class="flex h-20 w-40 items-center justify-center rounded-lg border-2 border-dashed border-navy-200 bg-cream text-xs text-ink-soft <?php echo e($meta?->ogImageUrl() ? 'hidden' : ''); ?>">No image</span>
                            <input type="file" id="og_image" name="og_image" accept="image/jpeg,image/png,image/webp" class="block w-full text-sm text-ink-soft file:mr-4 file:rounded-md file:border-0 file:bg-navy-900 file:px-4 file:py-2.5 file:text-sm file:font-semibold file:text-white hover:file:bg-navy-800">
                        </div>
                        <p class="mt-2 text-xs text-ink-soft">1200x630px recommended.</p>
                    </div>
                </div>

                <div>
                    <label for="og_type" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">OG Type</label>
                    <select id="og_type" name="og_type" class="<?php echo e($inputClass); ?>">
                        <option value="website" <?php if(old('og_type', $meta?->og_type ?? 'website') === 'website'): echo 'selected'; endif; ?>>Website</option>
                        <option value="article" <?php if(old('og_type', $meta?->og_type ?? 'website') === 'article'): echo 'selected'; endif; ?>>Article</option>
                        <option value="profile" <?php if(old('og_type', $meta?->og_type ?? 'website') === 'profile'): echo 'selected'; endif; ?>>Profile</option>
                    </select>
                </div>
            </div>
        </section>

        
        <section class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm sm:p-8">
            <h2 class="font-serif text-xl font-semibold text-navy-950">Twitter / X Card</h2>
            <p class="mt-1 text-sm text-ink-soft">Customize how this page appears on Twitter/X.</p>

            <div class="mt-6 grid gap-5 sm:grid-cols-2">
                <div class="sm:col-span-2">
                    <label for="twitter_title" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Twitter Title</label>
                    <input type="text" id="twitter_title" name="twitter_title" value="<?php echo e(old('twitter_title', $meta?->twitter_title)); ?>" placeholder="Falls back to OG title" class="<?php echo e($inputClass); ?>">
                </div>

                <div class="sm:col-span-2">
                    <label for="twitter_description" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Twitter Description</label>
                    <textarea id="twitter_description" name="twitter_description" rows="2" maxlength="500" placeholder="Falls back to OG description" class="<?php echo e($inputClass); ?> resize-none"><?php echo e(old('twitter_description', $meta?->twitter_description)); ?></textarea>
                </div>

                <div>
                    <label for="twitter_image" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Twitter Image</label>
                    <div>
                        <div class="flex items-center gap-4">
                            <img id="twitter-preview-img" src="<?php echo e($meta?->twitterImageUrl() ?? ''); ?>" alt="" class="h-20 w-40 rounded-lg object-cover ring-4 ring-gold-500/30 <?php echo e($meta?->twitterImageUrl() ? '' : 'hidden'); ?>">
                            <span id="twitter-preview-fallback" class="flex h-20 w-40 items-center justify-center rounded-lg border-2 border-dashed border-navy-200 bg-cream text-xs text-ink-soft <?php echo e($meta?->twitterImageUrl() ? 'hidden' : ''); ?>">No image</span>
                            <input type="file" id="twitter_image" name="twitter_image" accept="image/jpeg,image/png,image/webp" class="block w-full text-sm text-ink-soft file:mr-4 file:rounded-md file:border-0 file:bg-navy-900 file:px-4 file:py-2.5 file:text-sm file:font-semibold file:text-white hover:file:bg-navy-800">
                        </div>
                        <p class="mt-2 text-xs text-ink-soft">1200x628px recommended.</p>
                    </div>
                </div>

                <div>
                    <label for="twitter_card" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Card Type</label>
                    <select id="twitter_card" name="twitter_card" class="<?php echo e($inputClass); ?>">
                        <option value="summary_large_image" <?php if(old('twitter_card', $meta?->twitter_card ?? 'summary_large_image') === 'summary_large_image'): echo 'selected'; endif; ?>>Summary Large Image</option>
                        <option value="summary" <?php if(old('twitter_card', $meta?->twitter_card ?? 'summary_large_image') === 'summary'): echo 'selected'; endif; ?>>Summary</option>
                    </select>
                </div>
            </div>
        </section>

        
        <section class="rounded-lg border border-navy-100 bg-white p-6 shadow-sm sm:p-8">
            <h2 class="font-serif text-xl font-semibold text-navy-950">Advanced SEO</h2>
            <p class="mt-1 text-sm text-ink-soft">Indexing control, canonical URLs, and structured data.</p>

            <div class="mt-6 grid gap-5 sm:grid-cols-2">
                <div>
                    <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Indexing</label>
                    <div class="space-y-2">
                        <label class="flex items-center gap-3 rounded-lg border border-navy-200 bg-cream px-4 py-3">
                            <input type="checkbox" name="noindex" value="1" class="h-4 w-4 rounded border-navy-300 text-maroon-700 focus:ring-maroon-500" <?php if(old('noindex', $meta?->noindex ?? false)): echo 'checked'; endif; ?>>
                            <div>
                                <span class="text-sm font-medium text-navy-950">Noindex</span>
                                <p class="text-xs text-ink-soft">Prevent search engines from indexing this page.</p>
                            </div>
                        </label>
                        <label class="flex items-center gap-3 rounded-lg border border-navy-200 bg-cream px-4 py-3">
                            <input type="checkbox" name="nofollow" value="1" class="h-4 w-4 rounded border-navy-300 text-maroon-700 focus:ring-maroon-500" <?php if(old('nofollow', $meta?->nofollow ?? false)): echo 'checked'; endif; ?>>
                            <div>
                                <span class="text-sm font-medium text-navy-950">Nofollow</span>
                                <p class="text-xs text-ink-soft">Prevent search engines from following links on this page.</p>
                            </div>
                        </label>
                    </div>
                </div>

                <div>
                    <label for="canonical" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Canonical URL</label>
                    <input type="url" id="canonical" name="canonical" value="<?php echo e(old('canonical', $meta?->canonical)); ?>" placeholder="Leave empty for auto-detect" class="<?php echo e($inputClass); ?>">
                    <p class="mt-1 text-xs text-ink-soft">Override the canonical URL for this page.</p>

                    <label for="schema_markup" class="mb-1.5 mt-5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Custom JSON-LD Schema</label>
                    <textarea id="schema_markup" name="schema_markup" rows="6" placeholder='{"<?php $__contextArgs = [];
if (context()->has($__contextArgs[0])) :
if (isset($value)) { $__contextPrevious[] = $value; }
$value = context()->get($__contextArgs[0]); ?>":"https://schema.org","@type":"Organization",...}' class="<?php echo e($inputClass); ?> resize-none font-mono text-xs"><?php echo e(old('schema_markup', $meta?->schema_markup)); ?></textarea>
                    <p class="mt-1 text-xs text-ink-soft">Paste valid JSON-LD structured data.</p>
                </div>
            </div>
        </section>

        
        <div class="flex items-center justify-end gap-3 rounded-lg border border-navy-100 bg-white px-6 py-4 shadow-sm">
            <a href="<?php echo e(route('admin.seo.pages')); ?>" class="focus-ring inline-flex items-center justify-center rounded-md px-4 py-2.5 text-sm font-semibold text-navy-600 transition-colors hover:bg-navy-50">
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
                Save Page SEO
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
            const titleInput = document.getElementById('title');
            const titleCount = document.getElementById('title-count');
            const descTextarea = document.getElementById('description');
            const descCount = document.getElementById('desc-count');

            function updateTitleCount() { titleCount.textContent = titleInput.value.length; }
            function updateDescCount() { descCount.textContent = descTextarea.value.length; }

            titleInput.addEventListener('input', updateTitleCount);
            descTextarea.addEventListener('input', updateDescCount);
            updateTitleCount();
            updateDescCount();
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
            setupPreview('og_image', 'og-preview-img', 'og-preview-fallback');
            setupPreview('twitter_image', 'twitter-preview-img', 'twitter-preview-fallback');
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
<?php /**PATH C:\xampp\htdocs\ProDo\EDAA\resources\views/admin/seo/page-edit.blade.php ENDPATH**/ ?>