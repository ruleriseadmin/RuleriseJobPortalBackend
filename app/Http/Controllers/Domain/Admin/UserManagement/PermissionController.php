<?php

namespace App\Http\Controllers\Domain\Admin\UserManagement;

use App\Supports\ApiReturnResponse;
use Spatie\Permission\Models\Permission;
use App\Http\Resources\Domain\Admin\UserManagement\PermissionResource;

class PermissionController
{
    public function index()
    {
        $permissions = Permission::where('guard_name', 'admin')->get();

        return ApiReturnResponse::success(PermissionResource::collection($permissions));
    }
}
