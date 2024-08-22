<?php

namespace App\Actions\Domain\Shared\Auth;

use Exception;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Notification;
use App\Notifications\Domain\Shared\NotificationWithActionButton;

class SendEmailVerificationAction
{
    public function execute(string $domain, User $user)
    {
        $expiredAt = Carbon::now()->addHours(1);

        $randomString = str()->uuid();

        $token = json_encode([
            'email' => $user->email,
            'token' => $randomString,
            'expired_at' => $expiredAt
        ]);

        $token = Crypt::encrypt($token);

        $user->update([
            'email_verified_token' => $token,
        ]);

        $url = $domain == 'candidate' ? config('env.candidate.verify_email_url') : config('env.employer.verify_email_url');

        try{
            Notification::route('mail', $user->email)->notify(new NotificationWithActionButton([
                'subject' => 'Email Verification',
                'greeting' => "Hello {$user->full_name}! \n Welcome to Talent Beyond Border",
                'messages' => [
                    'Click the button below to get started.',
                ],
                'messagesAfterAction' => [
                    'If you did not initiate this request, please ignore this email, or write to xyz@gmail.com so we can look into a possible attempt to breach your account.',
                ],
                'actionText' => 'Verify email',
                'actionUrl' => "{$url}?token={$token}",
            ]));
        }catch(Exception $ex){
            Log::error("Error sending email @ SendEmailVerificationAction: " . $ex->getMessage());
        }
    }
}
