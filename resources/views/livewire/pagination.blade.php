@if ($paginator->hasPages())
    <nav>
        <ul class="pagination">
            @if ($paginator->onFirstPage())
            <li class="page-item disabled" aria-disabled="true" aria-label="« Previous">
                <span class="page-link" aria-hidden="true"><a href="#">‹</a></span>
            </li>
            @else
            <li class="page-item" aria-disabled="false" aria-label="« Previous">
                <button type="button" class="page-link" aria-hidden="true" wire:click="setPage('{{ $paginator->previousPageUrl() }}')" wire:loading.attr="disabled">‹</button></a>
            </li>
            @endif
            @if($paginator->currentPage() > 3)
                <li class="page-item" aria-current="page">
                    <button type="button" wire:click="setPage('{{ $paginator->url(1) }}')" class="page-link">1</button>
                </li>
            @endif
            @if($paginator->currentPage() > 4)
                <li class="page-item disabled" aria-disabled="true"><span class="page-link">...</span></li>
            @endif
            @foreach(range(1, $paginator->lastPage()) as $i)
                @if($i >= $paginator->currentPage() - 2 && $i <= $paginator->currentPage() + 2)
                    @if ($i == $paginator->currentPage())
                    <li class="page-item active">
                        <button type="button" wire:click="setPage('{{ $paginator->url($i) }}')" class="page-link">{{$i}}</button>
                    </li>
                    @else
                        <li  class="page-item">
                            <button type="button" wire:click="setPage('{{ $paginator->url($i) }}')" class="page-link">{{ $i }}</button>
                        </li>
                    @endif
                @endif
            @endforeach
            @if($paginator->currentPage() < $paginator->lastPage() - 3)
                <li class="page-item disabled" aria-disabled="true"><span class="page-link">...</span></li>
            @endif
            @if($paginator->currentPage() < $paginator->lastPage() - 2)
                <li class="page-item" >
                    <button type="button" wire:click="setPage('{{$paginator->url($paginator->lastPage())}}')" class="page-link">{{ $paginator->lastPage() }}</button>
                </li>
            @endif
            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <button type="button"  wire:click="setPage('{{ $paginator->nextPageUrl() }}')" wire:loading.attr="disabled" class="page-link" rel="next" aria-label="Next »">›</button>
                </li>    
            @else
                <li class="page-item disabled" aria-disabled="true" aria-label="Next »">
                    <span class="page-link" aria-hidden="true"><a href="#"></a>›</span>
                </li>
            @endif
        </ul>
    </nav>
@endif