@extends('layouts.portfolio')

@php
    $seoTitle = $post->seo_title ?? $post->title;
    $seoDescription = $post->seo_description ?? $post->excerpt;
    $seoType = 'article';
@endphp

@section('content')
    <article class="section-padding pt-32">
        <div class="container-site max-w-3xl">
            <header class="reveal mb-12">
                @if($post->category)<span class="badge-pulse mb-4"><span class="dot"></span>{{ $post->category->name }}</span>@endif
                <h1 class="display-lg mb-4 mt-4"><span class="gradient-text">{{ $post->title }}</span></h1>
                <p class="text-muted">{{ $post->published_at?->format('F j, Y') }} · {{ $post->reading_time }} min read · {{ $post->author->name }}</p>
            </header>

            <div class="prose-blog reveal">
                {!! Str::markdown($post->content) !!}
            </div>

            @if($post->tags->isNotEmpty())
                <div class="mt-12 flex flex-wrap gap-2">
                    @foreach($post->tags as $tag)
                        <span class="tech-tag">{{ $tag->name }}</span>
                    @endforeach
                </div>
            @endif

            @if($relatedPosts->isNotEmpty())
                <section class="mt-16 border-t border-white/10 pt-12">
                    <h2 class="font-display text-xl mb-6 gradient-underline inline-block">Related Articles</h2>
                    <div class="mt-2 space-y-4">
                        @foreach($relatedPosts as $related)
                            <a href="{{ route('blog.show', $related->slug) }}" class="block text-muted transition hover:gradient-text">{{ $related->title }}</a>
                        @endforeach
                    </div>
                </section>
            @endif
        </div>
    </article>
@endsection
