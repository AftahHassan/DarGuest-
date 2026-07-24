<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Bienvenue, {{ auth()->user()->fullName() }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- Cartes statistiques --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                    <p class="text-sm text-gray-500">Mes réservations</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ $stats['total_reservations'] }}</p>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                    <p class="text-sm text-gray-500">À venir</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ $stats['upcoming_reservations'] }}</p>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                    <p class="text-sm text-gray-500">Notifications non lues</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ $stats['unread_notifications'] }}</p>
                </div>
            </div>

            <div class="flex flex-wrap gap-3">
                <a href="{{ route('properties.index') }}" class="bg-gray-900 text-white px-4 py-2 rounded-lg text-sm hover:bg-gray-700">
                    Voir les logements disponibles
                </a>
            </div>

            {{-- Logements suggérés --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-semibold text-gray-900 mb-4">Logements disponibles</h3>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @foreach ($availableProperties as $property)
                        <a href="{{ route('properties.show', $property) }}" class="border border-gray-100 rounded-lg p-4 hover:shadow-md transition">
                            <p class="font-medium text-gray-800">{{ $property->title }}</p>
                            <p class="text-xs text-gray-500">{{ $property->city }}</p>
                            <p class="text-sm font-semibold mt-1">{{ $property->price_per_night }} MAD/nuit</p>
                        </a>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</x-app-layout>