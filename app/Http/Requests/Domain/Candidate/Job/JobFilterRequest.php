<?php

namespace App\Http\Requests\Domain\Candidate\Job;
use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class JobFilterRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'type' => ['string', 'required', Rule::in(['new', 'recommend', 'saved', 'applied'])],
        ];
    }
}
