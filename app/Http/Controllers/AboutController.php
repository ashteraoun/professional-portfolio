<?php

namespace App\Http\Controllers;

use App\Models\Experience;
use App\Models\SkillCategory;
use Illuminate\View\View;

class AboutController extends Controller
{
    public function index(): View
    {
        return view('pages.about', [
            'experiences' => Experience::published()
                ->orderByDesc('started_at')
                ->get(),
            'skillCategories' => SkillCategory::with('skills')
                ->orderBy('sort_order')
                ->get(),
        ]);
    }
}
