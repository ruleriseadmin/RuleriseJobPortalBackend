<?php

namespace App\Http\Requests\Domain\Employer\User;
use App\Http\Requests\BaseRequest;
use App\Models\Domain\Admin\AdminUser;
use App\Models\Domain\Employer\EmployerUser;
use Illuminate\Validation\Rules\Password;
use Illuminate\Contracts\Validation\Validator;

class UpdateUserRequest extends BaseRequest
{
    public function rules() : array
    {
        return [
            'firstName' => ['required'],
            'lastName' => ['required'],
            'email' => ['nullable', 'email'],
            'password' => ['nullable', Password::min(8)->letters()->numbers()],
            'role' => ['required'],
            'userId' => ['required', 'exists:employer_users,uuid']
        ];
    }

    public function withValidator(Validator $validator)
    {
        // $validator->after(function ($validator){
        //     //insert rule inside
        //     if ( $this->filled('email') && $this->filled('userId') ){
        //         $user = EmployerUser::whereUuid($this->input('userId'));

        //         if ( $user->email == $this->input('email') ) return;

        //         ! EmployerUser::where('email', $this->input('email'))->exists()?:$validator->errors()->add('email', 'Email already exists');
        //     }
        // });
    }
}
