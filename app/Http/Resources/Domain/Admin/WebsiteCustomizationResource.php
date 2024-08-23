<?php

namespace App\Http\Resources\Domain\Admin;

use App\Supports\HelperSupport;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WebsiteCustomizationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $sections = [];

        foreach($this['sections'] as $section){
            if ($section['name'] == 'images') {
                //@todo handle images
                continue;
            }

            $sections [] = collect($section)->only([
                'name',
                'value',
            ]);
        }

        return [
            'type' => $this['type'],
            'sections' => $sections,
        ];
    }
}
