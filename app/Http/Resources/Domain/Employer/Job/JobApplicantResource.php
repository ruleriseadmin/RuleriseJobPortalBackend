<?php

namespace App\Http\Resources\Domain\Employer\Job;

use App\Http\Resources\Domain\Employer\Candidate\CandidateResource;
use App\Supports\HelperSupport;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JobApplicantResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $response = collect(parent::toArray($request))->except([
            'created_at',
            'updated_at',
            'deleted_at',
            'id',
            'user_id',
            'job_id',
            'hiring_stage',
        ]);

        $response = collect($response)->merge([
            'status' => $this->status(),
            'applicant_information' => new CandidateResource($this->applicant),
        ]);

        return HelperSupport::snake_to_camel($response->toArray());
    }
}
