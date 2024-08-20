<?php

namespace App\Http\Controllers\Domain\Employer\Auth;

use Illuminate\Http\JsonResponse;
use App\Supports\ApiReturnResponse;
use App\Http\Controllers\Controller;
use App\Models\Domain\Employer\EmployerUser;
use App\Actions\Domain\Shared\Auth\ResetPasswordAction;
use App\Actions\Domain\Shared\Auth\ForgotPasswordAction;
use App\Actions\Domain\Shared\Auth\VerifyForgotPasswordAction;
use App\Http\Requests\Domain\Employer\Auth\ResetPasswordRequest;
use App\Http\Requests\Domain\Employer\Auth\VerifyResetPasswordLinkRequest;

class ForgotPasswordController extends Controller
{
    public function sendResetPasswordLink(string $email): JsonResponse
    {
        //get user
        $user = EmployerUser::where('email', $email)->first();

        if (! $user ) return ApiReturnResponse::notFound('User not found');

        //call forgot password action
        $sendEmail = (new ForgotPasswordAction)->execute('employer', $user);

        //return response
        return $sendEmail ? ApiReturnResponse::success() : ApiReturnResponse::failed();
    }

    public function verifyResetPasswordLink(VerifyResetPasswordLinkRequest $request): JsonResponse
    {
        $email = (new VerifyForgotPasswordAction)->execute('employer', $request->input('token'));
        
        return $email
            ? ApiReturnResponse::success(['email' => $email])
            : ApiReturnResponse::failed();
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $user = EmployerUser::whereEmail($request->input('email'));

        return (new ResetPasswordAction)->execute('employer', $user, $request->input('password'), $request->input('token'))
            ? ApiReturnResponse::success()
            : ApiReturnResponse::failed();
    }
}
