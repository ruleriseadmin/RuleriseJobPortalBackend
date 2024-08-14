<?php

namespace App\Http\Resources\Domain\Employer;

use Illuminate\Http\Request;
use App\Supports\HelperSupport;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $response['companyInformation'] = HelperSupport::snake_to_camel(collect(parent::toArray($request))->except([
            'created_at',
            'updated_at',
            'deleted_at',
            'id',
            'logo_url',
        ])->toArray());

        $response['companyInformation']['logoUrl'] = $this->logo_url ? asset("storage/$this->logo_url") : null;

        $user = auth()->user();

        $accountAccess = $user->employerAccess()->first();

        $response = collect($response)->merge([
            'account_information' => [
                'email' => $user->email,
                'firstName' => $accountAccess->first_name,
                'lastName' => $accountAccess->last_name,
                'positionTitle' => $accountAccess->position_title,
                'profilePicture' => $user->profile_picture_url ? asset("storage/$user->profile_picture_url") : null,
            ],
        ])->toArray();

        return HelperSupport::snake_to_camel($response);
    }
}
