<?php

namespace App\Http\Controllers;

use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\BlogTag;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BlogController extends Controller
{
    public function index(Request $request): View
    {
        $query = BlogPost::published()
            ->with(['category', 'tags', 'author'])
            ->latest('published_at');

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

        return view('pages.blog.index', [
            'posts' => $query->paginate(9)->withQueryString(),
            'categories' => BlogCategory::withCount('posts')->get(),
            'tags' => BlogTag::all(),
            'featuredPosts' => BlogPost::published()->featured()
                ->latest('published_at')
                ->limit(3)
                ->get(),
        ]);
    }

    public function show(string $slug): View
    {
        $post = BlogPost::published()
            ->where('slug', $slug)
            ->with(['category', 'tags', 'author'])
            ->firstOrFail();

        $post->increment('view_count');

        return view('pages.blog.show', [
            'post' => $post,
            'relatedPosts' => BlogPost::published()
                ->where('id', '!=', $post->id)
                ->where('blog_category_id', $post->blog_category_id)
                ->latest('published_at')
                ->limit(3)
                ->get(),
        ]);
    }
}
