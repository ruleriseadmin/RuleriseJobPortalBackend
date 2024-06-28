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
            'firstName' => ['required', 'alpha'],
            'lastName' => ['required', 'alpha'],
            'mobileNumber' => ['required', 'numeric'],
            'mobileCountryCode' => ['required'],
            'nationality' => ['required', 'alpha'],
            'locationProvince' => ['required'],
            'dob' => ['nullable', 'date'],
            'gender' => [Rule::in(['male', 'female'])],
            'jobTitle' => ['nullable', 'alpha'],
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
