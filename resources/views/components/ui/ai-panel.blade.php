@props([
    'analysis' => null,
    'categoryLabels' => [],
    'title' => 'Assistant IA',
    'subtitle' => 'Analyse intelligente',
])

<template x-teleport="body">
    <div
        x-show="aiPanel"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-[80]"
        style="display: none;"
    >
        <div class="absolute inset-0 bg-surface-900/40 backdrop-blur-sm" x-on:click="aiPanel = false"></div>

        <aside
            x-show="aiPanel"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="translate-x-full"
            class="absolute right-0 top-0 h-full w-full max-w-md bg-surface-50 shadow-2xl flex flex-col"
        >
            <div class="px-5 py-4 border-b border-surface-200/80 bg-white/80 backdrop-blur-xl flex items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-gold-100 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-gold-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.455 2.456L21.75 6l-1.036.259a3.375 3.375 0 00-2.455 2.456zM16.894 20.567L16.5 21.75l-.394-1.183a2.25 2.25 0 00-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 001.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 001.423 1.423l1.183.394-1.183.394a2.25 2.25 0 00-1.423 1.423z"/></svg>
                    </div>
                    <div>
                        <h2 class="text-sm font-semibold text-surface-900">{{ $title }}</h2>
                        <p class="text-xs text-surface-500">{{ $subtitle }}</p>
                    </div>
                </div>
                <button type="button" x-on:click="aiPanel = false"
                        class="w-9 h-9 rounded-xl bg-surface-100 hover:bg-surface-200 text-surface-500 hover:text-surface-900 flex items-center justify-center transition-colors">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <div class="flex-1 overflow-y-auto p-5">
                @if($analysis)
                    <div class="flex flex-wrap gap-2 mb-4">
                        <span class="badge-primary !text-[10px]">
                            <svg class="w-3 h-3 inline mr-1" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 21l5.25-11.25L21 21m-9-3h7.5M3 5.621a48.474 48.474 0 016-.371m0 0c1.12 0 2.233.038 3.334.114M9 5.25V3m3.334 2.364C11.176 10.658 7.69 15.08 3 17.502m9.334-12.138c.896.061 1.785.147 2.666.257m-4.589 8.495a18.023 18.023 0 01-3.827-5.802"/></svg>
                            {{ $analysis->detected_language ?? 'Auto' }}
                        </span>
                        <span class="badge-primary !text-[10px]">{{ $categoryLabels[$analysis->category] ?? $analysis->category }}</span>
                        @if($analysis->confidence)
                            <span class="badge-gray !text-[10px]">Confiance {{ round($analysis->confidence * 100) }}%</span>
                        @endif
                    </div>

                    @if($analysis->urgency)
                        <div class="flex items-start gap-3 rounded-xl bg-red-50 border border-red-200 p-4 mb-4">
                            <div class="w-8 h-8 rounded-lg bg-red-100 flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-red-700">Urgence détectée</p>
                                <p class="text-xs text-red-600 mt-0.5">Intervention immédiate recommandée.</p>
                            </div>
                        </div>
                    @endif

                    <p class="text-[10px] font-semibold text-navy-700 uppercase tracking-wider mb-1.5">Résumé automatique</p>
                    <p class="text-sm text-surface-600 leading-relaxed">{{ $analysis->generated_response ? Str::limit($analysis->generated_response, 240) : 'Aucun résumé disponible pour le moment.' }}</p>

                    @if($analysis->structured_output)
                        <p class="text-[10px] font-semibold text-navy-700 uppercase tracking-wider mt-4 mb-1.5">Détection</p>
                        <div class="space-y-1.5">
                            @foreach($analysis->structured_output as $key => $value)
                                <div class="flex items-center justify-between gap-2 rounded-lg bg-white border border-surface-200/70 px-3 py-2">
                                    <span class="text-[11px] text-surface-500 capitalize">{{ str_replace('_', ' ', $key) }}</span>
                                    <span class="text-xs font-medium text-surface-800 text-right">{{ is_array($value) ? implode(', ', $value) : $value }}</span>
                                </div>
                            @endforeach
                        </div>
                    @endif
                @else
                    <div class="text-center py-10">
                        <div class="w-12 h-12 rounded-2xl bg-gold-50 flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6 text-gold-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z"/></svg>
                        </div>
                        <p class="text-sm font-medium text-surface-600">Pas encore d'analyse</p>
                        <p class="text-xs text-surface-400 mt-1">L'IA analysera les messages échangés.</p>
                    </div>
                @endif
            </div>
        </aside>
    </div>
</template>
