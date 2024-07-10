<?php

namespace App\Http\Requests\Domain\Employer\Job;
use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class JobApplicantFilterRequest extends BaseRequest
{
    public function rules() : array
    {
        return [
            'filterBy' => [Rule::in(['rejected', 'offer_sent', 'shortlisted', 'unsorted', 'all'])],
        ];
    }
}
