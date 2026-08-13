<x-layouts.app title="{{ __('Filosofi & Core Values') }}" footerWaveColor="text-forest-50">
    <x-page-hero
        kicker="{{ __('Filosofi Atom') }}"
        title="{{ __('Ketajaman Intelijen, Ketepatan Strategi') }}"
        description="{{ __('Empat nilai inti yang menyatukan analisis, lanskap, objektivitas, dan strategi dalam satu kerangka kerja.') }}"
    />

    {{-- Philosophy narrative --}}
    <section class="bg-cream py-24 sm:py-32">
        <div class="mx-auto max-w-3xl px-6 lg:px-8">
            <div class="space-y-6 text-base leading-relaxed text-charcoal/80" data-aos="fade-up">
                <p>{{ __('Atom Visi Indonesia lahir dari keyakinan bahwa keputusan strategis yang benar hanya dapat dihasilkan ketika data, konteks wilayah, dan pembacaan dinamika sosial–politik dipadukan secara presisi. Dalam lanskap politik–ekonomi yang semakin kompleks, ketepatan membaca medan menjadi penentu keunggulan. Karena itu, kami berdiri sebagai firma riset dan intelijen strategis yang menjadikan analisis yang mendalam, pemetaan wilayah yang presisi, serta objektivitas berbasis data sebagai fondasi utama dalam setiap kerja konsultasi.') }}</p>

                <p>{{ __('Filosofi kami berakar pada pendekatan ATOM — sebuah prinsip yang menggambarkan unit kecil dengan dampak besar — yang kami terjemahkan ke dalam empat nilai inti:') }} <span class="font-semibold text-forest-800">{{ __('Analytical Excellence') }}</span>, <span class="font-semibold text-forest-800">{{ __('Topographical Intelligence') }}</span>, <span class="font-semibold text-forest-800">{{ __('Objective Rigor') }}</span>, {{ __('dan') }} <span class="font-semibold text-forest-800">{{ __('Mastery in Strategy') }}</span>. {{ __('Keempatnya membentuk metode kerja yang disiplin, berlapis, dan terukur, sehingga setiap temuan, skenario, maupun rekomendasi yang kami hasilkan tidak hanya informatif, tetapi juga dapat ditindaklanjuti dan berpotensi memenangkan kompetisi strategi.') }}</p>

                <p>{{ __('Kami meyakini bahwa kekuatan analisis tidak berarti tanpa pemahaman lanskap, dan data tidak bernilai tanpa objektivitas. Begitu pula strategi tidak akan efektif tanpa integrasi menyeluruh antara teori, lapangan, dan dinamika kepentingan. Oleh karena itu, kami membangun pendekatan yang menyinergikan seluruh elemen tersebut ke dalam kerangka intelijen yang utuh — kerangka yang mampu menembus lapisan data, mengurai kompleksitas konteks, dan memberi arah yang jelas bagi pengambil keputusan.') }}</p>

                <p>{{ __('Sebagai firma boutique yang menjunjung tinggi kerahasiaan dan integritas, kami berkomitmen memberi layanan yang eksklusif, berstandar tinggi, dan dapat dipercaya. Setiap proyek bagi kami bukan sekadar penyediaan informasi, tetapi misi untuk menghadirkan insight yang presisi dan strategi yang berdampak — sejalan dengan slogan kami:') }}</p>
            </div>

            <blockquote data-aos="fade-up" class="mx-auto mt-10 max-w-xl rounded-2xl border border-forest-100 bg-forest-50/60 px-8 py-6 text-center">
                <p class="font-serif text-xl font-medium italic leading-snug text-forest-800 sm:text-2xl">
                    {{ __('"Wawasan yang Presisi. Strategi yang Berdampak."') }}
                </p>
            </blockquote>

            <p data-aos="fade-up" class="mt-10 text-base leading-relaxed text-charcoal/80">
                {{ __('Filosofi ini menjadi landasan bagaimana kami bekerja, berpikir, dan mendampingi klien: menghadirkan ketajaman intelijen berbasis data, membaca medan dengan akurat, dan merancang strategi yang tidak hanya tepat, tetapi menentukan.') }}
            </p>
        </div>
    </section>

    {{-- CORE VALUES – ATOM --}}
    <section class="bg-forest-50 py-24 sm:py-32">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <x-section-heading kicker="{{ __('Core Values — ATOM') }}" align="center" class="mx-auto">
                <x-slot:title>{{ __('Empat Nilai Inti yang Membentuk Cara Kami Bekerja') }}</x-slot:title>
                <x-slot:description>{{ __('Prinsip ATOM — unit kecil dengan dampak besar — kami terjemahkan menjadi metode kerja yang disiplin, berlapis, dan terukur.') }}</x-slot:description>
            </x-section-heading>

            @php
                $values = [
                    ['letter' => 'A', 'icon' => 'heroicon-o-magnifying-glass', 'title' => __('Analytical Excellence'), 'text' => __('Analisis komprehensif, presisi, dan mendalam.')],
                    ['letter' => 'T', 'icon' => 'heroicon-o-map', 'title' => __('Topographical Intelligence'), 'text' => __('Pemahaman mendetail atas lanskap geografis, sosial, dan politik.')],
                    ['letter' => 'O', 'icon' => 'heroicon-o-scale', 'title' => __('Objective Rigor'), 'text' => __('Kejujuran data dan disiplin metodologi yang tidak bias.')],
                    ['letter' => 'M', 'icon' => 'heroicon-o-briefcase', 'title' => __('Mastery in Strategy'), 'text' => __('Integrasi pengetahuan menjadi strategi yang unggul dan berdaya guna.')],
                ];
            @endphp

            <div class="mt-16 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($values as $index => $value)
                    <div data-aos="fade-up" data-aos-delay="{{ $index * 100 }}"
                         class="group relative overflow-hidden rounded-2xl border border-forest-100 bg-white p-8 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-forest-900/10">
                        <span class="pointer-events-none absolute -right-3 -top-6 select-none font-serif text-8xl font-bold text-forest-50" aria-hidden="true">{{ $value['letter'] }}</span>
                        <div class="relative">
                            <span class="flex h-14 w-14 items-center justify-center rounded-xl bg-forest-50 text-forest-700 transition-colors duration-300 group-hover:bg-forest-700 group-hover:text-gold-400">
                                <x-icon :name="$value['icon']" class="h-7 w-7" />
                            </span>
                            <h3 class="mt-6 font-serif text-xl font-semibold text-forest-800">{{ $value['title'] }}</h3>
                            <p class="mt-3 text-sm leading-relaxed text-charcoal/70">{{ $value['text'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</x-layouts.app>
