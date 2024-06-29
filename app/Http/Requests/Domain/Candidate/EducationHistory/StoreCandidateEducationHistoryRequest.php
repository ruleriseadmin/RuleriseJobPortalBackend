<?php

namespace App\Http\Requests\Domain\Candidate\EducationHistory;
use App\Http\Requests\BaseRequest;

class StoreCandidateEducationHistoryRequest extends BaseRequest
{
    public function rules() : array
    {
        return [
            'instituteName' => ['required'],
            'courseName' => ['required'],
            'startDate' => ['nullable', 'date'],
            'endDate' => ['nullable', 'date'],
        ];
    }
}
