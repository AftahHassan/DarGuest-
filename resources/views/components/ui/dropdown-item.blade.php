@props(['href' => null, 'active' => false])

@php
    $tag = $href ? 'a' : 'button';
@endphp

<{{ $tag }}
    @if($href) href="{{ $href }}" @endif
    {{ $attributes->class([
        'w-full text-left px-4 py-2.5 text-sm transition-colors duration-150 flex items-center gap-3',
        'text-surface-700 hover:bg-surface-50' => !$active,
        'text-navy-700 bg-navy-50 font-medium' => $active,
    ]) }}
>
    {{ $slot }}
</{{ $tag }}>
