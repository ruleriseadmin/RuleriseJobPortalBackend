<?php

namespace App\Http\Requests\Domain\Candidate\CandidateCredential;
use App\Http\Requests\BaseRequest;

class StoreCandidateCredentialRequest extends BaseRequest
{
    public function rules() : array
    {
        return [
            'name' => ['required'],
            'type' => ['required'],
            'dateIssued' => ['nullable', 'date'],
        ];
    }
}
