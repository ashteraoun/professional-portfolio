@php
    $navLinks = [
        ['label' => 'Home', 'route' => 'home', 'hash' => null],
        ['label' => 'About', 'route' => 'about', 'hash' => null],
        ['label' => 'Projects', 'route' => 'projects.index', 'hash' => null],
        ['label' => 'Experience', 'route' => 'experience', 'hash' => null],
        ['label' => 'Blog', 'route' => 'blog.index', 'hash' => null],
        ['label' => 'Packages', 'route' => 'packages.index', 'hash' => null],
        ['label' => 'Contact', 'route' => 'contact', 'hash' => null],
    ];
@endphp

<header id="site-nav" class="fixed top-0 left-0 right-0 z-50 px-3 pt-3 transition-all duration-500 sm:px-5 sm:pt-4">
    <div class="container-site">
        <div class="pill-nav flex h-16 items-center justify-between px-4 shadow-lg shadow-black/10 sm:px-5">
            <a href="{{ route('home') }}" class="flex items-center gap-2 font-display text-lg font-bold tracking-tight">
                <span class="icon-chip !h-9 !w-9 text-sm spin-slow" style="animation-duration:8s;">{{ strtoupper(substr($site['site_name'] ?? config('app.name'), 0, 1)) }}</span>
                <span class="gradient-text">{{ $site['site_name'] ?? config('app.name') }}</span>
            </a>

            <nav class="hidden items-center gap-1 lg:flex" aria-label="Primary">
                @foreach ($navLinks as $link)
                    <a href="{{ route($link['route']) }}"
                       class="relative rounded-full px-3 py-2 text-sm font-medium text-muted transition hover:text-accent {{ request()->routeIs($link['route']) ? 'gradient-text font-semibold' : '' }}"
                       @if(request()->routeIs($link['route'])) aria-current="page" @endif>
                        {{ $link['label'] }}
                    </a>
                @endforeach

                {{-- Services Dropdown --}}
                <x-portfolio.services-dropdown />
            </nav>

            <div class="flex items-center gap-2">
                <button type="button" id="theme-toggle" class="rounded-full p-2 text-muted transition hover:text-accent" aria-label="Toggle theme">
                    <svg class="h-5 w-5 dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                    <svg class="hidden h-5 w-5 dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </button>

                <button type="button" id="command-trigger" class="hidden rounded-full border px-3 py-1.5 text-xs text-muted transition hover:border-accent hover:text-accent sm:inline-flex items-center gap-2" aria-label="Open command palette">
                    <span>Search</span>
                    <kbd class="rounded bg-white/5 px-1.5 py-0.5 font-mono text-[10px]">⌘K</kbd>
                </button>

                <a href="{{ route('contact') }}" class="btn-primary magnetic-btn hidden !py-2.5 sm:inline-flex">
                    Let's Work Together
                </a>

                <button type="button" id="mobile-menu-toggle" class="rounded-md p-2 text-muted lg:hidden" aria-expanded="false" aria-controls="mobile-menu" aria-label="Open menu">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
            </div>
        </div>

        <div id="mobile-menu" class="pill-nav mt-2 hidden overflow-hidden lg:hidden" aria-hidden="true">
            <nav class="flex flex-col gap-1 p-3" aria-label="Mobile">
                @foreach ($navLinks as $link)
                    <a href="{{ route($link['route']) }}" class="rounded-lg px-3 py-3 text-sm {{ request()->routeIs($link['route']) ? 'gradient-text font-semibold bg-accent-soft' : 'text-muted' }}">
                        {{ $link['label'] }}
                    </a>
                @endforeach
                <a href="{{ route('contact') }}" class="btn-primary mt-2 justify-center">Let's Work Together</a>
            </nav>
        </div>
    </div>
</header>
