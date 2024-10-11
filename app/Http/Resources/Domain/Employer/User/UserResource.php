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

        return [
            'uuid' => $this->pivot->uuid,
            'firstName' => $this->pivot->first_name,
            'email' => $this->email,
            'lastName' => $this->pivot->last_name,
            'createdAt' => $this->pivot->created_at->toDateTimeString(),
        ];
    }
}
