@props(['variant' => 'primary', 'dot' => false])

@php
    $variantClass = match($variant) {
        'primary' => 'bg-primary-50 text-primary-700 border-primary-200',
        'success' => 'bg-success-50 text-success-600 border-success-100',
        'warning' => 'bg-amber-50 text-amber-700 border-amber-200',
        'danger' => 'bg-danger-50 text-danger-600 border-danger-100',
        'gray' => 'bg-surface-100 text-surface-600 border-surface-200',
        'info' => 'bg-blue-50 text-blue-600 border-blue-200',
        default => 'bg-primary-50 text-primary-700 border-primary-200',
    };
    $dotColor = match($variant) {
        'primary' => 'bg-primary-500',
        'success' => 'bg-success-500',
        'warning' => 'bg-amber-500',
        'danger' => 'bg-danger-500',
        'gray' => 'bg-surface-400',
        'info' => 'bg-blue-500',
        default => 'bg-primary-500',
    };
@endphp

<span {{ $attributes->class([
    'inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-medium border',
    $variantClass,
]) }}>
    @if($dot)
        <span class="w-1.5 h-1.5 rounded-full {{ $dotColor }}"></span>
    @endif
    {{ $slot }}
</span>
