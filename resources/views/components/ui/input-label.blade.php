@props(['for'])

<div>
    <label for="{{ $for }}" class="label-field">{{ $slot }}</label>
</div>
