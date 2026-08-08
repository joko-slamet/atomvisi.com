<header
    x-data="{ mobileOpen: false, dropdown: null, scrollProgress: 0 }"
    x-init="
        const onScroll = () => {
            const max = document.documentElement.scrollHeight - window.innerHeight;
            scrollProgress = max > 0 ? Math.min(window.scrollY / max, 1) : 0;
        };
        onScroll();
        window.addEventListener('scroll', onScroll);
        window.addEventListener('resize', onScroll);
    "
    class="fixed inset-x-0 top-0 z-50"
>
    {{-- Scroll progress line --}}
    <div class="absolute inset-x-0 top-0 h-0.5 origin-left bg-gold-500" :style="`transform: scaleX(${scrollProgress})`"></div>

    <div class="mx-auto max-w-7xl px-4 pt-5 sm:px-6 lg:px-8">
        <nav aria-label="{{ __('Navigasi utama') }}"
             class="flex items-center justify-between gap-4 rounded-full border border-forest-100/60 bg-cream/95 py-2.5 pl-4 pr-2.5 shadow-lg shadow-forest-900/[0.06] backdrop-blur-md">
            <div>
                <x-logo variant="dark" />
            </div>

            <div class="hidden items-center gap-1 lg:flex">
                <a href="{{ route('home') }}" class="rounded-full px-4 py-2 text-sm font-medium text-charcoal transition-colors hover:bg-forest-50 hover:text-forest-700">
                    {{ __('Home') }}
                </a>

                <div class="relative" @mouseenter="dropdown = 'about'" @mouseleave="dropdown = null">
                    <button type="button" class="flex items-center gap-1 rounded-full px-4 py-2 text-sm font-medium text-charcoal transition-colors hover:bg-forest-50 hover:text-forest-700">
                        {{ __('Tentang') }}
                        <svg class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" /></svg>
                    </button>
                    <div x-show="dropdown === 'about'" x-transition.opacity.duration.150ms
                         class="absolute left-1/2 top-full w-56 -translate-x-1/2 pt-3" style="display: none;">
                        <div class="rounded-2xl border border-forest-100 bg-white p-2 shadow-lg shadow-forest-900/5">
                            <a href="{{ route('about') }}" class="block rounded-xl px-4 py-2.5 text-sm text-charcoal hover:bg-forest-50 hover:text-forest-700">{{ __('Tentang Kami') }}</a>
                            <a href="{{ route('core-values') }}" class="block rounded-xl px-4 py-2.5 text-sm text-charcoal hover:bg-forest-50 hover:text-forest-700">{{ __('Core Values') }}</a>
                            <a href="{{ route('vision') }}" class="block rounded-xl px-4 py-2.5 text-sm text-charcoal hover:bg-forest-50 hover:text-forest-700">{{ __('Visi & Misi') }}</a>
                            <a href="{{ route('team') }}" class="block rounded-xl px-4 py-2.5 text-sm text-charcoal hover:bg-forest-50 hover:text-forest-700">{{ __('Tim Kami') }}</a>
                        </div>
                    </div>
                </div>

                <a href="{{ route('services.index') }}" class="rounded-full px-4 py-2 text-sm font-medium text-charcoal transition-colors hover:bg-forest-50 hover:text-forest-700">
                    {{ __('Layanan') }}
                </a>

                <a href="{{ route('research.index') }}" class="rounded-full px-4 py-2 text-sm font-medium text-charcoal transition-colors hover:bg-forest-50 hover:text-forest-700">
                    {{ __('Riset') }}
                </a>

                <div class="relative" @mouseenter="dropdown = 'insight'" @mouseleave="dropdown = null">
                    <button type="button" class="flex items-center gap-1 rounded-full px-4 py-2 text-sm font-medium text-charcoal transition-colors hover:bg-forest-50 hover:text-forest-700">
                        {{ __('Insight') }}
                        <svg class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" /></svg>
                    </button>
                    <div x-show="dropdown === 'insight'" x-transition.opacity.duration.150ms
                         class="absolute left-1/2 top-full w-56 -translate-x-1/2 pt-3" style="display: none;">
                        <div class="rounded-2xl border border-forest-100 bg-white p-2 shadow-lg shadow-forest-900/5">
                            <a href="{{ route('articles.index') }}" class="block rounded-xl px-4 py-2.5 text-sm text-charcoal hover:bg-forest-50 hover:text-forest-700">{{ __('Artikel') }}</a>
                            <a href="{{ route('op-ed.index') }}" class="block rounded-xl px-4 py-2.5 text-sm text-charcoal hover:bg-forest-50 hover:text-forest-700">{{ __('Op-Ed') }}</a>
                            <a href="{{ route('newsletter.index') }}" class="block rounded-xl px-4 py-2.5 text-sm text-charcoal hover:bg-forest-50 hover:text-forest-700">{{ __('Newsletter') }}</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <x-language-switcher class="text-charcoal hover:bg-forest-50 hover:text-forest-700" />

                <a href="{{ route('contact') }}"
                   class="hidden rounded-full bg-gold-500 px-5 py-2.5 text-sm font-semibold text-forest-900 shadow-sm transition-all hover:bg-gold-400 hover:shadow-md sm:inline-flex">
                    {{ __('Hubungi Kami') }}
                </a>

                <button type="button" @click="mobileOpen = !mobileOpen"
                        class="inline-flex h-10 w-10 items-center justify-center rounded-full text-forest-800 transition-colors hover:bg-forest-50 lg:hidden"
                        aria-label="{{ __('Buka menu') }}" :aria-expanded="mobileOpen">
                    <svg x-show="!mobileOpen" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3.75 6.75h16.5M3.75 12h16.5M3.75 17.25h16.5" /></svg>
                    <svg x-show="mobileOpen" style="display:none" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>
        </nav>

        {{-- Mobile dropdown panel --}}
        <div x-show="mobileOpen" x-transition
             class="mt-2 rounded-3xl border border-forest-100/60 bg-cream/95 p-4 shadow-lg shadow-forest-900/[0.06] backdrop-blur-md lg:hidden"
             style="display: none;">
            <div class="flex flex-col gap-1">
                <a href="{{ route('home') }}" class="rounded-xl px-3 py-2.5 text-sm font-medium text-charcoal hover:bg-forest-50">{{ __('Home') }}</a>
                <a href="{{ route('about') }}" class="rounded-xl px-3 py-2.5 text-sm font-medium text-charcoal hover:bg-forest-50">{{ __('Tentang Kami') }}</a>
                <a href="{{ route('core-values') }}" class="rounded-xl px-3 py-2.5 text-sm font-medium text-charcoal hover:bg-forest-50">{{ __('Core Values') }}</a>
                <a href="{{ route('vision') }}" class="rounded-xl px-3 py-2.5 text-sm font-medium text-charcoal hover:bg-forest-50">{{ __('Visi & Misi') }}</a>
                <a href="{{ route('team') }}" class="rounded-xl px-3 py-2.5 text-sm font-medium text-charcoal hover:bg-forest-50">{{ __('Tim Kami') }}</a>
                <a href="{{ route('services.index') }}" class="rounded-xl px-3 py-2.5 text-sm font-medium text-charcoal hover:bg-forest-50">{{ __('Layanan') }}</a>
                <a href="{{ route('research.index') }}" class="rounded-xl px-3 py-2.5 text-sm font-medium text-charcoal hover:bg-forest-50">{{ __('Riset') }}</a>
                <a href="{{ route('articles.index') }}" class="rounded-xl px-3 py-2.5 text-sm font-medium text-charcoal hover:bg-forest-50">{{ __('Artikel') }}</a>
                <a href="{{ route('op-ed.index') }}" class="rounded-xl px-3 py-2.5 text-sm font-medium text-charcoal hover:bg-forest-50">{{ __('Op-Ed') }}</a>
                <a href="{{ route('newsletter.index') }}" class="rounded-xl px-3 py-2.5 text-sm font-medium text-charcoal hover:bg-forest-50">{{ __('Newsletter') }}</a>
                <x-language-switcher class="!h-auto justify-center rounded-xl px-3 py-2.5 text-charcoal hover:bg-forest-50" />
                <a href="{{ route('contact') }}" class="mt-2 rounded-full bg-gold-500 px-4 py-2.5 text-center text-sm font-semibold text-forest-900">{{ __('Hubungi Kami') }}</a>
            </div>
        </div>
    </div>
</header>
