<?php

namespace App\Http\Requests\Domain\Admin\WebsiteCustomization;
use Illuminate\Validation\Rule;
use App\Http\Requests\BaseRequest;
use App\Models\Domain\Shared\WebsiteCustomization;

class StoreWebsiteCustomizationRequest extends BaseRequest
{
    public function rules(): array
    {
        $expectedSectionName = [];
        $minSections = 0;
        if ( $this->filled('type') && $this->input('type') != 'contact' ) {
            $trait = str($this->input('type'))->camel()->value;

            $traitExists = method_exists(WebsiteCustomization::class, $trait);

            $expectedSectionName = $traitExists ? WebsiteCustomization::$trait() : [];

            $minSections = $traitExists ? count(WebsiteCustomization::$trait()) - (collect(WebsiteCustomization::$trait())->has('images') ? 1 : 0 ): 0;
        }

        return [
            'type' => ['required', Rule::in(WebsiteCustomization::TYPES)],
            'sections' => ['required', 'array', "size: $minSections"],
            'sections.*.name' => ['required', Rule::in($expectedSectionName)],
            'sections.*.value' => ['required'],
        ];
    }
}
