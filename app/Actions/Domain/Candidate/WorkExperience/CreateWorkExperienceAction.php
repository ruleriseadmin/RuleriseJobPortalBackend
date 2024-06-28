<?php

namespace App\Actions\Domain\Candidate\WorkExperience;

use App\Models\Domain\Candidate\CandidateWorkExperience;
use App\Models\Domain\Candidate\User;
use App\Supports\HelperSupport;
use Exception;
use Illuminate\Support\Facades\Log;

class CreateWorkExperienceAction
{
    public function execute(User $user, array $inputs): ?CandidateWorkExperience
    {
        try{
            $inputs['uuid'] = str()->uuid();
            $workExperience = $user->workExperiences()->create(HelperSupport::camel_to_snake($inputs));
        }catch(Exception $ex){
            Log::error("CreateWorkExperienceAction: " . $ex->getMessage());
            return null;
        }

        return $workExperience;
    }
}
