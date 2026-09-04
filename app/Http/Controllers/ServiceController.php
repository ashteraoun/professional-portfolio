<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\View\View;

class ServiceController extends Controller
{
    public function index(): View
    {
        return view('pages.services.index', [
            'services' => Service::published()
                ->with('serviceFeatures')
                ->orderBy('sort_order')
                ->get(),
        ]);
    }

    public function show(string $slug): View
    {
        $service = Service::published()
            ->where('slug', $slug)
            ->with('serviceFeatures')
            ->firstOrFail();

        return view('pages.services.show', ['service' => $service]);
    }
}
