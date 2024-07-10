<?php

namespace App\Http\Requests\Domain\Employer\Job;

use App\Http\Requests\BaseRequest;
use Illuminate\Contracts\Validation\Validator;

class AttachCandidatePoolRequest extends BaseRequest
{

    public function rules(): array
    {
        return [
            'candidatePoolIds' => ['required', 'array', 'min:1'],
            'candidatePoolIds.*' => ['required'],
            'candidateIds' => ['required', 'array', 'min:1'],
            'candidateIds.*' => ['required', 'exists:users,uuid'],
        ];
    }

    public function withValidator(Validator $validator)
    {
        $validator->after(function ($validator){
            //insert rule inside
            if ( $this->filled('candidatePoolIds') ){
                collect($this->input('candidatePoolIds'))->map(function ($item, $index) use($validator) {
                    $employer = auth()->user()->employerAccess()->first()->employer;

                    $employer->candidatePools()->where('uuid', $item)->exists() ? : $validator->errors()->add("candidatePoolIds.$index", 'Candidate Pool not found');
                });
            }
        });
    }
}
