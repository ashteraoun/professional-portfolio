<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\Technology;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ProjectController extends Controller
{
    public function index(Request $request): Response
    {
        $category = $request->query('category');
        $tech = $request->query('tech');

        $query = Project::published()
            ->with(['category', 'technologies', 'gallery'])
            ->orderBy('sort_order');

        if ($category) {
            $query->whereHas('category', fn ($q) => $q->where('slug', $category));
        }

        if ($tech) {
            $query->whereHas('technologies', fn ($q) => $q->where('slug', $tech));
        }

        $projects = $query->paginate(12)->withQueryString();
        $projects->through(fn (Project $project) => [
            ...$project->toArray(),
            'preview' => $project->toPreviewArray(),
        ]);

        return Inertia::render('Portfolio', [
            'page' => 'projects-index',
            'projects' => $projects,
            'categories' => ProjectCategory::orderBy('sort_order')->get(),
            'technologies' => Technology::orderBy('name')->get(),
            'activeCategory' => $category ?? null,
            'activeTech' => $tech ?? null,
            'spotlightProject' => ($spotlight = Project::published()->featured()->with(['category', 'technologies', 'gallery'])->orderBy('sort_order')->first()
                ?? Project::published()->with(['category', 'technologies', 'gallery'])->orderBy('sort_order')->first())?->toPreviewArray(),
        ]);
    }

    public function show(string $slug): Response
    {
        $project = Project::published()
            ->where('slug', $slug)
            ->with(['category', 'technologies', 'gallery'])
            ->firstOrFail();

        $project->increment('view_count');

        return Inertia::render('Portfolio', [
            'page' => 'project-show',
            'project' => $project,
            'heroImage' => $project->coverImage(),
            'galleryItems' => $project->gallery->map(fn ($item) => [
                ...$item->toArray(),
                'url' => Project::storageUrl($item->path),
            ]),
            'relatedProjects' => Project::published()
                ->where('id', '!=', $project->id)
                ->where('project_category_id', $project->project_category_id)
                ->limit(3)
                ->get(),
        ]);
    }
}
