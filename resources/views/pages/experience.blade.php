@extends('layouts.portfolio')

@section('content')
    <section class="section-padding pt-32">
        <div class="container-site max-w-3xl">
            <x-portfolio.section-heading label="Experience" title="Professional history." />
            <div class="space-y-0 border-l border-white/10 ml-3">
                @foreach($experiences as $exp)
                    <article class="reveal relative pl-8 pb-12 last:pb-0">
                        <div class="absolute -left-[5px] top-2 h-2.5 w-2.5 rounded-full bg-accent"></div>
                        <time class="label-mono">{{ $exp->started_at->format('Y') }}@if(!$exp->is_current && $exp->ended_at) — {{ $exp->ended_at->format('Y') }}@else — Present @endif</time>
                        <h2 class="font-display text-2xl font-medium mt-2">{{ $exp->role }}</h2>
                        <p class="text-accent">{{ $exp->company }}</p>
                        <p class="text-muted mt-4">{{ $exp->description }}</p>
                        @if($exp->achievements)
                            <ul class="mt-4 space-y-2 text-sm text-muted">
                                @foreach($exp->achievements as $achievement)
                                    <li>→ {{ $achievement }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </article>
                @endforeach
            </div>
        </div>
    </section>
@endsection
