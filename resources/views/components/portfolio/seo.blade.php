@props([
    'title' => null,
    'description' => null,
    'canonical' => null,
    'type' => 'website',
    'image' => null,
])

@php
    $siteName = $site['site_name'] ?? config('app.name');
    $pageTitle = $title ?? ($site['seo_default_title'] ?? $siteName);
    $pageDescription = $description ?? ($site['seo_default_description'] ?? '');
    $pageUrl = $canonical ?? url()->current();
    $pageImage = $image ?? asset('images/og-default.jpg');
@endphp

<title>{{ $pageTitle }} — {{ $siteName }}</title>
<meta name="description" content="{{ $pageDescription }}">
<link rel="canonical" href="{{ $pageUrl }}">

<meta property="og:type" content="{{ $type }}">
<meta property="og:title" content="{{ $pageTitle }}">
<meta property="og:description" content="{{ $pageDescription }}">
<meta property="og:url" content="{{ $pageUrl }}">
<meta property="og:site_name" content="{{ $siteName }}">

<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $pageTitle }}">
<meta name="twitter:description" content="{{ $pageDescription }}">

<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'Person',
    'name' => $siteName,
    'url' => url('/'),
    'jobTitle' => $site['site_tagline'] ?? 'Software Engineer',
    'sameAs' => $socialLinks->pluck('url')->filter()->values(),
], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
</script>
