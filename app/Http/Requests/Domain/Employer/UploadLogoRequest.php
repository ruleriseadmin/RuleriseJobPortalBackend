<?php

namespace App\Http\Requests\Domain\Employer;
use App\Http\Requests\BaseRequest;

class UploadLogoRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'imageInBase64' => ['required'],
            'imageExtension' => ['required'],
        ];
    }
}
