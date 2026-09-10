<x-layouts.app :title="$service->name" :description="$service->meta_description ?? $service->short_description">
    <section class="relative overflow-hidden bg-gradient-to-br from-forest-800 to-forest-600 pb-20 pt-40">
        <x-watermark class="pointer-events-none absolute -right-24 -top-24 h-80 w-80 text-forest-500/20" />

        <div class="relative mx-auto max-w-4xl px-6 text-center lg:px-8">
            <a href="{{ route('services.index') }}" data-aos="fade-up" class="inline-flex items-center gap-1.5 text-xs font-semibold uppercase tracking-[0.2em] text-gold-300 hover:text-gold-200">
                &larr; {{ __('Semua Layanan') }}
            </a>
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
