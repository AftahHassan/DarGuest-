@props(['type' => 'success', 'message' => null, 'duration' => 5000])

<div
    x-data="{
        show: true,
        init() {
            setTimeout(() => { this.show = false }, {{ $duration }})
        }
    }"
    x-show="show"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 translate-y-4"
    x-transition:enter-end="opacity-100 translate-y-0"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 translate-y-0"
    x-transition:leave-end="opacity-0 translate-y-4"
    class="toast"
    x-cloak
>
    <div class="toast-{{ $type }}">
        <div class="flex-shrink-0">
            @if($type === 'success')
                <svg class="w-5 h-5 text-success-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            @elseif($type === 'error')
                <svg class="w-5 h-5 text-danger-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            @endif
        </div>
        <div class="flex-1 min-w-0">
            <p class="text-sm font-medium text-surface-900">{{ $message ?? $slot }}</p>
        </div>
        <button x-on:click="show = false" class="flex-shrink-0 text-surface-400 hover:text-surface-600">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>
</div>
