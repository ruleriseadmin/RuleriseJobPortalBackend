<?php

namespace App\Actions\Domain\Candidate\CandidateLanguage;

use App\Models\Domain\Candidate\CandidateLanguage;
use App\Models\Domain\Candidate\User;
use App\Supports\HelperSupport;
use Exception;
use Illuminate\Support\Facades\Log;

class CreateCandidateLanguageAction
{
    public function execute(User $user, array $inputs): ?CandidateLanguage
    {
        try{
            $inputs['uuid'] = str()->uuid();
            $language = $user->languages()->create(HelperSupport::camel_to_snake($inputs));
        }catch(Exception $ex){
            Log::error("Error @ CreateCandidateLanguageAction: " . $ex->getMessage());
            return null;
        }

        return $language;
    }
}
