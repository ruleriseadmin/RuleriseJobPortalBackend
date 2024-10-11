<?php

namespace App\Http\Controllers\Domain\Employer\Users;

use App\Supports\ApiReturnResponse;
use App\Models\Domain\Employer\EmployerUser;
use App\Actions\Domain\Employer\User\CreateUserAction;
use App\Actions\Domain\Employer\User\DeleteUserAction;
use App\Actions\Domain\Employer\User\UpdateUserAction;
use App\Http\Controllers\Domain\Employer\BaseController;
use App\Http\Resources\Domain\Employer\User\UserResource;
use App\Http\Requests\Domain\Employer\User\StoreUserRequest;
use App\Http\Requests\Domain\Employer\User\UpdateUserRequest;
use App\Http\Resources\Domain\Employer\User\UserFilterResource;
use App\Models\Domain\Employer\EmployerAccess;

class UsersController extends BaseController
{
    public function index()
    {
        return ApiReturnResponse::success(new UserFilterResource($this->employer));
    }

    public function store(StoreUserRequest $request)
    {
        return (new CreateUserAction)->execute($this->employer, $request->input())
            ? ApiReturnResponse::success()
            : ApiReturnResponse::failed();
    }

    public function show(string $uuid)
    {
        $user = EmployerAccess::whereUuid($uuid);

        return $user
            ? ApiReturnResponse::success(new UserResource($user))
            : ApiReturnResponse::notFound('User does not exists');
    }

    public function update(UpdateUserRequest $request)
    {
        $user = EmployerAccess::whereUuid($request->input('userId'));

        return (new UpdateUserAction)->execute($this->employer, $user, $request->input())
            ? ApiReturnResponse::success()
            : ApiReturnResponse::failed();
    }

    public function delete(string $uuid)
    {
        $user = EmployerUser::whereUuid($uuid);

        if ( ! $user ) ApiReturnResponse::notFound('User does not exists');

        return (new DeleteUserAction)->execute($this->employer, $user)
            ? ApiReturnResponse::success()
            : ApiReturnResponse::failed();
    }
}
