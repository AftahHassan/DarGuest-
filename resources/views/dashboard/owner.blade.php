<x-app-layout>
    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <h1 class="text-2xl font-bold text-surface-900">Tableau de bord — {{ auth()->user()->fullName() }}</h1>

            {{-- Cartes statistiques --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-5">
                <div class="card p-5">
                    <p class="text-sm text-surface-500">Logements</p>
                    <p class="text-3xl font-bold text-surface-900 mt-1">{{ $stats['total_properties'] }}</p>
                    <p class="text-xs text-surface-400 mt-1">{{ $stats['available_properties'] }} disponibles</p>
                </div>

                <div class="card p-5">
                    <p class="text-sm text-surface-500">Réservations</p>
                    <p class="text-3xl font-bold text-surface-900 mt-1">{{ $stats['total_reservations'] }}</p>
                    <p class="text-xs text-surface-400 mt-1">Toutes propriétés confondues</p>
                </div>

                <a href="{{ route('reservations.index') }}" class="card p-5 block hover:shadow-md transition-shadow duration-150">
                    <p class="text-sm text-surface-500">Réservations en attente</p>
                    <p class="text-3xl font-bold text-surface-900 mt-1">{{ $stats['pending_reservations'] }}</p>
                </a>

                <a href="{{ route('notifications.index') }}" class="card p-5 block hover:shadow-md transition-shadow duration-150">
                    <p class="text-sm text-surface-500">Notifications non lues</p>
                    <p class="text-3xl font-bold text-surface-900 mt-1">{{ $stats['unread_notifications'] }}</p>
                </a>

                <div class="card bg-navy-700 border-navy-700 p-5 flex flex-col justify-between">
                    <p class="text-sm text-navy-200">Action rapide</p>
                    <a href="{{ route('properties.create') }}" class="mt-2 inline-block bg-white text-navy-700 font-medium text-sm rounded-lg px-4 py-2 text-center hover:bg-navy-50">
                        + Nouveau logement
                    </a>
                </div>
            </div>

            {{-- Boutons de navigation --}}
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('properties.index') }}" class="btn-primary">
                    Voir tous mes logements
                </a>
                <a href="{{ route('properties.create') }}" class="btn-secondary">
                    Ajouter un logement
                </a>
            </div>

            {{-- Logements récents --}}
            <div class="card p-6">
                <h3 class="font-semibold text-surface-900 mb-4">Logements récents</h3>

                @if ($recentProperties->isEmpty())
                    <p class="text-sm text-surface-500">Aucun logement pour l'instant. <a href="{{ route('properties.create') }}" class="text-navy-700 underline font-medium">Créer le premier</a>.</p>
                @else
                    <div class="divide-y divide-surface-100">
                        @foreach ($recentProperties as $property)
                            <a href="{{ route('properties.show', $property) }}" class="flex items-center justify-between py-3 hover:bg-surface-50 -mx-2 px-2 rounded-lg transition-colors duration-150">
                                <div>
                                    <p class="font-medium text-surface-900">{{ $property->title }}</p>
                                    <p class="text-xs text-surface-500">{{ $property->city }} · {{ $property->price_per_night }} MAD/nuit</p>
                                </div>
                                <span class="badge {{ $property->status === 'available' ? 'badge-success' : 'badge-gray' }}">
                                    {{ $property->status }}
                                </span>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Urgences détectées par l'IA --}}
            @if ($urgentAnalyses->isNotEmpty())
                <div class="bg-red-50 border border-red-200 rounded-xl p-6">
                    <h3 class="font-semibold text-red-700 mb-4">⚠️ Urgences détectées</h3>
                    <div class="divide-y divide-red-100">
                        @foreach ($urgentAnalyses as $analysis)
                            <a href="{{ route('reservations.show', $analysis->message->conversation->reservation) }}" class="flex justify-between py-3 hover:bg-red-100/50 -mx-2 px-2 rounded transition">
                                <div>
                                    <p class="font-medium text-red-800">{{ $analysis->message->conversation->reservation?->property?->title ?? 'Logement supprimé' }}</p>
                                    <p class="text-sm text-red-600">{{ $analysis->message->message }}</p>
                                </div>
                                <span class="text-xs text-red-500">{{ $analysis->analyzed_at->diffForHumans() }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Conversations récentes --}}
            <div class="card p-6">
                <h3 class="font-semibold text-surface-900 mb-4">Conversations récentes</h3>
                <div class="divide-y divide-surface-100">
                    @forelse ($recentConversations as $conversation)
                        <a href="{{ route('reservations.show', $conversation->reservation) }}" class="flex justify-between py-3 hover:bg-surface-50 -mx-2 px-2 rounded transition">
                            <div>
                                <p class="font-medium text-surface-900">{{ $conversation->reservation?->property?->title ?? 'Logement supprimé' }}</p>
                                <p class="text-xs text-surface-500">{{ $conversation->reservation->guest?->fullName() ?? 'N/A' }}</p>
                            </div>
                            <span class="text-xs text-surface-400">{{ $conversation->created_at->diffForHumans() }}</span>
                        </a>
                    @empty
                        <p class="text-sm text-surface-500 py-3">Aucune conversation pour l'instant.</p>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</x-app-layout>