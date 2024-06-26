<?php

namespace App\Http\Controllers\Domain\Employer\Auth;

use App\Actions\Domain\Shared\Auth\ForgotPasswordAction;
use App\Http\Controllers\Controller;
use App\Models\Domain\Employer\EmployerUser;
use App\Supports\ApiReturnResponse;
use Illuminate\Http\JsonResponse;

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
}
