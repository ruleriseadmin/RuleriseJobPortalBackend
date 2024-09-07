<?php

namespace App\Http\Resources\Domain\Candidate\Job;

use Illuminate\Http\Request;
use App\Supports\HelperSupport;
use App\Models\Domain\Admin\GeneralSetting;
use App\Models\Domain\Employer\EmployerJob;
use Illuminate\Http\Resources\Json\JsonResource;

class SimilarJobResource extends JsonResource
{
    private int $perPage = 4;

    public function toArray(Request $request): array
    {
        $similarJobs = EmployerJob::where('active', 1)
        //->orWhere('title', 'LIKE', '%' . $this->title . '%')
        ->where('job_industry', $this->job_industry)
        ->where(function($query) {
            $query->where('job_type', $this->job_type)
                  ->orWhere('employment_type', $this->employment_type)
                  ->orWhere('job_level', $this->job_level)
                  ->orWhere('location', $this->location)
                  ->orWhere('years_experience', $this->years_experience)
                  ->orWhere('salary', $this->salary);
                 // ->orWhere('easy_apply', $this->easy_apply);
                  foreach ($this->required_skills ?? [] as $skill) {
                    $query->orWhereRaw('exists (select 1 from json_each(required_skills) where json_each.value = ?)', [$skill]);
                }
        })->where('uuid', '!=', $this->uuid)->paginate($this->perPage);

        return $this->returnResponse($similarJobs);
    }

    private function returnResponse($paginatedJobs)
    {
        $jobs = collect($paginatedJobs->items())
                    ->map(function($job){
                    $user = auth()->user();

                    if ( ! $job->employer ) return null;

                    $job['employer_name'] = $job->employer->company_name;
                    $job['employer_logo'] = $job->employer->logo_url ? asset("storage/{$job->employer->logo_url}") : null;

                    // check if filter is applied then add extra details
                    if ( $this->type == 'applied' ){
                        $application = $user->jobApplications->where('job_id', $job->id)->first();
                        $job['status'] = $application->status();
                        $job['applied_at'] = $application->created_at->toDateTimeString();
                    }

                    // check if user has saved job
                    $job['saved'] = (bool) collect($user->savedJobs?->job_ids ?? [])->contains($job->id);

                    $job['job_status'] = $job->status;

                    $job['currency'] = GeneralSetting::defaultCurrency();

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
         ];
    }
}
