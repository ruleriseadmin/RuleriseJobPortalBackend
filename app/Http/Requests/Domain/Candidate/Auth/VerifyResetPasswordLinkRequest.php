<?php

namespace App\Http\Requests\Domain\Candidate\Auth;
use App\Http\Requests\BaseRequest;

class VerifyResetPasswordLinkRequest extends BaseRequest
{
    public function rules() : array
    {
        return [
            'token' => ['required'],
        ];
    }
}
