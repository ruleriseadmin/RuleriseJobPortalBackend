<?php

namespace App\Http\Resources\Domain\Admin\Candidate;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Domain\Candidate\CVResource;
use App\Http\Resources\Domain\Candidate\ProfileResource;

class CandidateResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $response = collect([
            'totalApplication'=> $this->jobApplications()->count(),
            'totalHired' => 0,
            'status' => 'active',
            'created_at' => $this->created_at->toDateTimeString(),
        ]);

        $additionalInformation = match($this->filter_by){
            'profile_details' => $this->profileDetails(),
            'job_application' => $this->applications(),
            'moderation' => $this->moderation(),
            default => $this->profileDetails(),
        };

        $response = $response->merge($additionalInformation);

        return $response->toArray();
    }

    private function profileDetails(): array
    {
        return [
            'accountInformation' => collect(new ProfileResource($this->resource) ?? null)->except([
                'filterBy',
            ]),
            'cvInformation' => CVResource::collection($this->cvs),
        ];
    }

    private function applications()
    {
        $paginatedApplications = $this->jobApplications()->orderByDesc('created_at')->paginate($this->perPage);

        $applications = collect($paginatedApplications->items())->map(function ($application) {
            if ( ! $application->job ) return null;
            $employer = $application->job->employer;

            return [
                'uuid' => $application->uuid,
                'title' => $application->job->title,
                'status' => $application->status(),
                'appliedAt' => $application->created_at->toDateTimeString(),
                'location' => $application->job->state_province,
                'employerInformation' => [
                    'name' => $employer->company_name,
                    'location' => $employer->state_city,
                    'logo' => $employer->logo_url ? asset("storage/$employer->logo_url") : null,
                ],
            ];
        })->filter();

        return [
            'jobApplications' => [
                'totalApplications' => $this->jobApplications->count(),
                'jobs' => [
                    'items' => $applications->toArray(),
                    'page' => $paginatedApplications->currentPage(),
                    'nextPage' =>  $paginatedApplications->currentPage() + ($paginatedApplications->hasMorePages() ? 1 : 0),
                    'hasMorePages' => $paginatedApplications->hasMorePages(),
                ],
            ],
        ];
    }

    private function moderation()
    {
        return [
            'isActive' => (bool) $this->active,
            'shadowBan' => [
                'applyJob' => $this->hasBan('ban_apply_job'),
            ],
        ];
    }
}
