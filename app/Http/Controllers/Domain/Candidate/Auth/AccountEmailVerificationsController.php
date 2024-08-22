<?php

namespace App\Http\Controllers\Domain\Candidate\Auth;

use App\Actions\Domain\Shared\Auth\VerifyEmailAction;
use App\Supports\ApiReturnResponse;
use App\Http\Requests\Domain\Employer\Auth\VerifyEmailRequest;
use App\Actions\Domain\Shared\Auth\SendEmailVerificationAction;
use App\Models\Domain\Candidate\User;

class AccountEmailVerificationsController
{
    public function resendEmailVerification(string $email)
    {
        $user = User::whereEmail($email);

        if ( ! $user ) return ApiReturnResponse::notFound('User not found');

        if ( $user->email_verified_at ) return ApiReturnResponse::failed(message: 'Email already verified');

        (new SendEmailVerificationAction)->execute('candidate', $user);

        return ApiReturnResponse::success(message: 'Please check your email to verify your account');
    }

    public function verifyEmail(VerifyEmailRequest $request)
    {
        return (new VerifyEmailAction)->execute('candidate', $request->input('token'))
            ? ApiReturnResponse::success()
            : ApiReturnResponse::failed();
    }
}
