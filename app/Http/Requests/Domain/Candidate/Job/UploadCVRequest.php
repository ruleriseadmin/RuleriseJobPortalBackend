<?php

namespace App\Http\Requests\Domain\Candidate\Job;
use Illuminate\Validation\Rule;
use App\Http\Requests\BaseRequest;

class UploadCVRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'documentInBase64' => ['required'],
            'documentExtension' => ['required', Rule::in(['pdf', 'doc', 'docx'])],
        ];
    }
}
