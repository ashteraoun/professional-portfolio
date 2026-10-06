<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class PackageAdminController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Admin', [
            'page' => 'resource-index', 'resource' => 'packages', 'title' => 'Packages',
            'createUrl' => route('admin.packages.create'),
            'records' => Package::with('features')->orderBy('sort_order')->paginate(15),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Admin', [
            'page' => 'resource-form', 'resource' => 'packages', 'title' => 'New Package',
            'action' => route('admin.packages.store'), 'indexUrl' => route('admin.packages.index'),
            'package' => null,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate(['name' => 'required', 'description' => 'nullable', 'price' => 'nullable|numeric', 'delivery_time' => 'nullable', 'is_published' => 'boolean', 'is_recommended' => 'boolean']);
        $data['slug'] = Str::slug($data['name']);
        $data['is_published'] = $request->boolean('is_published');
        $data['is_recommended'] = $request->boolean('is_recommended');
        Package::create($data);

        return redirect()->route('admin.packages.index')->with('success', 'Package created.');
    }

    public function edit(Package $package): Response
    {
        return Inertia::render('Admin', [
            'page' => 'resource-form', 'resource' => 'packages', 'title' => 'Edit Package',
            'action' => route('admin.packages.update', $package), 'indexUrl' => route('admin.packages.index'),
            'package' => $package->load('features'),
        ]);
    }

    public function update(Request $request, Package $package): RedirectResponse
    {
        $data = $request->validate(['name' => 'required', 'description' => 'nullable', 'price' => 'nullable|numeric', 'delivery_time' => 'nullable', 'is_published' => 'boolean', 'is_recommended' => 'boolean']);
        $data['is_published'] = $request->boolean('is_published');
        $data['is_recommended'] = $request->boolean('is_recommended');
        $package->update($data);

        return redirect()->route('admin.packages.index')->with('success', 'Package updated.');
    }

    public function destroy(Package $package): RedirectResponse
    {
        $package->delete();

        return redirect()->route('admin.packages.index')->with('success', 'Package deleted.');
    }
}
