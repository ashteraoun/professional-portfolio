@extends('layouts.admin')

@section('header')<h1 class="text-2xl font-semibold">Edit Project</h1>@endsection

@section('content')
<form action="{{ route('admin.projects.update', $project) }}" method="POST" class="bg-white rounded-lg shadow p-6 space-y-4 max-w-2xl">
    @csrf @method('PUT')
    @include('admin.projects._form', ['project' => $project])
    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md">Update</button>
</form>
@endsection
