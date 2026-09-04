@extends('layouts.admin')
@section('header')<h1 class="text-2xl font-semibold">Edit Package</h1>@endsection
@section('content')
<form action="{{ route('admin.packages.update', $package) }}" method="POST" class="bg-white rounded-lg shadow p-6 space-y-4 max-w-xl">@csrf @method('PUT')
<input name="name" value="{{ $package->name }}" required class="w-full rounded-md border-gray-300">
<textarea name="description" class="w-full rounded-md border-gray-300">{{ $package->description }}</textarea>
<input name="price" type="number" step="0.01" value="{{ $package->price }}" class="w-full rounded-md border-gray-300">
<input name="delivery_time" value="{{ $package->delivery_time }}" class="w-full rounded-md border-gray-300">
<button class="px-4 py-2 bg-indigo-600 text-white rounded-md">Update</button></form>@endsection
