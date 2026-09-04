@props(['project'])

<a href="{{ route('projects.show', $project->slug) }}" class="project-card group surface-card block overflow-hidden transition duration-500 hover:border-accent/30 hover:shadow-xl hover:shadow-accent/5">
    <div class="relative aspect-[16/10] overflow-hidden bg-ink-soft">
        @if($project->previewImage())
            <img src="{{ $project->previewImage() }}" alt="{{ $project->title }}" class="project-card-image h-full w-full object-cover" loading="lazy">
        @else
            <div class="flex h-full items-center justify-center bg-gradient-to-br from-accent/10 to-transparent">
                <span class="font-display text-4xl font-medium text-accent/40">{{ substr($project->title, 0, 1) }}</span>
            </div>
        @endif
        <div class="absolute inset-0 bg-gradient-to-t from-ink via-ink/20 to-transparent opacity-60"></div>
        @if($project->live_url)
            <span class="absolute top-4 right-4 rounded-full border border-accent/40 bg-ink/70 px-2.5 py-1 text-[10px] uppercase tracking-wider text-accent backdrop-blur-sm">Live</span>
        @endif
        <div class="absolute bottom-4 left-4 right-4 translate-y-2 opacity-0 transition duration-500 group-hover:translate-y-0 group-hover:opacity-100">
            <span class="text-xs text-accent">View case study →</span>
        </div>
    </div>

    <div class="p-6 md:p-8">
        <div class="mb-3 flex items-center gap-3 text-xs text-muted">
            @if($project->category)
                <span class="text-accent">{{ $project->category->name }}</span>
            @endif
            @if($project->year)
                <span>{{ $project->year }}</span>
            @endif
        </div>
        <h3 class="font-display text-xl font-medium transition group-hover:text-accent md:text-2xl">{{ $project->title }}</h3>
        @if($project->excerpt)
            <p class="mt-3 text-sm text-muted line-clamp-2">{{ $project->excerpt }}</p>
        @endif
        @if($project->technologies->isNotEmpty())
            <div class="mt-4 flex flex-wrap gap-2">
                @foreach($project->technologies->take(4) as $tech)
                    <span class="rounded-full border border-white/10 px-2.5 py-1 text-[11px] text-muted">{{ $tech->name }}</span>
                @endforeach
            </div>
        @endif
    </div>
</a>
