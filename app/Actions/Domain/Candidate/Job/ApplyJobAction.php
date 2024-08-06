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
    public function execute(User $user, EmployerJob $employerJob, string $applyVia, string $cvId = null) : ?CandidateJobApplication
    {
        $candidateJobApplication = $user->jobApplications()->where('job_id', $employerJob->id)->first();

        if ( $candidateJobApplication ) return $candidateJobApplication;

        $cvUrl = $cvId ? $user->cvs()->where('uuid', $cvId)->first()->id : null;

        DB::beginTransaction();
        try{
            $jobApplication = $user->jobApplications()->create([
                'uuid' => str()->uuid(),
                'job_id' => $employerJob->id,
                'applied_via' => $applyVia,
                'cv_url' => $cvUrl,
            ]);

            $jobApplication->setStatus(CandidateJobApplication::STATUSES['unsorted']);
            DB::commit();
        }catch(Exception $ex){
            DB::rollBack();
            Log::error("Error @ ApplyJobAction: " . $ex->getMessage());
            return null;
        }

        return $jobApplication;
    }
}
