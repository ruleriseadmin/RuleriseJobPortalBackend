<?php

namespace App\Http\Resources\Domain\Employer;

use App\Supports\HelperSupport;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $response = collect(parent::toArray($request))->except([
            'created_at',
            'updated_at',
            'deleted_at',
            'id',
            'email_verified_token',
            'email_verified_at',
        ]);

        $response['email_verified'] = $this->hasVerifiedEmail();

        $response['profile_picture_url'] = $this->profile_picture_url ? asset("storage/$this->profile_picture_url") : null;

        $response = $response
            ->merge(collect($this->employers->first()->pivot)->except(['employer_user_id', 'employer_id']))
            // ->merge([
            //     'employer' => (new EmployerResource($this->employers->first())),
            // ])
            ->toArray();

        return HelperSupport::snake_to_camel($response);
    }
}
