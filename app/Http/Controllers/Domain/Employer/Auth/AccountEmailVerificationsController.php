<?php

namespace App\Http\Controllers\Domain\Employer\Auth;

use App\Actions\Domain\Shared\Auth\VerifyEmailAction;
use App\Supports\ApiReturnResponse;
use App\Models\Domain\Employer\EmployerUser;
use App\Http\Requests\Domain\Employer\Auth\VerifyEmailRequest;
use App\Actions\Domain\Shared\Auth\SendEmailVerificationAction;

class AccountEmailVerificationsController
{
    public function resendEmailVerification(string $email)
    {
        $user = EmployerUser::whereEmail($email);

        if ( ! $user ) return ApiReturnResponse::notFound('User not found');

        if ( $user->email_verified_at ) return ApiReturnResponse::failed(message: 'Email already verified');

        (new SendEmailVerificationAction)->execute('employer', $user);

        return ApiReturnResponse::success(message: 'Please check your email to verify your account');
    }

    public function verifyEmail(VerifyEmailRequest $request)
    {
        return (new VerifyEmailAction)->execute('employer', $request->input('token'))
            ? ApiReturnResponse::success()
            : ApiReturnResponse::failed();
    }
}
