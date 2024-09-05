<?php

namespace App\Http\Resources\Domain\Employer;

use Illuminate\Http\Request;
use App\Supports\HelperSupport;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployerJobResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $response = collect(parent::toArray($request))->except([
            'id',
            'created_at',
            'updated_at',
            'deleted_at',
            'employer_id',
            'category_id',
            'job_industry',
        ]);

        $response = collect($response)->merge([
            'jobIndustryName' => $this->job_industry,
            'jobIndustry' => $this->category?->uuid,
            'status' => $this->status,
            'createdAt' => $this->created_at->toDateTimeString(),
            'pools' => $this->employer->candidatePools->map(fn($pool) => $pool->only(['name', 'uuid'])),
            'numberOfApplications' => $this->applicants->count(),
            'logoUrl' => $this->employer->logo_url ? asset("storage/{$this->employer->logo_url}") : null,
        ]);

        return HelperSupport::snake_to_camel($response->toArray());
    }
}
