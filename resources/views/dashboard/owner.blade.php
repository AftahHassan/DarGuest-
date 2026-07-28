<x-app-layout>
    <div class="space-y-10">

        {{-- Welcome --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-surface-900 tracking-tight">Bonjour {{ auth()->user()->first_name }} 👋</h1>
                <p class="text-surface-500 mt-1">Bienvenue sur votre espace propriétaire.</p>
            </div>
            <a href="{{ route('properties.create') }}" class="btn-primary px-5 py-2.5 self-start">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                </svg>
                Ajouter un logement
            </a>
        </div>

        {{-- Stats Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            <div class="card p-6 hover:shadow-card-hover hover:border-surface-300 transition-all duration-200">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-navy-50 flex items-center justify-center text-navy-700">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-surface-900">{{ $stats['total_properties'] }}</p>
                        <p class="text-sm text-surface-500">Mes logements</p>
                    </div>
                </div>
            </div>

            <div class="card p-6 hover:shadow-card-hover hover:border-surface-300 transition-all duration-200">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-surface-900">{{ $stats['total_reservations'] }}</p>
                        <p class="text-sm text-surface-500">Réservations</p>
                    </div>
                </div>
            </div>

            <div class="card p-6 hover:shadow-card-hover hover:border-surface-300 transition-all duration-200">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-purple-50 flex items-center justify-center text-purple-600">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.455 2.456L21.75 6l-1.036.259a3.375 3.375 0 00-2.455 2.456zM16.894 20.567L16.5 21.75l-.394-1.183a2.25 2.25 0 00-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 001.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 001.423 1.423l1.183.394-1.183.394a2.25 2.25 0 00-1.423 1.423z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-surface-900">{{ $stats['ai_messages_count'] }}</p>
                        <p class="text-sm text-surface-500">Messages IA</p>
                    </div>
                </div>
            </div>

            <div class="card p-6 hover:shadow-card-hover hover:border-surface-300 transition-all duration-200">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-amber-50 flex items-center justify-center text-amber-600">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-surface-900">{{ $stats['unread_notifications'] }}</p>
                        <p class="text-sm text-surface-500">Notifications</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Mes logements --}}
        <div>
            <div class="flex items-center justify-between mb-5">
                <h2 class="text-lg font-semibold text-surface-900">Mes logements</h2>
                <a href="{{ route('properties.index') }}" class="text-sm font-medium text-navy-700 hover:text-navy-800 transition-colors">Voir tout</a>
            </div>
            @if ($recentProperties->isEmpty())
                <div class="card p-12 text-center">
                    <div class="w-14 h-14 rounded-2xl bg-surface-100 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-7 h-7 text-surface-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/>
                        </svg>
                    </div>
                    <p class="text-surface-500 mb-4">Aucun logement pour l'instant.</p>
                    <a href="{{ route('properties.create') }}" class="btn-primary px-5 py-2.5">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                        </svg>
                        Ajouter un logement
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                    @foreach ($recentProperties->take(3) as $property)
                        <div class="card overflow-hidden hover:shadow-card-hover hover:border-surface-300 transition-all duration-200 group">
                            <div class="h-40 bg-surface-100 relative overflow-hidden">
                                @if($property->images->isNotEmpty())
                                    <img src="{{ Storage::url($property->images->first()->path) }}" alt="{{ $property->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <svg class="w-10 h-10 text-surface-300" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.41a2.25 2.25 0 013.182 0l2.909 2.91m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/>
                                        </svg>
                                    </div>
                                @endif
                                <span class="absolute top-3 right-3 badge {{ $property->status === 'available' ? 'badge-success' : 'badge-gray' }}">
                                    {{ $property->status === 'available' ? 'Disponible' : 'Occupé' }}
                                </span>
                            </div>
                            <div class="p-5">
                                <h3 class="font-semibold text-surface-900">{{ $property->title }}</h3>
                                <p class="text-sm text-surface-500 mt-1">{{ $property->city }}</p>
                                <p class="text-lg font-bold text-surface-900 mt-3">{{ number_format($property->price_per_night, 0, ',', ' ') }} <span class="text-xs font-normal text-surface-500">MAD/nuit</span></p>
                                <div class="flex gap-2 mt-4 pt-4 border-t border-surface-100">
                                    <a href="{{ route('properties.show', $property) }}" class="btn-secondary text-sm px-4 py-2 flex-1">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                        Voir
                                    </a>
                                    <a href="{{ route('properties.edit', $property) }}" class="btn-secondary text-sm px-4 py-2 flex-1">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/>
                                        </svg>
                                        Modifier
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Dernières réservations --}}
        <div class="card">
            <div class="flex items-center justify-between px-6 py-5 border-b border-surface-100">
                <h2 class="text-lg font-semibold text-surface-900">Dernières réservations</h2>
                <a href="{{ route('reservations.index') }}" class="text-sm font-medium text-navy-700 hover:text-navy-800 transition-colors">Voir tout</a>
            </div>
            <div class="overflow-x-auto">
                <table class="table w-full">
                    <thead>
                        <tr>
                            <th class="px-6 py-3.5 text-left">Voyageur</th>
                            <th class="px-6 py-3.5 text-left">Logement</th>
                            <th class="px-6 py-3.5 text-left hidden md:table-cell">Date</th>
                            <th class="px-6 py-3.5 text-left">Statut</th>
                            <th class="px-6 py-3.5 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($recentReservations->take(5) as $reservation)
                            <tr>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-navy-700 text-white flex items-center justify-center text-[10px] font-semibold">
                                            {{ strtoupper(substr($reservation->guest?->first_name ?? '?', 0, 1)) }}{{ strtoupper(substr($reservation->guest?->last_name ?? '?', 0, 1)) }}
                                        </div>
                                        <span class="font-medium text-surface-900 text-sm">{{ $reservation->guest?->fullName() ?? 'N/A' }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-surface-700">{{ $reservation->property?->title ?? 'N/A' }}</td>
                                <td class="px-6 py-4 text-sm text-surface-500 hidden md:table-cell">{{ $reservation->created_at->format('d M Y') }}</td>
                                <td class="px-6 py-4">
                                    @php
                                        $variant = match($reservation->status) {
                                            'confirmed' => 'success',
                                            'pending' => 'warning',
                                            'cancelled' => 'danger',
                                            default => 'gray',
                                        };
                                    @endphp
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-medium border {{ $variant === 'success' ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : '' }} {{ $variant === 'warning' ? 'bg-amber-50 text-amber-700 border-amber-200' : '' }} {{ $variant === 'danger' ? 'bg-red-50 text-red-700 border-red-200' : '' }} {{ $variant === 'gray' ? 'bg-surface-100 text-surface-600 border-surface-200' : '' }}">
                                        @if($reservation->status === 'confirmed') Confirmée
                                        @elseif($reservation->status === 'pending') En attente
                                        @elseif($reservation->status === 'cancelled') Annulée
                                        @else {{ $reservation->status }}
                                        @endif
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('reservations.show', $reservation) }}" class="text-sm font-medium text-navy-700 hover:text-navy-800 transition-colors">Voir</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-sm text-surface-500">
                                    <div class="flex flex-col items-center gap-2">
                                        <svg class="w-10 h-10 text-surface-300" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/>
                                        </svg>
                                        <span>Aucune réservation pour le moment.</span>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Assistant IA --}}
        <div class="card bg-gradient-to-br from-navy-700 to-navy-800 border-navy-700 p-6 text-white">
            <div class="flex items-center gap-3 mb-5">
                <div class="w-10 h-10 rounded-xl bg-white/10 backdrop-blur-sm border border-white/20 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.455 2.456L21.75 6l-1.036.259a3.375 3.375 0 00-2.455 2.456zM16.894 20.567L16.5 21.75l-.394-1.183a2.25 2.25 0 00-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 001.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 001.423 1.423l1.183.394-1.183.394a2.25 2.25 0 00-1.423 1.423z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold">Assistant IA</h3>
                    <p class="text-sm text-navy-200">Réponses automatiques à vos voyageurs</p>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4 mb-5">
                <div class="bg-white/10 backdrop-blur-sm rounded-xl border border-white/10 p-4">
                    <p class="text-2xl font-bold">{{ $stats['ai_messages_count'] }}</p>
                    <p class="text-xs text-navy-200 mt-1">Questions traitées</p>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-xl border border-white/10 p-4">
                    <p class="text-2xl font-bold">{{ $stats['urgent_messages'] }}</p>
                    <p class="text-xs text-navy-200 mt-1">Urgences détectées</p>
                </div>
            </div>
            <a href="{{ Route::has('ai-analysis.index') ? route('ai-analysis.index') : '#' }}"
               class="inline-flex items-center gap-2 px-5 py-2.5 bg-white text-navy-700 font-semibold rounded-xl hover:bg-navy-50 transition-all duration-200 text-sm shadow-lg">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                </svg>
                Voir les analyses
            </a>
        </div>

    </div>
</x-app-layout>
