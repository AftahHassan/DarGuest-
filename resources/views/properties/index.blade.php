<x-app-layout>
    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-bold text-surface-900">
                    {{ auth()->user()->isOwner() ? 'Mes logements' : 'Logements disponibles' }}
                </h1>
                @if (auth()->user()->isOwner())
                    <a href="{{ route('properties.create') }}" class="btn-primary">+ Ajouter un logement</a>
                @endif
            </div>

            @if (session('status'))
                <div class="alert-success">{{ session('status') }}</div>
            @endif

            <form method="GET" class="bg-white/60 backdrop-blur-sm border border-surface-200/60 rounded-2xl p-5 space-y-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
                    <div>
                        <label class="text-xs font-semibold text-surface-500 uppercase tracking-wider">Rechercher</label>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Titre ou ville…"
                               class="mt-1 w-full rounded-xl border-surface-200/60 bg-white/80 text-sm focus:border-navy-300 focus:ring-navy-200">
                    </div>
                    <div>
                        <label class="text-xs font-semibold text-surface-500 uppercase tracking-wider">Statut</label>
                        <select name="status" class="mt-1 w-full rounded-xl border-surface-200/60 bg-white/80 text-sm focus:border-navy-300 focus:ring-navy-200">
                            <option value="">Tous</option>
                            <option value="available" @selected(request('status') === 'available')>Disponible</option>
                            <option value="unavailable" @selected(request('status') === 'unavailable')>Indisponible</option>
                            <option value="maintenance" @selected(request('status') === 'maintenance')>Maintenance</option>
                        </select>
                    </div>
                    <div>
                        <label class="text-xs font-semibold text-surface-500 uppercase tracking-wider">Ville</label>
                        <select name="city" class="mt-1 w-full rounded-xl border-surface-200/60 bg-white/80 text-sm focus:border-navy-300 focus:ring-navy-200">
                            <option value="">Toutes</option>
                            @foreach ($cities as $c)
                                <option value="{{ $c }}" @selected(request('city') === $c)>{{ $c }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="text-xs font-semibold text-surface-500 uppercase tracking-wider">Prix min</label>
                        <input type="number" name="price_min" value="{{ request('price_min') }}" placeholder="0" min="0"
                               class="mt-1 w-full rounded-xl border-surface-200/60 bg-white/80 text-sm focus:border-navy-300 focus:ring-navy-200">
                    </div>
                    <div>
                        <label class="text-xs font-semibold text-surface-500 uppercase tracking-wider">Prix max</label>
                        <input type="number" name="price_max" value="{{ request('price_max') }}" placeholder="10000" min="0"
                               class="mt-1 w-full rounded-xl border-surface-200/60 bg-white/80 text-sm focus:border-navy-300 focus:ring-navy-200">
                    </div>
                </div>
                <div class="flex gap-3">
                    <button type="submit" class="btn-primary text-sm px-5 py-2">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
                        Filtrer
                    </button>
                    @if(request()->anyFilled(['search', 'status', 'city', 'price_min', 'price_max']))
                        <a href="{{ route('properties.index') }}" class="btn-secondary text-sm px-5 py-2">Réinitialiser</a>
                    @endif
                </div>
            </form>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @forelse ($properties as $property)
                    <a href="{{ route('properties.show', $property) }}" class="bg-white/60 backdrop-blur-sm border border-surface-200/60 rounded-2xl p-5 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 hover:border-navy-200/50 block group">
                        <h3 class="font-semibold text-surface-900 group-hover:text-navy-700 transition-colors">{{ $property->title }}</h3>
                        <p class="text-sm text-surface-500 mt-1">{{ $property->city }}</p>
                        <p class="text-sm font-bold text-navy-700 mt-2">{{ number_format($property->price_per_night, 0, ',', ' ') }} MAD / nuit</p>
                        <span class="badge @if($property->status === 'available') badge-success @else badge-gray @endif mt-3">
                            @if($property->status === 'available') Disponible
                            @elseif($property->status === 'unavailable') Indisponible
                            @elseif($property->status === 'maintenance') Maintenance
                            @else {{ $property->status }}
                            @endif
                        </span>
                    </a>
                @empty
                    <div class="col-span-full p-6 text-sm text-surface-500 text-center bg-white/60 backdrop-blur-sm border border-surface-200/60 rounded-2xl">
                        Aucun logement trouvé.
                    </div>
                @endforelse
            </div>

            {{ $properties->links() }}
        </div>
    </div>
</x-app-layout>