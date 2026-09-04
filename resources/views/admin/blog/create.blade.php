@extends('layouts.admin')
@section('header')<h1 class="text-2xl font-semibold">New Post</h1>@endsection
@section('content')
<form action="{{ route('admin.blog.store') }}" method="POST" class="bg-white rounded-lg shadow p-6 space-y-4 max-w-2xl">@csrf
<div><label class="block text-sm font-medium">Title</label><input name="title" required class="mt-1 w-full rounded-md border-gray-300"></div>
<div><label class="block text-sm font-medium">Excerpt</label><textarea name="excerpt" rows="2" class="mt-1 w-full rounded-md border-gray-300"></textarea></div>
<div><label class="block text-sm font-medium">Content (Markdown)</label><textarea name="content" rows="12" required class="mt-1 w-full rounded-md border-gray-300 font-mono text-sm"></textarea></div>
<div><label class="block text-sm font-medium">Status</label><select name="status" class="mt-1 rounded-md border-gray-300"><option value="draft">Draft</option><option value="published">Published</option></select></div>
<button class="px-4 py-2 bg-indigo-600 text-white rounded-md">Create</button>
</form>@endsection
