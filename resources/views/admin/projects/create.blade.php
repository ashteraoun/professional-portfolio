@extends('layouts.admin')

@section('header')
    <h1 class="admin-page-title">New Project</h1>
    <p class="admin-page-subtitle">Create a new portfolio case study</p>
@endsection

@section('actions')
    <a href="{{ route('admin.projects.index') }}" class="admin-btn-secondary">Back to list</a>
@endsection

@section('content')
<form action="{{ route('admin.projects.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @include('admin.projects._form')

    <div class="sticky bottom-0 mt-8 flex flex-wrap items-center justify-between gap-4 rounded-xl border border-slate-200 bg-white/95 backdrop-blur px-6 py-4 shadow-lg">
        <p class="text-sm text-slate-500">You can add gallery images after creating the project.</p>
        <div class="flex gap-3">
            <a href="{{ route('admin.projects.index') }}" class="admin-btn-secondary">Cancel</a>
            <button type="submit" class="admin-btn-primary">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Create Project
            </button>
        </div>
    </div>
</form>
@endsection
