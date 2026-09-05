@extends('layouts.portfolio')

@php
    $seoTitle = $project->seo_title ?? $project->title;
    $seoDescription = $project->seo_description ?? $project->excerpt;
    $heroImage = $project->coverImage();
    $galleryItems = $project->gallery;
@endphp

@section('content')
    {{-- Hero --}}
    <section class="relative pt-24 md:pt-28">
        <div class="container-site">
            <div class="reveal mb-8 max-w-4xl">
                @if($project->category)
                    <p class="label-mono mb-4">{{ $project->category->name }} · {{ $project->year }}</p>
                @endif
                <h1 class="display-lg mb-4"><span class="gradient-text">{{ $project->title }}</span></h1>
                @if($project->subtitle)
                    <p class="text-xl text-muted">{{ $project->subtitle }}</p>
                @endif
            </div>

            {{-- Hero media --}}
            <div class="reveal relative mb-12 overflow-hidden rounded-2xl border border-white/10">
                @if($project->video_url)
                    <div class="aspect-[21/9] bg-ink-soft">
                        <iframe src="{{ $project->video_url }}" class="h-full w-full" allowfullscreen loading="lazy" title="{{ $project->title }} demo"></iframe>
                    </div>
                @elseif($heroImage)
                    <div class="relative aspect-[21/9] overflow-hidden">
                        <img src="{{ $heroImage }}" alt="{{ $project->title }}" class="h-full w-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-ink/60 via-transparent to-transparent"></div>
                    </div>
                @else
                    <div class="aspect-[21/9] bg-gradient-to-br from-accent/10 via-ink-soft to-purple-500/5"></div>
                @endif

                {{-- Quick actions overlay --}}
                <div class="absolute bottom-6 left-6 right-6 flex flex-wrap gap-3">
                    @if($project->live_url)
                        <a href="{{ $project->live_url }}" target="_blank" rel="noopener noreferrer" class="btn-primary text-sm">Open Live Site</a>
                    @endif
                    @if($project->github_url)
                        <a href="{{ $project->github_url }}" target="_blank" rel="noopener noreferrer" class="btn-secondary text-sm">View on GitHub</a>
                    @endif
                </div>
            </div>

            @if($project->technologies->isNotEmpty())
                <div class="reveal mb-12 flex flex-wrap gap-2">
                    @foreach($project->technologies as $tech)
                        <span class="tech-tag">{{ $tech->name }}</span>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    {{-- Live preview embed --}}
    @if($project->live_url)
    <section class="section-padding border-t border-white/10 !py-12 md:!py-16">
        <div class="container-site reveal">
            <div class="mb-6 flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="label-mono mb-2">Live Preview</p>
                    <h2 class="font-display text-2xl font-medium">Experience the product</h2>
                </div>
                <a href="{{ $project->live_url }}" target="_blank" rel="noopener noreferrer" class="text-sm text-accent link-underline">Open in new tab →</a>
            </div>
            <div class="overflow-hidden rounded-2xl border border-white/10 bg-ink-soft shadow-2xl shadow-black/20">
                <div class="flex items-center gap-2 border-b border-white/10 px-4 py-3">
                    <span class="h-2.5 w-2.5 rounded-full bg-red-400/80"></span>
                    <span class="h-2.5 w-2.5 rounded-full bg-yellow-400/80"></span>
                    <span class="h-2.5 w-2.5 rounded-full bg-green-400/80"></span>
                    <span class="ml-3 truncate text-xs text-muted">{{ parse_url($project->live_url, PHP_URL_HOST) }}</span>
                </div>
                <div class="relative aspect-[16/10] w-full">
                    <iframe src="{{ $project->live_url }}" class="absolute inset-0 h-full w-full border-0" loading="lazy" title="{{ $project->title }} live preview" sandbox="allow-scripts allow-same-origin allow-forms allow-popups"></iframe>
                </div>
            </div>
        </div>
    </section>
    @endif

    {{-- Gallery --}}
    @if($galleryItems->isNotEmpty())
        <div class="container-site">
            <x-portfolio.project-gallery :items="$galleryItems" />
        </div>
    @endif

    {{-- Content --}}
    <section class="section-padding">
        <div class="container-site">
            <div class="grid gap-16 lg:grid-cols-3">
                <div class="lg:col-span-2 space-y-12">
                    @foreach([
                        'Overview' => $project->problem,
                        'Challenge' => $project->challenge,
                        'Solution' => $project->solution,
                    ] as $heading => $content)
                        @if($content)
                            <section class="reveal project-content-block">
                                <h2 class="font-display text-2xl mb-4">{{ $heading }}</h2>
                                <p class="text-muted leading-relaxed text-lg">{{ $content }}</p>
                            </section>
                        @endif
                    @endforeach

                    @if($project->architecture)
                        <section class="reveal project-content-block">
                            <h2 class="font-display text-2xl mb-6">Architecture</h2>
                            <dl class="grid gap-4 sm:grid-cols-2">
                                @foreach($project->architecture as $key => $value)
                                    <div class="glow-card p-5">
                                        <dt class="label-mono mb-2">{{ ucfirst($key) }}</dt>
                                        <dd class="text-sm">{{ is_array($value) ? implode(', ', $value) : $value }}</dd>
                                    </div>
                                @endforeach
                            </dl>
                        </section>
                    @endif

                    @if($project->features)
                        <section class="reveal project-content-block">
                            <h2 class="font-display text-2xl mb-6">Features</h2>
                            <ul class="grid gap-3 sm:grid-cols-2">
                                @foreach($project->features as $feature)
                                    <li class="flex items-start gap-3 rounded-xl border border-white/10 bg-white/[0.02] p-4 text-sm text-muted transition hover:border-accent/30">
                                        <span class="gradient-text font-bold mt-0.5">→</span>{{ $feature }}
                                    </li>
                                @endforeach
                            </ul>
                        </section>
                    @endif

                    @if($project->results)
                        <section class="reveal project-content-block">
                            <h2 class="font-display text-2xl mb-6">Results</h2>
                            <dl class="grid gap-4 sm:grid-cols-2">
                                @foreach($project->results as $key => $value)
                                    <div class="glow-card p-5">
                                        <dt class="text-xs uppercase tracking-wider text-muted">{{ $key }}</dt>
                                        <dd class="gradient-number mt-1 text-2xl font-bold">{{ $value }}</dd>
                                    </div>
                                @endforeach
                            </dl>
                        </section>
                    @endif

                    @if($project->lessons_learned)
                        <section class="reveal project-content-block">
                            <h2 class="font-display text-2xl mb-4">Lessons Learned</h2>
                            <p class="text-muted leading-relaxed">{{ $project->lessons_learned }}</p>
                        </section>
                    @endif
                </div>

                <aside class="reveal">
                    <div class="glow-card sticky top-28 p-6 md:p-8">
                        <h3 class="label-mono mb-6">Project Details</h3>
                        <dl class="space-y-4 text-sm">
                            @if($project->role)<div><dt class="text-muted">Role</dt><dd class="mt-1 font-medium">{{ $project->role }}</dd></div>@endif
                            @if($project->year)<div><dt class="text-muted">Year</dt><dd class="mt-1 font-medium">{{ $project->year }}</dd></div>@endif
                            @if($project->category)<div><dt class="text-muted">Category</dt><dd class="mt-1 font-medium">{{ $project->category->name }}</dd></div>@endif
                        </dl>
                        <div class="mt-8 flex flex-col gap-3">
                            @if($project->live_url)<a href="{{ $project->live_url }}" target="_blank" rel="noopener" class="btn-primary text-center text-sm">Live Demo</a>@endif
                            @if($project->github_url)<a href="{{ $project->github_url }}" target="_blank" rel="noopener" class="btn-secondary text-center text-sm">GitHub</a>@endif
                            <a href="{{ route('contact') }}" class="btn-secondary text-center text-sm">Start Similar Project</a>
                        </div>
                    </div>
                </aside>
            </div>

            @if($relatedProjects->isNotEmpty())
                <section class="mt-24 border-t border-white/10 pt-16 reveal">
                    <h2 class="font-display text-2xl mb-8">Related Projects</h2>
                    <div class="grid gap-6 md:grid-cols-3">
                        @foreach($relatedProjects as $related)
                            <x-portfolio.project-card :project="$related" />
                        @endforeach
                    </div>
                </section>
            @endif
        </div>
    </section>
@endsection
