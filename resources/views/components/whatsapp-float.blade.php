@props([])

@php
    $waPhone = $settings->phone_digits;
    $waMessage = $settings->whatsapp_message ?: 'Halo, saya ingin bertanya tentang layanan Atom Visi Indonesia.';
@endphp

<a href="https://wa.me/{{ $waPhone }}?text={{ urlencode($waMessage) }}"
   target="_blank"
   rel="noopener"
   aria-label="Chat via WhatsApp"
   class="group fixed bottom-6 right-6 z-50 flex h-14 w-14 items-center justify-center rounded-full bg-[#25D366] text-white shadow-lg shadow-forest-900/20 transition-transform duration-300 hover:scale-110">
    <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-[#25D366] opacity-40"></span>
    <svg class="relative h-7 w-7" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
        <path d="M12.04 2c-5.52 0-10 4.48-10 10 0 1.76.46 3.48 1.34 5L2 22l5.16-1.35a9.96 9.96 0 0 0 4.88 1.24h.01c5.52 0 10-4.48 10-10s-4.48-9.89-10.01-9.89zm0 18.18h-.01a8.2 8.2 0 0 1-4.18-1.15l-.3-.18-3.06.8.82-2.98-.2-.31a8.18 8.18 0 0 1-1.26-4.36c0-4.52 3.68-8.2 8.2-8.2 2.19 0 4.25.85 5.79 2.4a8.13 8.13 0 0 1 2.4 5.8c0 4.52-3.69 8.18-8.2 8.18zm4.49-6.14c-.24-.12-1.45-.72-1.68-.8-.22-.08-.39-.12-.55.12-.16.24-.63.8-.78.97-.14.16-.29.18-.53.06-.24-.12-1.02-.38-1.94-1.2-.72-.64-1.2-1.43-1.35-1.67-.14-.24-.02-.37.11-.49.11-.11.24-.29.36-.43.12-.14.16-.24.24-.4.08-.16.04-.3-.02-.42-.06-.12-.55-1.32-.75-1.81-.2-.48-.4-.41-.55-.42-.14-.01-.3-.01-.46-.01-.16 0-.42.06-.64.3-.22.24-.84.82-.84 2s.86 2.32.98 2.48c.12.16 1.7 2.6 4.13 3.64.58.25 1.03.4 1.38.51.58.18 1.11.16 1.53.1.47-.07 1.45-.59 1.65-1.16.2-.57.2-1.06.14-1.16-.06-.1-.22-.16-.46-.28z"/>
    </svg>
</a>
