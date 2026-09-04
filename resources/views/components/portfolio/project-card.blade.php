@props(['project'])

<a href="{{ route('projects.show', $project->slug) }}" class="project-card group surface-card block overflow-hidden transition hover:border-accent/30">
    <div class="relative aspect-[16/10] overflow-hidden bg-ink-soft">
        @if($project->thumbnail)
            <img src="{{ asset('storage/'.$project->thumbnail) }}" alt="{{ $project->title }}" class="project-card-image h-full w-full object-cover" loading="lazy">
        @else
            <div class="flex h-full items-center justify-center bg-gradient-to-br from-accent/10 to-transparent">
                <span class="font-display text-4xl font-medium text-accent/40">{{ substr($project->title, 0, 1) }}</span>
            </div>
        @endif
        <div class="absolute inset-0 bg-gradient-to-t from-ink/80 via-transparent to-transparent opacity-0 transition group-hover:opacity-100"></div>
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
