<?php

namespace App\Http\Controllers\Domain\Admin\UserManagement;
use App\Actions\Domain\Admin\UserManagement\Role\CreateRoleAction;
use Spatie\Permission\Models\Role;
use App\Supports\ApiReturnResponse;
use App\Http\Controllers\Domain\Admin\BaseController;
use App\Actions\Domain\Admin\UserManagement\Role\DeleteRoleAction;
use App\Actions\Domain\Admin\UserManagement\Role\UpdateRoleAction;
use App\Http\Requests\Domain\Admin\UserManagement\Role\StoreRoleRequest;
use App\Http\Requests\Domain\Admin\UserManagement\Role\UpdateRoleRequest;
use App\Http\Resources\Domain\Admin\UserManagement\RoleResource;

class Rolescontroller extends BaseController
{
    public function index()
    {
        $roles = Role::where('guard_name', 'admin')->where('name', '!=', 'super_admin')->get();

        return ApiReturnResponse::success(RoleResource::collection($roles));
    }

    public function store(StoreRoleRequest $request)
    {
        return (new CreateRoleAction)->execute($request->input('roleName'), $request->input('permissions'))
            ? ApiReturnResponse::success()
            : ApiReturnResponse::failed();
    }

    public function show(string $roleName)
    {
        $role = Role::where('name', $roleName)->first();

        return $role
            ? ApiReturnResponse::success(new RoleResource($role))
            : ApiReturnResponse::notFound('Role does not exists');
    }

    public function update(UpdateRoleRequest $request)
    {
        $role = Role::where('name', $request->input('slug'))->first();

        return (new UpdateRoleAction)->execute($role, $request->input('newRoleName'), $request->input('permissions'))
            ? ApiReturnResponse::success()
            : ApiReturnResponse::failed();
    }

    public function delete(string $roleName)
    {
        $role = Role::where('name', $roleName)->first();

        if ( ! $role ) return ApiReturnResponse::notFound('Role does not exists');

        return (new DeleteRoleAction)->execute($role)
            ? ApiReturnResponse::success()
            : ApiReturnResponse::failed();
    }
}
