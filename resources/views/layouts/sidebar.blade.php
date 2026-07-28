@php
    $user = auth()->user();
    $currentRoute = request()->route()->getName();
@endphp

<aside
    class="sidebar"
    :class="sidebarOpen ? 'sidebar-expanded' : 'sidebar-collapsed'"
    x-show="true"
>
    <div class="h-20 flex items-center px-5 border-b border-surface-100 flex-shrink-0">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 overflow-hidden">
            <div class="w-10 h-10 rounded-2xl bg-gradient-to-br from-blue-600 to-blue-700 flex items-center justify-center flex-shrink-0 shadow-lg shadow-blue-600/20">
                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/>
                </svg>
            </div>
            <span
                class="text-xl font-bold text-surface-900 tracking-tight whitespace-nowrap transition-all duration-200"
                :class="sidebarOpen ? 'opacity-100' : 'opacity-0 w-0 overflow-hidden'"
            >
                Dar<span class="text-blue-600">Guest</span>
            </span>
        </a>
    </div>

    <div class="flex-1 overflow-y-auto py-6 px-3 space-y-1">
        {{-- Dashboard --}}
        <a href="{{ route('dashboard') }}"
           class="sidebar-link {{ $currentRoute === 'dashboard' ? 'sidebar-link-active' : 'sidebar-link-default' }}"
           title="Dashboard">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z"/>
            </svg>
            <span class="transition-all duration-200 whitespace-nowrap" :class="sidebarOpen ? 'opacity-100' : 'opacity-0 w-0 overflow-hidden'">Dashboard</span>
        </a>

        {{-- Mes logements --}}
        <a href="{{ route('properties.index') }}"
           class="sidebar-link {{ str_starts_with($currentRoute, 'properties') ? 'sidebar-link-active' : 'sidebar-link-default' }}"
           title="Mes logements">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/>
            </svg>
            <span class="transition-all duration-200 whitespace-nowrap" :class="sidebarOpen ? 'opacity-100' : 'opacity-0 w-0 overflow-hidden'">Mes logements</span>
        </a>

        {{-- Réservations --}}
        <a href="{{ route('reservations.index') }}"
           class="sidebar-link {{ str_starts_with($currentRoute, 'reservations') ? 'sidebar-link-active' : 'sidebar-link-default' }}"
           title="Réservations">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/>
            </svg>
            <span class="transition-all duration-200 whitespace-nowrap" :class="sidebarOpen ? 'opacity-100' : 'opacity-0 w-0 overflow-hidden'">Réservations</span>
        </a>

        {{-- Voyageurs --}}
        <a href="{{ route('reservations.index') }}"
           class="sidebar-link sidebar-link-default"
           title="Voyageurs">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/>
            </svg>
            <span class="transition-all duration-200 whitespace-nowrap" :class="sidebarOpen ? 'opacity-100' : 'opacity-0 w-0 overflow-hidden'">Voyageurs</span>
        </a>

        {{-- Messagerie IA --}}
        @if(Route::has('conversations.index'))
        <a href="{{ route('conversations.index') }}"
           class="sidebar-link {{ str_starts_with($currentRoute, 'conversations') ? 'sidebar-link-active' : 'sidebar-link-default' }}"
           title="Messagerie IA">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.455 2.456L21.75 6l-1.036.259a3.375 3.375 0 00-2.455 2.456zM16.894 20.567L16.5 21.75l-.394-1.183a2.25 2.25 0 00-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 001.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 001.423 1.423l1.183.394-1.183.394a2.25 2.25 0 00-1.423 1.423z"/>
            </svg>
            <span class="transition-all duration-200 whitespace-nowrap" :class="sidebarOpen ? 'opacity-100' : 'opacity-0 w-0 overflow-hidden'">Messagerie IA</span>
        </a>
        @endif

        {{-- Notifications --}}
        @if(Route::has('notifications.index'))
        <a href="{{ route('notifications.index') }}"
           class="sidebar-link {{ str_starts_with($currentRoute, 'notifications') ? 'sidebar-link-active' : 'sidebar-link-default' }}"
           title="Notifications">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/>
            </svg>
            <span class="transition-all duration-200 whitespace-nowrap" :class="sidebarOpen ? 'opacity-100' : 'opacity-0 w-0 overflow-hidden'">Notifications</span>
            @php $unreadCount = $user->unreadNotifications()->count(); @endphp
            @if($unreadCount > 0)
                <span class="ml-auto bg-red-500 text-white text-[10px] font-bold rounded-full min-w-[20px] h-5 flex items-center justify-center px-1 flex-shrink-0">
                    {{ min($unreadCount, 99) }}
                </span>
            @endif
        </a>
        @endif

        {{-- Statistiques --}}
        <a href="{{ route('dashboard') }}"
           class="sidebar-link sidebar-link-default"
           title="Statistiques">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/>
            </svg>
            <span class="transition-all duration-200 whitespace-nowrap" :class="sidebarOpen ? 'opacity-100' : 'opacity-0 w-0 overflow-hidden'">Statistiques</span>
        </a>

        <div class="my-4 border-t border-surface-100"></div>

        {{-- Mon profil --}}
        <a href="{{ route('profile.edit') }}"
           class="sidebar-link {{ str_starts_with($currentRoute, 'profile') ? 'sidebar-link-active' : 'sidebar-link-default' }}"
           title="Mon profil">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
            </svg>
            <span class="transition-all duration-200 whitespace-nowrap" :class="sidebarOpen ? 'opacity-100' : 'opacity-0 w-0 overflow-hidden'">Mon profil</span>
        </a>

        {{-- Paramètres --}}
        @if(Route::has('settings.index'))
        <a href="{{ route('settings.index') }}"
           class="sidebar-link {{ str_starts_with($currentRoute, 'settings') ? 'sidebar-link-active' : 'sidebar-link-default' }}"
           title="Paramètres">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z"/>
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            <span class="transition-all duration-200 whitespace-nowrap" :class="sidebarOpen ? 'opacity-100' : 'opacity-0 w-0 overflow-hidden'">Paramètres</span>
        </a>
        @endif

        {{-- Déconnexion --}}
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="sidebar-link sidebar-link-default w-full text-left" title="Déconnexion">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9"/>
                </svg>
                <span class="transition-all duration-200 whitespace-nowrap" :class="sidebarOpen ? 'opacity-100' : 'opacity-0 w-0 overflow-hidden'">Déconnexion</span>
            </button>
        </form>
    </div>

    <div class="hidden lg:flex border-t border-surface-100 p-3">
        <button
            x-on:click="sidebarOpen = !sidebarOpen"
            class="w-full flex items-center justify-center gap-2 py-2.5 text-surface-400 hover:text-surface-600 hover:bg-surface-100 rounded-xl text-sm transition-all duration-200"
            :title="sidebarOpen ? 'Réduire' : 'Étendre'"
        >
            <svg class="w-5 h-5 transition-transform duration-200" :class="sidebarOpen ? '' : 'rotate-180'" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M18.75 19.5l-7.5-7.5 7.5-7.5m-6 15L5.25 12l7.5-7.5"/>
            </svg>
            <span class="transition-all duration-200 whitespace-nowrap" :class="sidebarOpen ? 'opacity-100' : 'opacity-0 w-0 overflow-hidden'">Réduire</span>
        </button>
    </div>
</aside>
