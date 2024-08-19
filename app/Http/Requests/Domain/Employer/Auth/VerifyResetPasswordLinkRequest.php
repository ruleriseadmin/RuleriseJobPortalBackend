<?php

namespace App\Http\Requests\Domain\Employer\Auth;
use App\Http\Requests\BaseRequest;

class VerifyResetPasswordLinkRequest extends BaseRequest
{
    public function rules() : array
    {
        return [
            'email' => ['required'],
            'token' => ['required'],
        ];
    }
}
