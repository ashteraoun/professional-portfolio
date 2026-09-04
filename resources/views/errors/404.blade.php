@extends('layouts.portfolio')

@section('content')
    <section class="section-padding pt-32 min-h-[60vh] flex items-center">
        <div class="container-site text-center max-w-xl mx-auto reveal">
            <p class="label-mono mb-4">404</p>
            <h1 class="display-lg mb-4">This route doesn't exist.</h1>
            <p class="text-muted mb-8">The page you're looking for may have moved or never existed.</p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="{{ route('home') }}" class="btn-primary">Home</a>
                <a href="{{ route('projects.index') }}" class="btn-secondary">Projects</a>
                <a href="{{ route('contact') }}" class="btn-secondary">Contact</a>
            </div>
        </div>
    </section>
@endsection
