<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Nouveau logement</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('properties.store') }}" class="bg-white p-6 rounded shadow space-y-4">
                @csrf

                <div>
                    <x-input-label for="title" value="Titre" />
                    <x-text-input id="title" name="title" class="block mt-1 w-full" :value="old('title')" required />
                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="description" value="Description" />
                    <textarea id="description" name="description" rows="3" class="block mt-1 w-full border-gray-300 rounded-md">{{ old('description') }}</textarea>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="city" value="Ville" />
                        <x-text-input id="city" name="city" class="block mt-1 w-full" :value="old('city')" required />
                    </div>
                    <div>
                        <x-input-label for="address" value="Adresse" />
                        <x-text-input id="address" name="address" class="block mt-1 w-full" :value="old('address')" required />
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <x-input-label for="price_per_night" value="Prix / nuit" />
                        <x-text-input id="price_per_night" name="price_per_night" type="number" step="0.01" class="block mt-1 w-full" :value="old('price_per_night')" required />
                    </div>
                    <div>
                        <x-input-label for="capacity" value="Capacité" />
                        <x-text-input id="capacity" name="capacity" type="number" class="block mt-1 w-full" :value="old('capacity')" required />
                    </div>
                    <div>
                        <x-input-label for="bedrooms" value="Chambres" />
                        <x-text-input id="bedrooms" name="bedrooms" type="number" class="block mt-1 w-full" :value="old('bedrooms')" required />
                    </div>
                </div>

                <div>
                    <x-input-label for="bathrooms" value="Salles de bain" />
                    <x-text-input id="bathrooms" name="bathrooms" type="number" class="block mt-1 w-full" :value="old('bathrooms')" required />
                </div>

                <x-primary-button>Créer le logement</x-primary-button>
            </form>
        </div>
    </div>
</x-app-layout>