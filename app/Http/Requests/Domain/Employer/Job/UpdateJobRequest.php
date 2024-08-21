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
}
