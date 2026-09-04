@extends('layouts.portfolio')

@section('content')
    <section class="section-padding pt-32">
        <div class="container-site max-w-3xl">
            <p class="label-mono mb-4">{{ str_pad(1, 2, '0', STR_PAD_LEFT) }} — Service</p>
            <h1 class="display-lg mb-6">{{ $service->title }}</h1>
            <p class="text-xl text-muted mb-12">{{ $service->excerpt }}</p>
            <div class="prose-blog space-y-8">
                @if($service->description)<p>{{ $service->description }}</p>@endif
                @if($service->process)
                    <section><h2>Process</h2><ol class="list-decimal pl-5 space-y-2 text-muted">@foreach($service->process as $step)<li>{{ $step }}</li>@endforeach</ol></section>
                @endif
                @if($service->deliverables)
                    <section><h2>Deliverables</h2><ul class="space-y-2">@foreach($service->deliverables as $item)<li class="text-muted">→ {{ $item }}</li>@endforeach</ul></section>
                @endif
            </div>
            <a href="{{ route('contact') }}" class="btn-primary mt-12 inline-flex">Start a Project</a>
        </div>
    </section>
@endsection
