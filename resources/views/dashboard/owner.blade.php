<x-app-layout>
    <div class="space-y-8">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-surface-900 tracking-tight">Bonjour {{ auth()->user()->first_name }} 👋</h1>
                <p class="text-surface-500 mt-1">Bienvenue sur votre espace propriétaire.</p>
            </div>
            <a href="{{ route('properties.create') }}" class="btn-premium-primary px-6 py-3 self-start">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                </svg>
                Nouveau logement
            </a>
        </div>

        {{-- Stats Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            {{-- Logements --}}
            <div class="bg-white rounded-2xl border border-surface-200 p-6 hover:shadow-elevated transition-all duration-300 group">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-blue-50 flex items-center justify-center text-blue-600 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-surface-500">Logements</p>
                        <div class="flex items-baseline gap-2">
                            <p class="text-3xl font-bold text-surface-900">{{ $stats['total_properties'] }}</p>
                            <span class="text-xs font-medium text-emerald-600 bg-emerald-50 px-1.5 py-0.5 rounded-full">{{ $stats['property_change'] }}%</span>
                        </div>
                    </div>
                </div>
                <div class="mt-4 flex gap-4">
                    <div class="flex-1 h-1.5 bg-surface-100 rounded-full overflow-hidden">
                        <div class="h-full bg-blue-500 rounded-full" style="width: {{ $stats['total_properties'] > 0 ? ($stats['available_properties'] / max($stats['total_properties'], 1)) * 100 : 0 }}%"></div>
                    </div>
                    <span class="text-xs text-surface-400">{{ $stats['available_properties'] }} disponibles</span>
                </div>
            </div>

            {{-- Réservations --}}
            <div class="bg-white rounded-2xl border border-surface-200 p-6 hover:shadow-elevated transition-all duration-300 group">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-50 flex items-center justify-center text-emerald-600 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-surface-500">Réservations</p>
                        <div class="flex items-baseline gap-2">
                            <p class="text-3xl font-bold text-surface-900">{{ $stats['total_reservations'] }}</p>
                            <span class="text-xs font-medium text-emerald-600 bg-emerald-50 px-1.5 py-0.5 rounded-full">{{ $stats['reservation_change'] }}%</span>
                        </div>
                    </div>
                </div>
                <div class="mt-4 flex gap-4">
                    <div class="flex-1 h-1.5 bg-surface-100 rounded-full overflow-hidden">
                        <div class="h-full bg-emerald-500 rounded-full" style="width: {{ $stats['total_reservations'] > 0 ? ($stats['pending_reservations'] / max($stats['total_reservations'], 1)) * 100 : 0 }}%"></div>
                    </div>
                    <span class="text-xs text-surface-400">{{ $stats['pending_reservations'] }} en attente</span>
                </div>
            </div>

            {{-- Revenus --}}
            <div class="bg-white rounded-2xl border border-surface-200 p-6 hover:shadow-elevated transition-all duration-300 group">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-amber-50 flex items-center justify-center text-amber-600 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-surface-500">Revenus</p>
                        <div class="flex items-baseline gap-2">
                            <p class="text-3xl font-bold text-surface-900">{{ number_format($stats['total_revenue'], 0, ',', ' ') }} MAD</p>
                            <span class="text-xs font-medium text-emerald-600 bg-emerald-50 px-1.5 py-0.5 rounded-full">{{ $stats['revenue_change'] }}%</span>
                        </div>
                    </div>
                </div>
                <div class="mt-4 flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.941"/>
                    </svg>
                    <span class="text-xs text-surface-500">+{{ $stats['revenue_change'] }}% ce mois</span>
                </div>
            </div>

            {{-- Messages IA --}}
            <div class="bg-white rounded-2xl border border-surface-200 p-6 hover:shadow-elevated transition-all duration-300 group">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-purple-50 flex items-center justify-center text-purple-600 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.455 2.456L21.75 6l-1.036.259a3.375 3.375 0 00-2.455 2.456zM16.894 20.567L16.5 21.75l-.394-1.183a2.25 2.25 0 00-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 001.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 001.423 1.423l1.183.394-1.183.394a2.25 2.25 0 00-1.423 1.423z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-surface-500">Messages IA</p>
                        <div class="flex items-baseline gap-2">
                            <p class="text-3xl font-bold text-surface-900">{{ $stats['ai_messages_count'] }}</p>
                            <span class="text-xs font-medium text-emerald-600 bg-emerald-50 px-1.5 py-0.5 rounded-full">+{{ $stats['ai_change'] }}%</span>
                        </div>
                    </div>
                </div>
                <div class="mt-4 flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="text-xs text-surface-500">~{{ $stats['ai_time_saved'] }} min économisées</span>
                </div>
            </div>
        </div>

        {{-- Charts Row --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
            {{-- Bookings Chart --}}
            <div class="bg-white rounded-2xl border border-surface-200 p-6 hover:shadow-elevated transition-all duration-300">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-surface-900">Réservations</h3>
                    <span class="text-xs text-surface-400">{{ now()->year }}</span>
                </div>
                <div class="flex items-end gap-2 h-36">
                    @for ($m = 1; $m <= 12; $m++)
                        @php
                            $count = $monthlyBookings[$m] ?? 0;
                            $max = max(array_values($monthlyBookings ?: [1]));
                            $height = $max > 0 ? ($count / $max) * 100 : 0;
                            $months = ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Aoû', 'Sep', 'Oct', 'Nov', 'Déc'];
                        @endphp
                        <div class="flex-1 flex flex-col items-center gap-1.5 group cursor-pointer">
                            <span class="text-[10px] font-medium text-surface-400 opacity-0 group-hover:opacity-100 transition-opacity">{{ $count }}</span>
                            <div class="w-full rounded-full bg-surface-100 overflow-hidden" style="height: 70px;">
                                <div class="w-full rounded-full bg-gradient-to-t from-blue-500 to-blue-400 transition-all duration-300 group-hover:from-blue-600 group-hover:to-blue-500"
                                     style="height: {{ $height }}%; margin-top: auto;"></div>
                            </div>
                            <span class="text-[10px] text-surface-400">{{ $months[$m - 1] }}</span>
                        </div>
                    @endfor
                </div>
            </div>

            {{-- Revenue Chart --}}
            <div class="bg-white rounded-2xl border border-surface-200 p-6 hover:shadow-elevated transition-all duration-300">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-surface-900">Revenus</h3>
                    <span class="text-xs text-surface-400">{{ now()->year }}</span>
                </div>
                <div class="flex items-end gap-2 h-36">
                    @for ($m = 1; $m <= 12; $m++)
                        @php
                            $revenue = $monthlyRevenue[$m] ?? 0;
                            $maxRev = max(array_values($monthlyRevenue ?: [1]));
                            $height = $maxRev > 0 ? ($revenue / $maxRev) * 100 : 0;
                            $months = ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Aoû', 'Sep', 'Oct', 'Nov', 'Déc'];
                        @endphp
                        <div class="flex-1 flex flex-col items-center gap-1.5 group cursor-pointer">
                            <span class="text-[10px] font-medium text-surface-400 opacity-0 group-hover:opacity-100 transition-opacity">{{ number_format($revenue, 0, ',', ' ') }} MAD</span>
                            <div class="w-full rounded-full bg-surface-100 overflow-hidden" style="height: 70px;">
                                <div class="w-full rounded-full bg-gradient-to-t from-emerald-500 to-emerald-400 transition-all duration-300 group-hover:from-emerald-600 group-hover:to-emerald-500"
                                     style="height: {{ $height }}%; margin-top: auto;"></div>
                            </div>
                            <span class="text-[10px] text-surface-400">{{ $months[$m - 1] }}</span>
                        </div>
                    @endfor
                </div>
            </div>
        </div>

        {{-- Recent Reservations Table --}}
        <div class="bg-white rounded-2xl border border-surface-200 hover:shadow-elevated transition-all duration-300">
            <div class="flex items-center justify-between px-6 py-5 border-b border-surface-100">
                <h3 class="text-lg font-semibold text-surface-900">Dernières réservations</h3>
                <a href="{{ route('reservations.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-700 transition-colors">Voir tout</a>
            </div>
            <div class="overflow-x-auto">
                <table class="table-premium w-full">
                    <thead>
                        <tr>
                            <th class="px-6 py-3.5 text-left">Voyageur</th>
                            <th class="px-6 py-3.5 text-left">Logement</th>
                            <th class="px-6 py-3.5 text-left hidden md:table-cell">Date</th>
                            <th class="px-6 py-3.5 text-left">Montant</th>
                            <th class="px-6 py-3.5 text-left">Statut</th>
                            <th class="px-6 py-3.5 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($recentReservations as $reservation)
                            <tr class="hover:bg-surface-50/50 transition-colors duration-150">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 text-white flex items-center justify-center text-[10px] font-bold">
                                            {{ strtoupper(substr($reservation->guest?->first_name ?? '?', 0, 1)) }}{{ strtoupper(substr($reservation->guest?->last_name ?? '?', 0, 1)) }}
                                        </div>
                                        <span class="font-medium text-surface-900 text-sm">{{ $reservation->guest?->fullName() ?? 'N/A' }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-surface-700">{{ $reservation->property?->title ?? 'N/A' }}</td>
                                <td class="px-6 py-4 text-sm text-surface-500 hidden md:table-cell">{{ $reservation->created_at->format('d M Y') }}</td>
                                <td class="px-6 py-4 text-sm font-semibold text-surface-900">{{ number_format($reservation->total_price, 0, ',', ' ') }} MAD</td>
                                <td class="px-6 py-4">
                                    @php
                                        $statusVariant = match($reservation->status) {
                                            'confirmed' => 'success',
                                            'pending' => 'warning',
                                            'cancelled' => 'danger',
                                            default => 'gray',
                                        };
                                    @endphp
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-medium border
                                        {{ $statusVariant === 'success' ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : '' }}
                                        {{ $statusVariant === 'warning' ? 'bg-amber-50 text-amber-700 border-amber-200' : '' }}
                                        {{ $statusVariant === 'danger' ? 'bg-red-50 text-red-700 border-red-200' : '' }}
                                        {{ $statusVariant === 'gray' ? 'bg-surface-100 text-surface-600 border-surface-200' : '' }}">
                                        @if($reservation->status === 'confirmed') Confirmée
                                        @elseif($reservation->status === 'pending') En attente
                                        @elseif($reservation->status === 'cancelled') Annulée
                                        @else {{ $reservation->status }}
                                        @endif
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('reservations.show', $reservation) }}" class="inline-flex items-center gap-1 text-sm font-medium text-blue-600 hover:text-blue-700 transition-colors">
                                        Voir
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-sm text-surface-500">
                                    <div class="flex flex-col items-center gap-2">
                                        <svg class="w-10 h-10 text-surface-300" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/>
                                        </svg>
                                        <span>Aucune réservation pour le moment.</span>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Bottom Row: AI Card + Notifications --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
            {{-- AI Assistant Card --}}
            <div class="lg:col-span-2 bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 rounded-2xl p-6 text-white hover:shadow-elevated transition-all duration-300">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-white/10 backdrop-blur-sm border border-white/20 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.455 2.456L21.75 6l-1.036.259a3.375 3.375 0 00-2.455 2.456zM16.894 20.567L16.5 21.75l-.394-1.183a2.25 2.25 0 00-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 001.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 001.423 1.423l1.183.394-1.183.394a2.25 2.25 0 00-1.423 1.423z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold">Assistant IA</h3>
                            <p class="text-sm text-blue-200">Intelligence artificielle au service de vos locations</p>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-3 gap-4 mb-6">
                    <div class="bg-white/10 backdrop-blur-sm rounded-xl border border-white/10 p-4">
                        <p class="text-2xl font-bold">{{ $stats['ai_messages_count'] }}</p>
                        <p class="text-xs text-blue-200 mt-1">Questions traitées</p>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm rounded-xl border border-white/10 p-4">
                        <p class="text-2xl font-bold">{{ $stats['urgent_messages'] }}</p>
                        <p class="text-xs text-blue-200 mt-1">Urgences</p>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm rounded-xl border border-white/10 p-4">
                        <p class="text-2xl font-bold">~{{ $stats['ai_time_saved'] }}min</p>
                        <p class="text-xs text-blue-200 mt-1">Temps économisé</p>
                    </div>
                </div>
                <a href="{{ Route::has('ai-analysis.index') ? route('ai-analysis.index') : '#' }}"
                   class="inline-flex items-center gap-2 px-5 py-2.5 bg-white text-blue-700 font-semibold rounded-xl hover:bg-blue-50 transition-all duration-300 shadow-lg shadow-blue-900/20 text-sm">
                    Voir les analyses IA
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                    </svg>
                </a>
            </div>

            {{-- Notifications --}}
            <div class="bg-white rounded-2xl border border-surface-200 hover:shadow-elevated transition-all duration-300 p-6">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="text-lg font-semibold text-surface-900">Notifications</h3>
                    <span class="bg-blue-50 text-blue-600 text-xs font-semibold px-2 py-0.5 rounded-full">{{ $stats['unread_notifications'] }} non lues</span>
                </div>
                <div class="space-y-3">
                    @php
                        $notifications = auth()->user()->notifications()->latest()->take(4)->get();
                    @endphp
                    @forelse ($notifications as $notif)
                        <div class="flex items-start gap-3 p-3 rounded-xl {{ $notif->is_read ? '' : 'bg-blue-50/50' }} hover:bg-surface-50 transition-colors duration-150">
                            <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0
                                {{ $notif->is_read ? 'bg-surface-100 text-surface-400' : 'bg-blue-100 text-blue-600' }}">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-surface-900 truncate">{{ $notif->title ?? 'Notification' }}</p>
                                <p class="text-xs text-surface-500 truncate">{{ $notif->message ?? '' }}</p>
                                <p class="text-[10px] text-surface-400 mt-0.5">{{ $notif->created_at->diffForHumans() }}</p>
                            </div>
                            @if(!$notif->is_read)
                                <span class="w-2 h-2 rounded-full bg-blue-500 flex-shrink-0 mt-1.5"></span>
                            @endif
                        </div>
                    @empty
                        <div class="text-center py-8 text-surface-400">
                            <svg class="w-10 h-10 mx-auto mb-2 text-surface-300" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/>
                            </svg>
                            <p class="text-sm">Aucune notification</p>
                        </div>
                    @endforelse
                </div>
                @if($notifications->isNotEmpty())
                    <a href="{{ route('notifications.index') }}" class="mt-4 block text-center text-sm font-medium text-blue-600 hover:text-blue-700 transition-colors">Voir toutes les notifications</a>
                @endif
            </div>
        </div>

        {{-- My Properties Grid --}}
        <div>
            <div class="flex items-center justify-between mb-5">
                <h3 class="text-lg font-semibold text-surface-900">Mes logements</h3>
                <a href="{{ route('properties.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-700 transition-colors">Voir tout</a>
            </div>
            @if ($recentProperties->isEmpty())
                <div class="bg-white rounded-2xl border border-surface-200 p-12 text-center">
                    <div class="w-16 h-16 rounded-2xl bg-surface-100 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-surface-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/>
                        </svg>
                    </div>
                    <p class="text-surface-500 mb-4">Aucun logement pour l'instant.</p>
                    <a href="{{ route('properties.create') }}" class="btn-premium-primary px-6 py-2.5">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                        </svg>
                        Ajouter un logement
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                    @foreach ($recentProperties as $property)
                        <div class="bg-white rounded-2xl border border-surface-200 overflow-hidden hover:shadow-elevated transition-all duration-300 group">
                            <div class="h-40 bg-gradient-to-br from-blue-100 to-blue-50 flex items-center justify-center relative">
                                @if($property->images->isNotEmpty())
                                    <img src="{{ Storage::url($property->images->first()->path) }}" alt="{{ $property->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <svg class="w-12 h-12 text-blue-300" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.41a2.25 2.25 0 013.182 0l2.909 2.91m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/>
                                    </svg>
                                @endif
                                <span class="absolute top-3 right-3 inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-medium border
                                    {{ $property->status === 'available' ? 'bg-emerald-50/90 text-emerald-700 border-emerald-200/90' : 'bg-surface-100/90 text-surface-600 border-surface-200/90' }}">
                                    {{ $property->status === 'available' ? 'Disponible' : 'Occupé' }}
                                </span>
                            </div>
                            <div class="p-5">
                                <h4 class="font-semibold text-surface-900 group-hover:text-blue-600 transition-colors">{{ $property->title }}</h4>
                                <div class="flex items-center gap-1 mt-1 text-sm text-surface-500">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/>
                                    </svg>
                                    {{ $property->city }}
                                </div>
                                <div class="flex items-center justify-between mt-4 pt-4 border-t border-surface-100">
                                    <p class="text-lg font-bold text-surface-900">{{ number_format($property->price_per_night, 0, ',', ' ') }} <span class="text-xs font-normal text-surface-500">MAD/nuit</span></p>
                                    <div class="flex gap-2">
                                        <a href="{{ route('properties.edit', $property) }}" class="w-8 h-8 rounded-lg flex items-center justify-center text-surface-400 hover:bg-surface-100 hover:text-surface-600 transition-all duration-200">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/>
                                            </svg>
                                        </a>
                                        <a href="{{ route('properties.show', $property) }}" class="w-8 h-8 rounded-lg flex items-center justify-center text-surface-400 hover:bg-surface-100 hover:text-surface-600 transition-all duration-200">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

    </div>
</x-app-layout>
