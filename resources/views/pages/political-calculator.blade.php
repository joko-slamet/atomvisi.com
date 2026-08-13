<x-layouts.app title="{{ __('Kalkulator Politik') }}" description="{{ __('Masukkan wilayah target Anda dan dapatkan estimasi demografi, strategi, dan roadmap 1 tahun berbasis AI.') }}">
    <x-page-hero
        kicker="{{ __('Kalkulator Politik') }}"
        title="{{ __('Estimasi Strategi Pemenangan Anda dalam Hitungan Menit') }}"
        description="{{ __('Masukkan wilayah target Anda dan dapatkan estimasi demografi, strategi, dan roadmap 1 tahun berbasis AI.') }}"
    />

    <section class="bg-cream py-24 sm:py-32">
        <div class="mx-auto max-w-3xl px-6 lg:px-8">
            @livewire('political-calculator')
        </div>
    </section>
</x-layouts.app>
