<section id="hero" class="relative min-h-screen flex items-center justify-center overflow-hidden">
    {{-- Background Image with Overlay --}}
    <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?q=80&w=2075&auto=format&fit=crop')] bg-cover bg-center bg-no-repeat"></div>
    <div class="absolute inset-0 bg-gradient-to-b from-surface-900/70 via-surface-900/60 to-surface-900/80"></div>

    {{-- Subtle pattern overlay --}}
    <div class="absolute inset-0 opacity-[0.03]" style="background-image: url(\"data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E\");"></div>

    <div class="relative z-10 max-w-5xl mx-auto px-6 text-center">
        <div data-aos="fade-up" data-aos-duration="800">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/10 backdrop-blur-sm border border-white/10 mb-8">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                <span class="text-xs font-medium text-white/80">Assistant IA disponible 24/7</span>
            </div>
        </div>

        <h1 data-aos="fade-up" data-aos-duration="800" data-aos-delay="100"
            class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-bold text-white leading-[1.1] tracking-tight text-balance">
            Gérez vos locations saisonnières<br>
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-200 to-white">intelligemment</span>
        </h1>

        <p data-aos="fade-up" data-aos-duration="800" data-aos-delay="200"
           class="mt-6 text-base sm:text-lg text-white/70 max-w-2xl mx-auto leading-relaxed">
            DarGuest simplifie la communication entre propriétaires et voyageurs grâce à une intelligence artificielle capable de répondre automatiquement aux questions des voyageurs.
        </p>

        <div data-aos="fade-up" data-aos-duration="800" data-aos-delay="300"
             class="mt-10 flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="#features"
               class="inline-flex items-center gap-2 px-8 py-3.5 bg-white text-surface-900 font-semibold rounded-2xl hover:bg-white/90 transition-all duration-300 shadow-xl hover:shadow-2xl hover:-translate-y-0.5">
                Découvrir
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
            </a>
            @if (Route::has('register'))
                <a href="{{ route('register') }}"
                   class="inline-flex items-center gap-2 px-8 py-3.5 border border-white/20 text-white font-semibold rounded-2xl backdrop-blur-sm hover:bg-white/10 transition-all duration-300 hover:-translate-y-0.5">
                    Commencer gratuitement
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                </a>
            @endif
        </div>
    </div>

    {{-- Scroll indicator --}}
    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 animate-bounce">
        <svg class="w-6 h-6 text-white/40" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
        </svg>
    </div>
</section>