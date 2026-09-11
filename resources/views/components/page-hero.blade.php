@props(['kicker' => null, 'title', 'description' => null])

<section id="hero" class="relative overflow-hidden bg-gradient-to-br from-forest-800 to-forest-600 pb-20 pt-40">
    <x-logo-watermark class="pointer-events-none absolute -right-24 -top-24 h-80 w-80 text-forest-500/20" />

    <div class="relative mx-auto max-w-5xl px-6 text-center lg:px-8">
        @if ($kicker)
            <span data-aos="fade-up" class="inline-flex items-center gap-2 rounded-full border border-gold-400/30 bg-gold-400/10 px-4 py-1.5 text-xs font-semibold uppercase tracking-[0.2em] text-gold-300">
                {{ $kicker }}
            </span>
        @endif

        <h1 data-aos="fade-up" data-aos-delay="100" class="mt-6 font-sans text-4xl font-semibold leading-tight text-cream sm:text-5xl">
            {{ $title }}
        </h1>

        @if ($description)
            <p data-aos="fade-up" data-aos-delay="200" class="mx-auto mt-5 max-w-2xl text-base leading-relaxed text-forest-100/80">
                {{ $description }}
            </p>
        @endif
    </div>
</section>
