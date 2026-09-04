@extends('layouts.portfolio')

@section('content')
    <section class="section-padding pt-32">
        <div class="container-site">
            <x-portfolio.section-heading label="Packages" title="Clear engagement models." description="Transparent starting points — every project is scoped individually." align="center" class="mx-auto text-center" />

            <div class="grid gap-6 lg:grid-cols-3 mt-8">
                @foreach($packages as $package)
                    <article class="reveal surface-card p-8 flex flex-col {{ $package->is_recommended ? 'border-accent/50 ring-1 ring-accent/20' : '' }}">
                        @if($package->is_recommended)
                            <span class="label-mono mb-4 text-accent">Recommended</span>
                        @endif
                        <h2 class="font-display text-2xl font-medium">{{ $package->name }}</h2>
                        <p class="text-sm text-muted mt-3 flex-1">{{ $package->description }}</p>
                        @if($package->price)
                            <p class="font-display text-3xl mt-6">${{ number_format($package->price, 0) }}<span class="text-sm text-muted font-body"> / project</span></p>
                        @endif
                        @if($package->delivery_time)
                            <p class="text-xs text-muted mt-2">Delivery: {{ $package->delivery_time }}</p>
                        @endif
                        <ul class="mt-6 space-y-2 text-sm">
                            @foreach($package->features as $feature)
                                <li class="flex items-start gap-2 text-muted"><span class="text-accent mt-0.5">✓</span>{{ $feature->feature }}</li>
                            @endforeach
                        </ul>
                        <a href="{{ $package->cta_url ?? route('contact') }}" class="{{ $package->is_recommended ? 'btn-primary' : 'btn-secondary' }} mt-8 justify-center">{{ $package->cta_text }}</a>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
@endsection
