<section id="features" class="relative py-24 sm:py-32 overflow-hidden">
    {{-- Subtle background --}}
    <div class="absolute inset-0 bg-gradient-to-b from-surface-50 to-white"></div>
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[800px] h-[800px] bg-navy-50/30 rounded-full blur-3xl -z-10"></div>

    <div class="relative max-w-7xl mx-auto px-6">
        <div data-aos="fade-up" class="text-center max-w-2xl mx-auto mb-16">
            <span class="text-xs font-semibold text-navy-700 uppercase tracking-widest">Fonctionnalités</span>
            <h2 class="mt-4 text-3xl sm:text-4xl font-bold text-surface-900 tracking-tight">Tout ce dont vous avez besoin</h2>
            <p class="mt-3 text-surface-500">Une plateforme complète pour gérer vos locations saisonnières sans effort.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @php
                $features = [
                    ['icon' => 'M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25', 'title' => 'Gestion des logements', 'desc' => 'Ajoutez, modifiez et gérez tous vos biens immobiliers depuis un tableau de bord centralisé.'],
                    ['icon' => 'M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5', 'title' => 'Gestion des réservations', 'desc' => 'Suivez vos réservations en temps réel avec un calendrier intelligent et des notifications automatiques.'],
                    ['icon' => 'M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z', 'title' => 'Messagerie intelligente', 'desc' => 'Communication fluide entre voyageurs et propriétaires avec historique complet et notifications.'],
                    ['icon' => 'M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.455 2.456L21.75 6l-1.036.259a3.375 3.375 0 00-2.455 2.456zM16.894 20.567L16.5 21.75l-.394-1.183a2.25 2.25 0 00-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 001.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 001.423 1.423l1.183.394-1.183.394a2.25 2.25 0 00-1.423 1.423z', 'title' => 'Assistant IA', 'desc' => 'Une intelligence artificielle répond automatiquement aux questions de vos voyageurs 24h/24.']
                ];
            @endphp

            @foreach ($features as $i => $feature)
                <div data-aos="fade-up" data-aos-delay="{{ $i * 100 }}"
                     class="group relative bg-white/60 backdrop-blur-sm border border-surface-200/60 rounded-2xl p-6 sm:p-8 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 hover:border-navy-200/50">
                    <div class="w-12 h-12 rounded-xl bg-navy-50 flex items-center justify-center mb-5 group-hover:bg-navy-100 transition-colors">
                        <svg class="w-6 h-6 text-navy-700" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $feature['icon'] }}"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-surface-900 mb-2">{{ $feature['title'] }}</h3>
                    <p class="text-sm text-surface-500 leading-relaxed">{{ $feature['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>