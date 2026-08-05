@props([
    'heading' => null,
    'subheading' => null,
])

@php
    $livewire ??= null;
@endphp

@push('styles')
    @fonts
    @vite(['resources/css/app.css'])
@endpush

<x-filament-panels::layout.base :livewire="$livewire">
    <div class="relative flex min-h-screen font-sans">
        {{-- Branded panel --}}
        <div class="relative hidden w-1/2 flex-col justify-between overflow-hidden bg-gradient-to-br from-forest-900 via-forest-800 to-forest-700 p-12 lg:flex">
            <div class="pointer-events-none absolute inset-0">
                <div class="absolute inset-0 bg-noise opacity-[0.05] mix-blend-overlay"></div>
                <div class="absolute inset-0 bg-dot-grid text-cream/[0.06]"></div>
                <div class="animate-drift-slow absolute -left-24 top-1/4 h-96 w-96 rounded-full bg-gold-500/10 blur-3xl"></div>
                <x-watermark class="absolute -bottom-24 -right-24 h-96 w-96 text-forest-600/30" />
            </div>

            <div class="relative">
                <x-logo variant="light" />
            </div>

            <div class="relative max-w-md">
                <span class="inline-flex items-center gap-2 rounded-full border border-gold-400/30 bg-gold-400/10 px-4 py-1.5 text-xs font-semibold uppercase tracking-[0.2em] text-gold-300">
                    Admin Panel
                </span>
                <h1 class="mt-6 font-serif text-4xl font-semibold leading-tight text-cream">
                    Insight with <span class="text-gold-400">Precision</span>.
                    Strategy with <span class="text-gold-400">Impact</span>.
                </h1>
                <p class="mt-4 text-sm leading-relaxed text-forest-100/70">
                    Kelola artikel, riset, layanan, dan seluruh konten Atom Visi Indonesia dari satu tempat.
                </p>
            </div>

            <p class="relative text-xs text-forest-100/50">
                &copy; {{ now()->year }} Atom Visi Indonesia. Seluruh hak cipta dilindungi.
            </p>
        </div>

        {{-- Form panel --}}
        <div class="flex w-full flex-col items-center justify-center bg-cream px-6 py-16 lg:w-1/2">
            <div class="w-full max-w-md">
                <div class="mb-6 lg:hidden">
                    <x-logo />
                </div>

                <h2 class="font-serif text-3xl font-semibold text-forest-800">
                    Selamat Datang Kembali
                </h2>
                <p class="mt-2 text-sm text-charcoal/60">
                    Masuk untuk mengelola konten Atom Visi Indonesia.
                </p>

                <div class="mt-8">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>
</x-filament-panels::layout.base>
