@props(['items'])

@if($items->isNotEmpty())
<section class="project-gallery reveal mt-16" data-gallery>
    <div class="mb-8 flex items-end justify-between gap-4">
        <div>
            <p class="label-mono mb-2">Gallery</p>
            <h2 class="font-display text-2xl font-medium">Project visuals</h2>
        </div>
        <p class="text-sm text-muted">{{ $items->count() }} {{ Str::plural('image', $items->count()) }}</p>
    </div>

    <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
        @foreach($items as $i => $item)
            @php $url = \App\Models\Project::storageUrl($item->path); @endphp
            <button
                type="button"
                class="gallery-item group relative overflow-hidden rounded-xl border border-white/10 bg-ink-soft {{ $i === 0 ? 'sm:col-span-2 sm:row-span-2 aspect-[16/10]' : 'aspect-[4/3]' }}"
                data-gallery-index="{{ $i }}"
                data-gallery-src="{{ $url }}"
                data-gallery-alt="{{ $item->alt ?? 'Project image' }}"
            >
                @if($item->type === 'video')
                    <video src="{{ $url }}" class="h-full w-full object-cover" muted loop playsinline></video>
                @else
                    <img src="{{ $url }}" alt="{{ $item->alt }}" class="h-full w-full object-cover transition duration-700 group-hover:scale-105" loading="lazy">
                @endif
                <div class="absolute inset-0 flex items-center justify-center bg-ink/0 transition group-hover:bg-ink/30">
                    <span class="scale-75 rounded-full border border-white/30 bg-ink/50 px-4 py-2 text-xs uppercase tracking-wider opacity-0 backdrop-blur-sm transition group-hover:scale-100 group-hover:opacity-100">View</span>
                </div>
            </button>
        @endforeach
    </div>
</section>

<div id="lightbox" class="lightbox fixed inset-0 z-[200] hidden items-center justify-center" role="dialog" aria-modal="true" aria-label="Image gallery">
    <div class="lightbox-backdrop absolute inset-0 bg-ink/95 backdrop-blur-xl" data-lightbox-close></div>
    <button type="button" class="absolute top-6 right-6 z-10 rounded-full border border-white/20 p-3 text-muted transition hover:border-accent hover:text-accent" data-lightbox-close aria-label="Close gallery">
        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12"/></svg>
    </button>
    <button type="button" class="lightbox-nav absolute left-4 top-1/2 z-10 -translate-y-1/2 rounded-full border border-white/20 p-3 transition hover:border-accent" data-lightbox-prev aria-label="Previous image">
        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 19l-7-7 7-7"/></svg>
    </button>
    <button type="button" class="lightbox-nav absolute right-4 top-1/2 z-10 -translate-y-1/2 rounded-full border border-white/20 p-3 transition hover:border-accent" data-lightbox-next aria-label="Next image">
        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5l7 7-7 7"/></svg>
    </button>
    <figure class="relative z-[1] mx-auto max-h-[85vh] max-w-5xl px-16">
        <img id="lightbox-image" src="" alt="" class="max-h-[85vh] w-auto rounded-xl object-contain shadow-2xl">
        <figcaption id="lightbox-caption" class="mt-4 text-center text-sm text-muted"></figcaption>
    </figure>
</div>
@endif
