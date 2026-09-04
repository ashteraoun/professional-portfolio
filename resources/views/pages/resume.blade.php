@extends('layouts.portfolio')

@section('content')
    <section class="section-padding pt-32">
        <div class="container-site max-w-3xl">
            <header class="reveal mb-12">
                <p class="label-mono mb-4">Resume</p>
                <h1 class="display-lg mb-2">{{ $site['site_name'] ?? '' }}</h1>
                <p class="text-xl text-muted">{{ $site['site_tagline'] ?? '' }}</p>
                <p class="text-muted mt-6">{{ $site['about_intro'] ?? '' }}</p>
            </header>

            <section class="reveal mb-12">
                <h2 class="font-display text-xl mb-6 border-b border-white/10 pb-3">Experience</h2>
                @foreach($experiences as $exp)
                    <div class="mb-8">
                        <h3 class="font-medium">{{ $exp->role }} — {{ $exp->company }}</h3>
                        <p class="text-sm text-muted">{{ $exp->started_at->format('M Y') }} — {{ $exp->is_current ? 'Present' : $exp->ended_at?->format('M Y') }}</p>
                        <p class="text-sm text-muted mt-2">{{ $exp->description }}</p>
                    </div>
                @endforeach
            </section>

            <section class="reveal mb-12">
                <h2 class="font-display text-xl mb-6 border-b border-white/10 pb-3">Skills</h2>
                <div class="grid gap-6 sm:grid-cols-2">
                    @foreach($skillCategories as $cat)
                        <div>
                            <h3 class="text-sm font-medium mb-2">{{ $cat->name }}</h3>
                            <p class="text-sm text-muted">{{ $cat->skills->pluck('name')->join(', ') }}</p>
                        </div>
                    @endforeach
                </div>
            </section>

            <section class="reveal">
                <h2 class="font-display text-xl mb-6 border-b border-white/10 pb-3">Selected Projects</h2>
                <ul class="space-y-3">
                    @foreach($projects as $project)
                        <li><a href="{{ route('projects.show', $project->slug) }}" class="text-accent hover:underline">{{ $project->title }}</a> — <span class="text-muted text-sm">{{ $project->excerpt }}</span></li>
                    @endforeach
                </ul>
            </section>

            <a href="{{ route('contact') }}" class="btn-primary mt-12 inline-flex">Download CV / Contact</a>
        </div>
    </section>
@endsection
