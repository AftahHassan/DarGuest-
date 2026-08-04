@props(['paginator'])

@if ($paginator->hasPages())
    <nav class="flex items-center justify-between px-1 mt-6">
        <div class="flex-1 flex justify-between sm:hidden">
            @if ($paginator->onFirstPage())
                <span class="inline-flex items-center justify-center w-fit gap-2.5 font-semibold rounded-xl h-10 px-4 text-xs text-surface-600 opacity-50 cursor-not-allowed">Précédent</span>
            @else
                <x-button href="{{ $paginator->previousPageUrl() }}" variant="ghost" size="sm">Précédent</x-button>
            @endif

            @if ($paginator->hasMorePages())
                <x-button href="{{ $paginator->nextPageUrl() }}" variant="ghost" size="sm">Suivant</x-button>
            @else
                <span class="inline-flex items-center justify-center w-fit gap-2.5 font-semibold rounded-xl h-10 px-4 text-xs text-surface-600 opacity-50 cursor-not-allowed">Suivant</span>
            @endif
        </div>

        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-center">
            <div class="flex items-center gap-1">
                @foreach ($elements as $element)
                    @if (is_string($element))
                        <span class="px-3 py-2 text-sm text-surface-400">{{ $element }}</span>
                    @endif

                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <span class="px-3 py-2 text-sm font-semibold text-white bg-navy-700 rounded-lg">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}" class="px-3 py-2 text-sm text-surface-700 hover:bg-surface-100 rounded-lg transition-colors duration-150">{{ $page }}</a>
                            @endif
                        @endforeach
                    @endif
                @endforeach
            </div>
        </div>
    </nav>
@endif
