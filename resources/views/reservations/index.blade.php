<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Réservations</h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-4">

            @if (session('status'))
                <div class="bg-green-100 text-green-800 p-3 rounded">{{ session('status') }}</div>
            @endif

            <div class="bg-white rounded shadow divide-y">
                @forelse ($reservations as $reservation)
                    <a href="{{ route('reservations.show', $reservation) }}" class="flex items-center justify-between p-4 hover:bg-gray-50">
                        <div>
                            <p class="font-medium">{{ $reservation->property->title }}</p>
                            <p class="text-sm text-gray-500">
                                {{ $reservation->check_in_date->format('d/m/Y') }} → {{ $reservation->check_out_date->format('d/m/Y') }}
                                @if(auth()->user()->isOwner())
                                    · {{ $reservation->guest->fullName() }}
                                @endif
                            </p>
                        </div>
                        <span class="text-xs px-2 py-1 rounded-full
                            @class([
                                'bg-yellow-100 text-yellow-700' => $reservation->status === 'pending',
                                'bg-green-100 text-green-700' => $reservation->status === 'confirmed',
                                'bg-red-100 text-red-700' => $reservation->status === 'cancelled',
                                'bg-gray-100 text-gray-600' => $reservation->status === 'completed',
                            ])">
                            {{ $reservation->status }}
                        </span>
                    </a>
                @empty
                    <p class="p-6 text-sm text-gray-500 text-center">Aucune réservation pour l'instant.</p>
                @endforelse
            </div>

            {{ $reservations->links() }}
        </div>
    </div>
</x-app-layout>