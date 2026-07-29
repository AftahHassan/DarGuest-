<x-app-layout>
    <div class="space-y-8">

        {{-- Header --}}
        <div class="flex items-start justify-between gap-4">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <a href="{{ route('properties.index') }}" class="text-xs font-semibold text-navy-700 uppercase tracking-widest hover:text-navy-900 transition-colors flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
                        Logements
                    </a>
                </div>
                <h1 class="text-2xl sm:text-3xl font-bold text-surface-900 tracking-tight">Nouveau logement</h1>
                <p class="text-surface-500 mt-1">Créez un nouveau logement pour vos voyageurs.</p>
            </div>
        </div>

        @if (session('status'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2" class="alert-success flex items-center justify-between" role="alert">
                <span>{{ session('status') }}</span>
                <button type="button" x-on:click="show = false" class="ml-4 text-emerald-700 hover:text-emerald-900">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        @endif

        <form method="POST" action="{{ route('properties.store') }}" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                {{-- Left: General info --}}
                <div class="bg-white/60 backdrop-blur-sm border border-surface-200/60 rounded-2xl p-6 sm:p-8 space-y-5" data-aos="fade-up">
                    <div>
                        <h2 class="text-lg font-semibold text-surface-900">Informations générales</h2>
                        <p class="text-sm text-surface-500 mt-0.5">Les détails essentiels de votre logement.</p>
                    </div>

                    <div>
                        <label for="title" class="block text-sm font-medium text-surface-700 mb-1.5">
                            <span class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-surface-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 9.776c.112-.017.227-.026.344-.026h15.812c.117 0 .232.009.344.026m-16.5 0a2.25 2.25 0 00-1.883 2.542l.857 6a2.25 2.25 0 002.227 1.932H19.05a2.25 2.25 0 002.227-1.932l.857-6a2.25 2.25 0 00-1.883-2.542m-16.5 0V6A2.25 2.25 0 016 3.75h3.879a1.5 1.5 0 011.06.44l2.122 2.12a1.5 1.5 0 001.06.44H18A2.25 2.25 0 0120.25 9v.776"/></svg>
                                Titre du logement
                            </span>
                        </label>
                        <input id="title" name="title" value="{{ old('title') }}" placeholder="Ex : Appartement vue mer" required
                               class="w-full bg-white border border-surface-200 text-surface-800 rounded-xl text-sm transition-all duration-200 px-4 py-2.5 focus:border-navy-500 focus:ring-2 focus:ring-navy-500/20 focus:outline-none placeholder:text-surface-400">
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-surface-700 mb-1.5">
                            <span class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-surface-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z"/></svg>
                                Description
                            </span>
                        </label>
                        <textarea id="description" name="description" rows="4" placeholder="Décrivez votre logement en quelques lignes…"
                                  class="w-full bg-white border border-surface-200 text-surface-800 rounded-xl text-sm transition-all duration-200 px-4 py-2.5 focus:border-navy-500 focus:ring-2 focus:ring-navy-500/20 focus:outline-none placeholder:text-surface-400 resize-y min-h-[100px]">{{ old('description') }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="city" class="block text-sm font-medium text-surface-700 mb-1.5">
                                <span class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-surface-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>
                                    Ville
                                </span>
                            </label>
                            <input id="city" name="city" value="{{ old('city') }}" placeholder="Ex : Taghazout" required
                                   class="w-full bg-white border border-surface-200 text-surface-800 rounded-xl text-sm transition-all duration-200 px-4 py-2.5 focus:border-navy-500 focus:ring-2 focus:ring-navy-500/20 focus:outline-none placeholder:text-surface-400">
                            <x-input-error :messages="$errors->get('city')" class="mt-2" />
                        </div>
                        <div>
                            <label for="address" class="block text-sm font-medium text-surface-700 mb-1.5">
                                <span class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-surface-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 6.75V15m6-6v8.25m.503 3.498l4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.252a1.125 1.125 0 00-1.006 0L3.622 5.689C3.24 5.88 3 6.27 3 6.695V19.18c0 .836.88 1.38 1.628 1.006l3.869-1.934c.317-.159.69-.159 1.006 0l4.994 2.497c.317.158.69.158 1.006 0z"/></svg>
                                    Adresse
                                </span>
                            </label>
                            <input id="address" name="address" value="{{ old('address') }}" placeholder="Ex : Rue des Dunes" required
                                   class="w-full bg-white border border-surface-200 text-surface-800 rounded-xl text-sm transition-all duration-200 px-4 py-2.5 focus:border-navy-500 focus:ring-2 focus:ring-navy-500/20 focus:outline-none placeholder:text-surface-400">
                            <x-input-error :messages="$errors->get('address')" class="mt-2" />
                        </div>
                    </div>
                </div>

                {{-- Right: Property details --}}
                <div class="bg-white/60 backdrop-blur-sm border border-surface-200/60 rounded-2xl p-6 sm:p-8 space-y-5" data-aos="fade-up" data-aos-delay="100">
                    <div>
                        <h2 class="text-lg font-semibold text-surface-900">Informations logement</h2>
                        <p class="text-sm text-surface-500 mt-0.5">Capacité, tarifs et disponibilité.</p>
                    </div>

                    <div>
                        <label for="price_per_night" class="block text-sm font-medium text-surface-700 mb-1.5">
                            <span class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-surface-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Prix par nuit (MAD)
                            </span>
                        </label>
                        <input id="price_per_night" name="price_per_night" type="number" step="0.01" min="0" value="{{ old('price_per_night') }}" placeholder="Ex : 850"
                               class="w-full bg-white border border-surface-200 text-surface-800 rounded-xl text-sm transition-all duration-200 px-4 py-2.5 focus:border-navy-500 focus:ring-2 focus:ring-navy-500/20 focus:outline-none placeholder:text-surface-400">
                        <x-input-error :messages="$errors->get('price_per_night')" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <label for="capacity" class="block text-sm font-medium text-surface-700 mb-1.5">
                                <span class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-surface-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"/></svg>
                                    Capacité
                                </span>
                            </label>
                            <input id="capacity" name="capacity" type="number" min="1" value="{{ old('capacity') }}" placeholder="4"
                                   class="w-full bg-white border border-surface-200 text-surface-800 rounded-xl text-sm transition-all duration-200 px-4 py-2.5 focus:border-navy-500 focus:ring-2 focus:ring-navy-500/20 focus:outline-none placeholder:text-surface-400">
                        </div>
                        <div>
                            <label for="bedrooms" class="block text-sm font-medium text-surface-700 mb-1.5">
                                <span class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-surface-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 20.25h12m-7.5-3v3m3-3v3m-10-3a3 3 0 01-3-3V6a3 3 0 013-3h12a3 3 0 013 3v8.25a3 3 0 01-3 3m-15 0h15"/></svg>
                                    Chambres
                                </span>
                            </label>
                            <input id="bedrooms" name="bedrooms" type="number" min="0" value="{{ old('bedrooms') }}" placeholder="2"
                                   class="w-full bg-white border border-surface-200 text-surface-800 rounded-xl text-sm transition-all duration-200 px-4 py-2.5 focus:border-navy-500 focus:ring-2 focus:ring-navy-500/20 focus:outline-none placeholder:text-surface-400">
                        </div>
                        <div>
                            <label for="bathrooms" class="block text-sm font-medium text-surface-700 mb-1.5">
                                <span class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-surface-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 2.994v3.264m12-3.264v3.264M6.75 6h4.5m-4.5 0H4.5m2.25 0v5.25M6.75 6h9m-9 0H3.75m12 0h2.25m-2.25 0v5.25M12 6V3.75m0 0H9.75M12 3.75h2.25M18.75 6v5.25M6.75 15h.008v.008H6.75V15zm3 0h.008v.008H9.75V15zm3 0h.008v.008H12.75V15zm3 0h.008v.008H15.75V15zm3 0h.008v.008H18.75V15z"/></svg>
                                    S. de bain
                                </span>
                            </label>
                            <input id="bathrooms" name="bathrooms" type="number" min="0" value="{{ old('bathrooms') }}" placeholder="1"
                                   class="w-full bg-white border border-surface-200 text-surface-800 rounded-xl text-sm transition-all duration-200 px-4 py-2.5 focus:border-navy-500 focus:ring-2 focus:ring-navy-500/20 focus:outline-none placeholder:text-surface-400">
                        </div>
                    </div>

                    <div>
                        <label for="status" class="block text-sm font-medium text-surface-700 mb-1.5">
                            <span class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-surface-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Statut
                            </span>
                        </label>
                        <select id="status" name="status"
                                class="w-full bg-white border border-surface-200 text-surface-800 rounded-xl text-sm transition-all duration-200 px-4 py-2.5 focus:border-navy-500 focus:ring-2 focus:ring-navy-500/20 focus:outline-none">
                            <option value="available" @selected(old('status', 'available') === 'available')>Disponible</option>
                            <option value="unavailable" @selected(old('status') === 'unavailable')>Indisponible</option>
                            <option value="maintenance" @selected(old('status') === 'maintenance')>Maintenance</option>
                        </select>
                    </div>
                </div>

            </div>

            {{-- Actions --}}
            <div class="flex items-center gap-3" data-aos="fade-up">
                <button type="submit" x-on:click="$el.classList.add('opacity-70', 'pointer-events-none'); $el.querySelector('.spinner')?.classList.remove('hidden'); $el.querySelector('.btn-text')?.classList.add('hidden')" class="btn-primary">
                    <svg x-cloak class="spinner hidden w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"/></svg>
                    <span class="btn-text flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                        Créer le logement
                    </span>
                </button>
                <a href="{{ route('properties.index') }}" class="btn-secondary">Annuler</a>
            </div>
        </form>

    </div>
</x-app-layout>