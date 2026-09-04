@extends('layouts.admin')

@section('header')
    <h1 class="text-2xl font-semibold text-gray-900">Projects</h1>
@endsection

@section('actions')
    <a href="{{ route('admin.projects.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm rounded-md hover:bg-indigo-700">New Project</a>
@endsection

@section('content')
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50"><tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Title</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Category</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                <th class="px-6 py-3"></th>
            </tr></thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($projects as $project)
                    <tr>
                        <td class="px-6 py-4">{{ $project->title }}</td>
                        <td class="px-6 py-4 text-gray-500">{{ $project->category?->name }}</td>
                        <td class="px-6 py-4"><span class="text-xs {{ $project->is_published ? 'text-green-600' : 'text-gray-400' }}">{{ $project->is_published ? 'Published' : 'Draft' }}</span></td>
                        <td class="px-6 py-4 text-right space-x-2">
                            <a href="{{ route('admin.projects.edit', $project) }}" class="text-indigo-600 text-sm">Edit</a>
                            <form action="{{ route('admin.projects.destroy', $project) }}" method="POST" class="inline" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button class="text-red-600 text-sm">Delete</button></form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $projects->links() }}</div>
@endsection
