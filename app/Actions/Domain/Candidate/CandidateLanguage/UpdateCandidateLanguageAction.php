<?php

namespace App\Actions\Domain\Candidate\CandidateLanguage;

use App\Supports\HelperSupport;
use Exception;
use Illuminate\Support\Facades\Log;
use App\Models\Domain\Candidate\CandidateLanguage;

class UpdateCandidateLanguageAction
{
    public function execute(CandidateLanguage $language, array $inputs) : ?CandidateLanguage
    {
        try{
            $language->update(HelperSupport::camel_to_snake($inputs));
        }catch(Exception $ex){
            Log::error("Error @ UpdateCandidateLanguageAction: " . $ex->getMessage());
            return null;
        }

        $language->refresh();

        return $language;
    }
}
