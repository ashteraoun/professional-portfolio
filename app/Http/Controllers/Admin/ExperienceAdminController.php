<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Experience;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ExperienceAdminController extends Controller
{
    public function index(): View
    {
        return view('admin.experience.index', ['experiences' => Experience::orderByDesc('started_at')->paginate(15)]);
    }

    public function create(): View
    {
        return view('admin.experience.create');
    }

    public function store(Request $request): RedirectResponse
    {
        Experience::create($this->validated($request));

        return redirect()->route('admin.experience.index')->with('success', 'Experience created.');
    }

    public function edit(Experience $experience): View
    {
        return view('admin.experience.edit', ['experience' => $experience]);
    }

    public function update(Request $request, Experience $experience): RedirectResponse
    {
        $experience->update($this->validated($request));

        return redirect()->route('admin.experience.index')->with('success', 'Experience updated.');
    }

    public function destroy(Experience $experience): RedirectResponse
    {
        $experience->delete();

        return redirect()->route('admin.experience.index')->with('success', 'Experience deleted.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'company' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'started_at' => 'required|date',
            'ended_at' => 'nullable|date|after:started_at',
            'is_current' => 'boolean',
            'description' => 'nullable|string',
            'is_published' => 'boolean',
        ]) + [
            'is_current' => $request->boolean('is_current'),
            'is_published' => $request->boolean('is_published'),
        ];
    }
}
