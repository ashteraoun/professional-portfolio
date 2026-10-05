<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', 'Sign in') — {{ config('app.name', 'Portfolio') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=space-grotesk:400,500,600,700|inter:400,500,600&display=swap" rel="stylesheet">
        @if(!empty($site['favicon_path'] ?? null))
            <link rel="icon" href="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($site['favicon_path']) }}">
        @endif

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="auth-page">
        <main class="auth-layout">
            <section class="auth-aside" aria-label="Portfolio workspace">
                <a href="{{ route('home') }}" class="auth-brand">
                    <span class="auth-brand-mark">{{ strtoupper(substr(config('app.name', 'P'), 0, 1)) }}</span>
                    <span>{{ config('app.name', 'Portfolio') }}</span>
                </a>

                <div class="auth-aside-content">
                    <p class="auth-kicker"><span></span> Portfolio workspace</p>
                    <h1>Your work,<br>beautifully managed.</h1>
                    <p class="auth-aside-copy">A focused space to shape your projects, share your stories, and keep your portfolio up to date.</p>

                    <div class="auth-preview" aria-hidden="true">
                        <div class="auth-preview-top">
                            <span class="auth-preview-dots"><i></i><i></i><i></i></span>
                            <span>Workspace</span>
                            <span class="auth-preview-avatar">{{ strtoupper(substr(config('app.name', 'P'), 0, 1)) }}</span>
                        </div>
                        <div class="auth-preview-content">
                            <div class="auth-preview-heading">
                                <span>Good to see you</span>
                                <span class="auth-preview-sparkle">✦</span>
                            </div>
                            <div class="auth-preview-cards">
                                <div><span class="auth-preview-icon">↗</span><span>Projects</span></div>
                                <div><span class="auth-preview-icon">✎</span><span>Stories</span></div>
                                <div><span class="auth-preview-icon">⌑</span><span>Messages</span></div>
                            </div>
                            <div class="auth-preview-lines"><i></i><i></i><i></i></div>
                        </div>
                    </div>
                </div>

                <p class="auth-aside-footer">&copy; {{ date('Y') }} {{ config('app.name', 'Portfolio') }}. All rights reserved.</p>
            </section>

            <section class="auth-main">
                <div class="auth-main-top">
                    <a href="{{ route('home') }}" class="auth-back-link">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path d="M15 18l-6-6 6-6M9 12h12" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        Back to portfolio
                    </a>
                </div>

                <div class="auth-form-card">
                    {{ $slot }}
                </div>

                <p class="auth-main-footer">Secure access to your portfolio workspace</p>
            </section>
        </main>
    </body>
</html>
