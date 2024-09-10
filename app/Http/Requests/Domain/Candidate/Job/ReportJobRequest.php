<?php

namespace App\Http\Requests\Domain\Candidate\Job;
use App\Http\Requests\BaseRequest;

class ReportJobRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'reason' => ['required'],
        ];
    }
}
