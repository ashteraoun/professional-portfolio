@extends('layouts.admin')

@section('header')
    <p class="admin-eyebrow">Workspace overview</p>
    <h1 class="admin-page-title">Dashboard</h1>
@endsection

@section('content')
    @php
        $dashboardCards = [
            ['key' => 'projects', 'label' => 'Projects', 'icon' => 'M4 7.5 12 3l8 4.5v9L12 21l-8-4.5v-9ZM12 12l8-4.5M12 12v9m0-9L4 7.5'],
            ['key' => 'posts', 'label' => 'Blog Posts', 'icon' => 'M7 4h10a2 2 0 0 1 2 2v14l-7-4-7 4V6a2 2 0 0 1 2-2Zm2 4h6m-6 4h6'],
            ['key' => 'unread_messages', 'label' => 'Unread Messages', 'icon' => 'M4 6h16v12H4zM4 7l8 6 8-6'],
            ['key' => 'total_messages', 'label' => 'Total Messages', 'icon' => 'M8 10h8m-8 4h5m-8 6 1.8-3.6A8 8 0 1 1 12 20H6Z'],
        ];
    @endphp

    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4 mb-8">
        @foreach($dashboardCards as $card)
            <div class="admin-card admin-metric-card p-5 sm:p-6">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <p class="text-sm font-medium text-slate-500">{{ $card['label'] }}</p>
                        <p class="mt-3 text-3xl font-bold tracking-tight text-slate-900">{{ $stats[$card['key']] ?? 0 }}</p>
                    </div>
                    <span class="admin-metric-icon">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="{{ $card['icon'] }}"/></svg>
                    </span>
                </div>
            </div>
        @endforeach
    </div>

    <section class="admin-card mb-8 p-5 sm:p-6">
        <div class="mb-4">
            <h2 class="font-semibold text-slate-900">Quick actions</h2>
            <p class="mt-1 text-sm text-slate-500">Jump into the parts of your portfolio you update most.</p>
        </div>
        <div class="grid gap-3 sm:grid-cols-3">
            <a href="{{ route('admin.projects.create') }}" class="admin-quick-link">
                <span class="admin-quick-link-icon">+</span>
                <span><strong>New project</strong><small>Add work to your portfolio</small></span>
                <span class="admin-quick-arrow" aria-hidden="true">→</span>
            </a>
            <a href="{{ route('admin.blog.create') }}" class="admin-quick-link">
                <span class="admin-quick-link-icon"><svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="m16.862 4.487 2.651 2.651M7 17l3.5-.7L19.5 7.3a1.875 1.875 0 0 0-2.65-2.65l-9 9L7 17Zm-2 3h14"/></svg></span>
                <span><strong>Write an article</strong><small>Publish a new blog post</small></span>
                <svg class="admin-quick-arrow h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M5 12h14m-6-6 6 6-6 6"/></svg>
            </a>
            <a href="{{ route('admin.settings.edit') }}" class="admin-quick-link">
                <span class="admin-quick-link-icon"><svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M4 7h10m4 0h2M4 17h2m4 0h10M14 5v4M8 15v4"/></svg></span>
                <span><strong>Site settings</strong><small>Update your portfolio details</small></span>
                <svg class="admin-quick-arrow h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M5 12h14m-6-6 6 6-6 6"/></svg>
            </a>
        </div>
    </section>

    <div class="grid gap-6 lg:grid-cols-2">
        <div class="admin-card">
            <div class="flex items-center justify-between border-b border-slate-100 px-6 py-4">
                <h2 class="font-semibold text-slate-900">Recent Messages</h2>
                <a href="{{ route('admin.messages.index') }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-800">View all</a>
            </div>
            <ul class="divide-y divide-slate-100">
                @forelse($recentMessages as $msg)
                    <li class="px-6 py-4 hover:bg-slate-50 transition"><a href="{{ route('admin.messages.show', $msg) }}" class="font-medium text-indigo-600 hover:text-indigo-800">{{ $msg->name }}</a><span class="text-sm text-slate-500 block mt-0.5">{{ Str::limit($msg->message, 60) }}</span></li>
                @empty
                    <li class="px-6 py-4 text-slate-500">No messages yet.</li>
                @endforelse
            </ul>
        </div>
        <div class="admin-card">
            <div class="flex items-center justify-between border-b border-slate-100 px-6 py-4">
                <h2 class="font-semibold text-slate-900">Popular Projects</h2>
                <a href="{{ route('admin.projects.index') }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-800">View all</a>
            </div>
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
