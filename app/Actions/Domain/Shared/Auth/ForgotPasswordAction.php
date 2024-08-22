<?php

namespace App\Actions\Domain\Shared\Auth;

use App\Models\User;
use App\Notifications\Domain\Shared\Auth\ForgotPasswordNotification;
use App\Notifications\Domain\Shared\NotificationWithActionButton;
use Exception;
use Illuminate\Support\Carbon;
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

        $expiredAt = Carbon::now()->addHours(5);

        $randomString = str()->uuid();

        $token = json_encode([
            'email' => $user->email,
            'token' => $randomString,
            'expired_at' => $expiredAt
        ]);

        $token = Crypt::encrypt($token);

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

        $resetPasswordUrl = $this->domain == 'candidate' ? config('env.candidate.reset_password_url') : config('env.employer.reset_password_url');

        try{
            Notification::route('mail', $this->user->email)->notify(new NotificationWithActionButton([
                'subject' => 'Reset Password',
                'name' => $this->user->full_name,
                'messages' => [
                    "You have requested to reset the password to your account on Talent Beyond Borders. Click the button below to get started",
                ],
                'messagesAfterAction' => [
                    "If you did not initiate this request, please ignore this email, or write to xyz@gmail.com so we can look into a possible attempt to breach your account.",
                ],
                'actionText' => 'Reset Password',
                'actionUrl' => "{$resetPasswordUrl}?token={$this->token}",
            ]));
        }catch(Exception $ex){
            Log::error("Error @ ForgotPasswordAction::sendEmail : {$ex->getMessage()}");
        }
    }
}
