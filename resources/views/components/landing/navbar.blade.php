@props(['transparent' => false])

<nav x-data="{ mobileOpen: false, scrolled: false }"
     x-init="window.addEventListener('scroll', () => scrolled = window.scrollY > 20)"
     class="fixed top-0 left-0 right-0 z-50 transition-all duration-500"
     :class="scrolled ? 'glass mt-2 max-w-6xl mx-auto rounded-2xl px-4 sm:px-6' : 'px-4 sm:px-8'">
    <div class="max-w-7xl mx-auto h-16 sm:h-20 flex items-center justify-between">
        {{-- Logo --}}
        <a href="/" class="flex items-center gap-2.5 group">
            <div class="w-9 h-9 bg-navy-700 rounded-xl flex items-center justify-center shadow-sm group-hover:shadow-md transition-shadow">
                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/>
                </svg>
            </div>
            <span class="text-xl font-bold tracking-tight text-surface-900">Dar<span class="text-navy-700">Guest</span></span>
        </a>

        {{-- Desktop Menu --}}
        <div class="hidden lg:flex items-center gap-8">
            <a href="#hero" class="text-sm font-medium text-surface-600 hover:text-navy-700 transition-colors">Accueil</a>
            <a href="#features" class="text-sm font-medium text-surface-600 hover:text-navy-700 transition-colors">Fonctionnalités</a>
            <a href="#how-it-works" class="text-sm font-medium text-surface-600 hover:text-navy-700 transition-colors">Comment ça marche</a>
            <a href="#advantages" class="text-sm font-medium text-surface-600 hover:text-navy-700 transition-colors">Avantages</a>
            <a href="#faq" class="text-sm font-medium text-surface-600 hover:text-navy-700 transition-colors">FAQ</a>
        </div>

        {{-- Desktop Actions --}}
        <div class="hidden lg:flex items-center gap-3">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn-primary text-sm px-5 py-2.5">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-medium text-surface-600 hover:text-navy-700 transition-colors px-4 py-2">Connexion</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn-primary text-sm px-5 py-2.5">Créer un compte</a>
                    @endif
                @endauth
            @endif
        </div>

        {{-- Mobile Toggle --}}
        <button x-on:click="mobileOpen = !mobileOpen"
                class="lg:hidden w-10 h-10 flex items-center justify-center rounded-xl hover:bg-surface-100 transition-colors"
                :aria-label="mobileOpen ? 'Fermer' : 'Menu'">
            <svg class="w-5 h-5 text-surface-700" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path x-show="!mobileOpen" stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
                <path x-show="mobileOpen" stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>

    {{-- Mobile Menu --}}
    <div x-show="mobileOpen"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-4"
         class="lg:hidden glass rounded-2xl mt-2 p-5 space-y-3"
         style="display: none;">
        <a href="#hero" class="block text-sm font-medium text-surface-600 hover:text-navy-700 py-2 transition-colors">Accueil</a>
        <a href="#features" class="block text-sm font-medium text-surface-600 hover:text-navy-700 py-2 transition-colors">Fonctionnalités</a>
        <a href="#how-it-works" class="block text-sm font-medium text-surface-600 hover:text-navy-700 py-2 transition-colors">Comment ça marche</a>
        <a href="#advantages" class="block text-sm font-medium text-surface-600 hover:text-navy-700 py-2 transition-colors">Avantages</a>
        <a href="#faq" class="block text-sm font-medium text-surface-600 hover:text-navy-700 py-2 transition-colors">FAQ</a>
        <div class="pt-3 border-t border-surface-200 flex flex-col gap-2">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn-primary text-sm text-center">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn-secondary text-sm text-center">Connexion</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn-primary text-sm text-center">Créer un compte</a>
                    @endif
                @endauth
            @endif
        </div>
    </div>
</nav>