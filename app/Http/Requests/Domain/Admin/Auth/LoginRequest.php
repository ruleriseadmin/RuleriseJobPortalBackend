<?php

namespace App\Http\Requests\Domain\Admin\Auth;
use App\Http\Requests\BaseRequest;

class LoginRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'email' => ['required', 'exists:admin_users,email'],
            'password' => ['required'],
        ];
    }
}
