<?php

namespace App\Http\Resources\Domain\Candidate;

use App\Http\Resources\Domain\Candidate\Data\CredentialResource;
use App\Http\Resources\Domain\Candidate\Data\EducationHistoryResource;
use App\Http\Resources\Domain\Candidate\Data\LanguageResource;
use App\Http\Resources\Domain\Candidate\Data\PortfolioResource;
use App\Http\Resources\Domain\Candidate\Data\QualificationResource;
use App\Http\Resources\Domain\Candidate\Data\WorkExperienceResource;
use App\Supports\HelperSupport;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $response = collect(parent::toArray($request))->except([
            'created_at',
            'updated_at',
            'deleted_at',
            'id',
        ]);

        $response = $response->merge([
            'qualification' => (new QualificationResource($this->qualification)),
            'workExperience' => WorkExperienceResource::collection($this->workExperiences),
            'educationHistory' => EducationHistoryResource::collection($this->educationHistories),
            'credentials' => CredentialResource::collection($this->credentials),
            'portfolio' => (new PortfolioResource($this->portfolio)),
            'language' => LanguageResource::collection($this->languages),
        ])->toArray();

        return HelperSupport::snake_to_camel($response);
    }
}
