<x-guest-layout>
    <div class="mb-4 text-sm text-surface-600">
        {{ __('Merci pour votre inscription ! Avant de continuer, vérifiez votre email en cliquant sur le lien que nous venons de vous envoyer.') }}
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-emerald-600">
            {{ __('Un nouveau lien de vérification a été envoyé.') }}
        </div>
    @endif

    <div class="mt-4 flex items-center justify-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <div>
                <x-button type="submit" variant="secondary">
                    {{ __('Renvoyer l\'email') }}
                </x-button>
            </div>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-sm text-surface-500 hover:text-navy-600 transition-colors">
                {{ __('Déconnexion') }}
            </button>
        </form>
    </div>
</x-guest-layout>
