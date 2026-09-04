<?php

namespace App\Http\Controllers;

use App\Models\Experience;
use App\Models\Project;
use App\Models\SkillCategory;
use Illuminate\View\View;

class ResumeController extends Controller
{
    public function index(): View
    {
        return view('pages.resume', [
            'experiences' => Experience::published()->orderByDesc('started_at')->get(),
            'projects' => Project::published()->featured()->limit(6)->get(),
            'skillCategories' => SkillCategory::with('skills')->orderBy('sort_order')->get(),
        ]);
    }
}
