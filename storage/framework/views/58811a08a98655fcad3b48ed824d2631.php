<?php if (isset($component)) { $__componentOriginal5863877a5171c196453bfa0bd807e410 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5863877a5171c196453bfa0bd807e410 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.app','data' => ['title' => 'Alumni','description' => 'Meet the graduates of the English Department — writers, educators, and leaders across the world.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.app'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Alumni','description' => 'Meet the graduates of the English Department — writers, educators, and leaders across the world.']); ?>

    <?php if (isset($component)) { $__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.page-header','data' => ['title' => 'Our Alumni','description' => 'Thousands of graduates, one shared foundation in language and literature. Explore the community that began in our lecture halls.','eyebrow' => 'The Community','breadcrumbs' => [['label' => 'Alumni']]]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('page-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Our Alumni','description' => 'Thousands of graduates, one shared foundation in language and literature. Explore the community that began in our lecture halls.','eyebrow' => 'The Community','breadcrumbs' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([['label' => 'Alumni']])]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e)): ?>
<?php $attributes = $__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e; ?>
<?php unset($__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e)): ?>
<?php $component = $__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e; ?>
<?php unset($__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e); ?>
<?php endif; ?>

    
    <section class="bg-cream py-12 sm:py-16">
        <div class="container-page grid gap-5 sm:grid-cols-3">
            <?php if (isset($component)) { $__componentOriginal3b387acd2c997737a257e1ec014549fd = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3b387acd2c997737a257e1ec014549fd = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.stat','data' => ['value' => ''.e(number_format($totalAlumni)).'','label' => 'Registered Alumni']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('stat'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['value' => ''.e(number_format($totalAlumni)).'','label' => 'Registered Alumni']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3b387acd2c997737a257e1ec014549fd)): ?>
<?php $attributes = $__attributesOriginal3b387acd2c997737a257e1ec014549fd; ?>
<?php unset($__attributesOriginal3b387acd2c997737a257e1ec014549fd); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3b387acd2c997737a257e1ec014549fd)): ?>
<?php $component = $__componentOriginal3b387acd2c997737a257e1ec014549fd; ?>
<?php unset($__componentOriginal3b387acd2c997737a257e1ec014549fd); ?>
<?php endif; ?>
            <?php if (isset($component)) { $__componentOriginal3b387acd2c997737a257e1ec014549fd = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3b387acd2c997737a257e1ec014549fd = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.stat','data' => ['value' => ''.e(number_format($totalCountries)).'','label' => 'Countries Represented','accent' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('stat'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['value' => ''.e(number_format($totalCountries)).'','label' => 'Countries Represented','accent' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3b387acd2c997737a257e1ec014549fd)): ?>
<?php $attributes = $__attributesOriginal3b387acd2c997737a257e1ec014549fd; ?>
<?php unset($__attributesOriginal3b387acd2c997737a257e1ec014549fd); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3b387acd2c997737a257e1ec014549fd)): ?>
<?php $component = $__componentOriginal3b387acd2c997737a257e1ec014549fd; ?>
<?php unset($__componentOriginal3b387acd2c997737a257e1ec014549fd); ?>
<?php endif; ?>
            <?php if (isset($component)) { $__componentOriginal3b387acd2c997737a257e1ec014549fd = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3b387acd2c997737a257e1ec014549fd = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.stat','data' => ['value' => ''.e(number_format($totalBatches)).'','label' => 'Alumni Batches']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('stat'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['value' => ''.e(number_format($totalBatches)).'','label' => 'Alumni Batches']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3b387acd2c997737a257e1ec014549fd)): ?>
<?php $attributes = $__attributesOriginal3b387acd2c997737a257e1ec014549fd; ?>
<?php unset($__attributesOriginal3b387acd2c997737a257e1ec014549fd); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3b387acd2c997737a257e1ec014549fd)): ?>
<?php $component = $__componentOriginal3b387acd2c997737a257e1ec014549fd; ?>
<?php unset($__componentOriginal3b387acd2c997737a257e1ec014549fd); ?>
<?php endif; ?>
        </div>
    </section>

    
    <?php if($featuredAlumni->isNotEmpty()): ?>
        <section class="section-pad bg-white">
            <div class="container-page">
                <div class="flex flex-col items-start justify-between gap-6 sm:flex-row sm:items-end">
                    <?php if (isset($component)) { $__componentOriginal755230460fd16c04121658d92fbf99f7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal755230460fd16c04121658d92fbf99f7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.section-heading','data' => ['eyebrow' => 'Featured Alumni','title' => 'Voices of the Department','description' => 'A selection of graduates who continue to carry the English Department\'s name across the world.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('section-heading'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['eyebrow' => 'Featured Alumni','title' => 'Voices of the Department','description' => 'A selection of graduates who continue to carry the English Department\'s name across the world.']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal755230460fd16c04121658d92fbf99f7)): ?>
