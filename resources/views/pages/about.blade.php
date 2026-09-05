@extends('layouts.portfolio')

@section('content')
    <section class="section-padding pt-32">
        <div class="container-site max-w-3xl">
            <p class="badge-pulse reveal mb-6"><span class="dot"></span> About</p>
            <h1 class="display-lg mb-8 reveal"><span class="gradient-text">The story behind the engineering.</span></h1>
            <div class="prose-blog reveal space-y-6">
                <p class="text-lg">{{ $site['about_intro'] ?? '' }}</p>
                <p>{{ $site['about_philosophy'] ?? '' }}</p>
            </div>
        </div>
    </section>

    <section class="section-padding border-t border-white/10">
        <div class="container-site">
            <x-portfolio.section-heading title="Career timeline" description="Replace placeholder entries with your real experience." />
            <div class="max-w-3xl space-y-0 border-l border-white/10 ml-3">
                @foreach($experiences as $exp)
                    <article class="reveal relative pl-8 pb-12 last:pb-0">
                        <div class="timeline-dot-gradient absolute -left-[7px] top-2 h-3.5 w-3.5 rounded-full"></div>
                        <time class="label-mono">{{ $exp->started_at->format('M Y') }} — {{ $exp->is_current ? 'Present' : $exp->ended_at?->format('M Y') }}</time>
                        <h2 class="font-display text-2xl font-medium mt-2">{{ $exp->role }}</h2>
                        <p class="gradient-text font-semibold">{{ $exp->company }} @if($exp->location)· {{ $exp->location }}@endif</p>
                        <p class="text-muted mt-4">{{ $exp->description }}</p>
                        @if($exp->technologies)
                            <div class="mt-4 flex flex-wrap gap-2">
                                @foreach($exp->technologies as $tech)
                                    <span class="tech-tag">{{ $tech }}</span>
                                @endforeach
                            </div>
                        @endif
                    </article>
                @endforeach
            </div>
        </div>
    </section>
@endsection
