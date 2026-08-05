@props(['variant' => 'dark'])

@php
    $src = $variant === 'light' ? asset('images/logo-light.png') : asset('images/logo.png');
@endphp

<a href="{{ route('home') }}" class="inline-flex items-center" aria-label="Atom Visi Indonesia — Beranda">
    <img src="{{ $src }}" alt="Atom Visi Indonesia" class="h-9 w-auto sm:h-10">
</a>
