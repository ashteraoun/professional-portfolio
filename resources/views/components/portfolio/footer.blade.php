<footer class="relative overflow-hidden border-t border-white/10 section-padding">
    <div class="pointer-events-none absolute inset-0 -z-10" style="background: var(--gradient-brand-soft); opacity:0.5;" aria-hidden="true"></div>

    <div class="container-site">
        <div class="glow-card reveal mb-16 max-w-3xl p-8 md:p-12">
            <p class="label-mono mb-4">✦ Next Step</p>
            <h2 class="display-lg mb-6">{{ $site['footer_statement'] ?? 'Have an idea worth building?' }}</h2>
            <a href="{{ route('contact') }}" class="btn-primary magnetic-btn">{{ $site['footer_cta'] ?? 'Start a Conversation' }}</a>
        </div>

        <div class="grid gap-10 border-t border-white/10 pt-10 md:grid-cols-4">
            <div>
                <p class="font-display text-lg font-semibold">{{ $site['site_name'] ?? config('app.name') }}</p>
                <p class="mt-2 text-sm text-muted">{{ $site['site_tagline'] ?? '' }}</p>
                <p class="mt-4 text-sm text-muted">{{ $site['hero_status'] ?? '' }}</p>
            </div>

            <div>
                <p class="label-mono mb-4">Navigate</p>
                <ul class="space-y-2 text-sm text-muted">
                    <li><a href="{{ route('about') }}" class="link-underline hover:text-accent">About</a></li>
                    <li><a href="{{ route('projects.index') }}" class="link-underline hover:text-accent">Projects</a></li>
                    <li><a href="{{ route('services.index') }}" class="link-underline hover:text-accent">Services</a></li>
                    <li><a href="{{ route('blog.index') }}" class="link-underline hover:text-accent">Blog</a></li>
                    <li><a href="{{ route('resume') }}" class="link-underline hover:text-accent">Resume</a></li>
                </ul>
            </div>

            <div>
                <p class="label-mono mb-4">Connect</p>
                <ul class="space-y-2 text-sm text-muted">
                    @foreach ($socialLinks as $link)
                        <li><a href="{{ $link->url }}" target="_blank" rel="noopener noreferrer" class="link-underline hover:text-accent">{{ $link->platform }}</a></li>
                    @endforeach
                    @if(!empty($site['contact_email']))
                        <li><a href="mailto:{{ $site['contact_email'] }}" class="link-underline hover:text-accent">{{ $site['contact_email'] }}</a></li>
                    @endif
                </ul>
            </div>

            <div>
                <p class="label-mono mb-4">Availability</p>
                <p class="text-sm text-muted">{{ $site['location'] ?? 'Remote' }}</p>
                <p class="mt-2 text-sm text-accent">{{ $site['hero_status'] ?? '' }}</p>
            </div>
        </div>

        <div class="mt-12 flex flex-col gap-2 border-t border-white/10 pt-6 text-xs text-muted sm:flex-row sm:items-center sm:justify-between">
            <p>&copy; {{ date('Y') }} {{ $site['site_name'] ?? config('app.name') }}. All rights reserved.</p>
            <p>Engineered with Laravel &amp; precision.</p>
        </div>
    </div>
</footer>
