<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Inertia\Inertia;
use Inertia\Response;

class ServiceController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Portfolio', [
            'page' => 'services-index',
            'services' => Service::published()
                ->with('serviceFeatures')
                ->orderBy('sort_order')
                ->get(),
        ]);
    }

    public function show(string $slug): Response
    {
        $service = Service::published()
            ->where('slug', $slug)
            ->with('serviceFeatures')
            ->firstOrFail();

        return Inertia::render('Portfolio', ['page' => 'service-show', 'service' => $service]);
    }
}
