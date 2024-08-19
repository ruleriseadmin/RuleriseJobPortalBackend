<?php

namespace App\Http\Requests\Domain\Candidate\Auth;
use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rules\Password;

class ResetPasswordRequest extends BaseRequest
{
    public function rules() : array
    {
        return [
            'email' => ['required', 'exists:users,email'],
            'token' => ['required'],
            'password' => ['required', Password::min(8)->letters()->numbers()],
            'passwordConfirmation' => ['required', 'same:password'],
        ];
    }
}
