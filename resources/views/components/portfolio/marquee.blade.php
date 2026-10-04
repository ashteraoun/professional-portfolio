@props(['items' => []])

<section class="marquee-band relative overflow-hidden border-y border-white/10 py-5 sm:py-6" style="background: var(--gradient-brand-soft);" aria-label="Technologies and expertise">
    <span class="marquee-sweep" aria-hidden="true"></span>
    <div class="marquee-track flex w-max whitespace-nowrap" data-marquee>
        @foreach([false, true] as $isClone)
            <div class="marquee-group flex shrink-0 items-center gap-8 pr-8 sm:gap-12 sm:pr-12" @if($isClone) aria-hidden="true" @endif>
                @foreach($items as $i => $item)
                    <span class="marquee-item flex items-center gap-3 rounded-full border border-white/10 bg-white/[0.035] px-4 py-2 font-mono text-xs font-semibold uppercase tracking-[0.2em] sm:text-sm {{ $i % 2 === 0 ? 'gradient-text' : 'text-muted' }}">
                        {{ $item }} <span class="marquee-star text-base text-fuchsia-400/80" aria-hidden="true">✦</span>
                    </span>
                @endforeach
            </div>
        @endforeach
    </div>
</section>
