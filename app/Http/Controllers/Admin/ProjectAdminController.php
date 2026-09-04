<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\ProjectGallery;
use App\Models\Technology;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProjectAdminController extends Controller
{
    public function index(): View
    {
        return view('admin.projects.index', [
            'projects' => Project::with(['category', 'gallery'])->latest()->paginate(15),
        ]);
    }

    public function create(): View
    {
        return view('admin.projects.create', [
            'categories' => ProjectCategory::orderBy('name')->get(),
            'technologies' => Technology::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data['slug'] = Str::slug($data['title']);

        $project = Project::create($data);
        $this->syncTechnologies($project, $request);
        $this->handleUploads($request, $project);

        return redirect()->route('admin.projects.edit', $project)->with('success', 'Project created. Add gallery images below.');
    }

    public function edit(Project $project): View
    {
        return view('admin.projects.edit', [
            'project' => $project->load(['technologies', 'gallery']),
            'categories' => ProjectCategory::orderBy('name')->get(),
            'technologies' => Technology::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Project $project): RedirectResponse
    {
        $data = $this->validated($request);

        if ($request->filled('title') && ! $request->filled('slug')) {
            $data['slug'] = Str::slug($data['title']);
        }

        $project->update($data);
        $this->syncTechnologies($project, $request);
        $this->handleUploads($request, $project);

        return redirect()->route('admin.projects.edit', $project)->with('success', 'Project updated.');
    }

    public function destroy(Project $project): RedirectResponse
    {
        $this->deleteProjectFiles($project);
        $project->delete();

        return redirect()->route('admin.projects.index')->with('success', 'Project deleted.');
    }

    public function destroyGallery(Project $project, ProjectGallery $gallery): RedirectResponse|\Illuminate\Http\JsonResponse
    {
        abort_unless($gallery->project_id === $project->id, 404);

        Storage::disk('public')->delete($gallery->path);
        $gallery->delete();

        if (request()->expectsJson()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'Gallery image removed.');
    }

    private function syncTechnologies(Project $project, Request $request): void
    {
        $project->technologies()->sync($request->input('technologies', []));
    }

    private function handleUploads(Request $request, Project $project): void
    {
        foreach (['thumbnail', 'hero_image', 'mobile_image'] as $field) {
            if ($request->hasFile($field)) {
                if ($project->{$field}) {
                    Storage::disk('public')->delete($project->{$field});
                }
                $project->{$field} = $request->file($field)->store("projects/{$project->id}", 'public');
            }
        }

        $project->save();

        if ($request->hasFile('gallery')) {
            $sort = $project->gallery()->max('sort_order') ?? 0;
            foreach ($request->file('gallery') as $file) {
                if (! $file || ! $file->isValid()) {
                    continue;
                }
                $sort++;
                $path = $file->store("projects/{$project->id}/gallery", 'public');
                $project->gallery()->create([
                    'path' => $path,
                    'alt' => $project->title,
                    'type' => str_starts_with($file->getMimeType(), 'video/') ? 'video' : 'image',
                    'sort_order' => $sort,
                ]);
            }
        }
    }

    private function deleteProjectFiles(Project $project): void
    {
        foreach (['thumbnail', 'hero_image', 'mobile_image'] as $field) {
            if ($project->{$field}) {
                Storage::disk('public')->delete($project->{$field});
            }
        }

        foreach ($project->gallery as $item) {
            Storage::disk('public')->delete($item->path);
        }

        Storage::disk('public')->deleteDirectory("projects/{$project->id}");
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'project_category_id' => 'nullable|exists:project_categories,id',
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'excerpt' => 'nullable|string',
            'description' => 'nullable|string',
            'problem' => 'nullable|string',
            'challenge' => 'nullable|string',
            'solution' => 'nullable|string',
            'role' => 'nullable|string|max:255',
            'year' => 'nullable|integer|min:2000|max:2100',
            'live_url' => 'nullable|string|max:500',
            'github_url' => 'nullable|string|max:500',
            'video_url' => 'nullable|string|max:500',
            'thumbnail' => 'nullable|image|max:5120',
            'hero_image' => 'nullable|image|max:8192',
            'mobile_image' => 'nullable|image|max:5120',
            'gallery' => 'nullable|array',
            'gallery.*' => 'nullable|file|mimes:jpg,jpeg,png,webp,gif,mp4,webm|max:10240',
            'is_featured' => 'sometimes|boolean',
            'is_published' => 'sometimes|boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        foreach (['live_url', 'github_url', 'video_url'] as $urlField) {
            if (! empty($data[$urlField]) && ! filter_var($data[$urlField], FILTER_VALIDATE_URL)) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    $urlField => 'Please enter a valid URL including https://',
                ]);
            }
            if (empty($data[$urlField])) {
                $data[$urlField] = null;
            }
        }

        return $data + [
            'is_featured' => $request->boolean('is_featured'),
            'is_published' => $request->boolean('is_published'),
            'sort_order' => $request->input('sort_order', 0),
        ];
    }
}
