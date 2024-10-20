<nav>
    <ul class="pagination pagination-sm pagination-gutter pagination-info justify-content-center">
        <li class="page-item {{ $paginator->onFirstPage() ? 'disabled' : '' }}">
            <a class="page-link" href="{{ $paginator->previousPageUrl() }}" aria-label="Previous">
                <i class="la la-angle-left"></i>
            </a>
        </li>

        @for ($i = 1; $i <= $paginator->lastPage(); $i++)
            <li class="page-item {{ ($paginator->currentPage() == $i) ? 'active' : '' }}">
                <a class="page-link" href="{{ $paginator->url($i) }}">{{ $i }}</a>
            </li>
        @endfor

        <li class="page-item {{ $paginator->hasMorePages() ? '' : 'disabled' }}">
            <a class="page-link" href="{{ $paginator->nextPageUrl() }}" aria-label="Next">
                <i class="la la-angle-right"></i>
            </a>
        </li>
    </ul>
</nav>