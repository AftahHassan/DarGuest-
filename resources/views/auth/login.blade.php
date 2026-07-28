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
<body class="font-sans antialiased relative min-h-screen flex items-center justify-center p-4 sm:p-6 overflow-hidden bg-surface-950">

    {{-- Fullscreen Background --}}
    <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?q=80&w=2075&auto=format&fit=crop')] bg-cover bg-center bg-no-repeat scale-105"></div>
    <div class="absolute inset-0 bg-gradient-to-b from-surface-950/70 via-surface-950/50 to-surface-950/80"></div>
    <div class="absolute inset-0 opacity-[0.04]" style="background-image: url(&quot;data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E&quot;);"></div>

    {{-- Logo --}}
    <div class="absolute top-6 left-6 sm:top-8 sm:left-8 z-10">
        <a href="/" class="inline-flex items-center gap-2.5 group">
            <div class="w-10 h-10 rounded-xl bg-white/10 backdrop-blur-md border border-white/20 flex items-center justify-center group-hover:bg-white/20 transition-all duration-300">
                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                </svg>
            </div>
            <span class="text-lg font-bold text-white">Dar<span class="text-blue-200">Guest</span></span>
        </a>
    </div>

    {{-- Glassmorphism Card --}}
    <div class="relative z-10 w-full max-w-[420px]">
        <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-elevated border border-surface-100">
            <div class="text-center mb-5">
                <div class="w-12 h-12 rounded-2xl bg-navy-700 flex items-center justify-center mx-auto mb-3 shadow-lg shadow-navy-700/20">
                    <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-surface-900">{{ __('Connexion') }}</h2>
                <p class="text-sm text-surface-500 mt-0.5">{{ __('Accédez à votre tableau de bord') }}</p>
            </div>

            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

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

                <button type="submit"
                        class="btn-primary w-full py-2.5 rounded-2xl text-sm font-semibold shadow-xl shadow-navy-700/20 hover:shadow-navy-700/30 hover:-translate-y-0.5 transition-all duration-300">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                    </svg>
                    {{ __('Se connecter') }}
                </button>

                {{-- Social --}}
                <div class="relative my-4">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-surface-200"></div>
                    </div>
                    <div class="relative flex justify-center text-xs uppercase">
                        <span class="bg-white px-4 text-surface-400 font-medium">{{ __('Ou continuer avec') }}</span>
                    </div>
                </div>

                <a href="#"
                   class="flex items-center justify-center gap-2 w-full px-4 py-2 border border-surface-200 rounded-2xl text-sm font-medium text-surface-700 bg-white hover:bg-surface-50 hover:border-surface-300 transition-all duration-200">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92a5.06 5.06 0 01-2.2 3.32v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.1z"/>
                        <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                        <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                        <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                    </svg>
                    <span>Google</span>
                </a>
            </form>

            <p class="mt-5 text-center text-sm text-surface-500">
                {{ __("Vous n'avez pas de compte ?") }}
                @if (Route::has('register'))
                    <a href="{{ route('register') }}"
                       class="font-semibold text-navy-700 hover:text-navy-800 transition-colors">
                        {{ __("S'inscrire") }}
                    </a>
                @endif
            </p>
        </div>

        <div class="flex justify-center gap-6 mt-8 text-xs text-white/40">
            <a href="#" class="hover:text-white/70 transition-colors">{{ __('Conditions') }}</a>
            <a href="#" class="hover:text-white/70 transition-colors">{{ __('Confidentialité') }}</a>
            <a href="#" class="hover:text-white/70 transition-colors">{{ __('Support') }}</a>
        </div>
    </div>

    <style>
        @keyframes fadeSlideIn {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .bg-white {
            animation: fadeSlideIn 0.6s ease-out both;
        }
    </style>

</body>
</html>
