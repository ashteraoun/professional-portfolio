@extends('layouts.portfolio')

@section('content')
    <section class="section-padding pt-32">
        <div class="container-site">
            <x-portfolio.section-heading label="Portfolio" title="Selected projects." description="Filter by category or technology." />

            <div class="mb-10 flex flex-wrap gap-2 reveal" role="tablist" aria-label="Project filters">
                <a href="{{ route('projects.index') }}" class="rounded-full px-4 py-2 text-sm transition {{ !$activeCategory && !$activeTech ? 'bg-accent text-ink' : 'border border-white/10 text-muted hover:border-accent' }}">All</a>
                @foreach($categories as $cat)
                    <a href="{{ route('projects.index', ['category' => $cat->slug]) }}" class="rounded-full px-4 py-2 text-sm transition {{ $activeCategory === $cat->slug ? 'bg-accent text-ink' : 'border border-white/10 text-muted hover:border-accent' }}">{{ $cat->name }}</a>
                @endforeach
            </div>

            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @forelse($projects as $project)
                    <div class="reveal"><x-portfolio.project-card :project="$project" /></div>
                @empty
                    <p class="text-muted col-span-full">No projects found for this filter.</p>
                @endforelse
            </div>

            <div class="mt-12">{{ $projects->links() }}</div>
        </div>
    </section>
@endsection
