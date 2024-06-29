<?php

namespace App\Actions\Domain\Candidate\CandidateCredential;

use App\Supports\HelperSupport;
use Exception;
use Illuminate\Support\Facades\Log;
use App\Models\Domain\Candidate\CandidateCredential;

class UpdateCandidateCredentialAction
{
    public function execute(CandidateCredential $credential, array $inputs) : ?CandidateCredential
    {
        try{
            $credential->update(HelperSupport::camel_to_snake($inputs));
        }catch(Exception $ex){
            Log::error("Error @ UpdateCandidateCredentialAction: " . $ex->getMessage());
            return null;
        }

        $credential->refresh();

        return $credential;
    }
}
