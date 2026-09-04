@extends('layouts.portfolio')

@section('content')
    {{-- Hero --}}
    <section class="relative min-h-screen flex items-center pt-20 overflow-hidden">
        <div class="hero-grid absolute inset-0" aria-hidden="true"></div>
        <div id="hero-glow" class="pointer-events-none absolute top-1/4 left-1/2 h-[500px] w-[500px] -translate-x-1/2 rounded-full bg-accent/10 blur-[120px]" aria-hidden="true"></div>

        <div class="container-site relative z-10 py-20">
            <div class="max-w-4xl">
                <p class="label-mono mb-6 reveal">{{ $site['hero_status'] ?? 'AVAILABLE FOR SELECT PROJECTS' }}</p>
                <h1 class="display-xl mb-8 reveal" style="transition-delay: 0.1s">
                    {{ $site['hero_headline'] ?? 'Building Digital Products That Move Ideas Forward.' }}
                </h1>
                <p class="text-lg md:text-xl text-muted max-w-2xl leading-relaxed reveal" style="transition-delay: 0.2s">
                    {{ $site['hero_subheadline'] ?? '' }}
                </p>

                <div class="mt-10 flex flex-wrap gap-4 reveal" style="transition-delay: 0.3s">
                    <a href="{{ route('projects.index') }}" class="btn-primary magnetic-btn" data-cursor="button">
                        {{ $site['hero_cta_primary'] ?? 'View Selected Work' }}
                    </a>
                    <a href="{{ route('contact') }}" class="btn-secondary magnetic-btn" data-cursor="button">
                        {{ $site['hero_cta_secondary'] ?? "Let's Talk" }}
                    </a>
                </div>

                <dl class="mt-16 grid grid-cols-2 gap-6 sm:grid-cols-4 reveal" style="transition-delay: 0.4s">
                    <div>
                        <dt class="label-mono mb-1">Experience</dt>
                        <dd class="font-display text-2xl">{{ $site['years_experience'] ?? '5+' }} years</dd>
                    </div>
                    <div>
                        <dt class="label-mono mb-1">Projects</dt>
                        <dd class="font-display text-2xl">{{ $site['projects_delivered'] ?? '30+' }}</dd>
                    </div>
                    <div>
                        <dt class="label-mono mb-1">Focus</dt>
                        <dd class="font-display text-2xl">Full-Stack</dd>
                    </div>
                    <div>
                        <dt class="label-mono mb-1">Location</dt>
                        <dd class="font-display text-lg">{{ $site['location'] ?? 'Remote' }}</dd>
                    </div>
                </dl>
            </div>

            <div class="absolute bottom-8 left-1/2 -translate-x-1/2 hidden md:block" aria-hidden="true">
                <div class="flex flex-col items-center gap-2 text-muted">
                    <span class="text-[10px] uppercase tracking-widest">Scroll</span>
                    <div class="h-10 w-px bg-gradient-to-b from-accent to-transparent animate-pulse"></div>
                </div>
            </div>
        </div>
    </section>

    {{-- Marquee --}}
    <x-portfolio.marquee :items="[
        'FULL-STACK DEVELOPMENT', 'AI ENGINEERING', 'LARAVEL', 'REACT', 'NODE.JS', 'MYSQL', 'REST APIs', 'SAAS', 'PERFORMANCE'
    ]" />

    {{-- About preview --}}
    <section class="section-padding">
        <div class="container-site">
            <div class="grid gap-12 lg:grid-cols-2 lg:gap-20 items-start">
                <x-portfolio.section-heading
                    number="01"
                    label="About"
                    title="Engineering with intention."
                    :description="$site['about_intro'] ?? ''"
                />
                <div class="reveal space-y-6">
                    <p class="text-muted leading-relaxed">{{ $site['about_philosophy'] ?? '' }}</p>
                    <a href="{{ route('about') }}" class="inline-flex items-center gap-2 text-sm text-accent link-underline">
                        Read my story
                        <span aria-hidden="true">→</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- Services --}}
    <section class="section-padding border-t border-white/10">
        <div class="container-site">
            <x-portfolio.section-heading
                number="02"
                label="What I Do"
                title="Services built for real products."
                description="From architecture to interface — focused capabilities that ship."
            />

            <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                @foreach($services as $i => $service)
                    <a href="{{ route('services.show', $service->slug) }}" class="reveal surface-card group p-6 md:p-8 transition hover:border-accent/30" style="transition-delay: {{ $i * 0.05 }}s">
                        <span class="label-mono mb-4 block">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>
                        <h3 class="font-display text-xl font-medium mb-3 group-hover:text-accent transition">{{ $service->title }}</h3>
                        <p class="text-sm text-muted">{{ $service->excerpt }}</p>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Featured Projects --}}
    <section class="section-padding border-t border-white/10">
        <div class="container-site">
            <div class="flex flex-col gap-6 md:flex-row md:items-end md:justify-between mb-12">
                <x-portfolio.section-heading
                    number="03"
                    label="Selected Work"
                    title="Projects that demonstrate depth."
                    description="Case studies spanning SaaS, AI integration, and scalable web platforms."
                    class="mb-0"
                />
                <a href="{{ route('projects.index') }}" class="btn-secondary shrink-0">View All Projects</a>
            </div>

            <div class="grid gap-6 md:grid-cols-2">
                @foreach($featuredProjects as $i => $project)
                    <div class="reveal" style="transition-delay: {{ $i * 0.08 }}s">
                        <x-portfolio.project-card :project="$project" />
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Skills --}}
    <section class="section-padding border-t border-white/10">
        <div class="container-site">
            <x-portfolio.section-heading
                number="04"
                label="Technology"
                title="A focused engineering stack."
                description="Technologies chosen for reliability, velocity, and long-term maintainability."
            />

            <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                @foreach($skillCategories as $category)
                    <div class="reveal surface-card p-6">
                        <h3 class="font-display text-lg font-medium mb-4">{{ $category->name }}</h3>
                        <ul class="space-y-3">
                            @foreach($category->skills as $skill)
                                <li class="flex items-center justify-between text-sm">
                                    <span>{{ $skill->name }}</span>
                                    <span class="text-xs text-muted">{{ $skill->experience_level }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Experience preview --}}
    @if($experiences->isNotEmpty())
    <section class="section-padding border-t border-white/10">
        <div class="container-site">
            <x-portfolio.section-heading number="05" label="Experience" title="Professional trajectory." />
            <div class="space-y-0 border-l border-white/10 ml-3">
                @foreach($experiences as $exp)
                    <div class="reveal relative pl-8 pb-10 last:pb-0">
                        <div class="absolute -left-[5px] top-2 h-2.5 w-2.5 rounded-full bg-accent"></div>
                        <p class="label-mono mb-2">{{ $exp->started_at->format('Y') }}@if($exp->ended_at) — {{ $exp->ended_at->format('Y') }}@else — Present @endif</p>
                        <h3 class="font-display text-xl font-medium">{{ $exp->role }}</h3>
                        <p class="text-accent text-sm mt-1">{{ $exp->company }}</p>
                        <p class="text-sm text-muted mt-3 max-w-xl">{{ $exp->description }}</p>
                    </div>
                @endforeach
            </div>
            <a href="{{ route('experience') }}" class="mt-8 inline-block text-sm text-accent link-underline">Full experience →</a>
        </div>
    </section>
    @endif
@endsection
