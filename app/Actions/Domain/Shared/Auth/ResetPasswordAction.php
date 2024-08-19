<?php

namespace App\Actions\Domain\Shared\Auth;

use Exception;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

class ResetPasswordAction
{
    public function execute(string $domain, User $user, string $password, string $token): bool
    {
        if ( ! (new VerifyForgotPasswordAction)->execute($domain, $user->email, $token) ) return false;

        try{
            $user->update(['password' => Hash::make($password)]);
            return true;
        }catch(Exception $ex){
            Log::error("Error @ ResetPasswordAction::execute : {$ex->getMessage()}");
            return false;
        }
    }
}
