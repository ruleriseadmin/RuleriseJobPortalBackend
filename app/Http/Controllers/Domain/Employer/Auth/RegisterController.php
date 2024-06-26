<?php

namespace App\Http\Controllers\Domain\Employer\Auth;

use App\Actions\Domain\Employer\ProcessNewEmployerAction;
use App\Actions\Domain\Shared\Auth\LoginAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Domain\Employer\Auth\RegisterRequest;
use App\Http\Resources\Domain\Employer\AuthResource;
use App\Supports\ApiReturnResponse;
use Illuminate\Http\JsonResponse;

class RegisterController extends Controller
{
    public function store(RegisterRequest $request): JsonResponse
    {
        $user = (new ProcessNewEmployerAction)->execute($request->input());

        if ( ! $user ) return ApiReturnResponse::failed();

        //auto-login employer user after successful registration
        $user = (new LoginAction)->autoLoginFromUser($user);

        return $user ? ApiReturnResponse::success(new AuthResource($user)) : ApiReturnResponse::failed();
    }
}
