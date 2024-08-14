<?php

namespace App\Http\Resources\Domain\FrontPage\Employer;

use App\Http\Resources\Domain\FrontPage\JobResource;
use Illuminate\Http\Request;
use App\Supports\HelperSupport;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployerResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $response = collect(parent::toArray($request))->except([
            'id',
            'created_at',
            'updated_at',
            'deleted_at',
            'active',
        ]);

        $response = collect($response)->merge([
            'open_jobs' => JobResource::collection($this->openJobs),
            'logo' => null,
        ]);

        return HelperSupport::snake_to_camel($response->toArray());
    }
}
