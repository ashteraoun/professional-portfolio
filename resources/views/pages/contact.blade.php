@extends('layouts.portfolio')

@section('content')
    <section class="section-padding pt-32">
        <div class="container-site">
            <div class="grid gap-16 lg:grid-cols-2">
                <div class="reveal">
                    <x-portfolio.section-heading
                        label="Contact"
                        title="What are you building?"
                        description="Tell me about your project. I typically respond within 1–2 business days."
                        class="mb-8"
                    />
                    <dl class="space-y-4 text-sm">
                        @if(!empty($site['contact_email']))
                            <div><dt class="label-mono mb-1">Email</dt><dd><a href="mailto:{{ $site['contact_email'] }}" class="text-accent">{{ $site['contact_email'] }}</a></dd></div>
                        @endif
                        <div><dt class="label-mono mb-1">Availability</dt><dd class="text-muted">{{ $site['hero_status'] ?? '' }}</dd></div>
                    </dl>
                </div>

                <form action="{{ route('contact.store') }}" method="POST" enctype="multipart/form-data" class="reveal surface-card p-6 md:p-8 space-y-5" id="contact-form">
                    @csrf

                    @if(session('success'))
                        <div class="rounded-lg border border-green-500/30 bg-green-500/10 px-4 py-3 text-sm text-green-400" role="status">{{ session('success') }}</div>
                    @endif

                    <div>
                        <label for="project_type" class="label-mono mb-2 block">Project Type</label>
                        <select name="project_type" id="project_type" class="w-full rounded-lg border border-white/10 bg-transparent px-4 py-3 text-sm outline-none focus:border-accent">
                            <option value="">Select type...</option>
                            @foreach(['Website', 'SaaS', 'AI Product', 'E-commerce', 'API', 'Other'] as $type)
                                <option value="{{ $type }}" @selected(old('project_type') === $type)>{{ $type }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid gap-5 sm:grid-cols-2">
                        <div>
                            <label for="name" class="label-mono mb-2 block">Name *</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required class="w-full rounded-lg border border-white/10 bg-transparent px-4 py-3 text-sm outline-none focus:border-accent">
                            @error('name')<p class="mt-1 text-xs text-red-400">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="email" class="label-mono mb-2 block">Email *</label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" required class="w-full rounded-lg border border-white/10 bg-transparent px-4 py-3 text-sm outline-none focus:border-accent">
                            @error('email')<p class="mt-1 text-xs text-red-400">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div>
                        <label for="company" class="label-mono mb-2 block">Company</label>
                        <input type="text" name="company" id="company" value="{{ old('company') }}" class="w-full rounded-lg border border-white/10 bg-transparent px-4 py-3 text-sm outline-none focus:border-accent">
                    </div>

                    <div class="grid gap-5 sm:grid-cols-2">
                        <div>
                            <label for="budget_range" class="label-mono mb-2 block">Budget Range</label>
                            <select name="budget_range" id="budget_range" class="w-full rounded-lg border border-white/10 bg-transparent px-4 py-3 text-sm outline-none focus:border-accent">
                                <option value="">Select...</option>
                                @foreach(['< $5k', '$5k – $10k', '$10k – $25k', '$25k+'] as $budget)
                                    <option value="{{ $budget }}" @selected(old('budget_range') === $budget)>{{ $budget }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="timeline" class="label-mono mb-2 block">Timeline</label>
                            <select name="timeline" id="timeline" class="w-full rounded-lg border border-white/10 bg-transparent px-4 py-3 text-sm outline-none focus:border-accent">
                                <option value="">Select...</option>
                                @foreach(['ASAP', '1–2 months', '3–6 months', 'Flexible'] as $time)
                                    <option value="{{ $time }}" @selected(old('timeline') === $time)>{{ $time }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div>
                        <label for="message" class="label-mono mb-2 block">Message *</label>
                        <textarea name="message" id="message" rows="5" required class="w-full rounded-lg border border-white/10 bg-transparent px-4 py-3 text-sm outline-none focus:border-accent resize-y">{{ old('message') }}</textarea>
                        @error('message')<p class="mt-1 text-xs text-red-400">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="attachment" class="label-mono mb-2 block">Attachment (optional, max 5MB)</label>
                        <input type="file" name="attachment" id="attachment" accept=".pdf,.doc,.docx,.txt,.png,.jpg,.jpeg" class="w-full text-sm text-muted file:mr-4 file:rounded-full file:border-0 file:bg-accent file:px-4 file:py-2 file:text-ink">
                        @error('attachment')<p class="mt-1 text-xs text-red-400">{{ $message }}</p>@enderror
                    </div>

                    <button type="submit" class="btn-primary w-full sm:w-auto">Send Message</button>
                </form>
            </div>
        </div>
    </section>
@endsection
