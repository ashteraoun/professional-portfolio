@extends('layouts.admin')
@section('header')<h1 class="text-2xl font-semibold">New Service</h1>@endsection
@section('content')
<form action="{{ route('admin.services.store') }}" method="POST" class="bg-white rounded-lg shadow p-6 space-y-4 max-w-xl">@csrf
<input name="title" required placeholder="Title" class="w-full rounded-md border-gray-300">
<textarea name="excerpt" placeholder="Excerpt" class="w-full rounded-md border-gray-300"></textarea>
<label><input type="checkbox" name="is_published" value="1" checked> Published</label>
<button class="px-4 py-2 bg-indigo-600 text-white rounded-md">Create</button></form>@endsection
