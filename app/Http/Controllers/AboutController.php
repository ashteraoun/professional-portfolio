<?php

namespace App\Http\Controllers;

use App\Models\Experience;
use App\Models\SkillCategory;
use Inertia\Inertia;
use Inertia\Response;

class AboutController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Portfolio', [
            'page' => 'about',
            'experiences' => Experience::published()
                ->orderByDesc('started_at')
                ->get(),
            'skillCategories' => SkillCategory::with('skills')
                ->orderBy('sort_order')
                ->get(),
        ]);
    }
}
