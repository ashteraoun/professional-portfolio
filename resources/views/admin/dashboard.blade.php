@extends('layouts.admin')

@section('header')
    <h1 class="text-2xl font-semibold text-gray-900">Dashboard</h1>
@endsection

@section('content')
    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4 mb-8">
        @foreach(['projects' => 'Projects', 'posts' => 'Blog Posts', 'unread_messages' => 'Unread Messages', 'total_messages' => 'Total Messages'] as $key => $label)
            <div class="bg-white rounded-lg shadow p-6">
                <p class="text-sm text-gray-500">{{ $label }}</p>
                <p class="text-3xl font-semibold text-gray-900 mt-1">{{ $stats[$key] ?? 0 }}</p>
            </div>
        @endforeach
    </div>

    <div class="grid gap-6 lg:grid-cols-2">
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b"><h2 class="font-semibold">Recent Messages</h2></div>
            <ul class="divide-y">
                @forelse($recentMessages as $msg)
                    <li class="px-6 py-4"><a href="{{ route('admin.messages.show', $msg) }}" class="text-indigo-600 hover:underline">{{ $msg->name }}</a><span class="text-sm text-gray-500 block">{{ Str::limit($msg->message, 60) }}</span></li>
                @empty
                    <li class="px-6 py-4 text-gray-500">No messages yet.</li>
                @endforelse
            </ul>
        </div>
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b"><h2 class="font-semibold">Popular Projects</h2></div>
            <ul class="divide-y">
                @forelse($popularProjects as $project)
                    <li class="px-6 py-4 flex justify-between"><span>{{ $project->title }}</span><span class="text-gray-500">{{ $project->view_count }} views</span></li>
                @empty
                    <li class="px-6 py-4 text-gray-500">No projects yet.</li>
                @endforelse
            </ul>
        </div>
    </div>
@endsection
