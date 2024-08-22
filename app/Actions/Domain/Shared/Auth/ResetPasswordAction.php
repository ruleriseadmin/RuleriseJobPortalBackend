<?php

namespace App\Actions\Domain\Shared\Auth;

use App\Notifications\Domain\Shared\NotificationWithActionButton;
use Exception;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;

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
        }catch(Exception $ex){
            DB::rollBack();
            Log::error("Error @ ResetPasswordAction::execute : {$ex->getMessage()}");
            return false;
        }

        $this->sendEmail($domain, $user);

        return true;
    }

    private function sendEmail(string $domain, User $user)
    {
        try{
            Notification::route('mail', $user->email)->notify(new NotificationWithActionButton([
                'subject' => 'Your password has been reset',
                'greeting' => "Hello {$user->full_name}!",
                'messages' => [
                    'Your password has been reset.',
                    'Click the button below to login.',
                ],
                'actionText' => 'Login',
                'actionUrl' => $domain == 'candidate' ? config('env.candidate.login_url') : config('env.employer.login_url'),
            ]));
        }catch(Exception $ex){
            Log::error("Error @ ResetPasswordAction::sendEmail : {$ex->getMessage()}");
        }
    }
}
