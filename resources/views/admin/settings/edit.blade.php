@extends('layouts.admin')

@section('header')
    <p class="admin-eyebrow">Portfolio configuration</p>
    <h1 class="admin-page-title">Site settings</h1>
@endsection

@section('content')
    @php
        $groups = [
            'identity' => [
                'title' => 'Brand & identity',
                'description' => 'Set the name and first impression visitors see across your site.',
                'fields' => [
                    'site_name' => ['label' => 'Site name', 'hint' => 'Used in the navigation, browser title, and footer.'],
                    'site_tagline' => ['label' => 'Professional tagline', 'hint' => 'A short description shown with your name.'],
                    'location' => ['label' => 'Location', 'hint' => 'For example: Remote · UTC+5.'],
                ],
            ],
            'hero' => [
                'title' => 'Homepage introduction',
                'description' => 'Shape the headline, supporting copy, and calls to action on your homepage.',
                'fields' => [
                    'hero_status' => ['label' => 'Availability', 'hint' => 'A short note such as “Available for select projects”.'],
                    'hero_headline' => ['label' => 'Headline', 'hint' => 'The primary message visitors see first.'],
                    'hero_subheadline' => ['label' => 'Supporting text'],
                    'hero_cta_primary' => ['label' => 'Primary button'],
                    'hero_cta_secondary' => ['label' => 'Secondary button'],
                    'years_experience' => ['label' => 'Years of experience', 'hint' => 'Shown in the homepage statistics.'],
                    'projects_delivered' => ['label' => 'Projects delivered', 'hint' => 'Shown in the homepage statistics.'],
                ],
            ],
            'about' => [
                'title' => 'About section',
                'description' => 'Introduce your background and approach.',
                'fields' => [
                    'about_intro' => ['label' => 'Introduction'],
                    'about_philosophy' => ['label' => 'Working philosophy'],
                ],
            ],
            'contact' => [
                'title' => 'Contact & social links',
                'description' => 'Choose how prospective clients can reach you.',
                'fields' => [
                    'contact_email' => ['label' => 'Contact email'],
                    'github_url' => ['label' => 'GitHub URL'],
                    'linkedin_url' => ['label' => 'LinkedIn URL'],
                    'resume_url' => ['label' => 'Resume URL', 'hint' => 'Use a full URL or a path such as /resume.'],
                ],
            ],
            'footer_seo' => [
                'title' => 'Footer & search preview',
                'description' => 'Customize your footer call to action and default search-engine metadata.',
                'fields' => [
                    'footer_statement' => ['label' => 'Footer statement'],
                    'footer_cta' => ['label' => 'Footer button'],
                    'seo_default_title' => ['label' => 'Default SEO title'],
                    'seo_default_description' => ['label' => 'Default SEO description'],
                ],
            ],
        ];
        $textareas = ['hero_subheadline', 'about_intro', 'about_philosophy', 'seo_default_description'];
        $logoPath = $settings['logo_path'] ?? null;
        $faviconPath = $settings['favicon_path'] ?? null;
    @endphp

    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <section class="admin-card admin-branding-card overflow-hidden">
            <div class="admin-settings-section-heading">
                <div class="admin-settings-heading-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path d="M4 7.5 12 3l8 4.5v9L12 21l-8-4.5v-9ZM12 12l8-4.5M12 12v9m0-9L4 7.5" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
                <div>
                    <h2>Logo & favicon</h2>
                    <p>Upload the visual identity used in your navigation and browser tab.</p>
                </div>
            </div>

            <div class="grid gap-5 border-t border-slate-100 p-5 sm:p-6 lg:grid-cols-2">
                <div class="admin-asset-card">
                    <div class="admin-asset-preview admin-logo-preview" data-branding-preview-target="logo">
                        @if($logoPath)
                            <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($logoPath) }}" alt="Current site logo">
                        @else
                            <span class="admin-logo-fallback" data-branding-placeholder>{{ strtoupper(substr(old('site_name', $settings['site_name'] ?? config('app.name')), 0, 1)) }}</span>
                        @endif
                        <span class="admin-asset-preview-name">{{ old('site_name', $settings['site_name'] ?? config('app.name')) }}</span>
                    </div>
                    <label for="logo" class="admin-label mt-5">Site logo</label>
                    <p class="admin-hint !mt-0 !mb-3">PNG, JPG, or WebP · maximum 2 MB · transparent PNG recommended.</p>
                    <input id="logo" name="logo" type="file" accept="image/png,image/jpeg,image/webp" data-branding-preview="logo" class="admin-input !p-2.5">
                    @error('logo')<p class="admin-field-error">{{ $message }}</p>@enderror
                    @if($logoPath)
                        <label class="admin-remove-asset"><input type="checkbox" name="remove_logo" value="1" @checked(old('remove_logo'))> Remove current logo</label>
                    @endif
                </div>

                <div class="admin-asset-card">
                    <div class="admin-asset-preview admin-favicon-preview" data-branding-preview-target="favicon">
                        @if($faviconPath)
                            <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($faviconPath) }}" alt="Current favicon">
                        @else
                            <span class="admin-favicon-placeholder" data-branding-placeholder>Aa</span>
                        @endif
                        <div class="admin-browser-tab"><span></span>{{ old('site_name', $settings['site_name'] ?? config('app.name')) }}</div>
                    </div>
                    <label for="favicon" class="admin-label mt-5">Browser favicon</label>
                    <p class="admin-hint !mt-0 !mb-3">PNG, JPG, or WebP · maximum 1 MB · square image, at least 32 × 32 px.</p>
                    <input id="favicon" name="favicon" type="file" accept="image/png,image/jpeg,image/webp" data-branding-preview="favicon" class="admin-input !p-2.5">
                    @error('favicon')<p class="admin-field-error">{{ $message }}</p>@enderror
                    @if($faviconPath)
                        <label class="admin-remove-asset"><input type="checkbox" name="remove_favicon" value="1" @checked(old('remove_favicon'))> Remove current favicon</label>
                    @endif
                </div>
            </div>
        </section>

        @foreach($groups as $group)
            <section class="admin-card overflow-hidden">
                <div class="admin-settings-section-heading">
                    <div class="admin-settings-heading-icon">
                        @if($loop->index === 1)
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path d="M4 5h16M4 12h10M4 19h7" stroke-width="1.7" stroke-linecap="round"/></svg>
                        @elseif($loop->index === 2)
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><circle cx="12" cy="8" r="3.5" stroke-width="1.6"/><path d="M5 20c.7-3.2 3.2-5 7-5s6.3 1.8 7 5" stroke-width="1.6" stroke-linecap="round"/></svg>
                        @elseif($loop->index === 3)
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><rect x="3.5" y="5" width="17" height="14" rx="2" stroke-width="1.6"/><path d="m4.5 7 7.5 5.5L19.5 7" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        @elseif($loop->index === 4)
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2Z" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        @else
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path d="M12 3 14.8 8.7 21 9.6l-4.5 4.4 1.1 6.2L12 17.3l-5.6 2.9 1.1-6.2L3 9.6l6.2-.9L12 3Z" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        @endif
                    </div>
                    <div>
                        <h2>{{ $group['title'] }}</h2>
                        <p>{{ $group['description'] }}</p>
                    </div>
                </div>

                <div class="grid gap-x-5 gap-y-4 border-t border-slate-100 p-5 sm:grid-cols-2 sm:p-6">
                    @foreach($group['fields'] as $key => $field)
                        @php
                            $isTextarea = in_array($key, $textareas, true);
                            $fieldClass = $isTextarea ? 'admin-textarea' : 'admin-input';
                            $type = $key === 'contact_email' ? 'email' : (str_ends_with($key, '_url') && $key !== 'resume_url' ? 'url' : 'text');
                        @endphp
                        <div class="{{ $isTextarea || in_array($key, ['hero_headline', 'about_intro', 'about_philosophy', 'seo_default_description'], true) ? 'sm:col-span-2' : '' }}">
                            <label for="{{ $key }}" class="admin-label">{{ $field['label'] }}</label>
                            @if($isTextarea)
                                <textarea id="{{ $key }}" name="{{ $key }}" rows="{{ $key === 'seo_default_description' ? 3 : 4 }}" class="{{ $fieldClass }}" @if($key === 'seo_default_description') maxlength="500" @endif>{{ old($key, $settings[$key] ?? '') }}</textarea>
                            @else
                                <input id="{{ $key }}" name="{{ $key }}" type="{{ $type }}" value="{{ old($key, $settings[$key] ?? '') }}" class="{{ $fieldClass }}">
                            @endif
                            @if(isset($field['hint']))<p class="admin-hint">{{ $field['hint'] }}</p>@endif
                            @error($key)<p class="admin-field-error">{{ $message }}</p>@enderror
                        </div>
                    @endforeach
                </div>
            </section>
        @endforeach

        <div class="admin-settings-savebar">
            <p>Your changes will be reflected across your public portfolio.</p>
            <button type="submit" class="admin-btn-primary">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path d="M5 12h14m-6-6 6 6-6 6" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                Save all settings
            </button>
        </div>
    </form>
@endsection
