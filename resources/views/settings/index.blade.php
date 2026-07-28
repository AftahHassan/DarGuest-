<x-app-layout>
    <div class="space-y-6 animate-fade-in">
        <h2 class="text-2xl font-bold text-surface-900 tracking-tight">Paramètres</h2>

        <div class="max-w-2xl space-y-6">
            <div class="card p-6">
                <div class="flex items-center gap-4 mb-6">
                    <div class="avatar avatar-xl bg-primary-600 text-white">
                        {{ strtoupper(substr(auth()->user()->first_name, 0, 1)) }}{{ strtoupper(substr(auth()->user()->last_name, 0, 1)) }}
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-surface-900">{{ auth()->user()->fullName() }}</h3>
                        <p class="text-sm text-surface-500">{{ auth()->user()->email }}</p>
                        <x-ui.badge variant="primary" class="mt-1">{{ auth()->user()->isOwner() ? 'Propriétaire' : 'Voyageur' }}</x-ui.badge>
                    </div>
                </div>

                <div class="space-y-3">
                    <a href="{{ route('profile.edit') }}" class="flex items-center justify-between p-4 rounded-xl border border-surface-200 hover:border-primary-300 hover:bg-primary-50/30 transition-all duration-200">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-surface-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0"/></svg>
                            <span class="text-sm font-medium text-surface-700">Modifier mon profil</span>
                        </div>
                        <svg class="w-4 h-4 text-surface-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
