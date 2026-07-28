<x-app-layout>
    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-bold text-surface-900">
                    {{ auth()->user()->isOwner() ? 'Mes logements' : 'Logements disponibles' }}
                </h1>

                @if (auth()->user()->isOwner())
                    <a href="{{ route('properties.create') }}" class="btn-primary">
                        + Ajouter un logement
                    </a>
                @endif
            </div>

            @if (session('status'))
                <div class="alert-success">{{ session('status') }}</div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @foreach ($properties as $property)
                    <a href="{{ route('properties.show', $property) }}" class="card p-4 hover:shadow-elevated transition-shadow duration-200 block">
                        <h3 class="font-semibold text-surface-900">{{ $property->title }}</h3>
                        <p class="text-sm text-surface-500 mt-1">{{ $property->city }}</p>
                        <p class="text-sm font-semibold text-navy-700 mt-1">{{ $property->price_per_night }} MAD / nuit</p>
                        <span class="badge badge-gray mt-2">{{ $property->status }}</span>
                    </a>
                @endforeach
            </div>

            {{ $properties->links() }}
        </div>
    </div>
</x-app-layout>