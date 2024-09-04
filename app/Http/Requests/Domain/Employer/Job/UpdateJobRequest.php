<?php

namespace App\Http\Requests\Domain\Employer\Job;
use App\Http\Requests\BaseRequest;
use Illuminate\Contracts\Validation\Validator;

class UpdateJobRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'uuid' => ['required'],
            'title' => ['required'],
            'summary' => ['required'],
            'description' => ['required'],
            'emailToApply' => ['required_if:emailApply,true'],
            'categoryId' => ['required', 'exists:job_categories,uuid'],
            // 'jobType',
            // 'employmentType',
            // 'jobIndustry',
            // 'location',
            // 'yearsExperience',
            // 'salary',
            // 'easyApply',
            // 'emailApply',
            // 'requiredSkills',
        ];
    }

    public function withValidator(Validator $validator)
    {
        $validator->after(function ($validator){
            if ( $this->filled('salary') ){
                ! $this->filled('salaryPaymentMode')
                    ? $validator->errors()->add('salaryPaymentMode', 'Salary payment mode is expected.') : null;
            }
        });
    }
}
