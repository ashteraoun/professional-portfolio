<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use App\Models\SkillCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SkillAdminController extends Controller
{
    public function index(): View
    {
        return view('admin.skills.index', ['categories' => SkillCategory::with('skills')->get()]);
    }

    public function create(): View
    {
        return view('admin.skills.create', ['categories' => SkillCategory::all()]);
    }

    public function store(Request $request): RedirectResponse
    {
        Skill::create($request->validate(['skill_category_id' => 'required|exists:skill_categories,id', 'name' => 'required', 'experience_level' => 'nullable']));

        return redirect()->route('admin.skills.index')->with('success', 'Skill created.');
    }

    public function edit(Skill $skill): View
    {
        return view('admin.skills.edit', ['skill' => $skill, 'categories' => SkillCategory::all()]);
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
