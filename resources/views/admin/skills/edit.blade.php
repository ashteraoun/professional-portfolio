@extends('layouts.admin')
@section('header')<h1 class="text-2xl font-semibold">Edit Skill</h1>@endsection
@section('content')
<form action="{{ route('admin.skills.update', $skill) }}" method="POST" class="bg-white rounded-lg shadow p-6 space-y-4 max-w-xl">@csrf @method('PUT')
<select name="skill_category_id" class="w-full rounded-md border-gray-300">@foreach($categories as $c)<option value="{{ $c->id }}" @selected($skill->skill_category_id===$c->id)>{{ $c->name }}</option>@endforeach</select>
<input name="name" value="{{ $skill->name }}" required class="w-full rounded-md border-gray-300">
<input name="experience_level" value="{{ $skill->experience_level }}" class="w-full rounded-md border-gray-300">
<button class="px-4 py-2 bg-indigo-600 text-white rounded-md">Update</button></form>@endsection
