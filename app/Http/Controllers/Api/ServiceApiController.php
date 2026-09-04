<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\JsonResponse;

class ServiceApiController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(
            Service::published()->orderBy('sort_order')->get()
        );
    }

    public function show(string $slug): JsonResponse
    {
        $service = Service::published()
            ->where('slug', $slug)
            ->with('serviceFeatures')
            ->firstOrFail();

        return response()->json($service);
    }
}
