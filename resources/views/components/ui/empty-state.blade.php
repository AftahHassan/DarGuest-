@props(['title' => 'Aucun résultat', 'description' => 'Il n\'y a rien à afficher pour le moment.', 'icon' => null, 'action' => null])

<div class="empty-state py-16 text-center">
    <div class="empty-state-icon mx-auto">
        @if($icon)
            <span class="text-surface-400">{!! $icon !!}</span>
        @else
            <svg class="w-8 h-8 text-surface-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
            </svg>
        @endif
    </div>
    <h3 class="text-base font-semibold text-surface-900 mb-1">{{ $title }}</h3>
    <p class="text-sm text-surface-500 max-w-sm mx-auto mb-6">{{ $description }}</p>
    @if($action)
        <div>{{ $action }}</div>
    @endif
</div>
