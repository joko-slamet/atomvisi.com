@props(['scrolledClass' => null])

@php
    $currentRoute = request()->route();
    $currentLocale = app()->getLocale();
    $otherLocale = $currentLocale === 'id' ? 'en' : 'id';
    $otherUrl = $currentRoute
        ? route($currentRoute->getName(), array_merge($currentRoute->parameters(), ['locale' => $otherLocale]))
        : url('/'.$otherLocale);
@endphp

<a href="{{ $otherUrl }}"
   {{ $attributes->merge(['class' => 'flex h-9 items-center gap-1.5 rounded-full px-3 text-xs font-semibold uppercase tracking-wide transition-colors']) }}>
    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 12h18M12 3a15 15 0 010 18M12 3a15 15 0 000 18" />
    </svg>
    {{ strtoupper($otherLocale) }}
</a>
