<x-layouts.app title="Core Values">
    <x-page-hero
        kicker="Core Values"
        title="Nilai-Nilai yang Memandu Setiap Riset Kami"
        description="Nilai-nilai ini menjadi kompas bagi seluruh tim Atom Visi Indonesia dalam menjalankan setiap proyek riset dan konsultasi."
    />

    <section class="bg-cream py-24 sm:py-32">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            @php
                $values = [
                    ['icon' => 'heroicon-o-shield-check', 'title' => 'Integritas', 'text' => 'Kami menjunjung tinggi kejujuran dan objektivitas dalam setiap tahap riset, tanpa kompromi terhadap kepentingan pihak manapun.'],
                    ['icon' => 'heroicon-o-magnifying-glass', 'title' => 'Ketelitian', 'text' => 'Setiap data dan temuan diverifikasi secara cermat menggunakan metodologi yang teruji dan dapat dipertanggungjawabkan.'],
                    ['icon' => 'heroicon-o-light-bulb', 'title' => 'Inovasi', 'text' => 'Kami terus mengembangkan pendekatan riset yang relevan dengan dinamika kebijakan dan teknologi terkini.'],
                    ['icon' => 'heroicon-o-users', 'title' => 'Kolaborasi', 'text' => 'Kami percaya dampak terbesar lahir dari kerja sama lintas sektor — akademisi, pemerintah, dan masyarakat sipil.'],
                    ['icon' => 'heroicon-o-scale', 'title' => 'Independensi', 'text' => 'Rekomendasi kami murni berdasarkan bukti dan analisis, bebas dari tekanan politik maupun komersial.'],
                    ['icon' => 'heroicon-o-bolt', 'title' => 'Dampak Nyata', 'text' => 'Kami mengukur keberhasilan riset dari sejauh mana ia diterjemahkan menjadi kebijakan dan program yang bermanfaat.'],
                ];
            @endphp

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($values as $index => $value)
                    <div data-aos="fade-up" data-aos-delay="{{ ($index % 3) * 100 }}"
                         class="group rounded-2xl border border-forest-100 bg-white p-8 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-forest-900/10">
                        <span class="flex h-14 w-14 items-center justify-center rounded-xl bg-forest-50 text-forest-700 transition-colors duration-300 group-hover:bg-forest-700 group-hover:text-gold-400">
                            <x-icon :name="$value['icon']" class="h-7 w-7" />
                        </span>
                        <h3 class="mt-6 font-serif text-xl font-semibold text-forest-800">{{ $value['title'] }}</h3>
                        <p class="mt-3 text-sm leading-relaxed text-charcoal/70">{{ $value['text'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</x-layouts.app>
