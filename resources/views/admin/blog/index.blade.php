@extends('layouts.admin')
@section('header')<h1 class="text-2xl font-semibold">Blog Posts</h1>@endsection
@section('actions')<a href="{{ route('admin.blog.create') }}" class="px-4 py-2 bg-indigo-600 text-white text-sm rounded-md">New Post</a>@endsection
@section('content')
<div class="bg-white rounded-lg shadow overflow-hidden">
<table class="min-w-full"><thead class="bg-gray-50"><tr><th class="px-6 py-3 text-left text-xs uppercase text-gray-500">Title</th><th class="px-6 py-3 text-left text-xs uppercase text-gray-500">Status</th><th class="px-6 py-3"></th></tr></thead>
<tbody class="divide-y">@foreach($posts as $post)<tr><td class="px-6 py-4">{{ $post->title }}</td><td class="px-6 py-4">{{ $post->status }}</td><td class="px-6 py-4 text-right"><a href="{{ route('admin.blog.edit', $post) }}" class="text-indigo-600 text-sm">Edit</a></td></tr>@endforeach</tbody></table>
</div>{{ $posts->links() }}@endsection
