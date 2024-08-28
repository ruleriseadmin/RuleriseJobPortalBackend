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
            'only_account',
            'email_verified_token',
            'email_verified_at',
        ])->toArray();

        //$response['email_verified_at'] = $this->email_verified_at->toDateTimeString();

        if ( auth()->check() ){
            $response['email_verified'] = $this->hasVerifiedEmail();
        }

        $response['profile_picture_url'] = $this->profile_picture_url ? asset("/$this->profile_picture_url") : null;

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
