@props(['type' => 'text', 'lines' => 1, 'height' => null])

@php
    $heightClass = match($type) {
        'avatar' => 'w-10 h-10 rounded-full',
        'button' => 'h-10 w-32 rounded-lg',
        'card' => 'h-40 w-full rounded-xl',
        'heading' => 'h-7 w-48 rounded-lg',
        'text' => 'h-4 rounded-lg',
        'image' => 'h-48 w-full rounded-xl',
        default => 'h-4 rounded-lg',
    };
@endphp

<div class="space-y-3" aria-hidden="true">
    @for($i = 0; $i < $lines; $i++)
        <div
            {{ $attributes->class([
                'animate-pulse bg-surface-200 rounded-lg',
                $heightClass,
            ]) }}
            @if($height) style="height: {{ $height }}px;" @endif
        ></div>
    @endfor
</div>
