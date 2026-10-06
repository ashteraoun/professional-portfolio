<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\SiteSettingsService;
use Illuminate\Http\UploadedFile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;
use RuntimeException;

class SettingAdminController extends Controller
{
    public function __construct(private SiteSettingsService $settings) {}

    public function edit(): Response
    {
        return Inertia::render('Admin', [
            'page' => 'settings',
            'settings' => $this->settings->all(),
            'action' => route('admin.settings.update'),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'site_name' => ['required', 'string', 'max:120'],
            'site_tagline' => ['nullable', 'string', 'max:255'],
            'hero_status' => ['nullable', 'string', 'max:120'],
            'hero_headline' => ['nullable', 'string', 'max:255'],
            'hero_subheadline' => ['nullable', 'string', 'max:1000'],
            'hero_cta_primary' => ['nullable', 'string', 'max:100'],
            'hero_cta_secondary' => ['nullable', 'string', 'max:100'],
            'years_experience' => ['nullable', 'string', 'max:30'],
            'projects_delivered' => ['nullable', 'string', 'max:30'],
            'location' => ['nullable', 'string', 'max:120'],
            'about_intro' => ['nullable', 'string', 'max:5000'],
            'about_philosophy' => ['nullable', 'string', 'max:5000'],
            'footer_statement' => ['nullable', 'string', 'max:255'],
            'footer_cta' => ['nullable', 'string', 'max:100'],
            'contact_email' => ['nullable', 'email', 'max:255'],
            'seo_default_title' => ['nullable', 'string', 'max:255'],
            'seo_default_description' => ['nullable', 'string', 'max:500'],
            'github_url' => ['nullable', 'url', 'max:500'],
            'linkedin_url' => ['nullable', 'url', 'max:500'],
            'resume_url' => ['nullable', 'string', 'max:500'],
            'logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'favicon' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:1024'],
            'remove_logo' => ['sometimes', 'boolean'],
            'remove_favicon' => ['sometimes', 'boolean'],
        ]);

        foreach (array_diff_key($validated, array_flip([
            'logo',
            'favicon',
            'remove_logo',
            'remove_favicon',
        ])) as $key => $value) {
            $this->settings->set($key, $value);
        }

        foreach (['logo', 'favicon'] as $field) {
            $removeField = "remove_{$field}";
            $oldPath = $this->settings->get("{$field}_path");

            if ($request->hasFile($field)) {
                $newPath = $this->storeBrandingImage($request->file($field), $field);
                $this->settings->set("{$field}_path", $newPath, 'image', 'branding');
                $this->deleteBrandingImage($oldPath);
            } elseif ($validated[$removeField] ?? false) {
                $this->settings->set("{$field}_path", null, 'image', 'branding');
                $this->deleteBrandingImage($oldPath);
            }
        }

        return back()->with('success', 'Settings saved.');
    }

    private function storeBrandingImage(UploadedFile $file, string $name): string
    {
        $path = $file->store('site/branding', 'public');

        if (! is_string($path)) {
            throw new RuntimeException("Unable to store the site {$name} image.");
        }

        return $path;
    }

    private function deleteBrandingImage(mixed $path): void
    {
        if (is_string($path) && str_starts_with($path, 'site/branding/')) {
            Storage::disk('public')->delete($path);
        }
    }
}
