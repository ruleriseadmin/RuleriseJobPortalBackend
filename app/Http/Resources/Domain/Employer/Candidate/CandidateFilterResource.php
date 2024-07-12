<?php

namespace App\Http\Resources\Domain\Employer\Candidate;

use App\Supports\HelperSupport;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Domain\Candidate\Job\CandidateJobApplication;

class CandidateFilterResource extends JsonResource
{
    private int $perPage = 4;

    protected $applicationIds;

    public function toArray($request)
    {
        $this->applicationIds = collect($this->jobs->load('applicants')
            ->map(fn($job) => $job->applicants)
            ->flatten())
            ->map(fn($application) => $application->id);

        return [
            'totalCandidates' => $this->applicationIds->count(),
            'candidates' => $this->candidateResponse($this->allCandidates()),
        ];
    }

    public function allCandidates()
    {
       return CandidateJobApplication::where('id', $this->applicationIds)->paginate($this->perPage);
    }

    public function candidateResponse($paginatedCandidates)
    {
        $candidates = collect($paginatedCandidates->items())
            ->map(function($application){
                $applicant =  $application->applicant;
                $application['status'] = $application->status();
                $application['applied_at'] = $application->created_at;
                $application['job_applied'] = $application->job->title;
                $application['applicant_information'] = [
                    'fullName' => $applicant->getFullNameAttribute(),
                    'uuid' => $applicant->uuid,
                ];
                return HelperSupport::snake_to_camel(collect($application)->only([
                    'status',
                    'applicant_information',
                    'applied_at',
                    'job_applied'
                ])->toArray());
            });

        return [
            'items' => $candidates,
            'page' => $paginatedCandidates->currentPage(),
            'nextPage' =>  $paginatedCandidates->currentPage() + ($paginatedCandidates->hasMorePages() ? 1 : 0),
            'hasMorePages' => $paginatedCandidates->hasMorePages(),
        ];
    }
}
