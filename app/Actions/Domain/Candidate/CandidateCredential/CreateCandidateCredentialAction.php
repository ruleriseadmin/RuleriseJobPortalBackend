<?php

namespace App\Actions\Domain\Candidate\CandidateCredential;

use App\Models\Domain\Candidate\CandidateCredential;
use App\Models\Domain\Candidate\CandidateEducationHistory;
use App\Models\Domain\Candidate\User;
use App\Supports\HelperSupport;
use Exception;
use Illuminate\Support\Facades\Log;

class CreateCandidateCredentialAction
{
    public function execute(User $user, array $inputs): ?CandidateCredential
    {
        try{
            $inputs['uuid'] = str()->uuid();
            $credential = $user->credentials()->create(HelperSupport::camel_to_snake($inputs));
        }catch(Exception $ex){
            Log::error("Error @ CreateCandidateCredentialAction: " . $ex->getMessage());
            return null;
        }

        return $credential;
    }
}
