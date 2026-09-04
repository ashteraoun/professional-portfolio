<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProjectApiController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Project::published()
            ->with(['category', 'technologies'])
            ->orderBy('sort_order');

        if ($category = $request->query('category')) {
            $query->whereHas('category', fn ($q) => $q->where('slug', $category));
        }

        return response()->json($query->paginate(12));
    }

    public function show(string $slug): JsonResponse
    {
        $project = Project::published()
            ->where('slug', $slug)
            ->with(['category', 'technologies', 'gallery'])
            ->firstOrFail();

        return response()->json($project);
    }
}
