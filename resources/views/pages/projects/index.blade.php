@extends('layouts.portfolio')

@section('content')
    <section class="section-padding pt-28 md:pt-32">
        <div class="container-site">
            {{-- Header --}}
            <div class="reveal mb-12 max-w-3xl">
                <p class="label-mono mb-4">Portfolio</p>
                <h1 class="display-lg mb-4">Selected work.<br><span class="text-muted">Engineered with precision.</span></h1>
                <p class="text-lg text-muted">Explore projects with live previews, case studies, and full galleries.</p>
            </div>

            {{-- Filters --}}
            <div class="reveal mb-8 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                <div class="flex flex-wrap gap-2" role="tablist" aria-label="Category filters">
                    <a href="{{ route('projects.index', request()->only('tech')) }}"
                       class="filter-pill {{ !$activeCategory && !$activeTech ? 'is-active' : '' }}">All</a>
                    @foreach($categories as $cat)
                        <a href="{{ route('projects.index', array_filter(['category' => $cat->slug, 'tech' => $activeTech])) }}"
                           class="filter-pill {{ $activeCategory === $cat->slug ? 'is-active' : '' }}">{{ $cat->name }}</a>
                    @endforeach
                </div>
                <div class="flex flex-wrap gap-2" aria-label="Technology filters">
                    @foreach($technologies->take(8) as $technology)
                        <a href="{{ route('projects.index', array_filter(['tech' => $technology->slug, 'category' => $activeCategory])) }}"
                           class="filter-pill filter-pill-sm {{ $activeTech === $technology->slug ? 'is-active' : '' }}">{{ $technology->name }}</a>
                    @endforeach
                </div>
            </div>

            @if($projects->isEmpty())
                <div class="reveal surface-card p-12 text-center">
                    <p class="text-muted">No projects match this filter.</p>
                    <a href="{{ route('projects.index') }}" class="btn-secondary mt-6 inline-flex">Clear filters</a>
                </div>
            @else
                {{-- Main layout: list + preview --}}
                <div class="grid gap-10 lg:grid-cols-[1fr_420px] xl:grid-cols-[1fr_480px] lg:gap-12">
                    <div class="space-y-4" id="project-list" data-projects-index>
                        @foreach($projects as $i => $project)
                            <div class="reveal" style="transition-delay: {{ min($i * 0.05, 0.4) }}s">
                                <x-portfolio.project-list-item :project="$project" :active="$i === 0" :index="$i" />
                            </div>
                        @endforeach
                    </div>

                    <x-portfolio.project-preview-panel />
                </div>

                {{-- Mobile preview card (shows active project) --}}
                <div id="mobile-project-preview" class="mt-8 lg:hidden reveal surface-card overflow-hidden"></div>

                <div class="mt-12">{{ $projects->links() }}</div>
            @endif
        </div>
    </section>

    @if($spotlightProject && $projects->isNotEmpty())
        <script type="application/json" id="projects-default-preview">
            {!! json_encode($spotlightProject->toPreviewArray()) !!}
        </script>
    @endif
@endsection
