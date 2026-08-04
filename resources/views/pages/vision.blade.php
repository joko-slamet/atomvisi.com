<x-layouts.app title="Visi & Misi">
    <x-page-hero
        kicker="Visi &amp; Misi"
        title="Arah yang Menuntun Setiap Langkah Kami"
    />

    <section class="bg-cream py-24 sm:py-32">
        <div class="mx-auto max-w-5xl px-6 lg:px-8">
            <div data-aos="fade-up" class="rounded-2xl border border-forest-100 bg-forest-50/60 p-10 text-center">
                <span class="text-xs font-semibold uppercase tracking-[0.25em] text-gold-600">Visi</span>
                <p class="mx-auto mt-4 max-w-3xl font-serif text-2xl font-medium leading-snug text-forest-800 sm:text-3xl">
                    Menjadi lembaga riset independen terdepan di Indonesia yang menghadirkan insight berkualitas untuk mendorong kebijakan dan strategi yang berdampak.
                </p>
            </div>

            <div class="mt-16">
                <span data-aos="fade-up" class="block text-center text-xs font-semibold uppercase tracking-[0.25em] text-gold-600">Misi</span>
                <div class="mt-8 grid grid-cols-1 gap-6 sm:grid-cols-2">
                    @php
                        $missions = [
                            'Menghasilkan riset kebijakan publik yang kredibel dan berbasis bukti untuk mendukung pengambilan keputusan.',
                            'Menyediakan analisis politik dan geopolitik yang tajam bagi pemerintah, bisnis, dan masyarakat sipil.',
                            'Melaksanakan survey dan kajian sosial dengan metodologi yang ilmiah dan dapat dipertanggungjawabkan.',
                            'Menjembatani hasil riset akademik dengan kebutuhan praktis para pengambil kebijakan melalui rekomendasi yang aplikatif.',
                        ];
                    @endphp
                    @foreach ($missions as $index => $mission)
                        <div data-aos="fade-up" data-aos-delay="{{ $index * 100 }}" class="flex gap-4 rounded-xl border border-forest-100 bg-white p-6">
                            <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-gold-500/10 font-serif text-sm font-semibold text-gold-600">
                                {{ $index + 1 }}
                            </span>
                            <p class="text-sm leading-relaxed text-charcoal/75">{{ $mission }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
</x-layouts.app>
