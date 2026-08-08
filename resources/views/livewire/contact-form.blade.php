<div>
    @if ($sent)
        <div class="rounded-2xl border border-forest-200 bg-forest-50 p-8 text-center" data-aos="fade-up">
            <svg class="mx-auto h-12 w-12 text-forest-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            <h3 class="mt-4 font-serif text-xl font-semibold text-forest-800">{{ __('Pesan Terkirim') }}</h3>
            <p class="mt-2 text-sm text-charcoal/70">{{ __('Terima kasih telah menghubungi kami. Tim kami akan segera merespons pesan Anda.') }}</p>
            <button type="button" wire:click="$set('sent', false)" class="mt-6 text-sm font-semibold text-forest-700 hover:text-gold-600">
                {{ __('Kirim pesan lain') }}
            </button>
        </div>
    @else
        <form wire:submit="submit" class="space-y-5">
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                <div>
                    <label for="name" class="block text-sm font-medium text-forest-800">{{ __('Nama Lengkap') }}</label>
                    <div class="relative mt-2">
                        <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-charcoal/30">
                            <x-icon name="heroicon-o-user" class="h-4 w-4" />
                        </span>
                        <input type="text" id="name" wire:model="name" placeholder="{{ __('Nama Anda') }}"
                               class="w-full rounded-xl border bg-white py-3 pl-10 pr-4 text-sm text-charcoal shadow-sm transition-colors placeholder:text-charcoal/30 focus:outline-none focus:ring-2 {{ $errors->has('name') ? 'border-red-300 focus:border-red-500 focus:ring-red-500/20' : 'border-forest-200 focus:border-forest-500 focus:ring-forest-500/20' }}">
                    </div>
                    @error('name') <span class="mt-1.5 block text-xs text-red-600">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-forest-800">{{ __('Email') }}</label>
                    <div class="relative mt-2">
                        <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-charcoal/30">
                            <x-icon name="heroicon-o-envelope" class="h-4 w-4" />
                        </span>
                        <input type="email" id="email" wire:model="email" placeholder="{{ __('nama@email.com') }}"
                               class="w-full rounded-xl border bg-white py-3 pl-10 pr-4 text-sm text-charcoal shadow-sm transition-colors placeholder:text-charcoal/30 focus:outline-none focus:ring-2 {{ $errors->has('email') ? 'border-red-300 focus:border-red-500 focus:ring-red-500/20' : 'border-forest-200 focus:border-forest-500 focus:ring-forest-500/20' }}">
                    </div>
                    @error('email') <span class="mt-1.5 block text-xs text-red-600">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                <div>
                    <label for="phone" class="block text-sm font-medium text-forest-800">{{ __('Telepon') }} <span class="text-charcoal/40">{{ __('(opsional)') }}</span></label>
                    <div class="relative mt-2">
                        <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-charcoal/30">
                            <x-icon name="heroicon-o-phone" class="h-4 w-4" />
                        </span>
                        <input type="text" id="phone" wire:model="phone" placeholder="{{ __('08xx xxxx xxxx') }}"
                               class="w-full rounded-xl border bg-white py-3 pl-10 pr-4 text-sm text-charcoal shadow-sm transition-colors placeholder:text-charcoal/30 focus:outline-none focus:ring-2 {{ $errors->has('phone') ? 'border-red-300 focus:border-red-500 focus:ring-red-500/20' : 'border-forest-200 focus:border-forest-500 focus:ring-forest-500/20' }}">
                    </div>
                    @error('phone') <span class="mt-1.5 block text-xs text-red-600">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label for="subject" class="block text-sm font-medium text-forest-800">{{ __('Subjek') }} <span class="text-charcoal/40">{{ __('(opsional)') }}</span></label>
                    <div class="relative mt-2">
                        <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-charcoal/30">
                            <x-icon name="heroicon-o-chat-bubble-left-right" class="h-4 w-4" />
                        </span>
                        <input type="text" id="subject" wire:model="subject" placeholder="{{ __('Topik pesan Anda') }}"
                               class="w-full rounded-xl border bg-white py-3 pl-10 pr-4 text-sm text-charcoal shadow-sm transition-colors placeholder:text-charcoal/30 focus:outline-none focus:ring-2 {{ $errors->has('subject') ? 'border-red-300 focus:border-red-500 focus:ring-red-500/20' : 'border-forest-200 focus:border-forest-500 focus:ring-forest-500/20' }}">
                    </div>
                    @error('subject') <span class="mt-1.5 block text-xs text-red-600">{{ $message }}</span> @enderror
                </div>
            </div>

            <div>
                <label for="message" class="block text-sm font-medium text-forest-800">{{ __('Pesan') }}</label>
                <div class="relative mt-2">
                    <span class="pointer-events-none absolute left-0 top-0 flex items-center pl-3.5 pt-3.5 text-charcoal/30">
                        <x-icon name="heroicon-o-pencil-square" class="h-4 w-4" />
                    </span>
                    <textarea id="message" wire:model="message" rows="5" placeholder="{{ __('Tuliskan kebutuhan riset atau pertanyaan Anda di sini...') }}"
                              class="w-full resize-none rounded-xl border bg-white py-3 pl-10 pr-4 text-sm text-charcoal shadow-sm transition-colors placeholder:text-charcoal/30 focus:outline-none focus:ring-2 {{ $errors->has('message') ? 'border-red-300 focus:border-red-500 focus:ring-red-500/20' : 'border-forest-200 focus:border-forest-500 focus:ring-forest-500/20' }}"></textarea>
                </div>
                @error('message') <span class="mt-1.5 block text-xs text-red-600">{{ $message }}</span> @enderror
            </div>

            <button type="submit"
                    wire:loading.attr="disabled"
                    class="inline-flex items-center gap-2 rounded-full bg-forest-700 px-7 py-3 text-sm font-semibold text-cream shadow-sm transition-all hover:bg-forest-600 hover:shadow-md disabled:opacity-60">
                <span wire:loading.remove class="inline-flex items-center gap-2">
                    {{ __('Kirim Pesan') }}
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3" /></svg>
                </span>
                <span wire:loading>{{ __('Mengirim...') }}</span>
            </button>
        </form>
    @endif
</div>
