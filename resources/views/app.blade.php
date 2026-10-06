<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
        (() => {
            const theme = localStorage.getItem('theme');
            if (theme === 'light') document.documentElement.classList.remove('dark');
            else if (theme === 'dark' || window.matchMedia('(prefers-color-scheme: dark)').matches) {
                document.documentElement.classList.add('dark');
            }
            if (window.location.pathname.startsWith('/admin') || window.location.pathname.startsWith('/profile')) {
                document.documentElement.classList.add('admin-root');
                document.documentElement.classList.remove('dark');
            }
            if (localStorage.getItem('admin-theme') === 'dark') {
                document.documentElement.classList.add('admin-dark');
            }
        })();
    </script>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=space-grotesk:400,500,600,700|inter:400,500,600|figtree:400,500,600,700&display=swap" rel="stylesheet">
    @inertiaHead
    @vite('resources/js/app.jsx')
</head>
<body>
    @inertia
</body>
</html>
