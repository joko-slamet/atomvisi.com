<x-layouts.app title="{{ __('Riset') }}">
    <x-page-hero
        kicker="{{ __('Riset') }}"
        title="{{ __('Portofolio Riset & Kajian Kami') }}"
        description="{{ __('Kumpulan hasil riset, kajian, dan survey yang telah kami laksanakan bersama berbagai mitra institusi.') }}"
    />

    <section class="bg-cream py-24 sm:py-32">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            @if ($featured->isNotEmpty())
                <div class="mb-16">
                    <span data-aos="fade-up" class="text-xs font-semibold uppercase tracking-[0.25em] text-gold-600">{{ __('Riset Unggulan') }}</span>
                    <div class="mt-8 grid grid-cols-1 gap-6 lg:grid-cols-3">
                        @foreach ($featured as $index => $project)
                            <a href="{{ route('research.show', $project) }}" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}"
                               class="group flex flex-col overflow-hidden rounded-2xl border border-forest-100 bg-white transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-forest-900/10">
                                <div class="aspect-[16/10] w-full overflow-hidden bg-forest-100">
                                    @if ($project->featured_image)
                                        <img src="{{ asset('storage/'.$project->featured_image) }}" alt="{{ $project->title }}" loading="lazy"
                                             class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105">
                                    @else
                                        <div class="flex h-full w-full items-center justify-center bg-gradient-to-br from-forest-600 to-forest-800">
                                            <x-logo-watermark class="h-14 w-14 text-cream/20" />
                                        </div>
                                    @endif
                                </div>
                                <div class="flex flex-1 flex-col p-6">
                                    <span class="text-xs font-semibold uppercase tracking-wider text-gold-600">{{ $project->category?->name }} &middot; {{ $project->year }}</span>
                                    <h3 class="mt-2 font-sans text-lg font-semibold leading-snug text-forest-800">{{ $project->title }}</h3>
                                    <p class="mt-2 line-clamp-2 flex-1 text-sm text-charcoal/70">{{ $project->summary }}</p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            <span data-aos="fade-up" class="text-xs font-semibold uppercase tracking-[0.25em] text-gold-600">{{ __('Seluruh Riset') }}</span>
            <div class="mt-8 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($projects as $index => $project)
                    <a href="{{ route('research.show', $project) }}" data-aos="fade-up" data-aos-delay="{{ ($index % 3) * 100 }}"
                       class="group rounded-2xl border border-forest-100 bg-white p-6 transition-all duration-300 hover:-translate-y-1 hover:shadow-lg hover:shadow-forest-900/10">
                        <span class="text-xs font-semibold uppercase tracking-wider text-gold-600">{{ $project->category?->name }} &middot; {{ $project->year }}</span>
                        <h3 class="mt-2 font-sans text-base font-semibold leading-snug text-forest-800 group-hover:text-forest-600">{{ $project->title }}</h3>
                        <p class="mt-2 line-clamp-2 text-sm text-charcoal/70">{{ $project->summary }}</p>
                        @if ($project->client)
                            <p class="mt-3 text-xs text-charcoal/50">{{ __('Mitra') }}: {{ $project->client }}</p>
                        @endif
                    </a>
                @endforeach
            </div>

            <div class="mt-16">
                {{ $projects->links() }}
            </div>
        </div>
    </section>
</x-layouts.app>
