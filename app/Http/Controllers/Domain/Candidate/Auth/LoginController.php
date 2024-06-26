<?php

namespace App\Http\Controllers\Domain\Candidate\Auth;

use App\Actions\Domain\Shared\Auth\LoginAction;
use App\Http\Requests\Domain\Candidate\Auth\LoginRequest;
use App\Http\Resources\Domain\Candidate\AuthResource;
use App\Supports\ApiReturnResponse;
use Illuminate\Http\JsonResponse;

class LoginController
{
    public function store(LoginRequest $request): JsonResponse
    {
        $user = (new LoginAction)->execute('web', $request->validated());

        //send response
        return $user ? ApiReturnResponse::success(new AuthResource($user)) : ApiReturnResponse::failed('Wrong email or password');
    }
}
