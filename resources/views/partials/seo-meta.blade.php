@php
    $seoTitle = $seoTitle ?? ($content->meta_title ?: $content->hero_name . ' - Portfolio');
    $seoDescription = $seoDescription ?? ($content->meta_description ?: $content->hero_description ?: $content->hero_name . ' - Full Stack Developer Portfolio');
    $seoDescription = \Illuminate\Support\Str::limit(strip_tags($seoDescription), 160);
    $seoKeywords = $seoKeywords ?? ($content->meta_keywords ?: 'Full Stack Developer, Laravel, Vue.js, PHP, ' . $content->hero_name);
    $seoUrl = $seoUrl ?? url()->current();
    $seoImage = $seoImage ?? ($content->og_image ? asset('storage/' . $content->og_image) : ($content->profile_image ? asset('storage/' . $content->profile_image) : asset('images/profile.jpg')));
    $seoType = $seoType ?? 'website';
    $seoSiteName = $content->hero_name . ' Portfolio';
    $seoTwitterRaw = $content->twitter_handle ?: '';
    $seoTwitterHandle = $seoTwitterRaw
        ? (str_starts_with($seoTwitterRaw, '@') ? $seoTwitterRaw : '@' . $seoTwitterRaw)
        : '';
@endphp

<title>{{ $seoTitle }}</title>
<meta name="description" content="{{ $seoDescription }}">
<meta name="keywords" content="{{ $seoKeywords }}">
<meta name="author" content="{{ $content->hero_name }}">
<link rel="canonical" href="{{ $seoUrl }}">

{{-- Open Graph (Facebook, LinkedIn, etc.) --}}
<meta property="og:type" content="{{ $seoType }}">
<meta property="og:title" content="{{ $seoTitle }}">
<meta property="og:description" content="{{ $seoDescription }}">
<meta property="og:url" content="{{ $seoUrl }}">
<meta property="og:image" content="{{ $seoImage }}">
<meta property="og:image:alt" content="{{ $content->hero_name }}">
<meta property="og:site_name" content="{{ $seoSiteName }}">
<meta property="og:locale" content="en_US">

{{-- Twitter Card --}}
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $seoTitle }}">
<meta name="twitter:description" content="{{ $seoDescription }}">
<meta name="twitter:image" content="{{ $seoImage }}">
@if($seoTwitterHandle)
    <meta name="twitter:creator" content="{{ $seoTwitterHandle }}">
    <meta name="twitter:site" content="{{ $seoTwitterHandle }}">
@endif

{{-- Favicon set --}}
<link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
<link rel="alternate icon" href="{{ asset('favicon.ico') }}">
<link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">
<meta name="theme-color" content="#6366f1">
