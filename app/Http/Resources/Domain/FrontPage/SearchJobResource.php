<?php

namespace App\Http\Resources\Domain\FrontPage;

use Illuminate\Http\Request;
use App\Supports\HelperSupport;
use App\Models\Domain\Admin\GeneralSetting;
use App\Models\Domain\Employer\EmployerJob;
use Illuminate\Http\Resources\Json\JsonResource;

class SearchJobResource extends JsonResource
{
    private int $perPage = 10;

    public function toArray(Request $request): array
    {
        $title = $this->title ?? null;

        $jobIndustry = $this->job_industry ?? null;

        $experienceLevel = $this->experience_level ?? null;

        $location = $this->location ?? null;

        //$stateCity = $this->state_city ?? null;

        $datePosted = $this->date_posted ?? '';

        $jobs = EmployerJob::query()
        ->orderByDesc('created_at')
        ->when($title, function($query, $title) {
            $query->where('title', 'LIKE', '%' . $title . '%');
        })
        ->when($jobIndustry, function($query, $jobIndustry) {
            $query->where('job_industry', 'LIKE', '%' . $jobIndustry . '%');
        })
        ->when($experienceLevel, function($query, $experienceLevel) {
            $query->where('years_experience', 'LIKE', '%' . $experienceLevel . '%');
        })
        ->when($location, function($query, $location) {
            $query->where('location', 'LIKE', '%' . $location . '%');
        })
        ->when($datePosted, function($query, $datePosted) {
            $query->whereDate('created_at', 'LIKE', '%' . $datePosted . '%');
        })
        ->paginate($this->perPage);

        return $this->returnResponse($jobs);
    }

    private function returnResponse($paginatedJobs)
    {
        $jobs = collect($paginatedJobs->items())
                    ->map(function($job){
                    $user = auth()->user();

                    if ( ! $job->employer ) return null;

                    $job['employer_name'] = $job->employer->company_name;

                    $job['employer_logo'] = $job->employer->logo_url ? asset("storage/{$job->employer->logo_url}") : null;

                    $job['job_status'] = $job->status;

                    $job['currency'] = GeneralSetting::defaultCurrency();

                    // check if filter is applied then add extra details
                    if ( $user ){
                        if ( $this->type == 'applied' ){
                            $application = $user->jobApplications->where('job_id', $job->id)->first();
                            $job['status'] = $application->status();
                            $job['applied_at'] = $application->created_at->toDateTimeString();
                        }

                        // check if user has saved job
                        $job['saved'] = (bool) collect($user->savedJobs?->job_ids ?? [])->contains($job->id);
                    }

                    $job['createdAt'] = $job->created_at->toDateTimeString();

                    $job = HelperSupport::snake_to_camel(collect($job)->only([
                        'title',
                        'location',
                        'salary',
                        'salary_payment_mode',
                        'currency',
                        'employment_type',
                        'employer_name',
                        'employer_logo',
                        'uuid',
                        'status',
                        'applied_at',
                        'saved',
                        'createdAt',
                        'job_status',
                    ])->toArray());

             return $job;
            })->filter()->values();

         return [
            'jobs' => $jobs,
            'page' => $paginatedJobs->currentPage(),
            'nextPage' =>  $paginatedJobs->currentPage() + ($paginatedJobs->hasMorePages() ? 1 : 0),
            'hasMorePages' => $paginatedJobs->hasMorePages(),
            'totalJobs' => $paginatedJobs->total(),
         ];
    }
}
