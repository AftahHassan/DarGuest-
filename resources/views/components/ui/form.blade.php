@props(['action' => '#', 'method' => 'GET'])

<form method="{{ $method === 'GET' ? 'GET' : 'POST' }}" action="{{ $action }}" class="contents">
    @csrf
    @unless(strtoupper($method) === 'GET')
        @method($method)
    @endunless
    {{ $slot }}
</form>
