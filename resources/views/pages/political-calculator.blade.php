<x-layouts.app title="{{ __('Kalkulator Politik') }}" description="{{ __('Masukkan wilayah target Anda dan dapatkan estimasi demografi, strategi, dan roadmap 1 tahun berbasis AI.') }}">
    <x-page-hero
        kicker="{{ __('Kalkulator Politik') }}"
        title="{{ __('Estimasi Strategi Pemenangan Anda dalam Hitungan Menit') }}"
        description="{{ __('Masukkan wilayah target Anda dan dapatkan estimasi demografi, strategi, dan roadmap 1 tahun berbasis AI.') }}"
    />

    <section class="bg-cream pt-24 sm:pt-32">
        <div class="mx-auto max-w-3xl px-6 lg:px-8">
            @livewire('political-calculator')
        </div>
    </section>

    {{-- CTA --}}
    @php
        $waMessage = __('Halo, saya baru mencoba Kalkulator Politik dan ingin berkonsultasi tentang strategi pemenangan yang lebih mendalam.');
    @endphp
    <section class="bg-cream py-24 sm:py-32">
        <div class="mx-auto max-w-5xl px-6 lg:px-8">
            <div data-aos="fade-up" class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-forest-800 to-forest-600 px-6 py-14 text-center shadow-2xl shadow-forest-900/20 sm:px-16">
                <div class="pointer-events-none absolute inset-0 bg-noise opacity-[0.05] mix-blend-overlay"></div>
                <x-logo-watermark class="pointer-events-none absolute -bottom-16 -left-16 h-72 w-72 text-gold-500/10" />
                <div class="relative">
                    <x-section-heading :kicker="__('Langkah Selanjutnya')" align="center" light class="mx-auto">
                        <x-slot:title>{{ __('Butuh Strategi Pemenangan yang Lebih Mendalam?') }}</x-slot:title>
                        <x-slot:description>{{ __('Estimasi ini hanya titik awal. Tim Atom Visi Indonesia siap menyusun riset lapangan, pemetaan wilayah, dan strategi pemenangan yang menyeluruh untuk kampanye Anda.') }}</x-slot:description>
                    </x-section-heading>
                    <div class="mt-8">
                        <a href="https://wa.me/{{ $settings->phone_digits }}?text={{ urlencode($waMessage) }}"
                           target="_blank" rel="noopener"
                           class="inline-flex items-center gap-2 rounded-full bg-gold-500 px-7 py-3.5 text-sm font-semibold text-forest-900 shadow-lg shadow-gold-500/20 transition-all hover:bg-gold-400 hover:shadow-xl">
                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M12.04 2c-5.52 0-10 4.48-10 10 0 1.76.46 3.48 1.34 5L2 22l5.16-1.35a9.96 9.96 0 0 0 4.88 1.24h.01c5.52 0 10-4.48 10-10s-4.48-9.89-10.01-9.89zm0 18.18h-.01a8.2 8.2 0 0 1-4.18-1.15l-.3-.18-3.06.8.82-2.98-.2-.31a8.18 8.18 0 0 1-1.26-4.36c0-4.52 3.68-8.2 8.2-8.2 2.19 0 4.25.85 5.79 2.4a8.13 8.13 0 0 1 2.4 5.8c0 4.52-3.69 8.18-8.2 8.18zm4.49-6.14c-.24-.12-1.45-.72-1.68-.8-.22-.08-.39-.12-.55.12-.16.24-.63.8-.78.97-.14.16-.29.18-.53.06-.24-.12-1.02-.38-1.94-1.2-.72-.64-1.2-1.43-1.35-1.67-.14-.24-.02-.37.11-.49.11-.11.24-.29.36-.43.12-.14.16-.24.24-.4.08-.16.04-.3-.02-.42-.06-.12-.55-1.32-.75-1.81-.2-.48-.4-.41-.55-.42-.14-.01-.3-.01-.46-.01-.16 0-.42.06-.64.3-.22.24-.84.82-.84 2s.86 2.32.98 2.48c.12.16 1.7 2.6 4.13 3.64.58.25 1.03.4 1.38.51.58.18 1.11.16 1.53.1.47-.07 1.45-.59 1.65-1.16.2-.57.2-1.06.14-1.16-.06-.1-.22-.16-.46-.28z"/>
                            </svg>
                            {{ __('Konsultasi via WhatsApp') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layouts.app>
