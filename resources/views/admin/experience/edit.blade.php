@extends('layouts.admin')
@section('header')<h1 class="text-2xl font-semibold">Edit Experience</h1>@endsection
@section('content')
<form action="{{ route('admin.experience.update', $experience) }}" method="POST" class="bg-white rounded-lg shadow p-6 space-y-4 max-w-xl">@csrf @method('PUT')
<input name="company" value="{{ $experience->company }}" required class="w-full rounded-md border-gray-300">
<input name="role" value="{{ $experience->role }}" required class="w-full rounded-md border-gray-300">
<input name="started_at" type="date" value="{{ $experience->started_at->format('Y-m-d') }}" required class="w-full rounded-md border-gray-300">
<input name="ended_at" type="date" value="{{ $experience->ended_at?->format('Y-m-d') }}" class="w-full rounded-md border-gray-300">
<textarea name="description" class="w-full rounded-md border-gray-300">{{ $experience->description }}</textarea>
<label><input type="checkbox" name="is_current" value="1" @checked($experience->is_current)> Current</label>
<label><input type="checkbox" name="is_published" value="1" @checked($experience->is_published)> Published</label>
<button class="px-4 py-2 bg-indigo-600 text-white rounded-md">Update</button></form>@endsection
