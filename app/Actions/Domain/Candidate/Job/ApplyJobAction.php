<?php

namespace App\Actions\Domain\Candidate\Job;

use App\Models\Domain\Candidate\Job\CandidateJobApplication;
use App\Models\Domain\Candidate\User;
use App\Models\Domain\Employer\EmployerJob;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ApplyJobAction
{
    public function execute(User $user, EmployerJob $employerJob, string $applyVia, string $cvUrl = null) : ?CandidateJobApplication
    {
        DB::beginTransaction();
        try{
            $jobApplication = $user->jobApplications()->create([
                'uuid' => str()->uuid(),
                'job_id' => $employerJob->id,
                'applied_via' => $applyVia,
                'cv_url',
            ]);

            $jobApplication->setStatus(CandidateJobApplication::STATUSES['applied']);
            DB::commit();
        }catch(Exception $ex){
            DB::rollBack();
            Log::error("Error @ ApplyJobAction: " . $ex->getMessage());
            return null;
        }

        return $jobApplication;
    }
}
