<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class TestimonialAdminController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Admin', [
            'page' => 'resource-index', 'resource' => 'testimonials', 'title' => 'Testimonials',
            'createUrl' => route('admin.testimonials.create'),
            'records' => Testimonial::latest()->paginate(15),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Admin', [
            'page' => 'resource-form', 'resource' => 'testimonials', 'title' => 'New Testimonial',
            'action' => route('admin.testimonials.store'), 'indexUrl' => route('admin.testimonials.index'),
            'testimonial' => null,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        Testimonial::create($request->validate(['client_name' => 'required', 'content' => 'required', 'company' => 'nullable', 'is_published' => 'boolean']) + ['is_published' => $request->boolean('is_published')]);

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial created.');
    }

    public function edit(Testimonial $testimonial): Response
    {
        return Inertia::render('Admin', [
            'page' => 'resource-form', 'resource' => 'testimonials', 'title' => 'Edit Testimonial',
            'action' => route('admin.testimonials.update', $testimonial), 'indexUrl' => route('admin.testimonials.index'),
            'testimonial' => $testimonial,
        ]);
    }

    public function update(Request $request, Testimonial $testimonial): RedirectResponse
    {
        $testimonial->update($request->validate(['client_name' => 'required', 'content' => 'required', 'company' => 'nullable', 'is_published' => 'boolean']) + ['is_published' => $request->boolean('is_published')]);

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial updated.');
    }

    public function destroy(Testimonial $testimonial): RedirectResponse
    {
        $testimonial->delete();

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial deleted.');
    }
}
