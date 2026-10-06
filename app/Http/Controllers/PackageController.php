<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Inertia\Inertia;
use Inertia\Response;

class PackageController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Portfolio', [
            'page' => 'packages',
            'packages' => Package::published()
                ->with('features')
                ->orderBy('sort_order')
                ->get(),
        ]);
    }
}
