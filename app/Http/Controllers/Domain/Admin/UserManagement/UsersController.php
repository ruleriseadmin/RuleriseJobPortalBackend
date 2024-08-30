<?php

namespace App\Http\Controllers\Domain\Admin\UserManagement;
use App\Http\Resources\Domain\Admin\UserManagement\UserFilterResource;
use App\Http\Resources\Domain\Admin\UserManagement\UserResource;
use App\Supports\ApiReturnResponse;
use App\Models\Domain\Admin\AdminUser;
use App\Http\Controllers\Domain\Admin\BaseController;
use App\Actions\Domain\Admin\UserManagement\User\CreateUserAction;
use App\Actions\Domain\Admin\UserManagement\User\DeleteUserAction;
use App\Actions\Domain\Admin\UserManagement\User\UpdateUserAction;
use App\Http\Requests\Domain\Admin\UserManagement\User\StoreUserRequest;
use App\Http\Requests\Domain\Admin\UserManagement\User\UpdateUserRequest;

class UsersController extends BaseController
{
    public function index()
    {
        return ApiReturnResponse::success(new UserFilterResource([]));
    }

    public function store(StoreUserRequest $request)
    {
        return (new CreateUserAction)->execute($request->input())
            ? ApiReturnResponse::success()
            : ApiReturnResponse::failed();
    }

    public function show(string $uuid)
    {
        $user = AdminUser::whereUuid($uuid);

        return $user
            ? ApiReturnResponse::success(new UserResource($user))
            : ApiReturnResponse::notFound('User does not exists');
    }

    public function update(UpdateUserRequest $request)
    {
        $user = AdminUser::whereUuid($request->input('userId'));

        return (new UpdateUserAction)->execute($user, $request->input())
            ? ApiReturnResponse::success()
            : ApiReturnResponse::failed();
    }

    public function delete(string $uuid)
    {
        $user = AdminUser::whereUuid($uuid);

        if ( ! $user ) ApiReturnResponse::notFound('User does not exists');

        return (new DeleteUserAction)->execute($user)
            ? ApiReturnResponse::success()
            : ApiReturnResponse::failed();
    }
}
