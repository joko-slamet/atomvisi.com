<x-layouts.app title="{{ __('Tim Kami') }}">
    <x-page-hero
        kicker="{{ __('Tim Kami') }}"
        title="{{ __('Peneliti & Analis di Balik Setiap Kajian') }}"
        description="{{ __('Ditopang oleh individu-individu dengan latar belakang akademik dan pengalaman praktis di bidang kebijakan publik, politik, dan riset sosial.') }}"
    />

    <section class="bg-cream py-24 sm:py-32">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($members as $index => $member)
                    <div data-aos="fade-up" data-aos-delay="{{ ($index % 3) * 100 }}"
                         class="group overflow-hidden rounded-2xl border border-forest-100 bg-white transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-forest-900/10">
                        <div class="aspect-square w-full overflow-hidden bg-forest-100">
                            @if ($member->photo)
                                <img src="{{ asset('storage/'.$member->photo) }}" alt="{{ $member->name }}" loading="lazy"
                                     class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105">
                            @else
                                <div class="flex h-full w-full items-center justify-center bg-gradient-to-br from-forest-600 to-forest-800">
                                    <span class="font-serif text-4xl font-semibold text-cream/70">
                                        {{ collect(explode(' ', $member->name))->map(fn ($w) => $w[0])->take(2)->implode('') }}
                                    </span>
                                </div>
                            @endif
                        </div>
                        <div class="p-6">
                            <h3 class="font-serif text-lg font-semibold text-forest-800">{{ $member->name }}</h3>
                            <p class="mt-1 text-sm font-medium text-gold-600">{{ $member->role }}</p>
                            @if ($member->bio)
                                <p class="mt-3 line-clamp-3 text-sm leading-relaxed text-charcoal/70">{{ $member->bio }}</p>
                            @endif
                            @if ($member->linkedin_url)
                                <a href="{{ $member->linkedin_url }}" target="_blank" rel="noopener"
                                   class="mt-4 inline-flex items-center gap-1.5 text-xs font-semibold text-forest-700 hover:text-gold-600">
                                    {{ __('LinkedIn') }}
                                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3" /></svg>
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</x-layouts.app>
