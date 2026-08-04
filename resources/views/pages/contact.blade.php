<x-layouts.app title="Kontak">
    <x-page-hero
        kicker="Kontak"
        title="Mari Berdiskusi tentang Kebutuhan Riset Anda"
        description="Tim kami siap membantu merancang riset, survey, atau kajian strategis yang sesuai dengan kebutuhan organisasi Anda."
    />

    <section class="bg-cream py-24 sm:py-32">
        <div class="mx-auto grid max-w-7xl grid-cols-1 gap-16 px-6 lg:grid-cols-5 lg:px-8">
            <div class="lg:col-span-2" data-aos="fade-up">
                <h2 class="font-serif text-2xl font-semibold text-forest-800">Informasi Kontak</h2>
                <div class="mt-8 space-y-6">
                    <div class="flex gap-4">
                        <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-forest-50 text-forest-700">
                            <x-icon name="heroicon-o-map-pin" class="h-5 w-5" />
                        </span>
                        <div>
                            <h3 class="text-sm font-semibold text-forest-800">Alamat</h3>
                            <p class="mt-1 text-sm text-charcoal/70">Setiabudi 2 Building,<br>Kuningan, Jakarta Selatan</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-forest-50 text-forest-700">
                            <x-icon name="heroicon-o-envelope" class="h-5 w-5" />
                        </span>
                        <div>
                            <h3 class="text-sm font-semibold text-forest-800">Email</h3>
                            <p class="mt-1 text-sm text-charcoal/70">info@atomvisi.com</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-forest-50 text-forest-700">
                            <x-icon name="heroicon-o-phone" class="h-5 w-5" />
                        </span>
                        <div>
                            <h3 class="text-sm font-semibold text-forest-800">Telepon</h3>
                            <p class="mt-1 text-sm text-charcoal/70">+62 21 0000 0000</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-forest-50 text-forest-700">
                            <x-icon name="heroicon-o-camera" class="h-5 w-5" />
                        </span>
                        <div>
                            <h3 class="text-sm font-semibold text-forest-800">Instagram</h3>
                            <p class="mt-1 text-sm text-charcoal/70">@atomvisiindonesia</p>
                        </div>
                    </div>
                </div>

                <div class="mt-10 aspect-video overflow-hidden rounded-2xl border border-forest-100">
                    <iframe
                        title="Lokasi Atom Visi Indonesia"
                        class="h-full w-full"
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        src="https://www.google.com/maps?q=Setiabudi+2+Building+Kuningan+Jakarta+Selatan&output=embed">
                    </iframe>
                </div>
            </div>

            <div class="lg:col-span-3" data-aos="fade-up" data-aos-delay="150">
                <div class="rounded-2xl border border-forest-100 bg-white p-8 sm:p-10">
                    <h2 class="font-serif text-2xl font-semibold text-forest-800">Kirim Pesan</h2>
                    <p class="mt-2 text-sm text-charcoal/60">Isi form di bawah ini dan tim kami akan merespons dalam 1&ndash;2 hari kerja.</p>
                    <div class="mt-8">
                        @livewire('contact-form')
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layouts.app>
