@php
    $services = \App\Models\Service::published()
        ->orderBy('sort_order')
        ->get()
        ->map(function ($service) {
            $iconMap = [
                'full-stack-development' => [
                    'icon' => 'M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9',
                    'color' => 'from-blue-500 to-cyan-500'
                ],
                'saas-development' => [
                    'icon' => 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10',
                    'color' => 'from-indigo-500 to-blue-500'
                ],
                'ai-integration' => [
                    'icon' => 'M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z',
                    'color' => 'from-yellow-500 to-orange-500'
                ],
                'api-backend' => [
                    'icon' => 'M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4',
                    'color' => 'from-green-500 to-emerald-500'
                ],
                'ui-ux' => [
                    'icon' => 'M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01',
                    'color' => 'from-purple-500 to-pink-500'
                ],
                'performance' => [
                    'icon' => 'M13 10V3L4 14h7v7l9-11h-7z',
                    'color' => 'from-orange-500 to-red-500'
                ],
            ];

            $defaultIcon = [
                'icon' => 'M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4',
                'color' => 'from-gray-500 to-gray-600'
            ];

            $iconData = $iconMap[$service->slug] ?? $defaultIcon;

            return [
                'title' => $service->title,
                'description' => $service->excerpt ?? 'Professional service tailored to your needs',
                'icon' => $iconData['icon'],
                'slug' => $service->slug,
                'color' => $iconData['color']
            ];
        })
        ->toArray();
@endphp

<div class="services-dropdown group relative">
    <button type="button" 
            class="flex items-center gap-1 rounded-full px-3 py-2 text-sm text-muted transition hover:text-accent"
            aria-expanded="false"
            aria-haspopup="true">
        <span>Services</span>
        <svg class="services-dropdown-arrow h-4 w-4 transition-transform duration-300 group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
        </svg>
    </button>

    <div class="services-dropdown-menu absolute left-1/2 top-full -translate-x-1/2 pt-4 opacity-0 invisible transition-all duration-300 group-hover:opacity-100 group-hover:visible">
        <div class="w-[600px] max-w-[calc(100vw-2rem)] overflow-hidden rounded-2xl border border-white/10 bg-surface/95 backdrop-blur-xl shadow-2xl shadow-black/50">
            <div class="grid grid-cols-2 gap-px bg-white/5">
                @foreach($services as $service)
                    <a href="{{ route('services.show', $service['slug']) }}" 
                       class="service-dropdown-item group relative flex items-start gap-4 bg-surface p-5 transition-all duration-300 hover:bg-surface-elevated">
                        {{-- Icon --}}
                        <div class="flex shrink-0 items-center justify-center">
                            <div class="relative flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br {{ $service['color'] }} opacity-80 group-hover:opacity-100 transition-opacity">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $service['icon'] }}"/>
                                </svg>
                            </div>
                        </div>

                        {{-- Content --}}
                        <div class="min-w-0 flex-1">
                            <h3 class="font-display text-sm font-medium text-text group-hover:text-accent transition-colors">
                                {{ $service['title'] }}
                            </h3>
                            <p class="mt-1 text-xs text-muted line-clamp-2">
                                {{ $service['description'] }}
                            </p>
                        </div>

                        {{-- Arrow --}}
                        <div class="flex shrink-0 items-center">
                            <svg class="h-4 w-4 text-muted opacity-0 -translate-x-2 transition-all duration-300 group-hover:opacity-100 group-hover:translate-x-0 group-hover:text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>

                        {{-- Hover gradient overlay --}}
                        <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/[0.02] to-transparent opacity-0 transition-opacity duration-300 group-hover:opacity-100"></div>
                    </a>
                @endforeach
            </div>

            {{-- Footer --}}
            <div class="flex items-center justify-between border-t border-white/10 bg-surface-elevated/50 px-5 py-3">
                <span class="text-xs text-muted">Explore all services</span>
                <a href="{{ route('services.index') }}" class="flex items-center gap-1 text-xs font-medium text-accent hover:gap-2 transition-all">
                    View All
                    <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</div>
