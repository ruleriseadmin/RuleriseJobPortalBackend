<?php

namespace App\Http\Requests\Domain\Employer\Auth;

use App\Http\Requests\BaseRequest;
use App\Supports\HelperSupport;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Validation\Validator;

class RegisterRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'email' => ['required', 'unique:employer_users,email', 'email'],
            'password' => ['required', Password::min(8)->letters()->numbers()],
            'firstName' => ['required'],
            'lastName' => ['required'],
            'companyName' => ['required', 'unique:employers,company_name,except,id'],
            'positionTitle' => ['required'],
            'officialEmail' => ['required', 'email'],
            'companyIndustry' => ['required'],
            'numberOfEmployees' => ['required'],
            'companyFounded' => ['required'],
            'stateCity' => ['required'],
            'address' => ['required'],
            'logo' => ['required'],
            'logo.imageInBase64' => ['required'],
            'logo.imageExtension' => ['required'],
        ];
    }

    public function withValidator(Validator $validator)
    {
        $validator->after(function ($validator){
            //insert rule inside
            if ( $this->filled('logo.imageInBase64') ){
                HelperSupport::getBase64Size($this->input('logo.imageInBase64')) >= 5000 ? $validator->errors()->add('logo', 'Company logo size must be less than 5MB') : null;
            }
        });
    }
}
