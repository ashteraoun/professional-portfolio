<?php

namespace App\Http\Controllers;

use App\Models\Experience;
use Inertia\Inertia;
use Inertia\Response;

class ExperienceController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Portfolio', [
            'page' => 'experience',
            'experiences' => Experience::published()
                ->orderByDesc('started_at')
                ->get(),
        ]);
    }
}
