<?php

namespace App\Http\Controllers\Domain\Candidate\Auth;

use App\Actions\Domain\Candidate\CreateCandidateAction;
use App\Http\Controllers\Controller;
use App\Actions\Domain\Shared\Auth\LoginAction;
use App\Http\Requests\Domain\Candidate\Auth\RegisterRequest;
use App\Http\Resources\Domain\Candidate\AuthResource;
use App\Supports\ApiReturnResponse;
use Illuminate\Http\JsonResponse;

class RegisterController extends Controller
{
    public function store(RegisterRequest $request): JsonResponse
    {
        $user = (new CreateCandidateAction)->execute($request->input());

        if ( ! $user ) return ApiReturnResponse::failed();

        //auto-login candidate user after successful registration
        $user = (new LoginAction)->autoLoginFromUser($user);

        return $user ? ApiReturnResponse::success(new AuthResource($user)) : ApiReturnResponse::failed();
    }
}
