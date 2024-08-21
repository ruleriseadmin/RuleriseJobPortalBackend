<?php

namespace App\Http\Resources\Domain\Admin\Job;

use App\Supports\HelperSupport;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $response = collect(parent::toArray($request))->only([
            'uuid',
            'name',
            'subcategories',
        ]);

        $response = $response->merge([
            'openJobs' => $this->openJobs()->count(),
        ]);

        return HelperSupport::snake_to_camel($response->toArray());
    }
}
