@extends('layouts.admin')
@section('header')<h1 class="text-2xl font-semibold">Edit Post</h1>@endsection
@section('content')
<form action="{{ route('admin.blog.update', $post) }}" method="POST" class="bg-white rounded-lg shadow p-6 space-y-4 max-w-2xl">@csrf @method('PUT')
<div><label class="block text-sm font-medium">Title</label><input name="title" value="{{ $post->title }}" required class="mt-1 w-full rounded-md border-gray-300"></div>
<div><label class="block text-sm font-medium">Excerpt</label><textarea name="excerpt" rows="2" class="mt-1 w-full rounded-md border-gray-300">{{ $post->excerpt }}</textarea></div>
<div><label class="block text-sm font-medium">Content</label><textarea name="content" rows="12" required class="mt-1 w-full rounded-md border-gray-300 font-mono text-sm">{{ $post->content }}</textarea></div>
<div><label class="block text-sm font-medium">Status</label><select name="status" class="mt-1 rounded-md border-gray-300"><option value="draft" @selected($post->status==='draft')>Draft</option><option value="published" @selected($post->status==='published')>Published</option></select></div>
<button class="px-4 py-2 bg-indigo-600 text-white rounded-md">Update</button>
</form>@endsection
