<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class ServiceAdminController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Admin', [
            'page' => 'resource-index', 'resource' => 'services', 'title' => 'Services',
            'createUrl' => route('admin.services.create'),
            'records' => Service::orderBy('sort_order')->paginate(15),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Admin', [
            'page' => 'resource-form', 'resource' => 'services', 'title' => 'New Service',
            'action' => route('admin.services.store'), 'indexUrl' => route('admin.services.index'),
            'service' => null,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate(['title' => 'required', 'excerpt' => 'nullable', 'description' => 'nullable', 'is_published' => 'boolean']);
        $data['slug'] = Str::slug($data['title']);
        $data['is_published'] = $request->boolean('is_published');
        Service::create($data);

        return redirect()->route('admin.services.index')->with('success', 'Service created.');
    }

    public function edit(Service $service): Response
    {
        return Inertia::render('Admin', [
            'page' => 'resource-form', 'resource' => 'services', 'title' => 'Edit Service',
            'action' => route('admin.services.update', $service), 'indexUrl' => route('admin.services.index'),
            'service' => $service,
        ]);
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
