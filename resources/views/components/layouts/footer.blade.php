@props(['waveColor' => 'text-cream'])

<footer class="relative overflow-hidden bg-forest-800 text-cream">
    <svg class="pointer-events-none relative z-10 block h-16 w-full {{ $waveColor }} sm:h-24 lg:h-32" viewBox="0 0 1440 100" preserveAspectRatio="none" fill="currentColor" aria-hidden="true">
        <path d="M0,50 C200,195 900,-75 1440,85 L1440,0 L0,0 Z" />
    </svg>

    <x-watermark class="pointer-events-none absolute -bottom-24 -right-24 h-96 w-96 text-forest-700/40" />

    <div class="relative mx-auto max-w-7xl px-6 pt-16 pb-4 lg:px-8">
        <div class="grid grid-cols-1 gap-12 md:grid-cols-2 lg:grid-cols-4">
            <div>
                <x-logo variant="light" />
                <p class="mt-5 max-w-xs text-sm leading-relaxed text-forest-100/80">
                    {{ __('Insight with Precision. Strategy with Impact.') }}
                </p>
                <div class="mt-6 flex items-center gap-4">
                    @if ($settings->instagram_url)
                        <a href="{{ $settings->instagram_url }}" target="_blank" rel="noopener" aria-label="Instagram"
                           class="flex h-9 w-9 items-center justify-center rounded-full border border-forest-600 text-forest-100 transition-colors hover:border-gold-400 hover:text-gold-400">
                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zm0 10.162a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                        </a>
                    @endif
                    @if ($settings->facebook_url)
                        <a href="{{ $settings->facebook_url }}" target="_blank" rel="noopener" aria-label="Facebook"
                           class="flex h-9 w-9 items-center justify-center rounded-full border border-forest-600 text-forest-100 transition-colors hover:border-gold-400 hover:text-gold-400">
                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M22 12.06C22 6.5 17.52 2 12 2S2 6.5 2 12.06c0 5 3.66 9.16 8.44 9.94v-7.03H7.9v-2.91h2.54V9.85c0-2.51 1.49-3.9 3.77-3.9 1.09 0 2.24.2 2.24.2v2.46h-1.26c-1.24 0-1.63.78-1.63 1.57v1.88h2.78l-.44 2.91h-2.34V22c4.78-.78 8.44-4.94 8.44-9.94z"/></svg>
                        </a>
                    @endif
                    @if ($settings->tiktok_url)
                        <a href="{{ $settings->tiktok_url }}" target="_blank" rel="noopener" aria-label="TikTok"
                           class="flex h-9 w-9 items-center justify-center rounded-full border border-forest-600 text-forest-100 transition-colors hover:border-gold-400 hover:text-gold-400">
                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M16.6 5.82c-1.05-.91-1.71-2.24-1.75-3.72h-3.29v14.02c0 1.68-1.37 3.05-3.05 3.05s-3.05-1.37-3.05-3.05 1.37-3.05 3.05-3.05c.33 0 .64.05.94.15v-3.33a6.35 6.35 0 0 0-.94-.07c-3.5 0-6.34 2.84-6.34 6.34S8.5 22.5 12 22.5s6.34-2.84 6.34-6.34V9.01a9.6 9.6 0 0 0 5.64 1.8V7.52c0 0-2.09.09-3.38-1.7z"/></svg>
                        </a>
                    @endif
                    @if ($settings->linkedin_url)
                        <a href="{{ $settings->linkedin_url }}" target="_blank" rel="noopener" aria-label="LinkedIn"
                           class="flex h-9 w-9 items-center justify-center rounded-full border border-forest-600 text-forest-100 transition-colors hover:border-gold-400 hover:text-gold-400">
                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M19 3A2 2 0 0 1 21 5v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14zM8.34 18.34V10H5.67v8.34h2.67zM7 8.9a1.55 1.55 0 1 0 0-3.1 1.55 1.55 0 0 0 0 3.1zm11.34 9.44v-4.6c0-2.46-1.31-3.6-3.06-3.6-1.41 0-2.04.78-2.39 1.32V10h-2.67s.03 7.6 0 8.34h2.67v-4.66c0-.25.02-.5.09-.68.2-.5.66-1.03 1.43-1.03 1.01 0 1.42.77 1.42 1.9v4.47h2.51z"/></svg>
                        </a>
                    @endif
                    @if ($settings->youtube_url)
                        <a href="{{ $settings->youtube_url }}" target="_blank" rel="noopener" aria-label="YouTube"
                           class="flex h-9 w-9 items-center justify-center rounded-full border border-forest-600 text-forest-100 transition-colors hover:border-gold-400 hover:text-gold-400">
                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M23.5 6.19a3.02 3.02 0 0 0-2.12-2.14C19.51 3.5 12 3.5 12 3.5s-7.51 0-9.38.55A3.02 3.02 0 0 0 .5 6.19 31.6 31.6 0 0 0 0 12a31.6 31.6 0 0 0 .5 5.81 3.02 3.02 0 0 0 2.12 2.14C4.49 20.5 12 20.5 12 20.5s7.51 0 9.38-.55a3.02 3.02 0 0 0 2.12-2.14A31.6 31.6 0 0 0 24 12a31.6 31.6 0 0 0-.5-5.81zM9.6 15.5v-7l6.27 3.5-6.27 3.5z"/></svg>
                        </a>
                    @endif
                    <a href="mailto:{{ $settings->email }}" aria-label="Email"
                       class="flex h-9 w-9 items-center justify-center rounded-full border border-forest-600 text-forest-100 transition-colors hover:border-gold-400 hover:text-gold-400">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.25 6.75c0-.966.784-1.75 1.75-1.75h16c.966 0 1.75.784 1.75 1.75v10.5A1.75 1.75 0 0119.999 19h-16a1.75 1.75 0 01-1.75-1.75V6.75zm1.5.25v.25l8.25 5.5 8.25-5.5V7l-8.25 5.5L3.75 7z" /></svg>
                    </a>
                </div>
            </div>

            <div>
                <h3 class="text-sm font-semibold uppercase tracking-wider text-gold-400">{{ __('Perusahaan') }}</h3>
                <ul class="mt-5 space-y-3 text-sm text-forest-100/80">
                    <li><a href="{{ route('about') }}" class="transition-colors hover:text-gold-300">{{ __('Tentang Kami') }}</a></li>
                    <li><a href="{{ route('core-values') }}" class="transition-colors hover:text-gold-300">{{ __('Core Values') }}</a></li>
                    <li><a href="{{ route('vision') }}" class="transition-colors hover:text-gold-300">{{ __('Visi & Misi') }}</a></li>
                    <li><a href="{{ route('team') }}" class="transition-colors hover:text-gold-300">{{ __('Tim Kami') }}</a></li>
                </ul>
            </div>

            <div>
                <h3 class="text-sm font-semibold uppercase tracking-wider text-gold-400">{{ __('Layanan & Riset') }}</h3>
                <ul class="mt-5 space-y-3 text-sm text-forest-100/80">
                    <li><a href="{{ route('services.index') }}" class="transition-colors hover:text-gold-300">{{ __('Layanan') }}</a></li>
                    <li><a href="{{ route('research.index') }}" class="transition-colors hover:text-gold-300">{{ __('Riset') }}</a></li>
                    <li><a href="{{ route('op-ed.index') }}" class="transition-colors hover:text-gold-300">{{ __('Op-Ed') }}</a></li>
                    <li><a href="{{ route('newsletter.index') }}" class="transition-colors hover:text-gold-300">{{ __('Newsletter') }}</a></li>
                </ul>
            </div>

            <div>
                <h3 class="text-sm font-semibold uppercase tracking-wider text-gold-400">{{ __('Kontak') }}</h3>
                <ul class="mt-5 space-y-3 text-sm text-forest-100/80">
                    <li>{!! nl2br(e($settings->address)) !!}</li>
                    <li><a href="mailto:{{ $settings->email }}" class="transition-colors hover:text-gold-300">{{ $settings->email }}</a></li>
                    <li><a href="tel:+{{ $settings->phone_digits }}" class="transition-colors hover:text-gold-300">{{ $settings->phone }}</a></li>
                </ul>
            </div>
        </div>

        <div class="mt-14 flex flex-col items-center justify-between gap-4 border-t border-forest-700 pt-8 text-xs text-forest-100/60 md:flex-row">
            <p>&copy; {{ now()->year }} Atom Visi Indonesia. {{ __('Seluruh hak cipta dilindungi.') }}</p>
            <p>{{ __('Built by') }} Aksa Technology</p>
        </div>
    </div>
</footer>
