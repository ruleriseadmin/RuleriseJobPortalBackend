<?php

namespace App\Http\Requests\Domain\Employer\Job;
use App\Http\Requests\BaseRequest;
use App\Models\Domain\Candidate\Job\CandidateJobApplication;
use Illuminate\Validation\Rule;

class ChangeHiringStageRequest extends BaseRequest
{

    public function rules(): array
    {
        return [
            'candidateIds' => ['required', 'array', 'min:1'],
            'candidateIds.*' => ['required', 'exists:users,uuid'],
            'hiringStage' => ['required', Rule::in(CandidateJobApplication::STATUSES)],
            'jobId' => ['required'],
        ];
    }
}
