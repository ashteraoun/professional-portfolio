<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\Project;
use App\Models\Service;
use App\Models\Technology;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SearchApiController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = trim($request->query('q', ''));

        if (strlen($query) < 2) {
            return response()->json(['results' => []]);
        }

        return response()->json([
            'results' => [
                'projects' => Project::published()
                    ->where('title', 'like', "%{$query}%")
                    ->limit(5)
                    ->get(['id', 'title', 'slug']),
                'posts' => BlogPost::published()
                    ->where('title', 'like', "%{$query}%")
                    ->limit(5)
                    ->get(['id', 'title', 'slug']),
                'services' => Service::published()
                    ->where('title', 'like', "%{$query}%")
                    ->limit(5)
                    ->get(['id', 'title', 'slug']),
                'technologies' => Technology::query()
                    ->where('name', 'like', "%{$query}%")
                    ->limit(5)
                    ->get(['id', 'name', 'slug']),
            ],
        ]);
    }
}
