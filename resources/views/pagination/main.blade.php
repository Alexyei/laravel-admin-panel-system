@if ($paginator->hasPages())
    <div class="pagination flex-row">

{{--    <nav>--}}
{{--        <ul class="pagination">--}}
            {{-- Previous Page Link --}}
            @if (!$paginator->onFirstPage())
{{--                <li class="disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">--}}
{{--                    <span aria-hidden="true">&lsaquo;</span>--}}
{{--                </li>--}}
{{--            <a href="#" aria-disabled="true" aria-label="@lang('pagination.previous')" class="pages"><i class="fas fa-chevron-left"></i></a>--}}
{{--            @else--}}
{{--                <li>--}}
{{--                    <a href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">&lsaquo;</a>--}}
{{--                </li>--}}
            <a href="{{ $paginator->toArray()['first_page_url'] }}" class="pages"><i class="fas fa-chevron-left"></i></a>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
{{--                    <li class="disabled" aria-disabled="true"><span>{{ $element }}</span></li>--}}
                <a href="#" class="pages">{{ $element}}</a>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
{{--                            <li class="active" aria-current="page"><span>{{ $page }}</span></li>--}}
                        <a href="#" class="pages current">{{ $page }}</a>
                    @else
{{--                            <li><a href="{{ $url }}">{{ $page }}</a></li>--}}
                            <a href="{{ $url }}" class="pages">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
{{--                <li>--}}
{{--                    <a href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">&rsaquo;</a>--}}
{{--                </li>--}}
            <a href="{{ $paginator->toArray()['last_page_url'] }}" class="pages"><i class="fas fa-chevron-right"></i></a>
{{--            @else--}}
{{--                <li class="disabled" aria-disabled="true" aria-label="@lang('pagination.next')">--}}
{{--                    <span aria-hidden="true">&rsaquo;</span>--}}
{{--                </li>--}}
            @endif
{{--        </ul>--}}
{{--    </nav>--}}

    </div>
@endif
