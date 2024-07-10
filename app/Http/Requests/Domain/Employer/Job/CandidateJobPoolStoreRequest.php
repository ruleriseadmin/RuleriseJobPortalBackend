<?php

namespace App\Http\Requests\Domain\Employer\Job;
use App\Http\Requests\BaseRequest;

class CandidateJobPoolStoreRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required'],
        ];
    }
}
