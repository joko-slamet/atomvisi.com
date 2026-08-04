@props([
    'kicker' => null,
    'title' => null,
    'description' => null,
    'align' => 'left',
    'light' => false,
])

@php
    $alignClass = $align === 'center' ? 'items-center text-center mx-auto' : 'items-start text-left';
    $kickerColor = $light ? 'text-gold-400' : 'text-gold-600';
    $titleColor = $light ? 'text-cream' : 'text-forest-800';
@endphp

<div {{ $attributes->merge(['class' => "flex flex-col $alignClass max-w-2xl"]) }} data-aos="fade-up">
    @if ($kicker)
        <span class="flex items-center gap-2 text-xs font-semibold uppercase tracking-[0.25em] {{ $kickerColor }}">
            <span class="h-px w-6 bg-current"></span>
            {{ $kicker }}
        </span>
    @endif

    <h2 class="mt-4 font-serif text-3xl font-semibold leading-tight {{ $titleColor }} sm:text-4xl">
        {{ $title ?? $slot }}
    </h2>

    @if ($description)
        <p class="mt-4 text-base leading-relaxed {{ $light ? 'text-forest-100/80' : 'text-charcoal/70' }}">
            {{ $description }}
        </p>
    @endif
</div>
