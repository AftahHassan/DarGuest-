@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full ps-3 pe-4 py-2 border-l-4 border-navy-500 text-start text-base font-medium text-navy-700 bg-navy-50 focus:outline-none focus:text-navy-800 focus:bg-navy-100 focus:border-navy-700 transition duration-150 ease-in-out'
            : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-surface-600 hover:text-surface-800 hover:bg-surface-50 hover:border-surface-300 focus:outline-none focus:text-surface-800 focus:bg-surface-50 focus:border-surface-300 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
