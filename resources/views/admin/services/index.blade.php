@extends('layouts.admin')
@section('header')<h1 class="text-2xl font-semibold">Services</h1>@endsection
@section('actions')<a href="{{ route('admin.services.create') }}" class="px-4 py-2 bg-indigo-600 text-white text-sm rounded-md">New</a>@endsection
@section('content')
<div class="bg-white rounded-lg shadow divide-y">@foreach($services as $s)<div class="px-6 py-4 flex justify-between"><span>{{ $s->title }}</span><a href="{{ route('admin.services.edit', $s) }}" class="text-indigo-600 text-sm">Edit</a></div>@endforeach</div>{{ $services->links() }}@endsection
