<?php

namespace App\Http\Requests\Domain\Candidate\CandidateLanguage;
use App\Http\Requests\BaseRequest;

class StoreCandidateLanguageRequest extends BaseRequest
{
    public function rules() : array
    {
        return [
            'language' => ['required'],
            'proficiency' => ['required'],
        ];
    }
}
