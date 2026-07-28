<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ __('Inscription') }} — {{ config('app.name', 'DarGuest') }}</title>
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
        <div class="glass rounded-3xl p-8 sm:p-10 shadow-elevated">
            <div class="text-center mb-8">
                <div class="w-14 h-14 rounded-2xl bg-navy-700 flex items-center justify-center mx-auto mb-4 shadow-lg shadow-navy-700/20">
                    <svg class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 3.75V16.5L12 14.25 7.5 16.5V3.75m9 0H18A2.25 2.25 0 0120.25 6v12A2.25 2.25 0 0118 20.25H6A2.25 2.25 0 013.75 18V6A2.25 2.25 0 016 3.75h1.5m9 0h-9" />
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-surface-900">{{ __('Créer un compte') }}</h2>
                <p class="text-sm text-surface-500 mt-1">{{ __('Rejoignez DarGuest dès aujourd\'hui') }}</p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label for="first_name" class="block text-sm font-medium text-surface-700 mb-1.5">{{ __('Prénom') }}</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-surface-400 pointer-events-none">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                </svg>
                            </span>
                            <input id="first_name" type="text" name="first_name" :value="old('first_name')" required autofocus autocomplete="given-name"
                                   class="input-field pl-10 @error('first_name') border-red-400 focus:border-red-500 focus:ring-red-500/20 @enderror"
                                   placeholder="Jean" />
                        </div>
                        <x-input-error :messages="$errors->get('first_name')" class="mt-1.5" />
                    </div>

                    <div>
                        <label for="last_name" class="block text-sm font-medium text-surface-700 mb-1.5">{{ __('Nom') }}</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-surface-400 pointer-events-none">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                </svg>
                            </span>
                            <input id="last_name" type="text" name="last_name" :value="old('last_name')" required autocomplete="family-name"
                                   class="input-field pl-10 @error('last_name') border-red-400 focus:border-red-500 focus:ring-red-500/20 @enderror"
                                   placeholder="Dupont" />
                        </div>
                        <x-input-error :messages="$errors->get('last_name')" class="mt-1.5" />
                    </div>
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-surface-700 mb-1.5">{{ __('Adresse email') }}</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-surface-400 pointer-events-none">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                            </svg>
                        </span>
                        <input id="email" type="email" name="email" :value="old('email')" required autocomplete="username"
                               class="input-field pl-10 @error('email') border-red-400 focus:border-red-500 focus:ring-red-500/20 @enderror"
                               placeholder="vous@exemple.com" />
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
                </div>

                <div>
                    <label for="phone" class="block text-sm font-medium text-surface-700 mb-1.5">{{ __('Téléphone') }}</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-surface-400 pointer-events-none">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                            </svg>
                        </span>
                        <input id="phone" type="text" name="phone" :value="old('phone')" autocomplete="tel"
                               class="input-field pl-10 @error('phone') border-red-400 focus:border-red-500 focus:ring-red-500/20 @enderror"
                               placeholder="+212 6 00 00 00 00" />
                    </div>
                    <x-input-error :messages="$errors->get('phone')" class="mt-1.5" />
                </div>

                <div>
                    <label for="role" class="block text-sm font-medium text-surface-700 mb-1.5">{{ __('Je suis un(e)') }}</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-surface-400 pointer-events-none">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                            </svg>
                        </span>
                        <select id="role" name="role" required
                                class="input-field pl-10 appearance-none @error('role') border-red-400 focus:border-red-500 focus:ring-red-500/20 @enderror">
                            <option value="">{{ __('-- Choisir --') }}</option>
                            <option value="owner" @selected(old('role') === 'owner')>{{ __('Propriétaire') }}</option>
                            <option value="guest" @selected(old('role') === 'guest')>{{ __('Voyageur') }}</option>
                        </select>
                    </div>
                    <x-input-error :messages="$errors->get('role')" class="mt-1.5" />
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-surface-700 mb-1.5">{{ __('Mot de passe') }}</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-surface-400 pointer-events-none">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                            </svg>
                        </span>
                        <input id="password" type="password" name="password" required autocomplete="new-password"
                               class="input-field pl-10 @error('password') border-red-400 focus:border-red-500 focus:ring-red-500/20 @enderror"
                               placeholder="••••••••" />
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-surface-700 mb-1.5">{{ __('Confirmer le mot de passe') }}</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-surface-400 pointer-events-none">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                            </svg>
                        </span>
                        <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                               class="input-field pl-10 @error('password_confirmation') border-red-400 focus:border-red-500 focus:ring-red-500/20 @enderror"
                               placeholder="••••••••" />
                    </div>
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1.5" />
                </div>

                <button type="submit"
                        class="btn-primary w-full py-3 rounded-2xl text-sm font-semibold shadow-xl shadow-navy-700/20 hover:shadow-navy-700/30 hover:-translate-y-0.5 transition-all duration-300">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    {{ __("S'inscrire") }}
                </button>
            </form>

            <p class="mt-8 text-center text-sm text-surface-500">
                {{ __('Déjà inscrit ?') }}
                @if (Route::has('login'))
                    <a href="{{ route('login') }}"
                       class="font-semibold text-navy-700 hover:text-navy-800 transition-colors">
                        {{ __('Se connecter') }}
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
        .glass {
            animation: fadeSlideIn 0.6s ease-out both;
        }
    </style>

</body>
</html>
