<?php

namespace App\Http\Requests\Domain\Admin\UserManagement\User;
use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rules\Password;

class StoreUserRequest extends BaseRequest
{
    public function rules() : array
    {
        return [
            'firstName' => ['required'],
            'lastName' => ['required'],
            'email' => ['required', 'email', 'unique:admin_users,email'],
            'password' => ['required', Password::min(8)->letters()->numbers()],
            'role' => ['required'],
        ];
    }
}
