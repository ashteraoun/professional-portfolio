<div>
    <label class="block text-sm font-medium text-gray-700">Title</label>
    <input type="text" name="title" value="{{ old('title', $project->title ?? '') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
</div>
<div>
    <label class="block text-sm font-medium text-gray-700">Category</label>
    <select name="project_category_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
        <option value="">None</option>
        @foreach($categories as $cat)
            <option value="{{ $cat->id }}" @selected(old('project_category_id', $project->project_category_id ?? '') == $cat->id)>{{ $cat->name }}</option>
        @endforeach
    </select>
</div>
<div>
    <label class="block text-sm font-medium text-gray-700">Excerpt</label>
    <textarea name="excerpt" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('excerpt', $project->excerpt ?? '') }}</textarea>
</div>
<div>
    <label class="block text-sm font-medium text-gray-700">Role</label>
    <input type="text" name="role" value="{{ old('role', $project->role ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
</div>
<div>
    <label class="block text-sm font-medium text-gray-700">Year</label>
    <input type="number" name="year" value="{{ old('year', $project->year ?? date('Y')) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
</div>
<div class="flex gap-4">
    <label class="flex items-center gap-2"><input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $project->is_featured ?? false))> Featured</label>
    <label class="flex items-center gap-2"><input type="checkbox" name="is_published" value="1" @checked(old('is_published', $project->is_published ?? true))> Published</label>
</div>
