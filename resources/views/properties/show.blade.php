<x-app-layout>
    <div class="space-y-10">

        {{-- Status toast --}}
        @if (session('status'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2" class="alert-success flex items-center justify-between" role="alert">
                <span>{{ session('status') }}</span>
                <button type="button" x-on:click="show = false" class="ml-4 text-emerald-700 hover:text-emerald-900">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        @endif

        {{-- ============================== --}}
        {{-- HERO HEADER                    --}}
        {{-- ============================== --}}
        <div class="relative h-[300px] sm:h-[420px] rounded-2xl overflow-hidden bg-surface-100">
            <x-gallery :images="$property->images" class="!w-full !h-full">
                <div class="w-full h-full flex items-center justify-center bg-surface-100">
                    <svg class="w-16 h-16 text-surface-300" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.41a2.25 2.25 0 013.182 0l2.909 2.91m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/>
                    </svg>
                </div>
            </x-gallery>

            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent pointer-events-none"></div>

            <div class="absolute bottom-0 left-0 right-0 p-6 sm:p-8">
                <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
                    <div class="text-white">
                        @php
                            $statusVariant = match($property->status) {
                                'available' => 'success',
                                'unavailable' => 'gray',
                                'maintenance' => 'warning',
                                default => 'gray',
                            };
                        @endphp
                        <x-ui.badge :variant="$statusVariant" dot class="mb-3">
                            @if($property->status === 'available') Disponible
                            @elseif($property->status === 'unavailable') Indisponible
                            @elseif($property->status === 'maintenance') Maintenance
                            @else {{ $property->status }}
                            @endif
                        </x-ui.badge>
                        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold tracking-tight">{{ $property->title }}</h1>
                        <p class="text-white/70 mt-1 text-sm sm:text-base">{{ $property->address }}, {{ $property->city }}</p>
                        <div class="flex items-center gap-4 mt-3 text-white/80 text-sm">
                            <span class="flex items-center gap-1.5"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"/></svg>{{ $property->capacity }} voyageurs</span>
                            <span class="flex items-center gap-1.5"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 20.25h12m-7.5-3v3m3-3v3m-10-3a3 3 0 01-3-3V6a3 3 0 013-3h12a3 3 0 013 3v8.25a3 3 0 01-3 3m-15 0h15"/></svg>{{ $property->bedrooms }} chambres</span>
                            <span class="flex items-center gap-1.5"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 2.994v3.264m12-3.264v3.264M6.75 6h4.5m-4.5 0H4.5m2.25 0v5.25M6.75 6h9m-9 0H3.75m12 0h2.25m-2.25 0v5.25M12 6V3.75m0 0H9.75M12 3.75h2.25M18.75 6v5.25M6.75 15h.008v.008H6.75V15zm3 0h.008v.008H9.75V15zm3 0h.008v.008H12.75V15zm3 0h.008v.008H15.75V15zm3 0h.008v.008H18.75V15z"/></svg>{{ $property->bathrooms }} sdb</span>
                        </div>
                    </div>
                    <div class="text-white text-right flex-shrink-0">
                        <p class="text-3xl sm:text-4xl font-bold">{{ number_format($property->price_per_night, 0, ',', ' ') }}</p>
                        <p class="text-white/60 text-sm">MAD / nuit</p>
                    </div>
                </div>
            </div>

            @can('update', $property)
                <div class="absolute top-4 right-4 flex gap-2 z-10">
                    <a href="{{ route('properties.edit', $property) }}" class="bg-white/90 backdrop-blur-sm hover:bg-white text-surface-800 text-sm font-medium rounded-xl px-4 py-2.5 transition-all duration-200 flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125"/></svg>
                        Modifier
                    </a>
                    <button x-on:click="$dispatch('open-modal', 'delete-property-{{ $property->id }}')" class="bg-white/90 backdrop-blur-sm hover:bg-white text-red-600 text-sm font-medium rounded-xl px-4 py-2.5 transition-all duration-200 flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                        Supprimer
                    </button>
                </div>
            @endcan
        </div>

        {{-- ============================== --}}
        {{-- CONTENT GRID                  --}}
        {{-- ============================== --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Left column (2/3) --}}
            <div class="lg:col-span-2 space-y-6">

                {{-- General info --}}
                <div class="panel p-6 sm:p-8">
                    <div class="flex items-center gap-3 mb-5">
                        <div class="w-10 h-10 rounded-xl bg-navy-50 flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-navy-700" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 9.776c.112-.017.227-.026.344-.026h15.812c.117 0 .232.009.344.026m-16.5 0a2.25 2.25 0 00-1.883 2.542l.857 6a2.25 2.25 0 002.227 1.932H19.05a2.25 2.25 0 002.227-1.932l.857-6a2.25 2.25 0 00-1.883-2.542m-16.5 0V6A2.25 2.25 0 016 3.75h3.879a1.5 1.5 0 011.06.44l2.122 2.12a1.5 1.5 0 001.06.44H18A2.25 2.25 0 0120.25 9v.776"/></svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold text-surface-900">Informations générales</h2>
                            <p class="text-sm text-surface-500">{{ $property->address }}, {{ $property->city }}</p>
                        </div>
                    </div>

                    @if($property->description)
                        <div class="text-surface-700 leading-relaxed whitespace-pre-line">{{ $property->description }}</div>
                    @else
                        <p class="text-sm text-surface-400 italic">Aucune description fournie.</p>
                    @endif

                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mt-6 pt-6 border-t border-surface-200/60">
                        <div class="text-center">
                            <p class="text-2xl font-bold text-surface-900">{{ $property->capacity }}</p>
                            <p class="text-xs text-surface-500 mt-0.5">Voyageurs</p>
                        </div>
                        <div class="text-center">
                            <p class="text-2xl font-bold text-surface-900">{{ $property->bedrooms }}</p>
                            <p class="text-xs text-surface-500 mt-0.5">Chambres</p>
                        </div>
                        <div class="text-center">
                            <p class="text-2xl font-bold text-surface-900">{{ $property->bathrooms }}</p>
                            <p class="text-xs text-surface-500 mt-0.5">Salles de bain</p>
                        </div>
                        <div class="text-center">
                            <p class="text-2xl font-bold text-navy-700">{{ number_format($property->price_per_night, 0, ',', ' ') }}</p>
                            <p class="text-xs text-surface-500 mt-0.5">MAD / nuit</p>
                        </div>
                    </div>
                </div>

                {{-- Photos gallery --}}
                @can('update', $property)
                    <div class="panel p-6 sm:p-8">
                        <div class="flex items-center justify-between mb-5">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-navy-50 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-navy-700" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.41a2.25 2.25 0 013.182 0l2.909 2.91m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/></svg>
                                </div>
                                <div>
                                    <h2 class="text-lg font-semibold text-surface-900">Galerie photos</h2>
                                    <p class="text-sm text-surface-500">{{ $property->images->count() }} photo{{ $property->images->count() > 1 ? 's' : '' }}</p>
                                </div>
                            </div>
                        </div>

                        {{-- Image grid --}}
                        @if($property->images->isNotEmpty())
                            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3 mb-5" id="image-grid">
                                @foreach ($property->images as $image)
                                    <div class="relative group rounded-xl overflow-hidden bg-surface-100 aspect-square" data-image-id="{{ $image->id }}">
                                        <img src="{{ Storage::url($image->image) }}" alt="" class="w-full h-full object-cover">
                                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-200 flex items-center justify-center gap-2">
                                            <form method="POST" action="{{ route('properties.images.destroy', $image) }}" class="m-0">
                                                @csrf @method('DELETE')
                                                <button type="button" x-on:click.prevent="$dispatch('open-modal', 'delete-image-{{ $image->id }}')" class="w-8 h-8 rounded-lg bg-white/90 backdrop-blur-sm hover:bg-white text-red-600 flex items-center justify-center transition-all duration-200">
                                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </div>

                                    {{-- Delete image modal --}}
                                    <x-ui.modal id="delete-image-{{ $image->id }}" maxWidth="sm">
                                        <div class="text-center">
                                            <div class="w-14 h-14 rounded-2xl bg-red-50 flex items-center justify-center mx-auto mb-4">
                                                <svg class="w-7 h-7 text-red-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg>
                                            </div>
                                            <h3 class="text-lg font-semibold text-surface-900 mb-1">Supprimer cette photo ?</h3>
                                            <p class="text-sm text-surface-500 mb-6">Cette action est irréversible.</p>
                                            <div class="flex items-center justify-center gap-3">
                                                <button type="button" x-on:click="$dispatch('close-modal', 'delete-image-{{ $image->id }}')" class="btn-secondary text-sm px-5 py-2">Annuler</button>
                                                <form method="POST" action="{{ route('properties.images.destroy', $image) }}">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="btn-danger text-sm px-5 py-2">Supprimer</button>
                                                </form>
                                            </div>
                                        </div>
                                    </x-ui.modal>
                                @endforeach
                            </div>
                        @endif

                        {{-- Upload form --}}
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
                                        <button type="submit" class="btn-primary text-sm px-5 py-2" x-show="!uploading">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/></svg>
                                            Télécharger <span x-text="files.length"></span> photo(s)
                                        </button>
                                        <button type="button" class="btn-secondary text-sm px-5 py-2"
                                                x-on:click="files = []; previews = []; $el.closest('form').querySelector('input[type=file]').value = ''">
                                            Annuler
                                        </button>
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
                @endcan

                {{-- Practical info --}}
                @can('update', $property)
                    <div class="panel p-6 sm:p-8">
                        <div class="flex items-center gap-3 mb-5">
                            <div class="w-10 h-10 rounded-xl bg-navy-50 flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-navy-700" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/></svg>
                            </div>
                            <div>
                                <h2 class="text-lg font-semibold text-surface-900">Informations pratiques</h2>
                                <p class="text-sm text-surface-500">Wifi, parking, check-in/out et règlement</p>
                            </div>
                        </div>

                        <form method="POST" action="{{ route('properties.info.update', $property) }}" class="space-y-5">
                            @csrf @method('PUT')

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-surface-700 mb-1.5">
                                        <span class="flex items-center gap-2">
                                            <svg class="w-4 h-4 text-surface-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M8.288 15.038a5.25 5.25 0 017.424 0M5.106 11.856c3.807-3.808 9.98-3.808 13.788 0M1.924 8.674c5.565-5.565 14.587-5.565 20.152 0M12.53 18.22l-.53.53-.53-.53a.75.75 0 011.06 0z"/></svg>
                                            Nom du WiFi
                                        </span>
                                    </label>
                                    <input name="wifi_name" value="{{ $property->info?->wifi_name }}" placeholder="Ex : DarGuest_Wifi"
                                           class="w-full bg-white border border-surface-200 text-surface-800 rounded-xl text-sm transition-all duration-200 px-4 py-2.5 focus:border-navy-500 focus:ring-2 focus:ring-navy-500/20 focus:outline-none placeholder:text-surface-400">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-surface-700 mb-1.5">
                                        <span class="flex items-center gap-2">
                                            <svg class="w-4 h-4 text-surface-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/></svg>
                                            Mot de passe WiFi
                                        </span>
                                    </label>
                                    <input name="wifi_password" value="{{ $property->info?->wifi_password }}" placeholder="Ex : DarGuest2024"
                                           class="w-full bg-white border border-surface-200 text-surface-800 rounded-xl text-sm transition-all duration-200 px-4 py-2.5 focus:border-navy-500 focus:ring-2 focus:ring-navy-500/20 focus:outline-none placeholder:text-surface-400">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-surface-700 mb-1.5">
                                        <span class="flex items-center gap-2">
                                            <svg class="w-4 h-4 text-surface-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            Check-in
                                        </span>
                                    </label>
                                    <input type="time" name="check_in" value="{{ $property->info?->check_in }}"
                                           class="w-full bg-white border border-surface-200 text-surface-800 rounded-xl text-sm transition-all duration-200 px-4 py-2.5 focus:border-navy-500 focus:ring-2 focus:ring-navy-500/20 focus:outline-none">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-surface-700 mb-1.5">
                                        <span class="flex items-center gap-2">
                                            <svg class="w-4 h-4 text-surface-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            Check-out
                                        </span>
                                    </label>
                                    <input type="time" name="check_out" value="{{ $property->info?->check_out }}"
                                           class="w-full bg-white border border-surface-200 text-surface-800 rounded-xl text-sm transition-all duration-200 px-4 py-2.5 focus:border-navy-500 focus:ring-2 focus:ring-navy-500/20 focus:outline-none">
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-surface-700 mb-1.5">
                                    <span class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-surface-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/></svg>
                                        Parking
                                    </span>
                                </label>
                                <div class="flex items-center gap-3 mt-1">
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="checkbox" name="parking" value="1" @checked($property->info?->parking)
                                               class="rounded border-surface-300 text-navy-700 shadow-sm focus:ring-navy-500">
                                        <span class="text-sm text-surface-700">Parking disponible</span>
                                    </label>
                                </div>
                                @if($property->info?->parking)
                                    <input name="parking_info" value="{{ $property->info?->parking_info }}" placeholder="Informations parking (optionnel)"
                                           class="mt-2 w-full bg-white border border-surface-200 text-surface-800 rounded-xl text-sm transition-all duration-200 px-4 py-2.5 focus:border-navy-500 focus:ring-2 focus:ring-navy-500/20 focus:outline-none placeholder:text-surface-400">
                                @endif
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-surface-700 mb-1.5">
                                    <span class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-surface-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 12h.007v.008H3.75V12zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm-.375 5.25h.007v.008H3.75v-.008zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/></svg>
                                        Instructions d'accès
                                    </span>
                                </label>
                                <textarea name="access_instructions" rows="2" placeholder="Comment accéder au logement…"
                                          class="w-full bg-white border border-surface-200 text-surface-800 rounded-xl text-sm transition-all duration-200 px-4 py-2.5 focus:border-navy-500 focus:ring-2 focus:ring-navy-500/20 focus:outline-none placeholder:text-surface-400 resize-y min-h-[60px]">{{ $property->info?->access_instructions }}</textarea>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-surface-700 mb-1.5">
                                    <span class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-surface-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/></svg>
                                        Règlement intérieur
                                    </span>
                                </label>
                                <textarea name="house_rules" rows="2" placeholder="Les règles à respecter…"
                                          class="w-full bg-white border border-surface-200 text-surface-800 rounded-xl text-sm transition-all duration-200 px-4 py-2.5 focus:border-navy-500 focus:ring-2 focus:ring-navy-500/20 focus:outline-none placeholder:text-surface-400 resize-y min-h-[60px]">{{ $property->info?->house_rules }}</textarea>
                            </div>

                            <button type="submit" class="btn-primary">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                                Enregistrer les informations
                            </button>
                        </form>
                    </div>
                @endcan

                {{-- Recommendations --}}
                <div class="panel p-6 sm:p-8">
                    <div class="flex items-center justify-between mb-5">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-navy-50 flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-navy-700" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z"/></svg>
                            </div>
                            <div>
                                <h2 class="text-lg font-semibold text-surface-900">Recommandations locales</h2>
                                <p class="text-sm text-surface-500">Les bons plans à proximité</p>
                            </div>
                        </div>
                        @can('update', $property)
                            <button x-on:click="$dispatch('open-modal', 'add-recommendation')" class="btn-primary text-sm px-4 py-2">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                                Ajouter
                            </button>
                        @endcan
                    </div>

                    @if($property->recommendations->isNotEmpty())
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @foreach ($property->recommendations as $reco)
                                @php
                                    $recoIcons = [
                                        'restaurant' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 8.25v-1.5m0 1.5c-1.355 0-2.697.056-4.024.166C6.845 8.51 6 9.473 6 10.608v2.513m6-4.87c1.355 0 2.697.055 4.024.165C17.155 8.51 18 9.473 18 10.608v2.513M15 8.25v-1.5m-6 1.5v-1.5m12 9.75l-1.5-1.5M3.54 20.25a48.15 48.15 0 0116.92 0"/>',
                                        'cafe' => '<path stroke-linecap="round" stroke-linejoin="round" d="M8.288 15.038a5.25 5.25 0 017.424 0M5.106 11.856c3.807-3.808 9.98-3.808 13.788 0M1.924 8.674c5.565-5.565 14.587-5.565 20.152 0M12.53 18.22l-.53.53-.53-.53a.75.75 0 011.06 0z"/>',
                                        'beach' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z"/>',
                                        'surf_school' => '<path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342"/>',
                                        'taxi' => '<path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 0 1-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 0 0-3.213-9.193 2.056 2.056 0 0 0-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 0 0-10.026 0 1.106 1.106 0 0 0-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12"/>',
                                        'pharmacy' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9.75 3.75v-1.5h4.5v1.5m-4.5 0h4.5m-6.75 3v9a2.25 2.25 0 0 0 2.25 2.25h6.75a2.25 2.25 0 0 0 2.25-2.25v-9m-11.25 0h11.25"/>',
                                        'hospital' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>',
                                        'supermarket' => '<path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3.75 3.75 0 0 0-3.75 3.75h15.75M5.25 11.25h13.5l1.149-5.069a1.125 1.125 0 0 0-1.108-1.376H5.25l-.75-2.25H2.25m9 4.5v6m-3-3h6"/>',
                                        'atm' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>',
                                    ];
                                    $recoLabel = [
                                        'restaurant' => 'Restaurant', 'cafe' => 'Café', 'beach' => 'Plage',
                                        'surf_school' => 'Surf School', 'taxi' => 'Taxi', 'pharmacy' => 'Pharmacie',
                                        'hospital' => 'Hôpital', 'supermarket' => 'Supermarché', 'atm' => 'Distributeur',
                                    ];
                                @endphp
                                <div class="bg-white/80 backdrop-blur-sm border border-surface-200/60 rounded-xl p-4 hover:shadow-md transition-all duration-200">
                                    <div class="flex items-start gap-3">
                                        <div class="w-9 h-9 rounded-lg bg-navy-50 flex items-center justify-center flex-shrink-0 mt-0.5">
                                            <svg class="w-5 h-5 text-navy-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">{!! $recoIcons[$reco->category] ?? $recoIcons['restaurant'] !!}</svg>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center justify-between gap-2">
                                                <p class="font-medium text-surface-900 text-sm">{{ $reco->title }}</p>
                                                <span class="text-[10px] font-medium text-surface-500 uppercase tracking-wider whitespace-nowrap">{{ $recoLabel[$reco->category] ?? $reco->category }}</span>
                                            </div>
                                            @if($reco->description)
                                                <p class="text-xs text-surface-500 mt-1">{{ $reco->description }}</p>
                                            @endif
                                            @if($reco->address || $reco->phone)
                                                <div class="flex flex-wrap gap-3 mt-2 text-xs text-surface-400">
                                                    @if($reco->address)
                                                        <span class="flex items-center gap-1"><svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>{{ $reco->address }}</span>
                                                    @endif
                                                    @if($reco->phone)
                                                        <span class="flex items-center gap-1"><svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/></svg>{{ $reco->phone }}</span>
                                                    @endif
                                                </div>
                                            @endif
                                            @can('update', $property)
                                                <div class="flex gap-2 mt-2 pt-2 border-t border-surface-100">
                                                    <button x-on:click="$dispatch('open-modal', 'edit-recommendation-{{ $reco->id }}')" class="text-xs text-navy-600 hover:text-navy-800 font-medium transition-colors">Modifier</button>
                                                    <button x-on:click="$dispatch('open-modal', 'delete-recommendation-{{ $reco->id }}')" class="text-xs text-red-600 hover:text-red-800 font-medium transition-colors">Supprimer</button>
                                                </div>
                                            @endcan
                                        </div>
                                    </div>
                                </div>

                                {{-- Edit recommendation modal --}}
                                @can('update', $property)
                                    <x-ui.modal id="edit-recommendation-{{ $reco->id }}" maxWidth="lg" title="Modifier la recommandation">
                                        <form id="edit-reco-form-{{ $reco->id }}" method="POST" action="{{ route('properties.recommendations.store', $property) }}" class="space-y-4">
                                            @csrf
                                            <input type="hidden" name="edit_id" value="{{ $reco->id }}">
                                            <div>
                                                <label class="block text-sm font-medium text-surface-700 mb-1.5">Catégorie</label>
                                                <select name="category" required
                                                        class="w-full bg-white border border-surface-200 text-surface-800 rounded-xl text-sm px-4 py-2.5 focus:border-navy-500 focus:ring-2 focus:ring-navy-500/20 focus:outline-none">
                                                    @foreach(['restaurant','cafe','beach','surf_school','taxi','pharmacy','hospital','supermarket','atm'] as $cat)
                                                        <option value="{{ $cat }}" @selected($reco->category === $cat)>{{ ucfirst(str_replace('_', ' ', $cat)) }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-surface-700 mb-1.5">Nom</label>
                                                <input name="title" value="{{ $reco->title }}" required
                                                       class="w-full bg-white border border-surface-200 text-surface-800 rounded-xl text-sm px-4 py-2.5 focus:border-navy-500 focus:ring-2 focus:ring-navy-500/20 focus:outline-none">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-surface-700 mb-1.5">Description</label>
                                                <textarea name="description" rows="2"
                                                          class="w-full bg-white border border-surface-200 text-surface-800 rounded-xl text-sm px-4 py-2.5 focus:border-navy-500 focus:ring-2 focus:ring-navy-500/20 focus:outline-none resize-y min-h-[60px]">{{ $reco->description }}</textarea>
                                            </div>
                                            <div class="grid grid-cols-2 gap-4">
                                                <div>
                                                    <label class="block text-sm font-medium text-surface-700 mb-1.5">Adresse</label>
                                                    <input name="address" value="{{ $reco->address }}"
                                                           class="w-full bg-white border border-surface-200 text-surface-800 rounded-xl text-sm px-4 py-2.5 focus:border-navy-500 focus:ring-2 focus:ring-navy-500/20 focus:outline-none">
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-medium text-surface-700 mb-1.5">Téléphone</label>
                                                    <input name="phone" value="{{ $reco->phone }}"
                                                           class="w-full bg-white border border-surface-200 text-surface-800 rounded-xl text-sm px-4 py-2.5 focus:border-navy-500 focus:ring-2 focus:ring-navy-500/20 focus:outline-none">
                                                </div>
                                            </div>
                                        </form>
                                        <x-slot:footer>
                                            <button type="button" x-on:click="$dispatch('close-modal', 'edit-recommendation-{{ $reco->id }}')" class="btn-secondary text-sm px-5 py-2">Annuler</button>
                                            <button type="submit" form="edit-reco-form-{{ $reco->id }}" class="btn-primary text-sm px-5 py-2">Enregistrer</button>
                                        </x-slot:footer>
                                    </x-ui.modal>

                                    {{-- Delete recommendation modal --}}
                                    <x-ui.modal id="delete-recommendation-{{ $reco->id }}" maxWidth="sm">
                                        <div class="text-center">
                                            <div class="w-14 h-14 rounded-2xl bg-red-50 flex items-center justify-center mx-auto mb-4">
                                                <svg class="w-7 h-7 text-red-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg>
                                            </div>
                                            <h3 class="text-lg font-semibold text-surface-900 mb-1">Supprimer cette recommandation ?</h3>
                                            <p class="text-sm text-surface-500 mb-6">Cette action est irréversible.</p>
                                            <div class="flex items-center justify-center gap-3">
                                                <button type="button" x-on:click="$dispatch('close-modal', 'delete-recommendation-{{ $reco->id }}')" class="btn-secondary text-sm px-5 py-2">Annuler</button>
                                                <form method="POST" action="{{ route('properties.recommendations.destroy', $reco) }}">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="btn-danger text-sm px-5 py-2">Supprimer</button>
                                                </form>
                                            </div>
                                        </div>
                                    </x-ui.modal>
                                @endcan
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <div class="w-12 h-12 rounded-2xl bg-surface-100 flex items-center justify-center mx-auto mb-3">
                                <svg class="w-6 h-6 text-surface-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z"/></svg>
                            </div>
                            <p class="text-sm text-surface-500">Aucune recommandation pour l'instant.</p>
                        </div>
                    @endif
                </div>

            </div>

            {{-- Right column (1/3) --}}
            <div class="space-y-6">

                {{-- Price card --}}
                <div class="panel p-6">
                    <p class="text-3xl font-bold text-surface-900">{{ number_format($property->price_per_night, 0, ',', ' ') }} <span class="text-sm font-normal text-surface-500">MAD / nuit</span></p>
                    @if($property->status === 'available')
                        <p class="text-xs text-emerald-600 font-medium mt-2">Prêt à recevoir des réservations</p>
                    @elseif($property->status === 'unavailable')
                        <p class="text-xs text-surface-500 font-medium mt-2">Actuellement indisponible</p>
                    @elseif($property->status === 'maintenance')
                        <p class="text-xs text-amber-600 font-medium mt-2">En maintenance</p>
                    @endif
                </div>

                {{-- Owner card (for guests) --}}
                @if(auth()->user()->isGuest())
                    <div class="panel p-6">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 rounded-full bg-navy-700 text-white flex items-center justify-center text-sm font-semibold">
                                {{ strtoupper(substr($property->owner?->first_name ?? '?', 0, 1)) }}{{ strtoupper(substr($property->owner?->last_name ?? '?', 0, 1)) }}
                            </div>
                            <div>
                                <p class="text-sm font-medium text-surface-900">{{ $property->owner?->fullName() ?? 'Propriétaire' }}</p>
                                <p class="text-xs text-surface-500">Hôte</p>
                            </div>
                        </div>

                        @if ($errors->any())
                            <div class="alert-danger mb-4 text-xs">
                                <ul class="list-disc pl-4">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('reservations.store') }}" class="space-y-4">
                            @csrf
                            <input type="hidden" name="property_id" value="{{ $property->id }}">

                            <div>
                                <label class="block text-xs font-semibold text-surface-500 uppercase tracking-wider mb-1">Arrivée</label>
                                <input type="date" name="check_in_date" value="{{ old('check_in_date') }}" required
                                       class="w-full bg-white border border-surface-200 text-surface-800 rounded-xl text-sm px-4 py-2.5 focus:border-navy-500 focus:ring-2 focus:ring-navy-500/20 focus:outline-none">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-surface-500 uppercase tracking-wider mb-1">Départ</label>
                                <input type="date" name="check_out_date" value="{{ old('check_out_date') }}" required
                                       class="w-full bg-white border border-surface-200 text-surface-800 rounded-xl text-sm px-4 py-2.5 focus:border-navy-500 focus:ring-2 focus:ring-navy-500/20 focus:outline-none">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-surface-500 uppercase tracking-wider mb-1">Voyageurs</label>
                                <input type="number" name="number_of_guests" min="1" max="{{ $property->capacity }}" value="{{ old('number_of_guests', 1) }}" required
                                       class="w-full bg-white border border-surface-200 text-surface-800 rounded-xl text-sm px-4 py-2.5 focus:border-navy-500 focus:ring-2 focus:ring-navy-500/20 focus:outline-none">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-surface-500 uppercase tracking-wider mb-1">Demande spéciale</label>
                                <textarea name="special_request" rows="2" placeholder="Optionnel"
                                          class="w-full bg-white border border-surface-200 text-surface-800 rounded-xl text-sm px-4 py-2.5 focus:border-navy-500 focus:ring-2 focus:ring-navy-500/20 focus:outline-none placeholder:text-surface-400 resize-y min-h-[60px]">{{ old('special_request') }}</textarea>
                            </div>
                            <button type="submit" class="btn-primary w-full">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                                Réserver
                            </button>
                        </form>
                    </div>
                @endif

            </div>
        </div>

        {{-- ============================== --}}
        {{-- ADD RECOMMENDATION MODAL       --}}
        {{-- ============================== --}}
        @can('update', $property)
            <x-ui.modal id="add-recommendation" maxWidth="lg" title="Ajouter une recommandation">
                <form id="add-reco-form" method="POST" action="{{ route('properties.recommendations.store', $property) }}" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-surface-700 mb-1.5">Catégorie</label>
                        <select name="category" required
                                class="w-full bg-white border border-surface-200 text-surface-800 rounded-xl text-sm px-4 py-2.5 focus:border-navy-500 focus:ring-2 focus:ring-navy-500/20 focus:outline-none">
                            @foreach(['restaurant','cafe','beach','surf_school','taxi','pharmacy','hospital','supermarket','atm'] as $cat)
                                <option value="{{ $cat }}">{{ ucfirst(str_replace('_', ' ', $cat)) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-surface-700 mb-1.5">Nom</label>
                        <input name="title" placeholder="Nom de l'établissement" required
                               class="w-full bg-white border border-surface-200 text-surface-800 rounded-xl text-sm px-4 py-2.5 focus:border-navy-500 focus:ring-2 focus:ring-navy-500/20 focus:outline-none placeholder:text-surface-400">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-surface-700 mb-1.5">Description</label>
                        <textarea name="description" rows="2" placeholder="Optionnelle"
                                  class="w-full bg-white border border-surface-200 text-surface-800 rounded-xl text-sm px-4 py-2.5 focus:border-navy-500 focus:ring-2 focus:ring-navy-500/20 focus:outline-none placeholder:text-surface-400 resize-y min-h-[60px]"></textarea>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-surface-700 mb-1.5">Adresse</label>
                            <input name="address" placeholder="Optionnelle"
                                   class="w-full bg-white border border-surface-200 text-surface-800 rounded-xl text-sm px-4 py-2.5 focus:border-navy-500 focus:ring-2 focus:ring-navy-500/20 focus:outline-none placeholder:text-surface-400">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-surface-700 mb-1.5">Téléphone</label>
                            <input name="phone" placeholder="Optionnel"
                                   class="w-full bg-white border border-surface-200 text-surface-800 rounded-xl text-sm px-4 py-2.5 focus:border-navy-500 focus:ring-2 focus:ring-navy-500/20 focus:outline-none placeholder:text-surface-400">
                        </div>
                    </div>
                </form>
                <x-slot:footer>
                    <button type="button" x-on:click="$dispatch('close-modal', 'add-recommendation')" class="btn-secondary text-sm px-5 py-2">Annuler</button>
                    <button type="submit" form="add-reco-form" class="btn-primary text-sm px-5 py-2">Ajouter</button>
                </x-slot:footer>
            </x-ui.modal>

            {{-- Delete property modal --}}
            <x-ui.modal id="delete-property-{{ $property->id }}" maxWidth="sm">
                <div class="text-center">
                    <div class="w-14 h-14 rounded-2xl bg-red-50 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-7 h-7 text-red-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg>
                    </div>
                    <h3 class="text-lg font-semibold text-surface-900 mb-1">Supprimer ce logement ?</h3>
                    <p class="text-sm text-surface-500 mb-2">Cette action est irréversible.</p>
                    <p class="text-xs text-surface-400 mb-6">Toutes les données associées seront définitivement supprimées.</p>
                    <div class="flex items-center justify-center gap-3">
                        <button type="button" x-on:click="$dispatch('close-modal', 'delete-property-{{ $property->id }}')" class="btn-secondary text-sm px-5 py-2">Annuler</button>
                        <form method="POST" action="{{ route('properties.destroy', $property) }}">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-danger text-sm px-5 py-2">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                Supprimer
                            </button>
                        </form>
                    </div>
                </div>
            </x-ui.modal>
        @endcan

    </div>
</x-app-layout>