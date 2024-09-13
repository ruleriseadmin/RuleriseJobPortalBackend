<?php

namespace App\Http\Requests\Domain\Candidate\Job;
use App\Http\Requests\BaseRequest;
use App\Models\Domain\Candidate\Job\CandidateJobApplication;
use Illuminate\Validation\Rule;

class JobApplicationRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'jobId' => ['required', 'exists:employer_jobs,uuid'],
            'applyVia' => ['required', Rule::in(CandidateJobApplication::APPLIED_VIA)],
            'cvId' => ['required_if:applyVia,custom_cv'], //, 'exists:c_v_documents,uuid'
        ];
    }
}
