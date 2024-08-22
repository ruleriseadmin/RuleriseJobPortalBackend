<?php

namespace App\Http\Controllers\Domain\Employer\Auth;

use Illuminate\Http\JsonResponse;
use App\Supports\ApiReturnResponse;
use App\Http\Controllers\Controller;
use App\Actions\Domain\Shared\Auth\LoginAction;
use App\Http\Resources\Domain\Employer\AuthResource;
use App\Actions\Domain\Employer\ProcessNewEmployerAction;
use App\Http\Requests\Domain\Employer\Auth\RegisterRequest;
use App\Actions\Domain\Shared\Auth\SendEmailVerificationAction;

class RegisterController extends Controller
{
    public function store(RegisterRequest $request): JsonResponse
    {
        $user = (new ProcessNewEmployerAction)->execute($request->input());

        if ( ! $user ) return ApiReturnResponse::failed();

        //auto-login employer user after successful registration
        //$user = (new LoginAction)->autoLoginFromUser($user);

        //send email verification
        (new SendEmailVerificationAction)->execute('employer', $user);

        return $user ? ApiReturnResponse::success(message: 'Please check your email to verify your account') : ApiReturnResponse::failed();
    }
}
