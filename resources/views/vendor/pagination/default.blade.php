@if ($paginator->hasPages())
    <ul class="pagination   list-reset">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="inline-block w-10 h-10 bg-grey rounded-sm py-2 m-1 active">
                <
            </li>
        @else
            <li class="inline-block w-10 bg-grey rounded-sm m-1">
                <a class="no-underline block h-10 py-2" href="{{ $paginator->previousPageUrl() }}">
                    <
                </a>
            </li>
            {{-- <li class="inline-block "><a class="no-underline" href="{{ $paginator->previousPageUrl() }}" rel="prev"><span class="px-4 py-2 m-1 w-10 h-10 bg-grey rounded-sm">&laquo;</span></a></li> --}}
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="inline-block  disabled"><span class="px-4 py-2 m-1 w-10 h-10 bg-grey rounded-sm">{{ $element }}</span></li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="inline-block w-10 h-10 bg-grey rounded-sm py-2 m-1 active">
                            {{ $page }}
                        </li>
                    @else
                        <li class="inline-block w-10 bg-grey rounded-sm m-1">
                            <a class="no-underline block h-10 py-2" href="{{ $url }}">
                                {{ $page }}
                            </a>
                        </li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li class="inline-block w-10 bg-grey rounded-sm m-1">
                <a class="no-underline block h-10 py-2" href="{{ $paginator->nextPageUrl() }}" rel="next">
                    >
                </a>
            </li>
        @else
            <li class="inline-block w-10 bg-grey rounded-sm m-1 disabled">
                >
            </li>
        @endif
    </ul>
@endif