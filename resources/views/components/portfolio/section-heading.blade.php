@props(['number' => null, 'label' => null, 'title', 'description' => null, 'align' => 'left'])

<div {{ $attributes->merge(['class' => 'reveal mb-12 md:mb-16 ' . ($align === 'center' ? 'text-center mx-auto max-w-2xl' : 'max-w-2xl')]) }}>
    @if($number || $label)
        <p class="label-mono mb-4 flex items-center gap-2 {{ $align === 'center' ? 'justify-center' : '' }}">
            @if($number)<span class="gradient-number text-sm font-bold">{{ str_pad($number, 2, '0', STR_PAD_LEFT) }}</span> <span class="text-text-subtle">—</span>@endif
            {{ $label }}
        </p>
    @endif
    <h2 class="display-lg gradient-underline mb-6 inline-block">{{ $title }}</h2>
    @if($description)
        <p class="text-lg text-muted leading-relaxed">{{ $description }}</p>
    @endif
</div>
