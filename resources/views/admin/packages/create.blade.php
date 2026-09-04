@extends('layouts.admin')
@section('header')<h1 class="text-2xl font-semibold">New Package</h1>@endsection
@section('content')
<form action="{{ route('admin.packages.store') }}" method="POST" class="bg-white rounded-lg shadow p-6 space-y-4 max-w-xl">@csrf
<input name="name" required placeholder="Name" class="w-full rounded-md border-gray-300">
<textarea name="description" class="w-full rounded-md border-gray-300"></textarea>
<input name="price" type="number" step="0.01" placeholder="Price" class="w-full rounded-md border-gray-300">
<input name="delivery_time" placeholder="Delivery time" class="w-full rounded-md border-gray-300">
<button class="px-4 py-2 bg-indigo-600 text-white rounded-md">Create</button></form>@endsection
