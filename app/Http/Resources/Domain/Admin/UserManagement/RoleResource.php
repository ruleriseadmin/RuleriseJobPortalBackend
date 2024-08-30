<?php

namespace App\Http\Resources\Domain\Admin\UserManagement;

use App\Supports\HelperSupport;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Nette\Schema\Helpers;

class RoleResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $response = collect(parent::toArray($request))->only([
            'name',
        ]);

        $response['createdAt'] = $this->created_at->toDateTimeString();

        return [
            'name' => str_replace('_', ' ', $this->name),
            'slug' => $this->name,
            'createdAt' => $this->created_at->toDateTimeString(),
        ];
    }
}
