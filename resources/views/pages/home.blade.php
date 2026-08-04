<x-layouts.app
    description="Atom Visi Indonesia adalah lembaga riset independen di bidang riset kebijakan publik, analisis politik & geopolitik, survey sosial, dan konsultasi strategis. Insight with Precision. Strategy with Impact."
>
    {{-- HERO --}}
    <section class="relative flex min-h-screen items-center overflow-hidden bg-gradient-to-br from-forest-800 via-forest-700 to-forest-600">
        <div
            x-data
            x-init="
                gsap.to($refs.watermark, {
                    yPercent: 15,
                    ease: 'none',
                    scrollTrigger: { trigger: $el, start: 'top top', end: 'bottom top', scrub: true },
                });
            "
            class="pointer-events-none absolute inset-0"
        >
            <x-watermark x-ref="watermark" class="absolute -right-32 -top-24 h-[36rem] w-[36rem] text-forest-500/20 sm:-right-16" />
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_20%_20%,rgba(212,165,61,0.12),transparent_45%)]"></div>
        </div>

        <div class="relative mx-auto grid w-full max-w-7xl grid-cols-1 gap-16 px-6 py-32 lg:grid-cols-12 lg:items-center lg:px-8">
            <div class="lg:col-span-7">
                <span data-aos="fade-up" class="inline-flex items-center gap-2 rounded-full border border-gold-400/30 bg-gold-400/10 px-4 py-1.5 text-xs font-semibold uppercase tracking-[0.2em] text-gold-300">
                    Lembaga Riset Independen
                </span>

                <h1 data-aos="fade-up" data-aos-delay="100" class="mt-6 font-serif text-4xl font-semibold leading-[1.1] text-cream sm:text-5xl lg:text-6xl">
                    Insight with <span class="text-gold-400">Precision</span>.
                    <br>Strategy with <span class="text-gold-400">Impact</span>.
                </h1>

                <p data-aos="fade-up" data-aos-delay="200" class="mt-6 max-w-xl text-lg leading-relaxed text-forest-100/80">
                    Atom Visi Indonesia menghadirkan riset kebijakan publik, analisis politik &amp; geopolitik, survey sosial, serta konsultasi strategis yang membantu para pengambil keputusan bertindak dengan keyakinan.
                </p>

                <div data-aos="fade-up" data-aos-delay="300" class="mt-10 flex flex-wrap items-center gap-4">
                    <a href="{{ route('services.index') }}"
                       class="rounded-full bg-gold-500 px-7 py-3.5 text-sm font-semibold text-forest-900 shadow-lg shadow-gold-500/20 transition-all hover:bg-gold-400 hover:shadow-xl">
                        Lihat Layanan Kami
                    </a>
                    <a href="{{ route('contact') }}"
                       class="rounded-full border border-cream/30 px-7 py-3.5 text-sm font-semibold text-cream transition-all hover:border-gold-400 hover:text-gold-300">
                        Hubungi Kami
                    </a>
                </div>
            </div>

            <div data-aos="fade-up" data-aos-delay="150" class="lg:col-span-5">
                <div class="group relative aspect-video overflow-hidden rounded-2xl border border-cream/10 bg-forest-900/50 shadow-2xl">
                    <div class="absolute inset-0 bg-gradient-to-br from-forest-600/60 to-forest-900/80"></div>
                    <div class="absolute inset-0 flex items-center justify-center">
                        <button type="button" aria-label="Putar video profil perusahaan"
                                class="flex h-16 w-16 items-center justify-center rounded-full bg-gold-500 text-forest-900 shadow-lg transition-transform duration-300 group-hover:scale-110">
                            <svg class="ml-1 h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                        </button>
                    </div>
                    <span class="absolute bottom-4 left-4 text-xs font-medium uppercase tracking-wider text-cream/70">Profil Perusahaan</span>
                </div>
            </div>
        </div>

        <div class="absolute inset-x-0 bottom-8 flex justify-center">
            <svg class="h-6 w-6 animate-bounce text-cream/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 14l-7 7m0 0l-7-7m7 7V3" /></svg>
        </div>
    </section>

    {{-- SERVICES --}}
    <section class="relative bg-cream py-24 sm:py-32">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <x-section-heading kicker="Layanan Kami" align="center" class="mx-auto">
                <x-slot:title>Solusi Riset &amp; Strategi yang Komprehensif</x-slot:title>
                <x-slot:description>Kami menghadirkan enam lini layanan utama untuk mendukung pengambilan keputusan berbasis data dan bukti.</x-slot:description>
            </x-section-heading>

            <div class="mt-16 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($services as $index => $service)
                    <div data-aos="fade-up" data-aos-delay="{{ ($index % 3) * 100 }}">
                        <x-service-card :service="$service" />
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- STATS --}}
    @if ($stats->isNotEmpty())
        <section class="relative overflow-hidden bg-forest-800 py-20">
            <x-watermark class="pointer-events-none absolute -bottom-20 -left-20 h-72 w-72 text-forest-700/40" />
            <div class="relative mx-auto max-w-7xl px-6 lg:px-8">
                <div class="grid grid-cols-2 gap-10 sm:grid-cols-4">
                    @foreach ($stats as $stat)
                        <x-stat-counter :value="$stat->value" :suffix="$stat->suffix" :label="$stat->label" />
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- WHY CHOOSE US --}}
    <section class="bg-cream py-24 sm:py-32">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-16 lg:grid-cols-2 lg:items-start">
                <x-section-heading kicker="Mengapa Memilih Kami">
                    <x-slot:title>Keunggulan yang Membedakan Kami</x-slot:title>
                    <x-slot:description>Komitmen kami pada independensi, ketelitian, dan dampak nyata menjadikan Atom Visi Indonesia mitra riset yang tepercaya.</x-slot:description>
                </x-section-heading>

                <div class="space-y-6">
                    @php
                        $reasons = [
                            ['icon' => 'heroicon-o-shield-check', 'title' => 'Independensi & Objektivitas', 'text' => 'Riset kami bebas dari kepentingan politik atau komersial tertentu, menjaga integritas hasil analisis.'],
                            ['icon' => 'heroicon-o-academic-cap', 'title' => 'Tim Peneliti Berpengalaman', 'text' => 'Didukung oleh peneliti dan analis dengan latar belakang akademik dan praktik yang kuat.'],
                            ['icon' => 'heroicon-o-chart-bar', 'title' => 'Metodologi yang Kredibel', 'text' => 'Menggunakan metode riset kuantitatif dan kualitatif yang teruji dan dapat dipertanggungjawabkan.'],
                            ['icon' => 'heroicon-o-bolt', 'title' => 'Rekomendasi yang Aplikatif', 'text' => 'Hasil riset diterjemahkan menjadi rekomendasi strategis yang siap diimplementasikan.'],
                            ['icon' => 'heroicon-o-clock', 'title' => 'Ketepatan Waktu', 'text' => 'Kami memahami pentingnya timing dalam pengambilan keputusan strategis.'],
                        ];
                    @endphp

                    @foreach ($reasons as $index => $reason)
                        <div data-aos="fade-up" data-aos-delay="{{ $index * 80 }}" class="flex gap-4 rounded-xl border border-transparent p-4 transition-colors hover:border-forest-100 hover:bg-forest-50/60">
                            <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-forest-700 text-gold-400">
                                <x-icon :name="$reason['icon']" class="h-5 w-5" />
                            </span>
                            <div>
                                <h3 class="font-serif text-lg font-semibold text-forest-800">{{ $reason['title'] }}</h3>
                                <p class="mt-1 text-sm leading-relaxed text-charcoal/70">{{ $reason['text'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- LATEST ARTICLES --}}
    @if ($latestArticles->isNotEmpty())
        <section class="bg-forest-50/50 py-24 sm:py-32">
            <div class="mx-auto max-w-7xl px-6 lg:px-8">
                <div class="flex flex-col items-start justify-between gap-6 sm:flex-row sm:items-end">
                    <x-section-heading kicker="Insight Terbaru">
                        <x-slot:title>Artikel &amp; Analisis Terkini</x-slot:title>
                    </x-section-heading>
                    <a href="{{ route('articles.index') }}" data-aos="fade-up" class="shrink-0 text-sm font-semibold text-forest-700 hover:text-gold-600">
                        Lihat Semua Artikel &rarr;
                    </a>
                </div>

                <div class="mt-14 grid grid-cols-1 gap-8 md:grid-cols-3">
                    @foreach ($latestArticles as $index => $article)
                        <a href="{{ route('articles.show', $article) }}" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}"
                           class="group flex flex-col overflow-hidden rounded-2xl border border-forest-100 bg-white transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-forest-900/10">
                            <div class="aspect-[16/10] w-full overflow-hidden bg-forest-100">
                                @if ($article->featured_image)
                                    <img src="{{ asset('storage/'.$article->featured_image) }}" alt="{{ $article->title }}"
                                         loading="lazy" class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105">
                                @else
                                    <div class="flex h-full w-full items-center justify-center bg-gradient-to-br from-forest-600 to-forest-800">
                                        <x-watermark class="h-16 w-16 text-cream/20" />
                                    </div>
                                @endif
                            </div>
                            <div class="flex flex-1 flex-col p-6">
                                @if ($article->category)
                                    <span class="text-xs font-semibold uppercase tracking-wider text-gold-600">{{ $article->category->name }}</span>
                                @endif
                                <h3 class="mt-2 font-serif text-lg font-semibold leading-snug text-forest-800 group-hover:text-forest-600">
                                    {{ $article->title }}
                                </h3>
                                <p class="mt-2 line-clamp-2 flex-1 text-sm text-charcoal/70">{{ $article->excerpt }}</p>
                                <span class="mt-4 text-xs text-charcoal/50">{{ $article->published_at?->translatedFormat('d F Y') }}</span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- TESTIMONIALS --}}
    @if ($testimonials->isNotEmpty())
        <section class="bg-cream py-24 sm:py-32">
            <div class="mx-auto max-w-7xl px-6 lg:px-8">
                <x-section-heading kicker="Kata Mereka" align="center" class="mx-auto">
                    <x-slot:title>Dipercaya oleh Mitra &amp; Klien Kami</x-slot:title>
                </x-section-heading>

                <div class="mt-14 grid grid-cols-1 gap-6 md:grid-cols-3">
                    @foreach ($testimonials as $index => $testimonial)
                        <blockquote data-aos="fade-up" data-aos-delay="{{ $index * 100 }}"
                                    class="flex flex-col rounded-2xl border border-forest-100 bg-white p-8">
                            <svg class="h-8 w-8 text-gold-400" fill="currentColor" viewBox="0 0 32 32"><path d="M9.352 4C4.456 7.456 1 13.12 1 19.36c0 5.088 3.072 8.064 6.624 8.064 3.36 0 5.856-2.688 5.856-5.856 0-3.168-2.208-5.472-5.088-5.472-.576 0-1.344.096-1.536.192.48-3.264 3.552-7.104 6.624-9.024L9.352 4zm17.472 0c-4.8 3.456-8.256 9.12-8.256 15.36 0 5.088 3.072 8.064 6.624 8.064 3.264 0 5.856-2.688 5.856-5.856 0-3.168-2.304-5.472-5.184-5.472-.576 0-1.248.096-1.44.192.48-3.264 3.456-7.104 6.528-9.024L26.824 4z"/></svg>
                            <p class="mt-4 flex-1 text-sm leading-relaxed text-charcoal/80">&ldquo;{{ $testimonial->quote }}&rdquo;</p>
                            <div class="mt-6 flex items-center gap-3">
                                <div class="flex h-11 w-11 items-center justify-center rounded-full bg-forest-100 font-serif text-sm font-semibold text-forest-700">
                                    {{ collect(explode(' ', $testimonial->client_name))->map(fn ($w) => $w[0])->take(2)->implode('') }}
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-forest-800">{{ $testimonial->client_name }}</p>
                                    <p class="text-xs text-charcoal/60">{{ $testimonial->client_role }}@if($testimonial->client_company), {{ $testimonial->client_company }}@endif</p>
                                </div>
                            </div>
                        </blockquote>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- CTA / NEWSLETTER --}}
    <section class="relative overflow-hidden bg-gradient-to-br from-forest-800 to-forest-600 py-24">
        <x-watermark class="pointer-events-none absolute -right-16 -top-16 h-72 w-72 text-forest-500/20" />
        <div class="relative mx-auto max-w-4xl px-6 text-center lg:px-8">
            <x-section-heading kicker="Tetap Terhubung" align="center" light class="mx-auto">
                <x-slot:title>Dapatkan Insight Terbaru dari Kami</x-slot:title>
                <x-slot:description>Berlangganan newsletter kami untuk mendapatkan ringkasan riset, analisis kebijakan, dan undangan diskusi publik langsung ke email Anda.</x-slot:description>
            </x-section-heading>

            <div class="mx-auto mt-8 max-w-md" data-aos="fade-up">
                @livewire('newsletter-subscribe')
            </div>

            <p class="mt-8 text-sm text-forest-100/70">
                Punya kebutuhan riset atau konsultasi strategis?
                <a href="{{ route('contact') }}" class="font-semibold text-gold-300 underline decoration-gold-400/40 underline-offset-4 hover:text-gold-200">Hubungi tim kami &rarr;</a>
            </p>
        </div>
    </section>
</x-layouts.app>
