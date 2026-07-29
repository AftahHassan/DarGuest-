<x-app-layout>
    <div class="space-y-12">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
            <div>
                <p class="text-xs font-semibold text-navy-700 uppercase tracking-widest">Gestion des logements</p>
                <h1 class="text-2xl sm:text-3xl font-bold text-surface-900 tracking-tight mt-1">
                    {{ auth()->user()->isOwner() ? 'Mes logements' : 'Logements disponibles' }}
                </h1>
                <p class="text-surface-500 mt-1">Gérez tous vos logements depuis une seule interface.</p>
            </div>
            @can('create', App\Models\Property::class)
                <a href="{{ route('properties.create') }}" class="btn-primary shrink-0">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                    Nouveau logement
                </a>
            @endcan
        </div>

        @if (session('status'))
            <div class="alert-success">{{ session('status') }}</div>
        @endif

        {{-- Filters --}}
        <form method="GET" class="bg-white/60 backdrop-blur-sm border border-surface-200/60 rounded-2xl p-5 space-y-4" data-aos="fade-up">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-4">
                <div class="lg:col-span-2">
                    <label class="text-xs font-semibold text-surface-500 uppercase tracking-wider">Rechercher</label>
                    <div class="relative mt-1">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-surface-400 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Titre, ville…"
                               class="w-full rounded-xl border-surface-200/60 bg-white/80 text-sm pl-9 pr-4 py-2.5 focus:border-navy-300 focus:ring-2 focus:ring-navy-500/20 focus:outline-none placeholder:text-surface-400 transition-all duration-200">
                    </div>
                </div>
                <div>
                    <label class="text-xs font-semibold text-surface-500 uppercase tracking-wider">Ville</label>
                    <select name="city" class="mt-1 w-full rounded-xl border-surface-200/60 bg-white/80 text-sm py-2.5 focus:border-navy-300 focus:ring-2 focus:ring-navy-500/20 focus:outline-none transition-all duration-200">
                        <option value="">Toutes</option>
                        @foreach ($cities as $c)
                            <option value="{{ $c }}" @selected(request('city') === $c)>{{ $c }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="text-xs font-semibold text-surface-500 uppercase tracking-wider">Statut</label>
                    <select name="status" class="mt-1 w-full rounded-xl border-surface-200/60 bg-white/80 text-sm py-2.5 focus:border-navy-300 focus:ring-2 focus:ring-navy-500/20 focus:outline-none transition-all duration-200">
                        <option value="">Tous</option>
                        <option value="available" @selected(request('status') === 'available')>Disponible</option>
                        <option value="unavailable" @selected(request('status') === 'unavailable')>Indisponible</option>
                        <option value="maintenance" @selected(request('status') === 'maintenance')>Maintenance</option>
                    </select>
                </div>
                <div>
                    <label class="text-xs font-semibold text-surface-500 uppercase tracking-wider">Prix max</label>
                    <input type="number" name="price_max" value="{{ request('price_max') }}" placeholder="10 000" min="0"
                           class="mt-1 w-full rounded-xl border-surface-200/60 bg-white/80 text-sm px-4 py-2.5 focus:border-navy-300 focus:ring-2 focus:ring-navy-500/20 focus:outline-none placeholder:text-surface-400 transition-all duration-200">
                </div>
                <div>
                    <label class="text-xs font-semibold text-surface-500 uppercase tracking-wider">Trier par</label>
                    <select name="sort" class="mt-1 w-full rounded-xl border-surface-200/60 bg-white/80 text-sm py-2.5 focus:border-navy-300 focus:ring-2 focus:ring-navy-500/20 focus:outline-none transition-all duration-200">
                        <option value="">Plus récents</option>
                        <option value="price_asc" @selected(request('sort') === 'price_asc')>Prix croissant</option>
                        <option value="price_desc" @selected(request('sort') === 'price_desc')>Prix décroissant</option>
                        <option value="name_asc" @selected(request('sort') === 'name_asc')>Nom A-Z</option>
                        <option value="name_desc" @selected(request('sort') === 'name_desc')>Nom Z-A</option>
                        <option value="date_asc" @selected(request('sort') === 'date_asc')>Plus anciens</option>
                    </select>
                </div>
            </div>
            <div class="flex gap-3">
                <button type="submit" class="btn-primary text-sm px-5 py-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
                    Filtrer
                </button>
                @if(request()->anyFilled(['search', 'status', 'city', 'price_max', 'sort']))
                    <a href="{{ route('properties.index') }}" class="btn-secondary text-sm px-5 py-2">Réinitialiser</a>
                @endif
            </div>
        </form>

        {{-- Results count --}}
        <p class="text-sm text-surface-500" data-aos="fade-up">
            <span class="font-semibold text-surface-700">{{ $properties->total() }}</span> logement{{ $properties->total() > 1 ? 's' : '' }} trouvé{{ $properties->total() > 1 ? 's' : '' }}
        </p>

        {{-- Grid --}}
        @if ($properties->count())
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($properties as $property)
                    <div class="group bg-white/60 backdrop-blur-sm border border-surface-200/60 rounded-2xl overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300 hover:border-navy-200/50" data-aos="fade-up" data-aos-delay="{{ $loop->index * 50 }}">
                        {{-- Image --}}
                        <div class="relative h-52 overflow-hidden bg-surface-100">
                            <x-gallery :images="$property->images" class="!w-full !h-full">
                                <div class="w-full h-full flex items-center justify-center">
                                    <svg class="w-10 h-10 text-surface-300" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.41a2.25 2.25 0 013.182 0l2.909 2.91m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/>
                                    </svg>
                                </div>
                            </x-gallery>

                            {{-- Overlay --}}
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

                            {{-- Badge --}}
                            <div class="absolute top-3 right-3 z-10">
                                @php
                                    $statusVariant = match($property->status) {
                                        'available' => 'success',
                                        'unavailable' => 'gray',
                                        'maintenance' => 'warning',
                                        default => 'gray',
                                    };
                                @endphp
                                <x-ui.badge :variant="$statusVariant" dot>
                                    @if($property->status === 'available') Disponible
                                    @elseif($property->status === 'unavailable') Indisponible
                                    @elseif($property->status === 'maintenance') Maintenance
                                    @else {{ $property->status }}
                                    @endif
                                </x-ui.badge>
                            </div>

                            {{-- Overlay actions --}}
                            <div class="absolute inset-x-0 bottom-0 p-4 flex gap-2 translate-y-4 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-300 z-10">
                                <a href="{{ route('properties.show', $property) }}" class="flex-1 bg-white/90 backdrop-blur-sm hover:bg-white text-surface-900 text-xs font-medium rounded-xl py-2.5 text-center transition-all duration-200">
                                    <svg class="w-4 h-4 inline mr-1" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    Voir
                                </a>
                                @can('update', $property)
                                    <a href="{{ route('properties.edit', $property) }}" class="bg-white/90 backdrop-blur-sm hover:bg-white text-surface-900 text-xs font-medium rounded-xl py-2.5 px-4 transition-all duration-200">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125"/></svg>
                                    </a>
                                @endcan
                            </div>
                        </div>

                        {{-- Content --}}
                        <div class="p-5">
                            <div class="flex items-start justify-between gap-2">
                                <div class="min-w-0">
                                    <h3 class="font-semibold text-surface-900 truncate">{{ $property->title }}</h3>
                                    <p class="text-sm text-surface-500 mt-0.5 truncate">{{ $property->address }}, {{ $property->city }}</p>
                                </div>
                            </div>

                            <div class="flex items-center gap-4 mt-3 text-sm text-surface-600">
                                <span class="flex items-center gap-1">
                                    <svg class="w-4 h-4 text-surface-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"/></svg>
                                    {{ $property->capacity }}
                                </span>
                                <span class="flex items-center gap-1">
                                    <svg class="w-4 h-4 text-surface-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 20.25h12m-7.5-3v3m3-3v3m-10-3a3 3 0 01-3-3V6a3 3 0 013-3h12a3 3 0 013 3v8.25a3 3 0 01-3 3m-15 0h15"/></svg>
                                    {{ $property->bedrooms }}
                                </span>
                                <span class="flex items-center gap-1">
                                    <svg class="w-4 h-4 text-surface-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 2.994v3.264m12-3.264v3.264M6.75 6h4.5m-4.5 0H4.5m2.25 0v5.25M6.75 6h9m-9 0H3.75m12 0h2.25m-2.25 0v5.25M12 6V3.75m0 0H9.75M12 3.75h2.25M18.75 6v5.25M6.75 15h.008v.008H6.75V15zm3 0h.008v.008H9.75V15zm3 0h.008v.008H12.75V15zm3 0h.008v.008H15.75V15zm3 0h.008v.008H18.75V15z"/></svg>
                                    {{ $property->bathrooms }}
                                </span>
                            </div>

                            <div class="flex items-center justify-between mt-4 pt-4 border-t border-surface-200/60">
                                <p class="text-lg font-bold text-surface-900">{{ number_format($property->price_per_night, 0, ',', ' ') }} <span class="text-xs font-normal text-surface-500">MAD/nuit</span></p>
                                <p class="text-xs text-surface-400">{{ $property->created_at->format('d/m/Y') }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div data-aos="fade-up">
                <x-ui.pagination :paginator="$properties" />
            </div>
        @else
            {{-- Empty state --}}
            <div class="bg-white/60 backdrop-blur-sm border border-surface-200/60 rounded-2xl p-12 sm:p-16 text-center" data-aos="fade-up">
                <div class="w-16 h-16 rounded-2xl bg-surface-100 flex items-center justify-center mx-auto mb-5">
                    <svg class="w-8 h-8 text-surface-400" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-surface-900 mb-1">Vous n'avez encore aucun logement</h3>
                <p class="text-sm text-surface-500 max-w-sm mx-auto mb-6">Commencez par créer votre premier logement dès maintenant.</p>
                @can('create', App\Models\Property::class)
                    <a href="{{ route('properties.create') }}" class="btn-primary">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                        Créer un logement
                    </a>
                @endcan
            </div>
        @endif

    </div>
</x-app-layout>