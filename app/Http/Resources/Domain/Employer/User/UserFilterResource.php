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

        $users = $this->users->filter(fn($user) => ! $user->pivot->deleted_at);

        return [
            'totalUsers' => $users->count(),
            'users' => $this->paginateFromCollection(UserResource::collection($users), $this->perPage),
        ];
    }
}
