@extends('layouts.portfolio')

@section('content')
    <section class="section-padding pt-32">
        <div class="container-site">
            <x-portfolio.section-heading label="Services" title="What I build." description="Focused capabilities for ambitious digital products." />
            <div class="grid gap-6 lg:grid-cols-2">
                @foreach($services as $i => $service)
                    <article class="reveal surface-card p-8">
                        <span class="label-mono">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>
                        <h2 class="font-display text-2xl font-medium mt-4 mb-3"><a href="{{ route('services.show', $service->slug) }}" class="hover:text-accent transition">{{ $service->title }}</a></h2>
                        <p class="text-muted mb-6">{{ $service->excerpt }}</p>
                        <a href="{{ route('services.show', $service->slug) }}" class="text-sm text-accent link-underline">Learn more →</a>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
@endsection
