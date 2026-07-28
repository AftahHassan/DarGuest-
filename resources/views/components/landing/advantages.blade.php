<section id="advantages" class="relative py-24 sm:py-32 overflow-hidden bg-surface-50">
    <div class="max-w-7xl mx-auto px-6">
        <div data-aos="fade-up" class="text-center max-w-2xl mx-auto mb-16">
            <span class="text-xs font-semibold text-navy-700 uppercase tracking-widest">Avantages</span>
            <h2 class="mt-4 text-3xl sm:text-4xl font-bold text-surface-900 tracking-tight">Pourquoi choisir DarGuest ?</h2>
            <p class="mt-3 text-surface-500">Des bénéfices concrets pour les propriétaires et les voyageurs.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @php
                $advantages = [
                    ['icon' => 'M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z', 'title' => 'Réduction du temps de réponse', 'desc' => 'Répondez instantanément à vos voyageurs grâce à notre IA, même en pleine nuit.'],
                    ['icon' => 'M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 21h16.5A2.25 2.25 0 0022.5 18.75V10.5A2.25 2.25 0 0020.25 8.25H3.75A2.25 2.25 0 001.5 10.5v8.25A2.25 2.25 0 003.75 21z', 'title' => 'Plus de réservations', 'desc' => 'Un service réactif augmente la satisfaction et encourage les réservations répétées.'],
                    ['icon' => 'M15.182 15.182a4.5 4.5 0 01-6.364 0M21 12a9 9 0 11-18 0 9 9 0 0118 0zM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75zm-.375 0h.008v.015h-.008V9.75zm5.625 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75zm-.375 0h.008v.015h-.008V9.75z', 'title' => 'Voyageurs satisfaits', 'desc' => 'Des réponses rapides et précises pour une expérience voyageur exceptionnelle.'],
                    ['icon' => 'M10.5 21l5.25-11.25L21 21m-9-3h7.5M3 5.621a48.474 48.474 0 016-.371m0 0c1.12 0 2.233.038 3.334.114M9 5.25V3m3.334 2.364C11.176 10.658 7.69 15.08 3 17.502m9.334-12.138c.896.061 1.78.147 2.653.255', 'title' => 'Support multilingue', 'desc' => "L'IA détecte et répond dans la langue de vos voyageurs, en français, anglais, arabe et plus."],
                    ['icon' => 'M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0', 'title' => 'Notifications intelligentes', 'desc' => "Soyez alerté uniquement pour ce qui nécessite vraiment votre attention."],
                    ['icon' => 'M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'title' => 'Gain de temps', 'desc' => "Automatisez les réponses aux questions fréquentes et concentrez-vous sur l'essentiel."]
                ];
            @endphp

            @foreach ($advantages as $i => $adv)
                <div data-aos="fade-up" data-aos-delay="{{ $i * 50 }}"
                     class="group flex items-start gap-4 p-5 rounded-2xl bg-white border border-surface-200 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300">
                    <div class="w-11 h-11 rounded-xl bg-navy-50 flex items-center justify-center flex-shrink-0 group-hover:bg-navy-100 transition-colors">
                        <svg class="w-5 h-5 text-navy-700" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $adv['icon'] }}"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-surface-900 mb-1">{{ $adv['title'] }}</h3>
                        <p class="text-xs text-surface-500 leading-relaxed">{{ $adv['desc'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>