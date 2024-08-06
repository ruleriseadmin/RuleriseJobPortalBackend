<?php

namespace App\Http\Resources\Domain\Admin\Candidate;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Domain\Candidate\CVResource;
use App\Http\Resources\Domain\Candidate\ProfileResource;

class CandidateResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $response = collect([
            'totalApplication'=> $this->jobApplications()->count(),
            'totalHired' => 0,
            'status' => 'active',
            'created_at' => $this->created_at->toDateTimeString(),
        ]);

        $additionalInformation = match($this->filter_by){
            'profile_details' => $this->profileDetails(),
            'job_application' => $this->applications(),
            default => $this->profileDetails(),
        };

        $response = $response->merge($additionalInformation);

        return $response->toArray();
    }

    private function profileDetails(): array
    {
        return [
            'accountInformation' => new ProfileResource($this->resource),
            'cvInformation' => new CVResource($this->cv),
        ];
    }

    private function applications()
    {
        return [
            'jobApplications' => JobApplicationResource::collection($this->jobApplications),
        ];
    }

    private function moderation(){}
}
