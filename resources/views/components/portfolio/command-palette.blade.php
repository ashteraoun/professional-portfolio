<div id="command-palette-root" class="hidden" role="dialog" aria-modal="true" aria-label="Command palette">
    <div class="command-palette-backdrop" data-command-close></div>
    <div class="command-palette">
        <div class="border-b border-white/10 p-4">
            <input type="search" id="command-input" placeholder="Search projects, articles, pages..." class="w-full bg-transparent text-sm outline-none placeholder:text-muted" autocomplete="off">
        </div>
        <ul id="command-results" class="max-h-80 overflow-y-auto p-2 text-sm"></ul>
        <div class="border-t border-white/10 px-4 py-2 text-xs text-muted">
            ↑↓ navigate · Enter select · Esc close
        </div>
    </div>
</div>

<script type="application/json" id="command-data">
{!! json_encode([
    ['label' => 'Go Home', 'url' => route('home'), 'group' => 'Pages'],
    ['label' => 'About', 'url' => route('about'), 'group' => 'Pages'],
    ['label' => 'Services', 'url' => route('services.index'), 'group' => 'Pages'],
    ['label' => 'Projects', 'url' => route('projects.index'), 'group' => 'Pages'],
    ['label' => 'Experience', 'url' => route('experience'), 'group' => 'Pages'],
    ['label' => 'Blog', 'url' => route('blog.index'), 'group' => 'Pages'],
    ['label' => 'Packages', 'url' => route('packages.index'), 'group' => 'Pages'],
    ['label' => 'Contact', 'url' => route('contact'), 'group' => 'Pages'],
    ['label' => 'Resume', 'url' => route('resume'), 'group' => 'Pages'],
    ['label' => 'Toggle Dark Mode', 'action' => 'toggle-theme', 'group' => 'Commands'],
    ['label' => 'GitHub', 'url' => $site['github_url'] ?? '#', 'group' => 'External'],
    ['label' => 'LinkedIn', 'url' => $site['linkedin_url'] ?? '#', 'group' => 'External'],
]) !!}
</script>
