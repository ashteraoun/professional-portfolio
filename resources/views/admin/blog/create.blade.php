@extends('layouts.admin')
@section('header')<h1 class="admin-page-title">New Post</h1>@endsection
@section('content')
<form action="{{ route('admin.blog.store') }}" method="POST" class="admin-card p-6 space-y-5 max-w-2xl">@csrf
<div>
    <label class="admin-label">Title</label>
    <input name="title" required class="admin-input">
</div>
<div>
    <label class="admin-label">Excerpt</label>
    <textarea name="excerpt" rows="2" class="admin-textarea"></textarea>
</div>
<div>
    <label class="admin-label">Content (Markdown)</label>
    <textarea name="content" rows="12" required class="admin-textarea font-mono"></textarea>
</div>
<div>
    <label class="admin-label">Status</label>
    <select name="status" class="admin-select">
        <option value="draft">Draft</option>
        <option value="published">Published</option>
    </select>
</div>
<button class="admin-btn-primary">Create Post</button>
</form>@endsection
