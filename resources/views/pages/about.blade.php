<x-layouts.app title="{{ __('Tentang Kami') }}" footerWaveColor="text-forest-50">
    <x-page-hero
        kicker="{{ __('Tentang Kami') }}"
        title="{{ __('Lembaga Riset Independen untuk Indonesia yang Lebih Baik') }}"
        description="{{ __('Atom Visi Indonesia hadir untuk menjembatani riset akademik dengan kebutuhan pengambilan keputusan yang nyata.') }}"
    />

    <section class="bg-cream py-24 sm:py-32">
        <div class="mx-auto grid max-w-7xl grid-cols-1 gap-16 px-6 lg:grid-cols-2 lg:px-8">
            <div data-aos="fade-up">
                <span class="text-xs font-semibold uppercase tracking-[0.25em] text-gold-600">{{ __('Sejarah Singkat') }}</span>
                <h2 class="mt-4 font-serif text-3xl font-semibold text-forest-800">{{ __('Berangkat dari Kebutuhan akan Riset yang Independen') }}</h2>
                <div class="mt-6 space-y-4 text-base leading-relaxed text-charcoal/75">
                    <p>{{ __('Atom Visi Indonesia didirikan oleh sekelompok peneliti dan praktisi kebijakan yang meyakini bahwa keputusan strategis — baik di sektor publik maupun swasta — harus dilandasi oleh riset yang independen, akurat, dan aplikatif.') }}</p>
                    <p>{{ __('Sejak awal berdiri, kami berkomitmen untuk menghadirkan riset kebijakan publik, analisis politik & geopolitik, survey sosial, serta konsultasi strategis yang membantu para pemangku kepentingan memahami lanskap yang terus berubah dengan lebih jernih.') }}</p>
                    <p>{{ __('Kini, Atom Visi Indonesia telah bermitra dengan berbagai kementerian/lembaga, organisasi non-pemerintah, dan sektor swasta dalam menghasilkan riset yang berdampak nyata.') }}</p>
                </div>
            </div>

            <div data-aos="fade-up" data-aos-delay="150" class="relative aspect-[2500/1432] self-center overflow-hidden rounded-2xl bg-gradient-to-br from-forest-600 to-forest-800">
                <img src="{{ asset('images/about-us.jpg') }}" alt="{{ __('Tim Atom Visi Indonesia') }}" class="h-full w-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-forest-900/50 via-transparent to-transparent"></div>
            </div>
        </div>
    </section>

    <section class="bg-forest-50 py-24 sm:py-32">
        <div class="mx-auto max-w-5xl px-6 text-center lg:px-8">
            <x-section-heading kicker="{{ __('Komitmen Kami') }}" align="center" class="mx-auto">
                <x-slot:title>{{ __('Independensi, Ketelitian, dan Dampak') }}</x-slot:title>
                <x-slot:description>{{ __('Tiga prinsip ini menjadi fondasi dari setiap riset dan rekomendasi yang kami hasilkan, memastikan hasil kerja kami dapat dipercaya oleh siapa pun yang menggunakannya.') }}</x-slot:description>
            </x-section-heading>
        </div>
    </section>
</x-layouts.app>
