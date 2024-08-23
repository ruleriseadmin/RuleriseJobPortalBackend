<?php

namespace App\Http\Requests\Domain\Admin\WebsiteCustomization;
use App\Http\Requests\BaseRequest;

class AddNewContactRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'title' => ['required'],
            'link' => ['required'],
        ];
    }
}
