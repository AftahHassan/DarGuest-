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
                <x-button href="{{ route('properties.create') }}" class="shrink-0">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                    Nouveau logement
                </x-button>
            @endcan
        </div>

        @if (session('status'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2" class="alert-success flex items-center justify-between" role="alert">
                <span>{{ session('status') }}</span>
                <button type="button" x-on:click="show = false" class="ml-4 text-emerald-700 hover:text-emerald-900">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        @endif

        {{-- Filters --}}
        <form method="GET" class="panel p-5 space-y-4">
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
                <x-button type="submit">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
                    Filtrer
                </x-button>
                @if(request()->anyFilled(['search', 'status', 'city', 'price_max', 'sort']))
                    <x-button href="{{ route('properties.index') }}" variant="secondary">Réinitialiser</x-button>
                @endif
            </div>
        </form>

        {{-- Results count --}}
        <p class="text-sm text-surface-500">
            <span class="font-semibold text-surface-700">{{ $properties->total() }}</span> logement{{ $properties->total() > 1 ? 's' : '' }} trouvé{{ $properties->total() > 1 ? 's' : '' }}
        </p>

        {{-- Grid --}}
        @if ($properties->count())
            <div x-data="{ deleteId: null }">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($properties as $property)
                    <div class="group panel-hover overflow-hidden">
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
                                <x-button href="{{ route('properties.show', $property) }}" size="sm" class="flex-1">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    Voir
                                </x-button>
                                @can('update', $property)
                                <x-button href="{{ route('properties.edit', $property) }}" size="sm" class="flex-1">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125"/></svg>
                                    Modifier
                                </x-button>
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
                                @can('update', $property)
                                    <div class="flex gap-1">
                                        <a href="{{ route('properties.edit', $property) }}" class="text-xs font-medium text-navy-600 hover:text-navy-800 transition-colors px-2.5 py-1.5 rounded-lg hover:bg-navy-50 flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125"/></svg>
                                            Modifier
                                        </a>
                                        @can('delete', $property)
                                            <button type="button" x-on:click="deleteId = {{ $property->id }}; $dispatch('open-modal', 'delete-property')" class="text-xs font-medium text-red-500 hover:text-red-700 transition-colors px-2.5 py-1.5 rounded-lg hover:bg-red-50 flex items-center gap-1">
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                                                Supprimer
                                            </button>
                                        @endcan
                                    </div>
                                @endcan
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div>
                <x-ui.pagination :paginator="$properties" />
            </div>

            {{-- Delete property modal --}}
            <x-ui.modal id="delete-property" maxWidth="sm">
                <div class="text-center">
                    <div class="w-14 h-14 rounded-2xl bg-red-50 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-7 h-7 text-red-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg>
                    </div>
                    <h3 class="text-lg font-semibold text-surface-900 mb-1">Supprimer ce logement ?</h3>
                    <p class="text-sm text-surface-500 mb-2">Cette action est irréversible.</p>
                    <p class="text-xs text-surface-400 mb-6">Toutes les données associées seront définitivement supprimées.</p>
                    <div class="flex items-center justify-center gap-3">
                        <x-button variant="secondary" size="sm" x-on:click="$dispatch('close-modal', 'delete-property')">Annuler</x-button>
                        <form x-ref="deleteForm" method="POST" x-bind:action="'{{ url('properties') }}/' + deleteId">
                            @csrf @method('DELETE')
                            <x-button type="submit" variant="danger" size="sm">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                Supprimer
                            </x-button>
                        </form>
                    </div>
                </div>
            </x-ui.modal>
            </div>
        @else
            {{-- Empty state --}}
            <div class="panel p-12 sm:p-16 text-center">
                <div class="w-16 h-16 rounded-2xl bg-surface-100 flex items-center justify-center mx-auto mb-5">
                    <svg class="w-8 h-8 text-surface-400" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-surface-900 mb-1">Vous n'avez encore aucun logement</h3>
                <p class="text-sm text-surface-500 max-w-sm mx-auto mb-6">Commencez par créer votre premier logement dès maintenant.</p>
                @can('create', App\Models\Property::class)
                    <x-button href="{{ route('properties.create') }}">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                        Créer un logement
                    </x-button>
                @endcan
            </div>
        @endif

    </div>
</x-app-layout>