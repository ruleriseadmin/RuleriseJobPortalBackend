<?php

namespace App\Http\Resources\Domain\Admin\UserManagement;

use App\Models\Domain\Admin\AdminUser;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserFilterResource extends JsonResource
{
    private int $perPage = 10;

    public function toArray(Request $request): array
    {
        $paginatedUsers = $this->allUsers();

        return [
            'totalUsers' => AdminUser::count(),
            'users' => $this->returnResponse($paginatedUsers),
        ];
    }

    private function allUsers()
    {
        return AdminUser::paginate($this->perPage);
    }

    private function returnResponse($paginatedUsers)
    {
        return [
            'items' => UserResource::collection($paginatedUsers->items()),
            'page' => $paginatedUsers->currentPage(),
            'nextPage' =>  $paginatedUsers->currentPage() + ($paginatedUsers->hasMorePages() ? 1 : 0),
            'hasMorePages' => $paginatedUsers->hasMorePages(),
            'totalPages' => (int) ceil( $paginatedUsers->total() / $this->perPage),
        ];
    }
}
