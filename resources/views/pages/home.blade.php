<x-layouts.app
    description="Atom Visi Indonesia adalah lembaga riset independen di bidang riset kebijakan publik, analisis politik & geopolitik, survey sosial, dan konsultasi strategis. Insight with Precision. Strategy with Impact."
>
    {{-- HERO --}}
    <section
        x-data="heroSection()"
        class="relative isolate flex min-h-screen flex-col overflow-hidden bg-gradient-to-br from-forest-900 via-forest-800 to-forest-600"
    >
        {{-- Atmosphere: grain, dot-grid, drifting glow orb, parallax watermark --}}
        <div class="pointer-events-none absolute inset-0">
            <div class="absolute inset-0 bg-noise opacity-[0.05] mix-blend-overlay"></div>

            <div data-parallax="12" class="absolute inset-0 bg-dot-grid text-cream/[0.07]"></div>

            <div data-parallax="35" class="animate-drift-slow absolute -left-24 top-1/4 h-[28rem] w-[28rem] rounded-full bg-gold-500/10 blur-3xl"></div>

            <x-watermark
                data-parallax="25"
                class="absolute -right-32 -top-24 h-[36rem] w-[36rem] text-forest-500/20 sm:-right-16"
            />

            <div class="absolute inset-0 bg-[radial-gradient(circle_at_20%_20%,rgba(216,180,65,0.14),transparent_45%)]"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-forest-900 via-transparent to-transparent"></div>
        </div>

        <div class="relative mx-auto grid w-full max-w-7xl flex-1 grid-cols-1 items-center gap-12 px-6 pb-20 pt-40 lg:grid-cols-12 lg:gap-8 lg:px-8">
            <div class="lg:col-span-6">
                <span data-reveal class="inline-flex w-fit items-center gap-2 rounded-full border border-gold-400/30 bg-gold-400/10 px-4 py-1.5 text-xs font-semibold uppercase tracking-[0.2em] text-gold-300 backdrop-blur-sm">
                    <span class="relative flex h-1.5 w-1.5">
                        <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-gold-400 opacity-75"></span>
                        <span class="relative inline-flex h-1.5 w-1.5 rounded-full bg-gold-400"></span>
                    </span>
                    Lembaga Riset Independen
                </span>

                <h1 x-ref="headline" class="relative z-10 mt-6 font-serif text-4xl font-semibold leading-[1.08] text-cream sm:text-5xl lg:text-6xl">
                    <span class="block overflow-hidden pb-1"><span data-line class="block">Insight with Precision.</span></span>
                    <span class="block overflow-hidden pb-1">
                        <span data-line class="block">
                            Strategy with
                            <span class="relative inline-block whitespace-nowrap text-gold-400">
                                Impact.
                                <svg class="absolute -bottom-1 left-0 h-2 w-full text-gold-400 sm:h-2.5" viewBox="0 0 220 12" preserveAspectRatio="none" fill="none" aria-hidden="true">
                                    <path x-ref="underline" d="M2 9.5C40 3 160 2 218 8" stroke="currentColor" stroke-width="3" stroke-linecap="round" />
                                </svg>
                            </span>
                        </span>
                    </span>
                </h1>

                <div data-reveal class="relative z-10 mt-5 h-6 overflow-hidden text-sm font-medium uppercase tracking-[0.15em] text-sage-300">
                    <span class="inline-flex items-center gap-2">
                        Spesialis dalam
                        <span class="relative inline-block overflow-hidden">
                            <span x-ref="rotatingWord" x-text="words[wordIndex]" class="inline-block text-gold-300"></span>
                        </span>
                    </span>
                </div>

                <p data-reveal class="relative z-10 mt-6 max-w-lg text-lg leading-relaxed text-forest-100/80">
                    Atom Visi Indonesia menghadirkan riset kebijakan publik, analisis politik &amp; geopolitik, survey sosial, serta konsultasi strategis yang membantu para pengambil keputusan bertindak dengan keyakinan.
                </p>

                <div data-reveal class="relative z-10 mt-10 flex flex-wrap items-center gap-4">
                    <a href="{{ route('services.index') }}"
                       class="group relative overflow-hidden rounded-full bg-gold-500 px-7 py-3.5 text-sm font-semibold text-forest-900 shadow-lg shadow-gold-500/20 transition-all hover:shadow-xl">
                        <span class="relative z-10">Lihat Layanan Kami</span>
                        <span class="absolute inset-0 -translate-x-full bg-gold-400 transition-transform duration-500 ease-out group-hover:translate-x-0"></span>
                    </a>
                    <a href="{{ route('contact') }}"
                       class="rounded-full border border-cream/30 px-7 py-3.5 text-sm font-semibold text-cream transition-all hover:border-gold-400 hover:text-gold-300">
                        Hubungi Kami
                    </a>
                </div>
            </div>

            <div data-reveal class="relative lg:col-span-6">
                {{-- Floating credibility badges over the image --}}
                @if ($stats->count() >= 1)
                    <div data-parallax="16" class="animate-float absolute -left-4 top-6 z-20 hidden items-center gap-3 rounded-2xl bg-cream px-5 py-3 shadow-xl sm:flex lg:-left-10">
                        <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-forest-700/10 text-forest-700">
                            <x-icon :name="$stats->get(2)->icon ?? 'heroicon-o-calendar-days'" class="h-4 w-4" />
                        </span>
                        <div class="leading-tight">
                            <p class="font-serif text-lg font-semibold text-forest-800">{{ $stats->get(2)->value ?? $stats->first()->value }}{{ $stats->get(2)->suffix ?? $stats->first()->suffix }}</p>
                            <p class="text-[0.65rem] uppercase tracking-wide text-charcoal/50">{{ $stats->get(2)->label ?? $stats->first()->label }}</p>
                        </div>
                    </div>
                @endif

                @if ($stats->count() >= 2)
                    <div data-parallax="22" class="animate-float-delayed absolute -right-4 top-1/3 z-20 hidden items-center gap-3 rounded-2xl bg-forest-900 px-5 py-3 shadow-xl ring-1 ring-cream/10 sm:flex lg:-right-8">
                        <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-gold-500/15 text-gold-400">
                            <x-icon :name="$stats->get(1)->icon ?? 'heroicon-o-users'" class="h-4 w-4" />
                        </span>
                        <div class="leading-tight">
                            <p class="font-serif text-lg font-semibold text-cream">{{ $stats->get(1)->value }}{{ $stats->get(1)->suffix }}</p>
                            <p class="text-[0.65rem] uppercase tracking-wide text-forest-100/60">{{ $stats->get(1)->label }}</p>
                        </div>
                    </div>
                @endif

                @if ($stats->count() >= 1)
                    <div data-parallax="18" class="animate-float absolute -bottom-6 right-6 z-20 hidden items-center gap-3 rounded-2xl bg-cream px-5 py-3 shadow-xl sm:flex lg:right-10">
                        <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-forest-700/10 text-forest-700">
                            <x-icon :name="$stats->first()->icon ?? 'heroicon-o-magnifying-glass'" class="h-4 w-4" />
                        </span>
                        <div class="leading-tight">
                            <p class="font-serif text-lg font-semibold text-forest-800">{{ $stats->first()->value }}{{ $stats->first()->suffix }}</p>
                            <p class="text-[0.65rem] uppercase tracking-wide text-charcoal/50">{{ $stats->first()->label }}</p>
                        </div>
                    </div>
                @endif

                <div x-data="tiltCard()"
                     class="group relative aspect-[4/5] w-full overflow-hidden rounded-[63%_37%_54%_46%/45%_39%_61%_55%] border border-cream/10 shadow-2xl sm:aspect-[5/6]">
                    <img src="{{ asset('images/hero.jpg') }}" alt="Pusat riset dan analisis Atom Visi Indonesia" class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-105">
                    <div class="absolute inset-0 bg-gradient-to-t from-forest-900/50 via-transparent to-transparent"></div>
                </div>
            </div>
        </div>

        {{-- Curved divider into the next section --}}
        <svg class="pointer-events-none relative z-10 block h-16 w-full text-cream sm:h-24 lg:h-32" viewBox="0 0 1440 100" preserveAspectRatio="none" fill="currentColor" aria-hidden="true">
            <path d="M0,50 C200,195 900,-75 1440,85 L1440,100 L0,100 Z" />
        </svg>
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
