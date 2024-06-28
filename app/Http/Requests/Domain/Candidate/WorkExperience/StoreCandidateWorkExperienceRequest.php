<?php

namespace App\Http\Requests\Domain\Candidate\WorkExperience;
use App\Http\Requests\BaseRequest;

class StoreCandidateWorkExperienceRequest extends BaseRequest
{
    public function rules() : array
    {
        return [
            'roleTitle' => ['required'],
            'companyName' => ['required'],
            'startDate' => ['nullable', 'date'],
            'endDate' => ['nullable', 'date'],
        ];
    }
}
