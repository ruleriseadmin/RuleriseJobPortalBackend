<?php

namespace App\Http\Requests\Domain\Admin\WebsiteCustomization;
use App\Supports\HelperSupport;
use Illuminate\Validation\Rule;
use App\Http\Requests\BaseRequest;
use Illuminate\Contracts\Validation\Validator;
use App\Models\Domain\Shared\WebsiteCustomization;

class UploadImageWebsiteCustomizationRequest extends BaseRequest
{
    public function rules(): array
    {
        $types = collect(WebsiteCustomization::TYPES)->except(['contact'])->toArray();

        return [
            'type' => ['required', Rule::in($types)],
            'imageInBase64' => ['required'],
            'imageExtension' => ['required'],
            'imageBox' => ['required', Rule::in([1,2,3,4])],
        ];
    }

    public function withValidator(Validator $validator)
    {
        $validator->after(function ($validator){
            //insert rule inside
            if ( $this->filled('imageInBase64') ){
                HelperSupport::getBase64Size($this->input('imageInBase64')) >= 2 ? $validator->errors()->add('imageInBase64', 'Image size must be less than 2MB') : null;
            }
        });
    }
}
