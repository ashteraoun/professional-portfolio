@extends('layouts.admin')
@section('header')<h1 class="text-2xl font-semibold">New Experience</h1>@endsection
@section('content')
<form action="{{ route('admin.experience.store') }}" method="POST" class="bg-white rounded-lg shadow p-6 space-y-4 max-w-xl">@csrf
<input name="company" required placeholder="Company" class="w-full rounded-md border-gray-300">
<input name="role" required placeholder="Role" class="w-full rounded-md border-gray-300">
<input name="started_at" type="date" required class="w-full rounded-md border-gray-300">
<input name="ended_at" type="date" class="w-full rounded-md border-gray-300">
<textarea name="description" class="w-full rounded-md border-gray-300"></textarea>
<label><input type="checkbox" name="is_current" value="1"> Current</label>
<label><input type="checkbox" name="is_published" value="1" checked> Published</label>
<button class="px-4 py-2 bg-indigo-600 text-white rounded-md">Create</button></form>@endsection
