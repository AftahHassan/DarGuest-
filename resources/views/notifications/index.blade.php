<x-app-layout>
    <div class="space-y-6 animate-fade-in">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-surface-900 tracking-tight">Notifications</h2>
                <p class="text-sm text-surface-500 mt-0.5">{{ $notifications->count() }} notification(s)</p>
            </div>
            @if($notifications->count() > 0)
                <form method="POST" action="{{ route('notifications.clear') }}">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn-ghost text-sm text-red-600 hover:text-red-700" onclick="return confirm('Supprimer toutes les notifications ?')">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                        Tout supprimer
                    </button>
                </form>
            @endif
        </div>

        @if($notifications->isEmpty())
            <div class="empty-state py-16 text-center">
                <div class="empty-state-icon mx-auto mb-4">
                    <svg class="w-8 h-8 text-surface-400" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/></svg>
                </div>
                <h3 class="text-base font-semibold text-surface-900 mb-1">Aucune notification</h3>
                <p class="text-sm text-surface-500 max-w-sm mx-auto">Vous êtes à jour ! Les nouvelles notifications apparaîtront ici.</p>
            </div>
        @else
            <div class="space-y-3">
                @foreach($notifications as $notif)
                    @php
                        $typeVariant = match($notif->type) {
                            'new_reservation' => 'success',
                            'new_message' => 'primary',
                            'emergency' => 'danger',
                            'reservation_cancelled' => 'warning',
                            default => 'gray',
                        };
                        $typeIcon = match($notif->type) {
                            'new_reservation' => '<path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/>',
                            'new_message' => '<path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z"/>',
                            'emergency' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>',
                            default => '<path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/>',
                        };
                    @endphp
                    <div class="card {{ !$notif->is_read ? 'border-l-4 border-l-primary-500' : '' }} p-0">
                        <div class="flex items-start gap-4 p-4">
                            <div class="w-10 h-10 rounded-xl bg-{{ $typeVariant }}-50 flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-{{ $typeVariant }}-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">{!! $typeIcon !!}</svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-semibold text-surface-900">{{ $notif->title }}</p>
                                <p class="text-sm text-surface-500 mt-0.5">{{ $notif->content }}</p>
                                <p class="text-xs text-surface-400 mt-1">{{ $notif->created_at->diffForHumans() }}</p>
                            </div>
                            <div class="flex items-center gap-1 flex-shrink-0">
                                @if(!$notif->is_read)
                                    <form method="POST" action="{{ route('notifications.read', $notif) }}">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="btn-icon" title="Marquer comme lu">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        </button>
                                    </form>
                                @endif
                                <form method="POST" action="{{ route('notifications.destroy', $notif) }}">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-icon text-red-400 hover:text-red-600 hover:bg-red-50" title="Supprimer">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>
