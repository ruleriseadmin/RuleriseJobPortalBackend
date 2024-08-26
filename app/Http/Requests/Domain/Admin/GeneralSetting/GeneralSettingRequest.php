<?php

namespace App\Http\Requests\Domain\Admin\GeneralSetting;
use App\Http\Requests\BaseRequest;

class GeneralSettingRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'value' => ['required'],
        ];
    }
}
