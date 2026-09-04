<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PackageAdminController extends Controller
{
    public function index(): View
    {
        return view('admin.packages.index', ['packages' => Package::with('features')->orderBy('sort_order')->paginate(15)]);
    }

    public function create(): View
    {
        return view('admin.packages.create');
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

    public function edit(Package $package): View
    {
        return view('admin.packages.edit', ['package' => $package->load('features')]);
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
