<?php

namespace App\Traits\Domain\Shared;

use Illuminate\Pagination\LengthAwarePaginator;

trait PaginationTrait
{
    protected function getPaginationData($paginatedItems): array
    {
        $total = $paginatedItems->total();

        return [
            'items' => $paginatedItems->items(),
            'page' => $total == 0 ? 0 :  $paginatedItems->currentPage(),
            'nextPage' => $total == 0 ? 0 : $paginatedItems->currentPage() + ($paginatedItems->hasMorePages() ? 1 : 0),
            'hasMorePages' => $paginatedItems->hasMorePages(),
            'totalPages' => (int) ceil( $total / $this->perPage),
            'total' => $total,
        ];
    }

    protected function paginateFromCollection($collection, $perPage): array
    {
        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        $currentPageResults = $collection->slice(($currentPage - 1) * $perPage, $perPage)->values();

        $paginatedCollection = new LengthAwarePaginator($currentPageResults, $collection->count(), $perPage, $currentPage);

        return $this->getPaginationData($paginatedCollection);
    }
}
