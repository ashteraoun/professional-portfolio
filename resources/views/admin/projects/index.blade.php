@extends('layouts.admin')

@section('header')
    <h1 class="admin-page-title">Projects</h1>
    <p class="admin-page-subtitle">Manage portfolio case studies and images</p>
@endsection

@section('actions')
    <a href="{{ route('admin.projects.create') }}" class="admin-btn-primary">
        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        New Project
    </a>
@endsection

@section('content')
<div class="admin-card overflow-hidden">
    <table class="min-w-full divide-y divide-slate-200">
        <thead class="bg-slate-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Project</th>
                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Category</th>
                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Status</th>
                <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100 bg-white">
            @forelse($projects as $project)
                <tr class="hover:bg-slate-50/80 transition">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-4">
                            @if($project->thumbnail)
                                <img src="{{ \App\Models\Project::storageUrl($project->thumbnail) }}" alt="" class="h-12 w-16 rounded-lg object-cover border border-slate-200">
                            @else
                                <div class="h-12 w-16 rounded-lg bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-sm">{{ substr($project->title, 0, 1) }}</div>
                            @endif
                            <div>
                                <p class="font-semibold text-slate-900">{{ $project->title }}</p>
                                <p class="text-xs text-slate-500">{{ $project->year }} · {{ $project->gallery->count() }} images</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm text-slate-600">{{ $project->category?->name ?? '—' }}</td>
                    <td class="px-6 py-4">
                        @if($project->is_published)
                            <span class="inline-flex rounded-full bg-emerald-100 px-2.5 py-0.5 text-xs font-semibold text-emerald-800">Published</span>
                        @else
                            <span class="inline-flex rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-semibold text-slate-600">Draft</span>
                        @endif
                        @if($project->is_featured)
                            <span class="ml-1 inline-flex rounded-full bg-indigo-100 px-2.5 py-0.5 text-xs font-semibold text-indigo-800">Featured</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right space-x-3">
                        <a href="{{ route('admin.projects.edit', $project) }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-800">Edit</a>
                        <form action="{{ route('admin.projects.destroy', $project) }}" method="POST" class="inline" onsubmit="return confirm('Delete this project?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-sm font-semibold text-red-600 hover:text-red-800">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="px-6 py-12 text-center text-slate-500">No projects yet. Create your first one.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $projects->links() }}</div>
@endsection
