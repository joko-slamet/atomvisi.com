<x-layouts.app title="Visi & Misi">
    <x-page-hero
        kicker="Visi &amp; Misi"
        title="Arah yang Menuntun Setiap Langkah Kami"
        description="Fondasi yang membentuk cara kami berpikir, bekerja, dan memberikan dampak bagi setiap mitra."
    />

    {{-- Visi: dark statement panel --}}
    <section class="relative overflow-hidden bg-gradient-to-br from-forest-800 to-forest-900 pt-24 sm:pt-32">
        <div class="pointer-events-none absolute inset-0">
            <div class="absolute inset-0 bg-noise opacity-[0.05] mix-blend-overlay"></div>
            <div class="absolute inset-0 bg-dot-grid text-cream/[0.06]"></div>
            <div class="animate-drift-slow absolute -right-24 top-0 h-96 w-96 rounded-full bg-gold-500/10 blur-3xl"></div>
            <x-watermark class="absolute -bottom-24 -left-24 h-80 w-80 text-forest-600/30" />
        </div>

        <div class="relative mx-auto max-w-4xl px-6 pb-24 text-center sm:pb-32 lg:px-8">
            <span data-aos="fade-up" class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl border border-gold-400/30 bg-gold-400/10 text-gold-300">
                <x-icon name="heroicon-o-flag" class="h-8 w-8" />
            </span>
            <span data-aos="fade-up" data-aos-delay="100" class="mt-6 flex items-center justify-center gap-2 text-xs font-semibold uppercase tracking-[0.25em] text-gold-400">
                <span class="h-px w-6 bg-current"></span>
                Visi
                <span class="h-px w-6 bg-current"></span>
            </span>
            <p data-aos="fade-up" data-aos-delay="200" class="mx-auto mt-6 max-w-3xl font-serif text-2xl font-medium leading-snug text-cream sm:text-3xl lg:text-4xl">
                Menjadi firma riset dan konsultansi strategis terdepan yang menyediakan intelijen politik&ndash;ekonomi berbasis data, pemetaan wilayah, dan analisis mendalam untuk mendukung pengambilan keputusan yang presisi dan berdampak.
            </p>
        </div>

        <svg class="pointer-events-none relative z-10 block h-16 w-full text-cream sm:h-24 lg:h-32" viewBox="0 0 1440 100" preserveAspectRatio="none" fill="currentColor" aria-hidden="true">
            <path d="M0,50 C200,195 900,-75 1440,85 L1440,100 L0,100 Z" />
        </svg>
    </section>

    {{-- Misi: icon cards --}}
    <section class="bg-cream py-24 sm:py-32">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <x-section-heading
                kicker="Misi"
                title="Empat Pilar yang Mengarahkan Kerja Kami"
                description="Langkah konkret yang kami tempuh untuk mewujudkan visi tersebut, dari lapangan hingga meja pengambil keputusan."
                align="center"
                class="mx-auto"
            />

            @php
                $missions = [
                    ['icon' => 'heroicon-o-map', 'title' => 'Pemetaan Strategis', 'text' => 'Menyediakan pemetaan wilayah, aktor, dan dinamika kepentingan secara komprehensif untuk membaca perubahan politik dan ekonomi dengan ketepatan tinggi.'],
                    ['icon' => 'heroicon-o-chart-bar-square', 'title' => 'Analisis Berbasis Data', 'text' => 'Mengelola serta menganalisis data dengan metodologi ilmiah mutakhir sebagai dasar keputusan yang objektif, terukur, dan akuntabel.'],
                    ['icon' => 'heroicon-o-document-chart-bar', 'title' => 'Kajian Strategis', 'text' => 'Mengembangkan kajian strategis yang mengintegrasikan teori, data, dan realitas lapangan guna merumuskan skenario dan rekomendasi yang relevan serta efektif.'],
                    ['icon' => 'heroicon-o-shield-check', 'title' => 'Integritas & Etika', 'text' => 'Menegakkan integritas, kerahasiaan, dan standar etika profesi yang tinggi dalam memberikan layanan konsultasi yang eksklusif dan dapat dipercaya.'],
                ];
            @endphp

            <div class="mt-16 grid grid-cols-1 gap-6 sm:grid-cols-2">
                @foreach ($missions as $index => $mission)
                    <div data-aos="fade-up" data-aos-delay="{{ ($index % 2) * 100 }}"
                         class="group rounded-2xl border border-forest-100 bg-white p-8 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-forest-900/10">
                        <span class="flex h-14 w-14 items-center justify-center rounded-xl bg-forest-50 text-forest-700 transition-colors duration-300 group-hover:bg-forest-700 group-hover:text-gold-400">
                            <x-icon :name="$mission['icon']" class="h-7 w-7" />
                        </span>
                        <h3 class="mt-6 font-serif text-xl font-semibold text-forest-800">{{ $mission['title'] }}</h3>
                        <p class="mt-3 text-sm leading-relaxed text-charcoal/70">{{ $mission['text'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</x-layouts.app>
