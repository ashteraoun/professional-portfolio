<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script>
        (function() {
            const storedTheme = localStorage.getItem('theme');
            if (storedTheme === 'dark') {
                document.documentElement.classList.add('dark');
            } else if (storedTheme === 'light') {
                document.documentElement.classList.remove('dark');
            } else if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
                document.documentElement.classList.add('dark');
            }
        })();
    </script>

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

    <div class="fixed inset-0 overflow-hidden" style="z-index:-1;" aria-hidden="true">
        <div class="blob blob-violet float-slow" style="width:520px;height:520px;top:-10%;left:-10%;"></div>
        <div class="blob blob-pink float-slower" style="width:460px;height:460px;top:20%;right:-12%;"></div>
        <div class="blob blob-orange float-slow" style="width:400px;height:400px;bottom:-10%;left:15%;"></div>
        <div class="blob blob-cyan float-slower" style="width:380px;height:380px;bottom:5%;right:10%;"></div>
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
