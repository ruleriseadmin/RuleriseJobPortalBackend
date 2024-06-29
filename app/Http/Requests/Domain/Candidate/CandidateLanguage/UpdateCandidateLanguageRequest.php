<?php

namespace App\Http\Requests\Domain\Candidate\CandidateLanguage;

use App\Http\Requests\BaseRequest;

class UpdateCandidateLanguageRequest extends BaseRequest
{
    public function rules() : array
    {
        return [
            'uuid' => ['required'],
            'language' => ['required'],
            'proficiency' => ['required'],
        ];
    }
}
{
}
