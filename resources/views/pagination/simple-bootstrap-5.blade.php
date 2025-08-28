@if ($paginator->hasPages())
    <nav class="pagination-wrapper" aria-label="Simple Pagination Navigation">
        <ul class="pagination justify-content-center">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled" aria-disabled="true">
                    <span class="page-link">
                        <i class="fas fa-chevron-left me-2"></i>পূর্ববর্তী
                    </span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">
                        <i class="fas fa-chevron-left me-2"></i>পূর্ববর্তী
                    </a>
                </li>
            @endif

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">
                        পরবর্তী<i class="fas fa-chevron-right ms-2"></i>
                    </a>
                </li>
            @else
                <li class="page-item disabled" aria-disabled="true">
                    <span class="page-link">
                        পরবর্তী<i class="fas fa-chevron-right ms-2"></i>
                    </span>
                </li>
            @endif
        </ul>
    </nav>
@endif