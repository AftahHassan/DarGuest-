<x-app-layout>
    <div class="py-10">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-4">

            <h1 class="text-2xl font-bold text-surface-900">Réservations</h1>

            @if (session('status'))
                <div class="alert-success">{{ session('status') }}</div>
            @endif

            <div class="card divide-y divide-surface-100 overflow-hidden">
                @forelse ($reservations as $reservation)
                    <a href="{{ route('reservations.show', $reservation) }}" class="flex items-center justify-between p-4 hover:bg-surface-50 transition-colors duration-150">
                        <div>
                            <p class="font-medium text-surface-900">{{ $reservation->property?->title ?? 'Logement supprimé' }}</p>
                            <p class="text-sm text-surface-500">
                                {{ $reservation->check_in_date->format('d/m/Y') }} → {{ $reservation->check_out_date->format('d/m/Y') }}
                                @if(auth()->user()->isOwner())
                                    · {{ $reservation->guest->fullName() }}
                                @endif
                            </p>
                        </div>
                        <span class="badge
                            @if($reservation->status === 'pending') badge-warning
                            @elseif($reservation->status === 'confirmed') badge-success
                            @elseif($reservation->status === 'cancelled') badge-danger
                            @else badge-gray
                            @endif">
                            {{ $reservation->status }}
                        </span>
                    </a>
                @empty
                    <p class="p-6 text-sm text-surface-500 text-center">Aucune réservation pour l'instant.</p>
                @endforelse
            </div>

            {{ $reservations->links() }}
        </div>
    </div>
</x-app-layout>