<?php

namespace App\Actions\Domain\Candidate\EducationHistory;

use App\Models\Domain\Candidate\CandidateEducationHistory;
use App\Supports\HelperSupport;
use Exception;
use Illuminate\Support\Facades\Log;

class UpdateEducationHistoryAction
{
    public function execute(CandidateEducationHistory $educationHistory, array $inputs) : ?CandidateEducationHistory
    {
        try{
            $educationHistory->update(HelperSupport::camel_to_snake($inputs));
        }catch(Exception $ex){
            Log::error("Error @ UpdateEducationHistoryAction: " . $ex->getMessage());
            return null;
        }

        $educationHistory->refresh();

        return $educationHistory;
    }
}
