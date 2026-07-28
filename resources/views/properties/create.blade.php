<x-app-layout>
    <div class="py-10">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">

            <h1 class="text-2xl font-bold text-surface-900 mb-6">Nouveau logement</h1>

            <form method="POST" action="{{ route('properties.store') }}" class="card p-6 space-y-5">
                @csrf

                <div>
                    <x-input-label for="title" value="Titre" />
                    <x-text-input id="title" name="title" class="mt-1 block w-full" :value="old('title')" required />
                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="description" value="Description" />
                    <textarea id="description" name="description" rows="3" class="textarea-field mt-1">{{ old('description') }}</textarea>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="city" value="Ville" />
                        <x-text-input id="city" name="city" class="mt-1 block w-full" :value="old('city')" required />
                    </div>
                    <div>
                        <x-input-label for="address" value="Adresse" />
                        <x-text-input id="address" name="address" class="mt-1 block w-full" :value="old('address')" required />
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <x-input-label for="price_per_night" value="Prix / nuit" />
                        <x-text-input id="price_per_night" name="price_per_night" type="number" step="0.01" class="mt-1 block w-full" :value="old('price_per_night')" required />
                    </div>
                    <div>
                        <x-input-label for="capacity" value="Capacité" />
                        <x-text-input id="capacity" name="capacity" type="number" class="mt-1 block w-full" :value="old('capacity')" required />
                    </div>
                    <div>
                        <x-input-label for="bedrooms" value="Chambres" />
                        <x-text-input id="bedrooms" name="bedrooms" type="number" class="mt-1 block w-full" :value="old('bedrooms')" required />
                    </div>
                </div>

                <div>
                    <x-input-label for="bathrooms" value="Salles de bain" />
                    <x-text-input id="bathrooms" name="bathrooms" type="number" class="mt-1 block w-full" :value="old('bathrooms')" required />
                </div>

                <button type="submit" class="btn-primary">Créer le logement</button>
            </form>
        </div>
    </div>
</x-app-layout>