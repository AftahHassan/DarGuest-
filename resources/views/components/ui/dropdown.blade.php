@props(['position' => 'bottom-right'])

<div
    x-data="{ open: false }"
    x-on:click.away="open = false"
    x-on:keydown.escape.window="open = false"
    class="relative inline-block text-left"
>
    <div x-on:click="open = !open">
        {{ $trigger }}
    </div>

    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="absolute {{ str_contains($position, 'right') ? 'right-0' : 'left-0' }} {{ str_contains($position, 'top') ? 'bottom-full mb-2' : 'top-full mt-2' }} z-50 min-w-[200px] bg-white border border-surface-200 rounded-xl shadow-elevated py-1 hidden"
        style="display: none;"
        x-on:click="open = false"
    >
        {{ $slot }}
    </div>
</div>
