<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ServiceAdminController extends Controller
{
    public function index(): View
    {
        return view('admin.services.index', ['services' => Service::orderBy('sort_order')->paginate(15)]);
    }

    public function create(): View
    {
        return view('admin.services.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate(['title' => 'required', 'excerpt' => 'nullable', 'description' => 'nullable', 'is_published' => 'boolean']);
        $data['slug'] = Str::slug($data['title']);
        $data['is_published'] = $request->boolean('is_published');
        Service::create($data);

        return redirect()->route('admin.services.index')->with('success', 'Service created.');
    }

    public function edit(Service $service): View
    {
        return view('admin.services.edit', ['service' => $service]);
    }

    public function update(Request $request, Service $service): RedirectResponse
    {
        $data = $request->validate(['title' => 'required', 'excerpt' => 'nullable', 'description' => 'nullable', 'is_published' => 'boolean']);
        $data['is_published'] = $request->boolean('is_published');
        $service->update($data);

        return redirect()->route('admin.services.index')->with('success', 'Service updated.');
    }

    public function destroy(Service $service): RedirectResponse
    {
        $service->delete();

        return redirect()->route('admin.services.index')->with('success', 'Service deleted.');
    }
}
