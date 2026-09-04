@extends('layouts.portfolio')

@section('content')
    <section class="section-padding pt-32">
        <div class="container-site">
            <x-portfolio.section-heading label="Blog" title="Engineering notes." description="Articles on architecture, Laravel, and product development." />

            @if($featuredPosts->isNotEmpty())
                <div class="mb-12 grid gap-6 md:grid-cols-3">
                    @foreach($featuredPosts as $post)
                        <a href="{{ route('blog.show', $post->slug) }}" class="reveal surface-card p-6 hover:border-accent/30 transition block">
                            <p class="label-mono mb-2">Featured</p>
                            <h2 class="font-display text-lg font-medium">{{ $post->title }}</h2>
                            <p class="text-sm text-muted mt-2 line-clamp-2">{{ $post->excerpt }}</p>
                        </a>
                    @endforeach
                </div>
            @endif

            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @forelse($posts as $post)
                    <article class="reveal surface-card p-6">
                        @if($post->category)<p class="text-xs text-accent mb-2">{{ $post->category->name }}</p>@endif
                        <h2 class="font-display text-lg font-medium"><a href="{{ route('blog.show', $post->slug) }}" class="hover:text-accent transition">{{ $post->title }}</a></h2>
                        <p class="text-sm text-muted mt-2">{{ $post->published_at?->format('M d, Y') }} · {{ $post->reading_time }} min read</p>
                        <p class="text-sm text-muted mt-3 line-clamp-3">{{ $post->excerpt }}</p>
                    </article>
                @empty
                    <p class="text-muted col-span-full">No articles published yet.</p>
                @endforelse
            </div>
            <div class="mt-12">{{ $posts->links() }}</div>
        </div>
    </section>
@endsection
