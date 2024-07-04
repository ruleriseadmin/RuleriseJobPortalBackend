<?php

namespace App\Actions\Domain\Candidate\Job;

use Exception;
use Illuminate\Support\Facades\Log;
use App\Models\Domain\Candidate\User;
use App\Models\Domain\Employer\EmployerJob;
use Illuminate\Support\Arr;

class SaveAndUnsafeJobAction
{
    public function execute(User $user, EmployerJob $job)
    {
        try{
            $savedJobs = $user->savedJobs()->exists() ? $user->savedJobs->job_ids : [];

            $savedJobs = collect($savedJobs)->contains($job->id)
                ? collect($savedJobs)->filter(fn($jobId) => $jobId != $job->id) // remove job id if exists.
                : array_merge($savedJobs, [$job->id]); // add jobs id if not exists

            $user->savedJobs()->exists()
                ? $user->savedJobs()->update(['job_ids' => $savedJobs])
                : $user->savedJobs()->create(['job_ids' => [$job->id]]);
        }catch(Exception $ex){
            Log::error("Error @ SaveAndUnsafeJobAction: " . $ex->getMessage());
            return false;
        }

        $user->refresh();

        return true;
    }
}
