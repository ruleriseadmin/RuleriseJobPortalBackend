<?php

namespace App\Actions\Domain\Shared\Auth;

use App\Models\User;
use App\Notifications\Domain\Shared\Auth\ForgotPasswordNotification;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class ForgotPasswordAction
{
    protected User $user;

    protected string $token;

    public function execute(string $domain, User $user) : bool
    {
        $this->user = $user;

        $token = str()->random(60);

        DB::beginTransaction();
        try{
            DB::table('password_reset_tokens')->where('email', $user->email)->delete();

            DB::table('password_reset_tokens')->insert([
                'email' => $user->email,
                'token' => $token,
            ]);
            DB::commit();
        }catch(Exception $ex){
            DB::rollBack();
            Log::error("Error @ ForgotPasswordAction::execute : {$ex->getMessage()}");
            return false;
        }

        $this->sendEmail();

        return true;
    }

    public function sendEmail()
    {
        //@todo sending notification
       // Notification::send($this->user, (new ForgotPasswordNotification()));//->delay();
    }
}
