<x-app-layout>
    <div class="py-10">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('status'))
                <div class="alert-success">{{ session('status') }}</div>
            @endif

            {{-- Infos générales --}}
            <div class="card p-6">
                <div class="flex justify-between items-start">
                    <div class="space-y-2">
                        <h1 class="text-2xl font-bold text-surface-900">{{ $property->title }}</h1>
                        <p class="text-surface-500">{{ $property->address }}, {{ $property->city }}</p>
                        <p class="text-surface-700">{{ $property->description }}</p>
                        <p class="font-semibold text-navy-700 text-lg">{{ number_format($property->price_per_night, 2) }} MAD / nuit</p>
                        <p class="text-sm text-surface-500">{{ $property->capacity }} voyageurs · {{ $property->bedrooms }} chambres · {{ $property->bathrooms }} sdb</p>
                    </div>

                    @can('update', $property)
                        <div class="flex gap-2">
                            <a href="{{ route('properties.edit', $property) }}" class="btn-secondary text-sm">
                                Modifier
                            </a>
                            <form method="POST" action="{{ route('properties.destroy', $property) }}" onsubmit="return confirm('Supprimer ce logement ?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-danger text-sm">Supprimer</button>
                            </form>
                        </div>
                    @endcan
                </div>
            </div>

            @if (auth()->user()->isGuest())
                <div class="card p-6">
                    <h3 class="font-semibold text-surface-900 mb-4">Réserver ce logement</h3>

                    @if ($errors->any())
                        <div class="alert-danger mb-4">
                            <ul class="list-disc pl-4">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('reservations.store') }}" class="grid grid-cols-2 gap-4">
                        @csrf
                        <input type="hidden" name="property_id" value="{{ $property->id }}">

                        <div>
                            <x-input-label value="Arrivée" />
                            <input type="date" name="check_in_date" value="{{ old('check_in_date') }}" class="input-field mt-1" required>
                        </div>
                        <div>
                             <x-input-label value="Départ" />
                            <input type="date" name="check_out_date" value="{{ old('check_out_date') }}" class="input-field mt-1" required>
                        </div>
                        <div>
                            <x-input-label value="Voyageurs" />
                            <x-text-input name="number_of_guests" type="number" min="1" class="mt-1" :value="old('number_of_guests')" required />
                        </div>
                        <div class="col-span-2">
                            <x-input-label value="Demande spéciale (optionnel)" />
                            <textarea name="special_request" rows="2" class="textarea-field mt-1">{{ old('special_request') }}</textarea>
                        </div>
                        <div class="col-span-2">
                            <button type="submit" class="btn-primary">Réserver</button>
                        </div>
                    </form>
                </div>
            @endif

            {{-- Images --}}
            <div class="card p-6">
                <h3 class="font-semibold text-surface-900 mb-4">Images</h3>
                <div class="grid grid-cols-4 gap-3 mb-4">
                    @foreach ($property->images as $image)
                        <div class="relative group">
                            <img src="{{ asset('storage/'.$image->image) }}" class="w-full h-24 object-cover rounded-lg">
                            @can('update', $property)
                                <form method="POST" action="{{ route('properties.images.destroy', $image) }}" onsubmit="return confirm('Supprimer cette image ?')" class="absolute top-1 right-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                    @csrf @method('DELETE')
                                    <button class="btn-icon bg-white/90 backdrop-blur-sm text-red-600 hover:bg-red-50 w-6 h-6 text-xs">×</button>
                                </form>
                            @endcan
                        </div>
                    @endforeach
                </div>

                @can('update', $property)
                    <form method="POST" action="{{ route('properties.images.store', $property) }}" enctype="multipart/form-data" class="flex items-center gap-3">
                        @csrf
                        <input type="file" name="images[]" multiple accept="image/*" class="text-sm text-surface-500 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-navy-50 file:text-navy-700 hover:file:bg-navy-100">
                        <button type="submit" class="btn-secondary text-sm">Ajouter des images</button>
                    </form>
                @endcan
            </div>

            {{-- Informations pratiques --}}
            @can('update', $property)
                <div class="card p-6">
                    <h3 class="font-semibold text-surface-900 mb-4">Informations pratiques</h3>
                    <form method="POST" action="{{ route('properties.info.update', $property) }}" class="space-y-4">
                        @csrf @method('PUT')

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <x-input-label value="Nom du WiFi" />
                                <x-text-input name="wifi_name" class="mt-1" :value="$property->info?->wifi_name" />
                            </div>
                            <div>
                                <x-input-label value="Mot de passe WiFi" />
                                <x-text-input name="wifi_password" class="mt-1" :value="$property->info?->wifi_password" />
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <x-input-label value="Check-in" />
                                <input type="time" name="check_in" class="input-field mt-1" value="{{ $property->info?->check_in }}">
                            </div>
                            <div>
                                <x-input-label value="Check-out" />
                                <input type="time" name="check_out" class="input-field mt-1" value="{{ $property->info?->check_out }}">
                            </div>
                        </div>

                        <div>
                            <x-input-label value="Instructions d'accès" />
                            <textarea name="access_instructions" rows="2" class="textarea-field mt-1">{{ $property->info?->access_instructions }}</textarea>
                        </div>

                        <div>
                            <x-input-label value="Règlement intérieur" />
                            <textarea name="house_rules" rows="2" class="textarea-field mt-1">{{ $property->info?->house_rules }}</textarea>
                        </div>

                        <button type="submit" class="btn-primary">Enregistrer les infos</button>
                    </form>
                </div>
            @endcan

            {{-- Recommandations --}}
            <div class="card p-6">
                <h3 class="font-semibold text-surface-900 mb-4">Recommandations locales</h3>

                @if ($property->recommendations->isNotEmpty())
                    <ul class="space-y-2 mb-4 divide-y divide-surface-100">
                        @foreach ($property->recommendations as $reco)
                            <li class="flex items-center justify-between py-2 text-sm">
                                <span class="text-surface-700">
                                    <span class="badge badge-primary text-xs mr-2">{{ ucfirst($reco->category) }}</span>
                                    {{ $reco->title }}
                                </span>
                                @can('update', $property)
                                    <form method="POST" action="{{ route('properties.recommendations.destroy', $reco) }}" onsubmit="return confirm('Supprimer ?')">
                                        @csrf @method('DELETE')
                                        <button class="text-red-600 hover:text-red-800 text-xs font-medium">Supprimer</button>
                                    </form>
                                @endcan
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-sm text-surface-500 mb-4">Aucune recommandation pour l'instant.</p>
                @endif

                @can('update', $property)
                    <form method="POST" action="{{ route('properties.recommendations.store', $property) }}" class="grid grid-cols-2 gap-3">
                        @csrf
                        <select name="category" class="select-field" required>
                            <option value="restaurant">Restaurant</option>
                            <option value="cafe">Café</option>
                            <option value="beach">Plage</option>
                            <option value="surf_school">École de surf</option>
                            <option value="taxi">Taxi</option>
                            <option value="pharmacy">Pharmacie</option>
                            <option value="hospital">Hôpital</option>
                            <option value="supermarket">Supermarché</option>
                            <option value="atm">Distributeur</option>
                        </select>
                        <x-text-input name="title" placeholder="Nom" required />
                        <div class="col-span-2">
                            <button type="submit" class="btn-secondary text-sm">Ajouter</button>
                        </div>
                    </form>
                @endcan
            </div>

        </div>
    </div>
</x-app-layout>