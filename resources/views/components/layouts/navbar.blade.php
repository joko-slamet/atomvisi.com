<header
    x-data="{ scrolled: false, mobileOpen: false, dropdown: null }"
    x-init="scrolled = window.scrollY > 40; window.addEventListener('scroll', () => scrolled = window.scrollY > 40)"
    class="fixed inset-x-0 top-0 z-50 transition-colors duration-300"
    :class="scrolled || mobileOpen ? 'bg-cream/95 backdrop-blur-md shadow-sm' : 'bg-transparent'"
>
    <nav class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4 lg:px-8" aria-label="Navigasi utama">
        <div class="flex items-center">
            <template x-if="scrolled || mobileOpen">
                <x-logo variant="dark" />
            </template>
            <template x-if="!(scrolled || mobileOpen)">
                <x-logo variant="light" />
            </template>
        </div>

        <div class="hidden items-center gap-8 lg:flex">
            <a href="{{ route('home') }}"
               class="text-sm font-medium transition-colors"
               :class="scrolled ? 'text-charcoal hover:text-forest-700' : 'text-cream hover:text-gold-300'">
                Home
            </a>

            <div class="relative" @mouseenter="dropdown = 'about'" @mouseleave="dropdown = null">
                <button type="button"
                        class="flex items-center gap-1 text-sm font-medium transition-colors"
                        :class="scrolled ? 'text-charcoal hover:text-forest-700' : 'text-cream hover:text-gold-300'">
                    Tentang
                    <svg class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" /></svg>
                </button>
                <div x-show="dropdown === 'about'" x-transition.opacity.duration.150ms
                     class="absolute left-1/2 top-full w-56 -translate-x-1/2 pt-3" style="display: none;">
                    <div class="rounded-xl border border-forest-100 bg-white p-2 shadow-lg shadow-forest-900/5">
                        <a href="{{ route('about') }}" class="block rounded-lg px-4 py-2.5 text-sm text-charcoal hover:bg-forest-50 hover:text-forest-700">Tentang Kami</a>
                        <a href="{{ route('core-values') }}" class="block rounded-lg px-4 py-2.5 text-sm text-charcoal hover:bg-forest-50 hover:text-forest-700">Core Values</a>
                        <a href="{{ route('vision') }}" class="block rounded-lg px-4 py-2.5 text-sm text-charcoal hover:bg-forest-50 hover:text-forest-700">Visi &amp; Misi</a>
                        <a href="{{ route('team') }}" class="block rounded-lg px-4 py-2.5 text-sm text-charcoal hover:bg-forest-50 hover:text-forest-700">Tim Kami</a>
                    </div>
                </div>
            </div>

            <a href="{{ route('services.index') }}"
               class="text-sm font-medium transition-colors"
               :class="scrolled ? 'text-charcoal hover:text-forest-700' : 'text-cream hover:text-gold-300'">
                Layanan
            </a>

            <a href="{{ route('research.index') }}"
               class="text-sm font-medium transition-colors"
               :class="scrolled ? 'text-charcoal hover:text-forest-700' : 'text-cream hover:text-gold-300'">
                Riset
            </a>

            <div class="relative" @mouseenter="dropdown = 'insight'" @mouseleave="dropdown = null">
                <button type="button"
                        class="flex items-center gap-1 text-sm font-medium transition-colors"
                        :class="scrolled ? 'text-charcoal hover:text-forest-700' : 'text-cream hover:text-gold-300'">
                    Insight
                    <svg class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" /></svg>
                </button>
                <div x-show="dropdown === 'insight'" x-transition.opacity.duration.150ms
                     class="absolute left-1/2 top-full w-56 -translate-x-1/2 pt-3" style="display: none;">
                    <div class="rounded-xl border border-forest-100 bg-white p-2 shadow-lg shadow-forest-900/5">
                        <a href="{{ route('articles.index') }}" class="block rounded-lg px-4 py-2.5 text-sm text-charcoal hover:bg-forest-50 hover:text-forest-700">Artikel</a>
                        <a href="{{ route('op-ed.index') }}" class="block rounded-lg px-4 py-2.5 text-sm text-charcoal hover:bg-forest-50 hover:text-forest-700">Op-Ed</a>
                        <a href="{{ route('newsletter.index') }}" class="block rounded-lg px-4 py-2.5 text-sm text-charcoal hover:bg-forest-50 hover:text-forest-700">Newsletter</a>
                    </div>
                </div>
            </div>

            <a href="{{ route('contact') }}"
               class="rounded-full bg-gold-500 px-5 py-2.5 text-sm font-semibold text-forest-900 shadow-sm transition-all hover:bg-gold-400 hover:shadow-md">
                Hubungi Kami
            </a>
        </div>

        <button type="button" @click="mobileOpen = !mobileOpen"
                class="inline-flex items-center justify-center rounded-md p-2 lg:hidden"
                :class="scrolled || mobileOpen ? 'text-forest-800' : 'text-cream'"
                aria-label="Buka menu">
            <svg x-show="!mobileOpen" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3.75 6.75h16.5M3.75 12h16.5M3.75 17.25h16.5" /></svg>
            <svg x-show="mobileOpen" style="display:none" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M6 18L18 6M6 6l12 12" /></svg>
        </button>
    </nav>

    <div x-show="mobileOpen" x-transition class="border-t border-forest-100 bg-cream px-6 py-4 lg:hidden" style="display:none">
        <div class="flex flex-col gap-1">
            <a href="{{ route('home') }}" class="rounded-lg px-3 py-2.5 text-sm font-medium text-charcoal hover:bg-forest-50">Home</a>
            <a href="{{ route('about') }}" class="rounded-lg px-3 py-2.5 text-sm font-medium text-charcoal hover:bg-forest-50">Tentang Kami</a>
            <a href="{{ route('core-values') }}" class="rounded-lg px-3 py-2.5 text-sm font-medium text-charcoal hover:bg-forest-50">Core Values</a>
            <a href="{{ route('vision') }}" class="rounded-lg px-3 py-2.5 text-sm font-medium text-charcoal hover:bg-forest-50">Visi &amp; Misi</a>
            <a href="{{ route('team') }}" class="rounded-lg px-3 py-2.5 text-sm font-medium text-charcoal hover:bg-forest-50">Tim Kami</a>
            <a href="{{ route('services.index') }}" class="rounded-lg px-3 py-2.5 text-sm font-medium text-charcoal hover:bg-forest-50">Layanan</a>
            <a href="{{ route('research.index') }}" class="rounded-lg px-3 py-2.5 text-sm font-medium text-charcoal hover:bg-forest-50">Riset</a>
            <a href="{{ route('articles.index') }}" class="rounded-lg px-3 py-2.5 text-sm font-medium text-charcoal hover:bg-forest-50">Artikel</a>
            <a href="{{ route('op-ed.index') }}" class="rounded-lg px-3 py-2.5 text-sm font-medium text-charcoal hover:bg-forest-50">Op-Ed</a>
            <a href="{{ route('newsletter.index') }}" class="rounded-lg px-3 py-2.5 text-sm font-medium text-charcoal hover:bg-forest-50">Newsletter</a>
            <a href="{{ route('contact') }}" class="mt-2 rounded-full bg-gold-500 px-4 py-2.5 text-center text-sm font-semibold text-forest-900">Hubungi Kami</a>
        </div>
    </div>
</header>
