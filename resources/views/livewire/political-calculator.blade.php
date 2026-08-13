<div>
    @if ($submitted && $result)
        <div class="space-y-8" data-aos="fade-up">
            <div class="rounded-2xl border border-forest-200 bg-forest-50 p-6 text-center">
                <svg class="mx-auto h-10 w-10 text-forest-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                <h3 class="mt-3 font-serif text-xl font-semibold text-forest-800">{{ __('Estimasi Selesai Dibuat') }}</h3>
                <p class="mt-1 text-sm text-charcoal/70">{{ $result->kecamatan }}, {{ $result->kota }}, {{ $result->provinsi }} &middot; {{ $result->target_jabatan_label }}</p>
            </div>

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                <div class="rounded-2xl border border-forest-100 bg-white p-5 text-center">
                    <p class="text-xs font-semibold uppercase tracking-wider text-gold-600">{{ __('Jumlah Penduduk') }}</p>
                    <p class="mt-2 font-serif text-2xl font-semibold text-forest-800">{{ number_format($result->jumlah_penduduk, 0, ',', '.') }}</p>
                </div>
                <div class="rounded-2xl border border-forest-100 bg-white p-5 text-center">
                    <p class="text-xs font-semibold uppercase tracking-wider text-gold-600">{{ __('Jumlah Pemilih Potensial') }}</p>
                    <p class="mt-2 font-serif text-2xl font-semibold text-forest-800">{{ number_format($result->jumlah_pemilih_potensial, 0, ',', '.') }}</p>
                </div>
                <div class="rounded-2xl border border-forest-100 bg-white p-5 text-center">
                    <p class="text-xs font-semibold uppercase tracking-wider text-gold-600">{{ __('Kelompok Umur yang Mendominasi') }}</p>
                    <p class="mt-2 font-serif text-2xl font-semibold text-forest-800">{{ $result->kelompok_umur_dominan }}</p>
                </div>
            </div>

            <div class="rounded-2xl border border-forest-100 bg-white p-6">
                <h4 class="font-serif text-lg font-semibold text-forest-800">{{ __('Langkah-Langkah Strategis yang Disarankan') }}</h4>
                <ul class="mt-4 space-y-3">
                    @foreach ($result->langkah_strategis as $langkah)
                        <li class="flex items-start gap-2.5 text-sm leading-relaxed text-charcoal/80">
                            <span class="mt-1.5 h-1.5 w-1.5 shrink-0 rounded-full bg-gold-500"></span>
                            {{ $langkah }}
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="rounded-2xl border border-forest-100 bg-white p-6">
                <h4 class="font-serif text-lg font-semibold text-forest-800">{{ __('Pembagian Porsi Komunikasi') }}</h4>
                <div class="mt-4 space-y-4">
                    @foreach ([
                        'baliho' => __('Baliho'),
                        'sosialisasi_kunjungan' => __('Sosialisasi & Kunjungan'),
                        'instagram' => 'Instagram',
                        'whatsapp' => 'WhatsApp',
                    ] as $key => $label)
                        <div>
                            <div class="flex items-center justify-between text-sm">
                                <span class="font-medium text-charcoal/80">{{ $label }}</span>
                                <span class="font-semibold text-forest-700">{{ $result->porsi_komunikasi[$key] ?? 0 }}%</span>
                            </div>
                            <div class="mt-1.5 h-2 w-full overflow-hidden rounded-full bg-forest-50">
                                <div class="h-full rounded-full bg-gold-500" style="width: {{ $result->porsi_komunikasi[$key] ?? 0 }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="rounded-2xl border border-forest-100 bg-white p-6" x-data="{ open: 1 }">
                <h4 class="font-serif text-lg font-semibold text-forest-800">{{ __('Roadmap 1 Tahun') }}</h4>
                <div class="mt-4 divide-y divide-forest-100">
                    @foreach ($result->roadmap as $bulan)
                        <div class="py-3">
                            <button type="button" @click="open = (open === {{ $bulan['bulan'] }} ? null : {{ $bulan['bulan'] }})"
                                    class="flex w-full items-center justify-between gap-4 text-left">
                                <span class="text-sm font-semibold text-forest-800">{{ __('Bulan') }} {{ $bulan['bulan'] }} &middot; {{ $bulan['fokus'] }}</span>
                                <svg class="h-4 w-4 shrink-0 text-forest-400 transition-transform" :class="open === {{ $bulan['bulan'] }} ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19.5 8.25l-7.5 7.5-7.5-7.5" /></svg>
                            </button>
                            <div x-show="open === {{ $bulan['bulan'] }}" x-transition class="mt-3 space-y-2 pl-1">
                                @foreach ($bulan['minggu'] as $minggu)
                                    <div class="flex items-start gap-2.5 text-sm text-charcoal/75">
                                        <span class="mt-0.5 shrink-0 font-semibold text-gold-600">{{ __('Minggu') }} {{ $minggu['minggu'] }}</span>
                                        <span>{{ $minggu['aktivitas'] }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <p class="text-center text-xs text-charcoal/50">{{ __('Estimasi berbasis AI, bukan data resmi BPS/KPU') }}</p>

            <div class="text-center">
                <button type="button" wire:click="resetForm" class="text-sm font-semibold text-forest-700 hover:text-gold-600">
                    {{ __('Hitung Ulang') }}
                </button>
            </div>
        </div>
    @else
        <form wire:submit="submit" class="space-y-5">
            @if ($errorMessage)
                <div class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                    {{ $errorMessage }}
                </div>
            @endif

            <input type="text" wire:model="website" tabindex="-1" autocomplete="off"
                   class="absolute -left-[9999px] h-0 w-0 opacity-0" aria-hidden="true">

            <div>
                <label for="provinsi" class="block text-sm font-medium text-forest-800">{{ __('Provinsi') }}</label>
                <input type="text" id="provinsi" wire:model="provinsi" placeholder="{{ __('Contoh: Jawa Barat') }}"
                       class="mt-2 w-full rounded-xl border bg-white px-4 py-3 text-sm text-charcoal shadow-sm transition-colors placeholder:text-charcoal/30 focus:outline-none focus:ring-2 {{ $errors->has('provinsi') ? 'border-red-300 focus:border-red-500 focus:ring-red-500/20' : 'border-forest-200 focus:border-forest-500 focus:ring-forest-500/20' }}">
                @error('provinsi') <span class="mt-1.5 block text-xs text-red-600">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="kota" class="block text-sm font-medium text-forest-800">{{ __('Kota/Kabupaten') }}</label>
                <input type="text" id="kota" wire:model="kota" placeholder="{{ __('Contoh: Kabupaten Bandung') }}"
                       class="mt-2 w-full rounded-xl border bg-white px-4 py-3 text-sm text-charcoal shadow-sm transition-colors placeholder:text-charcoal/30 focus:outline-none focus:ring-2 {{ $errors->has('kota') ? 'border-red-300 focus:border-red-500 focus:ring-red-500/20' : 'border-forest-200 focus:border-forest-500 focus:ring-forest-500/20' }}">
                @error('kota') <span class="mt-1.5 block text-xs text-red-600">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="kecamatan" class="block text-sm font-medium text-forest-800">{{ __('Kecamatan') }}</label>
                <input type="text" id="kecamatan" wire:model="kecamatan" placeholder="{{ __('Contoh: Soreang') }}"
                       class="mt-2 w-full rounded-xl border bg-white px-4 py-3 text-sm text-charcoal shadow-sm transition-colors placeholder:text-charcoal/30 focus:outline-none focus:ring-2 {{ $errors->has('kecamatan') ? 'border-red-300 focus:border-red-500 focus:ring-red-500/20' : 'border-forest-200 focus:border-forest-500 focus:ring-forest-500/20' }}">
                @error('kecamatan') <span class="mt-1.5 block text-xs text-red-600">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="target_jabatan" class="block text-sm font-medium text-forest-800">{{ __('Target Jabatan') }}</label>
                <select id="target_jabatan" wire:model="target_jabatan"
                        class="mt-2 w-full rounded-xl border bg-white px-4 py-3 text-sm text-charcoal shadow-sm transition-colors focus:outline-none focus:ring-2 {{ $errors->has('target_jabatan') ? 'border-red-300 focus:border-red-500 focus:ring-red-500/20' : 'border-forest-200 focus:border-forest-500 focus:ring-forest-500/20' }}">
                    <option value="">{{ __('Pilih target jabatan') }}</option>
                    <option value="gubernur">{{ __('Gubernur') }}</option>
                    <option value="walikota">{{ __('Walikota') }}</option>
                    <option value="bupati">{{ __('Bupati') }}</option>
                    <option value="caleg">{{ __('Caleg (Calon Legislatif)') }}</option>
                </select>
                @error('target_jabatan') <span class="mt-1.5 block text-xs text-red-600">{{ $message }}</span> @enderror
            </div>

            <button type="submit"
                    wire:loading.attr="disabled" wire:target="submit"
                    class="inline-flex w-full items-center justify-center gap-2 rounded-full bg-forest-700 px-7 py-3.5 text-sm font-semibold text-cream shadow-sm transition-all hover:bg-forest-600 hover:shadow-md disabled:opacity-60">
                <span wire:loading.remove wire:target="submit" class="inline-flex items-center gap-2">
                    {{ __('Hitung Estimasi') }}
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3" /></svg>
                </span>
                <span wire:loading wire:target="submit">{{ __('Menganalisis wilayah Anda, biasanya 20-30 detik...') }}</span>
            </button>
        </form>
    @endif
</div>
