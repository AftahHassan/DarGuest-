<x-app-layout>
    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <h1 class="text-2xl font-bold text-surface-900">Tableau de bord — {{ auth()->user()->fullName() }}</h1>

            {{-- Cartes statistiques --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
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

                <div class="card p-5">
                    <p class="text-sm text-surface-500">Notifications non lues</p>
                    <p class="text-3xl font-bold text-surface-900 mt-1">{{ $stats['unread_notifications'] }}</p>
                </div>

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

        </div>
    </div>
</x-app-layout>