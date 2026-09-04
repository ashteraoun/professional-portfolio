<div id="project-preview-panel" class="project-preview-panel sticky top-28 hidden lg:block">
    <div class="surface-card overflow-hidden">
        {{-- Preview image / iframe area --}}
        <div class="relative aspect-[16/10] overflow-hidden bg-ink-soft">
            <img id="preview-image" src="" alt="" class="absolute inset-0 h-full w-full object-cover transition-all duration-700 scale-100 opacity-100">
            <div id="preview-placeholder" class="absolute inset-0 flex items-center justify-center bg-gradient-to-br from-accent/10 via-transparent to-purple-500/5">
                <span class="font-display text-6xl font-medium text-accent/20">P</span>
            </div>
            <div id="preview-live-frame-wrap" class="absolute inset-0 hidden bg-ink">
                <iframe id="preview-live-frame" class="h-full w-full border-0" title="Live preview" loading="lazy" sandbox="allow-scripts allow-same-origin allow-forms allow-popups"></iframe>
            </div>
            <div class="absolute inset-0 bg-gradient-to-t from-ink/70 via-transparent to-transparent pointer-events-none"></div>

            {{-- View mode toggle --}}
            <div id="preview-mode-toggle" class="absolute top-4 right-4 hidden items-center gap-1 rounded-full border border-white/10 bg-ink/80 p-1 backdrop-blur-md">
                <button type="button" data-preview-mode="image" class="preview-mode-btn rounded-full px-3 py-1.5 text-[10px] uppercase tracking-wider is-active">Screenshot</button>
                <button type="button" data-preview-mode="live" class="preview-mode-btn rounded-full px-3 py-1.5 text-[10px] uppercase tracking-wider">Live</button>
            </div>
        </div>

        {{-- Preview meta --}}
        <div class="p-6 md:p-8">
            <p id="preview-category" class="label-mono mb-3"></p>
            <h2 id="preview-title" class="font-display text-2xl font-medium md:text-3xl"></h2>
            <p id="preview-subtitle" class="mt-2 text-sm text-muted"></p>
            <p id="preview-excerpt" class="mt-4 text-sm leading-relaxed text-muted"></p>

            <div id="preview-tech" class="mt-5 flex flex-wrap gap-2"></div>

            <div class="mt-6 flex flex-wrap gap-3">
                <a id="preview-case-study" href="#" class="btn-primary text-sm">View Case Study</a>
                <a id="preview-live-link" href="#" target="_blank" rel="noopener noreferrer" class="btn-secondary hidden text-sm">Open Live Site</a>
                <a id="preview-github-link" href="#" target="_blank" rel="noopener noreferrer" class="btn-secondary hidden text-sm">GitHub</a>
            </div>
        </div>
    </div>
</div>
