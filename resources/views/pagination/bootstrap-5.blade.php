@if ($paginator->hasPages())
    <nav class="pagination-wrapper" aria-label="Pagination Navigation">
        {{-- Mobile View --}}
        <div class="d-flex justify-content-between align-items-center d-sm-none mb-3">
            <div class="pagination-info">
                <small class="text-muted">
                    পৃষ্ঠা {{ $paginator->currentPage() }} এর {{ $paginator->lastPage() }}
                </small>
            </div>
            <div class="d-flex" style="gap: 0.5rem;">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <span class="btn btn-outline-secondary btn-sm disabled">
                        <i class="fas fa-chevron-left"></i>
                    </span>
                @else
                    <a class="btn btn-outline-primary btn-sm" href="{{ $paginator->previousPageUrl() }}" rel="prev">
                        <i class="fas fa-chevron-left"></i>
                    </a>
                @endif

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <a class="btn btn-outline-primary btn-sm" href="{{ $paginator->nextPageUrl() }}" rel="next">
                        <i class="fas fa-chevron-right"></i>
                    </a>
                @else
                    <span class="btn btn-outline-secondary btn-sm disabled">
                        <i class="fas fa-chevron-right"></i>
                    </span>
                @endif
            </div>
        </div>

        {{-- Desktop View --}}
        <div class="d-none d-sm-flex align-items-center justify-content-between">
            <div class="pagination-info">
                <p class="small text-muted mb-0">
                    মোট <span class="fw-semibold">{{ $paginator->total() }}</span> টি শিক্ষার্থীর মধ্যে
                    <span class="fw-semibold">{{ $paginator->firstItem() }}</span>
                    থেকে
                    <span class="fw-semibold">{{ $paginator->lastItem() }}</span>
                    পর্যন্ত প্রদর্শিত হচ্ছে
                </p>
            </div>

            <div>
                <ul class="pagination mb-0">
                    {{-- Previous Page Link --}}
                    @if ($paginator->onFirstPage())
                        <li class="page-item disabled" aria-disabled="true">
                            <span class="page-link">
                                <i class="fas fa-chevron-left"></i>
                            </span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">
                                <i class="fas fa-chevron-left"></i>
                            </a>
                        </li>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($elements as $element)
                        {{-- "Three Dots" Separator --}}
                        @if (is_string($element))
                            <li class="page-item disabled">
                                <span class="page-link">{{ $element }}</span>
                            </li>
                        @endif

                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <li class="page-item active">
                                        <span class="page-link">{{ $page }}</span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        <li class="page-item">
                            <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        </li>
                    @else
                        <li class="page-item disabled" aria-disabled="true">
                            <span class="page-link">
                                <i class="fas fa-chevron-right"></i>
                            </span>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
@endif