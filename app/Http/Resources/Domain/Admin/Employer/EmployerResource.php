<?php

namespace App\Http\Resources\Domain\Admin\Employer;

use App\Http\Resources\Domain\Employer\ProfileResource;
use App\Models\Domain\Candidate\Job\CandidateJobApplication;
use App\Supports\HelperSupport;
use App\Traits\Domain\Shared\PaginationTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class EmployerResource extends JsonResource
{
    use PaginationTrait;

    private int $perPage = 10;

    public function toArray(Request $request): array
    {
        $response = collect([
            'totalJobs' => $this->jobs->count(),
            'totalHired' => 0,
            'status' => 'active',
            'created_at' => $this->created_at->toDateTimeString(),
        ]);

        $additionalInformation = match($this->filter_by){
            'profile_details' => $this->profileDetails(),
            'moderation' => $this->moderation(),
            'transactions' => $this->transactions(),
            'job_listing' => $this->jobListings(),
            'candidate_hired' => $this->candidateHired(),
            default => $this->profileDetails(),
        };

        $response = $response->merge($additionalInformation);

        return HelperSupport::snake_to_camel($response->toArray());
    }

    private function profileDetails(): array
    {
        $user = $this->users()->first(); //to change for multiple users

        $employer = $this->resource;

        $employer['logoUrl'] = $employer->logo_url ? asset("storage/$employer->logo_url") : null;

        return [
            'personContact' => [
                'firstName' => $user->pivot->first_name,
                'lastName' => $user->pivot->last_name,
                'positionTitle' => $user->pivot->position_title,
                'email' => $user->email,
            ],
            'companyInformation' => HelperSupport::snake_to_camel(collect($employer)->except([
                'created_at',
                'updated_at',
                'deleted_at',
                'id',
                'jobs',
                'filter_by',
                'logo_url',
            ])->toArray()),
        ];
    }

    private function transactions(): array
    {
       // return $this->subscriptionTransactions->toArray();
        $transactions = $this->subscriptionTransactions->map(fn($transaction) => [
            'reference' => $transaction->reference,
            'amount' => $transaction->amount,
            'currency' => $transaction->currency,
            'status' => $transaction->status,
            'createdAt' => $transaction->created_at->toDateTimeString(),
            'quota' => $transaction->subscriptionPlan?->quota,
        ]);

        return [
            'transactions' => $this->paginateFromCollection($transactions, 10)
        ];
    }

    private function jobListings()
    {
        $paginatedJobs = $this->jobs()->paginate($this->perPage);

        if ( $this->sortJobBy ?? false ){
            $sortJobBy = strtolower($this->sortJobBy) == 'open'
                ? $this->openJobs()
                : $this->closedJobs();

            $paginatedJobs = $sortJobBy->paginate($this->perPage);
        }

        $jobs = collect($paginatedJobs->items())->map(function ($job) {
            $job['createdAt'] = $job->created_at->toDateTimeString();

            $job['status'] = $job->active ? 'open' : 'close';

            $job['totalApplicants'] = $job->applicants->count();

            return HelperSupport::snake_to_camel(collect($job)->only([
                'title',
                'uuid',
                'status',
                'location',
                'job_type',
                'createdAt',
                'totalApplicants',
            ])->toArray());
        });

        return [
            'totalJobs' => $this->jobs->count(),
            'totalOpenJobs' => $this->openJobs->count(),
            'totalClosedJobs' => $this->closedJobs->count(),
            'jobs' => [
                'items' => $jobs->toArray(),
                'page' => $paginatedJobs->currentPage(),
                'nextPage' =>  $paginatedJobs->currentPage() + ($paginatedJobs->hasMorePages() ? 1 : 0),
                'hasMorePages' => $paginatedJobs->hasMorePages(),
            ],
        ];
    }

    private function candidateHired()
    {
        $status = CandidateJobApplication::STATUSES['offer_sent'];

        // The checks the get candidate job application by getting the job ids and checking the status.
        $paginatedApplications = CandidateJobApplication::whereIn('job_id', $this->jobs->pluck('id'))
            ->whereRaw("json_extract(hiring_stage, '$[' || (json_array_length(hiring_stage) - 1) || '].status') = ?", [$status])
            ->paginate($this->perPage);

        $applications = collect($paginatedApplications->items())->map(function($application){
            return [
                'hiredAt' => Carbon::parse($application->latestStatus()->created_at)->toDateTimeString(),
                'name' => $application->applicant->full_name,
                'jobTitle' => $application->job->title,
                'location' => $application->job->location, //change if it's for applicant location
            ];
        });

        return [
            'candidates' => [
                'items' => $applications->toArray(),
                'page' => $paginatedApplications->currentPage(),
                'nextPage' =>  $paginatedApplications->currentPage() + ($paginatedApplications->hasMorePages() ? 1 : 0),
                'hasMorePages' => $paginatedApplications->hasMorePages(),
            ],
        ];
    }

    private function moderation()
    {
        return [
            'isActive' => (bool) $this->active,
            'shadowBan' => [
                'jobPosting' => $this->hasBan('ban_post_job'),
            ],
        ];
    }
}
