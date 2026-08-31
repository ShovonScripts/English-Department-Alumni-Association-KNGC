@props([
    'title' => null,
    'description' => null,
    'image' => null,
    'type' => 'website',
])

@php
    $site = config('site');
    $pageTitle = $title ? "{$title} | {$site['name']}" : $site['name'];
    $metaDescription = $description ?? $site['meta']['default_description'];
    $canonical = url()->current();
    $ogImage = url($image ?? $site['meta']['og_image']);
@endphp

<title>{{ $pageTitle }}</title>
<meta name="description" content="{{ $metaDescription }}">
<meta name="robots" content="index, follow">
<link rel="canonical" href="{{ $canonical }}">

<meta property="og:type" content="{{ $type }}">
<meta property="og:site_name" content="{{ $site['name'] }}">
<meta property="og:title" content="{{ $pageTitle }}">
<meta property="og:description" content="{{ $metaDescription }}">
<meta property="og:url" content="{{ $canonical }}">
<meta property="og:image" content="{{ $ogImage }}">
<meta property="og:locale" content="{{ str_replace('_', '-', app()->getLocale()) }}">

<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $pageTitle }}">
<meta name="twitter:description" content="{{ $metaDescription }}">
<meta name="twitter:image" content="{{ $ogImage }}">