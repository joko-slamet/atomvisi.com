<x-layouts.app :title="$article->title" :description="$article->meta_description ?? $article->excerpt" :og-image="$article->og_image ? asset('storage/'.$article->og_image) : null">
    <section class="relative overflow-hidden bg-gradient-to-br from-forest-800 to-forest-600 pb-20 pt-40">
        <x-watermark class="pointer-events-none absolute -right-24 -top-24 h-80 w-80 text-forest-500/20" />

        <div class="relative mx-auto max-w-3xl px-6 text-center lg:px-8">
            @php
                $backRoute = match ($article->type) {
                    'op-ed' => route('op-ed.index'),
                    'newsletter' => route('newsletter.index'),
                    default => route('articles.index'),
                };
            @endphp
            <a href="{{ $backRoute }}" data-aos="fade-up" class="inline-flex items-center gap-1.5 text-xs font-semibold uppercase tracking-[0.2em] text-gold-300 hover:text-gold-200">
                &larr; {{ __('Kembali') }}
            </a>

            <div data-aos="fade-up" data-aos-delay="80" class="mt-6 flex items-center justify-center gap-3 text-xs font-semibold uppercase tracking-[0.2em] text-gold-300">
                @if ($article->category)
                    <span>{{ $article->category->name }}</span>
                    <span class="h-1 w-1 rounded-full bg-gold-400"></span>
                @endif
                <span>{{ $article->published_at?->translatedFormat('d F Y') }}</span>
            </div>

            <h1 data-aos="fade-up" data-aos-delay="120" class="mt-4 font-sans text-3xl font-semibold leading-tight text-cream sm:text-4xl">
                {{ $article->title }}
            </h1>

            @if ($article->author)
                <p data-aos="fade-up" data-aos-delay="200" class="mt-5 text-sm text-forest-100/70">
                    {{ __('Oleh') }} <span class="font-medium text-cream">{{ $article->author->name }}</span>, {{ $article->author->role }}
                </p>
            @endif
        </div>
    </section>

    <section class="bg-cream py-24 sm:py-32">
        <div class="mx-auto max-w-3xl px-6 lg:px-8">
            @if ($article->featured_image)
                <img src="{{ asset('storage/'.$article->featured_image) }}" alt="{{ $article->title }}"
                     class="mb-10 aspect-video w-full rounded-2xl object-cover" data-aos="fade-up">
            @endif

            <div data-aos="fade-up" class="prose max-w-none prose-headings:font-sans prose-headings:text-forest-800 prose-a:text-forest-700 prose-strong:text-forest-800">
                {!! $article->content !!}
            </div>
        </div>
    </section>

    @if ($related->isNotEmpty())
        <section class="bg-forest-50/50 py-24">
            <div class="mx-auto max-w-7xl px-6 lg:px-8">
                <x-section-heading kicker="{{ __('Baca Juga') }}" align="center" class="mx-auto">
                    <x-slot:title>{{ __('Artikel Terkait') }}</x-slot:title>
                </x-section-heading>

                <div class="mt-14 grid grid-cols-1 gap-6 md:grid-cols-3">
                    @foreach ($related as $index => $item)
                        <a href="{{ route('articles.show', $item) }}" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}"
                           class="group rounded-2xl border border-forest-100 bg-white p-6 transition-all duration-300 hover:-translate-y-1 hover:shadow-lg hover:shadow-forest-900/10">
                            @if ($item->category)
                                <span class="text-xs font-semibold uppercase tracking-wider text-gold-600">{{ $item->category->name }}</span>
                            @endif
                            <h3 class="mt-2 font-sans text-base font-semibold leading-snug text-forest-800 group-hover:text-forest-600">{{ $item->title }}</h3>
                            <span class="mt-3 block text-xs text-charcoal/50">{{ $item->published_at?->translatedFormat('d F Y') }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
</x-layouts.app>
