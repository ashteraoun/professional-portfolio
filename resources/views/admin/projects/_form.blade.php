{{-- Basic info --}}
<div class="admin-card p-6 md:p-8 space-y-6">
    <div>
        <h2 class="admin-section-title">
            <svg class="h-5 w-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Basic Information
        </h2>
        <p class="admin-section-desc">Core project details shown on cards and case study pages.</p>
    </div>

    <div class="grid gap-6 md:grid-cols-2">
        <div>
            <label class="admin-label" for="title">Title <span class="text-red-500">*</span></label>
            <input type="text" id="title" name="title" value="{{ old('title', $project?->title ?? '') }}" required class="admin-input @error('title') border-red-500 @enderror" placeholder="Project Alpha">
            @error('title')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="admin-label" for="subtitle">Subtitle</label>
            <input type="text" id="subtitle" name="subtitle" value="{{ old('subtitle', $project?->subtitle ?? '') }}" class="admin-input" placeholder="Multi-tenant SaaS platform">
        </div>
    </div>

    <div class="grid gap-6 md:grid-cols-3">
        <div>
            <label class="admin-label" for="project_category_id">Category</label>
            <select id="project_category_id" name="project_category_id" class="admin-select">
                <option value="">Select category</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" @selected(old('project_category_id', $project?->project_category_id ?? '') == $cat->id)>{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="admin-label" for="year">Year</label>
            <input type="number" id="year" name="year" value="{{ old('year', $project?->year ?? date('Y')) }}" class="admin-input" min="2000" max="2100">
        </div>
        <div>
            <label class="admin-label" for="role">Your Role</label>
            <input type="text" id="role" name="role" value="{{ old('role', $project?->role ?? '') }}" class="admin-input" placeholder="Lead Full-Stack Developer">
        </div>
    </div>

    <div>
        <label class="admin-label" for="excerpt">Short Excerpt</label>
        <textarea id="excerpt" name="excerpt" rows="2" class="admin-textarea" placeholder="One-line summary for project cards...">{{ old('excerpt', $project?->excerpt ?? '') }}</textarea>
        <p class="admin-hint">Displayed on project cards and search results.</p>
    </div>
</div>

{{-- Case study --}}
<div class="admin-card p-6 md:p-8 space-y-6 mt-6">
    <div>
        <h2 class="admin-section-title">
            <svg class="h-5 w-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            Case Study Content
        </h2>
        <p class="admin-section-desc">Detailed narrative for the project detail page.</p>
    </div>

    <div class="grid gap-6 lg:grid-cols-2">
        <div>
            <label class="admin-label" for="problem">Overview / Problem</label>
            <textarea id="problem" name="problem" rows="4" class="admin-textarea" placeholder="What problem did this project solve?">{{ old('problem', $project?->problem ?? '') }}</textarea>
        </div>
        <div>
            <label class="admin-label" for="challenge">Challenge</label>
            <textarea id="challenge" name="challenge" rows="4" class="admin-textarea" placeholder="What made this difficult?">{{ old('challenge', $project?->challenge ?? '') }}</textarea>
        </div>
    </div>

    <div>
        <label class="admin-label" for="solution">Solution</label>
        <textarea id="solution" name="solution" rows="4" class="admin-textarea" placeholder="How did you approach and solve it?">{{ old('solution', $project?->solution ?? '') }}</textarea>
    </div>
</div>

{{-- Links --}}
<div class="admin-card p-6 md:p-8 space-y-6 mt-6">
    <div>
        <h2 class="admin-section-title">
            <svg class="h-5 w-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
            Links & Live Preview
        </h2>
        <p class="admin-section-desc">Live URL enables the interactive preview on the projects page.</p>
    </div>

    <div class="grid gap-6 md:grid-cols-3">
        <div>
            <label class="admin-label" for="live_url">Live Demo URL</label>
            <input type="text" id="live_url" name="live_url" value="{{ old('live_url', $project?->live_url ?? '') }}" class="admin-input @error('live_url') border-red-500 @enderror" placeholder="https://yourproject.com" inputmode="url" autocomplete="url">
            @error('live_url')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            <p class="admin-hint">Powers live iframe preview · include https://</p>
        </div>
        <div>
            <label class="admin-label" for="github_url">GitHub URL</label>
            <input type="text" id="github_url" name="github_url" value="{{ old('github_url', $project?->github_url ?? '') }}" class="admin-input @error('github_url') border-red-500 @enderror" placeholder="https://github.com/user/repo" inputmode="url" autocomplete="url">
            @error('github_url')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="admin-label" for="video_url">Video Embed URL</label>
            <input type="text" id="video_url" name="video_url" value="{{ old('video_url', $project?->video_url ?? '') }}" class="admin-input @error('video_url') border-red-500 @enderror" placeholder="https://youtube.com/embed/..." inputmode="url" autocomplete="url">
            @error('video_url')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
        </div>
    </div>
