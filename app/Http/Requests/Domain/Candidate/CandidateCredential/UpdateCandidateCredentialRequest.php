<?php

namespace App\Http\Requests\Domain\Candidate\CandidateCredential;

use App\Http\Requests\BaseRequest;

class UpdateCandidateCredentialRequest extends BaseRequest
{
    public function rules() : array
    {
        return [
            'uuid' => ['required'],
            'name' => ['required'],
            'type' => ['required'],
            'dateIssued' => ['nullable', 'date'],
        ];
    }
}
{
}
