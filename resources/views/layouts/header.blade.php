@php $user = auth()->user(); @endphp

<header
    class="fixed top-0 right-0 z-30 h-16 bg-white/80 backdrop-blur-xl border-b border-surface-200 transition-all duration-300"
    :class="{
        'left-64': sidebarOpen && !mobileSidebar,
        'left-[72px]': !sidebarOpen && !mobileSidebar,
        'left-0': mobileSidebar
    }"
>
    <div class="h-16 flex items-center justify-between px-6">
        <div class="flex items-center gap-4 flex-1">
            <button
                x-on:click="mobileSidebar = !mobileSidebar"
                class="lg:hidden w-9 h-9 rounded-lg flex items-center justify-center text-surface-400 hover:bg-surface-100 transition-all duration-200"
            >
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
                </svg>
            </button>

            <div class="relative hidden sm:block w-full max-w-xs">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-surface-400 pointer-events-none">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
                    </svg>
                </span>
                <input type="text" placeholder="Rechercher..."
                       class="w-full bg-surface-100 border-0 text-surface-800 rounded-lg text-sm pl-9 pr-3 py-2 placeholder:text-surface-400 focus:bg-white focus:ring-2 focus:ring-navy-500/20 focus:border-navy-500 focus:outline-none transition-all duration-200" />
            </div>
        </div>

        <div class="flex items-center gap-1">
            @if(Route::has('conversations.index'))
            <a href="{{ route('conversations.index') }}" class="btn-icon">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z"/>
                </svg>
            </a>
            @endif

            @if(Route::has('notifications.index'))
            <a href="{{ route('notifications.index') }}" class="btn-icon relative">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/>
                </svg>
                @php $unreadNotif = $user->unreadNotifications()->count(); @endphp
                @if($unreadNotif > 0)
                    <span class="absolute -top-0.5 -right-0.5 w-4 h-4 bg-red-500 text-white text-[9px] font-bold rounded-full flex items-center justify-center">
                        {{ $unreadNotif > 9 ? '9+' : $unreadNotif }}
                    </span>
                @endif
            </a>
            @endif

            <div
                x-data="{ open: false }"
                x-on:click.away="open = false"
                class="relative ml-2"
            >
                <button
                    x-on:click="open = !open"
                    class="flex items-center gap-2 hover:bg-surface-100 rounded-lg px-2 py-1.5 transition-all duration-200"
                >
                    <div class="w-8 h-8 rounded-full bg-navy-700 text-white flex items-center justify-center text-xs font-semibold">
                        {{ strtoupper(substr($user->first_name, 0, 1)) }}{{ strtoupper(substr($user->last_name, 0, 1)) }}
                    </div>
                    <span class="hidden sm:block text-sm font-medium text-surface-700">{{ $user->first_name }}</span>
                    <svg class="w-4 h-4 text-surface-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
                    </svg>
                </button>

                <div
                    x-show="open"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
                    x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                    class="absolute right-0 top-full mt-2 z-50 min-w-[200px] bg-white border border-surface-200 rounded-xl shadow-elevated py-1"
                    style="display: none;"
                    x-on:click="open = false"
                >
                    <div class="px-4 py-2 border-b border-surface-100">
                        <p class="text-sm font-semibold text-surface-900">{{ $user->fullName() }}</p>
                        <p class="text-xs text-surface-500">{{ $user->email }}</p>
                    </div>
                    <a href="{{ route('profile.edit') }}" class="w-full text-left px-4 py-2.5 text-sm text-surface-700 hover:bg-surface-50 flex items-center gap-3 transition-colors">
                        <svg class="w-4 h-4 text-surface-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                        </svg>
                        Mon profil
                    </a>
                    <div class="border-t border-surface-100 my-1"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 flex items-center gap-3 transition-colors">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9"/>
                            </svg>
                            Déconnexion
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>
