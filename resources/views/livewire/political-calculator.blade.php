@php use App\Support\PoliticalCalculatorOptions; @endphp
<div x-data="politicalCalculatorResult()" x-init="init()">
    <div x-show="result" style="display: none;" class="space-y-8">
        <div class="rounded-2xl border border-forest-200 bg-forest-50 p-6 text-center">
            <svg class="mx-auto h-10 w-10 text-forest-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            <h3 class="mt-3 font-sans text-xl font-semibold text-forest-800">{{ __('Estimasi Selesai Dibuat') }}</h3>
            <p class="mt-1 text-sm text-charcoal/70">
                <span x-text="result?.region_label"></span> &middot; <span x-text="result?.target_jabatan_label"></span>
            </p>
        </div>

        <div class="rounded-2xl border border-forest-100 bg-white p-6" x-show="result?.ringkasan_analisis">
            <h4 class="font-sans text-lg font-semibold text-forest-800">{{ __('Ringkasan Analisis') }}</h4>
            <p class="mt-3 text-sm leading-relaxed text-charcoal/80" x-text="result?.ringkasan_analisis"></p>
        </div>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
            <div class="rounded-2xl border border-forest-100 bg-white p-5 text-center">
                <p class="text-xs font-semibold uppercase tracking-wider text-gold-600">{{ __('Jumlah Penduduk') }}</p>
                <p class="mt-2 font-sans text-2xl font-semibold text-forest-800" x-text="formatNumber(result?.jumlah_penduduk)"></p>
            </div>
            <div class="rounded-2xl border border-forest-100 bg-white p-5 text-center">
                <p class="text-xs font-semibold uppercase tracking-wider text-gold-600">{{ __('Jumlah Pemilih Potensial') }}</p>
                <p class="mt-2 font-sans text-2xl font-semibold text-forest-800" x-text="formatNumber(result?.jumlah_pemilih_potensial)"></p>
            </div>
            <div class="rounded-2xl border border-forest-100 bg-white p-5 text-center">
                <p class="text-xs font-semibold uppercase tracking-wider text-gold-600">{{ __('Kelompok Umur yang Mendominasi') }}</p>
                <p class="mt-2 font-sans text-2xl font-semibold text-forest-800" x-text="result?.kelompok_umur_dominan"></p>
            </div>
        </div>

        <div class="rounded-2xl border border-forest-100 bg-white p-6" x-show="(result?.pesan_utama ?? []).length">
            <h4 class="font-sans text-lg font-semibold text-forest-800">{{ __('Pesan Utama Kampanye') }}</h4>
            <div class="mt-4 grid grid-cols-1 gap-3 sm:grid-cols-3">
                <template x-for="(pesan, index) in (result?.pesan_utama ?? [])" :key="index">
                    <div class="rounded-xl border border-gold-200 bg-gold-50/60 p-4 text-sm leading-relaxed text-charcoal/80" x-text="pesan"></div>
                </template>
            </div>
        </div>

        <div class="rounded-2xl border border-forest-100 bg-white p-6">
            <h4 class="font-sans text-lg font-semibold text-forest-800">{{ __('Langkah-Langkah Strategis yang Disarankan') }}</h4>
            <ul class="mt-4 space-y-3">
                <template x-for="(langkah, index) in (result?.langkah_strategis ?? [])" :key="index">
                    <li class="flex items-start gap-2.5 text-sm leading-relaxed text-charcoal/80">
                        <span class="mt-1.5 h-1.5 w-1.5 shrink-0 rounded-full bg-gold-500"></span>
                        <span x-text="langkah"></span>
                    </li>
                </template>
            </ul>
        </div>

        <div class="rounded-2xl border border-forest-100 bg-white p-6" x-show="(result?.fokus_isu ?? []).length">
            <h4 class="font-sans text-lg font-semibold text-forest-800">{{ __('Pendekatan per Isu Utama') }}</h4>
            <div class="mt-4 space-y-4">
                <template x-for="(item, index) in (result?.fokus_isu ?? [])" :key="index">
                    <div class="rounded-xl border border-forest-100 bg-forest-50/40 p-4">
                        <p class="text-sm font-semibold text-forest-800" x-text="item.isu"></p>
                        <p class="mt-1.5 text-sm leading-relaxed text-charcoal/75" x-text="item.rekomendasi"></p>
                    </div>
                </template>
            </div>
        </div>

        <div class="rounded-2xl border border-forest-100 bg-white p-6">
            <h4 class="font-sans text-lg font-semibold text-forest-800">{{ __('Pembagian Porsi Komunikasi') }}</h4>
            <div class="mt-4 space-y-4"
                 x-data="{ items: [
                     { key: 'baliho', label: @js(__('Baliho')) },
                     { key: 'sosialisasi_kunjungan', label: @js(__('Sosialisasi & Kunjungan')) },
                     { key: 'instagram', label: 'Instagram' },
                     { key: 'whatsapp', label: 'WhatsApp' },
                 ] }">
                <template x-for="item in items" :key="item.key">
                    <div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="font-medium text-charcoal/80" x-text="item.label"></span>
                            <span class="font-semibold text-forest-700" x-text="(result?.porsi_komunikasi?.[item.key] ?? 0) + '%'"></span>
                        </div>
                        <div class="mt-1.5 h-2 w-full overflow-hidden rounded-full bg-forest-50">
                            <div class="h-full rounded-full bg-gold-500" :style="`width: ${result?.porsi_komunikasi?.[item.key] ?? 0}%`"></div>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <div class="rounded-2xl border border-forest-100 bg-white p-6">
            <h4 class="font-sans text-lg font-semibold text-forest-800">{{ __('Roadmap 1 Tahun') }}</h4>
            <div class="mt-4 divide-y divide-forest-100">
                <template x-for="bulan in (result?.roadmap ?? [])" :key="bulan.bulan">
                    <div class="py-3">
                        <button type="button" @click="openMonth = (openMonth === bulan.bulan ? null : bulan.bulan)"
                                class="flex w-full items-center justify-between gap-4 text-left">
                            <span class="text-sm font-semibold text-forest-800">
                                {{ __('Bulan') }} <span x-text="bulan.bulan"></span> &middot; <span x-text="bulan.fokus"></span>
                            </span>
                            <svg class="h-4 w-4 shrink-0 text-forest-400 transition-transform" :class="openMonth === bulan.bulan ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19.5 8.25l-7.5 7.5-7.5-7.5" /></svg>
                        </button>
                        <div x-show="openMonth === bulan.bulan" x-transition class="mt-3 space-y-2 pl-1">
                            <template x-for="minggu in bulan.minggu" :key="minggu.minggu">
                                <div class="flex items-start gap-2.5 text-sm text-charcoal/75">
                                    <span class="mt-0.5 shrink-0 font-semibold text-gold-600">{{ __('Minggu') }} <span x-text="minggu.minggu"></span></span>
                                    <span x-text="minggu.aktivitas"></span>
                                </div>
                            </template>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <p class="text-center text-xs text-charcoal/50">{{ __('Estimasi berbasis AI, bukan data resmi BPS/KPU') }}</p>

        <div class="text-center">
            <button type="button" @click="clearResult" class="text-sm font-semibold text-forest-700 hover:text-gold-600">
                {{ __('Hapus Riwayat & Hitung Ulang') }}
            </button>
        </div>
    </div>

    <div x-show="!result">
        <form wire:submit="submit" class="space-y-5">
            @if ($errorMessage)
                <div class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                    {{ $errorMessage }}
                </div>
            @endif

            <input type="text" wire:model="website" tabindex="-1" autocomplete="off"
                   class="absolute -left-[9999px] h-0 w-0 opacity-0" aria-hidden="true">

            <div>
                <label for="target_jabatan" class="block text-sm font-medium text-forest-800">{{ __('Target Jabatan') }}</label>
                <select id="target_jabatan" wire:model.live="target_jabatan"
                        class="mt-2 w-full rounded-xl border bg-white px-4 py-3 text-sm text-charcoal shadow-sm transition-colors focus:outline-none focus:ring-2 {{ $errors->has('target_jabatan') ? 'border-red-300 focus:border-red-500 focus:ring-red-500/20' : 'border-forest-200 focus:border-forest-500 focus:ring-forest-500/20' }}">
                    <option value="">{{ __('Pilih target jabatan') }}</option>
                    <option value="gubernur">{{ __('Gubernur') }}</option>
                    <option value="walikota">{{ __('Walikota') }}</option>
                    <option value="bupati">{{ __('Bupati') }}</option>
                    <option value="caleg">{{ __('Caleg (Calon Legislatif)') }}</option>
                </select>
                @error('target_jabatan') <span class="mt-1.5 block text-xs text-red-600">{{ $message }}</span> @enderror
            </div>

            @if ($target_jabatan)
                <div wire:transition>
                    <label for="provinsi_id" class="block text-sm font-medium text-forest-800">{{ __('Provinsi') }}</label>
                    <select id="provinsi_id" wire:model.live="provinsi_id"
                            class="mt-2 w-full rounded-xl border bg-white px-4 py-3 text-sm text-charcoal shadow-sm transition-colors focus:outline-none focus:ring-2 {{ $errors->has('provinsi_id') ? 'border-red-300 focus:border-red-500 focus:ring-red-500/20' : 'border-forest-200 focus:border-forest-500 focus:ring-forest-500/20' }}">
                        <option value="">{{ __('Pilih provinsi') }}</option>
                        @foreach ($this->provinces as $id => $name)
                            <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                    </select>
                    @error('provinsi_id') <span class="mt-1.5 block text-xs text-red-600">{{ $message }}</span> @enderror
                </div>

                @if ($target_jabatan !== 'gubernur' && $provinsi_id)
                    <div wire:transition>
                        <label for="kota_id" class="block text-sm font-medium text-forest-800">{{ __('Kota/Kabupaten') }}</label>
                        <select id="kota_id" wire:model.live="kota_id"
                                class="mt-2 w-full rounded-xl border bg-white px-4 py-3 text-sm text-charcoal shadow-sm transition-colors focus:outline-none focus:ring-2 {{ $errors->has('kota_id') ? 'border-red-300 focus:border-red-500 focus:ring-red-500/20' : 'border-forest-200 focus:border-forest-500 focus:ring-forest-500/20' }}">
                            <option value="">{{ __('Pilih kota/kabupaten') }}</option>
                            @foreach ($this->regencies as $id => $name)
                                <option value="{{ $id }}">{{ $name }}</option>
                            @endforeach
                        </select>
                        @error('kota_id') <span class="mt-1.5 block text-xs text-red-600">{{ $message }}</span> @enderror
                    </div>
                @endif

                @if ($provinsi_id && ($target_jabatan === 'gubernur' || $kota_id))
                    <div wire:transition class="space-y-5 border-t border-forest-100 pt-5">
                        <div>
                            <label for="age_range" class="block text-sm font-medium text-forest-800">{{ __('Rentang Usia Anda') }}</label>
                            <select id="age_range" wire:model="age_range"
                                    class="mt-2 w-full rounded-xl border bg-white px-4 py-3 text-sm text-charcoal shadow-sm transition-colors focus:outline-none focus:ring-2 {{ $errors->has('age_range') ? 'border-red-300 focus:border-red-500 focus:ring-red-500/20' : 'border-forest-200 focus:border-forest-500 focus:ring-forest-500/20' }}">
                                <option value="">{{ __('Pilih rentang usia') }}</option>
                                @foreach (PoliticalCalculatorOptions::ageRanges() as $key => $label)
                                    <option value="{{ $key }}">{{ __($label) }}</option>
                                @endforeach
                            </select>
                            @error('age_range') <span class="mt-1.5 block text-xs text-red-600">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="candidate_status" class="block text-sm font-medium text-forest-800">{{ __('Status Pencalonan') }}</label>
                            <select id="candidate_status" wire:model="candidate_status"
                                    class="mt-2 w-full rounded-xl border bg-white px-4 py-3 text-sm text-charcoal shadow-sm transition-colors focus:outline-none focus:ring-2 {{ $errors->has('candidate_status') ? 'border-red-300 focus:border-red-500 focus:ring-red-500/20' : 'border-forest-200 focus:border-forest-500 focus:ring-forest-500/20' }}">
                                <option value="">{{ __('Pilih status pencalonan') }}</option>
                                @foreach (PoliticalCalculatorOptions::candidateStatuses() as $key => $label)
                                    <option value="{{ $key }}">{{ __($label) }}</option>
                                @endforeach
                            </select>
                            @error('candidate_status') <span class="mt-1.5 block text-xs text-red-600">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="public_recognition" class="block text-sm font-medium text-forest-800">{{ __('Tingkat Pengenalan Publik') }}</label>
                            <select id="public_recognition" wire:model="public_recognition"
                                    class="mt-2 w-full rounded-xl border bg-white px-4 py-3 text-sm text-charcoal shadow-sm transition-colors focus:outline-none focus:ring-2 {{ $errors->has('public_recognition') ? 'border-red-300 focus:border-red-500 focus:ring-red-500/20' : 'border-forest-200 focus:border-forest-500 focus:ring-forest-500/20' }}">
                                <option value="">{{ __('Pilih tingkat pengenalan publik') }}</option>
                                @foreach (PoliticalCalculatorOptions::recognitionLevels() as $key => $label)
                                    <option value="{{ $key }}">{{ __($label) }}</option>
                                @endforeach
                            </select>
                            @error('public_recognition') <span class="mt-1.5 block text-xs text-red-600">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="voter_target" class="block text-sm font-medium text-forest-800">{{ __('Kelompok Masyarakat Prioritas') }}</label>
                            <select id="voter_target" wire:model="voter_target"
                                    class="mt-2 w-full rounded-xl border bg-white px-4 py-3 text-sm text-charcoal shadow-sm transition-colors focus:outline-none focus:ring-2 {{ $errors->has('voter_target') ? 'border-red-300 focus:border-red-500 focus:ring-red-500/20' : 'border-forest-200 focus:border-forest-500 focus:ring-forest-500/20' }}">
                                <option value="">{{ __('Pilih kelompok masyarakat prioritas') }}</option>
                                @foreach (PoliticalCalculatorOptions::voterTargets() as $key => $label)
                                    <option value="{{ $key }}">{{ __($label) }}</option>
                                @endforeach
                            </select>
                            @error('voter_target') <span class="mt-1.5 block text-xs text-red-600">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="main_goal" class="block text-sm font-medium text-forest-800">{{ __('Prioritas Sosialisasi Saat Ini') }}</label>
                            <select id="main_goal" wire:model="main_goal"
                                    class="mt-2 w-full rounded-xl border bg-white px-4 py-3 text-sm text-charcoal shadow-sm transition-colors focus:outline-none focus:ring-2 {{ $errors->has('main_goal') ? 'border-red-300 focus:border-red-500 focus:ring-red-500/20' : 'border-forest-200 focus:border-forest-500 focus:ring-forest-500/20' }}">
                                <option value="">{{ __('Pilih prioritas sosialisasi') }}</option>
                                @foreach (PoliticalCalculatorOptions::mainGoals() as $key => $label)
                                    <option value="{{ $key }}">{{ __($label) }}</option>
                                @endforeach
                            </select>
                            @error('main_goal') <span class="mt-1.5 block text-xs text-red-600">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-forest-800">{{ __('Isu Utama di Wilayah Anda') }}</label>
                            <p class="mt-1 text-xs text-charcoal/60">{{ __('Pilih maksimal 3 isu yang paling menjadi perhatian masyarakat') }}</p>
                            <div class="mt-3 grid grid-cols-1 gap-2 sm:grid-cols-2">
                                @foreach (PoliticalCalculatorOptions::localIssues() as $key => $label)
                                    <label class="flex cursor-pointer items-center gap-2.5 rounded-xl border border-forest-200 bg-white px-4 py-2.5 text-sm text-charcoal transition-colors has-checked:border-forest-500 has-checked:bg-forest-50">
                                        <input type="checkbox" wire:model="local_issues" value="{{ $key }}"
                                               class="h-4 w-4 shrink-0 rounded border-forest-300 text-forest-600 focus:ring-forest-500/30">
                                        {{ __($label) }}
                                    </label>
                                @endforeach
                            </div>
                            @error('local_issues') <span class="mt-1.5 block text-xs text-red-600">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="about_you" class="block text-sm font-medium text-forest-800">
                                {{ __('Tentang Anda (Pilihan)') }}
                            </label>
                            <p class="mt-1 text-xs text-charcoal/60">{{ __('Bantu kami mempersonalisasi strategi Anda. Ceritakan secara singkat latar belakang, pengalaman, aktivitas di masyarakat, kekuatan utama, atau hal yang membedakan Anda dari kandidat lainnya.') }}</p>
                            <textarea id="about_you" wire:model="about_you" rows="4"
                                      placeholder="{{ __('Contoh: "Pengusaha lokal, lahir dan besar di Kabupaten Bandung, aktif dalam komunitas UMKM selama 12 tahun, namun relatif baru di dunia politik."') }}"
                                      class="mt-2 w-full rounded-xl border bg-white px-4 py-3 text-sm text-charcoal shadow-sm transition-colors focus:outline-none focus:ring-2 {{ $errors->has('about_you') ? 'border-red-300 focus:border-red-500 focus:ring-red-500/20' : 'border-forest-200 focus:border-forest-500 focus:ring-forest-500/20' }}"></textarea>
                            @error('about_you') <span class="mt-1.5 block text-xs text-red-600">{{ $message }}</span> @enderror
                        </div>
                    </div>
                @endif
            @endif

            <button type="submit"
                    wire:loading.attr="disabled" wire:target="submit"
                    class="inline-flex w-full items-center justify-center gap-2 rounded-full bg-forest-700 px-7 py-3.5 text-sm font-semibold text-cream shadow-sm transition-all hover:bg-forest-600 hover:shadow-md disabled:opacity-60">
                <span wire:loading.remove wire:target="submit" class="inline-flex items-center gap-2">
                    {{ __('Bangun Strategi Kemenangan Saya') }}
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3" /></svg>
                </span>
                <span wire:loading wire:target="submit">{{ __('Menganalisis wilayah Anda, biasanya 20-30 detik...') }}</span>
            </button>
        </form>
    </div>
</div>
