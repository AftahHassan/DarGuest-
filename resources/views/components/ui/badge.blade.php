@props(['variant' => 'primary', 'dot' => false])

@php
    $classes = match($variant) {
        'primary' => 'bg-navy-50 text-navy-700 border-navy-200',
        'success' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
        'warning' => 'bg-amber-50 text-amber-700 border-amber-200',
        'danger' => 'bg-red-50 text-red-700 border-red-200',
        'gray' => 'bg-surface-100 text-surface-600 border-surface-200',
        'info' => 'bg-sky-50 text-sky-700 border-sky-200',
        default => 'bg-navy-50 text-navy-700 border-navy-200',
    };
    $dotColor = match($variant) {
        'primary' => 'bg-navy-500',
        'success' => 'bg-emerald-500',
        'warning' => 'bg-amber-500',
        'danger' => 'bg-red-500',
        'gray' => 'bg-surface-400',
        'info' => 'bg-sky-500',
        default => 'bg-navy-500',
    };
@endphp

<span {{ $attributes->class([
    'inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-medium border',
    $classes,
]) }}>
    @if($dot)
        <span class="w-1.5 h-1.5 rounded-full {{ $dotColor }}"></span>
    @endif
    {{ $slot }}
</span>
