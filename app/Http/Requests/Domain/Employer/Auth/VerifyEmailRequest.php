<?php

namespace App\Http\Requests\Domain\Employer\Auth;
use App\Http\Requests\BaseRequest;

class VerifyEmailRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'token' => ['required', 'string'],
        ];
    }
}
