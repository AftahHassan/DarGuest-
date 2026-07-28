<x-app-layout>
    <div class="space-y-4 animate-fade-in">
        <h2 class="text-2xl font-bold text-surface-900 tracking-tight">Messages</h2>

        @if($conversations->isEmpty())
            <div class="empty-state py-16 text-center">
                <div class="empty-state-icon mx-auto">
                    <svg class="w-8 h-8 text-surface-400" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z"/></svg>
                </div>
                <h3 class="text-base font-semibold text-surface-900 mb-1">Aucune conversation</h3>
                <p class="text-sm text-surface-500 max-w-sm mx-auto">Les conversations liées à vos réservations apparaîtront ici.</p>
            </div>
        @else
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6" style="height: calc(100vh - 250px);">
                {{-- Conversation List --}}
                <div class="lg:col-span-1">
                    <div class="card h-full overflow-hidden flex flex-col p-0">
                        <div class="p-4 border-b border-surface-100">
                            <x-ui.search-bar placeholder="Rechercher..." />
                        </div>
                        <div class="flex-1 overflow-y-auto">
                            @foreach($conversations as $conv)
                                <a href="{{ route('conversations.show', $conv) }}"
                                   class="flex items-center gap-3 p-4 border-b border-surface-50 hover:bg-surface-50 transition-colors duration-150 {{ request()->route('conversation')?->id === $conv->id ? 'bg-primary-50 border-l-2 border-l-primary-600' : '' }}">
                                    <div class="avatar avatar-md bg-primary-600 text-white flex-shrink-0">
                                        {{ strtoupper(substr($conv->reservation->guest->first_name ?? 'U', 0, 1)) }}
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center justify-between">
                                            <p class="text-sm font-semibold text-surface-900 truncate">{{ $conv->reservation->guest->fullName() ?? 'N/A' }}</p>
                                            @if($conv->messages->count() > 0)
                                                <span class="text-[10px] text-surface-400">{{ $conv->messages->last()->created_at->diffForHumans() }}</span>
                                            @endif
                                        </div>
                                        <p class="text-xs text-surface-500 truncate mt-0.5">{{ $conv->reservation->property->title ?? '' }}</p>
                                        @if($conv->messages->count() > 0)
                                            <p class="text-xs text-surface-400 truncate mt-0.5">{{ Str::limit($conv->messages->last()->message, 40) }}</p>
                                        @endif
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Chat Area --}}
                <div class="lg:col-span-2">
                    @if(request()->route('conversation'))
                        @php $conv = request()->route('conversation'); @endphp
                        <div class="card h-full flex flex-col overflow-hidden p-0">
                            {{-- Chat Header --}}
                            <div class="p-4 border-b border-surface-100 flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="avatar avatar-sm bg-primary-600 text-white">
                                        {{ strtoupper(substr($conv->reservation->guest->first_name ?? 'U', 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-surface-900">{{ $conv->reservation->guest->fullName() ?? 'N/A' }}</p>
                                        <p class="text-xs text-surface-500">{{ $conv->reservation->property->title ?? '' }}</p>
                                    </div>
                                </div>
                                <x-ui.badge variant="{{ $conv->status === 'open' ? 'success' : 'gray' }}">{{ $conv->status }}</x-ui.badge>
                            </div>

                            {{-- Messages --}}
                            <div class="flex-1 overflow-y-auto p-4 space-y-4" id="messages-container">
                                @forelse($conv->messages as $msg)
                                    @php $isOwn = $msg->sender_id === auth()->id(); @endphp
                                    <div class="flex {{ $isOwn ? 'justify-end' : 'justify-start' }}">
                                        <div class="max-w-[75%]">
                                            <div class="px-4 py-3 rounded-2xl text-sm leading-relaxed {{ $isOwn ? 'bg-primary-600 text-white rounded-br-md' : 'bg-surface-100 text-surface-900 rounded-bl-md' }}">
                                                {{ $msg->message }}
                                            </div>
                                            <div class="flex items-center gap-2 mt-1 px-1">
                                                <span class="text-[10px] text-surface-400">{{ $msg->created_at->format('H:i') }}</span>
                                                @if($msg->sender_type === 'ai')
                                                    <x-ui.badge variant="primary" class="!text-[9px] !px-1.5 !py-0">IA</x-ui.badge>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="flex items-center justify-center h-full">
                                        <p class="text-sm text-surface-400">Aucun message pour le moment.</p>
                                    </div>
                                @endforelse
                            </div>

                            {{-- Message Input --}}
                            <div class="p-4 border-t border-surface-100">
                                <form method="POST" action="{{ route('conversations.messages.store', $conv) }}" class="flex items-center gap-3">
                                    @csrf
                                    <input type="text" name="message" required placeholder="Écrire un message..." class="input-field flex-1" />
                                    <button type="submit" class="btn-primary">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5"/></svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <div class="card h-full flex items-center justify-center">
                            <div class="text-center">
                                <div class="empty-state-icon mx-auto mb-4">
                                    <svg class="w-8 h-8 text-surface-400" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z"/></svg>
                                </div>
                                <h3 class="text-base font-semibold text-surface-900 mb-1">Sélectionnez une conversation</h3>
                                <p class="text-sm text-surface-500 max-w-sm">Choisissez une conversation dans la liste pour commencer à discuter.</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @endif
    </div>
</x-app-layout>
