@extends('layouts.portfolio')

@section('content')
    <section class="section-padding pt-32">
        <div class="container-site max-w-3xl">
            <h1 class="display-lg mb-8">Search</h1>
            <form action="{{ route('search') }}" method="GET" class="mb-12">
                <input type="search" name="q" value="{{ $query }}" placeholder="Search projects, articles, services..." class="w-full rounded-xl border border-white/10 bg-transparent px-5 py-4 text-lg outline-none focus:border-accent">
            </form>

            @if($query)
                <div class="space-y-12">
                    @if($projects->isNotEmpty())
                        <section><h2 class="label-mono mb-4">Projects</h2>
                            <ul class="space-y-2">@foreach($projects as $p)<li><a href="{{ route('projects.show', $p->slug) }}" class="hover:text-accent">{{ $p->title }}</a></li>@endforeach</ul>
                        </section>
                    @endif
                    @if($posts->isNotEmpty())
                        <section><h2 class="label-mono mb-4">Articles</h2>
                            <ul class="space-y-2">@foreach($posts as $p)<li><a href="{{ route('blog.show', $p->slug) }}" class="hover:text-accent">{{ $p->title }}</a></li>@endforeach</ul>
                        </section>
                    @endif
                    @if($services->isNotEmpty())
                        <section><h2 class="label-mono mb-4">Services</h2>
                            <ul class="space-y-2">@foreach($services as $s)<li><a href="{{ route('services.show', $s->slug) }}" class="hover:text-accent">{{ $s->title }}</a></li>@endforeach</ul>
                        </section>
                    @endif
                    @if($projects->isEmpty() && $posts->isEmpty() && $services->isEmpty() && $technologies->isEmpty())
                        <p class="text-muted">No results for "{{ $query }}".</p>
                    @endif
                </div>
            @endif
        </div>
    </section>
@endsection
