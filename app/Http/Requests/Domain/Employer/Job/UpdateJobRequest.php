<?php

namespace App\Http\Requests\Domain\Employer\Job;
use App\Http\Requests\BaseRequest;

class UpdateJobRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'uuid' => ['required'],
            'title' => ['required'],
            'summary' => ['required'],
            'description' => ['required'],
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
}
