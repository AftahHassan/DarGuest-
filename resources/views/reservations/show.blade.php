<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $reservation->property->title }}</h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('status'))
                <div class="bg-green-100 text-green-800 p-3 rounded">{{ session('status') }}</div>
            @endif

            {{-- Détail réservation --}}
            <div class="bg-white rounded shadow p-6">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm text-gray-500">Dates</p>
                        <p class="font-medium">{{ $reservation->check_in_date->format('d/m/Y') }} → {{ $reservation->check_out_date->format('d/m/Y') }}</p>
                        <p class="text-sm text-gray-500 mt-2">Voyageurs</p>
                        <p class="font-medium">{{ $reservation->number_of_guests }}</p>
                        <p class="text-sm text-gray-500 mt-2">Prix total</p>
                        <p class="font-medium">{{ $reservation->total_price }} MAD</p>
                        @if ($reservation->special_request)
                            <p class="text-sm text-gray-500 mt-2">Demande spéciale</p>
                            <p class="text-sm">{{ $reservation->special_request }}</p>
                        @endif
                    </div>
                    <span class="text-xs px-2 py-1 rounded-full bg-gray-100">{{ $reservation->status }}</span>
                </div>

                <div class="mt-4 flex gap-2">
                    @if (auth()->user()->isOwner() && $reservation->status === 'pending')
                        <form method="POST" action="{{ route('reservations.status', $reservation) }}">
                            @csrf @method('PATCH')
                            <input type="hidden" name="status" value="confirmed">
                            <button class="bg-green-600 text-white text-sm px-3 py-1.5 rounded">Confirmer</button>
                        </form>
                    @endif

                    @if (in_array($reservation->status, ['pending', 'confirmed']))
                        <form method="POST" action="{{ route('reservations.cancel', $reservation) }}" onsubmit="return confirm('Annuler cette réservation ?')">
                            @csrf @method('PATCH')
                            <button class="bg-red-600 text-white text-sm px-3 py-1.5 rounded">Annuler</button>
                        </form>
                    @endif
                </div>
            </div>

            {{-- Conversation --}}
            <div class="bg-white rounded shadow p-6">
                <h3 class="font-semibold mb-4">Conversation</h3>

                <div class="space-y-3 max-h-96 overflow-y-auto mb-4">
                    @forelse ($reservation->conversation->messages as $message)
                        <div class="flex {{ $message->sender_id === auth()->id() ? 'justify-end' : 'justify-start' }}">
                            <div class="max-w-xs px-3 py-2 rounded-lg text-sm
                                {{ $message->sender_id === auth()->id() ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-800' }}">
                                <p class="text-xs opacity-70 mb-1">{{ $message->sender->fullName() }}</p>
                                {{ $message->message }}
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500">Aucun message pour l'instant.</p>
                    @endforelse
                </div>

                <form method="POST" action="{{ route('conversations.messages.store', $reservation->conversation) }}" class="flex gap-2">
                    @csrf
                    <input type="text" name="message" placeholder="Écrire un message..." required
                           class="flex-1 border-gray-300 rounded-md text-sm">
                    <button class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm">Envoyer</button>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>