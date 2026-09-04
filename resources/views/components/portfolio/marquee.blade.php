@props(['items' => []])

<section class="border-y border-white/10 py-6 overflow-hidden" aria-label="Technologies and expertise">
    <div class="marquee-track flex w-max gap-12 whitespace-nowrap" data-marquee>
        @foreach(array_merge($items, $items) as $item)
            <span class="font-mono text-sm uppercase tracking-[0.25em] text-muted">{{ $item }}</span>
        @endforeach
    </div>
</section>
