@props(['variant' => 'primary', 'size' => 'md', 'icon' => false, 'href' => null, 'type' => 'button'])

@php
    $tag = $href ? 'a' : 'button';
    $sizeClass = match($size) {
        'sm' => 'px-3 py-1.5 text-xs',
        'md' => 'px-5 py-2.5 text-sm',
        'lg' => 'px-6 py-3 text-sm font-semibold',
        xl => 'px-8 py-3.5 text-base font-semibold',
        default => 'px-5 py-2.5 text-sm',
    };
    $variantClass = match($variant) {
        'primary' => 'bg-primary-600 hover:bg-primary-700 text-white shadow-sm hover:shadow-medium focus:ring-primary-500',
        'secondary' => 'bg-white hover:bg-surface-50 text-surface-700 border border-surface-200 focus:ring-surface-300',
        'danger' => 'bg-danger-500 hover:bg-danger-600 text-white shadow-sm focus:ring-danger-500',
        'ghost' => 'text-surface-600 hover:bg-surface-100 hover:text-surface-900',
        'success' => 'bg-success-500 hover:bg-success-600 text-white shadow-sm focus:ring-success-500',
        'link' => 'text-primary-600 hover:text-primary-700 underline-offset-2 hover:underline',
        default => 'bg-primary-600 hover:bg-primary-700 text-white shadow-sm focus:ring-primary-500',
    };
@endphp

<{{ $tag }}
    @if($href) href="{{ $href }}" @endif
    @if(!$href) type="{{ $type }}" @endif
    {{ $attributes->class([
        'btn inline-flex items-center justify-center gap-2 font-medium rounded-lg transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed',
        $sizeClass,
        $variantClass,
        'p-2' => $icon && $size === 'sm',
    ]) }}
>
    {{ $slot }}
</{{ $tag }}>
