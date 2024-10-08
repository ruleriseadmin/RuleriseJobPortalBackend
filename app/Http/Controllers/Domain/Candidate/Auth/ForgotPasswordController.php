<?php

namespace App\Http\Controllers\Domain\Candidate\Auth;

use Illuminate\Http\JsonResponse;
use App\Supports\ApiReturnResponse;
use App\Http\Controllers\Controller;
use App\Models\Domain\Candidate\User;
use App\Actions\Domain\Shared\Auth\ResetPasswordAction;
use App\Actions\Domain\Shared\Auth\ForgotPasswordAction;
use App\Actions\Domain\Shared\Auth\VerifyForgotPasswordAction;
use App\Http\Requests\Domain\Candidate\Auth\ResetPasswordRequest;
use App\Http\Requests\Domain\Candidate\Auth\VerifyResetPasswordLinkRequest;

class ForgotPasswordController extends Controller
{
    public function sendResetPasswordLink(string $email): JsonResponse
    {
        //get user
        $user = User::where('email', $email)->first();

        if (! $user ) return ApiReturnResponse::notFound('User not found');

        //call forgot password action
        $sendEmail = (new ForgotPasswordAction)->execute('candidate', $user);

        //return response
        return $sendEmail ? ApiReturnResponse::success() : ApiReturnResponse::failed();
    }

    public function verifyResetPasswordLink(VerifyResetPasswordLinkRequest $request): JsonResponse
    {
        $email = (new VerifyForgotPasswordAction)->execute('candidate', $request->input('token'));

        return $email
            ? ApiReturnResponse::success(['email' => $email])
            : ApiReturnResponse::failed();
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $user = User::whereEmail($request->input('email'));

        return (new ResetPasswordAction)->execute('candidate', $user, $request->input('password'), $request->input('token'))
            ? ApiReturnResponse::success()
            : ApiReturnResponse::failed();
    }
}
