<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'title' => null,
    'description' => null,
    'image' => null,
    'type' => 'website',
]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter(([
    'title' => null,
    'description' => null,
    'image' => null,
    'type' => 'website',
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $site = config('site');
    $siteName = \App\Models\SiteSetting::get('site_name') ?: $site['name'];
    $siteDescription = \App\Models\SiteSetting::get('site_description') ?: $site['description'];
    $pageTitle = $title ? "{$title} | {$siteName}" : $siteName;
    $metaDescription = $description ?? $siteDescription;
    $canonical = url()->current();
    $ogImage = url($image ?? $site['meta']['og_image']);
?>

<title><?php echo e($pageTitle); ?></title>
<meta name="description" content="<?php echo e($metaDescription); ?>">
<meta name="robots" content="index, follow">
<link rel="canonical" href="<?php echo e($canonical); ?>">

<meta property="og:type" content="<?php echo e($type); ?>">
<meta property="og:site_name" content="<?php echo e($siteName); ?>">
<meta property="og:title" content="<?php echo e($pageTitle); ?>">
<meta property="og:description" content="<?php echo e($metaDescription); ?>">
<meta property="og:url" content="<?php echo e($canonical); ?>">
<meta property="og:image" content="<?php echo e($ogImage); ?>">
<meta property="og:locale" content="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?php echo e($pageTitle); ?>">
<meta name="twitter:description" content="<?php echo e($metaDescription); ?>">
<meta name="twitter:image" content="<?php echo e($ogImage); ?>">
<?php /**PATH C:\xampp\htdocs\ProDo\EDAA\resources\views/components/seo.blade.php ENDPATH**/ ?>