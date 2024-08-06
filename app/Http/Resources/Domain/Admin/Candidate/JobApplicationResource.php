<?php

namespace App\Http\Resources\Domain\Admin\Candidate;

use App\Supports\HelperSupport;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JobApplicationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $response = collect(parent::toArray($request))->only([
            'uuid',
        ]);

        $employer = $this->job->employer;

        return HelperSupport::snake_to_camel([
            'uuid' => $this->uuid,
            'title' => $this->job->title,
            'status' => $this->status(),
            'applied_at' => $this->created_at->toDateTimeString(),
            'employerInformation' => [
                'name' => $employer->company_name,
                'location' => $employer->state_city,
            ],
        ]);
    }
}
