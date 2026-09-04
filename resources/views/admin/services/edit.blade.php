@extends('layouts.admin')
@section('header')<h1 class="text-2xl font-semibold">Edit Service</h1>@endsection
@section('content')
<form action="{{ route('admin.services.update', $service) }}" method="POST" class="bg-white rounded-lg shadow p-6 space-y-4 max-w-xl">@csrf @method('PUT')
<input name="title" value="{{ $service->title }}" required class="w-full rounded-md border-gray-300">
<textarea name="excerpt" class="w-full rounded-md border-gray-300">{{ $service->excerpt }}</textarea>
<textarea name="description" rows="4" class="w-full rounded-md border-gray-300">{{ $service->description }}</textarea>
<label><input type="checkbox" name="is_published" value="1" @checked($service->is_published)> Published</label>
<button class="px-4 py-2 bg-indigo-600 text-white rounded-md">Update</button></form>@endsection
