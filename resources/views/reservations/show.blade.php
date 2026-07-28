<x-app-layout>
    <div class="space-y-6 animate-fade-in max-w-4xl">

        @if (session('status'))
            <div class="bg-emerald-50 text-emerald-700 border border-emerald-200 px-4 py-3 rounded-xl text-sm font-medium">{{ session('status') }}</div>
        @endif

        {{-- Détail réservation --}}
        <div class="bg-white border border-surface-200 rounded-xl shadow-card p-6">
            <div class="flex justify-between items-start">
                <div>
                    <h2 class="text-xl font-bold text-surface-900">{{ $reservation->property->title }}</h2>
                    <div class="mt-4 grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <p class="text-surface-500">Dates</p>
                            <p class="font-medium text-surface-900">{{ $reservation->check_in_date->format('d/m/Y') }} → {{ $reservation->check_out_date->format('d/m/Y') }}</p>
                        </div>
                        <div>
                            <p class="text-surface-500">Voyageurs</p>
                            <p class="font-medium text-surface-900">{{ $reservation->number_of_guests }}</p>
                        </div>
                        <div>
                            <p class="text-surface-500">Prix total</p>
                            <p class="font-bold text-navy-700">{{ number_format($reservation->total_price, 0, ',', ' ') }} MAD</p>
                        </div>
                        <div>
                            <p class="text-surface-500">Statut</p>
                            @php
                                $statusVariant = match($reservation->status) {
                                    'pending' => 'warning',
                                    'confirmed' => 'success',
                                    'cancelled' => 'danger',
                                    default => 'gray',
                                };
                            @endphp
                            <x-ui.badge variant="{{ $statusVariant }}">{{ $reservation->status }}</x-ui.badge>
                        </div>
                    </div>
                    @if ($reservation->special_request)
                        <div class="mt-4">
                            <p class="text-surface-500 text-sm">Demande spéciale</p>
                            <p class="text-sm text-surface-700 mt-0.5">{{ $reservation->special_request }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <div class="mt-5 flex gap-2">
                @if (auth()->user()->isOwner() && $reservation->status === 'pending')
                    <form method="POST" action="{{ route('reservations.status', $reservation) }}">
                        @csrf @method('PATCH')
                        <input type="hidden" name="status" value="confirmed">
                        <button class="btn-primary text-sm">Confirmer</button>
                    </form>
                @endif

                @if (in_array($reservation->status, ['pending', 'confirmed']))
                    <form method="POST" action="{{ route('reservations.cancel', $reservation) }}" onsubmit="return confirm('Annuler cette réservation ?')">
                        @csrf @method('PATCH')
                        <button class="btn-danger text-sm">Annuler</button>
                    </form>
                @endif
            </div>
        </div>

        {{-- Conversation --}}
        <div class="bg-white border border-surface-200 rounded-xl shadow-card overflow-hidden">
            <div class="px-6 py-4 border-b border-surface-100">
                <h3 class="font-semibold text-surface-900">Conversation</h3>
            </div>

            <div class="p-6">
                <div class="space-y-4 max-h-[32rem] overflow-y-auto mb-6">
                    @forelse ($reservation->conversation->messages as $message)
                        @php $isOwn = $message->sender_id === auth()->id(); @endphp

                        <div class="flex {{ $isOwn ? 'justify-end' : 'justify-start' }}">
                            <div class="max-w-[75%]">
                                <div class="px-4 py-3 rounded-2xl text-sm leading-relaxed
                                    {{ $isOwn ? 'bg-navy-700 text-white rounded-br-md' : 'bg-surface-100 text-surface-800 rounded-bl-md' }}">
                                    <p class="text-[11px] opacity-70 mb-1">{{ $message->sender->fullName() }}</p>
                                    {{ $message->message }}
                                </div>
                                <p class="text-[10px] text-surface-400 mt-1 px-1">{{ $message->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>

                        @if ($message->sender_type === 'guest' && $message->aiAnalysis)
                            <div class="flex justify-start">
                                <div class="max-w-[75%]">
                                    <div class="px-4 py-3 rounded-2xl rounded-bl-md text-sm leading-relaxed bg-emerald-50 border border-emerald-200 text-surface-800">
                                        <div class="flex items-center gap-2 mb-1.5">
                                            <span class="text-[11px] font-semibold text-emerald-700">Réponse IA</span>
                                            @if ($message->aiAnalysis->urgency)
                                                <span class="inline-flex items-center gap-1 text-[10px] font-bold text-red-600 bg-red-50 px-1.5 py-0.5 rounded-full">
                                                    <span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span>
                                                    URGENT
                                                </span>
                                            @endif
                                        </div>
                                        <p class="text-surface-800">{{ $message->aiAnalysis->generated_response }}</p>
                                        <div class="flex items-center gap-2 mt-2">
                                            <span class="badge-primary !text-[9px]">{{ $message->aiAnalysis->detected_language }}</span>
                                            <span class="badge-primary !text-[9px]">{{ $message->aiAnalysis->category }}</span>
                                            @if ($message->aiAnalysis->confidence)
                                                <span class="text-[9px] text-surface-400">Confiance: {{ round($message->aiAnalysis->confidence * 100) }}%</span>
                                            @endif
                                        </div>
                                    </div>
                                    <p class="text-[10px] text-surface-400 mt-1 px-1">{{ $message->aiAnalysis->analyzed_at?->format('d/m/Y H:i') }}</p>
                                </div>
                            </div>
                        @elseif ($message->sender_type === 'guest' && !$message->aiAnalysis)
                            <div class="flex justify-start">
                                <div class="max-w-[75%]">
                                    <div class="px-4 py-2.5 rounded-2xl rounded-bl-md text-sm bg-surface-50 border border-surface-100 text-surface-400 italic">
                                        Analyse en cours...
                                    </div>
                                </div>
                            </div>
                        @endif
                    @empty
                        <div class="text-center py-12">
                            <div class="w-14 h-14 rounded-2xl bg-surface-100 flex items-center justify-center mx-auto mb-3">
                                <svg class="w-8 h-8 text-surface-300" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z"/></svg>
                            </div>
                            <p class="text-sm text-surface-400">Aucun message pour l'instant.</p>
                        </div>
                    @endforelse
                </div>

                <form method="POST" action="{{ route('conversations.messages.store', $reservation->conversation) }}" class="flex items-center gap-3">
                    @csrf
                    <input type="text" name="message" required placeholder="Écrire un message..."
                           class="input-field flex-1" />
                    <button type="submit" class="btn-primary">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5"/></svg>
                    </button>
                </form>
            </div>
        </div>

    </div>
</x-app-layout>
