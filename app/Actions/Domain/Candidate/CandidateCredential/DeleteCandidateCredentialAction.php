<?php

namespace App\Actions\Domain\Candidate\CandidateCredential;

use App\Models\Domain\Candidate\CandidateCredential;
use Exception;
use Illuminate\Support\Facades\Log;

class DeleteCandidateCredentialAction
{
    public function execute(CandidateCredential $credential): bool
    {
        try{
            $action = $credential->delete();
        }catch(Exception $ex){
            Log::error("Error @ DeleteCandidateCredentialAction: " . $ex->getMessage());
            return false;
        }

        return $action;
    }
}
