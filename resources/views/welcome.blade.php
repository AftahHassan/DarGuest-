<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="DarGuest - Gérez vos locations saisonnières intelligemment grâce à l'intelligence artificielle.">
    <title>{{ config('app.name', 'DarGuest') }} — Location saisonnière intelligente</title>

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Vite --}}
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    <style>
        body { font-family: 'Poppins', 'Inter', sans-serif; }
        .text-balance { text-wrap: balance; }
    </style>
</head>
<body class="font-sans text-surface-800 antialiased bg-white">

    {{-- Navbar --}}
    <x-landing.navbar />

    {{-- Hero --}}
    <x-landing.hero />

    {{-- Features --}}
    <x-landing.features />

    {{-- How it works --}}
    <x-landing.how-it-works />

    {{-- AI Section --}}
    <x-landing.ai-section />

    {{-- Advantages --}}
    <x-landing.advantages />

    {{-- Statistics --}}
    <x-landing.statistics />

    {{-- Testimonials --}}
    <x-landing.testimonials />

    {{-- FAQ --}}
    <x-landing.faq />

    {{-- Footer --}}
    <x-landing.footer />

    {{-- Alpine --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>

