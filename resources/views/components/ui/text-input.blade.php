@props(['value' => null, 'icon' => null, 'type' => 'text'])

<div class="relative">
    @if($icon)
        <div class="absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none">
            <svg class="w-5 h-5 text-surface-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                {!! $icon !!}
            </svg>
        </div>
    @endif
    <input
        type="{{ $type }}"
        value="{{ $value }}"
        {{ $attributes->class([
            'w-full bg-white border border-surface-200 text-surface-800 rounded-lg text-sm transition-all duration-200',
            'focus:border-navy-500 focus:ring-2 focus:ring-navy-500/20 focus:outline-none placeholder:text-surface-400',
            'px-4 py-2.5' => !$icon,
            'pl-10 pr-4 py-2.5' => $icon,
        ]) }}
    />
</div>
