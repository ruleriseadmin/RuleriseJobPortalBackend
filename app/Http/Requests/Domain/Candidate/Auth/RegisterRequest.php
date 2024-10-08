<?php

namespace App\Http\Requests\Domain\Candidate\Auth;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'email' => ['required', 'unique:users,email', 'email'],
            'password' => ['required', Password::min(8)->letters()->numbers()],
            'firstName' => ['required', 'string', 'min:2', 'max:255', 'regex:/^[a-zA-Z]+(?:[\s-][a-zA-Z]+)*$/'],
            'lastName' => ['required', 'string', 'min:2', 'max:255', 'regex:/^[a-zA-Z]+(?:[\s-][a-zA-Z]+)*$/'],
            'mobileNumber' => ['required', 'numeric'],
            'mobileCountryCode' => ['required'],
            'nationality' => ['required'],
            'locationProvince' => ['required'],
            'highestQualification' => ['required'],
            'yearOfExperience' => ['required'],
            'preferJobIndustry' => ['required'],
            'availableToWork' => ['required', 'boolean'],
            'skills' => ['nullable', 'array', 'max:10'],
        ];
    }
}
