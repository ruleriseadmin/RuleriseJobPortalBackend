<?php

namespace App\Http\Resources\Domain\Employer\User;

use App\Traits\Domain\Shared\PaginationTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserFilterResource extends JsonResource
{
    private int $perPage = 10;

    use PaginationTrait;

    public function toArray(Request $request): array
    {
        //$paginatedUsers = $this->allUsers();

        return [
            'totalUsers' => $this->users->count(),
            'users' => $this->paginateFromCollection(UserResource::collection($this->users), $this->perPage),
        ];
    }
}
