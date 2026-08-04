<div>
    @if ($subscribed)
        <p class="flex items-center gap-2 text-sm font-medium text-gold-300">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            Terima kasih! Anda telah berlangganan newsletter kami.
        </p>
    @else
        <form wire:submit="submit" class="flex flex-col gap-3 sm:flex-row sm:items-start">
            <div class="flex-1">
                <label for="newsletter-email" class="sr-only">Alamat email</label>
                <input type="email" id="newsletter-email" wire:model="email" placeholder="Alamat email Anda"
                       class="w-full rounded-full border-forest-600 bg-forest-800/60 px-5 py-3 text-sm text-cream placeholder:text-forest-100/50 focus:border-gold-400 focus:ring-gold-400">
                @error('email') <span class="mt-2 block px-2 text-xs text-gold-300">{{ $message }}</span> @enderror
            </div>
            <button type="submit"
                    wire:loading.attr="disabled"
                    class="inline-flex shrink-0 items-center justify-center gap-2 rounded-full bg-gold-500 px-6 py-3 text-sm font-semibold text-forest-900 shadow-sm transition-all hover:bg-gold-400 disabled:opacity-60">
                <span wire:loading.remove>Subscribe</span>
                <span wire:loading>...</span>
            </button>
        </form>
    @endif
</div>
