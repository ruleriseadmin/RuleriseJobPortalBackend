<?php

namespace App\Http\Resources\Domain\Employer\User;

use App\Supports\HelperSupport;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        // $response = collect(parent::toArray($request))->only([
        //     'first_name',
        //     'last_name',
        //     'email',
        //     'uuid',
        // ]);

        // $response = $response->merge([
        //     'createdAt' => $this->created_at->toDateTimeString(),
        //     'role' => str_replace('_', ' ', $this->employerAccess->roles->pluck('name')->first()),
        // ]);

        return parent::toArray($request);

        return [
            // 'uuid' => $this->employerAccess->uuid,
            // 'firstName' => $this->employerAccess->first_name,
            // 'email' => $this->email,
            // 'lastName' => $this->employerAccess->last_name,
        ];
    }
}
