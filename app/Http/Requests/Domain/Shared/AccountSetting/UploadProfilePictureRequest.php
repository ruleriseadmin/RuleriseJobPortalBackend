<?php

namespace App\Http\Requests\Domain\Shared\AccountSetting;
use App\Http\Requests\BaseRequest;

class UploadProfilePictureRequest extends BaseRequest
{

    public function rules(): array
    {
        return [
            'imageInBase64' => ['required'],
            'imageExtension' => ['required'],
        ];
    }
}
