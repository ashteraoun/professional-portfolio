@extends('layouts.portfolio')

@section('content')
    <section class="section-padding pt-32">
        <div class="container-site max-w-3xl">
            <p class="label-mono mb-4 reveal">About</p>
            <h1 class="display-lg mb-8 reveal">The story behind the engineering.</h1>
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
                        <div class="absolute -left-[5px] top-2 h-2.5 w-2.5 rounded-full bg-accent"></div>
                        <time class="label-mono">{{ $exp->started_at->format('M Y') }} — {{ $exp->is_current ? 'Present' : $exp->ended_at?->format('M Y') }}</time>
                        <h2 class="font-display text-2xl font-medium mt-2">{{ $exp->role }}</h2>
                        <p class="text-accent">{{ $exp->company }} @if($exp->location)· {{ $exp->location }}@endif</p>
                        <p class="text-muted mt-4">{{ $exp->description }}</p>
                        @if($exp->technologies)
                            <div class="mt-4 flex flex-wrap gap-2">
                                @foreach($exp->technologies as $tech)
                                    <span class="rounded-full border border-white/10 px-3 py-1 text-xs text-muted">{{ $tech }}</span>
                                @endforeach
                            </div>
                        @endif
                    </article>
                @endforeach
            </div>
        </div>
    </section>
@endsection
