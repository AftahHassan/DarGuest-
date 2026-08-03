<x-app-layout>
    @php
        $typeMeta = [
            'new_reservation' => ['label' => 'Nouvelle réservation', 'bg' => 'bg-navy-50', 'text' => 'text-navy-700', 'ring' => 'border-navy-100'],
            'new_message' => ['label' => 'Nouveau message', 'bg' => 'bg-sky-50', 'text' => 'text-sky-600', 'ring' => 'border-sky-100'],
            'emergency' => ['label' => 'Urgence', 'bg' => 'bg-red-50', 'text' => 'text-red-600', 'ring' => 'border-red-100'],
            'reservation_cancelled' => ['label' => 'Réservation annulée', 'bg' => 'bg-amber-50', 'text' => 'text-amber-600', 'ring' => 'border-amber-100'],
            'system' => ['label' => 'Système', 'bg' => 'bg-surface-100', 'text' => 'text-surface-500', 'ring' => 'border-surface-200'],
        ];
    @endphp

    <div x-data="{ deleteId: null }" class="space-y-8">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
            <div>
                <p class="text-xs font-semibold text-navy-700 uppercase tracking-widest">Notifications</p>
                <h1 class="text-2xl sm:text-3xl font-bold text-surface-900 tracking-tight mt-2">🔔 Notifications</h1>
                <p class="text-surface-500 mt-1">Restez informé des nouvelles réservations, messages et alertes urgentes.</p>
            </div>
            @if($stats['unread'] > 0)
                <form method="POST" action="{{ route('notifications.read-all') }}">
                    @csrf
                    <button type="submit" class="btn-secondary text-sm px-5 py-2.5 rounded-xl">
                        <svg class="w-4 h-4 text-navy-700" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 18.75a3.75 3.75 0 100-7.5 3.75 3.75 0 000 7.5z"/></svg>
                        Tout marquer comme lu
                    </button>
                </form>
            @endif
        </div>

        {{-- Toasts --}}
        @if (session('status'))
            <x-ui.toast type="success" title="Succès" :message="session('status')" />
        @endif

        {{-- Stats --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            <div class="panel p-5 flex items-center gap-4">
                <div class="w-11 h-11 rounded-xl bg-navy-50 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-navy-700" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/></svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-surface-900 leading-none">{{ $stats['total'] }}</p>
                    <p class="text-xs text-surface-500 mt-1">Notifications</p>
                </div>
            </div>
            <div class="panel p-5 flex items-center gap-4">
                <div class="w-11 h-11 rounded-xl bg-gold-100 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-gold-700" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/></svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-surface-900 leading-none">{{ $stats['unread'] }}</p>
                    <p class="text-xs text-surface-500 mt-1">Non lues</p>
                </div>
            </div>
            <div class="panel p-5 flex items-center gap-4">
                <div class="w-11 h-11 rounded-xl bg-red-50 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-surface-900 leading-none">{{ $stats['urgent'] }}</p>
                    <p class="text-xs text-surface-500 mt-1">Urgentes non lues</p>
                </div>
            </div>
        </div>

        {{-- Filters --}}
        <form method="GET" class="panel p-5">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div>
                    <label class="text-xs font-semibold text-surface-500 uppercase tracking-wider">Type</label>
                    <select name="type" class="mt-1 w-full rounded-xl border-surface-200/60 bg-white/80 text-sm py-2.5 focus:border-navy-300 focus:ring-2 focus:ring-navy-500/20 focus:outline-none transition-all duration-200">
                        <option value="">Tous les types</option>
                        <option value="new_reservation" @selected(request('type') === 'new_reservation')>Nouvelle réservation</option>
                        <option value="new_message" @selected(request('type') === 'new_message')>Nouveau message</option>
                        <option value="emergency" @selected(request('type') === 'emergency')>Urgence</option>
                        <option value="reservation_cancelled" @selected(request('type') === 'reservation_cancelled')>Réservation annulée</option>
                        <option value="system" @selected(request('type') === 'system')>Système</option>
                    </select>
                </div>
                <div class="flex items-end">
                    <label class="inline-flex items-center gap-2.5 pb-2.5 cursor-pointer select-none">
                        <input type="checkbox" name="unread" value="1" @checked(request()->boolean('unread'))
                               class="w-4 h-4 rounded border-surface-300 text-navy-700 focus:ring-navy-500/30 transition-all duration-200">
                        <span class="text-sm font-medium text-surface-700">Non lues uniquement</span>
                    </label>
                </div>
                <div class="lg:col-span-2 flex items-end gap-3">
                    <button type="submit" class="btn-primary text-sm px-5 py-2.5">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
                        Filtrer
                    </button>
                    @if(request()->anyFilled(['type', 'unread']))
                        <a href="{{ route('notifications.index') }}" class="btn-secondary text-sm px-5 py-2.5">Réinitialiser</a>
                    @endif
                </div>
            </div>
        </form>

        {{-- List --}}
        @if($notifications->count())
            <div class="space-y-3">
                @foreach($notifications as $notification)
                    @php $meta = $typeMeta[$notification->type] ?? $typeMeta['system']; @endphp
                    <div class="panel p-5 flex items-start gap-4 transition-all duration-200 hover:shadow-card-hover {{ $notification->is_read ? 'border-surface-200/80' : 'border-navy-200/80 bg-navy-50/40' }}">
                        <div class="relative flex-shrink-0">
                            <div class="w-11 h-11 rounded-xl {{ $meta['bg'] }} flex items-center justify-center">
                                @if($notification->type === 'emergency')
                                    <svg class="w-5 h-5 {{ $meta['text'] }}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg>
                                @elseif($notification->type === 'new_message')
                                    <svg class="w-5 h-5 {{ $meta['text'] }}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z"/></svg>
                                @elseif($notification->type === 'new_reservation')
                                    <svg class="w-5 h-5 {{ $meta['text'] }}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                                @elseif($notification->type === 'reservation_cancelled')
                                    <svg class="w-5 h-5 {{ $meta['text'] }}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                @else
                                    <svg class="w-5 h-5 {{ $meta['text'] }}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/></svg>
                                @endif
                            </div>
                            @if(!$notification->is_read)
                                <span class="absolute -top-0.5 -right-0.5 w-2.5 h-2.5 rounded-full bg-navy-600 ring-2 ring-white"></span>
                            @endif
                        </div>

                        <div class="flex-1 min-w-0">
                            <div class="flex flex-wrap items-center gap-2">
                                <h3 class="text-sm font-semibold text-surface-900">{{ $notification->title }}</h3>
                                <x-ui.badge :variant="$notification->type === 'emergency' ? 'danger' : 'gray'" class="!text-[10px]">{{ $meta['label'] }}</x-ui.badge>
                            </div>
                            @if($notification->content)
                                <p class="text-sm text-surface-600 mt-1 leading-relaxed">{{ $notification->content }}</p>
                            @endif
                            <p class="text-xs text-surface-400 mt-2">{{ $notification->created_at->diffForHumans() }}</p>
                        </div>

                        <div class="flex items-center gap-1 flex-shrink-0">
                            @unless($notification->is_read)
                                <form method="POST" action="{{ route('notifications.read', $notification) }}">
                                    @csrf
                                    <button type="submit" class="btn-secondary w-9 h-9 p-0 rounded-xl" title="Marquer comme lu">
                                        <svg class="w-4 h-4 text-navy-700" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 18.75a3.75 3.75 0 100-7.5 3.75 3.75 0 000 7.5z"/></svg>
                                    </button>
                                </form>
                            @endunless
                            <button type="button"
                                    x-on:click="deleteId = {{ $notification->id }}; $dispatch('open-modal', 'delete-notification')"
                                    class="btn-secondary w-9 h-9 p-0 rounded-xl text-red-500 hover:text-red-700 hover:bg-red-50" title="Supprimer">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>

            <div>
                <x-ui.pagination :paginator="$notifications" />
            </div>

            {{-- Delete modal --}}
            <x-ui.modal id="delete-notification" maxWidth="sm">
                <div class="text-center">
                    <div class="w-14 h-14 rounded-2xl bg-red-50 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-7 h-7 text-red-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg>
                    </div>
                    <h3 class="text-lg font-semibold text-surface-900 mb-1">Supprimer cette notification ?</h3>
                    <p class="text-sm text-surface-500 mb-2">Cette action est irréversible.</p>
                    <p class="text-xs text-surface-400 mb-6">La notification sera définitivement supprimée.</p>
                    <div class="flex items-center justify-center gap-3">
                        <button type="button" x-on:click="$dispatch('close-modal', 'delete-notification')" class="btn-secondary text-sm px-5 py-2">Retour</button>
                        <form method="POST" x-bind:action="'{{ url('notifications') }}/' + deleteId">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-danger text-sm px-5 py-2">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                                Supprimer
                            </button>
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
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/>
                        </svg>
                    </div>
                </div>
                @if(request()->anyFilled(['type', 'unread']))
                    <h3 class="text-lg font-semibold text-surface-900 mb-1">Aucune notification trouvée</h3>
                    <p class="text-sm text-surface-500 max-w-sm mx-auto mb-6">Ajustez vos filtres pour retrouver vos notifications.</p>
                    <a href="{{ route('notifications.index') }}" class="btn-secondary text-sm px-5 py-2.5">Réinitialiser les filtres</a>
                @else
                    <h3 class="text-lg font-semibold text-surface-900 mb-1">Aucune notification</h3>
                    <p class="text-sm text-surface-500 max-w-sm mx-auto">Vous n'avez aucune notification pour le moment. Les alertes de réservations, messages et urgences apparaîtront ici.</p>
                @endif
            </div>
        @endif

    </div>
</x-app-layout>
