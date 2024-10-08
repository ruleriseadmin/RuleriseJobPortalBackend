<?php

namespace App\Http\Requests\Domain\Candidate\Profile;

use App\Http\Requests\BaseRequest;
use App\Models\Domain\Candidate\User;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            //'email' => ['required', 'email'],
            'firstName' => ['required'],
            'lastName' => ['required'],
            'mobileNumber' => ['required', 'numeric'],
            'mobileCountryCode' => ['required'],
            'nationality' => ['required'],
            'locationProvince' => ['required'],
            'dob' => ['nullable', 'date'],
            //'gender' => [Rule::in(['male', 'female'])],
            'jobTitle' => ['nullable'],
            'skills' => ['nullable', 'array', 'max:10'],
        ];
    }

    public function withValidator(Validator $validator)
    {
        $validator->after(function ($validator){
            if ( $this->filled('email') && $this->input('email') !== auth()->user()->email ) {
                //User::where('email', $this->input('email'))->exists() ?: $validator->errors()->add('email', 'Email already exists');
            }
        });
    }
}
