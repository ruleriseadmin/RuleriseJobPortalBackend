<?php

namespace App\Http\Resources\Domain\Admin\UserManagement;

use App\Supports\HelperSupport;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $response = collect(parent::toArray($request))->only([
            'first_name',
            'last_name',
            'email',
            'uuid',
        ]);

        $response = $response->merge([
            'createdAt' => $this->created_at->toDateTimeString(),
            'role' => str_replace('_', ' ', $this->roles->pluck('name')->first()),
        ]);

        return HelperSupport::snake_to_camel($response->toArray());
    }
}
