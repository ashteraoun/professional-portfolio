@extends('layouts.portfolio')

@section('content')
    @php
        $hasFilters = request()->filled('category') || request()->filled('tag') || request()->filled('q');
        $activeCategory = request()->query('category');
    @endphp

    <section class="section-padding pt-28 md:pt-32">
        <div class="container-site">
            <header class="blog-index-hero reveal relative mb-12 overflow-hidden rounded-[2rem] border border-white/10 bg-surface/70 px-6 py-10 shadow-2xl shadow-purple-950/20 sm:px-10 md:mb-16 md:px-14 md:py-14">
                <div class="pointer-events-none absolute -right-20 -top-28 h-80 w-80 rounded-full bg-fuchsia-500/15 blur-[90px]" aria-hidden="true"></div>
                <div class="pointer-events-none absolute -bottom-40 right-1/4 h-72 w-72 rounded-full bg-violet-500/15 blur-[90px]" aria-hidden="true"></div>
                <div class="relative grid gap-10 lg:grid-cols-[1fr_auto] lg:items-end">
                    <div class="max-w-3xl">
                        <p class="label-mono mb-5 flex items-center gap-2"><span class="dot"></span> The journal</p>
                        <h1 class="display-lg mb-5"><span class="gradient-text">Engineering,</span><br>thoughtfully explained.</h1>
                        <p class="max-w-2xl text-lg leading-relaxed text-muted">Field notes on building reliable software, thoughtful products, and systems that scale.</p>
                    </div>
                    <div class="hidden min-w-44 border-l border-white/10 pl-6 lg:block">
                        <p class="label-mono mb-2">Ideas in progress</p>
                        <p class="font-display text-4xl font-semibold">{{ $posts->total() + ($hasFilters ? 0 : $featuredPosts->count()) }}<span class="ml-2 text-sm font-normal text-muted">articles</span></p>
                    </div>
                </div>
                <div class="relative mt-9 flex flex-wrap items-center gap-3 border-t border-white/10 pt-6">
                    <span class="mr-1 text-xs font-medium uppercase tracking-[0.16em] text-muted">Explore</span>
                    <a href="{{ route('blog.index', request()->only('q', 'tag')) }}" class="filter-pill {{ !$activeCategory ? 'is-active' : '' }}">All topics</a>
                    @foreach($categories as $category)
                        <a href="{{ route('blog.index', array_filter(['category' => $category->slug, 'q' => request()->query('q'), 'tag' => request()->query('tag')])) }}"
                           class="filter-pill {{ $activeCategory === $category->slug ? 'is-active' : '' }}">{{ $category->name }}</a>
                    @endforeach
                </div>
            </header>

            <div class="reveal mb-12 flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="label-mono mb-2">{{ $hasFilters ? 'Your selection' : ($featuredPosts->isNotEmpty() ? 'From the notebook' : 'The journal') }}</p>
                    <h2 class="font-display text-2xl font-medium sm:text-3xl">{{ $hasFilters ? 'Articles for you.' : ($featuredPosts->isNotEmpty() ? 'Featured writing.' : 'Latest articles.') }}</h2>
                </div>
                <form action="{{ route('blog.index') }}" method="GET" role="search" class="flex w-full max-w-md items-center gap-2 rounded-full border border-white/10 bg-surface/70 p-1.5 focus-within:border-accent/50 focus-within:ring-2 focus-within:ring-accent/15 sm:w-auto">
                    @if(request()->query('category'))<input type="hidden" name="category" value="{{ request()->query('category') }}">@endif
                    @if(request()->query('tag'))<input type="hidden" name="tag" value="{{ request()->query('tag') }}">@endif
                    <label for="blog-search" class="sr-only">Search articles</label>
                    <input id="blog-search" type="search" name="q" value="{{ request()->query('q') }}" placeholder="Search the journal..." class="min-w-0 flex-1 border-0 bg-transparent px-4 py-2 text-sm text-text outline-none placeholder:text-text-subtle focus:ring-0">
                    <button type="submit" class="btn-primary !px-5 !py-2.5 text-sm">Search</button>
                </form>
            </div>

            @if(!$hasFilters && $featuredPosts->isNotEmpty())
                @php($leadPost = $featuredPosts->first())
                <a href="{{ route('blog.show', $leadPost->slug) }}" class="reveal glow-card group mb-6 grid overflow-hidden md:min-h-[22rem] md:grid-cols-2">
                    <div class="relative flex min-h-64 flex-col justify-between overflow-hidden bg-gradient-to-br from-violet-950 via-purple-900 to-fuchsia-900 p-7 sm:p-10 md:min-h-full">
                        @if($leadPost->featured_image)
                            <img src="{{ asset('storage/' . $leadPost->featured_image) }}" alt="" class="absolute inset-0 h-full w-full object-cover transition-transform duration-700 group-hover:scale-105">
                            <div class="absolute inset-0 bg-gradient-to-br from-ink/70 via-ink/30 to-purple-950/70"></div>
                        @else
                            <div class="pointer-events-none absolute -right-10 -top-16 h-64 w-64 rounded-full border border-white/15" aria-hidden="true"></div>
                            <div class="pointer-events-none absolute -right-1 top-[-2rem] h-48 w-48 rounded-full border border-white/15" aria-hidden="true"></div>
                            <div class="pointer-events-none absolute -bottom-24 -left-14 h-56 w-56 rounded-full bg-fuchsia-500/30 blur-3xl" aria-hidden="true"></div>
                        @endif
                        <div class="relative flex items-center justify-between">
                            <span class="rounded-full border border-white/20 bg-white/10 px-3 py-1.5 text-[10px] font-semibold uppercase tracking-[0.2em] text-white backdrop-blur">Editor’s pick</span>
                            <span class="font-mono text-xs tracking-widest text-white/70">01 / {{ str_pad($featuredPosts->count(), 2, '0', STR_PAD_LEFT) }}</span>
                        </div>
                        <div class="relative mt-12 flex items-end justify-between">
                            <span class="font-display text-6xl font-bold tracking-tighter text-white/90 sm:text-8xl" aria-hidden="true">Aa</span>
                            <span class="flex h-12 w-12 items-center justify-center rounded-full border border-white/30 text-xl text-white transition group-hover:translate-x-1 group-hover:-translate-y-1" aria-hidden="true">↗</span>
                        </div>
                    </div>
                    <div class="flex flex-col justify-center p-7 sm:p-10 md:p-12">
                        <div class="mb-5 flex flex-wrap items-center gap-3 text-xs font-medium uppercase tracking-[0.15em] text-muted">
                            @if($leadPost->category)<span class="text-accent">{{ $leadPost->category->name }}</span><span class="h-1 w-1 rounded-full bg-accent/60"></span>@endif
                            <span>{{ $leadPost->published_at?->format('M d, Y') }}</span>
                            @if($leadPost->reading_time)<span class="h-1 w-1 rounded-full bg-accent/60"></span><span>{{ $leadPost->reading_time }} min read</span>@endif
                        </div>
                        <h2 class="font-display text-3xl font-medium leading-tight transition group-hover:gradient-text sm:text-4xl">{{ $leadPost->title }}</h2>
                        <p class="mt-4 line-clamp-3 leading-relaxed text-muted">{{ $leadPost->excerpt }}</p>
                        <span class="mt-8 inline-flex items-center gap-2 text-sm font-semibold text-accent">Read the story <span class="transition-transform group-hover:translate-x-1" aria-hidden="true">→</span></span>
                    </div>
                </a>

                @if($featuredPosts->count() > 1)
                    <div class="mb-16 grid gap-4 sm:grid-cols-2">
                        @foreach($featuredPosts->skip(1) as $i => $post)
                            <a href="{{ route('blog.show', $post->slug) }}" class="reveal glow-card group flex items-center gap-5 p-5 sm:p-6" style="transition-delay: {{ $i * 0.08 }}s">
                                <span class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl border border-accent/20 bg-accent/10 font-mono text-sm text-accent">{{ str_pad($i + 2, 2, '0', STR_PAD_LEFT) }}</span>
                                <span class="min-w-0 flex-1">
                                    <span class="mb-1 block text-xs uppercase tracking-wider text-muted">{{ $post->category?->name ?? 'Article' }}</span>
                                    <span class="block font-display text-lg font-medium transition group-hover:gradient-text">{{ $post->title }}</span>
                                </span>
                                <span class="text-xl text-accent transition-transform group-hover:translate-x-1" aria-hidden="true">→</span>
                            </a>
                        @endforeach
                    </div>
                @else
                    <div class="mb-16"></div>
                @endif
            @endif

            <div class="mb-6 flex items-end justify-between gap-4">
                <div>
                    <p class="label-mono mb-2">{{ $hasFilters ? 'Journal results' : 'Keep exploring' }}</p>
                    <h2 class="font-display text-2xl font-medium sm:text-3xl">{{ $hasFilters ? 'Matching articles.' : 'Latest articles.' }}</h2>
                </div>
                @if($posts->total())<span class="text-sm text-muted">{{ $posts->total() }} {{ \Illuminate\Support\Str::plural('article', $posts->total()) }}</span>@endif
            </div>

            <div class="grid gap-5 md:grid-cols-2 lg:grid-cols-3">
                @forelse($posts as $post)
                    <article class="reveal glow-card group flex min-h-64 flex-col p-6 transition-transform duration-300 hover:-translate-y-1 sm:p-7">
                        <div class="mb-6 flex items-center justify-between gap-3">
                            @if($post->category)<a href="{{ route('blog.index', ['category' => $post->category->slug]) }}" class="rounded-full border border-accent/20 bg-accent/10 px-3 py-1 text-xs font-medium text-accent transition hover:border-accent/50">{{ $post->category->name }}</a>
                            @else<span class="rounded-full border border-white/10 bg-white/5 px-3 py-1 text-xs text-muted">Article</span>@endif
                            <span class="font-mono text-[10px] uppercase tracking-wider text-muted">{{ $post->published_at?->format('M d, Y') }}</span>
                        </div>
                        <h3 class="font-display text-xl font-medium leading-snug transition group-hover:gradient-text sm:text-2xl"><a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a></h3>
                        <p class="mt-3 line-clamp-3 text-sm leading-relaxed text-muted">{{ $post->excerpt }}</p>
                        <div class="mt-auto flex items-center justify-between border-t border-white/10 pt-5 mt-6">
                            @if($post->reading_time)<span class="text-xs text-muted">{{ $post->reading_time }} min read</span>@else<span class="text-xs text-muted">Article</span>@endif
                            <a href="{{ route('blog.show', $post->slug) }}" class="inline-flex items-center gap-2 text-sm font-medium text-accent">Read <span class="transition-transform group-hover:translate-x-1" aria-hidden="true">→</span></a>
                        </div>
                    </article>
                @empty
                    <div class="glow-card col-span-full p-10 text-center sm:p-14">
                        <span class="mx-auto mb-5 flex h-14 w-14 items-center justify-center rounded-2xl bg-accent/10 text-2xl text-accent" aria-hidden="true">⌕</span>
                        <h3 class="font-display text-xl font-medium">{{ $hasFilters ? 'No articles found.' : 'The journal is just getting started.' }}</h3>
                        <p class="mx-auto mt-2 max-w-md text-sm text-muted">{{ $hasFilters ? 'Try another phrase or clear the filters to explore all published writing.' : 'New engineering notes and ideas will appear here soon.' }}</p>
                        @if($hasFilters)<a href="{{ route('blog.index') }}" class="btn-secondary mt-6 inline-flex">Clear filters</a>@endif
                    </div>
                @endforelse
            </div>
            @if($posts->hasPages())<div class="mt-12">{{ $posts->links() }}</div>@endif
        </div>
    </section>
@endsection
