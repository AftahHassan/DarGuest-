@props(['type' => 'success', 'message' => null, 'duration' => 5000, 'title' => null])

@php
    $iconColor = match($type) {
        'success' => 'text-emerald-500',
        'error' => 'text-red-500',
        'info' => 'text-sky-500',
        'warning' => 'text-amber-500',
        default => 'text-emerald-500',
    };
    $iconBg = match($type) {
        'success' => 'bg-emerald-50',
        'error' => 'bg-red-50',
        'info' => 'bg-sky-50',
        'warning' => 'bg-amber-50',
        default => 'bg-emerald-50',
    };
@endphp

<div
    x-data="{
        show: true,
        init() {
            setTimeout(() => { this.show = false }, {{ $duration }})
        }
    }"
    x-show="show"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 translate-x-4 scale-95"
    x-transition:enter-end="opacity-100 translate-x-0 scale-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 translate-x-0 scale-100"
    x-transition:leave-end="opacity-0 translate-x-4 scale-95"
    class="toast"
    x-cloak
>
    <div class="toast-{{ $type }}">
        <div class="w-9 h-9 rounded-xl {{ $iconBg }} flex items-center justify-center flex-shrink-0">
            @if($type === 'success')
                <svg class="w-5 h-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            @elseif($type === 'error')
                <svg class="w-5 h-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>
                </svg>
            @elseif($type === 'info')
                <svg class="w-5 h-5 text-sky-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/>
                </svg>
            @elseif($type === 'warning')
                <svg class="w-5 h-5 text-amber-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/>
                </svg>
            @endif
        </div>
        <div class="flex-1 min-w-0">
            @if($title)
                <p class="text-sm font-semibold text-surface-900">{{ $title }}</p>
                <p class="text-xs text-surface-500 mt-0.5">{{ $message ?? $slot }}</p>
            @else
                <p class="text-sm font-medium text-surface-900">{{ $message ?? $slot }}</p>
            @endif
        </div>
        <button x-on:click="show = false" class="flex-shrink-0 text-surface-400 hover:text-surface-600 transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>
</div>
