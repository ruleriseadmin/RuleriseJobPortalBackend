<?php

namespace App\Http\Resources\Domain\Candidate;

use Illuminate\Http\Request;
use App\Supports\HelperSupport;
use App\Models\Domain\Admin\GeneralSetting;
use Illuminate\Http\Resources\Json\JsonResource;

class JobResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $user = auth()->user();

        $response = collect(parent::toArray($request))->except([
            'id',
            'created_at',
            'updated_at',
            'deleted_at',
            'employer_id'
        ]);

        $response = collect($response)->merge([
            'created_at' => $this->created_at->toDateTimeString(),
            'saved' => (bool) collect($user->savedJobs?->job_ids ?? [])->contains($this->id),
            'employer_name' => $this->employer->company_name,
            'employer_logo' => $this->employer->logo_url ? asset("storage/{$this->employer->logo_url}") : null,
            'employer_id' => $this->employer->uuid,
            'currency' => GeneralSetting::defaultCurrency(),
            'applied' => false,
            'reported' => false,
        ]);

        $application = $user->jobApplications->where('job_id', $this->id)->first();

        if ( $application ){
            $response = collect($response)->merge([
                'status' => $application->status(),
                'applied_at' => $application->created_at->toDateTimeString(),
                'applied' => true,
            ]);
        }

        $reported = $user->reportedJobs->where('job_id', $this->id)->first();

        if ( $reported ){
            $response = collect($response)->merge([
                'reported_at' => $reported->created_at->toDateTimeString(),
                'reported' => true,
            ]);
        }

        return HelperSupport::snake_to_camel($response->toArray());
    }
}
