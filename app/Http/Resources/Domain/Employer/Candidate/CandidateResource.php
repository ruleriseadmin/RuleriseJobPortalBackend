<?php

namespace App\Http\Resources\Domain\Employer\Candidate;

use Illuminate\Http\Request;
use App\Supports\HelperSupport;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Domain\Candidate\Data\LanguageResource;
use App\Http\Resources\Domain\Candidate\Data\PortfolioResource;
use App\Http\Resources\Domain\Candidate\Data\CredentialResource;
use App\Http\Resources\Domain\Candidate\Data\QualificationResource;
use App\Http\Resources\Domain\Candidate\Data\WorkExperienceResource;
use App\Http\Resources\Domain\Candidate\Data\EducationHistoryResource;

class CandidateResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $response = collect(parent::toArray($request))->except([
            'created_at',
            'updated_at',
            'deleted_at',
            'id',
            'only_account',
        ])->toArray();

        $response['profile_picture_url'] = asset($this->profile_picture_url);

        if ( ! ($this->only_account ?? false) ){
            $response = collect($response)->merge([
                'qualification' => (new QualificationResource($this->qualification)),
                'workExperience' => WorkExperienceResource::collection($this->workExperiences),
                'educationHistory' => EducationHistoryResource::collection($this->educationHistories),
                'credentials' => CredentialResource::collection($this->credentials),
                'portfolio' => (new PortfolioResource($this->portfolio)),
                'language' => LanguageResource::collection($this->languages),
            ])->toArray();
        }

        return HelperSupport::snake_to_camel($response);
    }
}
