<x-app-layout>
    <div class="py-10">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-bold text-surface-900">Réservations</h1>
            </div>

            @if (session('status'))
                <div class="alert-success">{{ session('status') }}</div>
            @endif

            <form method="GET" class="bg-white/60 backdrop-blur-sm border border-surface-200/60 rounded-2xl p-5 space-y-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div>
                        <label class="text-xs font-semibold text-surface-500 uppercase tracking-wider">Rechercher</label>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Logement ou client…"
                               class="mt-1 w-full rounded-xl border-surface-200/60 bg-white/80 text-sm focus:border-navy-300 focus:ring-navy-200">
                    </div>
                    <div>
                        <label class="text-xs font-semibold text-surface-500 uppercase tracking-wider">Statut</label>
                        <select name="status" class="mt-1 w-full rounded-xl border-surface-200/60 bg-white/80 text-sm focus:border-navy-300 focus:ring-navy-200">
                            <option value="">Tous</option>
                            <option value="pending" @selected(request('status') === 'pending')>En attente</option>
                            <option value="confirmed" @selected(request('status') === 'confirmed')>Confirmée</option>
                            <option value="cancelled" @selected(request('status') === 'cancelled')>Annulée</option>
                            <option value="completed" @selected(request('status') === 'completed')>Terminée</option>
                        </select>
                    </div>
                    <div>
                        <label class="text-xs font-semibold text-surface-500 uppercase tracking-wider">Du</label>
                        <input type="date" name="date_from" value="{{ request('date_from') }}"
                               class="mt-1 w-full rounded-xl border-surface-200/60 bg-white/80 text-sm focus:border-navy-300 focus:ring-navy-200">
                    </div>
                    <div>
                        <label class="text-xs font-semibold text-surface-500 uppercase tracking-wider">Au</label>
                        <input type="date" name="date_to" value="{{ request('date_to') }}"
                               class="mt-1 w-full rounded-xl border-surface-200/60 bg-white/80 text-sm focus:border-navy-300 focus:ring-navy-200">
                    </div>
                </div>
                <div class="flex gap-3">
                    <button type="submit" class="btn-primary text-sm px-5 py-2">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
                        Filtrer
                    </button>
                    @if(request()->anyFilled(['search', 'status', 'date_from', 'date_to']))
                        <a href="{{ route('reservations.index') }}" class="btn-secondary text-sm px-5 py-2">Réinitialiser</a>
                    @endif
                </div>
            </form>

            <div class="bg-white/60 backdrop-blur-sm border border-surface-200/60 rounded-2xl overflow-hidden divide-y divide-surface-100">
                @forelse ($reservations as $reservation)
                    <a href="{{ route('reservations.show', $reservation) }}" class="flex items-center justify-between p-4 hover:bg-surface-50/80 transition-colors duration-150">
                        <div>
                            <p class="font-medium text-surface-900">{{ $reservation->property?->title ?? 'Logement supprimé' }}</p>
                            <p class="text-sm text-surface-500">
                                {{ $reservation->check_in_date->format('d/m/Y') }} → {{ $reservation->check_out_date->format('d/m/Y') }}
                                @if(auth()->user()->isOwner())
                                    · {{ $reservation->guest?->fullName() ?? 'N/A' }}
                                @endif
                            </p>
                        </div>
                        <span class="badge
                            @if($reservation->status === 'pending') badge-warning
                            @elseif($reservation->status === 'confirmed') badge-success
                            @elseif($reservation->status === 'cancelled') badge-danger
                            @else badge-gray
                            @endif">
                            @if($reservation->status === 'pending') En attente
                            @elseif($reservation->status === 'confirmed') Confirmée
                            @elseif($reservation->status === 'cancelled') Annulée
                            @elseif($reservation->status === 'completed') Terminée
                            @else {{ $reservation->status }}
                            @endif
                        </span>
                    </a>
                @empty
                    <p class="p-6 text-sm text-surface-500 text-center">Aucune réservation trouvée.</p>
                @endforelse
            </div>

            {{ $reservations->links() }}
        </div>
    </div>
</x-app-layout>