<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ __('Connexion') }} — {{ config('app.name', 'DarGuest') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:300,400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-surface-950 overflow-x-hidden">

<div class="flex min-h-screen">
    {{-- LEFT: Hero Background (70%) --}}
    <div class="hidden lg:flex relative w-[70%] min-h-screen overflow-hidden">
        <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?q=80&w=2075&auto=format&fit=crop')] bg-cover bg-center bg-no-repeat scale-105"></div>
        <div class="absolute inset-0 bg-gradient-to-r from-surface-950/80 via-surface-950/50 to-transparent"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-surface-950/60 via-transparent to-surface-950/30"></div>

        <div class="absolute inset-0 opacity-[0.04]" style="background-image: url(&quot;data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E&quot;);"></div>

        <div class="relative z-10 flex flex-col justify-between p-12 w-full">
            <div>
                <a href="/" class="inline-flex items-center gap-3 group">
                    <div class="w-11 h-11 rounded-2xl bg-white/10 backdrop-blur-md border border-white/20 flex items-center justify-center group-hover:bg-white/20 transition-all duration-300">
                        <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                        </svg>
                    </div>
                    <span class="text-xl font-bold text-white">Dar<span class="text-blue-200">Guest</span></span>
                </a>
            </div>

            <div class="max-w-lg">
                <h1 class="text-4xl sm:text-5xl font-bold text-white leading-[1.15] tracking-tight text-balance">
                    Votre <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-200 to-white">confort</span>, notre priorité
                </h1>
                <p class="mt-4 text-base sm:text-lg text-white/60 leading-relaxed">
                    Connectez-vous pour gérer vos propriétés, suivre vos réservations et interagir avec vos voyageurs en toute simplicité.
                </p>
                <div class="mt-8 flex flex-wrap gap-3">
                    <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/5 backdrop-blur-sm border border-white/10 text-xs font-medium text-white/70">
                        <svg class="w-3.5 h-3.5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Gestion centralisée
                    </span>
                    <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/5 backdrop-blur-sm border border-white/10 text-xs font-medium text-white/70">
                        <svg class="w-3.5 h-3.5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Assistant IA 24/7
                    </span>
                    <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/5 backdrop-blur-sm border border-white/10 text-xs font-medium text-white/70">
                        <svg class="w-3.5 h-3.5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Paiements sécurisés
                    </span>
                </div>
            </div>

            <div class="text-xs text-white/30">
                &copy; {{ date('Y') }} DarGuest. Tous droits réservés.
            </div>
        </div>
    </div>

    {{-- RIGHT: Auth Card (30%) --}}
    <div class="relative w-full lg:w-[30%] min-h-screen flex items-center justify-center p-6 lg:p-10 bg-surface-50 lg:bg-surface-50">
        {{-- Mobile background (visible only on small screens) --}}
        <div class="lg:hidden absolute inset-0 bg-[url('https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?q=80&w=2075&auto=format&fit=crop')] bg-cover bg-center bg-no-repeat"></div>
        <div class="lg:hidden absolute inset-0 bg-gradient-to-b from-surface-900/80 via-surface-900/70 to-surface-900/90"></div>

        <div class="relative z-10 w-full max-w-[420px]">
            {{-- Mobile logo --}}
            <div class="lg:hidden text-center mb-8">
                <a href="/" class="inline-flex items-center gap-2">
                    <div class="w-10 h-10 rounded-xl bg-white/10 backdrop-blur-md border border-white/20 flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                        </svg>
                    </div>
                    <span class="text-xl font-bold text-white">Dar<span class="text-blue-200">Guest</span></span>
                </a>
            </div>

            {{-- Glassmorphism Card --}}
            <div class="glass rounded-3xl p-8 sm:p-10 shadow-elevated">
                <div class="text-center mb-8">
                    <div class="w-14 h-14 rounded-2xl bg-navy-700 flex items-center justify-center mx-auto mb-4 shadow-lg shadow-navy-700/20">
                        <svg class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-surface-900">{{ __('Connexion') }}</h2>
                    <p class="text-sm text-surface-500 mt-1">{{ __('Accédez à votre tableau de bord') }}</p>
                </div>

                {{-- Session Status --}}
                <x-auth-session-status class="mb-6" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    {{-- Email --}}
                    <div>
                        <label for="email" class="block text-sm font-medium text-surface-700 mb-1.5">
                            {{ __('Adresse email') }}
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-surface-400 pointer-events-none">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                                </svg>
                            </span>
                            <input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username"
                                   class="input-field pl-10 @error('email') border-red-400 focus:border-red-500 focus:ring-red-500/20 @enderror"
                                   placeholder="vous@exemple.com" />
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
                    </div>

                    {{-- Password --}}
                    <div>
                        <label for="password" class="block text-sm font-medium text-surface-700 mb-1.5">
                            {{ __('Mot de passe') }}
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-surface-400 pointer-events-none">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                                </svg>
                            </span>
                            <input id="password" type="password" name="password" required autocomplete="current-password"
                                   class="input-field pl-10 @error('password') border-red-400 focus:border-red-500 focus:ring-red-500/20 @enderror"
                                   placeholder="••••••••" />
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
                    </div>

                    {{-- Remember & Forgot --}}
                    <div class="flex items-center justify-between">
                        <label for="remember_me" class="flex items-center gap-2 cursor-pointer select-none">
                            <input id="remember_me" type="checkbox" name="remember"
                                   class="rounded border-surface-300 text-navy-700 shadow-sm focus:ring-navy-500 cursor-pointer" />
                            <span class="text-sm text-surface-600">{{ __('Se souvenir de moi') }}</span>
                        </label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}"
                               class="text-sm font-medium text-navy-700 hover:text-navy-800 transition-colors">
                                {{ __('Mot de passe oublié ?') }}
                            </a>
                        @endif
                    </div>

                    {{-- Submit --}}
                    <button type="submit"
                            class="btn-primary w-full py-3 rounded-2xl text-sm font-semibold shadow-xl shadow-navy-700/20 hover:shadow-navy-700/30 hover:-translate-y-0.5 transition-all duration-300">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                        </svg>
                        {{ __('Se connecter') }}
                    </button>

                    {{-- Divider --}}
                    <div class="relative my-6">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-surface-200"></div>
                        </div>
                        <div class="relative flex justify-center text-xs uppercase">
                            <span class="bg-white/70 px-4 text-surface-400 font-medium">{{ __('Ou continuer avec') }}</span>
                        </div>
                    </div>

                    {{-- Social Buttons --}}
                    <div class="grid grid-cols-2 gap-3">
                        <a href="#"
                           class="flex items-center justify-center gap-2.5 px-4 py-2.5 border border-surface-200 rounded-2xl text-sm font-medium text-surface-700 bg-white hover:bg-surface-50 hover:border-surface-300 transition-all duration-200">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92a5.06 5.06 0 01-2.2 3.32v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.1z"/>
                                <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                                <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                                <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                            </svg>
                            <span>Google</span>
                        </a>
                        <a href="#"
                           class="flex items-center justify-center gap-2.5 px-4 py-2.5 border border-surface-200 rounded-2xl text-sm font-medium text-surface-700 bg-white hover:bg-surface-50 hover:border-surface-300 transition-all duration-200">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                            </svg>
                            <span>GitHub</span>
                        </a>
                    </div>
                </form>

                <p class="mt-8 text-center text-sm text-surface-500">
                    {{ __("Vous n'avez pas de compte ?") }}
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                           class="font-semibold text-navy-700 hover:text-navy-800 transition-colors">
                            {{ __("S'inscrire") }}
                        </a>
                    @endif
                </p>
            </div>

            {{-- Footer links --}}
            <div class="flex justify-center gap-6 mt-8 text-xs text-surface-400">
                <a href="#" class="hover:text-surface-600 transition-colors">{{ __('Conditions') }}</a>
                <a href="#" class="hover:text-surface-600 transition-colors">{{ __('Confidentialité') }}</a>
                <a href="#" class="hover:text-surface-600 transition-colors">{{ __('Support') }}</a>
            </div>
        </div>
    </div>
</div>

{{-- Animation keyframes --}}
<style>
    @keyframes fadeSlideIn {
        from { opacity: 0; transform: translateY(20px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .glass {
        animation: fadeSlideIn 0.6s ease-out both;
    }
    .glass > *:nth-child(2) { animation-delay: 0.05s; }
    .glass > *:nth-child(3) { animation-delay: 0.10s; }
    .glass > *:nth-child(4) { animation-delay: 0.15s; }
    .glass > *:nth-child(5) { animation-delay: 0.20s; }
</style>

</body>
</html>
