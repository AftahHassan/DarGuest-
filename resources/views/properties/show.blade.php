<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $property->title }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('status'))
                <div class="bg-green-100 text-green-800 p-3 rounded">{{ session('status') }}</div>
            @endif

            {{-- Infos générales --}}
            <div class="bg-white p-6 rounded shadow">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-gray-600">{{ $property->address }}, {{ $property->city }}</p>
                        <p class="mt-2">{{ $property->description }}</p>
                        <p class="mt-2 font-semibold">{{ $property->price_per_night }} MAD / nuit</p>
                        <p class="text-sm text-gray-500">{{ $property->capacity }} voyageurs · {{ $property->bedrooms }} chambres · {{ $property->bathrooms }} sdb</p>
                    </div>

                    @can('update', $property)
                        <div class="space-x-2">
                            <a href="{{ route('properties.edit', $property) }}" class="text-indigo-600">Modifier</a>
                            <form method="POST" action="{{ route('properties.destroy', $property) }}" class="inline" onsubmit="return confirm('Supprimer ce logement ?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600">Supprimer</button>
                            </form>
                        </div>
                    @endcan
                </div>
            </div>

            {{-- Images --}}
            <div class="bg-white p-6 rounded shadow">
                <h3 class="font-semibold mb-3">Images</h3>
                <div class="grid grid-cols-4 gap-3 mb-4">
                    @foreach ($property->images as $image)
                        <div class="relative">
                            <img src="{{ asset('storage/'.$image->image) }}" class="w-full h-24 object-cover rounded">
                            @can('update', $property)
                                <form method="POST" action="{{ route('properties.images.destroy', $image) }}" onsubmit="return confirm('Supprimer cette image ?')">
                                    @csrf @method('DELETE')
                                    <button class="absolute top-1 right-1 bg-red-600 text-white text-xs rounded px-1">×</button>
                                </form>
                            @endcan
                        </div>
                    @endforeach
                </div>

                @can('update', $property)
                    <form method="POST" action="{{ route('properties.images.store', $property) }}" enctype="multipart/form-data">
                        @csrf
                        <input type="file" name="images[]" multiple accept="image/*">
                        <x-primary-button class="mt-2">Ajouter des images</x-primary-button>
                    </form>
                @endcan
            </div>

            {{-- Informations pratiques --}}
            @can('update', $property)
                <div class="bg-white p-6 rounded shadow">
                    <h3 class="font-semibold mb-3">Informations pratiques</h3>
                    <form method="POST" action="{{ route('properties.info.update', $property) }}" class="space-y-3">
                        @csrf @method('PUT')

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <x-input-label value="Nom du WiFi" />
                                <x-text-input name="wifi_name" class="block mt-1 w-full" :value="$property->info?->wifi_name" />
                            </div>
                            <div>
                                <x-input-label value="Mot de passe WiFi" />
                                <x-text-input name="wifi_password" class="block mt-1 w-full" :value="$property->info?->wifi_password" />
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <x-input-label value="Check-in" />
                                <input type="time" name="check_in" class="block mt-1 w-full border-gray-300 rounded-md" value="{{ $property->info?->check_in }}">
                            </div>
                            <div>
                                <x-input-label value="Check-out" />
                                <input type="time" name="check_out" class="block mt-1 w-full border-gray-300 rounded-md" value="{{ $property->info?->check_out }}">
                            </div>
                        </div>

                        <div>
                            <x-input-label value="Instructions d'accès" />
                            <textarea name="access_instructions" rows="2" class="block mt-1 w-full border-gray-300 rounded-md">{{ $property->info?->access_instructions }}</textarea>
                        </div>

                        <div>
                            <x-input-label value="Règlement intérieur" />
                            <textarea name="house_rules" rows="2" class="block mt-1 w-full border-gray-300 rounded-md">{{ $property->info?->house_rules }}</textarea>
                        </div>

                        <x-primary-button>Enregistrer les infos</x-primary-button>
                    </form>
                </div>
            @endcan

            {{-- Recommandations --}}
            <div class="bg-white p-6 rounded shadow">
                <h3 class="font-semibold mb-3">Recommandations locales</h3>
                <ul class="space-y-2 mb-4">
                    @foreach ($property->recommendations as $reco)
                        <li class="flex justify-between text-sm border-b pb-1">
                            <span><strong>{{ ucfirst($reco->category) }}</strong> — {{ $reco->title }}</span>
                            @can('update', $property)
                                <form method="POST" action="{{ route('properties.recommendations.destroy', $reco) }}" onsubmit="return confirm('Supprimer ?')">
                                    @csrf @method('DELETE')
                                    <button class="text-red-600">Supprimer</button>
                                </form>
                            @endcan
                        </li>
                    @endforeach
                </ul>

                @can('update', $property)
                    <form method="POST" action="{{ route('properties.recommendations.store', $property) }}" class="grid grid-cols-2 gap-3">
                        @csrf
                        <select name="category" class="border-gray-300 rounded-md" required>
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
                            <x-primary-button>Ajouter</x-primary-button>
                        </div>
                    </form>
                @endcan
            </div>

        </div>
    </div>
</x-app-layout>