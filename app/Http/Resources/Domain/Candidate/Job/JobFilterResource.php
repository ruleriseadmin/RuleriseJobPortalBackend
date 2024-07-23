<?php

namespace App\Http\Resources\Domain\Candidate\Job;

use Illuminate\Http\Request;
use App\Supports\HelperSupport;
use App\Models\Domain\Employer\EmployerJob;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class JobFilterResource extends JsonResource
{
    private int $perPage = 4;

    public function toArray(Request $request): array
    {
        $type = $this->type;

        $call = match($type){
            'new' => 'newJobs',
            'recommend' => 'recommendedJobs',
            'saved' => 'savedJobs',
            'applied' => 'appliedJobs',
            default => 'newJobs',
        };

        return $this->returnResponse($this->$call());
    }

    private function newJobs()
    {
        return EmployerJob::query()->paginate($this->perPage);
    }

    private function recommendedJobs(){}

    private function savedJobs()
    {
        $user = auth()->user();

        $jobIds = $user->savedJobs?->job_ids ?? [];

        return EmployerJob::whereIn('id', $jobIds)->paginate($this->perPage);
    }

    private function appliedJobs()
    {
        $jobIds = auth()->user()->jobApplications->map(fn($application) => $application->job_id);

        return EmployerJob::whereIn('id', $jobIds)->paginate($this->perPage);
    }

    private function returnResponse($paginatedJobs)
    {
        $jobs = collect($paginatedJobs->items())
                    ->map(function($job){
                    $user = auth()->user();

                    if ( ! $job->employer ) return null;

                    $job['employer_name'] = $job->employer->company_name;

                    // check if filter is applied then add extra details
                    if ( $this->type == 'applied' ){
                        $application = $user->jobApplications->where('job_id', $job->id)->first();
                        $job['status'] = $application->status();
                        $job['applied_at'] = $application->created_at;
                    }

                    // check if user has saved job
                    $job['saved'] = (bool) collect($user->savedJobs?->job_ids ?? [])->contains($job->id);

                    $job = HelperSupport::snake_to_camel(collect($job)->only([
                        'title',
                        'location',
                        'salary',
                        'employment_type',
                        'employer_name',
                        'uuid',
                        'status',
                        'applied_at',
                        'saved',
                    ])->toArray());

             return $job;
            })->filter();

         return [
            'jobs' => $jobs,
            'page' => $paginatedJobs->currentPage(),
            'nextPage' =>  $paginatedJobs->currentPage() + ($paginatedJobs->hasMorePages() ? 1 : 0),
            'hasMorePages' => $paginatedJobs->hasMorePages(),
         ];
    }
}
