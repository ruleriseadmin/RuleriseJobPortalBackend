<?php

namespace App\Actions\Domain\Candidate\Job;

use App\Models\Domain\Candidate\User;
use App\Models\Domain\Employer\EmployerJob;
use App\Models\Domain\Shared\ReportedJob;
use Exception;
use Illuminate\Support\Facades\Log;

class ReportJobAction
{
    public function execute(User $user, EmployerJob $job, array $input): ?ReportedJob
    {
        try{
            $reportedJob = $user->reportedJobs()->create([
                'job_id' => $job->id,
                'reason' => $input['reason']
            ]);
            return $reportedJob;
        }catch(Exception $ex){
            Log::error("Error @ ReportJobAction: " . $ex->getMessage());
            return null;
        }
    }
}
