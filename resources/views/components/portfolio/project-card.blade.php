@props(['project'])

<a href="{{ route('projects.show', $project->slug) }}" class="project-card glow-card group block">
    <div class="relative aspect-[16/10] overflow-hidden bg-ink-soft">
        @if($project->previewImage())
            <img src="{{ $project->previewImage() }}" alt="{{ $project->title }}" class="project-card-image h-full w-full object-cover" loading="lazy">
        @else
            <div class="flex h-full items-center justify-center" style="background: var(--gradient-brand-soft);">
                <span class="gradient-text font-display text-4xl font-bold">{{ substr($project->title, 0, 1) }}</span>
            </div>
        @endif
        <div class="absolute inset-0 bg-gradient-to-t from-ink via-ink/10 to-transparent opacity-70"></div>
        @if($project->live_url)
            <span class="absolute top-4 right-4 flex items-center gap-1.5 rounded-full px-3 py-1 text-[10px] font-semibold uppercase tracking-wider text-white shadow-lg" style="background: var(--gradient-cta);">
                <span class="h-1.5 w-1.5 rounded-full bg-white animate-pulse"></span> Live
            </span>
        @endif
        <div class="absolute bottom-4 left-4 right-4 translate-y-2 opacity-0 transition duration-500 group-hover:translate-y-0 group-hover:opacity-100">
            <span class="gradient-text text-sm font-semibold">View case study →</span>
        </div>
    </div>

    <div class="p-6 md:p-8">
        <div class="mb-3 flex items-center gap-3 text-xs text-muted">
            @if($project->category)
                <span class="font-semibold text-accent">{{ $project->category->name }}</span>
            @endif
            @if($project->year)
                <span>{{ $project->year }}</span>
            @endif
        </div>
        <h3 class="font-display text-xl font-medium transition-all duration-300 group-hover:gradient-text md:text-2xl">{{ $project->title }}</h3>
        @if($project->excerpt)
            <p class="mt-3 text-sm text-muted line-clamp-2">{{ $project->excerpt }}</p>
        @endif
        @if($project->technologies->isNotEmpty())
            <div class="mt-4 flex flex-wrap gap-2">
                @foreach($project->technologies->take(4) as $tech)
                    <span class="tech-tag">{{ $tech->name }}</span>
                @endforeach
            </div>
        @endif
    </div>
</a>
