<?php

namespace App\Http\Controllers;

use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\BlogTag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class BlogController extends Controller
{
    public function index(Request $request): Response
    {
        $featuredPosts = BlogPost::published()->featured()
            ->with('category')
            ->latest('published_at')
            ->limit(3)
            ->get();

        $query = BlogPost::published()
            ->with(['category', 'tags', 'author'])
            ->latest('published_at');

        $hasFilters = $request->filled('category')
            || $request->filled('tag')
            || $request->filled('q');

        if (! $hasFilters && $featuredPosts->isNotEmpty()) {
            $query->whereNotIn('id', $featuredPosts->modelKeys());
        }

        if ($category = $request->query('category')) {
            $query->whereHas('category', fn ($q) => $q->where('slug', $category));
        }

        if ($tag = $request->query('tag')) {
            $query->whereHas('tags', fn ($q) => $q->where('slug', $tag));
        }

        if ($search = $request->query('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('excerpt', 'like', "%{$search}%");
            });
        }

        return Inertia::render('Portfolio', [
            'page' => 'blog-index',
            'posts' => $query->paginate(9)->withQueryString(),
            'categories' => BlogCategory::withCount('posts')->get(),
            'tags' => BlogTag::all(),
            'featuredPosts' => $featuredPosts,
            'hasFilters' => $hasFilters,
            'activeCategory' => $request->query('category'),
            'activeTag' => $request->query('tag'),
            'searchQuery' => $request->query('q', ''),
        ]);
    }

    public function show(string $slug): Response
    {
        $post = BlogPost::published()
            ->where('slug', $slug)
            ->with(['category', 'tags', 'author'])
            ->firstOrFail();

        $post->increment('view_count');

        return Inertia::render('Portfolio', [
            'page' => 'blog-show',
            'post' => $post,
            'contentHtml' => Str::markdown($post->content),
            'relatedPosts' => BlogPost::published()
                ->where('id', '!=', $post->id)
                ->where('blog_category_id', $post->blog_category_id)
                ->latest('published_at')
                ->limit(3)
                ->get(),
        ]);
    }
}
