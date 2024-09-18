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
            'cvUrl' => $this->cv ? [
                'uploadedAt' => $this->cv->created_at->toDateTimeString(),
                'url' => asset("storage/{$this->cv->cv_document_url}"),
            ] : null,
        ]);

        return HelperSupport::snake_to_camel($response->toArray());
    }
}
