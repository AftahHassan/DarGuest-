<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-2xl font-bold text-surface-900 tracking-tight">Analyse IA</h2>
            <p class="text-sm text-surface-500 mt-0.5">Analyses automatiques des messages</p>
        </div>
    </x-slot>

    <x-ui.empty-state
        title="Analyse IA en cours de développement"
        description="Les analyses de messages par intelligence artificielle seront disponibles ici. Chaque analyse affichera le message, la langue détectée, la catégorie, le score de confiance et la réponse générée."
    >
        <x-slot:icon>
            <div class="w-16 h-16 rounded-2xl bg-primary-50 flex items-center justify-center">
                <svg class="w-8 h-8 text-primary-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.455 2.456L21.75 6l-1.036.259a3.375 3.375 0 00-2.455 2.456z"/>
                </svg>
            </div>
        </x-slot:icon>
    </x-ui.empty-state>
</x-app-layout>
