<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ auth()->user()->isOwner() ? 'Mes logements' : 'Logements disponibles' }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">

            @if (session('status'))
                <div class="bg-green-100 text-green-800 p-3 rounded">{{ session('status') }}</div>
            @endif

            @if (auth()->user()->isOwner())
                <a href="{{ route('properties.create') }}" class="inline-block bg-indigo-600 text-white px-4 py-2 rounded">
                    + Ajouter un logement
                </a>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @foreach ($properties as $property)
                    <a href="{{ route('properties.show', $property) }}" class="block bg-white rounded shadow p-4 hover:shadow-md">
                        <h3 class="font-semibold">{{ $property->title }}</h3>
                        <p class="text-sm text-gray-500">{{ $property->city }}</p>
                        <p class="text-sm">{{ $property->price_per_night }} MAD / nuit</p>
                        <span class="text-xs uppercase text-gray-400">{{ $property->status }}</span>
                    </a>
                @endforeach
            </div>

            {{ $properties->links() }}
        </div>
    </div>
</x-app-layout>