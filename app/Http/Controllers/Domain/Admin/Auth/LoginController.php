<?php

namespace App\Http\Controllers\Domain\Admin\Auth;

use App\Supports\ApiReturnResponse;
use App\Actions\Domain\Shared\Auth\LoginAction;
use App\Http\Resources\Domain\Admin\AuthResource;
use App\Http\Requests\Domain\Admin\Auth\LoginRequest;

class LoginController
{
    public function store(LoginRequest $request)
    {
        $user = (new LoginAction)->execute('admin', $request->validated());

        return $user ? ApiReturnResponse::success(new AuthResource($user)) : ApiReturnResponse::failed('Wrong email or password');
    }
}
