<section class="relative py-24 sm:py-32 overflow-hidden bg-navy-700">
    <div class="absolute inset-0 bg-gradient-to-br from-navy-700 via-navy-800 to-navy-900"></div>
    <div class="absolute top-20 right-20 w-72 h-72 bg-navy-500/20 rounded-full blur-3xl"></div>
    <div class="absolute bottom-20 left-20 w-96 h-96 bg-navy-400/10 rounded-full blur-3xl"></div>

    <div class="relative max-w-7xl mx-auto px-6">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20 items-center">
            <div>
                <span class="text-xs font-semibold text-navy-200 uppercase tracking-widest">Intelligence Artificielle</span>
                <h2 class="mt-4 text-3xl sm:text-4xl lg:text-5xl font-bold text-white tracking-tight leading-tight">
                    Une IA qui travaille<br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-200 to-white">pour vous 24h/24</span>
                </h2>
                <p class="mt-4 text-base text-navy-200 leading-relaxed max-w-lg">
                    Notre intelligence artificielle analyse chaque message reçu et y répond instantanément, permettant aux propriétaires de se concentrer sur l'essentiel.
                </p>

                <div class="mt-8 space-y-4">
                    @php
                        $capabilities = [
                            ['icon' => 'M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z', 'label' => 'Analyse automatique des messages'],
                            ['icon' => 'M10.5 21l5.25-11.25L21 21m-9-3h7.5M3 5.621a48.474 48.474 0 016-.371m0 0c1.12 0 2.233.038 3.334.114M9 5.25V3m3.334 2.364C11.176 10.658 7.69 15.08 3 17.502m9.334-12.138c.896.061 1.78.147 2.653.255', 'label' => 'Détection de la langue'],
                            ['icon' => 'M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z', 'label' => 'Classification intelligente'],
                            ['icon' => 'M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z', 'label' => 'Détection des urgences'],
                            ['icon' => 'M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z', 'label' => 'Réponse intelligente contextuelle'],
                            ['icon' => 'M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0', 'label' => 'Escalade vers le propriétaire']
                        ];
                    @endphp
                    @foreach ($capabilities as $cap)
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-navy-500/30 flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-navy-200" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="{{ $cap['icon'] }}"/>
                                </svg>
                            </div>
                            <span class="text-sm text-navy-100">{{ $cap['label'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="relative">
                <div class="glass rounded-3xl p-8 border-white/10">
                    {{-- Chat mockup --}}
                    <div class="space-y-4">
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-full bg-navy-500 flex items-center justify-center text-xs font-bold text-white flex-shrink-0">M</div>
                            <div class="bg-white/10 backdrop-blur-sm rounded-2xl rounded-tl-md px-4 py-3 max-w-[80%]">
                                <p class="text-sm text-white/90">Bonjour, quel est le code de la wifi ?</p>
                                <span class="text-[10px] text-white/40 mt-1 block">Marco, voyageur</span>
                            </div>
                        </div>

                        <div class="flex items-start gap-3 justify-end">
                            <div class="bg-navy-500/30 backdrop-blur-sm rounded-2xl rounded-tr-md px-4 py-3 max-w-[80%]">
                                <div class="flex items-center gap-2 mb-1">
                                    <svg class="w-3.5 h-3.5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z"/></svg>
                                    <span class="text-[10px] font-medium text-emerald-300/80">Assistant IA</span>
                                </div>
                                <p class="text-sm text-white/90">Le code WiFi est "VillaSoleil2024". Bon séjour ! ☀️</p>
                                <span class="text-[10px] text-white/40 mt-1 block">Réponse instantanée • IA</span>
                            </div>
                            <div class="w-8 h-8 rounded-full bg-navy-700 border border-navy-500 flex items-center justify-center text-xs font-bold text-navy-200 flex-shrink-0">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z"/></svg>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-full bg-navy-500 flex items-center justify-center text-xs font-bold text-white flex-shrink-0">M</div>
                            <div class="bg-white/10 backdrop-blur-sm rounded-2xl rounded-tl-md px-4 py-3 max-w-[80%]">
                                <p class="text-sm text-white/90">Y a-t-il un parking ?</p>
                                <span class="text-[10px] text-white/40 mt-1 block">Marco, voyageur</span>
                            </div>
                        </div>

                        <div class="flex items-start gap-3 justify-end">
                            <div class="bg-navy-500/30 backdrop-blur-sm rounded-2xl rounded-tr-md px-4 py-3 max-w-[80%]">
                                <p class="text-sm text-white/90">Oui, un parking privé gratuit est disponible sur place. Vous pouvez garer jusqu'à 2 véhicules.</p>
                                <span class="text-[10px] text-white/40 mt-1 block">Réponse instantanée • IA</span>
                            </div>
                            <div class="w-8 h-8 rounded-full bg-navy-700 border border-navy-500 flex items-center justify-center text-xs font-bold text-navy-200 flex-shrink-0">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z"/></svg>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Decorative elements --}}
                <div class="absolute -bottom-4 -right-4 w-20 h-20 bg-navy-400/10 rounded-full blur-2xl"></div>
            </div>
        </div>
    </div>
</section>