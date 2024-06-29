<?php

namespace App\Actions\Domain\Candidate\EducationHistory;

use App\Models\Domain\Candidate\CandidateEducationHistory;
use App\Models\Domain\Candidate\User;
use App\Supports\HelperSupport;
use Exception;
use Illuminate\Support\Facades\Log;

class CreateEducationHistoryAction
{
    public function execute(User $user, array $inputs): ?CandidateEducationHistory
    {
        try{
            $inputs['uuid'] = str()->uuid();
            $educationHistory = $user->educationHistories()->create(HelperSupport::camel_to_snake($inputs));
        }catch(Exception $ex){
            Log::error("CreateEducationHistoryAction: " . $ex->getMessage());
            return null;
        }

        return $educationHistory;
    }
}
