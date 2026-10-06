<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use App\Models\SkillCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class SkillAdminController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Admin', [
            'page' => 'resource-index', 'resource' => 'skills', 'title' => 'Skills',
            'createUrl' => route('admin.skills.create'),
            'categoriesWithSkills' => SkillCategory::with('skills')->get(),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Admin', [
            'page' => 'resource-form', 'resource' => 'skills', 'title' => 'New Skill',
            'action' => route('admin.skills.store'), 'indexUrl' => route('admin.skills.index'),
            'categories' => SkillCategory::all(), 'skill' => null,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        Skill::create($request->validate(['skill_category_id' => 'required|exists:skill_categories,id', 'name' => 'required', 'experience_level' => 'nullable']));

        return redirect()->route('admin.skills.index')->with('success', 'Skill created.');
    }

    public function edit(Skill $skill): Response
    {
        return Inertia::render('Admin', [
            'page' => 'resource-form', 'resource' => 'skills', 'title' => 'Edit Skill',
            'action' => route('admin.skills.update', $skill), 'indexUrl' => route('admin.skills.index'),
            'skill' => $skill, 'categories' => SkillCategory::all(),
        ]);
    }

    public function update(Request $request, Skill $skill): RedirectResponse
    {
        $skill->update($request->validate(['skill_category_id' => 'required|exists:skill_categories,id', 'name' => 'required', 'experience_level' => 'nullable']));

        return redirect()->route('admin.skills.index')->with('success', 'Skill updated.');
    }

    public function destroy(Skill $skill): RedirectResponse
    {
        $skill->delete();

        return redirect()->route('admin.skills.index')->with('success', 'Skill deleted.');
    }
}
