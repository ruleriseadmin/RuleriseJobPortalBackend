<?php

namespace App\Actions\Domain\Employer\Candidate;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Domain\Candidate\Job\CandidateJobApplication;
use App\Actions\Domain\Employer\Notification\SendCandidateApplicationStatusEmail;

class ChangeHiringStageAction
{
    public function execute(array $inputs)
    {
        DB::beginTransaction();
        try{
            foreach($inputs['applicationIds'] as $uuid){
                $application = CandidateJobApplication::whereUuid($uuid);

                if ( ! $application ) continue;

                $application->setStatus($inputs['hiringStage']);

                (new SendCandidateApplicationStatusEmail)->execute($application, $inputs['hiringStage']);
            }
            DB::commit();
        }catch(Exception $ex){
            DB::rollBack();
            Log::error("Error @ ChangeHiringStageAction for manage candidate: " . $ex->getMessage());
            return false;
        }

        return true;
    }
}
