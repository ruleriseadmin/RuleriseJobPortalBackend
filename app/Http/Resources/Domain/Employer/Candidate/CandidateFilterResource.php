<?php

namespace App\Http\Resources\Domain\Employer\Candidate;

use App\Supports\HelperSupport;
use App\Traits\Domain\Shared\PaginationTrait;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Domain\Candidate\Job\CandidateJobApplication;

class CandidateFilterResource extends JsonResource
{
    use PaginationTrait;

    private int $perPage = 10;

    protected $applicationIds;

    public function toArray($request)
    {
        $this->applicationIds = $this->jobs->load('applicants')
            ->flatMap(function ($job) {
                return $job->applicants;
            })
            ->pluck('id')
            ->toArray();

        return [
            'totalCandidates' => count($this->applicationIds),
            'candidates' => $this->candidateResponse($this->allCandidates()),
        ];
    }

    public function allCandidates()
    {
       return CandidateJobApplication::whereIn('id', $this->applicationIds)->orderByDesc('created_at')->paginate($this->perPage);
    }

    public function candidateResponse($paginatedCandidates)
    {
        $candidates = collect($paginatedCandidates->items())
            ->map(function($application){
                $applicant =  $application->applicant;
                $application['status'] = $application->status();
                $application['applied_at'] = $application->created_at->toDateTimeString();
                $application['job_applied'] = $application->job->title;
                $application['applied_via'] = $application->applied_via;
                $application['cvUrl'] = $application->cv ? asset("storage/{$application->cv->cv_document_url}") : null;
                $application['applicant_information'] = [
                    'fullName' => $applicant->getFullNameAttribute(),
                    'uuid' => $applicant->uuid,
                    'email' => $applicant->email,
                ];
                return HelperSupport::snake_to_camel(collect($application)->only([
                    'status',
                    'applicant_information',
                    'applied_at',
                    'job_applied',
                    'uuid',
                    'applied_via',
                    'cvUrl',
                ])->toArray());
            });

        return $this->paginateFromCollection( $candidates, $this->perPage);

        return [
            'items' => $candidates,
            'page' => $paginatedCandidates->currentPage(),
            'nextPage' =>  $paginatedCandidates->currentPage() + ($paginatedCandidates->hasMorePages() ? 1 : 0),
            'hasMorePages' => $paginatedCandidates->hasMorePages(),
        ];
    }
}
