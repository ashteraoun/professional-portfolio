<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\Technology;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function index(Request $request): View
    {
        $query = Project::published()
            ->with(['category', 'technologies'])
            ->orderBy('sort_order');

        if ($category = $request->query('category')) {
            $query->whereHas('category', fn ($q) => $q->where('slug', $category));
        }

        if ($tech = $request->query('tech')) {
            $query->whereHas('technologies', fn ($q) => $q->where('slug', $tech));
        }

        return view('pages.projects.index', [
            'projects' => $query->paginate(9)->withQueryString(),
            'categories' => ProjectCategory::orderBy('sort_order')->get(),
            'technologies' => Technology::orderBy('name')->get(),
            'activeCategory' => $category,
            'activeTech' => $tech,
        ]);
    }

    public function show(string $slug): View
    {
        $project = Project::published()
            ->where('slug', $slug)
            ->with(['category', 'technologies', 'gallery'])
            ->firstOrFail();

        $project->increment('view_count');

        return view('pages.projects.show', [
            'project' => $project,
            'relatedProjects' => Project::published()
                ->where('id', '!=', $project->id)
                ->where('project_category_id', $project->project_category_id)
                ->limit(3)
                ->get(),
        ]);
    }
}
