<x-app-layout>
    <div class="space-y-10">

        {{-- Welcome --}}
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-surface-900 tracking-tight">Bienvenue {{ auth()->user()->first_name }} 👋</h1>
            <p class="text-surface-500 mt-1">Retrouvez toutes vos réservations.</p>
        </div>

        {{-- Stats Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            <div class="card p-6 hover:shadow-card-hover hover:border-surface-300 transition-all duration-200">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-navy-50 flex items-center justify-center text-navy-700">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-surface-900">{{ $stats['total_reservations'] }}</p>
                        <p class="text-sm text-surface-500">Mes voyages</p>
                    </div>
                </div>
            </div>

            <div class="card p-6 hover:shadow-card-hover hover:border-surface-300 transition-all duration-200">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-surface-900">{{ $stats['upcoming_reservations'] }}</p>
                        <p class="text-sm text-surface-500">Réservations</p>
                    </div>
                </div>
            </div>

            <div class="card p-6 hover:shadow-card-hover hover:border-surface-300 transition-all duration-200">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-purple-50 flex items-center justify-center text-purple-600">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-surface-900">{{ $upcomingReservations->count() }}</p>
                        <p class="text-sm text-surface-500">Messages</p>
                    </div>
                </div>
            </div>

            <div class="card p-6 hover:shadow-card-hover hover:border-surface-300 transition-all duration-200">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-rose-50 flex items-center justify-center text-rose-600">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-surface-900">{{ $availableProperties->count() }}</p>
                        <p class="text-sm text-surface-500">Favoris</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Mes réservations --}}
        <div>
            <div class="flex items-center justify-between mb-5">
                <h2 class="text-lg font-semibold text-surface-900">Mes réservations</h2>
                <a href="{{ route('reservations.index') }}" class="text-sm font-medium text-navy-700 hover:text-navy-800 transition-colors">Voir tout</a>
            </div>
            @if ($upcomingReservations->isEmpty())
                <div class="card p-12 text-center">
                    <div class="w-14 h-14 rounded-2xl bg-surface-100 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-7 h-7 text-surface-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/>
                        </svg>
                    </div>
                    <p class="text-surface-500 mb-4">Aucune réservation pour le moment.</p>
                    <a href="{{ route('properties.index') }}" class="btn-primary px-5 py-2.5">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                        </svg>
                        Voir les logements
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                    @foreach ($upcomingReservations->take(3) as $reservation)
                        <div class="card overflow-hidden hover:shadow-card-hover hover:border-surface-300 transition-all duration-200 group">
                            <div class="h-40 bg-surface-100 relative overflow-hidden">
                                @if($reservation->property && $reservation->property->images->isNotEmpty())
                                    <img src="{{ Storage::url($reservation->property->images->first()->path) }}" alt="{{ $reservation->property->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <svg class="w-10 h-10 text-surface-300" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.41a2.25 2.25 0 013.182 0l2.909 2.91m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/>
                                        </svg>
                                    </div>
                                @endif
                                <span class="absolute top-3 right-3 badge
                                    {{ $reservation->status === 'confirmed' ? 'badge-success' : '' }}
                                    {{ $reservation->status === 'pending' ? 'badge-warning' : '' }}
                                    {{ $reservation->status === 'cancelled' ? 'badge-danger' : '' }}">
                                    @if($reservation->status === 'confirmed') Confirmée
                                    @elseif($reservation->status === 'pending') En attente
                                    @elseif($reservation->status === 'cancelled') Annulée
                                    @else {{ $reservation->status }}
                                    @endif
                                </span>
                            </div>
                            <div class="p-5">
                                <h3 class="font-semibold text-surface-900">{{ $reservation->property?->title ?? 'Logement' }}</h3>
                                @if($reservation->property)
                                    <p class="text-sm text-surface-500 mt-1">{{ $reservation->property->city }}</p>
                                @endif
                                <div class="flex items-center gap-2 mt-2 text-sm text-surface-500">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25"/>
                                    </svg>
                                    <span>{{ $reservation->check_in_date->format('d M') }} → {{ $reservation->check_out_date->format('d M Y') }}</span>
                                </div>
                                <p class="text-lg font-bold text-surface-900 mt-3">{{ number_format($reservation->total_price, 0, ',', ' ') }} MAD</p>
                                <div class="flex gap-2 mt-4 pt-4 border-t border-surface-100">
                                    <a href="{{ route('reservations.show', $reservation) }}" class="btn-secondary text-sm px-4 py-2 flex-1">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                        Voir
                                    </a>
                                    @if(Route::has('conversations.index'))
                                    <a href="{{ route('conversations.index') }}" class="btn-secondary text-sm px-4 py-2 flex-1">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z"/>
                                        </svg>
                                        Contacter
                                    </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Recommandations --}}
        <div>
            <div class="flex items-center justify-between mb-5">
                <h2 class="text-lg font-semibold text-surface-900">Recommandations</h2>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="card p-5 hover:shadow-card-hover hover:border-surface-300 transition-all duration-200 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-orange-50 flex items-center justify-center text-orange-600 flex-shrink-0">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 6.75V15m6-6v8.25m.503 3.498l4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.252a1.125 1.125 0 00-1.006 0L3.622 5.689C3.24 5.88 3 6.27 3 6.695V19.18c0 .836.88 1.38 1.628 1.006l3.869-1.934c.317-.159.69-.159 1.006 0l4.994 2.497c.317.158.69.158 1.006 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold text-surface-900">Restaurants</p>
                        <p class="text-xs text-surface-500 mt-0.5">Les meilleures adresses autour de vous</p>
                    </div>
                </div>
                <div class="card p-5 hover:shadow-card-hover hover:border-surface-300 transition-all duration-200 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-sky-50 flex items-center justify-center text-sky-600 flex-shrink-0">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 9V5.25A2.25 2.25 0 0110.5 3h6a2.25 2.25 0 012.25 2.25v13.5A2.25 2.25 0 0116.5 21h-6a2.25 2.25 0 01-2.25-2.25V15M12 9l3 3m0 0l-3 3m3-3H2.25"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold text-surface-900">Plages</p>
                        <p class="text-xs text-surface-500 mt-0.5">Découvrez les plus belles plages</p>
                    </div>
                </div>
                <div class="card p-5 hover:shadow-card-hover hover:border-surface-300 transition-all duration-200 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600 flex-shrink-0">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold text-surface-900">Surf</p>
                        <p class="text-xs text-surface-500 mt-0.5">Les meilleurs spots de surf</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
