<x-app-layout>
    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <h1 class="text-2xl font-bold text-surface-900">Bienvenue, {{ auth()->user()->fullName() }}</h1>

            {{-- Cartes statistiques --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                <div class="card p-5">
                    <p class="text-sm text-surface-500">Mes réservations</p>
                    <p class="text-3xl font-bold text-surface-900 mt-1">{{ $stats['total_reservations'] }}</p>
                </div>

                <div class="card p-5">
                    <p class="text-sm text-surface-500">À venir</p>
                    <p class="text-3xl font-bold text-surface-900 mt-1">{{ $stats['upcoming_reservations'] }}</p>
                </div>

                <div class="card p-5">
                    <p class="text-sm text-surface-500">Notifications non lues</p>
                    <p class="text-3xl font-bold text-surface-900 mt-1">{{ $stats['unread_notifications'] }}</p>
                </div>
            </div>

            <div class="flex flex-wrap gap-3">
                <a href="{{ route('properties.index') }}" class="btn-primary">
                    Voir les logements disponibles
                </a>
            </div>

            {{-- Logements suggérés --}}
            <div class="card p-6">
                <h3 class="font-semibold text-surface-900 mb-4">Logements disponibles</h3>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @foreach ($availableProperties as $property)
                        <a href="{{ route('properties.show', $property) }}" class="card p-4 hover:shadow-elevated transition-shadow duration-200 block">
                            <p class="font-medium text-surface-900">{{ $property->title }}</p>
                            <p class="text-xs text-surface-500">{{ $property->city }}</p>
                            <p class="text-sm font-semibold mt-1 text-navy-700">{{ $property->price_per_night }} MAD/nuit</p>
                        </a>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</x-app-layout>