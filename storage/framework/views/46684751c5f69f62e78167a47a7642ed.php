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

    // Global SEO defaults from database
    $seoTitle = \App\Models\SiteSetting::get('seo_meta_title');
    $seoDescription = \App\Models\SiteSetting::get('seo_meta_description');
    $seoKeywords = \App\Models\SiteSetting::get('seo_meta_keywords');
    $seoOgTitle = \App\Models\SiteSetting::get('seo_og_title');
    $seoOgDescription = \App\Models\SiteSetting::get('seo_og_description');
    $seoOgImage = \App\Models\SiteSetting::get('seo_og_image');
    $seoOgType = \App\Models\SiteSetting::get('seo_og_type', 'website');
    $seoTwitterTitle = \App\Models\SiteSetting::get('seo_twitter_title');
    $seoTwitterDescription = \App\Models\SiteSetting::get('seo_twitter_description');
    $seoTwitterImage = \App\Models\SiteSetting::get('seo_twitter_image');
    $seoTwitterCard = \App\Models\SiteSetting::get('seo_twitter_card', 'summary_large_image');
    $seoTwitterHandle = \App\Models\SiteSetting::get('seo_twitter_handle');
    $seoFacebookAppId = \App\Models\SiteSetting::get('seo_facebook_app_id');
    $seoVerificationCode = \App\Models\SiteSetting::get('seo_verification_code');

    // Per-page metadata override
    $currentPageUri = request()->path();
    $pageMeta = \App\Models\SeoPageMeta::findByUri('/' . $currentPageUri)
        ?? (\App\Models\SeoPageMeta::findByUri('/' . $currentPageUri . '/') ?? null);

    // Resolve final values: page-specific > prop > global SEO > site defaults
    $pageTitle = $title
        ?? $pageMeta?->title
        ?? $seoTitle
        ?? $siteName;
    if (! str_ends_with($pageTitle, $siteName)) {
        $pageTitle = "{$pageTitle} | {$siteName}";
    }

    $metaDescription = $description
        ?? $pageMeta?->description
        ?? $seoDescription
        ?? $siteDescription;

    $ogTitle = $pageMeta?->og_title
        ?? $seoOgTitle
        ?? $title
        ?? $siteName;
    $ogDescription = $pageMeta?->og_description
        ?? $seoOgDescription
        ?? $description
        ?? $siteDescription;

    $resolvedType = $pageMeta?->og_type ?? $type;
    $canonical = $pageMeta?->canonical ?? url()->current();

    // Images: resolve priority chain
    $resolvedOgImage = null;
    if ($image) {
        $resolvedOgImage = url($image);
    } elseif ($pageMeta?->og_image) {
        $resolvedOgImage = \Illuminate\Support\Facades\Storage::disk('public')->url($pageMeta->og_image);
    } elseif ($seoOgImage) {
        $resolvedOgImage = \Illuminate\Support\Facades\Storage::disk('public')->url($seoOgImage);
    } else {
        $resolvedOgImage = url($site['meta']['og_image']);
    }

    $twitterImage = null;
    if ($pageMeta?->twitter_image) {
        $twitterImage = \Illuminate\Support\Facades\Storage::disk('public')->url($pageMeta->twitter_image);
    } elseif ($seoTwitterImage) {
        $twitterImage = \Illuminate\Support\Facades\Storage::disk('public')->url($seoTwitterImage);
    } else {
        $twitterImage = $resolvedOgImage;
    }

    $twitterTitle = $pageMeta?->twitter_title
        ?? $seoTwitterTitle
        ?? $ogTitle;
    $twitterDescription = $pageMeta?->twitter_description
        ?? $seoTwitterDescription
        ?? $ogDescription;

    // Robots directive
    $robotsDirective = $pageMeta ? $pageMeta->robotsDirective() : 'index, follow';

    // Schema markup
    $schemaMarkup = $pageMeta?->schema_markup;
?>

<title><?php echo e($pageTitle); ?></title>
<meta name="description" content="<?php echo e($metaDescription); ?>">
<?php if($seoKeywords || $pageMeta?->keywords): ?>
    <meta name="keywords" content="<?php echo e($pageMeta?->keywords ?? $seoKeywords); ?>">
<?php endif; ?>
<meta name="robots" content="<?php echo e($robotsDirective); ?>">
<link rel="canonical" href="<?php echo e($canonical); ?>">

<?php if($seoVerificationCode): ?>
    <meta name="google-site-verification" content="<?php echo e($seoVerificationCode); ?>">
<?php endif; ?>

<meta property="og:type" content="<?php echo e($resolvedType); ?>">
<meta property="og:site_name" content="<?php echo e($siteName); ?>">
<meta property="og:title" content="<?php echo e($ogTitle); ?>">
<meta property="og:description" content="<?php echo e($ogDescription); ?>">
<meta property="og:url" content="<?php echo e($canonical); ?>">
<meta property="og:image" content="<?php echo e($resolvedOgImage); ?>">
<meta property="og:locale" content="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<?php if($seoFacebookAppId): ?>
    <meta property="fb:app_id" content="<?php echo e($seoFacebookAppId); ?>">
<?php endif; ?>

<meta name="twitter:card" content="<?php echo e($pageMeta?->twitter_card ?? $seoTwitterCard); ?>">
<meta name="twitter:title" content="<?php echo e($twitterTitle); ?>">
<meta name="twitter:description" content="<?php echo e($twitterDescription); ?>">
<meta name="twitter:image" content="<?php echo e($twitterImage); ?>">
<?php if($seoTwitterHandle): ?>
    <meta name="twitter:site" content="<?php echo e($seoTwitterHandle); ?>">
<?php endif; ?>

<?php if($schemaMarkup && is_array(json_decode($schemaMarkup, true))): ?>
    <script type="application/ld+json"><?php echo json_encode(json_decode($schemaMarkup, true), JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?></script>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\ProDo\EDAA\resources\views/components/seo.blade.php ENDPATH**/ ?>