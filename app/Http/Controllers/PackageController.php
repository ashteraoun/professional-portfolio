<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\View\View;

class PackageController extends Controller
{
    public function index(): View
    {
        return view('pages.packages', [
            'packages' => Package::published()
                ->with('features')
                ->orderBy('sort_order')
                ->get(),
        ]);
    }
}
