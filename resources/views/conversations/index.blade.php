<x-app-layout>
    @php
        $categoryLabels = [
            'accommodation' => 'Logement', 'check_in' => 'Check-in', 'check_out' => 'Check-out',
            'wifi' => 'Wi-Fi', 'parking' => 'Parking', 'restaurant' => 'Restaurant',
            'taxi' => 'Taxi', 'beach' => 'Plage', 'surf_school' => 'École de surf',
            'house_rules' => 'Règlement', 'technical_problem' => 'Problème technique',
            'emergency' => 'Urgence', 'other' => 'Autre',
        ];

        $monthNames = ['janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre'];
        $dayNames = ['dimanche', 'lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi'];

        $dateLabel = function ($d) use ($monthNames, $dayNames) {
            if ($d->isToday()) return "Aujourd'hui";
            if ($d->isYesterday()) return 'Hier';
            $label = $dayNames[$d->dayOfWeek] . ' ' . $d->day . ' ' . $monthNames[$d->month - 1];
            if ($d->year !== now()->year) $label .= ' ' . $d->year;
            return ucfirst($label);
        };

        $guest = $active?->reservation->guest;
        $property = $active?->reservation->property;

        $messageGroups = [];
        foreach ($active?->messages ?? collect() as $msg) {
            $idx = count($messageGroups) - 1;
            $prev = $idx >= 0 ? end($messageGroups[$idx]['messages']) : null;
            $sameSender = $prev
                && $prev->sender_type === $msg->sender_type
                && ($msg->sender_type === 'ai' || $prev->sender_id === $msg->sender_id)
                && $prev->created_at->diffInMinutes($msg->created_at) < 10;
            $sameDay = $prev && $prev->created_at->isSameDay($msg->created_at);
            if ($sameSender && $sameDay) {
                $messageGroups[$idx]['messages'][] = $msg;
            } else {
                $messageGroups[] = ['label' => $dateLabel($msg->created_at), 'messages' => [$msg]];
            }
        }

        $lastMessage = $active?->messages->last();
        $lastAnalysis = $active?->messages->reduce(function ($carry, $msg) {
            return $msg->aiAnalysis ? $msg->aiAnalysis : $carry;
        }, null);
    @endphp

    <div class="space-y-8" x-data="{ aiPanel: false }">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
            <div>
                <p class="text-xs font-semibold text-navy-700 uppercase tracking-widest">Messagerie</p>
                <h1 class="text-2xl sm:text-3xl font-bold text-surface-900 tracking-tight mt-2">💬 Messagerie IA</h1>
                <p class="text-surface-500 mt-1">Échangez avec vos voyageurs — l'assistant traduit, analyse et suggère des réponses.</p>
            </div>
            @if($conversations->count())
                <div class="flex items-center gap-2">
                    <x-ui.badge variant="primary">
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z"/></svg>
                        {{ $conversations->count() }} conversation{{ $conversations->count() > 1 ? 's' : '' }}
                    </x-ui.badge>
                </div>
            @endif
        </div>

        @if($conversations->isEmpty())

            {{-- Empty state --}}
            <div class="panel p-12 sm:p-16 text-center">
                <div class="relative w-20 h-20 mx-auto mb-6">
                    <div class="absolute inset-0 rounded-3xl bg-navy-50 rotate-6"></div>
                    <div class="absolute inset-0 rounded-3xl bg-gold-100 -rotate-6"></div>
                    <div class="absolute inset-2 rounded-2xl bg-white flex items-center justify-center shadow-sm">
                        <svg class="w-9 h-9 text-surface-300" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z"/>
                        </svg>
                    </div>
                </div>
                <h3 class="text-lg font-semibold text-surface-900 mb-1">Aucune conversation</h3>
                <p class="text-sm text-surface-500 max-w-sm mx-auto">Les conversations liées à vos réservations apparaîtront ici. Le premier échange avec un voyageur ouvrira automatiquement une conversation.</p>
            </div>

        @else

        {{-- Workspace --}}
        <div class="grid grid-cols-1 lg:grid-cols-[340px_minmax(0,1fr)] gap-6 h-[70vh] lg:h-[calc(100vh-13.5rem)] min-h-[520px]">

            {{-- Sidebar --}}
            <div x-data="{ search: '' }" class="panel overflow-hidden flex flex-col min-h-0 {{ $active ? 'hidden lg:flex' : 'flex' }}">
                <div class="px-4 pt-4 pb-3 border-b border-surface-200/60 bg-white/40">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="relative flex-shrink-0">
                            <div class="w-10 h-10 rounded-full bg-navy-700 text-white flex items-center justify-center text-xs font-semibold">
                                {{ strtoupper(substr(auth()->user()->first_name ?? 'D', 0, 1)) }}{{ strtoupper(substr(auth()->user()->last_name ?? '?', 0, 1)) }}
                            </div>
                            <span class="absolute bottom-0 right-0 w-3 h-3 rounded-full bg-emerald-500 ring-2 ring-white"></span>
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="text-sm font-semibold text-surface-900 truncate">{{ auth()->user()->fullName() }}</p>
                            <p class="text-xs text-emerald-600 font-medium">En ligne</p>
                        </div>
                        <x-ui.badge variant="primary">{{ auth()->user()->isOwner() ? 'Propriétaire' : 'Voyageur' }}</x-ui.badge>
                    </div>
                    <div class="relative">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-surface-400 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
                        <input type="text" x-model="search" placeholder="Rechercher un voyageur…"
                               class="w-full rounded-xl border-surface-200/60 bg-surface-50/80 text-sm pl-9 pr-4 py-2.5 focus:border-navy-300 focus:ring-2 focus:ring-navy-500/20 focus:outline-none placeholder:text-surface-400 transition-all duration-200">
                    </div>
                </div>

                <div class="flex-1 overflow-y-auto p-2 space-y-1">
                    @foreach($conversations as $conv)
                        @php
                            $name = $conv->reservation->guest?->fullName() ?? 'Voyageur';
                            $propertyTitle = $conv->reservation->property?->title ?? 'Logement';
                            $preview = $conv->messages->first();
                            $isActive = $active?->id === $conv->id;
                            $isOpen = $conv->status === 'open';
                        @endphp
                        <a href="{{ route('conversations.index', ['conversation' => $conv->id]) }}"
                           data-search="{{ strtolower($name . ' ' . $propertyTitle) }}"
                           x-show="search === '' || $el.dataset.search.includes(search.toLowerCase())"
                           x-transition
                           class="flex items-center gap-3 p-3 rounded-xl transition-all duration-200 group {{ $isActive ? 'bg-navy-700 shadow-sm' : 'hover:bg-surface-100' }}">
                            <div class="relative flex-shrink-0">
                                <div class="w-12 h-12 rounded-full {{ $isActive ? 'bg-white/15 text-white' : 'bg-navy-700 text-white' }} flex items-center justify-center text-xs font-semibold">
                                    {{ strtoupper(substr($conv->reservation->guest?->first_name ?? 'U', 0, 1)) }}{{ strtoupper(substr($conv->reservation->guest?->last_name ?? '?', 0, 1)) }}
                                </div>
                                @if($isOpen)
                                    <span class="absolute bottom-0 right-0 w-3 h-3 rounded-full bg-emerald-500 ring-2 ring-white"></span>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between gap-2">
                                    <p class="text-sm font-semibold truncate {{ $isActive ? 'text-white' : 'text-surface-900' }}">{{ $name }}</p>
                                    @if($preview)
                                        <span class="text-[10px] flex-shrink-0 {{ $isActive ? 'text-white/60' : 'text-surface-400' }}">{{ $preview->created_at->format($preview->created_at->isToday() ? 'H:i' : 'd/m') }}</span>
                                    @endif
                                </div>
                                <div class="flex items-center gap-2 mt-0.5">
                                    <p class="text-xs truncate {{ $isActive ? 'text-white/60' : 'text-surface-400' }}">{{ $preview?->message ? Str::limit($preview->message, 40) : $propertyTitle }}</p>
                                    @if($conv->unread_count > 0)
                                        <span class="ml-auto inline-flex items-center justify-center min-w-[18px] h-[18px] px-1 rounded-full bg-gold-500 text-white text-[10px] font-semibold flex-shrink-0">{{ $conv->unread_count }}</span>
                                    @endif
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>

            {{-- Chat --}}
            <div class="panel overflow-hidden flex flex-col min-h-0 {{ $active ? 'flex' : 'hidden lg:flex' }}">
                @if($active)
                    <div class="px-4 sm:px-5 py-3 border-b border-surface-200/60 flex items-center justify-between gap-3 bg-white/70 backdrop-blur-sm">
                        <a href="{{ route('conversations.index') }}"
                           class="lg:hidden w-9 h-9 rounded-xl bg-surface-100 hover:bg-surface-200 text-surface-500 flex items-center justify-center flex-shrink-0 transition-colors">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
                        </a>
                        <div class="flex items-center gap-3 min-w-0 flex-1">
                            <div class="relative flex-shrink-0">
                                <div class="w-11 h-11 rounded-full bg-navy-700 text-white flex items-center justify-center text-xs font-semibold">
                                    {{ strtoupper(substr($guest?->first_name ?? 'U', 0, 1)) }}{{ strtoupper(substr($guest?->last_name ?? '?', 0, 1)) }}
                                </div>
                                @if($active->status === 'open')
                                    <span class="absolute bottom-0 right-0 w-3 h-3 rounded-full bg-emerald-500 ring-2 ring-white"></span>
                                @endif
                            </div>
                            <div class="min-w-0">
                                <div class="flex items-center gap-2">
                                    <p class="text-sm font-semibold text-surface-900 truncate">{{ $guest?->fullName() ?? 'Voyageur' }}</p>
                                </div>
                                <p class="text-xs truncate {{ $active->status === 'open' ? 'text-emerald-600 font-medium' : 'text-surface-400' }}">
                                    {{ $active->status === 'open' ? 'En ligne' : 'Conversation fermée' }}
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 flex-shrink-0">
                            <button type="button" x-on:click="aiPanel = true"
                                    class="inline-flex items-center gap-1.5 rounded-xl bg-gold-100 hover:bg-gold-200 text-gold-800 text-xs font-semibold px-3 py-2 transition-colors" title="Ouvrir l'assistant IA">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z"/></svg>
                                <span class="hidden sm:inline">Assistant IA</span>
                            </button>
                            <a href="{{ route('reservations.show', $active->reservation) }}"
                               class="w-9 h-9 rounded-xl bg-surface-100 hover:bg-surface-200 text-surface-500 hover:text-surface-900 flex items-center justify-center transition-colors" title="Voir la réservation">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                            </a>
                        </div>
                    </div>

                    <div x-data="{}" x-init="$nextTick(() => $el.scrollTop = $el.scrollHeight)" class="flex-1 overflow-y-auto chat-bg" x-ref="chatScroll">
                        <div class="px-4 sm:px-6 py-6 max-w-3xl mx-auto">
                            @if($messageGroups)
                                @foreach($messageGroups as $group)
                                    <div class="flex justify-center my-4">
                                        <span class="chat-date-chip">
                                            <svg class="w-3 h-3 text-gold-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                                            {{ $group['label'] }}
                                        </span>
                                    </div>
                                    @foreach($group['messages'] as $i => $msg)
                                        @php
                                            $isLast = $i === count($group['messages']) - 1;
                                            $isOwn = $msg->sender_id === auth()->id() && $msg->sender_type !== 'ai';
                                            $isAi = $msg->sender_type === 'ai';
                                            $avatarVisible = $isLast && !$isOwn && !$isAi;
                                        @endphp
                                        <div class="flex items-end gap-2 {{ $isOwn ? 'justify-end pl-8 sm:pl-16' : 'justify-start pr-8 sm:pr-16' }} my-1.5">
                                            @if(!$isOwn)
                                                <div class="w-8 flex-shrink-0 {{ $avatarVisible ? '' : 'invisible' }}">
                                                    <div class="w-8 h-8 rounded-full bg-navy-700 text-white flex items-center justify-center text-[10px] font-semibold">
                                                        {{ strtoupper(substr($guest?->first_name ?? 'U', 0, 1)) }}{{ strtoupper(substr($guest?->last_name ?? '?', 0, 1)) }}
                                                    </div>
                                                </div>
                                            @endif
                                            <div class="max-w-[78%] sm:max-w-[70%]">
                                                @if($isAi)
                                                    <div class="mb-0.5 flex items-center gap-1.5">
                                                        <span class="inline-flex items-center gap-1 text-[9px] font-semibold text-gold-800 bg-gold-100 rounded-full px-2 py-0.5">
                                                            <svg class="w-2.5 h-2.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z"/></svg>
                                                            Assistant IA
                                                        </span>
                                                    </div>
                                                @endif
                                                <div class="msg-bubble-{{ $isAi ? 'ai' : ($isOwn ? 'out' : 'in') }}">
                                                    <p class="whitespace-pre-wrap break-words">{{ $msg->message }}</p>
                                                    <span class="flex items-center justify-end gap-1 mt-0.5 -mb-0.5 ml-8 text-[10px] {{ $isOwn ? 'text-white/70' : 'text-surface-400' }}">
                                                        {{ $msg->created_at->format('H:i') }}
                                                        @if($isOwn && $isLast)
                                                            @if($msg->read_at)
                                                                <svg class="w-4 h-4 {{ $isOwn ? 'text-gold-300' : 'text-surface-300' }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12.75l5.25 5.25L20.25 5.25"/><path d="M9.75 15.75l1.5 1.5L23.25 4.5" opacity=".55"/></svg>
                                                            @else
                                                                <svg class="w-4 h-4 {{ $isOwn ? 'text-white/60' : 'text-surface-300' }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12.75l5.25 5.25L20.25 5.25"/></svg>
                                                            @endif
                                                        @endif
                                                    </span>
                                                </div>
                                                @if($msg->aiAnalysis)
                                                    <div x-data="{ analysisOpen: false }" class="mt-1.5">
                                                        <button type="button" x-on:click="analysisOpen = !analysisOpen" class="inline-flex items-center gap-1 text-[10px] font-semibold text-gold-700 hover:text-gold-900 bg-white/80 border border-gold-200/70 rounded-full px-2.5 py-1 transition-colors">
                                                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z"/></svg>
                                                            <span x-show="!analysisOpen">Afficher l'analyse</span>
                                                            <span x-show="analysisOpen" x-cloak>Masquer</span>
                                                        </button>
                                                        <div x-show="analysisOpen" x-transition x-cloak class="mt-2 p-3 bg-white/90 border border-gold-200/70 rounded-xl shadow-sm space-y-2">
                                                            <div class="flex flex-wrap gap-1.5">
                                                                <span class="inline-flex items-center gap-1 rounded-full bg-gold-50 border border-gold-200 px-2 py-0.5 text-[10px] font-medium text-surface-600">
                                                                    {{ $msg->aiAnalysis->detected_language ?? 'Auto' }}
                                                                </span>
                                                                <span class="inline-flex items-center rounded-full bg-gold-50 border border-gold-200 px-2 py-0.5 text-[10px] font-medium text-surface-600">
                                                                    {{ $categoryLabels[$msg->aiAnalysis->category] ?? $msg->aiAnalysis->category }}
                                                                </span>
                                                                @if($msg->aiAnalysis->confidence)
                                                                    <span class="inline-flex items-center rounded-full bg-gold-50 border border-gold-200 px-2 py-0.5 text-[10px] font-medium text-surface-600">Confiance {{ round($msg->aiAnalysis->confidence * 100) }}%</span>
                                                                @endif
                                                            </div>
                                                            @if($msg->aiAnalysis->urgency)
                                                                <p class="flex items-center gap-1.5 text-[11px] font-semibold text-red-700">
                                                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg>
                                                                    Urgence détectée
                                                                </p>
                                                            @endif
                                                            @if($msg->aiAnalysis->generated_response)
                                                                <p class="text-xs text-surface-600 leading-relaxed">{{ Str::limit($msg->aiAnalysis->generated_response, 200) }}</p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                @endforeach

                                @if($lastMessage && $lastMessage->sender_id !== auth()->id() && $lastMessage->sender_type !== 'ai' && !$lastMessage->aiAnalysis)
                                    <div class="flex items-end gap-2 my-1.5">
                                        <div class="w-8 flex-shrink-0">
                                            <div class="w-8 h-8 rounded-full bg-navy-700 text-white flex items-center justify-center text-[10px] font-semibold">
                                                {{ strtoupper(substr($guest?->first_name ?? 'U', 0, 1)) }}{{ strtoupper(substr($guest?->last_name ?? '?', 0, 1)) }}
                                            </div>
                                        </div>
                                        <div class="msg-bubble-in flex items-center gap-1.5 text-gold-700" x-data>
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z"/></svg>
                                            <span class="text-xs font-medium">L'assistant analyse le message</span>
                                            <span class="typing-dot"></span>
                                            <span class="typing-dot"></span>
                                            <span class="typing-dot"></span>
                                        </div>
                                    </div>
                                @endif
                            @else
                                <div class="flex items-center justify-center h-full">
                                    <div class="text-center">
                                        <div class="w-14 h-14 rounded-2xl bg-gold-50 flex items-center justify-center mx-auto mb-3">
                                            <svg class="w-7 h-7 text-gold-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z"/></svg>
                                        </div>
                                        <p class="text-sm font-medium text-surface-600">Aucun message pour le moment</p>
                                        <p class="text-xs text-surface-400 mt-1">Écrivez le premier message à votre voyageur.</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="px-4 py-3.5 border-t border-surface-200/60 bg-white/70 backdrop-blur-sm">
                        <form method="POST" action="{{ route('conversations.messages.store', $active) }}" class="flex items-center gap-3">
                            @csrf
                            <input type="text" name="message" required placeholder="Écrire un message…" autocomplete="off"
                                   class="flex-1 rounded-full border-surface-200/60 bg-white text-sm px-5 py-3 focus:border-navy-300 focus:ring-2 focus:ring-navy-500/20 focus:outline-none placeholder:text-surface-400 transition-all duration-200">
                            <button type="submit"
                                    class="w-11 h-11 rounded-full bg-navy-700 hover:bg-navy-800 text-white flex items-center justify-center shadow-sm transition-colors flex-shrink-0" title="Envoyer">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5"/></svg>
                            </button>
                        </form>
                    </div>
                @else
                    <div class="flex-1 flex items-center justify-center p-8">
                        <div class="text-center">
                            <div class="relative w-20 h-20 mx-auto mb-6">
                                <div class="absolute inset-0 rounded-3xl bg-navy-50 rotate-6"></div>
                                <div class="absolute inset-0 rounded-3xl bg-gold-100 -rotate-6"></div>
                                <div class="absolute inset-2 rounded-2xl bg-white flex items-center justify-center shadow-sm">
                                    <svg class="w-9 h-9 text-surface-300" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z"/></svg>
                                </div>
                            </div>
                            <h3 class="text-base font-semibold text-surface-900 mb-1">Sélectionnez une conversation</h3>
                            <p class="text-sm text-surface-500 max-w-sm mx-auto">Choisissez une conversation dans la liste pour ouvrir la discussion avec l'assistant IA.</p>
                        </div>
                    </div>
                @endif
            </div>

        </div>
        @endif

        <x-ui.ai-panel :analysis="$lastAnalysis" :category-labels="$categoryLabels" />
    </div>
</x-app-layout>