</div>

{{-- Technologies --}}
<div class="admin-card p-6 md:p-8 space-y-4 mt-6">
    <div>
        <h2 class="admin-section-title">
            <svg class="h-5 w-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/></svg>
            Technologies
        </h2>
        <p class="admin-section-desc">Select all technologies used in this project.</p>
    </div>

    <div class="admin-tech-grid">
        @foreach($technologies as $tech)
            <label class="admin-tech-item">
                <input type="checkbox" name="technologies[]" value="{{ $tech->id }}" class="admin-checkbox"
                    @checked(in_array($tech->id, old('technologies', $project?->technologies?->pluck('id')->toArray() ?? [])))>
                {{ $tech->name }}
            </label>
        @endforeach
    </div>
</div>

{{-- Images --}}
<div class="admin-card p-6 md:p-8 space-y-6 mt-6">
    <div>
        <h2 class="admin-section-title">
            <svg class="h-5 w-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            Project Images
        </h2>
        <p class="admin-section-desc">Upload visuals for cards, hero banner, and gallery lightbox.</p>
    </div>

    <div class="grid gap-6 md:grid-cols-3">
        @foreach([
            ['field' => 'thumbnail', 'label' => 'Thumbnail', 'hint' => 'Project cards & list'],
            ['field' => 'hero_image', 'label' => 'Hero Image', 'hint' => 'Detail page banner'],
            ['field' => 'mobile_image', 'label' => 'Mobile Image', 'hint' => 'Optional mobile variant'],
        ] as $img)
            <div>
                <label class="admin-label">{{ $img['label'] }}</label>
                @if(!empty($project?->{$img['field']}))
                    <div class="admin-gallery-thumb mb-3">
                        <img src="{{ \App\Models\Project::storageUrl($project->{$img['field']}) }}" alt="" class="h-full w-full object-cover">
                    </div>
                @endif
                <div class="admin-file-zone" data-file-zone>
                    <svg class="h-8 w-8 text-slate-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                    <p class="text-sm font-medium text-slate-700" data-file-name>Click to upload</p>
                    <p class="admin-hint">{{ $img['hint'] }} · JPG, PNG, WebP</p>
                    <input type="file" name="{{ $img['field'] }}" accept="image/*" data-file-preview>
                </div>
            </div>
        @endforeach
    </div>

    <div>
        <label class="admin-label">Gallery Images</label>
        <div class="admin-file-zone py-10" data-file-zone>
            <svg class="h-10 w-10 text-indigo-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            <p class="text-sm font-semibold text-slate-800" data-file-count>Drop images or click to browse</p>
            <p class="admin-hint">Multiple files · JPG, PNG, WebP, GIF, MP4 · Max 10MB each</p>
            <input type="file" name="gallery[]" accept="image/*,video/mp4,video/webm" multiple data-gallery-input>
        </div>
    </div>

    @if(!empty($project) && $project->gallery->isNotEmpty())
        <div>
            <p class="admin-label mb-3">Current Gallery ({{ $project->gallery->count() }})</p>
            <p class="admin-hint mb-3">Remove images using the buttons below after saving, or from the gallery panel under the form.</p>
            <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-5 gap-3" id="project-gallery-grid">
                @foreach($project->gallery as $item)
                    <div class="admin-gallery-thumb group" data-gallery-id="{{ $item->id }}">
                        <img src="{{ \App\Models\Project::storageUrl($item->path) }}" alt="" class="h-full w-full object-cover">
                        <div class="absolute inset-0 flex items-center justify-center bg-slate-900/60 opacity-0 group-hover:opacity-100 transition">
                            <button type="button" class="admin-btn-danger gallery-remove-btn" data-remove-url="{{ route('admin.projects.gallery.destroy', [$project, $item]) }}">Remove</button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>

{{-- Publishing --}}
<div class="admin-card p-6 md:p-8 mt-6">
    <h2 class="admin-section-title mb-5">
        <svg class="h-5 w-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        Publishing Options
    </h2>

    <div class="flex flex-wrap items-center gap-8">
        <label class="admin-checkbox-label">
            <input type="checkbox" name="is_featured" value="1" class="admin-checkbox" @checked(old('is_featured', $project?->is_featured ?? false))>
            Featured project
        </label>
        <label class="admin-checkbox-label">
            <input type="checkbox" name="is_published" value="1" class="admin-checkbox" @checked(old('is_published', $project?->is_published ?? true))>
            Published (visible on site)
        </label>
        <div class="flex items-center gap-3">
            <label class="admin-label mb-0" for="sort_order">Sort order</label>
            <input type="number" id="sort_order" name="sort_order" value="{{ old('sort_order', $project?->sort_order ?? 0) }}" class="admin-input w-24" min="0">
        </div>
    </div>
</div>
