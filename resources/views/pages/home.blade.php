<x-layouts.app
    :description="__('Atom Visi Indonesia adalah lembaga riset independen di bidang riset kebijakan publik, analisis politik & geopolitik, survey sosial, dan konsultasi strategis. Insight with Precision. Strategy with Impact.')"
>
    {{-- HERO + SERVICES --}}
    <section
        id="hero"
        x-data="heroSection({{ Illuminate\Support\Js::from([
            __('Riset Kebijakan Publik'),
            __('Analisis Politik & Geopolitik'),
            __('Survey & Kajian Sosial'),
            __('Strategi & Konsultasi'),
        ]) }})"
        class="relative isolate z-10 bg-cream"
    >
        {{-- Shared atmosphere across hero + services: grain, dot-grid, parallax watermarks --}}
        <div class="pointer-events-none absolute inset-0 overflow-hidden">
            <div class="absolute inset-0 bg-noise opacity-[0.05] mix-blend-multiply"></div>
            <div class="absolute inset-0 bg-dot-grid text-forest-900/[0.06]"></div>
            <x-watermark
                data-parallax="25"
                class="absolute -right-32 -top-24 h-[36rem] w-[36rem] text-forest-500/10 sm:-right-16"
            />
            <x-watermark class="absolute -left-40 top-[65%] h-[34rem] w-[34rem] -translate-y-1/2 text-forest-900/[0.03]" />
        </div>

        {{-- Hero content --}}
        <div class="relative mx-auto flex w-full max-w-4xl flex-col items-center gap-2 px-6 pt-40 text-center lg:px-8">
            <h1 x-ref="headline" class="relative z-10 font-serif text-4xl font-semibold leading-[1.08] text-forest-900 sm:text-5xl lg:text-6xl">
                <span class="block overflow-hidden pb-1"><span data-line class="block">{{ __('Insight with Precision.') }}</span></span>
                <span class="block overflow-hidden pb-1">
                    <span data-line class="block">
                        {{ __('Strategy with') }}
                        <span class="relative inline-block whitespace-nowrap text-gold-600">
                            {{ __('Impact.') }}
                            <svg class="absolute -bottom-1 left-0 h-2 w-full text-gold-600 sm:h-2.5" viewBox="0 0 220 12" preserveAspectRatio="none" fill="none" aria-hidden="true">
                                <path x-ref="underline" d="M2 9.5C40 3 160 2 218 8" stroke="currentColor" stroke-width="3" stroke-linecap="round" />
                            </svg>
                        </span>
                    </span>
                </span>
            </h1>

            <div data-reveal class="relative z-10 mt-5 h-6 overflow-hidden text-sm font-medium uppercase tracking-[0.15em] text-forest-600">
                <span class="inline-flex items-center gap-2">
                    {{ __('Spesialis dalam') }}
                    <span class="relative inline-block overflow-hidden">
                        <span x-ref="rotatingWord" x-text="words[wordIndex]" class="inline-block text-gold-600"></span>
                    </span>
                </span>
            </div>

        </div>

        {{-- Services content --}}
        <div class="relative pb-12 sm:pb-16">
            <div class="relative mx-auto max-w-7xl px-6 lg:px-8">
                @php
                $serviceSubItems = [
                    'strategy-private-class' => [
                        __('Analisis Politik & Geopolitik'),
                        __('Kajian Strategis & Rekomendasi Program'),
                    ],
                    'survey-data-analyses' => [
                        __('Riset Kebijakan Publik'),
                        __('Survey & Kajian Sosial Strategis'),
                        __('Kajian Strategis & Rekomendasi Program'),
                    ],
                ];
            @endphp

            @if ($services->isNotEmpty())
                <div x-data="serviceShowcase({{ $services->count() }})" @mouseenter="paused = true" @mouseleave="paused = false">

                    {{-- ORBIT (desktop) --}}
                    <div x-data="tiltCard()" class="relative mx-auto mt-40 hidden aspect-square w-full max-w-xl lg:block">
                        {{-- decorative orbit rings, each carrying a small satellite dot --}}
                        <div class="animate-orbit-slow absolute inset-[6%] rounded-full border border-dashed border-forest-200/70">
                            <span class="absolute -top-1 left-1/2 h-2 w-2 -translate-x-1/2 rounded-full bg-forest-300 shadow-sm"></span>
                        </div>
                        <div class="animate-orbit-slow-reverse absolute inset-[20%] rounded-full border border-dashed border-gold-300/70">
                            <span class="absolute -top-1 left-1/2 h-1.5 w-1.5 -translate-x-1/2 rounded-full bg-gold-400 shadow-sm"></span>
                        </div>

                        {{-- spokes + nodes + per-node cards --}}
                        @foreach ($services as $index => $service)
                            @php
                                $step = 360 / $services->count();
                                $angleDeg = -90 + ($step / 2) + $index * $step;
                                $angleRad = deg2rad($angleDeg);
                                $nodeX = 50 + 42 * cos($angleRad);
                                $nodeY = 50 + 42 * sin($angleRad);
                                $isRight = cos($angleRad) >= 0;
                                $isBottom = sin($angleRad) >= 0.15;
                                $isTop = sin($angleRad) <= -0.15;
                            @endphp

                            <div class="absolute left-1/2 top-1/2 h-px origin-left bg-gradient-to-r from-forest-300 to-forest-100/0"
                                 style="width: 42%; transform: rotate({{ $angleDeg }}deg);"></div>

                            <button type="button" @click="select({{ $index }})" @mouseenter="select({{ $index }})"
                                    data-aos="zoom-in" data-aos-delay="{{ $index * 80 }}"
                                    class="absolute z-10 flex h-16 w-16 -translate-x-1/2 -translate-y-1/2 items-center justify-center rounded-full border-2 bg-white shadow-lg transition-all duration-300"
                                    :class="active === {{ $index }} ? 'border-gold-500 scale-110 shadow-gold-500/30' : 'border-forest-100 hover:border-forest-300 hover:scale-105'"
                                    style="left: {{ $nodeX }}%; top: {{ $nodeY }}%;">
                                <span x-show="active === {{ $index }}" class="animate-ping absolute inset-0 rounded-full bg-gold-400/40"></span>
                                <span class="relative" :class="active === {{ $index }} ? 'text-gold-600' : 'text-forest-700'">
                                    <x-icon :name="$service->icon ?? 'heroicon-o-briefcase'" class="h-6 w-6" />
                                </span>
                            </button>

                            {{-- Floating card(s) anchored to this node --}}
                            @php $subItems = $serviceSubItems[$service->slug] ?? []; @endphp
                            <div class="absolute w-56 text-left transition-all duration-300"
                                 :class="active === {{ $index }} ? 'z-50 scale-100 opacity-100' : 'z-10 scale-95 opacity-60'"
                                 style="
                                     {{ $isRight ? 'left: calc(' . $nodeX . '% + 2.25rem);' : 'right: calc(' . (100 - $nodeX) . '% + 2.25rem);' }}
                                     {{ $isBottom ? 'top: calc(' . $nodeY . '% - 0.5rem);' : ($isTop ? 'bottom: calc(' . (100 - $nodeY) . '% - 0.5rem);' : 'top: calc(' . $nodeY . '% - 4.5rem);') }}
                                 ">
                                {{-- Main service card --}}
                                <div class="rounded-2xl border-2 bg-white p-4 shadow-2xl transition-colors duration-300"
                                     :class="active === {{ $index }} ? 'border-gold-500 shadow-gold-500/20 ring-4 ring-gold-400/20' : 'border-forest-100 shadow-forest-900/10'">
                                    <span class="text-xs font-semibold uppercase tracking-wider transition-colors duration-300"
                                          :class="active === {{ $index }} ? 'text-gold-600' : 'text-forest-400'">
                                        {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                                    </span>
                                    <h3 class="mt-1 font-serif text-lg font-semibold leading-snug text-forest-800">
                                        {{ $service->name }}
                                    </h3>
                                    @if (empty($subItems))
                                        <p class="mt-2 text-sm leading-relaxed text-charcoal/70">
                                            {{ $service->short_description }}
                                        </p>
                                        <a href="{{ route('services.show', $service) }}"
                                           class="group mt-3 inline-flex items-center gap-1.5 text-sm font-semibold text-forest-700 transition-colors hover:text-gold-600">
                                            {{ __('Pelajari Lebih Lanjut') }}
                                            <svg class="h-3.5 w-3.5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3" />
                                            </svg>
                                        </a>
                                    @endif
                                </div>

                                {{-- Sub-item cards --}}
                                @if (! empty($subItems))
                                    <div class="mt-2 space-y-2">
                                        @foreach ($subItems as $subItem)
                                            <div class="rounded-xl border border-forest-100 bg-white p-3 shadow-lg shadow-forest-900/5">
                                                <div class="flex items-start gap-2">
                                                    <span class="mt-1 h-1.5 w-1.5 shrink-0 rounded-full bg-gold-500"></span>
                                                    <span class="text-sm leading-snug text-charcoal/80">{{ $subItem }}</span>
                                                </div>
                                                <a href="{{ route('services.show', $service) }}"
                                                   class="group mt-2 inline-flex items-center gap-1 pl-3.5 text-xs font-semibold text-forest-700 transition-colors hover:text-gold-600">
                                                    {{ __('Pelajari Lebih Lanjut') }}
                                                    <svg class="h-3 w-3 transition-transform group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3" />
                                                    </svg>
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @endforeach

                        {{-- nucleus --}}
                        <div class="absolute left-1/2 top-1/2 z-20 flex h-28 w-28 -translate-x-1/2 -translate-y-1/2 items-center justify-center rounded-full bg-forest-700 shadow-2xl shadow-forest-900/30 ring-4 ring-cream">
                            <span class="absolute -inset-4 -z-10 rounded-full bg-gold-400/10 blur-2xl"></span>
                            <span class="animate-glow-pulse absolute inset-0 rounded-full bg-gold-400/20"></span>

                            {{-- Autoplay progress ring --}}
                            <svg class="pointer-events-none absolute left-1/2 top-1/2 z-0 h-36 w-36 -translate-x-1/2 -translate-y-1/2 -rotate-90" viewBox="0 0 100 100" aria-hidden="true">
                                <circle cx="50" cy="50" r="47" fill="none" stroke="currentColor" stroke-width="2" class="text-cream/60" />
                                <circle cx="50" cy="50" r="47" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                                        class="text-gold-400" stroke-dasharray="295.3"
                                        :stroke-dashoffset="295.3 - (295.3 * progress) / 100" />
                            </svg>

                            <img src="{{ asset('images/logo-icon.png') }}" alt="Atom Visi Indonesia" class="relative h-16 w-auto">
                        </div>
                    </div>

                    {{-- Progress dots (desktop, indicates autoplay + lets you jump) --}}
                    <div class="mt-8 hidden items-center justify-center gap-2 lg:flex">
                        @foreach ($services as $index => $service)
                            <button type="button" @click="select({{ $index }})" aria-label="{{ __('Lihat') }} {{ $service->name }}"
                                    class="h-1.5 rounded-full bg-forest-200 transition-all duration-300"
                                    :class="active === {{ $index }} ? 'w-8 bg-gold-500' : 'w-1.5 hover:bg-forest-300'"></button>
                        @endforeach
                    </div>

                    {{-- Fallback grid (mobile/tablet) --}}
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:hidden">
                        @foreach ($services as $index => $service)
                            <div data-aos="fade-up" data-aos-delay="{{ ($index % 2) * 100 }}">
                                <x-service-card :service="$service" />
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
            </div>
        </div>
    </section>

    {{-- STATS --}}
    @if ($stats->isNotEmpty())
        <section class="mt-32 relative overflow-hidden bg-gradient-to-br from-forest-900 via-forest-800 to-forest-700 py-24 sm:py-28">
            <div class="pointer-events-none absolute inset-0">
                <div class="absolute inset-0 bg-noise opacity-[0.05] mix-blend-overlay"></div>
                <div class="absolute inset-0 bg-dot-grid text-cream/[0.06]"></div>
                <div class="animate-drift-slow absolute -right-24 top-0 h-96 w-96 rounded-full bg-gold-500/10 blur-3xl"></div>
                <x-watermark class="absolute -bottom-24 -left-24 h-80 w-80 text-forest-600/30" />
            </div>

            <div class="relative mx-auto max-w-7xl px-6 lg:px-8">
                <x-section-heading :kicker="__('Pencapaian Kami')" align="center" light class="mx-auto">
                    <x-slot:title>{{ __('Dipercaya, Terukur, Berdampak') }}</x-slot:title>
                    <x-slot:description>{{ __('Angka-angka yang mencerminkan komitmen kami dalam menghadirkan riset berkualitas selama bertahun-tahun.') }}</x-slot:description>
                </x-section-heading>

                <div class="mt-14 grid grid-cols-1 items-center gap-10 lg:grid-cols-5 lg:gap-16">
                    {{-- Featured stat --}}
                    @if ($stats->isNotEmpty())
                        @php $featured = $stats->first(); @endphp
                        <div data-aos="fade-up" class="relative lg:col-span-3">
                            <div
                                x-data="{ display: 0 }"
                                x-init="
                                    ScrollTrigger.create({
                                        trigger: $el, start: 'top 85%', once: true,
                                        onEnter: () => gsap.to($data, {
                                            display: {{ (int) $featured->value }}, duration: 2, ease: 'power2.out',
                                            onUpdate: () => display = Math.round(display),
                                        }),
                                    })
                                "
                                class="relative"
                            >
                                <span class="pointer-events-none absolute -left-4 -top-10 select-none font-serif text-[12rem] leading-none text-cream/[0.04]" aria-hidden="true">
                                    <x-icon :name="$featured->icon ?? 'heroicon-o-chart-bar'" class="h-40 w-40" />
                                </span>

                                <span class="relative flex h-12 w-12 items-center justify-center rounded-full bg-gold-500/10 text-gold-400">
                                    <x-icon :name="$featured->icon ?? 'heroicon-o-chart-bar'" class="h-6 w-6" />
                                </span>

                                <span class="relative mt-4 block font-serif text-7xl font-semibold text-cream sm:text-8xl">
                                    <span x-text="display">0</span>{{ $featured->suffix }}
                                </span>
                                <span class="relative mt-2 block text-base font-medium uppercase tracking-wide text-gold-300">
                                    {{ $featured->label }}
                                </span>
                                <p class="relative mt-4 max-w-md text-sm leading-relaxed text-forest-100/70">
                                    {{ __('Angka ini terus bertambah seiring komitmen kami mendampingi mitra institusi dengan riset yang independen dan berbasis bukti.') }}
                                </p>
                            </div>
                        </div>
                    @endif

                    {{-- Secondary stats --}}
                    <div data-aos="fade-up" data-aos-delay="150" class="divide-y divide-cream/10 border-t border-cream/10 lg:col-span-2">
                        @foreach ($stats->slice(1) as $stat)
                            <div
                                x-data="{ display: 0, filled: false }"
                                x-init="
                                    ScrollTrigger.create({
                                        trigger: $el, start: 'top 90%', once: true,
                                        onEnter: () => {
                                            filled = true;
                                            gsap.to($data, {
                                                display: {{ (int) $stat->value }}, duration: 1.6, ease: 'power2.out',
                                                onUpdate: () => display = Math.round(display),
                                            });
                                        },
                                    })
                                "
                                class="flex items-center gap-4 py-5"
                            >
                                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-cream/5 text-gold-400">
                                    <x-icon :name="$stat->icon ?? 'heroicon-o-chart-bar'" class="h-5 w-5" />
                                </span>
                                <div class="flex-1">
                                    <div class="flex items-baseline justify-between gap-3">
                                        <span class="text-sm font-medium text-forest-100/70">{{ $stat->label }}</span>
                                        <span class="font-serif text-2xl font-semibold text-cream">
                                            <span x-text="display">0</span>{{ $stat->suffix }}
                                        </span>
                                    </div>
                                    <div class="mt-2 h-1 overflow-hidden rounded-full bg-cream/10">
                                        <div class="h-full origin-left scale-x-0 rounded-full bg-gold-500 transition-transform duration-1000 ease-out"
                                             :class="filled ? 'scale-x-100' : 'scale-x-0'"></div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Marquee ticker --}}
            <div class="relative mt-16 overflow-hidden border-y border-cream/10 py-4" data-aos="fade-up">
                <div class="animate-marquee flex w-max items-center gap-8 whitespace-nowrap text-xs font-semibold uppercase tracking-[0.25em] text-cream/40">
                    @for ($i = 0; $i < 2; $i++)
                        <span class="flex items-center gap-8">
                            <span>{{ __('Riset Independen') }}</span>
                            <span class="text-gold-500">&bull;</span>
                            <span>{{ __('Kebijakan Publik') }}</span>
                            <span class="text-gold-500">&bull;</span>
                            <span>{{ __('Politik & Geopolitik') }}</span>
                            <span class="text-gold-500">&bull;</span>
                            <span>{{ __('Survey Sosial') }}</span>
                            <span class="text-gold-500">&bull;</span>
                            <span>{{ __('Strategi & Konsultasi') }}</span>
                            <span class="text-gold-500">&bull;</span>
                        </span>
                    @endfor
                </div>
            </div>
        </section>
    @endif

    {{-- WHY CHOOSE US --}}
    @php
        $reasons = [
            ['icon' => 'heroicon-o-shield-check', 'title' => __('Independensi & Objektivitas'), 'text' => __('Riset kami bebas dari kepentingan politik atau komersial tertentu, menjaga integritas hasil analisis.')],
            ['icon' => 'heroicon-o-academic-cap', 'title' => __('Tim Peneliti Berpengalaman'), 'text' => __('Didukung oleh peneliti dan analis dengan latar belakang akademik dan praktik yang kuat.')],
            ['icon' => 'heroicon-o-chart-bar', 'title' => __('Metodologi yang Kredibel'), 'text' => __('Menggunakan metode riset kuantitatif dan kualitatif yang teruji dan dapat dipertanggungjawabkan.')],
            ['icon' => 'heroicon-o-bolt', 'title' => __('Rekomendasi yang Aplikatif'), 'text' => __('Hasil riset diterjemahkan menjadi rekomendasi strategis yang siap diimplementasikan.')],
            ['icon' => 'heroicon-o-clock', 'title' => __('Ketepatan Waktu'), 'text' => __('Kami memahami pentingnya timing dalam pengambilan keputusan strategis.')],
        ];
        $reasonCount = count($reasons);
        $pentagon = [];
        foreach ($reasons as $i => $reason) {
            $a = deg2rad(-90 + $i * (360 / $reasonCount));
            $pentagon[] = [50 + 40 * cos($a), 50 + 40 * sin($a)];
        }
        $pentagonPath = 'M ' . implode(' L ', array_map(fn ($p) => $p[0].','.$p[1], $pentagon)) . ' Z';
    @endphp

    <section x-data="whyReasons()" class="relative bg-cream py-24 sm:py-32">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-16 lg:grid-cols-12">
                {{-- Pinned indicator --}}
                <div class="lg:col-span-4">
                    <div class="lg:sticky lg:top-32">
                        <x-section-heading :kicker="__('Mengapa Memilih Kami')">
                            <x-slot:title>{{ __('Keunggulan yang Membedakan Kami') }}</x-slot:title>
                            <x-slot:description>{{ __('Komitmen kami pada independensi, ketelitian, dan dampak nyata menjadikan Atom Visi Indonesia mitra riset yang tepercaya.') }}</x-slot:description>
                        </x-section-heading>

                        <div class="mt-10 flex items-center gap-6">
                            <span class="font-serif text-6xl font-semibold text-gold-500" x-text="String(active + 1).padStart(2, '0')">01</span>
                            <span class="text-sm text-charcoal/30">/ {{ str_pad($reasonCount, 2, '0', STR_PAD_LEFT) }}</span>
                        </div>

                        {{-- Pentagon motif, one vertex active per reason --}}
                        <svg viewBox="0 0 100 100" class="mt-8 h-40 w-40" aria-hidden="true">
                            <path d="{{ $pentagonPath }}" fill="none" stroke="currentColor" class="text-forest-100" stroke-width="1" />
                            @foreach ($pentagon as $index => $point)
                                <line x1="50" y1="50" x2="{{ $point[0] }}" y2="{{ $point[1] }}"
                                      stroke="currentColor" stroke-width="1"
                                      :class="active === {{ $index }} ? 'text-gold-400' : 'text-forest-100'" />
                            @endforeach
                            @foreach ($pentagon as $index => $point)
                                <circle cx="{{ $point[0] }}" cy="{{ $point[1] }}" r="4" fill="currentColor"
                                        class="transition-all duration-300"
                                        :class="active === {{ $index }} ? 'text-gold-500' : 'text-forest-200'"
                                        :r="active === {{ $index }} ? 5 : 3"></circle>
                            @endforeach
                        </svg>
                    </div>
                </div>

                {{-- Scrolling reason list --}}
                <div x-ref="items" class="space-y-24 lg:col-span-8 lg:space-y-32">
                    @foreach ($reasons as $index => $reason)
                        <div data-reason class="flex gap-6 transition-opacity duration-500" :class="active === {{ $index }} ? 'opacity-100' : 'opacity-40'">
                            <span class="shrink-0 font-serif text-sm text-gold-600">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                            <div>
                                <span class="flex h-14 w-14 items-center justify-center rounded-2xl bg-forest-700 text-gold-400 shadow-lg transition-transform duration-500"
                                      :class="active === {{ $index }} ? 'scale-100' : 'scale-90'">
                                    <x-icon :name="$reason['icon']" class="h-7 w-7" />
                                </span>
                                <h3 class="mt-6 font-serif text-3xl font-semibold leading-snug text-forest-800 sm:text-4xl">
                                    {{ $reason['title'] }}
                                </h3>
                                <p class="mt-4 max-w-md text-base leading-relaxed text-charcoal/70">
                                    {{ $reason['text'] }}
                                </p>
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
                    <x-section-heading :kicker="__('Insight Terbaru')">
                        <x-slot:title>{{ __('Artikel & Analisis Terkini') }}</x-slot:title>
                    </x-section-heading>
                    <a href="{{ route('articles.index') }}" data-aos="fade-up" class="shrink-0 text-sm font-semibold text-forest-700 hover:text-gold-600">
                        {{ __('Lihat Semua Artikel') }} &rarr;
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
                <x-section-heading :kicker="__('Kata Mereka')" align="center" class="mx-auto">
                    <x-slot:title>{{ __('Dipercaya oleh Mitra & Klien Kami') }}</x-slot:title>
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

    {{-- CTA --}}
    <section class="bg-cream py-24 sm:py-32">
        <div class="mx-auto max-w-5xl px-6 lg:px-8">
            <div data-aos="fade-up" class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-forest-800 to-forest-600 px-6 py-16 text-center shadow-2xl shadow-forest-900/20 sm:px-16 sm:py-20">
                <div class="pointer-events-none absolute inset-0 bg-noise opacity-[0.05] mix-blend-overlay"></div>
                <x-watermark class="pointer-events-none absolute -right-16 -top-16 h-72 w-72 text-forest-500/20" />

                <div class="relative">
                    <x-section-heading :kicker="__('Tetap Terhubung')" align="center" light class="mx-auto">
                        <x-slot:title>{{ __('Mari Berdiskusi tentang Kebutuhan Riset Anda') }}</x-slot:title>
                        <x-slot:description>{{ __('Tim kami siap membantu merancang riset, survey, atau kajian strategis yang sesuai dengan kebutuhan organisasi Anda.') }}</x-slot:description>
                    </x-section-heading>

                    <div class="mt-10 flex flex-wrap items-center justify-center gap-4">
                        <a href="{{ route('contact') }}"
                           class="rounded-full bg-gold-500 px-7 py-3.5 text-sm font-semibold text-forest-900 shadow-lg shadow-gold-500/20 transition-all hover:bg-gold-400 hover:shadow-xl">
                            {{ __('Hubungi Kami') }}
                        </a>
                        <a href="{{ route('articles.index') }}"
                           class="rounded-full border border-cream/30 px-7 py-3.5 text-sm font-semibold text-cream transition-all hover:border-gold-400 hover:text-gold-300">
                            {{ __('Baca Insight Terbaru') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layouts.app>
