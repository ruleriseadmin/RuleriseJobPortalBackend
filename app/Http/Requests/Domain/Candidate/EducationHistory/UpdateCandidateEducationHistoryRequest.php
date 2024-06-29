<?php

namespace App\Http\Requests\Domain\Candidate\EducationHistory;

use App\Http\Requests\BaseRequest;

class UpdateCandidateEducationHistoryRequest extends BaseRequest
{
    public function rules() : array
    {
        return [
            'uuid' => ['required'],
            'instituteName' => ['required'],
            'courseName' => ['required'],
            'startDate' => ['nullable', 'date'],
            'endDate' => ['nullable', 'date'],
        ];
    }
}
{
}
