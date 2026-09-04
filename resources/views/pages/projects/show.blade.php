@extends('layouts.portfolio')

@php
    $seoTitle = $project->seo_title ?? $project->title;
    $seoDescription = $project->seo_description ?? $project->excerpt;
@endphp

@section('content')
    <article class="section-padding pt-32">
        <div class="container-site">
            <header class="max-w-4xl mb-16 reveal">
                @if($project->category)
                    <p class="label-mono mb-4">{{ $project->category->name }} · {{ $project->year }}</p>
                @endif
                <h1 class="display-lg mb-4">{{ $project->title }}</h1>
                @if($project->subtitle)
                    <p class="text-xl text-muted">{{ $project->subtitle }}</p>
                @endif
                @if($project->technologies->isNotEmpty())
                    <div class="mt-6 flex flex-wrap gap-2">
                        @foreach($project->technologies as $tech)
                            <span class="rounded-full border border-white/10 px-3 py-1 text-xs">{{ $tech->name }}</span>
                        @endforeach
                    </div>
                @endif
            </header>

            <div class="aspect-[21/9] rounded-2xl bg-gradient-to-br from-accent/10 to-transparent mb-16 reveal"></div>

            <div class="grid gap-16 lg:grid-cols-3">
                <div class="lg:col-span-2 space-y-12 reveal">
                    @if($project->problem)
                        <section><h2 class="font-display text-2xl mb-4">Overview</h2><p class="text-muted leading-relaxed">{{ $project->problem }}</p></section>
                    @endif
                    @if($project->challenge)
                        <section><h2 class="font-display text-2xl mb-4">Challenge</h2><p class="text-muted leading-relaxed">{{ $project->challenge }}</p></section>
                    @endif
                    @if($project->solution)
                        <section><h2 class="font-display text-2xl mb-4">Solution</h2><p class="text-muted leading-relaxed">{{ $project->solution }}</p></section>
                    @endif
                    @if($project->architecture)
                        <section>
                            <h2 class="font-display text-2xl mb-4">Architecture</h2>
                            <dl class="grid gap-4 sm:grid-cols-2">
                                @foreach($project->architecture as $key => $value)
                                    <div class="surface-card p-4"><dt class="label-mono mb-1">{{ ucfirst($key) }}</dt><dd>{{ is_array($value) ? implode(', ', $value) : $value }}</dd></div>
                                @endforeach
                            </dl>
                        </section>
                    @endif
                    @if($project->features)
                        <section>
                            <h2 class="font-display text-2xl mb-4">Features</h2>
                            <ul class="grid gap-2 sm:grid-cols-2">
                                @foreach($project->features as $feature)
                                    <li class="flex items-center gap-2 text-sm text-muted"><span class="text-accent">→</span>{{ $feature }}</li>
                                @endforeach
                            </ul>
                        </section>
                    @endif
                    @if($project->lessons_learned)
                        <section><h2 class="font-display text-2xl mb-4">Lessons Learned</h2><p class="text-muted">{{ $project->lessons_learned }}</p></section>
                    @endif
                </div>

                <aside class="space-y-8 reveal">
                    <div class="surface-card p-6 sticky top-28">
                        <h3 class="label-mono mb-4">Project Details</h3>
                        @if($project->role)<p class="text-sm"><span class="text-muted">Role:</span> {{ $project->role }}</p>@endif
                        @if($project->year)<p class="text-sm mt-2"><span class="text-muted">Year:</span> {{ $project->year }}</p>@endif
                        <div class="mt-6 flex flex-col gap-3">
                            @if($project->live_url)<a href="{{ $project->live_url }}" target="_blank" rel="noopener" class="btn-primary text-center">Live Demo</a>@endif
                            @if($project->github_url)<a href="{{ $project->github_url }}" target="_blank" rel="noopener" class="btn-secondary text-center">GitHub</a>@endif
                        </div>
                    </div>
                </aside>
            </div>

            @if($relatedProjects->isNotEmpty())
                <section class="mt-24 border-t border-white/10 pt-16">
                    <h2 class="font-display text-2xl mb-8">Related Projects</h2>
                    <div class="grid gap-6 md:grid-cols-3">
                        @foreach($relatedProjects as $related)
                            <x-portfolio.project-card :project="$related" />
                        @endforeach
                    </div>
                </section>
            @endif
        </div>
    </article>
@endsection
