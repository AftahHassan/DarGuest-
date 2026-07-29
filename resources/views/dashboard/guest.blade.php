<x-app-layout>
    <div class="space-y-12">

        {{-- Welcome --}}
        <div data-aos="fade-up" class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <span class="text-xs font-semibold text-navy-700 uppercase tracking-widest">Tableau de bord</span>
                <h1 class="mt-3 text-2xl sm:text-3xl font-bold text-surface-900 tracking-tight">Bienvenue {{ auth()->user()->first_name }} 👋</h1>
                <p class="text-surface-500 mt-1">Retrouvez toutes vos réservations.</p>
            </div>
            <a href="{{ route('properties.index') }}"
               class="inline-flex items-center gap-2 px-6 py-3 bg-white text-surface-900 font-semibold rounded-2xl border border-surface-200/60 hover:bg-white/90 transition-all duration-300 shadow-xl hover:shadow-2xl hover:-translate-y-0.5">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                </svg>
                Voir les logements
            </a>
        </div>

        {{-- Stats Cards --}}
        <div data-aos="fade-up" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @php
                $guestStatCards = [
                    ['icon' => 'M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5', 'value' => $stats['total_reservations'], 'label' => 'Mes voyages'],
                    ['icon' => 'M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'value' => $stats['upcoming_reservations'], 'label' => 'Réservations'],
                    ['icon' => 'M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z', 'value' => $upcomingReservations->count(), 'label' => 'Messages'],
                    ['icon' => 'M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z', 'value' => $availableProperties->count(), 'label' => 'Favoris'],
                ];
            @endphp
            @foreach ($guestStatCards as $i => $card)
                <div class="group bg-white/60 backdrop-blur-sm border border-surface-200/60 rounded-2xl p-6 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 hover:border-navy-200/50">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-navy-50 flex items-center justify-center group-hover:bg-navy-100 transition-colors">
                            <svg class="w-6 h-6 text-navy-700" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $card['icon'] }}"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-surface-900">{{ $card['value'] }}</p>
                            <p class="text-sm text-surface-500 mt-0.5">{{ $card['label'] }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Mes réservations --}}
        <div data-aos="fade-up">
            <div class="flex items-center justify-between mb-5">
                <div>
                    <span class="text-xs font-semibold text-navy-700 uppercase tracking-widest">Réservations</span>
                    <h2 class="mt-2 text-lg font-semibold text-surface-900">Mes réservations</h2>
                </div>
                <a href="{{ route('reservations.index') }}" class="text-sm font-medium text-navy-700 hover:text-navy-800 transition-colors">Voir tout</a>
            </div>
            @if ($upcomingReservations->isEmpty())
                <div class="bg-white/60 backdrop-blur-sm border border-surface-200/60 rounded-2xl p-12 text-center">
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
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($upcomingReservations->take(3) as $reservation)
                        <div class="group bg-white/60 backdrop-blur-sm border border-surface-200/60 rounded-2xl overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300 hover:border-navy-200/50">
                            <div class="h-40 bg-surface-100 relative overflow-hidden">
                                @if($reservation->property && $reservation->property->images->isNotEmpty())
                                    <img src="{{ Storage::url($reservation->property->images->first()->image) }}" alt="{{ $reservation->property->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
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
                                <div class="flex gap-2 mt-4 pt-4 border-t border-surface-200/60">
                                    <a href="{{ route('reservations.show', $reservation) }}" class="btn-secondary text-sm px-4 py-2 flex-1">Voir</a>
                                    @if(Route::has('conversations.index'))
                                    <a href="{{ route('conversations.index') }}" class="btn-secondary text-sm px-4 py-2 flex-1">Contacter</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Logements disponibles --}}
        <div data-aos="fade-up">
            <div class="flex items-center justify-between mb-5">
                <div>
                    <span class="text-xs font-semibold text-navy-700 uppercase tracking-widest">Découvrir</span>
                    <h2 class="mt-2 text-lg font-semibold text-surface-900">Logements disponibles</h2>
                </div>
                <a href="{{ route('properties.index') }}" class="text-sm font-medium text-navy-700 hover:text-navy-800 transition-colors">Voir tout</a>
            </div>
            @if ($availableProperties->isEmpty())
                <div class="bg-white/60 backdrop-blur-sm border border-surface-200/60 rounded-2xl p-12 text-center">
                    <div class="w-14 h-14 rounded-2xl bg-surface-100 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-7 h-7 text-surface-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/>
                        </svg>
                    </div>
                    <p class="text-surface-500">Aucun logement disponible pour le moment.</p>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($availableProperties->take(3) as $property)
                        <div class="group bg-white/60 backdrop-blur-sm border border-surface-200/60 rounded-2xl overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300 hover:border-navy-200/50">
                            <div class="h-40 bg-surface-100 relative overflow-hidden">
                                @if($property->images->isNotEmpty())
                                    <img src="{{ Storage::url($property->images->first()->image) }}" alt="{{ $property->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <svg class="w-10 h-10 text-surface-300" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.41a2.25 2.25 0 013.182 0l2.909 2.91m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/>
                                        </svg>
                                    </div>
                                @endif
                                <div class="absolute top-3 right-3 badge badge-success">Disponible</div>
                            </div>
                            <div class="p-5">
                                <h3 class="font-semibold text-surface-900">{{ $property->title }}</h3>
                                <p class="text-sm text-surface-500 mt-1">{{ $property->city }}</p>
                                <p class="text-lg font-bold text-surface-900 mt-3">{{ number_format($property->price_per_night, 0, ',', ' ') }} <span class="text-xs font-normal text-surface-500">MAD/nuit</span></p>
                                <div class="flex gap-2 mt-4 pt-4 border-t border-surface-200/60">
                                    <a href="{{ route('properties.show', $property) }}" class="btn-primary text-sm px-4 py-2 flex-1">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                                        </svg>
                                        Voir
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

    </div>
</x-app-layout>
