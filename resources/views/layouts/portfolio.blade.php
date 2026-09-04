<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <x-portfolio.seo
        :title="$seoTitle ?? null"
        :description="$seoDescription ?? null"
        :canonical="$canonical ?? null"
        :type="$seoType ?? 'website'"
    />

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=space-grotesk:400,500,600,700|inter:400,500,600&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>
<body class="font-body overflow-x-hidden">
    <a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 focus:z-[200] focus:rounded-md focus:bg-accent focus:px-4 focus:py-2 focus:text-ink">
        Skip to content
    </a>

    <div class="grain-overlay fixed inset-0 z-[1]" aria-hidden="true"></div>

    <div id="custom-cursor" class="custom-cursor" aria-hidden="true">
        <div class="custom-cursor-dot"></div>
    </div>

    <x-portfolio.navbar />

    <main id="main-content">
        @yield('content')
    </main>

    <x-portfolio.footer />

    <x-portfolio.command-palette />

    @stack('scripts')
</body>
</html>
