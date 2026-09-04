@extends('layouts.admin')

@section('header')
    <h1 class="admin-page-title">Dashboard</h1>
    <p class="admin-page-subtitle">Overview of your portfolio</p>
@endsection

@section('content')
    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4 mb-8">
        @foreach(['projects' => 'Projects', 'posts' => 'Blog Posts', 'unread_messages' => 'Unread Messages', 'total_messages' => 'Total Messages'] as $key => $label)
            <div class="admin-card p-6">
                <p class="text-sm font-medium text-slate-500">{{ $label }}</p>
                <p class="text-3xl font-bold text-slate-900 mt-2">{{ $stats[$key] ?? 0 }}</p>
            </div>
        @endforeach
    </div>

    <div class="grid gap-6 lg:grid-cols-2">
        <div class="admin-card">
            <div class="px-6 py-4 border-b border-slate-100"><h2 class="font-semibold text-slate-900">Recent Messages</h2></div>
            <ul class="divide-y divide-slate-100">
                @forelse($recentMessages as $msg)
                    <li class="px-6 py-4 hover:bg-slate-50 transition"><a href="{{ route('admin.messages.show', $msg) }}" class="font-medium text-indigo-600 hover:text-indigo-800">{{ $msg->name }}</a><span class="text-sm text-slate-500 block mt-0.5">{{ Str::limit($msg->message, 60) }}</span></li>
                @empty
                    <li class="px-6 py-4 text-slate-500">No messages yet.</li>
                @endforelse
            </ul>
        </div>
        <div class="admin-card">
            <div class="px-6 py-4 border-b border-slate-100"><h2 class="font-semibold text-slate-900">Popular Projects</h2></div>
            <ul class="divide-y divide-slate-100">
                @forelse($popularProjects as $project)
                    <li class="px-6 py-4 flex justify-between items-center hover:bg-slate-50 transition"><span class="font-medium text-slate-800">{{ $project->title }}</span><span class="text-sm text-slate-500">{{ $project->view_count }} views</span></li>
                @empty
                    <li class="px-6 py-4 text-slate-500">No projects yet.</li>
                @endforelse
            </ul>
        </div>
    </div>
@endsection
