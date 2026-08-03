<section class="relative py-24 sm:py-32 overflow-hidden bg-white">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center max-w-2xl mx-auto mb-16">
            <span class="text-xs font-semibold text-navy-700 uppercase tracking-widest">Témoignages</span>
            <h2 class="mt-4 text-3xl sm:text-4xl font-bold text-surface-900 tracking-tight">Ils nous font confiance</h2>
            <p class="mt-3 text-surface-500">Découvrez ce que nos utilisateurs disent de DarGuest.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @php
                $testimonials = [
                    ['name' => 'Sophie Martin', 'city' => 'Marrakech', 'avatar' => 'SM', 'rating' => 5, 'text' => 'DarGuest a transformé ma façon de gérer mes locations. L\'IA répond aux voyageurs pendant que je dors, c\'est incroyable !'],
                    ['name' => 'Karim Benali', 'city' => 'Agadir', 'avatar' => 'KB', 'rating' => 5, 'text' => 'Je recommande à tous les propriétaires. La détection des urgences est très fiable et la communication est fluide.'],
                    ['name' => 'Julie Dubois', 'city' => 'Taghazout', 'avatar' => 'JD', 'rating' => 5, 'text' => 'Depuis que j\'utilise DarGuest, je n\'ai plus à répondre aux mêmes questions 100 fois. L\'IA s\'occupe de tout !']
                ];
            @endphp

            @foreach ($testimonials as $i => $t)
                <div
                     class="bg-surface-50 border border-surface-200 rounded-2xl p-6 sm:p-8 hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                    <div class="flex items-center gap-1 mb-4">
                        @for ($s = 0; $s < 5; $s++)
                            <svg class="w-4 h-4 {{ $s < $t['rating'] ? 'text-amber-400' : 'text-surface-200' }}" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z"/>
                            </svg>
                        @endfor
                    </div>
                    <p class="text-sm text-surface-600 leading-relaxed mb-6">"{{ $t['text'] }}"</p>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-navy-700 text-white flex items-center justify-center text-xs font-semibold">{{ $t['avatar'] }}</div>
                        <div>
                            <p class="text-sm font-semibold text-surface-900">{{ $t['name'] }}</p>
                            <p class="text-xs text-surface-500">{{ $t['city'] }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>