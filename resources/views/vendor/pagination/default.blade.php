@if ($paginator->hasPages())
    <ul class="pagination flex items-center justify-center list-reset ">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="inline-block w-10 h-10 rounded-full py-2 m-1 active">
                <i class="material-icons text-grey">chevron_right</i>
            </li>
        @else
            <li class="inline-block w-10 rounded-full m-1">
                <a class="no-underline block h-10 py-2" href="{{ $paginator->previousPageUrl() }}">
                    <i class="material-icons text-black">chevron_right</i>
                </a>
            </li>
            {{-- <li class="inline-block "><a class="no-underline" href="{{ $paginator->previousPageUrl() }}" rel="prev"><span class="px-4 py-2 m-1 w-10 h-10 bg-white shadow rounded-full">&laquo;</span></a></li> --}}
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="inline-block disabled"><span class="px-4 py-2 m-1 w-10 h-10 bg-white shadow rounded-full">{{ $element }}</span></li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="flex items-center justify-center w-12 h-12 bg-black shadow text-white rounded-full py-2 m-1 active">
                            {{ $page }}
                        </li>
                    @else
                        <li class="">
                            <a class="no-underline flex items-center justify-center w-12 h-12 bg-white shadow rounded-full m-1 text-black" href="{{ $url }}">
                                {{ $page }}
                            </a>
                        </li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li class="inline-block w-10  rounded-full m-1">
                <a class="no-underline block h-10 py-2" href="{{ $paginator->nextPageUrl() }}" rel="next">
                    <i class="material-icons text-black">chevron_left</i>
                </a>
            </li>
        @else
            <li class="inline-block w-10 h-10 rounded-full py-2 m-1 disabled ">
                <i class="material-icons text text-grey">chevron_left</i>
            </li>
        @endif
    </ul>
@endif