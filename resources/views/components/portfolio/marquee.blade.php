@props(['items' => []])

<section class="gradient-divider relative overflow-hidden border-y border-white/10 py-7" style="background: var(--gradient-brand-soft);" aria-label="Technologies and expertise">
    <div class="marquee-track flex w-max gap-12 whitespace-nowrap" data-marquee>
        @foreach(array_merge($items, $items) as $i => $item)
            <span class="flex items-center gap-3 font-mono text-sm uppercase tracking-[0.25em] {{ $i % 2 === 0 ? 'gradient-text font-bold' : 'text-muted' }}">
                {{ $item }} <span class="text-lg text-fuchsia-400/60">✦</span>
            </span>
        @endforeach
    </div>
</section>
