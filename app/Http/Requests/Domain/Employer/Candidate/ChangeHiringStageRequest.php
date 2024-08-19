<?php

namespace App\Http\Requests\Domain\Employer\Candidate;
use Illuminate\Validation\Rule;
use App\Http\Requests\BaseRequest;
use App\Models\Domain\Candidate\Job\CandidateJobApplication;

class ChangeHiringStageRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'hiringStage' => ['required', Rule::in(CandidateJobApplication::STATUSES)],
            'applicationIds' => ['required', 'array'],
            'applicationIds.*' => ['required', 'exists:candidate_job_applications,uuid']
        ];
    }
}
