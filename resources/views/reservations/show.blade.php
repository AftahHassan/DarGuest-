<x-app-layout>
    @php
        $isOwner = auth()->user()->isOwner();
        $guest = $reservation->guest;
        $conversation = $reservation->conversation;
        $nights = max($reservation->check_in_date->diffInDays($reservation->check_out_date), 1);
        $heroImage = $reservation->property?->images->first();
        $lastAnalysis = $conversation?->messages?->reduce(function ($carry, $msg) {
            return $msg->aiAnalysis ? $msg->aiAnalysis : $carry;
        }, null);
        $categoryLabels = [
            'accommodation' => 'Logement', 'check_in' => 'Check-in', 'check_out' => 'Check-out',
            'wifi' => 'Wi-Fi', 'parking' => 'Parking', 'restaurant' => 'Restaurant',
            'taxi' => 'Taxi', 'beach' => 'Plage', 'surf_school' => 'École de surf',
            'house_rules' => 'Règlement', 'technical_problem' => 'Problème technique',
            'emergency' => 'Urgence', 'other' => 'Autre',
        ];
        $statusVariant = match($reservation->status) {
            'confirmed' => 'success', 'pending' => 'warning', 'cancelled' => 'danger',
            'completed' => 'gray', default => 'gray',
        };
        $statusLabel = match($reservation->status) {
            'confirmed' => 'Confirmée', 'pending' => 'En attente',
            'cancelled' => 'Annulée', 'completed' => 'Terminée',
            default => $reservation->status,
        };
    @endphp

    <div x-data="{ statusId: {{ $reservation->id }}, statusValue: '{{ $reservation->status }}', cancelId: {{ $reservation->id }} }" class="space-y-8">

        {{-- Back --}}
        <div>
            <a href="{{ route('reservations.index') }}" class="inline-flex items-center gap-2 text-sm font-medium text-surface-500 hover:text-surface-900 transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
                Retour aux réservations
            </a>
        </div>

        {{-- Toasts --}}
        @if (session('status'))
            <x-ui.toast type="success" title="Succès" :message="session('status')" />
        @endif

        {{-- Hero Header --}}
        <div class="relative rounded-3xl overflow-hidden shadow-elevated">
            @if ($heroImage)
                <img src="{{ asset('storage/' . $heroImage->image) }}" alt="{{ $reservation->property?->title }}" class="absolute inset-0 w-full h-full object-cover">
            @else
                <div class="absolute inset-0 bg-hero-gradient"></div>
            @endif
            <div class="absolute inset-0 bg-gradient-to-t from-surface-950/90 via-surface-950/40 to-transparent"></div>

            <div class="relative z-10 px-6 sm:px-10 pt-28 sm:pt-40 pb-8 sm:pb-10">
                <div class="flex flex-wrap items-center gap-3">
                    <span class="inline-flex items-center gap-1.5 text-[11px] font-semibold text-white/70 uppercase tracking-widest">
                        Détail réservation
                    </span>
                    <x-ui.badge :variant="$statusVariant" dot>{{ $statusLabel }}</x-ui.badge>
                </div>
                <h1 class="mt-3 text-2xl sm:text-4xl font-bold text-white tracking-tight">{{ $reservation->property?->title ?? 'Logement supprimé' }}</h1>
                <div class="mt-3 flex flex-wrap items-center gap-x-6 gap-y-2 text-sm text-white/80">
                    <span class="flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>
                        {{ $reservation->property?->city ?? '—' }}, Maroc
                    </span>
                    <span class="flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25"/></svg>
                        {{ $reservation->check_in_date->format('d M Y') }} → {{ $reservation->check_out_date->format('d M Y') }}
                    </span>
                    <span class="flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/></svg>
                        {{ $reservation->number_of_guests }} voyageur{{ $reservation->number_of_guests > 1 ? 's' : '' }}
                    </span>
                </div>
            </div>
        </div>

        {{-- Info cards --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Voyageur --}}
            <div class="panel-hover">
                <div class="px-6 py-5 border-b border-surface-200/60 flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-navy-50 flex items-center justify-center">
                        <svg class="w-4.5 h-4.5 text-navy-700" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                    </div>
                    <div>
                        <h2 class="text-sm font-semibold text-surface-900">Informations du voyageur</h2>
                        <p class="text-xs text-surface-500">Coordonnées et profil</p>
                    </div>
                </div>
                <div class="p-6">
                    <div class="flex items-center gap-3 mb-5">
                        <div class="w-12 h-12 rounded-full bg-navy-700 text-white flex items-center justify-center text-sm font-semibold shadow-sm">
                            {{ strtoupper(substr($guest?->first_name ?? '?', 0, 1)) }}{{ strtoupper(substr($guest?->last_name ?? '?', 0, 1)) }}
                        </div>
                        <div>
                            <p class="font-semibold text-surface-900">{{ $guest?->fullName() ?? 'Voyageur' }}</p>
                            <p class="text-xs text-surface-500">{{ $lastAnalysis?->detected_language ? 'Langue : ' . $lastAnalysis->detected_language : 'Langue : Français' }}</p>
                        </div>
                    </div>
                    <div class="space-y-3 text-sm">
                        <div class="flex items-center gap-3">
                            <svg class="w-4 h-4 text-surface-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/></svg>
                            <span class="text-surface-600">{{ $guest?->phone ?? 'Non renseigné' }}</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <svg class="w-4 h-4 text-surface-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
                            <a href="mailto:{{ $guest?->email }}" class="text-navy-700 hover:text-navy-900 font-medium">{{ $guest?->email ?? '—' }}</a>
                        </div>
                        <div class="flex items-center gap-3">
                            <svg class="w-4 h-4 text-surface-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 11-3 0m3 0a1.5 1.5 0 10-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-9.75 0h9.75"/></svg>
                            <span class="text-surface-600">{{ $reservation->number_of_guests }} personne{{ $reservation->number_of_guests > 1 ? 's' : '' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Réservation --}}
            <div class="panel-hover">
                <div class="px-6 py-5 border-b border-surface-200/60 flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-gold-50 flex items-center justify-center">
                        <svg class="w-4.5 h-4.5 text-gold-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                    </div>
                    <div>
                        <h2 class="text-sm font-semibold text-surface-900">Informations réservation</h2>
                        <p class="text-xs text-surface-500">Détails du séjour</p>
                    </div>
                </div>
                <div class="p-6 space-y-4 text-sm">
                    <div class="flex items-center justify-between">
                        <span class="text-surface-500">Check-in</span>
                        <span class="font-semibold text-surface-900">{{ $reservation->check_in_date->format('l d M Y') }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-surface-500">Check-out</span>
                        <span class="font-semibold text-surface-900">{{ $reservation->check_out_date->format('l d M Y') }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-surface-500">Durée</span>
                        <span class="font-semibold text-surface-900">{{ $nights }} nuit{{ $nights > 1 ? 's' : '' }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-surface-500">Voyageurs</span>
                        <span class="font-semibold text-surface-900">{{ $reservation->number_of_guests }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-surface-500">Paiement</span>
                        @if($reservation->status === 'confirmed')
                            <span class="inline-flex items-center gap-1.5 text-emerald-600 font-semibold">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Payé
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 text-amber-600 font-semibold">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                En attente
                            </span>
                        @endif
                    </div>
                    <div class="flex items-center justify-between pt-4 border-t border-surface-200/60">
                        <span class="font-medium text-surface-700">Montant total</span>
                        <p class="text-xl font-bold text-surface-900">{{ number_format($reservation->total_price, 0, ',', ' ') }} <span class="text-xs font-normal text-surface-400">MAD</span></p>
                    </div>
                </div>
            </div>

            {{-- IA --}}
            <div class="panel-hover overflow-hidden">
                <div class="px-6 py-5 border-b border-surface-200/60 flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-gold-100 flex items-center justify-center">
                        <svg class="w-4.5 h-4.5 text-gold-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.455 2.456L21.75 6l-1.036.259a3.375 3.375 0 00-2.455 2.456zM16.894 20.567L16.5 21.75l-.394-1.183a2.25 2.25 0 00-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 001.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 001.423 1.423l1.183.394-1.183.394a2.25 2.25 0 00-1.423 1.423z"/></svg>
                    </div>
                    <div>
                        <h2 class="text-sm font-semibold text-surface-900">Informations IA</h2>
                        <p class="text-xs text-surface-500">Analyse intelligente</p>
                    </div>
                </div>
                <div class="p-6">
                    @if ($lastAnalysis)
                        <div class="flex flex-wrap gap-2 mb-4">
                            <span class="badge-primary !text-[10px]">
                                <svg class="w-3 h-3 inline mr-1" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 21l5.25-11.25L21 21m-9-3h7.5M3 5.621a48.474 48.474 0 016-.371m0 0c1.12 0 2.233.038 3.334.114M9 5.25V3m3.334 2.364C11.176 10.658 7.69 15.08 3 17.502m9.334-12.138c.896.061 1.785.147 2.666.257m-4.589 8.495a18.023 18.023 0 01-3.827-5.802"/></svg>
                                {{ $lastAnalysis->detected_language ?? 'Auto' }}
                            </span>
                            <span class="badge-primary !text-[10px]">{{ $categoryLabels[$lastAnalysis->category] ?? $lastAnalysis->category }}</span>
                            @if ($lastAnalysis->confidence)
                                <span class="badge-gray !text-[10px]">Confiance {{ round($lastAnalysis->confidence * 100) }}%</span>
                            @endif
                        </div>

                        @if ($lastAnalysis->urgency)
                            <div class="flex items-start gap-3 rounded-xl bg-red-50 border border-red-200 p-4 mb-4">
                                <div class="w-8 h-8 rounded-lg bg-red-100 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-4 h-4 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-red-700">Urgence détectée</p>
                                    <p class="text-xs text-red-600 mt-0.5">Intervention immédiate recommandée.</p>
                                </div>
                            </div>
                        @endif

                        <p class="text-[10px] font-semibold text-navy-700 uppercase tracking-wider mb-1.5">Résumé automatique</p>
                        <p class="text-sm text-surface-600 leading-relaxed">{{ $lastAnalysis->generated_response ? Str::limit($lastAnalysis->generated_response, 220) : 'Aucun résumé disponible pour le moment.' }}</p>

                        <p class="text-[10px] font-semibold text-navy-700 uppercase tracking-wider mt-4 mb-1.5">Traduction du dernier message</p>
                        <p class="text-sm text-surface-600 leading-relaxed italic">« {{ Str::limit($conversation?->messages?->last()?->message ?? '—', 140) }} »</p>
                    @else
                        <div class="text-center py-6">
                            <div class="w-12 h-12 rounded-2xl bg-gold-50 flex items-center justify-center mx-auto mb-3">
                                <svg class="w-6 h-6 text-gold-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z"/></svg>
                            </div>
                            <p class="text-sm font-medium text-surface-600">Pas encore d'analyse</p>
                            <p class="text-xs text-surface-400 mt-1">L'IA analysera les messages échangés.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Actions --}}
        <div class="flex flex-wrap items-center gap-3">
            <x-button href="{{ $conversation ? route('conversations.show', $conversation) : route('conversations.index') }}">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z"/></svg>
                Contacter le voyageur
            </x-button>
            <x-button variant="secondary" x-on:click="window.print()">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                Télécharger PDF
            </x-button>
            @if($isOwner)
                <x-button variant="secondary" x-on:click="$dispatch('open-modal', 'status-reservation')">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125"/></svg>
                    Modifier
                </x-button>
            @endif
            @if(in_array($reservation->status, ['pending', 'confirmed']))
                <x-button variant="danger" x-on:click="$dispatch('open-modal', 'cancel-reservation')">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Annuler
                </x-button>
            @endif
        </div>

        {{-- Conversation --}}
        @if ($conversation)
            <div class="panel overflow-hidden">
                <div class="px-6 py-5 border-b border-surface-200/60 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-navy-50 flex items-center justify-center">
                            <svg class="w-4.5 h-4.5 text-navy-700" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z"/></svg>
                        </div>
                        <div>
                            <h2 class="text-sm font-semibold text-surface-900">Conversation</h2>
                            <p class="text-xs text-surface-500">{{ $conversation->messages->count() }} message{{ $conversation->messages->count() > 1 ? 's' : '' }}</p>
                        </div>
                    </div>
                    <a href="{{ route('conversations.show', $conversation) }}" class="text-sm font-medium text-navy-700 hover:text-navy-800 transition-colors">Ouvrir la messagerie →</a>
                </div>
                <div class="p-6 space-y-4 max-h-72 overflow-y-auto">
                    @forelse ($conversation->messages->take(-3) as $message)
                        @php $isOwn = $message->sender_id === auth()->id(); @endphp
                        <div class="flex {{ $isOwn ? 'justify-end' : 'justify-start' }}">
                            <div class="max-w-[80%]">
                                <div class="px-4 py-3 rounded-2xl text-sm leading-relaxed
                                    @if ($message->sender_type === 'ai')
                                        bg-gold-50 border border-gold-200/60 text-surface-800 rounded-bl-md
                                    @else
                                        {{ $isOwn ? 'bg-navy-700 text-white rounded-br-md' : 'bg-surface-100 text-surface-800 rounded-bl-md' }}
                                    @endif">
                                    {{ $message->message }}
                                </div>
                                <p class="text-[10px] text-surface-400 mt-1 px-1">{{ $message->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-sm text-surface-400 py-6">Aucun message pour l'instant.</p>
                    @endforelse
                </div>
            </div>
        @endif

        {{-- Status modal --}}
        <x-ui.modal id="status-reservation" maxWidth="sm">
            <div class="text-center">
                <div class="w-14 h-14 rounded-2xl bg-navy-50 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-7 h-7 text-navy-700" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125"/></svg>
                </div>
                <h3 class="text-lg font-semibold text-surface-900 mb-1">Modifier le statut</h3>
                <p class="text-sm text-surface-500 mb-6">Sélectionnez le nouveau statut de la réservation.</p>
                <form method="POST" action="{{ route('reservations.status', $reservation) }}" class="space-y-4">
                    @csrf @method('PATCH')
                    <select x-model="statusValue" name="status"
                            class="w-full rounded-xl border-surface-200/60 bg-white/80 text-sm py-2.5 focus:border-navy-300 focus:ring-2 focus:ring-navy-500/20 focus:outline-none transition-all duration-200">
                        <option value="pending">En attente</option>
                        <option value="confirmed">Confirmée</option>
                        <option value="cancelled">Annulée</option>
                        <option value="completed">Terminée</option>
                    </select>
                    <div class="flex items-center justify-center gap-3">
                        <x-button variant="secondary" size="sm" x-on:click="$dispatch('close-modal', 'status-reservation')">Annuler</x-button>
                        <x-button type="submit" size="sm">Enregistrer</x-button>
                    </div>
                </form>
            </div>
        </x-ui.modal>

        {{-- Cancel modal --}}
        <x-ui.modal id="cancel-reservation" maxWidth="sm">
            <div class="text-center">
                <div class="w-14 h-14 rounded-2xl bg-red-50 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-7 h-7 text-red-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg>
                </div>
                <h3 class="text-lg font-semibold text-surface-900 mb-1">Annuler cette réservation ?</h3>
                <p class="text-sm text-surface-500 mb-2">Cette action est irréversible.</p>
                <p class="text-xs text-surface-400 mb-6">Le voyageur sera informé de l'annulation.</p>
                <div class="flex items-center justify-center gap-3">
                    <x-button variant="secondary" size="sm" x-on:click="$dispatch('close-modal', 'cancel-reservation')">Retour</x-button>
                    <form method="POST" action="{{ route('reservations.cancel', $reservation) }}">
                        @csrf @method('PATCH')
                        <x-button type="submit" variant="danger" size="sm">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Confirmer l'annulation
                        </x-button>
                    </form>
                </div>
            </div>
        </x-ui.modal>

    </div>
</x-app-layout>
