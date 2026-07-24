<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tableau de bord — {{ auth()->user()->fullName() }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- Cartes statistiques --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                    <p class="text-sm text-gray-500">Logements</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ $stats['total_properties'] }}</p>
                    <p class="text-xs text-gray-400 mt-1">{{ $stats['available_properties'] }} disponibles</p>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                    <p class="text-sm text-gray-500">Réservations</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ $stats['total_reservations'] }}</p>
                    <p class="text-xs text-gray-400 mt-1">Toutes propriétés confondues</p>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                    <p class="text-sm text-gray-500">Notifications non lues</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ $stats['unread_notifications'] }}</p>
                </div>

                <div class="bg-indigo-600 rounded-xl shadow-sm p-5 flex flex-col justify-between">
                    <p class="text-sm text-indigo-100">Action rapide</p>
                    <a href="{{ route('properties.create') }}" class="mt-2 inline-block bg-white text-indigo-600 font-medium text-sm rounded-lg px-4 py-2 text-center hover:bg-indigo-50">
                        + Nouveau logement
                    </a>
                </div>
            </div>

            {{-- Boutons de navigation --}}
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('properties.index') }}" class="bg-gray-900 text-white px-4 py-2 rounded-lg text-sm hover:bg-gray-700">
                    Voir tous mes logements
                </a>
                <a href="{{ route('properties.create') }}" class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-lg text-sm hover:bg-gray-50">
                    Ajouter un logement
                </a>
            </div>

            {{-- Logements récents --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-semibold text-gray-900 mb-4">Logements récents</h3>

                @if ($recentProperties->isEmpty())
                    <p class="text-sm text-gray-500">Aucun logement pour l'instant. <a href="{{ route('properties.create') }}" class="text-indigo-600 underline">Créer le premier</a>.</p>
                @else
                    <div class="divide-y divide-gray-100">
                        @foreach ($recentProperties as $property)
                            <a href="{{ route('properties.show', $property) }}" class="flex items-center justify-between py-3 hover:bg-gray-50 -mx-2 px-2 rounded">
                                <div>
                                    <p class="font-medium text-gray-800">{{ $property->title }}</p>
                                    <p class="text-xs text-gray-500">{{ $property->city }} · {{ $property->price_per_night }} MAD/nuit</p>
                                </div>
                                <span class="text-xs px-2 py-1 rounded-full
                                    {{ $property->status === 'available' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
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