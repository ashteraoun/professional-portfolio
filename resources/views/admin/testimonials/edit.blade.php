@extends('layouts.admin')
@section('header')<h1 class="text-2xl font-semibold">Edit Testimonial</h1>@endsection
@section('content')
<form action="{{ route('admin.testimonials.update', $testimonial) }}" method="POST" class="bg-white rounded-lg shadow p-6 space-y-4 max-w-xl">@csrf @method('PUT')
<input name="client_name" value="{{ $testimonial->client_name }}" required class="w-full rounded-md border-gray-300">
<input name="company" value="{{ $testimonial->company }}" class="w-full rounded-md border-gray-300">
<textarea name="content" required rows="4" class="w-full rounded-md border-gray-300">{{ $testimonial->content }}</textarea>
<label><input type="checkbox" name="is_published" value="1" @checked($testimonial->is_published)> Published</label>
<button class="px-4 py-2 bg-indigo-600 text-white rounded-md">Update</button></form>@endsection
