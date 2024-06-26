<?php

namespace App\Http\Controllers\Domain\Candidate\Auth;

use App\Actions\Domain\Shared\Auth\ForgotPasswordAction;
use App\Http\Controllers\Controller;
use App\Models\Domain\Candidate\User;
use App\Supports\ApiReturnResponse;
use Illuminate\Http\JsonResponse;

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
}
