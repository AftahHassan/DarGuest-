@props(['id' => 'modal', 'maxWidth' => 'md', 'title' => null, 'description' => null])

@php
    $maxWidthClass = match($maxWidth) {
        'sm' => 'max-w-sm',
        'md' => 'max-w-md',
        'lg' => 'max-w-lg',
        'xl' => 'max-w-xl',
        '2xl' => 'max-w-2xl',
        '4xl' => 'max-w-4xl',
        default => 'max-w-md',
    };
@endphp

<div
    x-data="{ open: false }"
    x-on:open-modal.window="$event.detail === '{{ $id }}' ? open = true : null"
    x-on:close-modal.window="$event.detail === '{{ $id }}' ? open = false : null"
    x-on:keydown.escape.window="open = false"
    x-show="open"
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-50 overflow-y-auto px-4 py-6 sm:px-0 hidden"
    style="display: none;"
>
    <div class="fixed inset-0 bg-surface-500/75" x-on:click="open = false"></div>

    <div
        class="fixed inset-0 overflow-hidden"
        x-show="open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
    >
        <div class="absolute inset-0 overflow-hidden">
            <div class="fixed inset-0 {{ $maxWidthClass }} mx-auto flex items-center justify-center" style="padding: 2rem;">
                <div class="bg-white rounded-2xl shadow-elevated w-full transform transition-all">
                    @if($title || $description)
                        <div class="px-6 pt-6 pb-0">
                            @if($title)
                                <h3 class="text-lg font-semibold text-surface-900">{{ $title }}</h3>
                            @endif
                            @if($description)
                                <p class="mt-1 text-sm text-surface-500">{{ $description }}</p>
                            @endif
                        </div>
                    @endif

                    <div class="p-6">
                        {{ $slot }}
                    </div>

                    @if(isset($footer))
                        <div class="px-6 py-4 bg-surface-50 rounded-b-2xl flex items-center justify-end gap-3">
                            {{ $footer }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
