<x-app-layout>
    <div class="space-y-10">

        {{-- Welcome --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-surface-900 tracking-tight">Bonjour {{ auth()->user()->first_name }} 👋</h1>
                <p class="text-surface-500 mt-1">{{ now()->format('l d F Y') }}</p>
            </div>
            <a href="{{ route('properties.create') }}" class="btn-primary px-5 py-2.5 self-start">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                </svg>
                Ajouter un logement
            </a>
        </div>

        {{-- Stats Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
            <div class="card p-5 hover:shadow-card-hover hover:border-surface-300 transition-all duration-200">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-10 h-10 rounded-xl bg-navy-50 flex items-center justify-center text-navy-700">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/>
                        </svg>
                    </div>
                    <span class="inline-flex items-center gap-0.5 text-xs font-medium {{ $stats['property_change'] >= 0 ? 'text-emerald-600' : 'text-red-600' }}">
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $stats['property_change'] >= 0 ? 'M4.5 15.75l7.5-7.5 7.5 7.5' : 'M19.5 8.25l-7.5 7.5-7.5-7.5' }}"/>
                        </svg>
                        {{ $stats['property_change'] }}%
                    </span>
                </div>
                <p class="text-2xl font-bold text-surface-900">{{ $stats['total_properties'] }}</p>
                <p class="text-sm text-surface-500 mt-0.5">Logements</p>
            </div>

            <div class="card p-5 hover:shadow-card-hover hover:border-surface-300 transition-all duration-200">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/>
                        </svg>
                    </div>
                    <span class="inline-flex items-center gap-0.5 text-xs font-medium {{ $stats['reservation_change'] >= 0 ? 'text-emerald-600' : 'text-red-600' }}">
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $stats['reservation_change'] >= 0 ? 'M4.5 15.75l7.5-7.5 7.5 7.5' : 'M19.5 8.25l-7.5 7.5-7.5-7.5' }}"/>
                        </svg>
                        {{ $stats['reservation_change'] }}%
                    </span>
                </div>
                <p class="text-2xl font-bold text-surface-900">{{ $stats['total_reservations'] }}</p>
                <p class="text-sm text-surface-500 mt-0.5">Réservations</p>
            </div>

            <div class="card p-5 hover:shadow-card-hover hover:border-surface-300 transition-all duration-200">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center text-amber-600">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <span class="inline-flex items-center gap-0.5 text-xs font-medium {{ ($stats['revenue_change'] ?? 0) >= 0 ? 'text-emerald-600' : 'text-red-600' }}">
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ ($stats['revenue_change'] ?? 0) >= 0 ? 'M4.5 15.75l7.5-7.5 7.5 7.5' : 'M19.5 8.25l-7.5 7.5-7.5-7.5' }}"/>
                        </svg>
                        {{ $stats['revenue_change'] ?? 0 }}%
                    </span>
                </div>
                <p class="text-2xl font-bold text-surface-900">{{ number_format($stats['total_revenue'], 0, ',', ' ') }} <span class="text-xs font-normal text-surface-500">MAD</span></p>
                <p class="text-sm text-surface-500 mt-0.5">Revenu total</p>
            </div>

            <div class="card p-5 hover:shadow-card-hover hover:border-surface-300 transition-all duration-200">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-10 h-10 rounded-xl bg-purple-50 flex items-center justify-center text-purple-600">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.455 2.456L21.75 6l-1.036.259a3.375 3.375 0 00-2.455 2.456zM16.894 20.567L16.5 21.75l-.394-1.183a2.25 2.25 0 00-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 001.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 001.423 1.423l1.183.394-1.183.394a2.25 2.25 0 00-1.423 1.423z"/>
                        </svg>
                    </div>
                    <span class="inline-flex items-center gap-0.5 text-xs font-medium {{ $stats['ai_change'] >= 0 ? 'text-emerald-600' : 'text-red-600' }}">
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $stats['ai_change'] >= 0 ? 'M4.5 15.75l7.5-7.5 7.5 7.5' : 'M19.5 8.25l-7.5 7.5-7.5-7.5' }}"/>
                        </svg>
                        {{ $stats['ai_change'] }}%
                    </span>
                </div>
                <p class="text-2xl font-bold text-surface-900">{{ $stats['ai_messages_count'] }}</p>
                <p class="text-sm text-surface-500 mt-0.5">Messages IA</p>
            </div>

            <div class="card p-5 hover:shadow-card-hover hover:border-surface-300 transition-all duration-200">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-10 h-10 rounded-xl bg-red-50 flex items-center justify-center text-red-600">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>
                        </svg>
                    </div>
                    <span class="inline-flex items-center gap-0.5 text-xs font-medium {{ $stats['urgent_messages'] > 0 ? 'text-red-600' : 'text-emerald-600' }}">
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $stats['urgent_messages'] > 0 ? 'M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z' : 'M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z' }}"/>
                        </svg>
                        {{ $stats['urgent_messages'] > 0 ? $stats['urgent_messages'] . ' urgentes' : 'Aucune' }}
                    </span>
                </div>
                <p class="text-2xl font-bold text-surface-900">{{ $stats['urgent_messages'] }}</p>
                <p class="text-sm text-surface-500 mt-0.5">Urgences</p>
            </div>
        </div>

        {{-- Graphique + Urgences --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
            <div class="card lg:col-span-2">
                <div class="px-6 py-5 border-b border-surface-100">
                    <h2 class="text-lg font-semibold text-surface-900">Revenus {{ now()->year }}</h2>
                    <p class="text-sm text-surface-500 mt-0.5">Évolution mensuelle des réservations confirmées</p>
                </div>
                <div class="p-6">
                    @php
                        $months = ['Jan','Fév','Mar','Avr','Mai','Jun','Jul','Aoû','Sep','Oct','Nov','Déc'];
                        $maxRevenue = max($monthlyRevenue ?: [1]);
                        $maxBookings = max($monthlyBookings ?: [1]);
                    @endphp
                    <div class="flex items-end gap-1.5 h-48">
                        @for ($i = 1; $i <= 12; $i++)
                            @php
                                $revenue = $monthlyRevenue[$i] ?? 0;
                                $bookings = $monthlyBookings[$i] ?? 0;
                                $revenuePercent = ($revenue / $maxRevenue) * 100;
                                $bookingsPercent = ($bookings / $maxBookings) * 100;
                            @endphp
                            <div class="flex-1 flex flex-col items-center gap-1 h-full justify-end">
                                <div class="relative w-full flex flex-col items-center justify-end h-full" style="max-height: 100%">
                                    <div class="w-full bg-amber-100 rounded-t-md transition-all duration-500 hover:bg-amber-200 relative group" style="height: {{ max($bookingsPercent, 1) }}%">
                                        <div class="absolute -top-8 left-1/2 -translate-x-1/2 bg-surface-900 text-white text-[10px] px-2 py-0.5 rounded-md opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap z-10 pointer-events-none">
                                            {{ $bookings }} réservation(s)
                                        </div>
                                    </div>
                                    <div class="w-full bg-navy-700 rounded-t-md transition-all duration-500 hover:bg-navy-800 relative group" style="height: {{ max($revenuePercent, 1) }}%">
                                        <div class="absolute -top-8 left-1/2 -translate-x-1/2 bg-surface-900 text-white text-[10px] px-2 py-0.5 rounded-md opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap z-10 pointer-events-none">
                                            {{ number_format($revenue, 0, ',', ' ') }} MAD
                                        </div>
                                    </div>
                                </div>
                                <span class="text-[10px] text-surface-400 font-medium mt-1">{{ $months[$i - 1] }}</span>
                            </div>
                        @endfor
                    </div>
                    <div class="flex items-center gap-6 mt-6 pt-4 border-t border-surface-100 text-sm">
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-sm bg-navy-700"></span>
                            <span class="text-surface-600">Revenus</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-sm bg-amber-100 border border-amber-200"></span>
                            <span class="text-surface-600">Réservations</span>
                        </div>
                        <div class="ml-auto">
                            <span class="font-semibold text-surface-900">{{ number_format(array_sum($monthlyRevenue), 0, ',', ' ') }} MAD</span>
                            <span class="text-surface-500"> total</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="px-6 py-5 border-b border-surface-100 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <h2 class="text-lg font-semibold text-surface-900">Urgences</h2>
                        @if ($urgentAnalyses->count() > 0)
                            <span class="w-2 h-2 rounded-full bg-red-500 animate-pulse"></span>
                        @endif
                    </div>
                    <span class="text-xs font-medium text-surface-500">{{ $urgentAnalyses->count() }} non traitées</span>
                </div>
                <div class="divide-y divide-surface-100">
                    @forelse ($urgentAnalyses->take(5) as $analysis)
                        <div class="px-6 py-4 hover:bg-red-50/50 transition-colors">
                            <div class="flex items-start gap-3">
                                <div class="w-2 h-2 rounded-full bg-red-500 mt-1.5 flex-shrink-0"></div>
                                <div class="min-w-0">
                                    <p class="text-sm font-medium text-surface-900 truncate">{{ $analysis->message?->conversation?->reservation?->property?->title ?? 'Logement' }}</p>
                                    <p class="text-xs text-surface-500 mt-0.5 line-clamp-2">{{ $analysis->message?->body ?? 'Message urgent détecté' }}</p>
                                    <p class="text-[10px] text-surface-400 mt-1">{{ $analysis->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="px-6 py-10 text-center">
                            <div class="w-12 h-12 rounded-2xl bg-emerald-50 flex items-center justify-center mx-auto mb-3">
                                <svg class="w-6 h-6 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <p class="text-sm font-medium text-surface-600">Tout est calme</p>
                            <p class="text-xs text-surface-400 mt-1">Aucune urgence détectée</p>
                        </div>
                    @endforelse
                </div>
                @if ($urgentAnalyses->count() > 0 && Route::has('ai-analysis.index'))
                    <div class="px-6 py-4 border-t border-surface-100">
                        <a href="{{ route('ai-analysis.index') }}" class="text-sm font-medium text-navy-700 hover:text-navy-800 transition-colors">Voir toutes les analyses</a>
                    </div>
                @endif
            </div>
        </div>

        {{-- Dernières réservations --}}
        <div>
            <div class="flex items-center justify-between mb-5">
                <h2 class="text-lg font-semibold text-surface-900">Dernières réservations</h2>
                <a href="{{ route('reservations.index') }}" class="text-sm font-medium text-navy-700 hover:text-navy-800 transition-colors">Voir tout</a>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                @forelse ($recentReservations->take(3) as $reservation)
                    <div class="card overflow-hidden hover:shadow-card-hover hover:border-surface-300 transition-all duration-200 group">
                        <div class="h-36 bg-surface-100 relative overflow-hidden">
                            @if($reservation->property && $reservation->property->images->isNotEmpty())
                                <img src="{{ Storage::url($reservation->property->images->first()->path) }}" alt="{{ $reservation->property->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <svg class="w-8 h-8 text-surface-300" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.41a2.25 2.25 0 013.182 0l2.909 2.91m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/>
                                    </svg>
                                </div>
                            @endif
                            <div class="absolute top-3 right-3">
                                @php
                                    $v = match($reservation->status) { 'confirmed' => 'success', 'pending' => 'warning', 'cancelled' => 'danger', default => 'gray' };
                                @endphp
                                <span class="badge-{{ $v }}">
                                    @if($reservation->status === 'confirmed') Confirmée
                                    @elseif($reservation->status === 'pending') En attente
                                    @elseif($reservation->status === 'cancelled') Annulée
                                    @else {{ $reservation->status }}
                                    @endif
                                </span>
                            </div>
                            <div class="absolute bottom-3 left-3 flex items-center gap-2 bg-white/90 backdrop-blur-sm rounded-lg px-2.5 py-1.5 shadow-sm">
                                <div class="w-6 h-6 rounded-full bg-navy-700 text-white flex items-center justify-center text-[9px] font-semibold">
                                    {{ strtoupper(substr($reservation->guest?->first_name ?? '?', 0, 1)) }}{{ strtoupper(substr($reservation->guest?->last_name ?? '?', 0, 1)) }}
                                </div>
                                <span class="text-xs font-medium text-surface-900">{{ $reservation->guest?->fullName() ?? 'N/A' }}</span>
                            </div>
                        </div>
                        <div class="p-5">
                            <h3 class="font-semibold text-surface-900">{{ $reservation->property?->title ?? 'N/A' }}</h3>
                            <div class="flex items-center gap-4 mt-2 text-xs text-surface-500">
                                <span class="flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25"/>
                                    </svg>
                                    {{ $reservation->check_in_date->format('d M') }} → {{ $reservation->check_out_date->format('d M') }}
                                </span>
                                <span class="flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ number_format($reservation->total_price, 0, ',', ' ') }} MAD
                                </span>
                            </div>
                            <div class="flex gap-2 mt-4 pt-4 border-t border-surface-100">
                                <a href="{{ route('reservations.show', $reservation) }}" class="btn-secondary text-sm px-4 py-2 flex-1">Voir détails</a>
                                <a href="{{ Route::has('conversations.index') ? route('conversations.index') : '#' }}" class="btn-ghost text-sm px-3 py-2">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="card p-12 text-center lg:col-span-3">
                        <div class="w-14 h-14 rounded-2xl bg-surface-100 flex items-center justify-center mx-auto mb-4">
                            <svg class="w-7 h-7 text-surface-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/>
                            </svg>
                        </div>
                        <p class="text-surface-500">Aucune réservation pour le moment.</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Mes logements --}}
        <div>
            <div class="flex items-center justify-between mb-5">
                <h2 class="text-lg font-semibold text-surface-900">Mes logements</h2>
                <a href="{{ route('properties.index') }}" class="text-sm font-medium text-navy-700 hover:text-navy-800 transition-colors">Voir tout</a>
            </div>
            @if ($recentProperties->isEmpty())
                <div class="card p-12 text-center">
                    <div class="w-14 h-14 rounded-2xl bg-surface-100 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-7 h-7 text-surface-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/>
                        </svg>
                    </div>
                    <p class="text-surface-500 mb-4">Aucun logement pour l'instant.</p>
                    <a href="{{ route('properties.create') }}" class="btn-primary px-5 py-2.5">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                        </svg>
                        Ajouter un logement
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                    @foreach ($recentProperties->take(3) as $property)
                        <div class="card overflow-hidden hover:shadow-card-hover hover:border-surface-300 transition-all duration-200 group">
                            <div class="h-40 bg-surface-100 relative overflow-hidden">
                                @if($property->images->isNotEmpty())
                                    <img src="{{ Storage::url($property->images->first()->path) }}" alt="{{ $property->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <svg class="w-10 h-10 text-surface-300" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.41a2.25 2.25 0 013.182 0l2.909 2.91m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/>
                                        </svg>
                                    </div>
                                @endif
                                <span class="absolute top-3 right-3 badge {{ $property->status === 'available' ? 'badge-success' : 'badge-gray' }}">
                                    {{ $property->status === 'available' ? 'Disponible' : 'Occupé' }}
                                </span>
                            </div>
                            <div class="p-5">
                                <h3 class="font-semibold text-surface-900">{{ $property->title }}</h3>
                                <p class="text-sm text-surface-500 mt-1">{{ $property->city }}</p>
                                <p class="text-lg font-bold text-surface-900 mt-3">{{ number_format($property->price_per_night, 0, ',', ' ') }} <span class="text-xs font-normal text-surface-500">MAD/nuit</span></p>
                                <div class="flex gap-2 mt-4 pt-4 border-t border-surface-100">
                                    <a href="{{ route('properties.show', $property) }}" class="btn-secondary text-sm px-4 py-2 flex-1">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                        Voir
                                    </a>
                                    <a href="{{ route('properties.edit', $property) }}" class="btn-secondary text-sm px-4 py-2 flex-1">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/>
                                        </svg>
                                        Modifier
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Assistant IA --}}
        <div class="card bg-gradient-to-br from-navy-700 to-navy-800 border-navy-700 p-6 text-white">
            <div class="flex items-center gap-3 mb-5">
                <div class="w-10 h-10 rounded-xl bg-white/10 backdrop-blur-sm border border-white/20 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.455 2.456L21.75 6l-1.036.259a3.375 3.375 0 00-2.455 2.456zM16.894 20.567L16.5 21.75l-.394-1.183a2.25 2.25 0 00-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 001.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 001.423 1.423l1.183.394-1.183.394a2.25 2.25 0 00-1.423 1.423z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold">Assistant IA</h3>
                    <p class="text-sm text-navy-200">Réponses automatiques à vos voyageurs</p>
                </div>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-5">
                <div class="bg-white/10 backdrop-blur-sm rounded-xl border border-white/10 p-4">
                    <p class="text-2xl font-bold">{{ $stats['ai_messages_count'] }}</p>
                    <p class="text-xs text-navy-200 mt-1">Questions traitées</p>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-xl border border-white/10 p-4">
                    <p class="text-2xl font-bold">{{ $stats['urgent_messages'] }}</p>
                    <p class="text-xs text-navy-200 mt-1">Urgences</p>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-xl border border-white/10 p-4">
                    <p class="text-2xl font-bold">{{ $stats['ai_time_saved'] }}<span class="text-sm font-normal">min</span></p>
                    <p class="text-xs text-navy-200 mt-1">Temps gagné</p>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-xl border border-white/10 p-4">
                    <p class="text-2xl font-bold">{{ round(($stats['ai_messages_count'] / max($stats['total_reservations'], 1)) * 100) }}%</p>
                    <p class="text-xs text-navy-200 mt-1">Taux d'automatisation</p>
                </div>
            </div>
            @if(Route::has('ai-analysis.index'))
            <a href="{{ route('ai-analysis.index') }}"
               class="inline-flex items-center gap-2 px-5 py-2.5 bg-white text-navy-700 font-semibold rounded-xl hover:bg-navy-50 transition-all duration-200 text-sm shadow-lg">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                </svg>
                Voir les analyses
            </a>
            @endif
        </div>

    </div>
</x-app-layout>
