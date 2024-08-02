<?php

namespace App\Http\Requests\Domain\Employer\CVPackage;
use App\Http\Requests\BaseRequest;

class UpdateCVDownloadUsageRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'candidateId' => ['required', 'exists:users,uuid'],
        ];
    }
}
