<?php

namespace App\Http\Resources\Domain\Employer;

use Illuminate\Http\Request;
use App\Models\Domain\Employer\EmployerJob;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployerJobFilterResource extends JsonResource
{
    private int $perPage = 10;

    public function toArray(Request $request): array
    {
        $jobs = match($this->filterBy){
            'open' => $this->paginateOpenJobs(),
            'close' => $this->paginateCloseJobs(),
            'draft' => $this->paginateDraftJobs(),
            default => $this->allJobs(),
        };

        return [
            'totalJobs' => $this->jobs()->count(),
            'totalOpenJobs' => $this->openJobs()->count(),
            'totalClosedJobs' => $this->closedJobs()->count(),
            'totalDraftJobs' => $this->draftJobs()->count(),
            'jobs' => $this->jobResponse($jobs),
        ];
    }

    private function allJobs()
    {
        return $this->jobs()->orderByDesc('created_at')->paginate($this->perPage);
    }

    private function paginateOpenJobs()
    {
        return $this->openJobs()->orderByDesc('created_at')->paginate($this->perPage);
    }

    private function paginateCloseJobs()
    {
        return $this->closedJobs()->orderByDesc('created_at')->paginate($this->perPage);
    }

    private function paginateDraftJobs()
    {
        return $this->draftJobs()->orderByDesc('created_at')->paginate($this->perPage);
    }

    private function jobResponse($paginatedJobs)
    {
        $jobs = EmployerJobResource::collection($paginatedJobs->items());

        return [
            'items' => $jobs,
            'page' => $paginatedJobs->currentPage(),
            'nextPage' =>  $paginatedJobs->currentPage() + ($paginatedJobs->hasMorePages() ? 1 : 0),
            'hasMorePages' => $paginatedJobs->hasMorePages(),
        ];
    }
}
