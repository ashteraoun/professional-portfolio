@extends('layouts.admin')
@section('header')<h1 class="text-2xl font-semibold">Testimonials</h1>@endsection
@section('actions')<a href="{{ route('admin.testimonials.create') }}" class="px-4 py-2 bg-indigo-600 text-white text-sm rounded-md">New</a>@endsection
@section('content')
<div class="bg-white rounded-lg shadow divide-y">@foreach($testimonials as $t)<div class="px-6 py-4 flex justify-between"><span>{{ $t->client_name }}</span><a href="{{ route('admin.testimonials.edit', $t) }}" class="text-indigo-600 text-sm">Edit</a></div>@endforeach</div>{{ $testimonials->links() }}@endsection
