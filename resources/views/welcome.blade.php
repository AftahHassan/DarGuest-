<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'DarGuest') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=outfit:300,400,500,600,700&display=swap" rel="stylesheet" />
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    <style>
        body { font-family: 'Outfit', 'Segoe UI', 'Tahoma', sans-serif; }
    </style>
</head>
<body class="font-sans text-surface-800 antialiased">
    <header class="border-b border-surface-200 bg-white">
        <div class="max-w-6xl mx-auto px-6 h-16 flex items-center justify-between">
            <a href="/" class="flex items-center gap-2">
                <div class="w-8 h-8 bg-navy-700 rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/>
                    </svg>
                </div>
                <span class="text-lg font-bold text-surface-900">Dar<span class="text-navy-700">Guest</span></span>
            </a>
            <nav class="flex items-center gap-3">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn-primary text-sm">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm text-surface-600 hover:text-navy-600 transition-colors font-medium">Connexion</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn-primary text-sm">S'inscrire</a>
                        @endif
                    @endauth
                @endif
            </nav>
        </div>
    </header>

    <section class="py-24 px-6">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="text-5xl font-bold text-surface-900 tracking-tight leading-tight">
                Trouvez votre <span class="text-navy-700">prochain séjour</span>
            </h1>
            <p class="mt-5 text-lg text-surface-500 max-w-2xl mx-auto leading-relaxed">
                Des hébergements vérifiés, des réservations simples, une assistance IA intégrée.
            </p>
            <div class="mt-10 flex items-center justify-center gap-4">
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="btn-primary px-8 py-3 text-base">Commencer maintenant</a>
                @endif
                <a href="#features" class="btn-secondary px-8 py-3 text-base">En savoir plus</a>
            </div>
        </div>
    </section>

    <section id="features" class="py-20 px-6 bg-surface-50 border-y border-surface-200">
        <div class="max-w-6xl mx-auto">
            <h2 class="text-3xl font-bold text-surface-900 text-center tracking-tight">Pourquoi DarGuest ?</h2>
            <p class="mt-3 text-surface-500 text-center max-w-lg mx-auto">Tout ce dont vous avez besoin pour une location réussie.</p>

            <div class="mt-14 grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white border border-surface-200 rounded-xl shadow-card p-6">
                    <div class="w-10 h-10 bg-navy-50 rounded-xl flex items-center justify-center mb-4">
                        <svg class="w-5 h-5 text-navy-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/></svg>
                    </div>
                    <h3 class="text-base font-semibold text-surface-900 mb-2">Propriétés vérifiées</h3>
                    <p class="text-sm text-surface-500 leading-relaxed">Chaque annonce est reviewée par notre équipe.</p>
                </div>

                <div class="bg-white border border-surface-200 rounded-xl shadow-card p-6">
                    <div class="w-10 h-10 bg-navy-50 rounded-xl flex items-center justify-center mb-4">
                        <svg class="w-5 h-5 text-navy-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.455 2.456L21.75 6l-1.036.259a3.375 3.375 0 00-2.455 2.456zM16.894 20.567L16.5 21.75l-.394-1.183a2.25 2.25 0 00-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 001.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 001.423 1.423l1.183.394-1.183.394a2.25 2.25 0 00-1.423 1.423z"/></svg>
                    </div>
                    <h3 class="text-base font-semibold text-surface-900 mb-2">Assistance IA</h3>
                    <p class="text-sm text-surface-500 leading-relaxed">Analyse intelligente et suggestions automatiques.</p>
                </div>

                <div class="bg-white border border-surface-200 rounded-xl shadow-card p-6">
                    <div class="w-10 h-10 bg-navy-50 rounded-xl flex items-center justify-center mb-4">
                        <svg class="w-5 h-5 text-navy-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z"/></svg>
                    </div>
                    <h3 class="text-base font-semibold text-surface-900 mb-2">Messagerie intégrée</h3>
                    <p class="text-sm text-surface-500 leading-relaxed">Communication directe entre voyageurs et propriétaires.</p>
                </div>
            </div>
        </div>
    </section>

    <footer class="py-10 px-6">
        <div class="max-w-6xl mx-auto text-center text-sm text-surface-400">
            &copy; {{ date('Y') }} DarGuest. Tous droits réservés.
        </div>
    </footer>
</body>
</html>
