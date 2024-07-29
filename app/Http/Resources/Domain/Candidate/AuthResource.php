<?php

namespace App\Http\Resources\Domain\Candidate;

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
        ])->toArray();

        $response['profile_picture_url'] = $this->profile_picture_url ? asset("storage/$this->profile_picture_url") : null;

        return HelperSupport::snake_to_camel($response);
    }
}
