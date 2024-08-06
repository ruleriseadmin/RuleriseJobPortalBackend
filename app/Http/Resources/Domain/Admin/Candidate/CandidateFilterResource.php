<?php

namespace App\Http\Resources\Domain\Admin\Candidate;

use App\Models\Domain\Candidate\User;
use App\Supports\HelperSupport;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CandidateFilterResource extends JsonResource
{
    private int $perPage = 10;

    private $candidates;

    public function toArray(Request $request): array
    {
        $call = match($this->filterBy ?? ''){
            'all' => 'allCandidates',
            default => 'allCandidates',
        };

        $this->$call();

        $candidates = $this->candidates;

        return [
            'totalCandidates' => $candidates->total(),
            'totalActiveCandidates' => 0,
            'totalInactiveCandidates' => 0,
            'totalBlacklistedCandidates' => 0,
            'candidates' => $this->candidateResponse(),
        ];
    }

    public function allCandidates()
    {
        $this->candidates = User::query()->orderByDesc('created_at')->paginate($this->perPage);
    }

    private function candidateResponse()
    {
        $paginatedCandidates = $this->candidates;

        $candidates = collect($paginatedCandidates->items())->map(function ($candidate) {
            return HelperSupport::snake_to_camel([
                'uuid' => $candidate->uuid,
                'full_name' => $candidate->full_name,
                'email' => $candidate->email,
                'created_at' =>$candidate->created_at->toDateTimeString(),
                'jobApplied' => $candidate->jobApplications()->count(),
                'status' => 'active', //@todo adjust candidate status
            ]);
        });

        return [
            'items' => $candidates,
            'page' => $paginatedCandidates->currentPage(),
            'nextPage' =>  $paginatedCandidates->currentPage() + ($paginatedCandidates->hasMorePages() ? 1 : 0),
            'hasMorePages' => $paginatedCandidates->hasMorePages(),
        ];
    }
}