<?php $attributes = $__attributesOriginal755230460fd16c04121658d92fbf99f7; ?>
<?php unset($__attributesOriginal755230460fd16c04121658d92fbf99f7); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal755230460fd16c04121658d92fbf99f7)): ?>
<?php $component = $__componentOriginal755230460fd16c04121658d92fbf99f7; ?>
<?php unset($__componentOriginal755230460fd16c04121658d92fbf99f7); ?>
<?php endif; ?>
                </div>

                <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    <?php $__currentLoopData = $featuredAlumni; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $alumnus): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if (isset($component)) { $__componentOriginal98907a067cf0b7ee0a65abc9eeb4175a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal98907a067cf0b7ee0a65abc9eeb4175a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.alumni-card','data' => ['name' => $alumnus->full_name,'graduationYear' => $alumnus->graduation_year,'role' => $alumnus->designation,'field' => $alumnus->organization,'image' => $alumnus->profile_photo_url,'batch' => $alumnus->batch,'country' => $alumnus->country,'membershipType' => $alumnus->publicMembership?->type,'membershipTier' => $alumnus->publicMembership?->tier,'href' => ''.e(route('alumni.show', $alumnus)).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('alumni-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($alumnus->full_name),'graduation_year' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($alumnus->graduation_year),'role' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($alumnus->designation),'field' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($alumnus->organization),'image' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($alumnus->profile_photo_url),'batch' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($alumnus->batch),'country' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($alumnus->country),'membership_type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($alumnus->publicMembership?->type),'membership_tier' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($alumnus->publicMembership?->tier),'href' => ''.e(route('alumni.show', $alumnus)).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal98907a067cf0b7ee0a65abc9eeb4175a)): ?>
<?php $attributes = $__attributesOriginal98907a067cf0b7ee0a65abc9eeb4175a; ?>
<?php unset($__attributesOriginal98907a067cf0b7ee0a65abc9eeb4175a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal98907a067cf0b7ee0a65abc9eeb4175a)): ?>
<?php $component = $__componentOriginal98907a067cf0b7ee0a65abc9eeb4175a; ?>
<?php unset($__componentOriginal98907a067cf0b7ee0a65abc9eeb4175a); ?>
<?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    
    <section class="section-pad bg-cream">
        <div class="container-page">
            <?php if (isset($component)) { $__componentOriginal755230460fd16c04121658d92fbf99f7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal755230460fd16c04121658d92fbf99f7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.section-heading','data' => ['eyebrow' => 'Alumni Directory','title' => 'Search the community','description' => 'Find classmates and colleagues by name, profession, organization, batch, or graduation year.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('section-heading'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['eyebrow' => 'Alumni Directory','title' => 'Search the community','description' => 'Find classmates and colleagues by name, profession, organization, batch, or graduation year.']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal755230460fd16c04121658d92fbf99f7)): ?>
