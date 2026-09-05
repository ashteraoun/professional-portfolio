@props(['project', 'active' => false, 'index' => 0])

@php
    $preview = $project->toPreviewArray();
@endphp

<button
    type="button"
    class="project-list-item group w-full text-left transition-all duration-500 {{ $active ? 'is-active' : '' }}"
    data-project-preview="{{ json_encode($preview) }}"
    data-project-index="{{ $index }}"
    aria-pressed="{{ $active ? 'true' : 'false' }}"
>
    <div class="flex items-start gap-5 rounded-2xl border p-5 transition-all duration-500 {{ $active ? 'border-accent/40 bg-accent-soft/30 shadow-lg shadow-accent/10' : 'border-white/10 bg-white/[0.02] hover:border-white/20 hover:bg-white/[0.04]' }}">
        <span class="gradient-number mt-1 shrink-0 text-sm font-bold">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>

        <div class="min-w-0 flex-1">
            <div class="mb-2 flex flex-wrap items-center gap-2 text-xs">
                @if($project->category)
                    <span class="text-accent">{{ $project->category->name }}</span>
                @endif
                @if($project->year)
                    <span class="text-muted">{{ $project->year }}</span>
                @endif
                @if($project->live_url)
                    <span class="rounded-full border border-accent/30 px-2 py-0.5 text-[10px] uppercase tracking-wider text-accent">Live</span>
                @endif
            </div>

            <h3 class="project-list-item-title font-display text-xl font-medium transition md:text-2xl">{{ $project->title }}</h3>

            @if($project->excerpt)
                <p class="mt-2 text-sm leading-relaxed text-muted line-clamp-2">{{ $project->excerpt }}</p>
            @endif

            @if($project->technologies->isNotEmpty())
                <div class="mt-3 flex flex-wrap gap-1.5">
                    @foreach($project->technologies->take(5) as $tech)
                        <span class="rounded-full border border-white/10 px-2 py-0.5 text-[10px] text-muted">{{ $tech->name }}</span>
                    @endforeach
                </div>
            @endif
        </div>

        <span class="project-list-item-arrow mt-2 shrink-0 text-muted transition group-hover:translate-x-1" aria-hidden="true">→</span>
    </div>
</button>
