<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-surface-700 mb-1']) }}>
    {{ $value ?? $slot }}
</label>
