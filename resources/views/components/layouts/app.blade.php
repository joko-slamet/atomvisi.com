@props([
    'title' => null,
    'description' => 'Atom Visi Indonesia — lembaga riset independen di bidang kebijakan publik, analisis politik & geopolitik, survey sosial, dan konsultasi strategis.',
    'ogImage' => null,
    'footerWaveColor' => 'text-cream',
])

<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $title ? "$title — Atom Visi Indonesia" : 'Atom Visi Indonesia — Insight with Precision. Strategy with Impact.' }}</title>
    <meta name="description" content="{{ $description }}">

    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ $title ? "$title — Atom Visi Indonesia" : 'Atom Visi Indonesia' }}">
    <meta property="og:description" content="{{ $description }}">
    @if ($ogImage)
        <meta property="og:image" content="{{ $ogImage }}">
    @endif

    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">

    @fonts
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-cream font-sans text-charcoal antialiased">
    <x-layouts.navbar />

    <main>
        {{ $slot }}
    </main>

    <x-layouts.footer :wave-color="$footerWaveColor" />

    <x-whatsapp-float />

    @livewireScripts
</body>
</html>
