<?php

namespace App\Http\Requests\Domain\Candidate\WorkExperience;

use App\Http\Requests\BaseRequest;

class UpdateCandidateWorkExperienceRequest extends BaseRequest
{
    public function rules() : array
    {
        return [
            'uuid' => ['required'],
            'roleTitle' => ['required'],
            'companyName' => ['required'],
            'startDate' => ['nullable', 'date'],
            'endDate' => ['nullable', 'date'],
        ];
    }
}
{
}
