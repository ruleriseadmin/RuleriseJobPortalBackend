<?php

namespace App\Http\Resources\Domain\Admin\UserManagement;

use App\Supports\HelperSupport;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PermissionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return HelperSupport::snake_to_camel(collect(parent::toArray($request))->only(['name'])->toArray());
    }
}
