<?php

namespace App\Actions\Domain\Candidate\WorkExperience;

use App\Models\Domain\Candidate\CandidateWorkExperience;
use Exception;
use Illuminate\Support\Facades\Log;

class DeleteWorkExperienceAction
{
    public function execute(CandidateWorkExperience $workExperience): bool
    {
        try{
            $action = $workExperience->delete();
        }catch(Exception $ex){
            Log::error("DeleteWorkExperienceAction: " . $ex->getMessage());
            return false;
        }

        return $action;
    }
}
