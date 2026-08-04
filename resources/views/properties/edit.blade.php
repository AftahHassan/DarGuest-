<x-app-layout>
    <div class="space-y-8">

        {{-- Header --}}
        <div class="flex items-start justify-between gap-4">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <a href="{{ route('properties.show', $property) }}" class="text-xs font-semibold text-navy-700 uppercase tracking-widest hover:text-navy-900 transition-colors flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
                        {{ $property->title }}
                    </a>
                </div>
                <h1 class="text-2xl sm:text-3xl font-bold text-surface-900 tracking-tight">Modifier le logement</h1>
                <p class="text-surface-500 mt-1">Modifiez les informations de votre logement.</p>
            </div>
        </div>

        {{-- Property summary card --}}
        <div class="panel p-5 flex flex-col sm:flex-row sm:items-center gap-4">
            <div class="w-16 h-16 rounded-xl bg-surface-100 overflow-hidden flex-shrink-0">
                @if($property->images->isNotEmpty())
                    <img src="{{ Storage::url($property->images->first()->image) }}" alt="" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-surface-300" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.41a2.25 2.25 0 013.182 0l2.909 2.91m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/></svg>
                    </div>
                @endif
            </div>
            <div class="flex-1 min-w-0">
                <h2 class="text-lg font-semibold text-surface-900 truncate">{{ $property->title }}</h2>
                <p class="text-sm text-surface-500 truncate">{{ $property->address }}, {{ $property->city }}</p>
            </div>
            <div class="flex items-center gap-3 flex-shrink-0">
                @php
                    $statusVariant = match($property->status) {
                        'available' => 'success',
                        'unavailable' => 'gray',
                        'maintenance' => 'warning',
                        default => 'gray',
                    };
                @endphp
                <x-ui.badge :variant="$statusVariant" dot>
                    @if($property->status === 'available') Disponible
                    @elseif($property->status === 'unavailable') Indisponible
                    @elseif($property->status === 'maintenance') Maintenance
                    @else {{ $property->status }}
                    @endif
                </x-ui.badge>
                <span class="text-xs text-surface-400">Créé le {{ $property->created_at->format('d/m/Y') }}</span>
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

        <form method="POST" action="{{ route('properties.update', $property) }}" class="space-y-6" x-data="{ saving: false }" x-on:submit="saving = true">
            @csrf @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                {{-- Left: General info --}}
                <div class="panel p-6 sm:p-8 space-y-5">
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
                        <input id="title" name="title" value="{{ old('title', $property->title) }}" required
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
                        <textarea id="description" name="description" rows="4"
                                  class="w-full bg-white border border-surface-200 text-surface-800 rounded-xl text-sm transition-all duration-200 px-4 py-2.5 focus:border-navy-500 focus:ring-2 focus:ring-navy-500/20 focus:outline-none placeholder:text-surface-400 resize-y min-h-[100px]">{{ old('description', $property->description) }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="city" class="block text-sm font-medium text-surface-700 mb-1.5">
                                <span class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-surface-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>
                                    Ville
                                </span>
                            </label>
                            <input id="city" name="city" value="{{ old('city', $property->city) }}" required
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
                            <input id="address" name="address" value="{{ old('address', $property->address) }}" required
                                   class="w-full bg-white border border-surface-200 text-surface-800 rounded-xl text-sm transition-all duration-200 px-4 py-2.5 focus:border-navy-500 focus:ring-2 focus:ring-navy-500/20 focus:outline-none placeholder:text-surface-400">
                        </div>
                    </div>
                </div>

                {{-- Right: Property details --}}
                <div class="panel p-6 sm:p-8 space-y-5">
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
                        <input id="price_per_night" name="price_per_night" type="number" step="0.01" min="0" value="{{ old('price_per_night', $property->price_per_night) }}"
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
                            <input id="capacity" name="capacity" type="number" min="1" value="{{ old('capacity', $property->capacity) }}"
                                   class="w-full bg-white border border-surface-200 text-surface-800 rounded-xl text-sm transition-all duration-200 px-4 py-2.5 focus:border-navy-500 focus:ring-2 focus:ring-navy-500/20 focus:outline-none placeholder:text-surface-400">
                        </div>
                        <div>
                            <label for="bedrooms" class="block text-sm font-medium text-surface-700 mb-1.5">
                                <span class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-surface-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 20.25h12m-7.5-3v3m3-3v3m-10-3a3 3 0 01-3-3V6a3 3 0 013-3h12a3 3 0 013 3v8.25a3 3 0 01-3 3m-15 0h15"/></svg>
                                    Chambres
                                </span>
                            </label>
                            <input id="bedrooms" name="bedrooms" type="number" min="0" value="{{ old('bedrooms', $property->bedrooms) }}"
                                   class="w-full bg-white border border-surface-200 text-surface-800 rounded-xl text-sm transition-all duration-200 px-4 py-2.5 focus:border-navy-500 focus:ring-2 focus:ring-navy-500/20 focus:outline-none placeholder:text-surface-400">
                        </div>
                        <div>
                            <label for="bathrooms" class="block text-sm font-medium text-surface-700 mb-1.5">
                                <span class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-surface-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 2.994v3.264m12-3.264v3.264M6.75 6h4.5m-4.5 0H4.5m2.25 0v5.25M6.75 6h9m-9 0H3.75m12 0h2.25m-2.25 0v5.25M12 6V3.75m0 0H9.75M12 3.75h2.25M18.75 6v5.25M6.75 15h.008v.008H6.75V15zm3 0h.008v.008H9.75V15zm3 0h.008v.008H12.75V15zm3 0h.008v.008H15.75V15zm3 0h.008v.008H18.75V15z"/></svg>
                                    S. de bain
                                </span>
                            </label>
                            <input id="bathrooms" name="bathrooms" type="number" min="0" value="{{ old('bathrooms', $property->bathrooms) }}"
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
                            <option value="available" @selected(old('status', $property->status) === 'available')>Disponible</option>
                            <option value="unavailable" @selected(old('status', $property->status) === 'unavailable')>Indisponible</option>
                            <option value="maintenance" @selected(old('status', $property->status) === 'maintenance')>Maintenance</option>
                        </select>
                    </div>
                </div>

            </div>

            {{-- Image Manager --}}
            <div class="panel p-6 sm:p-8 space-y-5">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-navy-50 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-navy-700" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.41a2.25 2.25 0 013.182 0l2.909 2.91m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/></svg>
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold text-surface-900">Galerie photos</h2>
                        <p class="text-sm text-surface-500">{{ $property->images->count() }} photo{{ $property->images->count() > 1 ? 's' : '' }}</p>
                    </div>
                </div>

                {{-- Image grid --}}
                @if($property->images->isNotEmpty())
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3" id="image-grid">
                        @foreach ($property->images as $image)
                            <div class="relative group rounded-xl overflow-hidden bg-surface-100 aspect-square" data-image-id="{{ $image->id }}">
                                <img src="{{ Storage::url($image->image) }}" alt="" class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-200 flex items-center justify-center gap-2">
                                    <button type="button" x-on:click.prevent="$dispatch('open-modal', 'delete-image-{{ $image->id }}')" class="w-8 h-8 rounded-lg bg-white/90 backdrop-blur-sm hover:bg-white text-red-600 flex items-center justify-center transition-all duration-200">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                    </button>
                                </div>
                            </div>

                            <x-ui.modal id="delete-image-{{ $image->id }}" maxWidth="sm">
                                <div class="text-center">
                                    <div class="w-14 h-14 rounded-2xl bg-red-50 flex items-center justify-center mx-auto mb-4">
                                        <svg class="w-7 h-7 text-red-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg>
                                    </div>
                                    <h3 class="text-lg font-semibold text-surface-900 mb-1">Supprimer cette photo ?</h3>
                                    <p class="text-sm text-surface-500 mb-6">Cette action est irréversible.</p>
                                    <div class="flex items-center justify-center gap-3">
                                        <x-button variant="secondary" size="sm" x-on:click="$dispatch('close-modal', 'delete-image-{{ $image->id }}')">Annuler</x-button>
                                        <form method="POST" action="{{ route('properties.images.destroy', $image) }}">
                                            @csrf @method('DELETE')
                                            <x-button type="submit" variant="danger" size="sm">Supprimer</x-button>
                                        </form>
                                    </div>
                                </div>
                            </x-ui.modal>
                        @endforeach
                    </div>
                @endif

                {{-- Upload zone --}}
                <form method="POST" action="{{ route('properties.images.store', $property) }}" enctype="multipart/form-data"
                      x-data="{ uploading: false, files: [], previews: [], uploaded: 0, total: 0 }"
                      x-on:submit="uploading = true"
                      class="border-2 border-dashed border-surface-200/80 hover:border-navy-300/60 rounded-2xl p-8 text-center transition-all duration-200 cursor-pointer"
                      x-on:dragover.prevent="$el.classList.add('border-navy-400', 'bg-navy-50/30')"
                      x-on:dragleave.prevent="$el.classList.remove('border-navy-400', 'bg-navy-50/30')"
                      x-on:drop.prevent="
                        $el.classList.remove('border-navy-400', 'bg-navy-50/30');
                        files = [...$event.dataTransfer.files].filter(f => f.type.startsWith('image/'));
                        previews = files.map(f => URL.createObjectURL(f));
                        total = files.length;
                        uploaded = 0;
                        if(files.length) $el.querySelector('input[type=file]').files = $event.dataTransfer.files;
                      ">
                    @csrf
                    <input type="file" name="images[]" multiple accept="image/*"
                           x-on:change="files = [...$event.target.files]; previews = files.map(f => URL.createObjectURL(f)); total = files.length; uploaded = 0;"
                           class="hidden" id="image-upload">

                    <template x-if="!files.length">
                        <div>
                            <label for="image-upload" class="cursor-pointer">
                                <div class="w-14 h-14 rounded-2xl bg-surface-100 flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-7 h-7 text-surface-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5V9.75m0 0l3 3m-3-3l-3 3M6.75 19.5a4.5 4.5 0 01-1.41-8.775 5.25 5.25 0 0110.325 0A4.5 4.5 0 0117.25 19.5H6.75z"/></svg>
                                </div>
                                <p class="text-sm font-medium text-surface-700 mb-1">Cliquez ou glissez-déposez vos images ici</p>
                                <p class="text-xs text-surface-400">PNG, JPG jusqu'à 4 Mo</p>
                            </label>
                        </div>
                    </template>

                    <template x-if="files.length">
                        <div>
                            <div class="grid grid-cols-4 sm:grid-cols-6 gap-2 mb-4">
                                <template x-for="(preview, i) in previews" :key="i">
                                    <div class="aspect-square rounded-xl overflow-hidden bg-surface-100">
                                        <img :src="preview" class="w-full h-full object-cover">
                                    </div>
                                </template>
                            </div>
                            <div class="flex items-center justify-center gap-3">
                                <x-button type="submit" x-show="!uploading">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/></svg>
                                    Télécharger <span x-text="files.length"></span> photo(s)
                                </x-button>
                                <x-button variant="secondary"
                                          x-on:click="files = []; previews = []; $el.closest('form').querySelector('input[type=file]').value = ''">
                                    Annuler
                                </x-button>
                            </div>
                            <div x-show="uploading" class="mt-4">
                                <div class="w-full bg-surface-100 rounded-full h-2 overflow-hidden">
                                    <div class="h-full bg-navy-600 rounded-full transition-all duration-300" :style="`width: ${total ? (uploaded / total) * 100 : 0}%`"></div>
                                </div>
                                <p class="text-xs text-surface-500 mt-1" x-text="`${uploaded} / ${total}`"></p>
                            </div>
                        </div>
                    </template>
                </form>
            </div>

            {{-- Actions --}}
            <div class="panel p-5 flex items-center justify-end gap-3">
                <x-button href="{{ route('properties.show', $property) }}" variant="secondary">Annuler</x-button>
                <x-button type="submit" :class="saving ? 'opacity-70 pointer-events-none' : ''">
                    <svg x-show="!saving" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125"/></svg>
                    <svg x-show="saving" x-cloak class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"/></svg>
                    <span x-show="!saving">Enregistrer</span>
                    <span x-show="saving" x-cloak>Enregistrement...</span>
                </x-button>
            </div>
        </form>

    </div>
</x-app-layout>