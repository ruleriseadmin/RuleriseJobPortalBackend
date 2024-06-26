<?php

namespace App\Http\Requests\Domain\Employer\Auth;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rules\Password;

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
            // 'positionCompany',
            // 'officialEmail',
            // 'companyIndustry',
            // 'numberOfEmployees',
            // 'companyFounded',
            // 'stateCity',
            // 'address',
        ];
    }
}
