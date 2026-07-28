@props(['variant' => 'primary', 'size' => 'md', 'icon' => false, 'href' => null, 'type' => 'button'])

@php
    $tag = $href ? 'a' : 'button';
    $sizeClass = match($size) {
        'sm' => 'px-3 py-1.5 text-xs',
        'md' => 'px-5 py-2.5 text-sm',
        'lg' => 'px-6 py-3 text-sm font-semibold',
        'xl' => 'px-8 py-3.5 text-base font-semibold',
        default => 'px-5 py-2.5 text-sm',
    };
    $variantClass = match($variant) {
        'primary' => 'bg-navy-700 hover:bg-navy-800 text-white shadow-sm focus:ring-navy-500',
        'secondary' => 'bg-white hover:bg-surface-50 text-surface-700 border border-surface-200 focus:ring-surface-300',
        'danger' => 'bg-red-600 hover:bg-red-700 text-white shadow-sm focus:ring-red-500',
        'ghost' => 'text-surface-600 hover:bg-surface-100 hover:text-surface-900',
        'success' => 'bg-emerald-600 hover:bg-emerald-700 text-white shadow-sm focus:ring-emerald-500',
        'link' => 'text-navy-700 hover:text-navy-800 underline-offset-2 hover:underline',
        default => 'bg-navy-700 hover:bg-navy-800 text-white shadow-sm focus:ring-navy-500',
    };
@endphp

<{{ $tag }}
    @if($href) href="{{ $href }}" @endif
    @if(!$href) type="{{ $type }}" @endif
    {{ $attributes->class([
        'inline-flex items-center justify-center gap-2 font-medium rounded-lg transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed',
        $sizeClass,
        $variantClass,
        'p-2' => $icon && $size === 'sm',
    ]) }}
>
    {{ $slot }}
</{{ $tag }}>
