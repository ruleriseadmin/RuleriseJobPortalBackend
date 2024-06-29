<?php

namespace App\Actions\Domain\Candidate\EducationHistory;

use App\Models\Domain\Candidate\CandidateEducationHistory;
use Exception;
use Illuminate\Support\Facades\Log;

class DeleteEducationHistoryAction
{
    public function execute(CandidateEducationHistory $educationHistory): bool
    {
        try{
            $action = $educationHistory->delete();
        }catch(Exception $ex){
            Log::error("Error @ DeleteEducationHistoryAction: " . $ex->getMessage());
            return false;
        }

        return $action;
    }
}
