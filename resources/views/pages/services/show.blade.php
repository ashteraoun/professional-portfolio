@extends('layouts.portfolio')

@section('content')
    {{-- Hero Section --}}
    <section class="relative overflow-hidden pt-32 pb-20 md:pt-40 md:pb-28">
        <div class="absolute inset-0 hero-grid opacity-50"></div>
        <div class="container-site relative">
            <div class="reveal max-w-4xl">
                <div class="mb-6 flex items-center gap-3">
                    <p class="label-mono">Service</p>
                    @if($service->icon)
                        <div class="icon-chip !h-10 !w-10">
                            <span class="text-xl">{{ $service->icon }}</span>
                        </div>
                    @endif
                </div>
                <h1 class="display-xl mb-6">
                    <span class="gradient-text">{{ $service->title }}</span>
                </h1>
                <p class="text-xl text-muted max-w-2xl">
                    {{ $service->excerpt }}
                </p>
                
                <div class="mt-8 flex flex-wrap gap-4">
                    <a href="{{ route('contact') }}" class="btn-primary">
                        Start a Project
                    </a>
                    <a href="{{ route('services.index') }}" class="btn-secondary">
                        View All Services
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- Description Section --}}
    @if($service->description)
        <section class="pb-20">
            <div class="container-site">
                <div class="reveal max-w-4xl">
                    <div class="glow-card p-8 md:p-12">
                        <h2 class="font-display text-2xl font-medium mb-4">Overview</h2>
                        <div class="prose-blog text-lg text-muted">
                            <p>{{ $service->description }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    {{-- Problem & Solution --}}
    @if($service->problem || $service->solution)
        <section class="pb-20">
            <div class="container-site">
                <div class="reveal grid gap-6 md:grid-cols-2">
                    @if($service->problem)
                        <div class="glow-card p-8">
                            <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-red-500/10">
                                <svg class="h-6 w-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                            </div>
                            <h3 class="font-display text-xl font-medium mb-3">The Challenge</h3>
                            <p class="text-muted">{{ $service->problem }}</p>
                        </div>
                    @endif
                    
                    @if($service->solution)
                        <div class="glow-card p-8">
                            <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-green-500/10">
                                <svg class="h-6 w-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <h3 class="font-display text-xl font-medium mb-3">The Solution</h3>
                            <p class="text-muted">{{ $service->solution }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    @endif

    {{-- Features Section --}}
    @if($service->features && is_array($service->features) && count($service->features) > 0)
        <section class="pb-20">
            <div class="container-site">
                <div class="reveal mb-12">
                    <h2 class="font-display text-3xl font-medium mb-4">Key Features</h2>
                    <p class="text-lg text-muted">What makes this service exceptional</p>
                </div>
                
                <div class="reveal grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach($service->features as $feature)
                        <div class="glow-card p-6">
                            <div class="icon-chip !h-10 !w-10 mb-4">
                                <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <h3 class="font-display text-lg font-medium">{{ $feature }}</h3>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- Process Section --}}
    @if($service->process && is_array($service->process) && count($service->process) > 0)
        <section class="pb-20">
            <div class="container-site">
                <div class="reveal max-w-4xl">
                    <div class="mb-12">
                        <h2 class="font-display text-3xl font-medium mb-4">Our Process</h2>
                        <p class="text-lg text-muted">How we bring your vision to life</p>
                    </div>
                    
                    <div class="space-y-6">
                        @foreach($service->process as $index => $step)
                            <div class="glow-card p-6 md:p-8 flex gap-6">
                                <div class="icon-chip !h-12 !w-12 !rounded-full shrink-0 text-lg">
                                    {{ $index + 1 }}
                                </div>
                                <div>
                                    <h3 class="font-display text-xl font-medium mb-2">{{ $step }}</h3>
                                    <p class="text-muted">Detailed explanation of this step in the process.</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif

    {{-- Technologies Section --}}
    @if($service->technologies && is_array($service->technologies) && count($service->technologies) > 0)
        <section class="pb-20">
            <div class="container-site">
                <div class="reveal">
                    <div class="mb-8">
                        <h2 class="font-display text-3xl font-medium mb-4">Technologies We Use</h2>
                        <p class="text-lg text-muted">Tools and frameworks in our arsenal</p>
                    </div>
                    
                    <div class="flex flex-wrap gap-3">
                        @foreach($service->technologies as $tech)
                            <span class="tech-tag !px-4 !py-2 !text-sm">{{ $tech }}</span>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif

    {{-- Deliverables Section --}}
    @if($service->deliverables && is_array($service->deliverables) && count($service->deliverables) > 0)
        <section class="pb-20">
            <div class="container-site">
                <div class="reveal max-w-4xl">
                    <div class="glow-card p-8 md:p-12">
                        <h2 class="font-display text-2xl font-medium mb-6">What You'll Get</h2>
                        <ul class="space-y-4">
                            @foreach($service->deliverables as $item)
                                <li class="flex items-start gap-3">
                                    <div class="flex shrink-0 mt-1 h-5 w-5 items-center justify-center rounded-full bg-accent/20">
                                        <svg class="h-3 w-3 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </div>
                                    <span class="text-muted">{{ $item }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </section>
    @endif

    {{-- CTA Section --}}
    <section class="pb-32">
        <div class="container-site">
            <div class="reveal glow-card p-8 md:p-12 text-center" style="background: var(--gradient-brand-soft);">
                <h2 class="font-display text-3xl font-medium mb-4"><span class="gradient-text">Ready to Get Started?</span></h2>
                <p class="text-lg text-muted mb-8 max-w-2xl mx-auto">
                    Let's discuss how this service can help transform your business.
                </p>
                <a href="{{ route('contact') }}" class="btn-primary inline-flex">
                    Start Your Project
                </a>
            </div>
        </div>
    </section>
@endsection
