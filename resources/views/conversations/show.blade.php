@php $conv = $conversation; @endphp

<x-app-layout>
    <div class="space-y-4 animate-fade-in max-w-4xl">
        <div class="flex items-center gap-3">
            <a href="{{ route('conversations.index') }}" class="btn-icon">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
            </a>
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-full bg-navy-700 text-white flex items-center justify-center text-xs font-semibold">
                    {{ strtoupper(substr($conv->reservation->guest->first_name ?? 'U', 0, 1)) }}
                </div>
                <div>
                    <h2 class="text-lg font-bold text-surface-900">{{ $conv->reservation->guest?->fullName() ?? 'N/A' }}</h2>
                    <p class="text-sm text-surface-500">{{ $conv->reservation->property->title ?? '' }}</p>
                </div>
            </div>
        </div>

        <div style="height: calc(100vh - 220px);">
            <div class="bg-white border border-surface-200 rounded-xl shadow-card h-full flex flex-col overflow-hidden">
                <div class="flex-1 overflow-y-auto p-6 space-y-4" id="messages-container">
                    @forelse($conv->messages as $msg)
                        @php $isOwn = $msg->sender_id === auth()->id(); @endphp
                        <div class="flex {{ $isOwn ? 'justify-end' : 'justify-start' }}">
                            <div class="max-w-[75%]">
                                <div class="px-4 py-3 rounded-2xl text-sm leading-relaxed {{ $isOwn ? 'bg-navy-700 text-white rounded-br-md' : 'bg-surface-100 text-surface-800 rounded-bl-md' }}">
                                    {{ $msg->message }}
                                </div>
                                <div class="flex items-center gap-2 mt-1 px-1">
                                    <span class="text-[10px] text-surface-400">{{ $msg->created_at->format('d/m/Y H:i') }}</span>
                                    @if($msg->sender_type === 'ai')
                                        <x-ui.badge variant="primary" class="!text-[9px] !px-1.5 !py-0">Réponse IA</x-ui.badge>
                                    @endif
                                </div>
                                @if($msg->aiAnalysis)
                                    <div class="mt-2 p-3 bg-navy-50 rounded-xl border border-navy-100">
                                        <p class="text-[10px] font-semibold text-navy-700 uppercase tracking-wider mb-1">Analyse IA</p>
                                        <div class="flex flex-wrap gap-2">
                                            <span class="badge-primary !text-[10px]">{{ $msg->aiAnalysis->detected_language }}</span>
                                            <span class="badge-primary !text-[10px]">{{ $msg->aiAnalysis->category }}</span>
                                            @if($msg->aiAnalysis->urgency)
                                                <span class="badge-danger !text-[10px]">Urgent</span>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="flex items-center justify-center h-full">
                            <p class="text-sm text-surface-400">Aucun message. Commencez la conversation !</p>
                        </div>
                    @endforelse
                </div>

                <div class="p-4 border-t border-surface-100">
                    <form method="POST" action="{{ route('conversations.messages.store', $conv) }}" class="flex items-center gap-3">
                        @csrf
                        <input type="text" name="message" required placeholder="Écrire un message..." class="input-field flex-1" autofocus />
                        <button type="submit" class="btn-primary">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5"/></svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
