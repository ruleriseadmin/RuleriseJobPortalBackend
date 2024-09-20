<?php

namespace App\Http\Requests\Domain\Candidate\Auth;

use App\Http\Requests\BaseRequest;

class LoginRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'email' => ['required', ], //'exists:users,email'
            'password' => ['required'],
        ];
    }
}
