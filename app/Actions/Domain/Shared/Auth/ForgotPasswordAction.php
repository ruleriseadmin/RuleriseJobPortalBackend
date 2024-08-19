<?php

namespace App\Actions\Domain\Shared\Auth;

use App\Models\User;
use App\Notifications\Domain\Shared\Auth\ForgotPasswordNotification;
use App\Notifications\Domain\Shared\NotificationWithActionButton;
use Exception;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class ForgotPasswordAction
{
    protected User $user;

    protected string $token;

    protected string $domain;

    public function execute(string $domain, User $user) : bool
    {
        $this->user = $user;

        $token = Crypt::encrypt($domain);//str()->random(60);

        $this->domain = $domain;

        $this->token = $token;

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
        try{
            Notification::route('mail', $this->user->email)->notify(new NotificationWithActionButton([
                'subject' => 'Reset Password',
                'name' => $this->user->full_name,
                'messages' => [
                    "You've requested for a password change, kindly click the button below to reset your password.",
                    "If you didn't request for a password change, kindly ignore this email.",
                ],
                'actionText' => 'Reset Password',
                'actionUrl' => "{$this->domain}/reset-password?token={$this->token}",
            ]));
        }catch(Exception $ex){
            Log::error("Error @ ForgotPasswordAction::sendEmail : {$ex->getMessage()}");
        }
    }
}
