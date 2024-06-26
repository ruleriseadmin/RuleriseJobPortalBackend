<?php

namespace App\Http\Controllers\Domain\Employer\Auth;

use App\Actions\Domain\Shared\Auth\LoginAction;
use App\Http\Requests\Domain\Employer\Auth\LoginRequest;
use App\Http\Resources\Domain\Employer\AuthResource;
use App\Supports\ApiReturnResponse;
use Illuminate\Http\JsonResponse;

class LoginController
{
    public function store(LoginRequest $request): JsonResponse
    {
        $user = (new LoginAction)->execute('employer', $request->validated());

        //send response
        return $user ? ApiReturnResponse::success(new AuthResource($user)) : ApiReturnResponse::failed('Wrong email or password');
    }
}
