<?php

namespace App\Http\Requests\Domain\Shared\AccountSetting;
use App\Http\Requests\BaseRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Contracts\Validation\Validator;

class ChangePasswordRequest extends BaseRequest
{

    public function rules(): array
    {
        return [
            'currentPassword' => ['required'],
            'password' => ['required', Password::min(8)->letters()->numbers()],
            'passwordConfirmation' => ['required', 'same:password'],
        ];
    }

    public function withValidator(Validator $validator)
    {
        $validator->after(function ($validator){
            if ( $this->filled('currentPassword') ){
                Hash::check($this->input('currentPassword'), auth()->user()->getAuthPassword())
                    ? null : $validator->errors()->add('currentPassword', 'Current password does not match');
            }

            if ( $this->filled('password') ){
                ! Hash::check($this->input('password'), auth()->user()->getAuthPassword())
                    ? null : $validator->errors()->add('password', 'Password must no be the same as current password');
            }
        });
    }
}
