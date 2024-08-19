<?php

namespace App\Http\Requests\Domain\Employer\Auth;
use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rules\Password;

class ResetPasswordRequest extends BaseRequest
{
    public function rules() : array
    {
        return [
            'email' => ['required', 'exists:employer_users,email'],
            'token' => ['required'],
            'password' => ['required', Password::min(8)->letters()->numbers()],
            'passwordConfirmation' => ['required', 'same:password'],
        ];
    }
}
