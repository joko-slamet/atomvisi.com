<x-layouts.app title="{{ __('Layanan') }}">
    <x-page-hero
        kicker="{{ __('Layanan Kami') }}"
        title="{{ __('Solusi Riset & Strategi yang Komprehensif') }}"
        description="{{ __('Enam lini layanan utama yang dirancang untuk mendukung pengambilan keputusan berbasis data di berbagai sektor.') }}"
    />

    <section class="bg-cream py-24 sm:py-32">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($services as $index => $service)
                    <div data-aos="fade-up" data-aos-delay="{{ ($index % 3) * 100 }}" class="flex flex-col gap-3">
                        <x-service-card :service="$service" />
                        @if ($service->activeChildren->isNotEmpty())
                            <div class="rounded-2xl border border-forest-100 bg-white p-4">
                                <span class="text-xs font-semibold uppercase tracking-wider text-forest-400">{{ __('Sub-layanan') }}</span>
                                <ul class="mt-2 divide-y divide-forest-100">
                                    @foreach ($service->activeChildren as $child)
                                        <li>
                                            <a href="{{ route('services.show', $child) }}"
                                               class="group flex items-center justify-between gap-2 py-2.5 text-sm text-charcoal/80 transition-colors hover:text-gold-600">
                                                <span class="flex items-start gap-2">
                                                    <span class="mt-1.5 h-1.5 w-1.5 shrink-0 rounded-full bg-gold-500"></span>
                                                    {{ $child->name }}
                                                </span>
                                                <svg class="h-3.5 w-3.5 shrink-0 transition-transform group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3" />
                                                </svg>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</x-layouts.app>
