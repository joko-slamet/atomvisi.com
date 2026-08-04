<div>
    @if ($sent)
        <div class="rounded-2xl border border-forest-200 bg-forest-50 p-8 text-center" data-aos="fade-up">
            <svg class="mx-auto h-12 w-12 text-forest-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            <h3 class="mt-4 font-serif text-xl font-semibold text-forest-800">Pesan Terkirim</h3>
            <p class="mt-2 text-sm text-charcoal/70">Terima kasih telah menghubungi kami. Tim kami akan segera merespons pesan Anda.</p>
            <button type="button" wire:click="$set('sent', false)" class="mt-6 text-sm font-semibold text-forest-700 hover:text-gold-600">
                Kirim pesan lain
            </button>
        </div>
    @else
        <form wire:submit="submit" class="space-y-5">
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                <div>
                    <label for="name" class="block text-sm font-medium text-forest-800">Nama Lengkap</label>
                    <input type="text" id="name" wire:model="name"
                           class="mt-2 w-full rounded-lg border-forest-200 bg-white text-sm text-charcoal shadow-sm focus:border-forest-500 focus:ring-forest-500">
                    @error('name') <span class="mt-1 block text-xs text-red-600">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-forest-800">Email</label>
                    <input type="email" id="email" wire:model="email"
                           class="mt-2 w-full rounded-lg border-forest-200 bg-white text-sm text-charcoal shadow-sm focus:border-forest-500 focus:ring-forest-500">
                    @error('email') <span class="mt-1 block text-xs text-red-600">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                <div>
                    <label for="phone" class="block text-sm font-medium text-forest-800">Telepon <span class="text-charcoal/40">(opsional)</span></label>
                    <input type="text" id="phone" wire:model="phone"
                           class="mt-2 w-full rounded-lg border-forest-200 bg-white text-sm text-charcoal shadow-sm focus:border-forest-500 focus:ring-forest-500">
                    @error('phone') <span class="mt-1 block text-xs text-red-600">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label for="subject" class="block text-sm font-medium text-forest-800">Subjek <span class="text-charcoal/40">(opsional)</span></label>
                    <input type="text" id="subject" wire:model="subject"
                           class="mt-2 w-full rounded-lg border-forest-200 bg-white text-sm text-charcoal shadow-sm focus:border-forest-500 focus:ring-forest-500">
                    @error('subject') <span class="mt-1 block text-xs text-red-600">{{ $message }}</span> @enderror
                </div>
            </div>

            <div>
                <label for="message" class="block text-sm font-medium text-forest-800">Pesan</label>
                <textarea id="message" wire:model="message" rows="5"
                          class="mt-2 w-full rounded-lg border-forest-200 bg-white text-sm text-charcoal shadow-sm focus:border-forest-500 focus:ring-forest-500"></textarea>
                @error('message') <span class="mt-1 block text-xs text-red-600">{{ $message }}</span> @enderror
            </div>

            <button type="submit"
                    wire:loading.attr="disabled"
                    class="inline-flex items-center gap-2 rounded-full bg-forest-700 px-7 py-3 text-sm font-semibold text-cream shadow-sm transition-all hover:bg-forest-600 hover:shadow-md disabled:opacity-60">
                <span wire:loading.remove>Kirim Pesan</span>
                <span wire:loading>Mengirim...</span>
            </button>
        </form>
    @endif
</div>
