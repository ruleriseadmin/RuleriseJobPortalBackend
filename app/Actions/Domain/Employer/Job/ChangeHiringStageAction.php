<?php

namespace App\Actions\Domain\Employer\Job;

use Exception;
use Illuminate\Support\Facades\Log;
use App\Models\Domain\Candidate\User;
use App\Models\Domain\Employer\Employer;
use App\Models\Domain\Employer\EmployerJob;
use App\Models\Domain\Candidate\Job\CandidateJobApplication;
use App\Actions\Domain\Employer\Notification\SendCandidateApplicationStatusEmail;

class ChangeHiringStageAction
{
    public function execute(EmployerJob $job, array $input): bool
    {
        try{
            foreach($input['candidateIds'] as $uuid){
            $user = User::where('uuid', $uuid)->first();

            $application = CandidateJobApplication::where('user_id', $user->id)
                ->where('job_id', $job->id)
                ->first();

            if ( ! $application ) continue;

            $application->setStatus($input['hiringStage']);

            (new SendCandidateApplicationStatusEmail)->execute($application, $input['hiringStage']);
        }
        }catch(Exception $ex){
            Log::error("Error @ ChangeHiringStageAction: " . $ex->getMessage());
            return false;
        }

        return true;
    }
}
