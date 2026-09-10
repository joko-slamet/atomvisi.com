<x-layouts.app :title="$title">
    <x-page-hero :kicker="$title" :title="$title" :description="$subtitle" />

    <section class="bg-cream py-24 sm:py-32">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            @if ($articles->isEmpty())
                <p class="text-center text-sm text-charcoal/60">{{ __('Belum ada artikel yang dipublikasikan.') }}</p>
            @else
                <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
                    @foreach ($articles as $index => $article)
                        <a href="{{ route('articles.show', $article) }}" data-aos="fade-up" data-aos-delay="{{ ($index % 3) * 100 }}"
                           class="group flex flex-col overflow-hidden rounded-2xl border border-forest-100 bg-white transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-forest-900/10">
                            <div class="aspect-[16/10] w-full overflow-hidden bg-forest-100">
                                @if ($article->featured_image)
                                    <img src="{{ asset('storage/'.$article->featured_image) }}" alt="{{ $article->title }}" loading="lazy"
                                         class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105">
                                @else
                                    <div class="flex h-full w-full items-center justify-center bg-gradient-to-br from-forest-600 to-forest-800">
                                        <x-watermark class="h-14 w-14 text-cream/20" />
                                    </div>
                                @endif
                            </div>
                            <div class="flex flex-1 flex-col p-6">
                                @if ($article->category)
                                    <span class="text-xs font-semibold uppercase tracking-wider text-gold-600">{{ $article->category->name }}</span>
                                @endif
                                <h3 class="mt-2 font-sans text-lg font-semibold leading-snug text-forest-800 group-hover:text-forest-600">{{ $article->title }}</h3>
                                <p class="mt-2 line-clamp-2 flex-1 text-sm text-charcoal/70">{{ $article->excerpt }}</p>
                                <span class="mt-4 text-xs text-charcoal/50">{{ $article->published_at?->translatedFormat('d F Y') }}</span>
                            </div>
                        </a>
                    @endforeach
                </div>

                <div class="mt-16">
                    {{ $articles->links() }}
                </div>
            @endif
        </div>
    </section>
</x-layouts.app>
