@props(['message'])

@if($message)
    <p class="mt-1.5 text-sm text-danger-600" {{ $attributes }}>
        {{ $message }}
    </p>
@endif
