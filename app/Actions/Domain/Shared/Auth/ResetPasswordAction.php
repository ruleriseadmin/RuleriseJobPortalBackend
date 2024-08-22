<?php

namespace App\Actions\Domain\Shared\Auth;

use Exception;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

class ResetPasswordAction
{
    public function execute(string $domain, User $user, string $password, string $token): bool
    {
        if ( ! (new VerifyForgotPasswordAction)->execute($domain, $token) ) return false;

        DB::beginTransaction();
        try{
            $user->update(['password' => Hash::make($password)]);
            DB::table('password_reset_tokens')->where('email', $user->email)->delete();
            DB::commit();
            return true;
        }catch(Exception $ex){
            DB::rollBack();
            Log::error("Error @ ResetPasswordAction::execute : {$ex->getMessage()}");
            return false;
        }
    }
}
