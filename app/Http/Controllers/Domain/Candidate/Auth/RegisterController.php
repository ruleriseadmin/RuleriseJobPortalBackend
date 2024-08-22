<?php

namespace App\Http\Controllers\Domain\Candidate\Auth;

use Illuminate\Http\JsonResponse;
use App\Supports\ApiReturnResponse;
use App\Http\Controllers\Controller;
use App\Actions\Domain\Shared\Auth\LoginAction;
use App\Http\Resources\Domain\Candidate\AuthResource;
use App\Actions\Domain\Candidate\CreateCandidateAction;
use App\Http\Requests\Domain\Candidate\Auth\RegisterRequest;
use App\Actions\Domain\Shared\Auth\SendEmailVerificationAction;

class RegisterController extends Controller
{
    public function store(RegisterRequest $request): JsonResponse
    {
        $user = (new CreateCandidateAction)->execute($request->input());

        if ( ! $user ) return ApiReturnResponse::failed();

        //auto-login candidate user after successful registration
        //$user = (new LoginAction)->autoLoginFromUser($user);

        //send email verification
        (new SendEmailVerificationAction)->execute('candidate', $user);

        return $user ? ApiReturnResponse::success(message: 'Please check your email to verify your account') : ApiReturnResponse::failed();
    }
}
