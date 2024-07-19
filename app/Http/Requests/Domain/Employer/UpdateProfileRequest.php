<?php

namespace App\Http\Requests\Domain\Employer;
use App\Http\Requests\BaseRequest;
use App\Models\Domain\Employer\Employer;
use Illuminate\Contracts\Validation\Validator;

class UpdateProfileRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'firstName' => ['required'],
            'lastName' => ['required'],
            'companyName' => ['required'],
            'positionTitle' => ['required'],
            'officialEmail' => ['required', 'email'],
            'companyIndustry' => ['required'],
            'numberOfEmployees' => ['required'],
            'companyFounded' => ['required'],
            'stateCity' => ['required'],
            'address' => ['required'],
        ];
    }

    public function withValidator(Validator $validator)
    {
        $validator->after(function ($validator){
            if ( $this->filled('companyName') ){
                $user = auth()->user();

                $employerAccess = $user->employerAccess()->first();

                $employer = $employerAccess->employer;

                Employer::where('company_name', '!=', $employer->company_name)
                    ->where('company_name', $this->input('companyName'))->exists()
                        ? $validator->errors()->add('companyName', 'Company name already exists')
                        : null;
            }
        });
    }
}
