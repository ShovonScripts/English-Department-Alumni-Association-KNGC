@props([
    'title' => null,
    'description' => null,
    'image' => null,
    'type' => 'website',
])

@php
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
@endphp

<title>{{ $pageTitle }}</title>
<meta name="description" content="{{ $metaDescription }}">
@if ($seoKeywords || $pageMeta?->keywords)
    <meta name="keywords" content="{{ $pageMeta?->keywords ?? $seoKeywords }}">
@endif
<meta name="robots" content="{{ $robotsDirective }}">
<link rel="canonical" href="{{ $canonical }}">

@if ($seoVerificationCode)
    <meta name="google-site-verification" content="{{ $seoVerificationCode }}">
@endif

<meta property="og:type" content="{{ $resolvedType }}">
<meta property="og:site_name" content="{{ $siteName }}">
<meta property="og:title" content="{{ $ogTitle }}">
<meta property="og:description" content="{{ $ogDescription }}">
<meta property="og:url" content="{{ $canonical }}">
<meta property="og:image" content="{{ $resolvedOgImage }}">
<meta property="og:locale" content="{{ str_replace('_', '-', app()->getLocale()) }}">
@if ($seoFacebookAppId)
    <meta property="fb:app_id" content="{{ $seoFacebookAppId }}">
@endif

<meta name="twitter:card" content="{{ $pageMeta?->twitter_card ?? $seoTwitterCard }}">
<meta name="twitter:title" content="{{ $twitterTitle }}">
<meta name="twitter:description" content="{{ $twitterDescription }}">
<meta name="twitter:image" content="{{ $twitterImage }}">
@if ($seoTwitterHandle)
    <meta name="twitter:site" content="{{ $seoTwitterHandle }}">
@endif

@if ($schemaMarkup && is_array(json_decode($schemaMarkup, true)))
    <script type="application/ld+json">{!! json_encode(json_decode($schemaMarkup, true), JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!}</script>
@endif
