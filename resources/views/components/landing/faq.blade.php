<section id="faq" class="relative py-24 sm:py-32 overflow-hidden bg-surface-50">
    <div class="max-w-3xl mx-auto px-6">
        <div data-aos="fade-up" class="text-center max-w-2xl mx-auto mb-16">
            <span class="text-xs font-semibold text-navy-700 uppercase tracking-widest">FAQ</span>
            <h2 class="mt-4 text-3xl sm:text-4xl font-bold text-surface-900 tracking-tight">Questions fréquentes</h2>
            <p class="mt-3 text-surface-500">Tout ce que vous devez savoir sur DarGuest.</p>
        </div>

        <div class="space-y-3">
            @php
                $faqs = [
                    ['q' => 'Comment fonctionne l\'assistant IA ?', 'a' => 'L\'assistant IA analyse chaque message reçu, détecte la langue, classe la demande et génère une réponse automatique basée sur les informations de votre logement. Il peut répondre aux questions sur le WiFi, le check-in, les équipements, et plus encore.'],
                    ['q' => 'Est-ce que DarGuest est gratuit ?', 'a' => 'Nous proposons un essai gratuit pour découvrir toutes les fonctionnalités. Ensuite, nos offres commencent à partir de 9,99€/mois pour les propriétaires avec jusqu\'à 3 logements.'],
                    ['q' => 'L\'IA peut-elle gérer les urgences ?', 'a' => 'Oui, l\'IA détecte les situations urgentes (fuite d\'eau, panne électrique, urgence médicale) et notifie immédiatement le propriétaire tout en envoyant une réponse appropriée au voyageur.'],
                    ['q' => 'Quelles langues sont supportées ?', 'a' => 'L\'IA supporte le français, l\'anglais, l\'arabe, l\'espagnol et l\'allemand. Elle détecte automatiquement la langue du voyageur et répond dans la même langue.'],
                    ['q' => 'Puis-je personnaliser les réponses de l\'IA ?', 'a' => 'Absolument ! Vous pouvez modifier les informations de votre logement (règlement intérieur, code WiFi, instructions d\'accès) qui servent de base aux réponses de l\'IA.'],
                    ['q' => 'Mes données sont-elles sécurisées ?', 'a' => 'Oui, nous utilisons un chiffrement de bout en bout et respectons le RGPD. Vos données ne sont jamais partagées avec des tiers sans votre consentement.']
                ];
            @endphp

            @foreach ($faqs as $i => $faq)
                <div data-aos="fade-up" data-aos-delay="{{ $i * 50 }}"
                     x-data="{ open: false }"
                     class="bg-white border border-surface-200 rounded-2xl overflow-hidden transition-all duration-300"
                     :class="open ? 'shadow-md' : 'hover:shadow-sm'">
                    <button x-on:click="open = !open"
                            class="w-full flex items-center justify-between px-6 py-5 text-left">
                        <span class="text-sm font-medium text-surface-900 pr-4">{{ $faq['q'] }}</span>
                        <svg class="w-5 h-5 text-surface-400 flex-shrink-0 transition-transform duration-300" :class="open ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
                        </svg>
                    </button>
                    <div x-show="open"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 -translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 -translate-y-2"
                         class="px-6 pb-5"
                         style="display: none;">
                        <p class="text-sm text-surface-600 leading-relaxed">{{ $faq['a'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>