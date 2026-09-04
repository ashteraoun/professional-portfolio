@extends('layouts.admin')
@section('header')<h1 class="text-2xl font-semibold">Skills</h1>@endsection
@section('actions')<a href="{{ route('admin.skills.create') }}" class="px-4 py-2 bg-indigo-600 text-white text-sm rounded-md">New Skill</a>@endsection
@section('content')
@foreach($categories as $cat)
<div class="bg-white rounded-lg shadow mb-4 p-6"><h2 class="font-semibold mb-3">{{ $cat->name }}</h2><ul class="space-y-1">@foreach($cat->skills as $skill)<li class="flex justify-between text-sm"><span>{{ $skill->name }}</span><a href="{{ route('admin.skills.edit', $skill) }}" class="text-indigo-600">Edit</a></li>@endforeach</ul></div>
@endforeach@endsection
