<?php

namespace App\Http\Controllers;

use App\Models\Experience;
use App\Models\Project;
use App\Models\Service;
use App\Models\SkillCategory;
use App\Models\Technology;
use App\Models\Testimonial;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        return view('pages.home', [
            'featuredProjects' => Project::published()->featured()
                ->with(['category', 'technologies'])
                ->orderBy('sort_order')
                ->limit(4)
                ->get(),
            'services' => Service::published()
                ->orderBy('sort_order')
                ->limit(6)
                ->get(),
            'technologies' => Technology::query()
                ->where('is_featured', true)
                ->orderBy('sort_order')
                ->get(),
            'experiences' => Experience::published()
                ->orderByDesc('started_at')
                ->limit(4)
                ->get(),
            'skillCategories' => SkillCategory::with('skills')
                ->orderBy('sort_order')
                ->get(),
            'testimonials' => Testimonial::query()
                ->where('is_published', true)
                ->orderBy('sort_order')
                ->limit(3)
                ->get(),
        ]);
    }
}
