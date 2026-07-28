<section id="how-it-works" class="relative py-24 sm:py-32 overflow-hidden bg-white">
    <div class="absolute top-1/2 left-0 right-0 h-px bg-gradient-to-r from-transparent via-surface-200 to-transparent"></div>

    <div class="max-w-7xl mx-auto px-6">
        <div data-aos="fade-up" class="text-center max-w-2xl mx-auto mb-16">
            <span class="text-xs font-semibold text-navy-700 uppercase tracking-widest">Processus</span>
            <h2 class="mt-4 text-3xl sm:text-4xl font-bold text-surface-900 tracking-tight">Comment ça marche</h2>
            <p class="mt-3 text-surface-500">En quelques étapes simples, votre location est opérationnelle.</p>
        </div>

        <div class="relative grid grid-cols-1 md:grid-cols-5 gap-8 md:gap-4">
            @php
                $steps = [
                    ['num' => '01', 'icon' => 'M8.25 21v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21m0 0h4.5V3.545M12.75 21h7.5V10.75M2.25 21h1.5m18 0h-18M2.25 9l4.5-1.636M18.75 3l-1.5.545m0 6.205l3 1m1.5.5l-1.5-.5M6.75 7.364V3h-3v18m3-13.636l10.5-3.819', 'title' => 'Ajoutez votre bien', 'desc' => 'Créez facilement la fiche de votre logement avec photos, prix et description.'],
                    ['num' => '02', 'icon' => 'M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5', 'title' => 'Le voyageur réserve', 'desc' => 'Les voyageurs découvrent et réservent votre logement en toute simplicité.'],
                    ['num' => '03', 'icon' => 'M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z', 'title' => 'Le voyageur pose une question', 'desc' => 'Via la messagerie intégrée, le voyageur peut demander toute information.'],
                    ['num' => '04', 'icon' => 'M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.455 2.456L21.75 6l-1.036.259a3.375 3.375 0 00-2.455 2.456zM16.894 20.567L16.5 21.75l-.394-1.183a2.25 2.25 0 00-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 001.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 001.423 1.423l1.183.394-1.183.394a2.25 2.25 0 00-1.423 1.423z', 'title' => "L'IA répond automatiquement", 'desc' => "Notre assistant IA analyse et répond instantanément à toutes les questions."],
                    ['num' => '05', 'icon' => 'M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0', 'title' => 'Vous êtes notifié si nécessaire', 'desc' => "Vous recevez une notification uniquement pour les demandes urgentes ou complexes."]
                ];
            @endphp

            @foreach ($steps as $i => $step)
                <div data-aos="fade-up" data-aos-delay="{{ $i * 100 }}" class="relative flex flex-col items-center text-center">
                    {{-- Connecting line --}}
                    @if (!$loop->last)
                        <div class="hidden md:block absolute top-12 left-[60%] w-[80%] h-px border-t-2 border-dashed border-surface-200"></div>
                    @endif

                    <div class="w-24 h-24 rounded-2xl bg-navy-50 flex items-center justify-center mb-5 relative">
                        <span class="absolute -top-2 -right-2 w-7 h-7 rounded-full bg-navy-700 text-white text-xs font-bold flex items-center justify-center">{{ $step['num'] }}</span>
                        <svg class="w-10 h-10 text-navy-700" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $step['icon'] }}"/>
                        </svg>
                    </div>
                    <h3 class="text-base font-semibold text-surface-900 mb-2">{{ $step['title'] }}</h3>
                    <p class="text-sm text-surface-500 max-w-xs">{{ $step['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>