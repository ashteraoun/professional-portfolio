@extends('layouts.admin')

@section('header')<h1 class="text-2xl font-semibold">Site Settings</h1>@endsection

@section('content')
<form action="{{ route('admin.settings.update') }}" method="POST" class="bg-white rounded-lg shadow p-6 space-y-4 max-w-2xl">
    @csrf @method('PUT')
    @foreach([
        'site_name' => 'Site Name',
        'site_tagline' => 'Tagline',
        'hero_status' => 'Hero Status',
        'hero_headline' => 'Hero Headline',
        'hero_subheadline' => 'Hero Subheadline',
        'about_intro' => 'About Intro',
        'about_philosophy' => 'About Philosophy',
        'contact_email' => 'Contact Email',
        'footer_statement' => 'Footer Statement',
        'location' => 'Location',
    ] as $key => $label)
        <div>
            <label class="block text-sm font-medium text-gray-700">{{ $label }}</label>
            @if(in_array($key, ['hero_subheadline', 'about_intro', 'about_philosophy']))
                <textarea name="{{ $key }}" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ $settings[$key] ?? '' }}</textarea>
            @else
                <input type="text" name="{{ $key }}" value="{{ $settings[$key] ?? '' }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            @endif
        </div>
    @endforeach
    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md">Save Settings</button>
</form>
@endsection
