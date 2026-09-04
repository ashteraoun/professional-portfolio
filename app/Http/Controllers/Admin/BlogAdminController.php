<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\BlogTag;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class BlogAdminController extends Controller
{
    public function index(): View
    {
        return view('admin.blog.index', [
            'posts' => BlogPost::with('category')->latest()->paginate(15),
        ]);
    }

    public function create(): View
    {
        return view('admin.blog.create', [
            'categories' => BlogCategory::all(),
            'tags' => BlogTag::all(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data['user_id'] = $request->user()->id;
        $data['slug'] = Str::slug($data['title']);
        $post = BlogPost::create($data);
        $post->tags()->sync($request->input('tags', []));

        return redirect()->route('admin.blog.index')->with('success', 'Post created.');
    }

    public function edit(BlogPost $blog): View
    {
        return view('admin.blog.edit', [
            'post' => $blog->load('tags'),
            'categories' => BlogCategory::all(),
            'tags' => BlogTag::all(),
        ]);
    }

    public function update(Request $request, BlogPost $blog): RedirectResponse
    {
        $blog->update($this->validated($request));
        $blog->tags()->sync($request->input('tags', []));

        return redirect()->route('admin.blog.index')->with('success', 'Post updated.');
    }

    public function destroy(BlogPost $blog): RedirectResponse
    {
        $blog->delete();

        return redirect()->route('admin.blog.index')->with('success', 'Post deleted.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'blog_category_id' => 'nullable|exists:blog_categories,id',
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string',
            'content' => 'required|string',
            'reading_time' => 'nullable|integer|min:1',
            'status' => 'required|in:draft,published,scheduled',
            'published_at' => 'nullable|date',
            'is_featured' => 'boolean',
            'seo_title' => 'nullable|string|max:255',
            'seo_description' => 'nullable|string',
        ]) + [
            'is_featured' => $request->boolean('is_featured'),
            'published_at' => $request->input('published_at') ?? ($request->status === 'published' ? now() : null),
        ];
    }
}
