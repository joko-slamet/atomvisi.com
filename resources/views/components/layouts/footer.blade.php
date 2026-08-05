<footer class="relative overflow-hidden bg-forest-800 text-cream">
    <svg class="pointer-events-none relative z-10 block h-16 w-full text-cream sm:h-24 lg:h-32" viewBox="0 0 1440 100" preserveAspectRatio="none" fill="currentColor" aria-hidden="true">
        <path d="M0,50 C200,195 900,-75 1440,85 L1440,0 L0,0 Z" />
    </svg>

    <x-watermark class="pointer-events-none absolute -bottom-24 -right-24 h-96 w-96 text-forest-700/40" />

    <div class="relative mx-auto max-w-7xl px-6 py-16 lg:px-8">
        <div class="grid grid-cols-1 gap-12 md:grid-cols-2 lg:grid-cols-4">
            <div>
                <x-logo variant="light" />
                <p class="mt-5 max-w-xs text-sm leading-relaxed text-forest-100/80">
                    Insight with Precision. Strategy with Impact.
                </p>
                <div class="mt-6 flex items-center gap-4">
                    <a href="https://instagram.com" target="_blank" rel="noopener" aria-label="Instagram"
                       class="flex h-9 w-9 items-center justify-center rounded-full border border-forest-600 text-forest-100 transition-colors hover:border-gold-400 hover:text-gold-400">
                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zm0 10.162a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                    </a>
                    <a href="mailto:info@atomvisi.com" aria-label="Email"
                       class="flex h-9 w-9 items-center justify-center rounded-full border border-forest-600 text-forest-100 transition-colors hover:border-gold-400 hover:text-gold-400">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.25 6.75c0-.966.784-1.75 1.75-1.75h16c.966 0 1.75.784 1.75 1.75v10.5A1.75 1.75 0 0119.999 19h-16a1.75 1.75 0 01-1.75-1.75V6.75zm1.5.25v.25l8.25 5.5 8.25-5.5V7l-8.25 5.5L3.75 7z" /></svg>
                    </a>
                </div>
            </div>

            <div>
                <h3 class="text-sm font-semibold uppercase tracking-wider text-gold-400">Perusahaan</h3>
                <ul class="mt-5 space-y-3 text-sm text-forest-100/80">
                    <li><a href="{{ route('about') }}" class="transition-colors hover:text-gold-300">Tentang Kami</a></li>
                    <li><a href="{{ route('core-values') }}" class="transition-colors hover:text-gold-300">Core Values</a></li>
                    <li><a href="{{ route('vision') }}" class="transition-colors hover:text-gold-300">Visi &amp; Misi</a></li>
                    <li><a href="{{ route('team') }}" class="transition-colors hover:text-gold-300">Tim Kami</a></li>
                </ul>
            </div>

            <div>
                <h3 class="text-sm font-semibold uppercase tracking-wider text-gold-400">Layanan &amp; Riset</h3>
                <ul class="mt-5 space-y-3 text-sm text-forest-100/80">
                    <li><a href="{{ route('services.index') }}" class="transition-colors hover:text-gold-300">Layanan</a></li>
                    <li><a href="{{ route('research.index') }}" class="transition-colors hover:text-gold-300">Riset</a></li>
                    <li><a href="{{ route('op-ed.index') }}" class="transition-colors hover:text-gold-300">Op-Ed</a></li>
                    <li><a href="{{ route('newsletter.index') }}" class="transition-colors hover:text-gold-300">Newsletter</a></li>
                </ul>
            </div>

            <div>
                <h3 class="text-sm font-semibold uppercase tracking-wider text-gold-400">Kontak</h3>
                <ul class="mt-5 space-y-3 text-sm text-forest-100/80">
                    <li>Setiabudi 2 Building,<br>Kuningan, Jakarta Selatan</li>
                    <li><a href="mailto:info@atomvisi.com" class="transition-colors hover:text-gold-300">info@atomvisi.com</a></li>
                    <li><a href="tel:+622100000000" class="transition-colors hover:text-gold-300">+62 21 0000 0000</a></li>
                </ul>
            </div>
        </div>

        <div class="mt-14 flex flex-col items-center justify-between gap-4 border-t border-forest-700 pt-8 text-xs text-forest-100/60 md:flex-row">
            <p>&copy; {{ now()->year }} Atom Visi Indonesia. Seluruh hak cipta dilindungi.</p>
            <p class="italic">Insight with Precision. Strategy with Impact.</p>
        </div>
    </div>
</footer>