<?php $attributes = $__attributesOriginal755230460fd16c04121658d92fbf99f7; ?>
<?php unset($__attributesOriginal755230460fd16c04121658d92fbf99f7); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal755230460fd16c04121658d92fbf99f7)): ?>
<?php $component = $__componentOriginal755230460fd16c04121658d92fbf99f7; ?>
<?php unset($__componentOriginal755230460fd16c04121658d92fbf99f7); ?>
<?php endif; ?>

            <form method="GET" action="<?php echo e(route('alumni.index')); ?>" class="mt-10 rounded-2xl border border-navy-100 bg-white/95 p-6 shadow-sm backdrop-blur-md sm:p-8">
                <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-5">
                    <div class="lg:col-span-2">
                        <label for="search" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Search</label>
                        <input
                            type="search"
                            id="search"
                            name="search"
                            value="<?php echo e($filters['search']); ?>"
                            placeholder="Name, profession or organization"
                            class="w-full rounded-xl border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 placeholder-navy-400 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none"
                        >
                    </div>

                    <div>
                        <label for="batch" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Batch</label>
                        <select id="batch" name="batch" class="w-full rounded-xl border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none">
                            <option value="">All batches</option>
                            <?php $__currentLoopData = $batches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $batch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($batch); ?>" <?php if($filters['batch'] == $batch): echo 'selected'; endif; ?>>Batch <?php echo e($batch); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div>
                        <label for="graduation_year" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Graduation Year</label>
                        <select id="graduation_year" name="graduation_year" class="w-full rounded-xl border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none">
                            <option value="">All years</option>
                            <?php $__currentLoopData = $years; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($year); ?>" <?php if($filters['graduation_year'] == $year): echo 'selected'; endif; ?>><?php echo e($year); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div>
                        <label for="country" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-ink-soft">Country</label>
                        <select id="country" name="country" class="w-full rounded-xl border border-navy-300 bg-white px-4 py-2.5 text-sm text-navy-950 focus:border-gold-500 focus:ring-2 focus:ring-gold-500/30 focus:outline-none">
                            <option value="">All countries</option>
                            <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($option); ?>" <?php if($filters['country'] == $option): echo 'selected'; endif; ?>><?php echo e($option); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>

                <div class="mt-6 flex flex-wrap items-center justify-between gap-4 border-t border-navy-50 pt-4">
                    <div class="flex flex-wrap items-center gap-3">
                        <?php if (isset($component)) { $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.button','data' => ['type' => 'submit','variant' => 'navy','class' => 'rounded-xl px-5']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'submit','variant' => 'navy','class' => 'rounded-xl px-5']); ?>Search Alumni <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561)): ?>
<?php $attributes = $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561; ?>
<?php unset($__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald0f1fd2689e4bb7060122a5b91fe8561)): ?>
<?php $component = $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561; ?>
<?php unset($__componentOriginald0f1fd2689e4bb7060122a5b91fe8561); ?>
<?php endif; ?>
                        <?php if($filters['search'] !== '' || $filters['batch'] || $filters['graduation_year'] || $filters['country']): ?>
                            <a href="<?php echo e(route('alumni.index')); ?>" class="focus-ring inline-flex items-center gap-1.5 rounded-xl px-3.5 py-2 text-xs font-bold text-maroon-700 transition-colors hover:bg-maroon-50">
                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Clear all filters
                            </a>
                        <?php endif; ?>
                    </div>

                    
                    <div class="text-xs font-medium text-ink-soft">
                        Showing <span class="font-bold text-navy-950"><?php echo e($alumni->total()); ?></span> alumni
                    </div>
                </div>

                
                <?php if($filters['search'] || $filters['batch'] || $filters['graduation_year'] || $filters['country']): ?>
                    <div class="mt-4 flex flex-wrap items-center gap-2 border-t border-navy-50 pt-3 text-xs">
                        <span class="font-semibold text-navy-600">Active Filters:</span>
                        <?php if($filters['search']): ?>
                            <span class="inline-flex items-center gap-1 rounded-full bg-navy-100 px-3 py-1 font-medium text-navy-900">
                                Keyword: "<?php echo e($filters['search']); ?>"
                            </span>
                        <?php endif; ?>
                        <?php if($filters['batch']): ?>
                            <span class="inline-flex items-center gap-1 rounded-full bg-gold-100 px-3 py-1 font-semibold text-gold-900">
                                Batch <?php echo e($filters['batch']); ?>

                            </span>
                        <?php endif; ?>
                        <?php if($filters['graduation_year']): ?>
                            <span class="inline-flex items-center gap-1 rounded-full bg-maroon-100 px-3 py-1 font-semibold text-maroon-900">
                                Year: <?php echo e($filters['graduation_year']); ?>

                            </span>
                        <?php endif; ?>
                        <?php if($filters['country']): ?>
                            <span class="inline-flex items-center gap-1 rounded-full bg-navy-100 px-3 py-1 font-medium text-navy-900">
                                <?php echo e($filters['country']); ?>

                            </span>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </form>

            <?php if($alumni->isNotEmpty()): ?>
                <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    <?php $__currentLoopData = $alumni; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $alumnus): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if (isset($component)) { $__componentOriginal98907a067cf0b7ee0a65abc9eeb4175a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal98907a067cf0b7ee0a65abc9eeb4175a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.alumni-card','data' => ['name' => $alumnus->full_name,'graduationYear' => $alumnus->graduation_year,'role' => $alumnus->designation,'field' => $alumnus->organization,'image' => $alumnus->profile_photo_url,'batch' => $alumnus->batch,'country' => $alumnus->country,'bio' => $alumnus->bio,'membershipType' => $alumnus->publicMembership?->type,'membershipTier' => $alumnus->publicMembership?->tier,'href' => ''.e(route('alumni.show', $alumnus)).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('alumni-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($alumnus->full_name),'graduation_year' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($alumnus->graduation_year),'role' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($alumnus->designation),'field' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($alumnus->organization),'image' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($alumnus->profile_photo_url),'batch' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($alumnus->batch),'country' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($alumnus->country),'bio' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($alumnus->bio),'membership_type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($alumnus->publicMembership?->type),'membership_tier' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($alumnus->publicMembership?->tier),'href' => ''.e(route('alumni.show', $alumnus)).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal98907a067cf0b7ee0a65abc9eeb4175a)): ?>
<?php $attributes = $__attributesOriginal98907a067cf0b7ee0a65abc9eeb4175a; ?>
<?php unset($__attributesOriginal98907a067cf0b7ee0a65abc9eeb4175a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal98907a067cf0b7ee0a65abc9eeb4175a)): ?>
<?php $component = $__componentOriginal98907a067cf0b7ee0a65abc9eeb4175a; ?>
<?php unset($__componentOriginal98907a067cf0b7ee0a65abc9eeb4175a); ?>
<?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <div class="mt-12 flex justify-center">
                    <?php echo e($alumni->links()); ?>

                </div>
            <?php else: ?>
                <div class="mt-10">
                    <?php if (isset($component)) { $__componentOriginal074a021b9d42f490272b5eefda63257c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal074a021b9d42f490272b5eefda63257c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.empty-state','data' => ['title' => 'No alumni match your search','description' => 'Try adjusting your search terms or clearing the filters to see the full directory.','actionLabel' => 'Clear all filters','actionHref' => ''.e(route('alumni.index')).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('empty-state'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'No alumni match your search','description' => 'Try adjusting your search terms or clearing the filters to see the full directory.','action_label' => 'Clear all filters','action_href' => ''.e(route('alumni.index')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal074a021b9d42f490272b5eefda63257c)): ?>
<?php $attributes = $__attributesOriginal074a021b9d42f490272b5eefda63257c; ?>
<?php unset($__attributesOriginal074a021b9d42f490272b5eefda63257c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal074a021b9d42f490272b5eefda63257c)): ?>
<?php $component = $__componentOriginal074a021b9d42f490272b5eefda63257c; ?>
<?php unset($__componentOriginal074a021b9d42f490272b5eefda63257c); ?>
<?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>

    
    <section class="bg-white py-16 sm:py-20">
        <div class="container-page">
            <div class="rounded-3xl bg-gradient-to-br from-navy-950 via-navy-900 to-maroon-950 p-10 text-white sm:p-14 shadow-2xl">
                <div class="grid items-center gap-8 lg:grid-cols-2">
                    <div>
                        <?php if (isset($component)) { $__componentOriginal755230460fd16c04121658d92fbf99f7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal755230460fd16c04121658d92fbf99f7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.section-heading','data' => ['eyebrow' => 'Get Listed','title' => 'Want to be part of the directory?','description' => 'Membership is the key to the directory. Register your profile and join the EDAA family as verified alumni.','dark' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('section-heading'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['eyebrow' => 'Get Listed','title' => 'Want to be part of the directory?','description' => 'Membership is the key to the directory. Register your profile and join the EDAA family as verified alumni.','dark' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal755230460fd16c04121658d92fbf99f7)): ?>
<?php $attributes = $__attributesOriginal755230460fd16c04121658d92fbf99f7; ?>
<?php unset($__attributesOriginal755230460fd16c04121658d92fbf99f7); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal755230460fd16c04121658d92fbf99f7)): ?>
<?php $component = $__componentOriginal755230460fd16c04121658d92fbf99f7; ?>
<?php unset($__componentOriginal755230460fd16c04121658d92fbf99f7); ?>
<?php endif; ?>
                    </div>
                    <div class="lg:justify-self-end">
                        <?php if (isset($component)) { $__componentOriginald0f1fd2689e4bb7060122a5b91fe8561 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald0f1fd2689e4bb7060122a5b91fe8561 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.button','data' => ['href' => ''.e(route('membership.apply')).'','variant' => 'gold','size' => 'lg','icon' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => ''.e(route('membership.apply')).'','variant' => 'gold','size' => 'lg','icon' => true]); ?>Become a Member <?php echo $__env->renderComponent(); ?>
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
                </div>
            </div>
        </div>
    </section>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5863877a5171c196453bfa0bd807e410)): ?>
<?php $attributes = $__attributesOriginal5863877a5171c196453bfa0bd807e410; ?>
<?php unset($__attributesOriginal5863877a5171c196453bfa0bd807e410); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5863877a5171c196453bfa0bd807e410)): ?>
<?php $component = $__componentOriginal5863877a5171c196453bfa0bd807e410; ?>
<?php unset($__componentOriginal5863877a5171c196453bfa0bd807e410); ?>
<?php endif; ?><?php /**PATH C:\xampp\htdocs\ProDo\EDAA\resources\views/pages/alumni.blade.php ENDPATH**/ ?>