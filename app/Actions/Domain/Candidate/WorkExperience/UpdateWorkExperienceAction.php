<?php

namespace App\Actions\Domain\Candidate\WorkExperience;

use App\Models\Domain\Candidate\CandidateWorkExperience;
use App\Supports\HelperSupport;
use Exception;
use Illuminate\Support\Facades\Log;

class UpdateWorkExperienceAction
{
    public function execute(CandidateWorkExperience $workExperience, array $inputs) : ?CandidateWorkExperience
    {
        try{
            $workExperience->update(HelperSupport::camel_to_snake($inputs));
        }catch(Exception $ex){
            Log::error("UpdateWorkExperienceAction: " . $ex->getMessage());
            return null;
        }

        $workExperience->refresh();

        return $workExperience;
    }
}
