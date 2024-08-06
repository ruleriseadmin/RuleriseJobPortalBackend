<?php

namespace App\Http\Requests\Domain\Admin\Candidate;

use Illuminate\Validation\Rule;
use App\Http\Requests\BaseRequest;

class CandidateFilterRequest extends BaseRequest
{
    public function rules() : array
    {
        return [
            'filterBy' => [Rule::in(['all', 'active', 'inactive', 'blacklisted'])],
        ];
    }
}
