<x-layouts.app title="Layanan">
    <x-page-hero
        kicker="Layanan Kami"
        title="Solusi Riset &amp; Strategi yang Komprehensif"
        description="Enam lini layanan utama yang dirancang untuk mendukung pengambilan keputusan berbasis data di berbagai sektor."
    />

    <section class="bg-cream py-24 sm:py-32">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($services as $index => $service)
                    <div data-aos="fade-up" data-aos-delay="{{ ($index % 3) * 100 }}">
                        <x-service-card :service="$service" />
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</x-layouts.app>
