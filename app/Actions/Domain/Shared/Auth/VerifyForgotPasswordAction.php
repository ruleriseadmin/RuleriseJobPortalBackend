<?php

namespace App\Actions\Domain\Shared\Auth;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class VerifyForgotPasswordAction
{
    public function execute(string $domain, string $token): ?string
    {
        $password = DB::table('password_reset_tokens')->where('token', $token)->first();

        if ( ! $password ) return false;

        $decodeToken = Crypt::decrypt($token);

        $decodeToken = (object) json_decode($decodeToken);

        if ( Carbon::now()->greaterThan($decodeToken->expired_at) ) return null;

        return $password->email;
    }
}
