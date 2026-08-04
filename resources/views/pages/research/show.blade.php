<x-layouts.app :title="$project->title" :description="$project->summary">
    <section class="relative overflow-hidden bg-gradient-to-br from-forest-800 to-forest-600 pb-20 pt-40">
        <x-watermark class="pointer-events-none absolute -right-24 -top-24 h-80 w-80 text-forest-500/20" />

        <div class="relative mx-auto max-w-4xl px-6 text-center lg:px-8">
            <a href="{{ route('research.index') }}" data-aos="fade-up" class="inline-flex items-center gap-1.5 text-xs font-semibold uppercase tracking-[0.2em] text-gold-300 hover:text-gold-200">
                &larr; Semua Riset
            </a>
            <span data-aos="fade-up" data-aos-delay="80" class="mt-6 block text-xs font-semibold uppercase tracking-[0.25em] text-gold-300">
                {{ $project->category?->name }} &middot; {{ $project->year }}
            </span>
            <h1 data-aos="fade-up" data-aos-delay="120" class="mt-4 font-serif text-3xl font-semibold leading-tight text-cream sm:text-4xl">
                {{ $project->title }}
            </h1>
            @if ($project->client)
                <p data-aos="fade-up" data-aos-delay="200" class="mt-4 text-sm text-forest-100/70">Mitra: {{ $project->client }}</p>
            @endif
        </div>
    </section>

    <section class="bg-cream py-24 sm:py-32">
        <div class="mx-auto max-w-3xl px-6 lg:px-8">
            @if ($project->featured_image)
                <img src="{{ asset('storage/'.$project->featured_image) }}" alt="{{ $project->title }}"
                     class="mb-10 aspect-video w-full rounded-2xl object-cover" data-aos="fade-up">
            @endif

            @if ($project->summary)
                <p data-aos="fade-up" class="text-lg leading-relaxed text-charcoal/80">{{ $project->summary }}</p>
            @endif

            <div data-aos="fade-up" data-aos-delay="100" class="prose mt-8 max-w-none prose-headings:font-serif prose-headings:text-forest-800 prose-a:text-forest-700 prose-strong:text-forest-800">
                {!! $project->content !!}
            </div>

            @if ($project->report_file)
                <a href="{{ asset('storage/'.$project->report_file) }}" target="_blank" rel="noopener" data-aos="fade-up" data-aos-delay="150"
                   class="mt-10 inline-flex items-center gap-2 rounded-full bg-forest-700 px-7 py-3 text-sm font-semibold text-cream shadow-sm transition-all hover:bg-forest-600">
                    <x-icon name="heroicon-o-document-arrow-down" class="h-4 w-4" />
                    Unduh Laporan Lengkap
                </a>
            @endif
        </div>
    </section>
</x-layouts.app>
