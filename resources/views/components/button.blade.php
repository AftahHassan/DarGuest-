@props([
    'variant' => 'primary',
    'size' => 'md',
    'href' => null,
    'type' => 'button',
    'full' => false,
    'target' => null,
])

@php
    $tag = $href ? 'a' : 'button';

    $sizes = [
        'sm'    => 'h-10 px-4 text-xs',
        'md'    => 'h-11 px-6 text-sm',
        'lg'    => 'h-12 px-7 text-sm',
        'xl'    => 'h-12 px-8 text-base',
        'icon'  => 'h-9 w-9 px-0 justify-center',
    ];
    $sizeClass = $sizes[$size] ?? $sizes['md'];

    $variants = [
        'primary'   => 'bg-navy-700 hover:bg-navy-800 text-white focus-visible:ring-navy-700',
        'secondary' => 'bg-white hover:bg-surface-50 text-surface-900 border border-surface-300 focus-visible:ring-surface-300',
        'success'   => 'bg-emerald-600 hover:bg-emerald-700 text-white focus-visible:ring-emerald-600',
        'danger'    => 'bg-red-600 hover:bg-red-700 text-white focus-visible:ring-red-600',
        'outline'   => 'bg-transparent hover:bg-navy-50 text-navy-700 border border-navy-700 focus-visible:ring-navy-700',
        'ghost'     => 'bg-transparent hover:bg-surface-100 text-surface-600 hover:text-surface-900 focus-visible:ring-surface-400',
    ];
    $variantClass = $variants[$variant] ?? $variants['primary'];
@endphp

<{{ $tag }}
    @if ($href)
        href="{{ $href }}"
        @if ($target) target="{{ $target }}" @endif
    @else
        type="{{ $type }}"
    @endif
    {{ $attributes->class([
        'inline-flex items-center justify-center gap-2.5 font-semibold rounded-xl',
        'w-fit',
        'shadow-sm',
        'transition-all duration-200 ease-out',
        'hover:-translate-y-0.5 active:translate-y-0 active:scale-95',
        'focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2',
        'disabled:opacity-50 disabled:cursor-not-allowed',
        $sizeClass,
        $variantClass,
        'w-full' => $full,
    ]) }}
>
    {{ $slot }}
</{{ $tag }}>
