@extends('layouts.admin')

@section('header')<h1 class="text-2xl font-semibold">Message from {{ $message->name }}</h1>@endsection

@section('content')
<div class="bg-white rounded-lg shadow p-6 max-w-2xl space-y-4">
    <p><strong>Email:</strong> {{ $message->email }}</p>
    @if($message->company)<p><strong>Company:</strong> {{ $message->company }}</p>@endif
    @if($message->project_type)<p><strong>Project Type:</strong> {{ $message->project_type }}</p>@endif
    @if($message->budget_range)<p><strong>Budget:</strong> {{ $message->budget_range }}</p>@endif
    @if($message->timeline)<p><strong>Timeline:</strong> {{ $message->timeline }}</p>@endif
    <div><strong>Message:</strong><p class="mt-2 text-gray-700 whitespace-pre-wrap">{{ $message->message }}</p></div>
    <form action="{{ route('admin.messages.update', $message) }}" method="POST" class="flex gap-2 pt-4">@csrf @method('PUT')
        <select name="status" class="rounded-md border-gray-300 text-sm">
            @foreach(['unread','read','archived'] as $s)<option value="{{ $s }}" @selected($message->status === $s)>{{ ucfirst($s) }}</option>@endforeach
        </select>
        <button class="px-3 py-1 bg-indigo-600 text-white text-sm rounded-md">Update</button>
    </form>
</div>
@endsection
