<?php

namespace App\Http\Resources\Domain\Admin\Job;

use Illuminate\Http\Request;
use App\Supports\HelperSupport;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Domain\FrontPage\JobResource;

class CategoryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $response = collect(parent::toArray($request))->only([
            'uuid',
            'name',
            'subcategories',
            'svg_icon',
        ]);

        $response = $response->merge([
            'active' => (bool) $this->active,
            'openJobs' => $this->openJobs()->count(),
        ]);

        if ( $this->withJobs ?? false ){
            $response = $response->merge([
                'jobs' => JobResource::collection($this->openJobs),
            ]);
        }

        return HelperSupport::snake_to_camel($response->toArray());
    }
}
