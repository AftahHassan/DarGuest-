<x-app-layout>
    <div x-data="{ statusId: null, statusValue: 'pending', cancelId: null }" class="space-y-12">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
            <div>
                <p class="text-xs font-semibold text-navy-700 uppercase tracking-widest">Réservations</p>
                <h1 class="text-2xl sm:text-3xl font-bold text-surface-900 tracking-tight mt-2">📅 Réservations</h1>
                <p class="text-surface-500 mt-1">Gérez facilement toutes les réservations de vos logements.</p>
            </div>
            <x-button href="{{ route('properties.index') }}" size="lg" class="shrink-0">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                </svg>
                Nouvelle réservation
            </x-button>
        </div>

        {{-- Toasts --}}
        @if (session('status'))
            <x-ui.toast type="success" title="Succès" :message="session('status')" />
        @endif
        @if ($errors->any())
            <x-ui.toast type="error" title="Erreur" message="Une erreur est survenue. Veuillez réessayer." />
        @endif

        {{-- Filters --}}
        <form method="GET" class="panel p-5 space-y-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-4">
                <div class="lg:col-span-2">
                    <label class="text-xs font-semibold text-surface-500 uppercase tracking-wider">Rechercher</label>
                    <div class="relative mt-1">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-surface-400 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Logement, voyageur…"
                               class="w-full rounded-xl border-surface-200/60 bg-white/80 text-sm pl-9 pr-4 py-2.5 focus:border-navy-300 focus:ring-2 focus:ring-navy-500/20 focus:outline-none placeholder:text-surface-400 transition-all duration-200">
                    </div>
                </div>
                <div>
                    <label class="text-xs font-semibold text-surface-500 uppercase tracking-wider">Statut</label>
                    <select name="status" class="mt-1 w-full rounded-xl border-surface-200/60 bg-white/80 text-sm py-2.5 focus:border-navy-300 focus:ring-2 focus:ring-navy-500/20 focus:outline-none transition-all duration-200">
                        <option value="">Tous</option>
                        <option value="pending" @selected(request('status') === 'pending')>En attente</option>
                        <option value="confirmed" @selected(request('status') === 'confirmed')>Confirmée</option>
                        <option value="cancelled" @selected(request('status') === 'cancelled')>Annulée</option>
                        <option value="completed" @selected(request('status') === 'completed')>Terminée</option>
                    </select>
                </div>
                <div>
                    <label class="text-xs font-semibold text-surface-500 uppercase tracking-wider">Arrivée</label>
                    <input type="date" name="date_from" value="{{ request('date_from') }}"
                           class="mt-1 w-full rounded-xl border-surface-200/60 bg-white/80 text-sm px-4 py-2.5 focus:border-navy-300 focus:ring-2 focus:ring-navy-500/20 focus:outline-none transition-all duration-200">
                </div>
                <div>
                    <label class="text-xs font-semibold text-surface-500 uppercase tracking-wider">Départ</label>
                    <input type="date" name="date_to" value="{{ request('date_to') }}"
                           class="mt-1 w-full rounded-xl border-surface-200/60 bg-white/80 text-sm px-4 py-2.5 focus:border-navy-300 focus:ring-2 focus:ring-navy-500/20 focus:outline-none transition-all duration-200">
                </div>
                <div>
                    <label class="text-xs font-semibold text-surface-500 uppercase tracking-wider">Trier par</label>
                    <select name="sort" class="mt-1 w-full rounded-xl border-surface-200/60 bg-white/80 text-sm py-2.5 focus:border-navy-300 focus:ring-2 focus:ring-navy-500/20 focus:outline-none transition-all duration-200">
                        <option value="">Plus récent</option>
                        <option value="check_in_asc" @selected(request('sort') === 'check_in_asc')>Date d'arrivée ↑</option>
                        <option value="check_in_desc" @selected(request('sort') === 'check_in_desc')>Date d'arrivée ↓</option>
                        <option value="check_out_asc" @selected(request('sort') === 'check_out_asc')>Date de départ ↑</option>
                        <option value="check_out_desc" @selected(request('sort') === 'check_out_desc')>Date de départ ↓</option>
                        <option value="price_asc" @selected(request('sort') === 'price_asc')>Prix croissant</option>
                        <option value="price_desc" @selected(request('sort') === 'price_desc')>Prix décroissant</option>
                    </select>
                </div>
            </div>

            @if(auth()->user()->isOwner())
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="text-xs font-semibold text-surface-500 uppercase tracking-wider">Logement</label>
                    <select name="property" class="mt-1 w-full rounded-xl border-surface-200/60 bg-white/80 text-sm py-2.5 focus:border-navy-300 focus:ring-2 focus:ring-navy-500/20 focus:outline-none transition-all duration-200">
                        <option value="">Tous les logements</option>
                        @foreach ($properties as $property)
                            <option value="{{ $property->id }}" @selected(request('property') == $property->id)>{{ $property->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="text-xs font-semibold text-surface-500 uppercase tracking-wider">Voyageur</label>
                    <input type="text" name="guest" value="{{ request('guest') }}" placeholder="Nom du voyageur…"
                           class="mt-1 w-full rounded-xl border-surface-200/60 bg-white/80 text-sm px-4 py-2.5 focus:border-navy-300 focus:ring-2 focus:ring-navy-500/20 focus:outline-none placeholder:text-surface-400 transition-all duration-200">
                </div>
            </div>
            @endif

            <div class="flex gap-3">
                <x-button type="submit" size="sm">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
                    Filtrer
                </x-button>
                @if(request()->anyFilled(['search', 'status', 'property', 'guest', 'date_from', 'date_to', 'sort']))
                    <x-button href="{{ route('reservations.index') }}" variant="secondary" size="sm">Réinitialiser</x-button>
                @endif
            </div>
        </form>

        {{-- Results count --}}
        <p class="text-sm text-surface-500">
            <span class="font-semibold text-surface-700">{{ $reservations->total() }}</span> réservation{{ $reservations->total() > 1 ? 's' : '' }} trouvée{{ $reservations->total() > 1 ? 's' : '' }}
        </p>

        {{-- Cards --}}
        @if ($reservations->count())
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">
                @foreach ($reservations as $reservation)
                    @php
                        $isOwner = auth()->user()->isOwner();
                        $statusVariant = match($reservation->status) {
                            'confirmed' => 'success',
                            'pending' => 'warning',
                            'cancelled' => 'danger',
                            'completed' => 'gray',
                            default => 'gray',
                        };
                        $statusLabel = match($reservation->status) {
                            'confirmed' => 'Confirmée',
                            'pending' => 'En attente',
                            'cancelled' => 'Annulée',
                            'completed' => 'Terminée',
                            default => $reservation->status,
                        };
                        $nights = max($reservation->check_in_date->diffInDays($reservation->check_out_date), 1);
                    @endphp
                    <div class="group panel-hover overflow-hidden">
                        {{-- Image --}}
                        <div class="relative h-44 overflow-hidden bg-surface-100">
                            <x-gallery :images="$reservation->property?->images ?? collect()" class="!w-full !h-full">
                                <div class="w-full h-full flex items-center justify-center">
                                    <svg class="w-10 h-10 text-surface-300" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.41a2.25 2.25 0 013.182 0l2.909 2.91m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/>
                                    </svg>
                                </div>
                            </x-gallery>
                            <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none"></div>

                            {{-- Status --}}
                            <div class="absolute top-3 right-3 z-10">
                                <x-ui.badge :variant="$statusVariant" dot>{{ $statusLabel }}</x-ui.badge>
                            </div>

                            {{-- Guest chip --}}
                            @if($isOwner && $reservation->guest)
                                <div class="absolute bottom-3 left-3 z-10 flex items-center gap-2 bg-white/90 backdrop-blur-sm rounded-lg px-2.5 py-1.5 shadow-sm">
                                    <div class="w-6 h-6 rounded-full bg-navy-700 text-white flex items-center justify-center text-[9px] font-semibold">
                                        {{ strtoupper(substr($reservation->guest->first_name ?? '?', 0, 1)) }}{{ strtoupper(substr($reservation->guest->last_name ?? '?', 0, 1)) }}
                                    </div>
                                    <span class="text-xs font-medium text-surface-900">{{ $reservation->guest->fullName() }}</span>
                                </div>
                            @endif
                        </div>

                        {{-- Content --}}
                        <div class="p-5">
                            <div class="flex items-start justify-between gap-2">
                                <div class="min-w-0">
                                    <h3 class="font-semibold text-surface-900 truncate">{{ $reservation->property?->title ?? 'Logement supprimé' }}</h3>
                                    <p class="text-sm text-surface-500 mt-0.5 truncate flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/>
                                        </svg>
                                        {{ $reservation->property?->city ?? '—' }}
                                    </p>
                                </div>
                            </div>

                            {{-- Dates --}}
                            <div class="flex items-center justify-between mt-4 rounded-xl bg-surface-50/80 border border-surface-200/60 p-3">
                                <div>
                                    <p class="text-[10px] font-semibold text-surface-400 uppercase tracking-wider">Arrivée</p>
                                    <p class="text-sm font-semibold text-surface-900 mt-0.5">{{ $reservation->check_in_date->format('d M Y') }}</p>
                                </div>
                                <div class="flex flex-col items-center px-2">
                                    <span class="text-[10px] text-surface-400">{{ $nights }} nuit{{ $nights > 1 ? 's' : '' }}</span>
                                    <svg class="w-4 h-4 text-navy-700 mt-0.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                                    </svg>
                                </div>
                                <div class="text-right">
                                    <p class="text-[10px] font-semibold text-surface-400 uppercase tracking-wider">Départ</p>
                                    <p class="text-sm font-semibold text-surface-900 mt-0.5">{{ $reservation->check_out_date->format('d M Y') }}</p>
                                </div>
                            </div>

                            {{-- Meta --}}
                            <div class="flex items-center justify-between mt-4">
                                <div class="flex items-center gap-4 text-sm text-surface-500">
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4 text-surface-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/>
                                        </svg>
                                        {{ $reservation->number_of_guests }}
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4 text-surface-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/>
                                        </svg>
                                        {{ $reservation->number_of_guests }} pers.
                                    </span>
                                </div>
                                <p class="text-lg font-bold text-surface-900">{{ number_format($reservation->total_price, 0, ',', ' ') }} <span class="text-[10px] font-normal text-surface-400">MAD</span></p>
                            </div>

                            {{-- Actions --}}
                            <div class="flex gap-2 mt-4 pt-4 border-t border-surface-200/60">
                                <x-button href="{{ route('reservations.show', $reservation) }}" class="flex-1" size="sm">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    Voir
                                </x-button>
                                @if($isOwner)
                                    <x-button variant="secondary" size="sm"
                                              x-on:click="statusId = {{ $reservation->id }}; statusValue = '{{ $reservation->status }}'; $dispatch('open-modal', 'status-reservation')">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125"/></svg>
                                        Modifier
                                    </x-button>
                                @endif
                                @if(in_array($reservation->status, ['pending', 'confirmed']))
                                    <x-button variant="ghost" size="sm" class="!text-red-500 hover:!bg-red-50"
                                              x-on:click="cancelId = {{ $reservation->id }}; $dispatch('open-modal', 'cancel-reservation')">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        Annuler
                                    </x-button>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div>
                <x-ui.pagination :paginator="$reservations" />
            </div>

            {{-- Status modal --}}
            <x-ui.modal id="status-reservation" maxWidth="sm">
                <div class="text-center">
                    <div class="w-14 h-14 rounded-2xl bg-navy-50 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-7 h-7 text-navy-700" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125"/></svg>
                    </div>
                    <h3 class="text-lg font-semibold text-surface-900 mb-1">Modifier le statut</h3>
                    <p class="text-sm text-surface-500 mb-6">Sélectionnez le nouveau statut de la réservation.</p>
                    <form method="POST" x-bind:action="'{{ url('reservations') }}/' + statusId + '/status'" class="space-y-4">
                        @csrf @method('PATCH')
                        <select x-model="statusValue" name="status"
                                class="w-full rounded-xl border-surface-200/60 bg-white/80 text-sm py-2.5 focus:border-navy-300 focus:ring-2 focus:ring-navy-500/20 focus:outline-none transition-all duration-200">
                            <option value="pending">En attente</option>
                            <option value="confirmed">Confirmée</option>
                            <option value="cancelled">Annulée</option>
                            <option value="completed">Terminée</option>
                        </select>
                        <div class="flex items-center justify-center gap-3">
                            <x-button variant="secondary" size="sm" x-on:click="$dispatch('close-modal', 'status-reservation')">Annuler</x-button>
                            <x-button type="submit" size="sm">Enregistrer</x-button>
                        </div>
                    </form>
                </div>
            </x-ui.modal>

            {{-- Cancel modal --}}
            <x-ui.modal id="cancel-reservation" maxWidth="sm">
                <div class="text-center">
                    <div class="w-14 h-14 rounded-2xl bg-red-50 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-7 h-7 text-red-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg>
                    </div>
                    <h3 class="text-lg font-semibold text-surface-900 mb-1">Annuler cette réservation ?</h3>
                    <p class="text-sm text-surface-500 mb-2">Cette action est irréversible.</p>
                    <p class="text-xs text-surface-400 mb-6">Le voyageur sera informé de l'annulation.</p>
                    <div class="flex items-center justify-center gap-3">
                        <x-button variant="secondary" size="sm" x-on:click="$dispatch('close-modal', 'cancel-reservation')">Retour</x-button>
                        <form method="POST" x-bind:action="'{{ url('reservations') }}/' + cancelId + '/cancel'">
                            @csrf @method('PATCH')
                            <x-button type="submit" variant="danger" size="sm">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Confirmer l'annulation
                            </x-button>
                        </form>
                    </div>
                </div>
            </x-ui.modal>
        @else
            {{-- Empty state --}}
            <div class="panel p-12 sm:p-16 text-center">
                <div class="relative w-20 h-20 mx-auto mb-6">
                    <div class="absolute inset-0 rounded-3xl bg-navy-50 rotate-6"></div>
                    <div class="absolute inset-0 rounded-3xl bg-gold-100 -rotate-6"></div>
                    <div class="absolute inset-2 rounded-2xl bg-white flex items-center justify-center shadow-sm">
                        <svg class="w-9 h-9 text-surface-300" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/>
                        </svg>
                    </div>
                </div>
                <h3 class="text-lg font-semibold text-surface-900 mb-1">Aucune réservation trouvée</h3>
                <p class="text-sm text-surface-500 max-w-sm mx-auto mb-6">Ajustez vos filtres ou créez une nouvelle réservation dès maintenant.</p>
                <div class="flex items-center justify-center gap-3">
                    @if(request()->anyFilled(['search', 'status', 'property', 'guest', 'date_from', 'date_to', 'sort']))
                        <x-button href="{{ route('reservations.index') }}" variant="secondary" size="sm">Réinitialiser les filtres</x-button>
                    @endif
                    <x-button href="{{ route('properties.index') }}">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                        Nouvelle réservation
                    </x-button>
                </div>
            </div>
        @endif

    </div>
</x-app-layout>
