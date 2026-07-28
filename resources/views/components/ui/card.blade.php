@props(['hover' => false, 'padding' => true])

<div {{ $attributes->class([
    'card bg-white border border-surface-200 rounded-xl shadow-soft transition-all duration-200',
    'hover:shadow-medium hover:border-surface-300 cursor-pointer' => $hover,
    'p-6' => $padding && !$attributes->has('no-padding'),
]) }}>
    {{ $slot }}
</div>
