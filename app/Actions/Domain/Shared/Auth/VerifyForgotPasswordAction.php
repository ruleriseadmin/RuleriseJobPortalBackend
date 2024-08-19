<?php

namespace App\Actions\Domain\Shared\Auth;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class VerifyForgotPasswordAction
{
    public function execute(string $domain, string $email, string $token): bool
    {
        $password = DB::table('password_reset_tokens')->where('email', $email)->where('token', $token)->first();

        if ( ! $password ) return false;

        $decodeToken = Crypt::decrypt($token);

        return Carbon::now()->lessThan($decodeToken);
    }
}
