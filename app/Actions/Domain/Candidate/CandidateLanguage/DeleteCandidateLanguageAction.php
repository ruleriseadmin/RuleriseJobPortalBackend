<?php

namespace App\Actions\Domain\Candidate\CandidateLanguage;

use App\Models\Domain\Candidate\CandidateLanguage;
use Exception;
use Illuminate\Support\Facades\Log;

class DeleteCandidateLanguageAction
{
    public function execute(CandidateLanguage $language): bool
    {
        try{
            $action = $language->delete();
        }catch(Exception $ex){
            Log::error("Error @ DeleteCandidateLanguageAction: " . $ex->getMessage());
            return false;
        }

        return $action;
    }
}
