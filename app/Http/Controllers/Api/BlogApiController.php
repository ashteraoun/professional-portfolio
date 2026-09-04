<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BlogApiController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = BlogPost::published()
            ->with(['category', 'tags'])
            ->latest('published_at');

        return response()->json($query->paginate(12));
    }

    public function show(string $slug): JsonResponse
    {
        $post = BlogPost::published()
            ->where('slug', $slug)
            ->with(['category', 'tags', 'author'])
            ->firstOrFail();

        return response()->json($post);
    }
}
