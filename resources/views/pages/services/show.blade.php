<x-layouts.app :title="$service->name" :description="$service->meta_description ?? $service->short_description">
    <section class="relative overflow-hidden bg-gradient-to-br from-forest-800 to-forest-600 pb-20 pt-40">
        <x-watermark class="pointer-events-none absolute -right-24 -top-24 h-80 w-80 text-forest-500/20" />

        <div class="relative mx-auto max-w-4xl px-6 text-center lg:px-8">
            @if ($service->parent)
                <a href="{{ route('services.show', $service->parent) }}" data-aos="fade-up" class="inline-flex items-center gap-1.5 text-xs font-semibold uppercase tracking-[0.2em] text-gold-300 hover:text-gold-200">
                    &larr; {{ $service->parent->name }}
                </a>
            @else
                <a href="{{ route('services.index') }}" data-aos="fade-up" class="inline-flex items-center gap-1.5 text-xs font-semibold uppercase tracking-[0.2em] text-gold-300 hover:text-gold-200">
                    &larr; {{ __('Semua Layanan') }}
                </a>
            @endif
            <div data-aos="fade-up" data-aos-delay="80" class="mx-auto mt-6 flex h-16 w-16 items-center justify-center rounded-2xl bg-forest-700/60 text-gold-400">
                <x-icon :name="$service->icon ?? 'heroicon-o-briefcase'" class="h-8 w-8" />
            </div>
            <h1 data-aos="fade-up" data-aos-delay="120" class="mt-6 font-sans text-4xl font-semibold leading-tight text-cream sm:text-5xl">
                {{ $service->name }}
            </h1>
            <p data-aos="fade-up" data-aos-delay="200" class="mx-auto mt-5 max-w-2xl text-base leading-relaxed text-forest-100/80">
                {{ $service->short_description }}
            </p>
        </div>
    </section>

    <section class="bg-cream py-24 sm:py-32">
        <div class="mx-auto max-w-3xl px-6 lg:px-8">
            <div data-aos="fade-up" class="prose max-w-none prose-headings:font-sans prose-headings:text-forest-800 prose-a:text-forest-700 prose-strong:text-forest-800">
                {!! $service->description !!}
            </div>

            @if ($service->activeChildren->isNotEmpty())
                <div data-aos="fade-up" data-aos-delay="100" class="mt-12">
                    <h2 class="font-sans text-xl font-semibold text-forest-800">{{ __('Cakupan Layanan') }}</h2>
                    <div class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-2">
                        @foreach ($service->activeChildren as $child)
                            <a href="{{ route('services.show', $child) }}"
                               class="group flex flex-col rounded-2xl border border-forest-100 bg-white p-6 transition-all hover:-translate-y-0.5 hover:border-gold-400 hover:shadow-lg hover:shadow-forest-900/5">
                                <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-forest-50 text-forest-700 transition-colors group-hover:bg-forest-700 group-hover:text-gold-400">
                                    <x-icon :name="$child->icon ?? 'heroicon-o-briefcase'" class="h-6 w-6" />
                                </span>
                                <h3 class="mt-4 font-sans text-base font-semibold text-forest-800">{{ $child->name }}</h3>
                                @if ($child->short_description)
                                    <p class="mt-2 text-sm leading-relaxed text-charcoal/70">{{ $child->short_description }}</p>
                                @endif
                                <span class="mt-4 inline-flex items-center gap-1.5 text-sm font-semibold text-forest-700 transition-colors group-hover:text-gold-600">
                                    {{ __('Pelajari Lebih Lanjut') }}
                                    <svg class="h-4 w-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3" /></svg>
                                </span>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            <div data-aos="fade-up" data-aos-delay="150" class="mt-12 rounded-2xl border border-forest-100 bg-forest-50/60 p-8 text-center">
                <h2 class="font-sans text-xl font-semibold text-forest-800">{{ __('Tertarik dengan Layanan Ini?') }}</h2>
                <p class="mt-2 text-sm text-charcoal/70">{{ __('Hubungi tim kami untuk mendiskusikan kebutuhan riset atau konsultasi strategis Anda.') }}</p>
                <a href="{{ route('contact') }}" class="mt-6 inline-flex rounded-full bg-forest-700 px-7 py-3 text-sm font-semibold text-cream shadow-sm transition-all hover:bg-forest-600">
                    {{ __('Hubungi Kami') }}
                </a>
            </div>
        </div>
    </section>

    @if ($otherServices->isNotEmpty())
        <section class="bg-forest-50/50 py-24">
            <div class="mx-auto max-w-7xl px-6 lg:px-8">
                <x-section-heading kicker="{{ __('Layanan Lainnya') }}" align="center" class="mx-auto">
                    <x-slot:title>{{ __('Jelajahi Layanan Kami yang Lain') }}</x-slot:title>
                </x-section-heading>

                <div class="mt-14 grid grid-cols-1 gap-6 sm:grid-cols-3">
                    @foreach ($otherServices as $other)
                        <x-service-card :service="$other" />
                    @endforeach
                </div>
            </div>
        </section>
    @endif
</x-layouts.app>
