@extends('layouts.admin')

@section('header')<h1 class="text-2xl font-semibold">Messages</h1>@endsection

@section('content')
<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50"><tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">From</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
        </tr></thead>
        <tbody class="divide-y">
            @foreach($messages as $message)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4"><a href="{{ route('admin.messages.show', $message) }}" class="text-indigo-600">{{ $message->name }}</a><div class="text-sm text-gray-500">{{ $message->email }}</div></td>
                    <td class="px-6 py-4 text-sm">{{ $message->project_type ?? '—' }}</td>
                    <td class="px-6 py-4 text-sm">{{ $message->status }}</td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $message->created_at->format('M d, Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $messages->links() }}</div>
@endsection
